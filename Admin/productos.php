<?php
include("../db/conexion.php");

//Iniciar la sesión y verificar si el usuario está logueado
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Variables de paginación
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta de productos con paginación y búsqueda
$sql = "SELECT p.*, f.marca AS marca_fragancia, pr.nombre_empresa AS proveedor, c.nombre AS categoria
        FROM productos p
        LEFT JOIN fragancia f ON p.fragancia_id = f.id
        LEFT JOIN proveedores pr ON p.proveedor_id = pr.id
        LEFT JOIN categorias c ON p.categoria_id = c.id
        WHERE p.nombre LIKE '%$search%' ORDER BY p.id LIMIT $offset, $limit";
$result = $conexion->query($sql);

// Total de productos para paginación
$totalSql = "SELECT COUNT(*) FROM productos WHERE nombre LIKE '%$search%'";
$totalResult = $conexion->query($totalSql);
$totalProductos = $totalResult->fetch_row()[0];
$totalPages = ceil($totalProductos / $limit);

// Lógica para agregar/editar/eliminar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion'] ?? '');
    $proveedor_id = (int)$_POST['proveedor_id'];
    $categoria_id = (int)$_POST['categoria_id'];
    $marca = $conexion->real_escape_string($_POST['marca']);
    $tipo_fragancia_nombre = $conexion->real_escape_string($_POST['tipo_fragancia']);
    $tamaño = $conexion->real_escape_string($_POST['tamaño']);
    $cantidad = (int)$_POST['cantidad'];
    $precio_x1 = (float)$_POST['precio_x1'];
    $descuento_x1 = (float)$_POST['descuento_x1'];

    // Obtener fragancia_id
    $fraganciaIdQuery = "SELECT id FROM fragancia WHERE tipo_fragancia = '$tipo_fragancia_nombre'";
    $fraganciaResult = $conexion->query($fraganciaIdQuery);
    if ($fraganciaResult->num_rows > 0) {
        $fraganciaRow = $fraganciaResult->fetch_assoc();
        $fragancia_id = $fraganciaRow['id'];
    } else {
        die("Error: Tipo de fragancia no válido.");
    }

    // Directorio de imágenes
    $directorio = "imagen/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // Procesar imágenes
    $imagenes = [];
    for ($i = 1; $i <= 5; $i++) {
        // Verificar si se subió una nueva imagen
        if (isset($_FILES["imagen$i"]) && $_FILES["imagen$i"]['error'] === UPLOAD_ERR_OK) {
            $tipoArchivo = mime_content_type($_FILES["imagen$i"]["tmp_name"]);
            if (in_array($tipoArchivo, ['image/jpeg', 'image/png', 'image/gif'])) {
                $nombreArchivo = uniqid() . '_' . basename($_FILES["imagen$i"]["name"]); // Nombre único
                $ruta = $directorio . $nombreArchivo;
                if (move_uploaded_file($_FILES["imagen$i"]["tmp_name"], $ruta)) {
                    $imagenes[$i] = $ruta;
                } else {
                    echo "Error al mover el archivo $nombreArchivo";
                }
            } else {
                echo "El archivo {$i} no es una imagen válida.";
            }
        } else {
            // Si no se subió nueva imagen, mantener la anterior si existe
            $imagenes[$i] = isset($_POST["imagen_anterior$i"]) ? $_POST["imagen_anterior$i"] : NULL;
        }
    }

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Editar producto
        $id = (int)$_POST['id'];
        
        // Construir la parte de imágenes del query dinámicamente
        $imagenesQuery = [];
        for ($i = 1; $i <= 5; $i++) {
            $imagen = $imagenes[$i] !== NULL ? "'" . $conexion->real_escape_string($imagenes[$i]) . "'" : 'NULL';
            $imagenesQuery[] = "imagen$i = $imagen";
        }
        $imagenesQueryStr = implode(", ", $imagenesQuery);

        $updateSql = "UPDATE productos SET 
            nombre = '$nombre', 
            descripcion = '$descripcion', 
            proveedor_id = $proveedor_id, 
            fragancia_id = $fragancia_id, 
            categoria_id = $categoria_id, 
            marca = '$marca', 
            tipo_fragancia = '$tipo_fragancia_nombre', 
            tamaño = '$tamaño', 
            cantidad = $cantidad, 
            precio_x1 = $precio_x1, 
            descuento_x1 = $descuento_x1, 
            $imagenesQueryStr,
            fecha_actualizacion = NOW() 
            WHERE id = $id";

        if ($conexion->query($updateSql) === TRUE) {
            header("Location: productos.php");
            exit;
        } else {
            echo "Error al editar el producto: " . $conexion->error;
        }
    } else {
            // Generar un NIT aleatorio de 9 dígitos
        $nit = str_pad(mt_rand(0, 999999999), 9, '0', STR_PAD_LEFT); // Relleno de ceros a la izquierda si es necesario

        // Construir la parte de imágenes del query dinámicamente
        $imagenesValues = [];
        for ($i = 1; $i <= 5; $i++) {
            $imagen = $imagenes[$i] !== NULL ? "'" . $conexion->real_escape_string($imagenes[$i]) . "'" : 'NULL';
            $imagenesValues[] = $imagen;
        }
        $imagenesValuesStr = implode(", ", $imagenesValues);

        $insertSql = "INSERT INTO productos (
            nombre, descripcion, proveedor_id, fragancia_id, marca, 
            tipo_fragancia, tamaño, cantidad, precio_x1, descuento_x1, 
            imagen1, imagen2, imagen3, imagen4, imagen5, 
            fecha_creacion, fecha_actualizacion, categoria_id, nit
        ) VALUES (
            '$nombre', '$descripcion', $proveedor_id, $fragancia_id, '$marca',
            '$tipo_fragancia_nombre', '$tamaño', $cantidad, $precio_x1, $descuento_x1,
            $imagenesValuesStr,
            NOW(), NOW(), $categoria_id, '$nit'
        )";

        if ($conexion->query($insertSql) === TRUE) {
            header("Location: productos.php");
            exit;
        } else {
            echo "Error al insertar el producto: " . $conexion->error;
        }

    }
}

// Eliminar producto
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $deleteSql = "DELETE FROM productos WHERE id = $id";
    if ($conexion->query($deleteSql) === TRUE) {
        header("Location: productos.php");
        exit;
    } else {
        echo "Error al eliminar el producto: " . $conexion->error;
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Sistema de Inventario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tiny.cloud/1/4wgg1xab2nj9kzu81qhsw5zn5elf9on5neq24w6lmvzamuop/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    

    <style>
        <?php 
        require_once "style.css";
        ?>
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
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Buscar productos...">
                <button type="submit">Buscar</button>
            </form>
            <button class="add-product-btn" onclick="openModal()">Agregar</button>
        </div>
            
              <!-- Tabla de productos -->
        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Proveedor</th>
                    <th>Categoría</th>
                    <th>Marca</th>
                    <th>Tipo-Fragrancia</th>
                    <th>Tamaño</th>
                    <th>Cantidad</th>
                    <th>Precio X1</th>
                    <th>Descuento X1</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexión a la base de datos
                include("../db/conexion.php");

                // Consulta para obtener los productos
                $sql = "SELECT p.*, pr.nombre_empresa AS proveedor, c.nombre AS categoria 
                        FROM productos p
                        JOIN proveedores pr ON p.proveedor_id = pr.id 
                        JOIN categorias c ON p.categoria_id = c.id 
                        ORDER BY p.id";

                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr class="fade-in">';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td><img src="' . $row['imagen1'] . '" alt="' . htmlspecialchars($row['nombre']) . '" class="product-image" style="width:100px; height:auto;"></td>';
                        echo '<td>' . $row['nombre'] . '</td>';
                        echo '<td>' . $row['proveedor'] . '</td>';
                        echo '<td>' . $row['categoria'] . '</td>';
                        echo '<td>' . $row['marca'] . '</td>';
                        echo '<td>' . $row['tipo_fragancia'] . '</td>';
                        echo '<td>' . $row['tamaño'] . '</td>';
                        echo '<td>' . $row['cantidad'] . '</td>';
                        echo '<td>$' . number_format($row['precio_x1'], 2) . '</td>';
                        echo '<td>$' . number_format($row['descuento_x1'], 2) . '</td>';
                        echo '<td>';
                        echo '<button class="btn btn-edit" onclick="openModal(' . $row['id'] . ')"><i class="fas fa-edit"></i></button>';
                        echo '<button class="btn btn-delete" onclick="confirmDelete(' . $row['id'] . ')"><i class="fas fa-trash-alt"></i></button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="13">No se encontraron productos.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <a href="?page=<?php echo min($totalPages, $page + 1); ?>&search=<?php echo urlencode($search); ?>">Siguiente</a>
        </div>
        <br>
        <header class="header">
            <h2>Productos y su descripcion</h2>
        </header>
            <!-- Tabla de productos -->
            <table class="products-tables">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Consulta para obtener los productos
                $sql = "SELECT p.*, pr.nombre_empresa AS proveedor, c.nombre AS categoria 
                        FROM productos p
                        JOIN proveedores pr ON p.proveedor_id = pr.id 
                        JOIN categorias c ON p.categoria_id = c.id 
                        ORDER BY p.id";

                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr class="fade-in">';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td><img src="' . $row['imagen1'] . '" alt="' . htmlspecialchars($row['nombre']) . '" class="product-image" style="width:100px; height:auto;"></td>';
                        echo '<td>' . $row['nombre'] . '</td>';
                        echo '<td>' . $row['descripcion'] . '</td>';
                        echo '<td>';
                        echo '<button class="btn btn-edit" onclick="openModals(' . $row['id'] . ')"><i class="fas fa-edit"></i></button>';
                        echo '<button class="btn btn-delete" onclick="confirmDelete(' . $row['id'] . ')"><i class="fas fa-trash-alt"></i></button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="13">No se encontraron productos.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <a href="?page=<?php echo min($totalPages, $page + 1); ?>&search=<?php echo urlencode($search); ?>">Siguiente</a>
        </div>
        </main>
    </div>

<!-- Modal para agregar/editar producto -->
<div id="productModals" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModals()">×</span>
        <h3 id="modalTitle">Editar Descripción</h3>
        <form id="productForm" method="POST" enctype="multipart/form-data" action="">
            <div class="form-group2">
                <label for="editor">Descripción del producto:</label>
                <textarea id="editor" name="descripcion"></textarea>
            </div>
            <div class="button-group2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" onclick="closeModals()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para agregar/editar producto -->
<div id="productModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <h3 id="modalTitle">Agregar producto</h3>
        <form id="productForm" method="POST" enctype="multipart/form-data" action="">
            <div class="form-container">
                <!-- Bloque izquierdo -->
                <div class="left">
                <div class="form-group">
                        <label for="imagen1">Imagen de frente:</label>
                        <input type="file" id="imagen1" name="imagen1" accept="image/*">
                        <input type="hidden" name="imagen_anterior1" value="<?php echo $imagen_frente; ?>">

                        <label for="imagen2">Imagen de espalda:</label>
                        <input type="file" id="imagen2" name="imagen2" accept="image/*">
                        <input type="hidden" name="imagen_anterior2" value="<?php echo $imagen_espalda; ?>">

                        <label for="imagen3">Imagen lateral derecha:</label>
                        <input type="file" id="imagen3" name="imagen3" accept="image/*">
                        <input type="hidden" name="imagen_anterior3" value="<?php echo $imagen_lateral_derecha; ?>">

                        <label for="imagen4">Imagen lateral izquierda:</label>
                        <input type="file" id="imagen4" name="imagen4" accept="image/*">
                        <input type="hidden" name="imagen_anterior4" value="<?php echo $imagen_lateral_izquierda; ?>">

                        <label for="imagen5">Imagen entera:</label>
                        <input type="file" id="imagen5" name="imagen5" accept="image/*">
                        <input type="hidden" name="imagen_anterior5" value="<?php echo $imagen_entera; ?>">


                        <label for="nombre">Nombre del Producto:</label>
                        <input type="text" id="nombre" name="nombre" required>

                        <label for="tamaño">Tamaño:</label>
                        <input type="text" id="tamaño" name="tamaño" required>
                    </div>
                </div>

                <!-- Bloque derecho -->
                <div class="right">
                    <div class="form-block">
                        <h4>Detalles del producto</h4>
                        <label for="proveedor_id">Proveedor:</label>
                        <select name="proveedor_id" id="proveedor_id" required>
                            <?php
                            // Llenar el select con los proveedores desde la base de datos
                            $proveedoresQuery = "SELECT id, nombre_empresa FROM proveedores";
                            $proveedoresResult = $conexion->query($proveedoresQuery);
                            while ($proveedor = $proveedoresResult->fetch_assoc()) {
                                echo '<option value="' . $proveedor['id'] . '">' . $proveedor['nombre_empresa'] . '</option>';
                            }
                            ?>
                        </select>

                        <label for="categoria_id">Categoría:</label>
                        <select name="categoria_id" id="categoria_id" required>
                            <?php
                            // Llenar el select con las categorías desde la base de datos
                            $categoriasQuery = "SELECT id, nombre FROM categorias";
                            $categoriasResult = $conexion->query($categoriasQuery);
                            while ($categoria = $categoriasResult->fetch_assoc()) {
                                echo '<option value="' . $categoria['id'] . '">' . $categoria['nombre'] . '</option>';
                            }
                            ?>
                        </select>

                        <label for="marca">Marca:</label>
                        <select name="marca" id="marca" required>
                            <?php
                            // Llenar el select con las marcas desde la base de datos
                            $marcasQuery = "SELECT DISTINCT marca FROM fragancia";
                            $marcasResult = $conexion->query($marcasQuery);
                            while ($marca = $marcasResult->fetch_assoc()) {
                                echo '<option value="' . $marca['marca'] . '">' . $marca['marca'] . '</option>';
                            }
                            ?>
                        </select>

                        <label for="tipo_fragancia">Tipo de Fragancia:</label>
                        <select name="tipo_fragancia" id="tipo_fragancia" required>
                            <?php
                            // Llenar el select con los tipos de fragancia desde la base de datos
                            $tipoFraganciaQuery = "SELECT DISTINCT tipo_fragancia FROM fragancia";
                            $tipoFraganciaResult = $conexion->query($tipoFraganciaQuery);
                            while ($tipo_fragancia = $tipoFraganciaResult->fetch_assoc()) {
                                echo '<option value="' . $tipo_fragancia['tipo_fragancia'] . '">' . $tipo_fragancia['tipo_fragancia'] . '</option>';
                            }
                            ?>
                        </select>

                        <label for="cantidad">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" required>

                        <label for="precio_x1">Precio por unidad:</label>
                        <input type="number" id="precio_x1" name="precio_x1" step="0.01" required>

                        <label for="descuento_x1">Descuento por unidad:</label>
                        <input type="number" id="descuento_x1" name="descuento_x1" step="0.01" required>
                    </div>
                </div>
            </div>
            <div>
                <!-- Campo oculto para el ID del producto en caso de edición -->
                <input type="hidden" name="id" id="productId">
                <button type="submit">Guardar Producto</button>
            </div>
        </form>
    </div>
</div>

    <script>
        
/*Modal de ingresar productos*/
function openModal() {
    document.getElementById('productModal').style.display = 'flex';
    document.getElementById('modalTitle').textContent = 'Agregar Producto';
    document.getElementById('productForm').reset();
}

function closeModal() {
    document.getElementById('productModal').style.display = 'none';
}


let originalImages = []; // Para almacenar las rutas originales de las imágenes

function openModal(productId = null) {
    document.getElementById('productModal').style.display = 'flex';
    document.getElementById('modalTitle').textContent = productId ? 'Editar Producto' : 'Agregar Producto';
    
    if (productId) {
        fetch(`get_product.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                // Llenar campos básicos
                document.getElementById('productId').value = data.id;
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('tamaño').value = data.tamaño;
                document.getElementById('cantidad').value = data.cantidad;
                document.getElementById('precio_x1').value = data.precio_x1;
                document.getElementById('descuento_x1').value = data.descuento_x1;
                document.getElementById('marca').value = data.marca;
                document.getElementById('proveedor_id').value = data.proveedor_id;
                document.getElementById('categoria_id').value = data.categoria_id;
                document.getElementById('tipo_fragancia').value = data.tipo_fragancia;

                // Manejar las imágenes
                originalImages = []; // Reiniciar el arreglo
                for (let i = 1; i <= 5; i++) {
                    // Crear campo hidden para cada imagen
                    let hiddenInput = document.getElementById(`imagen_anterior${i}`);
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.id = `imagen_anterior${i}`;
                        hiddenInput.name = `imagen_anterior${i}`;
                        document.getElementById('productForm').appendChild(hiddenInput);
                    }
                    
                    // Guardar la ruta original de la imagen
                    const imagePath = data[`imagen${i}`] || '';
                    hiddenInput.value = imagePath;
                    originalImages.push(imagePath);
                    
                    // Resetear el input file
                    const fileInput = document.getElementById(`imagen${i}`);
                    fileInput.value = '';
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        // Resetear el formulario para nuevo producto
        document.getElementById('productForm').reset();
        originalImages = [];
        
        // Limpiar todos los campos de imagen
        for (let i = 1; i <= 5; i++) {
            const fileInput = document.getElementById(`imagen${i}`);
            fileInput.value = '';
            
            // Limpiar campos hidden si existen
            const hiddenInput = document.getElementById(`imagen_anterior${i}`);
            if (hiddenInput) {
                hiddenInput.value = '';
            }
        }
    }
}

// Función opcional para validar el formulario antes de enviar
function validateForm(event) {
    const formData = new FormData(document.getElementById('productForm'));
    
    // Asegurarse de que las imágenes anteriores se mantengan si no se seleccionaron nuevas
    for (let i = 1; i <= 5; i++) {
        const fileInput = document.getElementById(`imagen${i}`);
        if (!fileInput.files || !fileInput.files[0]) {
            // Si no se seleccionó nueva imagen, usar la original
            formData.set(`imagen${i}`, originalImages[i-1] || '');
        }
    }
    
    // Aquí puedes agregar más validaciones si lo necesitas
    
    return true;
}



        


window.onclick = function(event) {
    if (event.target == document.getElementById('productModal')) {
          closeModal();
         }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.products-table tbody tr');
            rows.forEach((row, index) => {
                setTimeout(() => {
                    row.classList.add('fade-in');
                }, index * 100);
            });
        });

        document.querySelector('.pagination').addEventListener('click', function(e) {
            e.preventDefault();
            if (e.target.tagName === 'A') {
                this.querySelectorAll('a').forEach(link => link.classList.remove('active'));
                if (!e.target.classList.contains('next')) {
                    e.target.classList.add('active');
                }
                console.log('Página seleccionada:', e.target.textContent);
            }
        });
       
    tinymce.init({
    selector: '#editor',
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 14px }',
    height: 400,
    language: 'es',
    branding: false,
    menubar: true,
    setup: function(editor) {
        editor.on('init', function() {
            // Código para cuando el editor se inicializa
        });
    }
});
    
</script>
<script src="products.js"></script>
</body>
</html>
