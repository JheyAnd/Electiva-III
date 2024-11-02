<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Sistema de Inventario</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
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
        
        /* Estilo específico para los números grandes */
        .big-number {
            font-size: 3.5em;
            font-weight: bold;
            margin: 0;
            color: #2c3e50;
        }
        
        /* Estilos para la tabla de productos */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-size: 14px;
        }
        .products-table th, .products-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .products-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .products-table tr {
            transition: background-color 0.3s ease;
        }
        .products-table tr:hover {
            background-color: #f5f5f5;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        /* Estilos para el formulario de búsqueda */
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
        .search-form button, .add-product-btn {
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
        .search-form button:hover, .add-product-btn:hover {
            background-color: #34495e;
        }
        
        /* Estilos para el modal */
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
        /* Agregamos flexbox para centrar el contenido */
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
        /* Eliminamos el margin ya que usamos flexbox para centrar */
        margin: auto;
        /* Agregamos una altura máxima y scroll si es necesario */
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
        
        /* Estilos actualizados para el formulario de producto */
        .product-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Montserrat', sans-serif;
        }
        .form-group button {
            grid-column: span 2;
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

        /* Estilos actualizados para los botones de acción */
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
        /* Agregar estos estilos para la paginación */
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
            from {transform: translateY(-50px); opacity: 0;}
            to {transform: translateY(0); opacity: 1;}
        }
        /* Actualizamos la animación slideDown */
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
                <h2>Gestión de Productos</h2>
            </header>
            
            <!-- Formulario de búsqueda y botón para agregar producto -->
            <div class="search-form">
                <input type="text" placeholder="Buscar productos...">
                <button type="submit">Buscar</button>
                <button class="add-product-btn" onclick="openModal()">Agregar</button>
            </div>
            
            <!-- Tabla de productos -->
            <table class="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre del Producto</th>
                        <th>Categoria</th>
                        <th>Marca</th>
                        <th>Tamaño</th>
                        <th>Cantidad</th>
                        <th>Precio por Unidad</th>
                        <th>Descuento por Unidad</th>
                        <th>Fecha de Agregado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="fade-in">
                        <th>ID</th>
                        <td><img src="/placeholder.svg?height=50&width=50" alt="Producto 1" class="product-image"></td>
                        <td>Producto 1</td>
                        <th>Hombre</th>
                        <td>Marca A</td>
                        <td>Grande</td>
                        <td>100</td>
                        <td>$10.00</td>
                        <td>$1.00</td>
                        <td>2023-01-01</td>
                        <td>
                            <button class="btn btn-edit" onclick="editProduct(1)">Editar</button>
                            <button class="btn btn-delete" onclick="deleteProduct(1)">Eliminar</button>
                        </td>
                    </tr>
                    <!-- Aquí se repetirían más filas para los otros productos -->
                </tbody>
            </table>
            <div class="pagination">
                        <a href="#" class="active">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#">6</a>
                        <a href="#">7</a>
                        <a href="#">8</a>
                        <a href="#">9</a>
                        <a href="#">10</a>
                        <a href="#" class="next">Siguiente</a>
                    </div>
        </main>
    </div>
    

    <!-- Modal para agregar/editar producto -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="modalTitle">Agregar/Editar Producto</h3>
            <form id="productForm" class="product-form">
                <div class="form-group">
                    <label for="productImage">Imagen del Producto:</label>
                    <input type="file" id="productImage" name="productImage" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="productName">Nombre del Producto:</label>
                    <select name="categoria" id="categoria" requered>
                        <option value="electronica">Electrónica</option>
                        <option value="ropa">Ropa</option>
                        <option value="alimentos">Alimentos</option>
                        <option value="hogar">Hogar</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="unitDiscount">Proveedor:</label>
                    <input type="number" id="unitDiscount" name="unitDiscount" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="brand">Marca:</label>
                    <input type="text" id="brand" name="brand" required>
                </div>
                <div class="form-group">
                    <label for="size">Tamaño:</label>
                    <input type="text" id="size" name="size" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Cantidad:</label>
                    <input type="number" id="quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="unitPrice">Precio por Unidad:</label>
                    <input type="number" id="unitPrice" name="unitPrice" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="unitDiscount">Descuento por Unidad:</label>
                    <input type="number" id="unitDiscount" name="unitDiscount" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="unitDiscount">Descuento por Unidad:</label>
                    <input type="number" id="unitDiscount" name="unitDiscount" step="0.01" required>
                </div>
                <div class="form-group">
                    <button type="submit">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Funciones para manejar el modal
        function openModal() {
            document.getElementById('productModal').style.display = 'block';
            document.getElementById('modalTitle').textContent = 'Agregar Producto';
            document.getElementById('productForm').reset();
        }

        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
        }

        // Funciones para manejar el CRUD de productos
        function editProduct(id) {
            openModal();
            document.getElementById('modalTitle').textContent = 'Editar Producto';
            // Aquí iría la lógica para cargar los datos del producto en el formulario
            console.log('Editando producto con ID:', id);
        }

        function deleteProduct(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                console.log('Eliminando producto con ID:', id);
                // Aquí iría la lógica para eliminar el producto
            }
        }

        // Manejar el envío del formulario
        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Aquí iría la lógica para guardar o actualizar el producto
            console.log('Guardando producto...');
            closeModal();
        });

        // Manejar la búsqueda de productos
        document.querySelector('.search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const searchTerm = this.querySelector('input').value;
            console.log('Buscando productos con término:', searchTerm);
            // Aquí iría  la lógica para filtrar los productos
        });

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target == document.getElementById('productModal')) {
                closeModal();
            }
        }

        // Animación para los elementos de la tabla
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.products-table tbody tr');
            rows.forEach((row, index) => {
                setTimeout(() => {
                    row.classList.add('fade-in');
                }, index * 100);
            });
        });
        // Agregar esta función para manejar la paginación
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
    </script>
</body>
</html>