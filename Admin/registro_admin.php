<?php
session_start();
include("../db/conexion.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL); // Habilitar la visualización de todos los errores
ini_set('display_errors', 1); // Configurar para mostrar los errores en la salida

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

header('Content-Type: application/json'); // Establece la respuesta en formato JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extraer los datos del formulario
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $contraseña = $_POST['contraseña'] ?? '';
    $cedula = trim($_POST['cedula'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');

    // Validar campos requeridos
    if (empty($nombre) || empty($correo) || empty($usuario) || empty($contraseña) || empty($cedula) || empty($telefono)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
        exit();
    }

    // Validación de contraseña
    $forbiddenWords = ["admin", "administrador"];
    if (strlen($contraseña) < 8 || !preg_match('/[a-zA-Z]/', $contraseña) || !preg_match('/\d/', $contraseña) || !preg_match('/[\W_]/', $contraseña) ||
        array_filter($forbiddenWords, fn($word) => stripos($contraseña, $word) !== false)) {
        echo json_encode([
            "success" => false,
            "message" => "La contraseña debe tener al menos 8 caracteres, incluir letras, números y caracteres especiales, y no debe contener palabras como 'admin' o 'administrador'."
        ]);
        exit();
    }

    // Proteger contra inyección SQL
    $usuario = $conexion->real_escape_string($usuario);
    $correo = $conexion->real_escape_string($correo);
    $nombre = $conexion->real_escape_string($nombre);
    $cedula = $conexion->real_escape_string($cedula);
    $telefono = $conexion->real_escape_string($telefono);

    // Usar Argon2 para el hash de la contraseña
    $contraseña_hash = password_hash($contraseña, PASSWORD_ARGON2ID);
    $token_verificacion = bin2hex(random_bytes(16));
    $codigo_verificacion = rand(100000, 999999);

    // Verificar si el usuario ya existe
    $sql_check = "SELECT id FROM administradores WHERE usuario = '$usuario' OR correo = '$correo'";
    $resultado_check = $conexion->query($sql_check);

    if ($resultado_check->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "El usuario o correo ya existe."]);
        exit();
    }

    // Insertar el nuevo administrador en la base de datos
    $sql_insert = "INSERT INTO administradores (nombre, correo, usuario, clave, cedula, telefono, verificado, codigo_verificacion, token_verificacion) 
                   VALUES ('$nombre', '$correo', '$usuario', '$contraseña_hash', '$cedula', '$telefono', 0, '$codigo_verificacion', '$token_verificacion')";

    if ($conexion->query($sql_insert) !== TRUE) {
        echo json_encode(["success" => false, "message" => "Error: " . $conexion->error]);
        exit();
    }
    // Guardar el correo en la sesión
    
    $_SESSION['correo'] = $correo;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['usuario'] = $usuario;
    // Configuración para enviar el correo con PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'esensesimperial@gmail.com';
        $mail->Password = 'a n b p p s n y w n p g h t i l'; // Asegúrate de que esta sea una contraseña segura
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('esensesimperial@gmail.com', 'Imperial Essences');
        $mail->addAddress($correo, $nombre);
        $enlace_verificacion = "verificar.php?token=$token_verificacion";
        $mensaje_personalizado = "<p>¡Hola $nombre!</p><p>Gracias por registrarte en nuestra plataforma. Por favor, verifica tu cuenta utilizando el código que te proporcionamos abajo.</p>";
        $codigo_verificacion_html = "<p>Tu código de verificación es: <strong>$codigo_verificacion</strong></p>";
        $mensaje_personalizado .= "<p>Si no ingresaste el código, puedes verificar tu cuenta haciendo clic en este <a href='$enlace_verificacion'>enlace de verificación</a>.</p>";

        $mail->isHTML(true);
        $mail->Subject = 'Verificación de cuenta - Admin';
        $mail->Body = $mensaje_personalizado . $codigo_verificacion_html . "<p>Si no has solicitado esta verificación, ignora este correo.</p>";
        $mail->AltBody = "Hola $nombre,\n\nGracias por registrarte en nuestra plataforma. Tu código de verificación es: $codigo_verificacion.\nSi no solicitaste esta verificación, ignora este correo.";

        $mail->send();

        echo json_encode(["success" => true, "message" => "Correo de verificación enviado a $correo.", "correo" => $correo]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "No se pudo enviar el correo. Error: {$mail->ErrorInfo}"]);
    }
}
?>
