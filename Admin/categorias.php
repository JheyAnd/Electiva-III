<?php
include("../db/conexion.php");

// Variables de paginación
$limit = 10; // Número de categorías por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta de categorías con paginación y búsqueda
$sql = "SELECT * FROM categorias WHERE nombre LIKE ? ORDER BY id LIMIT ?, ?";
$stmt = $conexion->prepare($sql);
$searchParam = "%$search%";
$stmt->bind_param("sii", $searchParam, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Total de categorías para paginación
$totalSql = "SELECT COUNT(*) FROM categorias WHERE nombre LIKE ?";
$totalStmt = $conexion->prepare($totalSql);
$totalStmt->bind_param("s", $searchParam);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalCategories = $totalResult->fetch_row()[0];
$totalPages = ceil($totalCategories / $limit);

// Lógica para agregar/editar/eliminar categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Editar categoría
        $id = (int)$_POST['id'];
        $updateSql = "UPDATE categorias SET nombre = ?, descripcion = ? WHERE id = ?";
        $updateStmt = $conexion->prepare($updateSql);
        $updateStmt->bind_param("ssi", $nombre, $descripcion, $id);
        if ($updateStmt->execute()) {
            header("Location: categorias.php"); // Redirige para evitar reenvío de formulario
            exit;
        } else {
            echo "Error al editar la categoría: " . $conexion->error;
        }
    } else {
        // Agregar nueva categoría
        $insertSql = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)";
        $insertStmt = $conexion->prepare($insertSql);
        $insertStmt->bind_param("ss", $nombre, $descripcion);
        if ($insertStmt->execute()) {
            header("Location: categorias.php"); // Redirige para evitar reenvío de formulario
            exit;
        } else {
            echo "Error al agregar la categoría: " . $conexion->error;
        }
    }
}

// Eliminar categoría
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $deleteSql = "DELETE FROM categorias WHERE id = ?";
    $deleteStmt = $conexion->prepare($deleteSql);
    $deleteStmt->bind_param("i", $id);
    if ($deleteStmt->execute()) {
        header("Location: categorias.php"); // Redirige para evitar reenvío de formulario
        exit;
    } else {
        echo "Error al eliminar la categoría: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías - Sistema de Inventario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
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
        .sidebar {
    width: 280px;
    background-color: #2c3e50;
    color: white;
    height: 100vh; /* Ajusta la altura si tienes una cabecera de 60px */
    position: fixed;
    left: 0;
    top: 0;
    padding-top: 2rem;
    transition: all 0.3s ease;
    /* Si deseas que la barra lateral no tenga borde en el contenido, puedes usar */
    border-right: 1px solid rgba(255, 255, 255, 0.1); /* Borde derecho opcional */
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
        /* Tablas (productos y categorías) */
        .categories-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-size: 14px;
        }
        .categories-table th, .categories-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .categories-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .categories-table tr:hover {
            background-color: #f5f5f5;
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
        .search-form button {
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
        .search-form button:hover {
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
        /* Formularios (productos y categorías) */
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
        }
        .form-group button:hover {
            background-color: #34495e;
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
.dropdown {
    display: none;
    list-style: none;
    padding-left: 20px;
}

.dropdown.show {
    display: block;
}

.dropdown li a:hover {
    background-color: #ccc;
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
            <h2>Gestión de Categorías</h2>
            <form class="search-form" action="" method="GET">
                <input type="text" name="search" placeholder="Buscar categoría..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Buscar</button>
                <button type="button" class="add-product-btn" onclick="openModal()">Agregar Categoría</button>

            </form>
            
            <table class="categories-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                            <td>
                            <button class="btn btn-edit"  onclick="editCategory(<?php echo $row['id']; ?>)"><i class="fas fa-edit"></i></button>
                            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar esta categoría?')" class="btn btn-delete"><i class="fas fa-trash-alt"></i></a>
                            
                            
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div>
                <nav>
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li><a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
            
        </div>
    </div>

    <!-- Modal para agregar/editar categoría -->
    <div class="modal" id="categoryModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Agregar Categoría</h2>
            <form id="categoryForm" action="" method="POST">
                <input type="hidden" name="id" id="categoryId">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('categoryModal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('categoryModal').style.display = 'none';
            document.getElementById('categoryForm').reset();
        }
        function editCategory(id) {
            openModal();
            document.getElementById('modalTitle').textContent = 'Editar Categoría';
            document.getElementById('categoryId').value = id;

            // Cargar los datos de la categoría
            fetch(`get_category.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('input[name="nombre"]').value = data.nombre;
                    document.querySelector('textarea[name="descripcion"]').value = data.descripcion;
                })
                .catch(error => console.error('Error al cargar los datos:', error));
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('categoryModal');
            if (event.target === modal) {
                closeModal();
            }
        }
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
