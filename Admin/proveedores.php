<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores - Sistema de Inventario</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

/* Estilos generales */
body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f2f5;
    color: #333;
    font-weight: bold;
}
.container {
    display: flex;
    min-height: 100vh;
}

/* Barra lateral */
.sidebar {
    width: 250px;
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    transition: all 0.3s ease;
}
.sidebar h1 {
    text-align: center;
    margin-bottom: 30px;
}
.sidebar ul {
    list-style-type: none;
    padding: 0;
}
.sidebar ul li {
    margin-bottom: 15px;
}
.sidebar ul li a {
    color: white;
    text-decoration: none;
    display: block;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}
.sidebar ul li a:hover {
    background-color: #34495e;
}

/* Estilo para el menú desplegable */
.dropdown {
    display: none;
    list-style: none;
    padding-left: 20px;
    margin: auto;
}
.dropdown-toggle:hover + .dropdown, 
.dropdown:hover {
    display: block;
}
.dropdown li a:hover {
    background-color: #34495e;
}

/* Contenido principal */
.main-content {
    flex-grow: 1;
    padding: 20px;
}
.header {
    background-color: white;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.header h2 {
    margin: 0;
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

/* Paginación */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    gap: 5px;
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
    </style>
</head>
<body>
    <div class="container">
        <?php require 'menu.php'; ?>
        <main class="main-content">
            <header class="header">
                <h2>Gestión de Proveedores</h2>
            </header>
            
            <!-- Formulario de búsqueda y botón para agregar proveedor -->
            <div class="search-form">
                <input type="text" placeholder="Buscar proveedores...">
                <button type="submit">Buscar</button>
                <button class="add-supplier-btn" onclick="openModal()">Agregar Proveedor</button>
            </div>
            
            <!-- Tabla de proveedores -->
            <table class="suppliers-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de la Empresa</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="fade-in">
                        <td>1</td>
                        <td>Suministros S.A.</td>
                        <td>Juan Pérez</td>
                        <td>+1234567890</td>
                        <td>juan@suministros.com</td>
                        <td>Calle Principal 123, Ciudad</td>
                        <td>
                            <button class="btn btn-edit" onclick="editSupplier(1)">Editar</button>
                            <button class="btn btn-delete" onclick="deleteSupplier(1)">Eliminar</button>
                        </td>
                    </tr>
                    <!-- Aquí se repetirían más filas para los otros proveedores -->
                </tbody>
            </table>

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

    <!-- Modal para agregar/editar proveedor -->
    <div id="supplierModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle">Agregar/Editar Proveedor</h3>
            <form id="supplierForm" class="supplier-form">
                <div class="form-group">
                    <label for="companyName">Nombre de la Empresa:</label>
                    <input type="text" id="companyName" name="companyName" required>
                </div>
                <div class="form-group">
                    <label for="contactName">Nombre de Contacto:</label>
                    <input type="text" id="contactName" name="contactName" required>
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="address">Dirección:</label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Guardar Proveedor</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Funciones para manejar el modal
        function openModal() {
            document.getElementById('supplierModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Agregar Proveedor';
            document.getElementById('supplierForm').reset();
        }

        function closeModal() {
            document.getElementById('supplierModal').style.display = 'none';
        }

        // Funciones para manejar el CRUD de proveedores
        function editSupplier(id) {
            openModal();
            document.getElementById('modalTitle').textContent = 'Editar Proveedor';
            // Aquí iría la lógica para cargar los datos del proveedor en el formulario
            console.log('Editando proveedor con ID:', id);
        }

        function deleteSupplier(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este proveedor?')) {
                console.log('Eliminando proveedor con ID:', id);
                // Aquí iría la lógica para eliminar el proveedor
            }
        }

        // Manejar el envío del formulario
        document.getElementById('supplierForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Aquí iría la lógica para guardar o actualizar el proveedor
            console.log('Guardando proveedor...');
            closeModal();
        });

        // Manejar la búsqueda de proveedores
        document.querySelector('.search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const searchTerm = this.querySelector('input').value;
            console.log('Buscando proveedores con término:', searchTerm);
            // Aquí iría la lógica para filtrar los proveedores
        });

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target == document.getElementById('supplierModal')) {
                closeModal();
            }
        }

        // Animación para los elementos de la tabla
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.suppliers-table tbody tr');
            rows.forEach((row, index) => {
                setTimeout(() => {
                    row.classList.add('fade-in');
                }, index * 100);
            });
        });
    </script>
</body>
</html>