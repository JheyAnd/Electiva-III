<?php
// Datos de conexión
$host = "localhost"; // Dirección del servidor de MySQL (puede ser localhost o una IP remota)
$usuario = "root"; // Usuario de MySQL
$contraseña = ""; // Contraseña del usuario
$base_de_datos = "perfumeria"; // Nombre de la base de datos

// Crear la conexión
$conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

?>
