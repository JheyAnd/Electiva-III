<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión activa, redirigir al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h2>
    <p>Has iniciado sesión correctamente.</p>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>
