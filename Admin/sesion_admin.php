<?php
session_start(); // Iniciar sesión
include("../db/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Proteger contra inyección SQL
    $usuario = $conexion->real_escape_string($usuario);

    // Consultar en la base de datos el usuario y la contraseña
    $sql = "SELECT id, nombre, correo, usuario, clave FROM administradores WHERE usuario = '$usuario'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        // Extraer los datos del usuario
        $fila = $resultado->fetch_assoc();

        // Verificar si la contraseña ingresada coincide con el hash almacenado
        if (password_verify($contraseña, $fila['clave'])) {
            // Guardar información del usuario en la sesión
            $_SESSION['usuario'] = $usuario;
            $_SESSION['id_usuario'] = $fila['id'];
            $_SESSION['nombre'] = $fila['nombre']; // Guardar el nombre en la sesión
            $_SESSION['correo'] = $fila['correo']; // Guardar el correo en la sesión

            // Redirigir al panel de administración
            header("Location: index.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "El usuario no existe.";
    }
}
?>