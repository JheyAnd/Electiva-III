<?php
include("../db/conexion.php");

//Iniciar la sesión y verificar si el usuario está logueado
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
// Variables de paginación
$limit = 5; // Número de proveedores por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta de proveedores con paginación y búsqueda
$sql = "SELECT * FROM proveedores WHERE nombre_empresa LIKE ? ORDER BY id LIMIT ?, ?";
$stmt = $conexion->prepare($sql);
$searchParam = "%$search%";
$stmt->bind_param("sii", $searchParam, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Total de proveedores para paginación
$totalSql = "SELECT COUNT(*) FROM proveedores WHERE nombre_empresa LIKE ?";
$totalStmt = $conexion->prepare($totalSql);
$totalStmt->bind_param("s", $searchParam);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalProveedores = $totalResult->fetch_row()[0];
$totalPages = ceil($totalProveedores / $limit);

// Lógica para agregar/editar/eliminar proveedor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
$nombre_contacto = $_POST['nombre_contacto']; // Nuevo campo
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];

    // Al editar el proveedor
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = (int)$_POST['id'];
    $updateSql = "UPDATE proveedores SET nombre_empresa = ?, nombre_contacto = ?, direccion = ?, telefono = ?, fecha_actualizacion = NOW() WHERE id = ?";
    $updateStmt = $conexion->prepare($updateSql);
    $updateStmt->bind_param("ssssi", $nombre, $nombre_contacto, $direccion, $telefono, $id);
        if ($updateStmt->execute()) {
            header("Location: proveedores.php"); // Redirige para evitar reenvío de formulario
            exit;
        } else {
            echo "Error al editar el proveedor: " . $conexion->error;
        }
    } else {
        // Al agregar nuevo proveedor
        $insertSql = "INSERT INTO proveedores (nombre_empresa, nombre_contacto, direccion, telefono, fecha_creacion) VALUES (?, ?, ?, ?, NOW())";
        $insertStmt = $conexion->prepare($insertSql);
        $insertStmt->bind_param("ssss", $nombre, $nombre_contacto, $direccion, $telefono);
        if ($insertStmt->execute()) {
            header("Location: proveedores.php"); // Redirige para evitar reenvío de formulario
            exit;
        } else {
            echo "Error al agregar el proveedor: " . $conexion->error;
        }
    }
}

// Eliminar proveedor
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $deleteSql = "DELETE FROM proveedores WHERE id = ?";
    $deleteStmt = $conexion->prepare($deleteSql);
    $deleteStmt->bind_param("i", $id);
    if ($deleteStmt->execute()) {
        header("Location: proveedores.php"); // Redirige para evitar reenvío de formulario
        exit;
    } else {
        echo "Error al eliminar el proveedor: " . $conexion->error;
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores - Sistema de Inventario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

/* Estilos generales */
body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f2f5;
    color: #333;
    
}
.container {
    display: flex;
    min-height: 100vh;
}

/* Barra lateral */
.sidebar {
    width: 280px;
    background-color: #2c3e50;
    color: white;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    padding-top: 2rem;
    transition: all 0.3s ease;
    overflow-y: auto;
}

.sidebar h1 {
    color: white;
    font-size: 1.5rem;
    font-weight: 600;
    padding: 0 1.5rem 2rem;
    margin: 0;
    text-align: center;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar ul li {
    margin: 0.5rem 0;
}

.sidebar ul li a {
    color: #94a3b8;
    text-decoration: none;
    padding: 0.875rem 1.5rem;
    display: block;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}

.sidebar ul li a:hover,
.sidebar ul li a.active {
    color: white;
    background-color: rgba(255, 255, 255, 0.1);
    border-left-color: #60a5fa;
}
/* Estilos de la barra de desplazamiento para navegadores WebKit (Chrome, Safari) */
.sidebar::-webkit-scrollbar {
    width: 8px; /* Ancho de la barra de desplazamiento */
}

.sidebar::-webkit-scrollbar-track {
    background: #34495e; /* Color de fondo del track */
}

.sidebar::-webkit-scrollbar-thumb {
    background: #60a5fa; /* Color de la barra de desplazamiento */
    border-radius: 50%; /* Bordes redondeados */
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: #007bff; /* Color cuando se pasa el mouse */
}

/* Estilos de la barra de desplazamiento para Firefox */
.sidebar {
    scrollbar-width: thin; /* Ancho de la barra de desplazamiento */
    scrollbar-color: #60a5fa #34495e; /* Color de la barra y el track */
}

/* Estilos para navegadores que no soportan barra de desplazamiento personalizada */
.sidebar {
    overflow-y: auto; /* Permitir desplazamiento vertical */
}

/* Contenido principal */
.main-content {
    flex-grow: 1;
    padding: 20px;
    margin-left: 280px;
    max-width: calc(100% - 280px);
}

/* Ajustes para pantallas pequeñas */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
        padding: 10px;
    }
    .products-table {
        display: block;
        overflow-x: auto;
        width: 100%;
    }
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding-top: 1rem;
    }
}

/* Estilo para el menú desplegable */
.dropdown {
    display: none;
    list-style: none;
    padding-left: 20px;
    margin: auto;
}
.dropdown {
    display: none;
}
.dropdown.show {
    display: block;
}
.dropdown li a:hover {
    background-color: #34495e;
}



/* Dashboard */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}
.card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    opacity: 0;
    transform: translateY(20px);
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
.card h3 {
    margin-top: 0;
}
.card-content {
    height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.big-number {
    font-size: 3.5em;
    font-weight: bold;
    margin: 0;
    color: #2c3e50;
}

/* Tablas (productos, categorías y proveedores) */
.products-table, .categories-table, .suppliers-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.products-table th, .products-table td,
.categories-table th, .categories-table td,
.suppliers-table th, .suppliers-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
.products-table th, .categories-table th, .suppliers-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}
.products-table tr, .categories-table tr, .suppliers-table tr {
    transition: background-color 0.3s ease;
}
.products-table tr:hover, .categories-table tr:hover, .suppliers-table tr:hover {
    background-color: #f5f5f5;
}
.product-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}

/* Formularios de búsqueda */
.search-form {
    margin-bottom: 20px;
    display: flex;
    gap: 10px;
}
.search-form input[type="text"] {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: 'Montserrat', sans-serif;
}
.search-form button, .add-product-btn, .add-category-btn, .add-supplier-btn {
    padding: 10px 20px;
    background-color: #2c3e50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-family: 'Montserrat', sans-serif;
    font-weight: bold;
}
.search-form button:hover, .add-product-btn:hover, .add-category-btn:hover, .add-supplier-btn:hover {
    background-color: #34495e;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
    animation: fadeIn 0.3s;
    justify-content: center;
    align-items: center;
}
.modal-content {
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 8px;
    animation: slideDown 0.3s;
    max-height: 90vh;
    overflow-y: auto;
}
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}
.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}

/* Formularios (productos, categorías y proveedores) */
.product-form, .category-form, .supplier-form {
    display: grid;
    gap: 15px;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
}
.form-group input, .form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: 'Montserrat', sans-serif;
}
.form-group button {
    padding: 10px 20px;
    background-color: #2c3e50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-family: 'Montserrat', sans-serif;
    font-weight: bold;
}
.form-group button:hover {
    background-color: #34495e;
}

/* Botones de acción */
.btn {
    padding: 6px 12px;
    font-size: 14px;
    
    font-weight: bold;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 2px;
}
.btn-edit {
    background-color: #4CAF50;
}
.btn-edit:hover {
    background-color: #45a049;
}
.btn-delete {
    background-color: #f44336;
}
.btn-delete:hover {
    background-color: #d32f2f;
}
/* Botones de acción (editar y eliminar) en línea */
.categories-table td .btn {
    display: inline-block;
    margin-right: 5px;
}

/* Paginación */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    gap: 5px;
    list-style-type: none; /* Elimina los puntos de la lista */
    padding: 0; /* Elimina el padding predeterminado */
}
.pagination a {
    padding: 8px 12px;
    text-decoration: none;
    color: #2c3e50;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: all 0.3s ease;
    font-weight: 500;
}
.pagination a:hover {
    background-color: #f5f5f5;
}
.pagination a.active {
    background-color: #2c3e50;
    color: white;
    border-color: #2c3e50;
}
.pagination a.next {
    margin-left: 10px;
}
/* CSS para ocultar inicialmente el submenú */



/* Animaciones */
@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity: 1;}
}
@keyframes slideDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.fade-in {
    animation: fadeInUp 0.5s ease-out forwards;
}
.user-profile {
    text-align: center;
    margin-bottom: 20px; /* Espacio entre la foto y la navegación */
}

.profile-img {
    width: 60px; /* Ajusta según tu diseño */
    height: 60px; /* Ajusta según tu diseño */
    border-radius: 50%; /* Hace que la imagen sea circular */
}

.user-name {
    font-weight: bold;
    margin: 5px 0; /* Espaciado entre el nombre y el icono */
}

.logout-icon img {
    width: 20px; /* Ajusta según tu diseño */
    height: 20px; /* Ajusta según tu diseño */
}

    </style>
</head>
<body>
<div class="container">
    <?php require 'menu.php'; ?>
    <div class="main-content">
        <h2>Gestión de Proveedores</h2>
        <form class="search-form" action="" method="GET">
            <input type="text" name="search" placeholder="Buscar proveedor por nombre..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Buscar</button>
            <button type="button" class="add-product-btn" onclick="openModal()">Agregar Proveedor</button>
        </form>

        <table class="categories-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre-Empresa</th>
                    <th>Nombre-Contacto</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Fecha-Creación</th>
                    <th>Fecha-Actualización</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_empresa']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_contacto']); ?></td>
                        <td><?php echo htmlspecialchars($row['direccion']); ?></td>
                        <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                        <td><?php echo $row['fecha_creacion']; ?></td>
                        <td><?php echo $row['fecha_actualizacion']; ?></td>
                        <td>
                            <button class="btn btn-edit" onclick="editProvider(<?php echo $row['id']; ?>)"><i class="fas fa-edit"></i></button>
                            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este proveedor?')" class="btn btn-delete"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li><a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>

<!-- Modal para agregar/editar proveedor -->
<div class="modal" id="providerModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Agregar Proveedor</h2>
        <form id="providerForm" action="" method="POST">
            <input type="hidden" name="id" id="providerId">
            <div class="form-group">
                <label for="nombre">Nombre de Empresa</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="nombre_contacto">Nombre de Contacto</label>
                <input type="text" name="nombre_contacto" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" required>
            </div>
            <div class="form-group">
                <button type="submit">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('providerModal').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('providerModal').style.display = 'none';
        document.getElementById('providerForm').reset();
    }
    function editProvider(id) {
        openModal();
        document.getElementById('modalTitle').textContent = 'Editar Proveedor';
        document.getElementById('providerId').value = id;

        fetch(`get_provider.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.querySelector('input[name="nombre"]').value = data.nombre;
                document.querySelector('input[name="direccion"]').value = data.direccion;
                document.querySelector('input[name="telefono"]').value = data.telefono;
            })
            .catch(error => console.error('Error al cargar los datos:', error));
    }

    window.onclick = function(event) {
        const modal = document.getElementById('providerModal');
        if (event.target === modal) {
            closeModal();
        }
    };

        document.addEventListener('DOMContentLoaded', () => {
        // Selecciona el enlace que despliega el submenú
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        const dropdownMenu = document.querySelector('.dropdown');

        // Agrega el evento de clic para alternar la clase 'show'
        dropdownToggle.addEventListener('click', (event) => {
            event.preventDefault(); // Evita que el enlace se active
            dropdownMenu.classList.toggle('show');
        });
    });
    </script>
</body>
</html>