<?php
session_start(); // Iniciar sesión
include("../db/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Proteger contra inyección SQL
    $usuario = $conexion->real_escape_string($usuario);

    // Consultar en la base de datos el usuario y el tipo de usuario
    $sql = "SELECT id, username, password, tipo_usuario FROM usuarios WHERE username = '$usuario'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        // Extraer los datos del usuario
        $fila = $resultado->fetch_assoc();

        // Verificar si la contraseña ingresada coincide con el hash almacenado
        if (password_verify($contraseña, $fila['password'])) {
            // Guardar información del usuario en la sesión
            $_SESSION['usuario'] = $usuario;
            $_SESSION['id_usuario'] = $fila['id'];
            $_SESSION['tipo_usuario'] = $fila['tipo_usuario']; // Guardar el tipo de usuario en la sesión

            // Redirigir según el tipo de usuario
            switch ($fila['tipo_usuario']) {
                case 2: // Vendedor
                    header("Location: vendedor_dashboard.php"); // Cambia la ruta si es necesario
                    break;
                case 3: // Cliente
                    header("Location: ../Home/index.php");
                    break;
                default:
                    echo "Tipo de usuario no reconocido.";
                    break;
            }
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "El usuario no existe.";
    }
}
?>
