
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Contenido de Página - Sistema de Inventario</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos para la tabla de contenido de página */
.table-container {
    overflow-x: auto;
    margin-bottom: 1rem;
}

.content-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background-color: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.content-table th,
.content-table td {
    padding: 12px 15px;
    text-align: left;
}

.content-table thead {
    background-color: #2c3e50;
    color: #ffffff;
}

.content-table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.content-table tbody tr {
    transition: background-color 0.3s ease;
}

.content-table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

.content-table tbody tr:hover {
    background-color: #e9ecef;
}

.content-table td {
    border-bottom: 1px solid #dee2e6;
}

.content-table tbody tr:last-child td {
    border-bottom: none;
}

/* Estilos para los botones de acción en la tabla */
.content-table .btn {
    padding: 6px 12px;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 4px;
    transition: all 0.15s ease-in-out;
}

.content-table .btn-edit {
    background-color: #4CAF50;
    color: white;
    border: none;
    margin-right: 5px;
}

.content-table .btn-edit:hover {
    background-color: #45a049;
}

.content-table .btn-delete {
    background-color: #f44336;
    color: white;
    border: none;
}

.content-table .btn-delete:hover {
    background-color: #d32f2f;
}

/* Animación para las filas de la tabla */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.content-table tbody tr.fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}
    </style>
</head>
<body>
    <div class="container">
        <?php require 'menu.php'; ?>
        <main class="main-content">
            <header class="header">
                <h2>Gestión de Contenido de Página</h2>
            </header>
            
            <!-- Formulario de búsqueda y botón para agregar contenido -->
            <div class="search-form">
                <input type="text" id="buscar_nit" placeholder="Buscar por NIT...">
                <button onclick="buscarProducto()">Buscar</button>
                <button class="add-content-btn" onclick="openModal()">Agregar Contenido</button>
            </div>
            
           <!-- Tabla de contenido de página -->
<div class="table-container">
    <table class="content-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NIT del Producto</th>
                <th>Parte de la Página</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se llenarán las filas con PHP -->
        </tbody>
    </table>
</div>

            <!-- Paginación -->
            <div class="pagination">
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#" class="next">Siguiente</a>
            </div>
        </main>
    </div>

    <!-- Modal para agregar/editar contenido -->
    <div id="contentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle">Agregar/Editar Contenido de Página</h3>
            <form id="contentForm" class="content-form">
                <div class="form-group">
                    <label for="productNit">NIT del Producto:</label>
                    <input type="text" id="productNit" name="productNit" required>
                </div>
                <div class="form-group">
                    <label for="pagePart">Parte de la Página:</label>
                    <select id="pagePart" name="pagePart" required>
                        <option value="">Seleccionar...</option>
                        <option value="Hot Deals">Hot Deals</option>
                        <option value="Best Sellers">Best Sellers</option>
                        <option value="On Sale">On Sale</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" id="submitButton">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(action = "add", id = null) {
    document.getElementById('contentModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = action === "add" ? "Agregar Contenido" : "Editar Contenido";
    document.getElementById('contentForm').reset();

    if (action === "edit") {
        // Llenar el formulario con datos del contenido seleccionado
        fetch(`content_pg.php?action=edit&id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('productNit').value = data.nit;
                document.getElementById('pagePart').value = data.contenido_pg;
            });
    }
}

function closeModal() {
    document.getElementById('contentModal').style.display = 'none';
}

function buscarProducto() {
    const nit = document.getElementById('buscar_nit').value;
    const action = 'search';

    fetch('content_pg.php', {
        method: 'POST',
        body: new URLSearchParams({
            action,
            productNit: nit
        })
    })
    .then(response => response.text())
    .then(data => {
        document.querySelector('.content-table tbody').innerHTML = data;
    });
}

document.getElementById('contentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const action = document.getElementById('modalTitle').textContent.includes('Editar') ? 'edit' : 'add';
    const nit = document.getElementById('productNit').value;
    const pagePart = document.getElementById('pagePart').value;

    fetch('content_pg.php', {
        method: 'POST',
        body: new URLSearchParams({
            action,
            productNit: nit,
            pagePart
        })
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        closeModal();
        buscarProducto();
    });
});

    </script>
</body>
</html>
