<?php
include("../db/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];
    $email = $_POST['email'];

    // Verificar que las contraseñas coincidan
    if ($contraseña !== $confirmar_contraseña) {
        echo "Las contraseñas no coinciden. Inténtalo de nuevo.";
        exit(); // Terminar el script si las contraseñas no coinciden
    }

    // Proteger contra inyección SQL
    $usuario = $conexion->real_escape_string($usuario);
    $email = $conexion->real_escape_string($email);

    // Generar el hash de la contraseña utilizando Argon2
    $hash_contraseña = password_hash($contraseña, PASSWORD_ARGON2ID);

    // Insertar el nuevo usuario y la contraseña hasheada en la base de datos
    $sql = "INSERT INTO usuarios (username, password, email) VALUES ('$usuario', '$hash_contraseña', '$email')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../Home/index.php");
    } else {
        echo "Error al registrar el usuario: " . $conexion->error;
    }
}
?>
