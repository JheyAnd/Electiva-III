<?php
// Iniciar la sesión
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir a la página de inicio de sesión
header("Location: login.php"); // Cambia "login.php" por la URL de la página de inicio de sesión que uses
exit();
?>
