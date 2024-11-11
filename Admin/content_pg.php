<?php
// Conexión a la base de datos
require '../db/conexion.php';

// Función para agregar nuevo contenido de página
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $nit_producto = $_POST['productNit'];
    $parte_pagina = $_POST['pagePart'];

    // Verificar que el NIT del producto exista en la tabla productos
    $checkSql = $conexion->prepare("SELECT nit FROM productos WHERE nit = ?");
    $checkSql->bind_param("s", $nit_producto);
    $checkSql->execute();
    $checkResult = $checkSql->get_result();

    if ($checkResult->num_rows > 0) {
        // El NIT existe, agregamos el contenido
        $insertSql = $conexion->prepare("INSERT INTO cp (nit, contenido_pg) VALUES (?, ?)");
        $insertSql->bind_param("ss", $nit_producto, $parte_pagina);
        
        if ($insertSql->execute()) {
            echo json_encode(["status" => "success", "message" => "Contenido agregado exitosamente."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al agregar contenido: " . $conexion->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "El NIT no existe en la base de datos de productos."]);
    }
}

// Función para editar contenido de página
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = (int)$_POST['id'];
    $nit_producto = $conexion->real_escape_string($_POST['productNit']);
    $parte_pagina = $conexion->real_escape_string($_POST['pagePart']);

    // Verificar que el NIT del producto exista en la tabla productos
    $checkSql = "SELECT nit FROM productos WHERE nit = '$nit_producto'";
    $checkResult = $conexion->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // El NIT existe, actualizamos el contenido
        $updateSql = "UPDATE cp SET nit = '$nit_producto', contenido_pg = '$parte_pagina' WHERE id = $id";
        if ($conexion->query($updateSql) === TRUE) {
            echo "Contenido actualizado exitosamente.";
        } else {
            echo "Error al actualizar contenido: " . $conexion->error;
        }
    } else {
        echo "El NIT no existe en la base de datos de productos.";
    }
}

// Función para eliminar contenido de página
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];

    $deleteSql = "DELETE FROM cp WHERE id = $id";
    if ($conexion->query($deleteSql) === TRUE) {
        echo "Contenido eliminado exitosamente.";
    } else {
        echo "Error al eliminar contenido: " . $conexion->error;
    }
}

// Función para buscar contenido de página por NIT
if (isset($_POST['action']) && $_POST['action'] === 'search') {
    $nit_producto = $conexion->real_escape_string($_POST['productNit']);

    // Realizar búsqueda por NIT en la tabla cp
    $searchSql = "SELECT * FROM cp WHERE nit LIKE '%$nit_producto%'";
    $result = $conexion->query($searchSql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='fade-in'>
                    <td>{$row['id']}</td>
                    <td>{$row['nit']}</td>
                    <td>{$row['contenido_pg']}</td>
                    <td>
                        <button class='btn btn-edit' onclick='editContent({$row['id']})'>Editar</button>
                        <button class='btn btn-delete' onclick='deleteContent({$row['id']})'>Eliminar</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No se encontraron resultados.</td></tr>";
    }
}



// Realizar consulta para obtener productos con sus imágenes y otros datos
$sql = "SELECT cp.id, cp.nit, cp.contenido_pg, productos.nombre, productos.precio_x1 AS precio, productos.descuento_x1 AS descuento, productos.imagen1, productos.imagen2
        FROM cp
        INNER JOIN productos ON cp.nit = productos.nit where cp.contenido_pg = 'Hot Dells'";
$result = $conexion->query($sql);

$sql2 = "SELECT cp.id, cp.nit, cp.contenido_pg, productos.nombre, productos.precio_x1 AS precio, productos.descuento_x1 AS descuento, productos.imagen1, productos.imagen2
        FROM cp
        INNER JOIN productos ON cp.nit = productos.nit where cp.contenido_pg = 'Best Sellers'";
$result2 = $conexion->query($sql2);

$sql3 = "SELECT cp.id, cp.nit, cp.contenido_pg, productos.nombre, productos.precio_x1 AS precio, productos.descuento_x1 AS descuento, productos.imagen1, productos.imagen2
        FROM cp
        INNER JOIN productos ON cp.nit = productos.nit where cp.contenido_pg = 'On Sale'";
$result3 = $conexion->query($sql3);



?>