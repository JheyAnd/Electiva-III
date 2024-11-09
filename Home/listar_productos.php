<?php
// Iniciar sesión si es necesario
//session_start();

// Incluir el archivo de conexión a la base de datos
include("../db/conexion.php");

// Consulta para obtener todos los productos
$consulta = "SELECT id, nombre, precio_x1 AS precio, imagen1 AS imagen, imagen2 FROM productos ORDER BY nombre";
$resultado = $conexion->query($consulta);

$productos = [];

// Verificar si hay resultados y agregarlos al arreglo
if ($resultado->num_rows > 0) {
    while ($producto = $resultado->fetch_assoc()) {
        $productos[] = $producto;
    }
}

// Cerrar la conexión
$conexion->close();
?>
