<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías - Sistema de Inventario</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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

/* Tablas (productos y categorías) */
.products-table, .categories-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    font-size: 14px;
}
.products-table th, .products-table td,
.categories-table th, .categories-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
.products-table th, .categories-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}
.products-table tr, .categories-table tr {
    transition: background-color 0.3s ease;
}
.products-table tr:hover, .categories-table tr:hover {
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
.search-form button, .add-product-btn, .add-category-btn {
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
.search-form button:hover, .add-product-btn:hover, .add-category-btn:hover {
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

/* Formularios (productos y categorías) */
.product-form, .category-form {
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
/* Estilo para el menú desplegable */
.dropdown {
        display: none; /* Oculta el submenú por defecto */
        list-style: none;
        padding-left: 20px;
        margin: 0;
    }
    .dropdown-toggle:hover + .dropdown, 
    .dropdown:hover {
        display: block; /* Muestra el submenú al pasar el ratón */
    }

    /* Opcional: Ajustes del submenú */
    .dropdown li a {
        padding: 8px;
        font-size: 14px;
        color: #555;
    }
    .dropdown li a:hover {
        background-color: #ccc;
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
                <h2>Gestión de Categorías</h2>
            </header>
            
            <!-- Formulario de búsqueda y botón para agregar categoría -->
            <div class="search-form">
                <input type="text" placeholder="Buscar categorías...">
                <button type="submit">Buscar</button>
                <button class="add-category-btn" onclick="openModal()">Agregar Categoría</button>
            </div>
            
            <!-- Tabla de categorías -->
            <table class="categories-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de la Categoría</th>
                        <th>Descripción</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="fade-in">
                        <td>1</td>
                        <td>Electrónicos</td>
                        <td>Productos electrónicos y gadgets</td>
                        <td>2023-01-01</td>
                        <td>
                            <button class="btn btn-edit" onclick="editCategory(1)">Editar</button>
                            <button class="btn btn-delete" onclick="deleteCategory(1)">Eliminar</button>
                        </td>
                    </tr>
                    <tr class="fade-in">
                        <td>2</td>
                        <td>Ropa</td>
                        <td>Prendas de vestir y accesorios</td>
                        <td>2023-01-02</td>
                        <td>
                            <button class="btn btn-edit" onclick="editCategory(2)">Editar</button>
                            <button class="btn btn-delete" onclick="deleteCategory(2)">Eliminar</button>
                        </td>
                    </tr>
                    <!-- Aquí se repetirían más filas para las otras categorías -->
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

    <!-- Modal para agregar/editar categoría -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle">Agregar/Editar Categoría</h3>
            <form id="categoryForm" class="category-form">
                <div class="form-group">
                    <label for="categoryName">Nombre de la Categoría:</label>
                    <input type="text" id="categoryName" name="categoryName" required>
                </div>
                <div class="form-group">
                    <label for="categoryDescription">Descripción:</label>
                    <textarea id="categoryDescription" name="categoryDescription" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Guardar Categoría</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Funciones para manejar el modal
        function openModal() {
            document.getElementById('categoryModal').style.display = 'flex';
            document.getElementById('modalTitle').textContent = 'Agregar Categoría';
            document.getElementById('categoryForm').reset();
        }

        function closeModal() {
            document.getElementById('categoryModal').style.display = 'none';
        }

        // Funciones para manejar el CRUD de categorías
        function editCategory(id) {
            openModal();
            document.getElementById('modalTitle').textContent = 'Editar Categoría';
            // Aquí iría la lógica para cargar los datos de la categoría en el formulario
            console.log('Editando categoría con ID:', id);
        }

        function deleteCategory(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta categoría?')) {
                console.log('Eliminando categoría con ID:', id);
                // Aquí iría la lógica para eliminar la categoría
            }
        }

        // Manejar el envío del formulario
        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Aquí iría la lógica para guardar o actualizar la categoría
            console.log('Guardando categoría...');
            closeModal();
        });

        // Manejar la búsqueda de categorías
        document.querySelector('.search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const searchTerm = this.querySelector('input').value;
            console.log('Buscando categorías con término:', searchTerm);
            // Aquí iría la lógica para filtrar las categorías
        });

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target == document.getElementById('categoryModal')) {
                closeModal();
            }
        }

        // Manejar la paginación
        document.querySelector('.pagination').addEventListener('click', function(e) {
            e.preventDefault();
            if (e.target.tagName === 'A') {
                // Remover la clase active de todos los enlaces
                this.querySelectorAll('a').forEach(link => link.classList.remove('active'));
                // Agregar la clase active al enlace clickeado
                if (!e.target.classList.contains('next')) {
                    e.target.classList.add('active');
                }
                // Aquí puedes agregar la lógica para cargar la página correspondiente
                console.log('Página seleccionada:', e.target.textContent);
            }
        });

        // Animación para los elementos de la tabla
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.categories-table tbody tr');
            rows.forEach((row, index) => {
                setTimeout(() => {
                    row.classList.add('fade-in');
                }, index * 100);
            });
        });
    </script>
</body>
</html>