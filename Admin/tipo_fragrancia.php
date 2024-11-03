<?php
include("../db/conexion.php");

// Variables de paginación
$limit = 5; // Número de fragancias por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta de fragancias con paginación y búsqueda
$sql = "SELECT * FROM fragancia WHERE marca LIKE ? ORDER BY id LIMIT ?, ?";
$stmt = $conexion->prepare($sql);
$searchParam = "%$search%";
$stmt->bind_param("sii", $searchParam, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Total de fragancias para paginación
$totalSql = "SELECT COUNT(*) FROM fragancia WHERE marca LIKE ?";
$totalStmt = $conexion->prepare($totalSql);
$totalStmt->bind_param("s", $searchParam);
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalFragancias = $totalResult->fetch_row()[0];
$totalPages = ceil($totalFragancias / $limit);

// Lógica para agregar/editar/eliminar fragancia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = $_POST['marca'];
    $tipo_fragancia = $_POST['tipo_fragancia'];
    $descripcion = $_POST['descripcion'];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Editar fragancia
        $id = (int)$_POST['id'];
        $updateSql = "UPDATE fragancia SET marca = ?, tipo_fragancia = ?, descripcion = ?, fecha_actualizacion = NOW() WHERE id = ?";
        $updateStmt = $conexion->prepare($updateSql);
        $updateStmt->bind_param("sssi", $marca, $tipo_fragancia, $descripcion, $id);
        if ($updateStmt->execute()) {
            header("Location: tipo_fregancia.php"); // Redirige para evitar reenvío de formulario
            exit;
        } else {
            echo "Error al editar la fragancia: " . $conexion->error;
        }
    } else {
        // Agregar nueva fragancia
        $insertSql = "INSERT INTO fragancia (marca, tipo_fragancia, descripcion, fecha_creacion) VALUES (?, ?, ?, NOW())";
        $insertStmt = $conexion->prepare($insertSql);
        $insertStmt->bind_param("sss", $marca, $tipo_fragancia, $descripcion);
        if ($insertStmt->execute()) {
            header("Location: tipo_fregancia.php"); // Redirige para evitar reenvío de formulario
            exit;
        } else {
            echo "Error al agregar la fragancia: " . $conexion->error;
        }
    }
}

// Eliminar fragancia
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $deleteSql = "DELETE FROM fragancia WHERE id = ?";
    $deleteStmt = $conexion->prepare($deleteSql);
    $deleteStmt->bind_param("i", $id);
    if ($deleteStmt->execute()) {
        header("Location: tipo_fragrancia.php"); // Redirige para evitar reenvío de formulario
        exit;
    } else {
        echo "Error al eliminar la fragancia: " . $conexion->error;
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
    margin: auto;
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


    </style>
</head>
<body>
<div class="container">
    <?php require 'menu.php'; ?>
        <div class="main-content">
            <h2>Gestión de Fragancias</h2>
            <form class="search-form" action="" method="GET">
                <input type="text" name="search" placeholder="Buscar fragancia por marca..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Buscar</button>
                <button type="button" class="add-product-btn" onclick="openModal()">Agregar Fragancia</button>
            </form>
            
            <table class="categories-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Tipo-Fragancia</th>
                        <th>Descripción</th>
                        <th>Fecha-Creación</th>
                        <th>Fecha-Actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['marca']); ?></td>
                            <td><?php echo htmlspecialchars($row['tipo_fragancia']); ?></td>
                            <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                            <td><?php echo $row['fecha_creacion']; ?></td>
                            <td><?php echo $row['fecha_actualizacion']; ?></td>
                            <td>
                                <button class="btn btn-edit" onclick="editCategory(<?php echo $row['id']; ?>)"><i class="fas fa-edit"></i></button>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar esta fragancia?')" class="btn btn-delete"><i class="fas fa-trash-alt"></i></a>
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

    <!-- Modal para agregar/editar fragancia -->
    <div class="modal" id="categoryModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Agregar Fragancia</h2>
            <form id="categoryForm" action="" method="POST">
                <input type="hidden" name="id" id="categoryId">
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" name="marca" required>
                </div>
                <div class="form-group">
                    <label for="tipo_fragancia">Tipo de Fragancia</label>
                    <input type="text" name="tipo_fragancia" required>
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
