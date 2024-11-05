<?php
session_start();
include("../db/conexion.php");

header('Content-Type: application/json'); // Establece la respuesta en formato JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extraer el código y el correo de sesión
    $codigo = trim($_POST['codigo'] ?? '');
    $correo = $_SESSION['correo'] ?? '';

    // Validar el código y el correo
if (empty($correo) && empty($codigo)) {
    echo json_encode(["success" => false, "message" => "El código de verificación y el correo son obligatorios."]);
    exit();
} elseif (empty($correo)) {
    echo json_encode(["success" => false, "message" => "El correo es obligatorio."]);
    exit();
} elseif (empty($codigo)) {
    echo json_encode(["success" => false, "message" => "El código de verificación es obligatorio."]);
    exit();
}


    // Preparar y ejecutar la consulta para verificar el código
    $stmt = $conexion->prepare("SELECT id FROM administradores WHERE correo = ? AND codigo_verificacion = ?");
    $stmt->bind_param("ss", $correo, $codigo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Actualizar la cuenta como verificada
        $stmt_update = $conexion->prepare("UPDATE administradores SET verificado = 1, codigo_verificacion = NULL WHERE correo = ?");
        $stmt_update->bind_param("s", $correo);
        $stmt_update->execute();

        echo json_encode(["success" => true, "message" => "Cuenta verificada exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Código de verificación incorrecto."]);
    }
}
?>
