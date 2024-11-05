<?php
session_start();
include("db/conexion.php");

header('Content-Type: application/json'); // Respuesta en formato JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leer los datos JSON enviados
    $data = json_decode(file_get_contents("php://input"), true);
    $token = $data['token'] ?? '';
    $codigo = $data['codigo'] ?? '';

    // Validar token y código
    if (empty($token) || empty($codigo)) {
        echo json_encode(["success" => false, "message" => "El código y el token son obligatorios."]);
        exit();
    }

    // Preparar y ejecutar la consulta para verificar el token y el código
    $stmt = $conexion->prepare("SELECT id FROM administradores WHERE token_verificacion = ? AND codigo_verificacion = ? AND verificado = 0");
    $stmt->bind_param("ss", $token, $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Marcar la cuenta como verificada
        $stmt_update = $conexion->prepare("UPDATE administradores SET verificado = 1, token_verificacion = NULL WHERE token_verificacion = ?");
        $stmt_update->bind_param("s", $token);
        $stmt_update->execute();

        echo json_encode(["success" => true, "message" => "¡Cuenta activada con éxito! Ahora puedes iniciar sesión."]);
    } else {
        echo json_encode(["success" => false, "message" => "El código o el token son incorrectos o la cuenta ya está verificada."]);
    }
} else {
    // Verificar si el token está presente en la URL para mostrar el formulario
    if (isset($_GET['token'])) {
        $token = htmlspecialchars($_GET['token']);
        echo "
        <div class='verification-container'>
            <form id='verificationForm' method='POST' class='verification-form'>
                <h2>Verificación de cuenta</h2>
                <input type='hidden' name='token' value='$token'>
                <label for='codigo'>Código de verificación:</label>
                <input type='text' id='codigo' name='codigo' required placeholder='Ingresa el código aquí'>
                <button type='button' onclick='verifyAccount()' class='verify-button'>Verificar cuenta</button>
            </form>
        </div>
        <script>
            async function verifyAccount() {
                const token = document.querySelector('input[name=\"token\"]').value;
                const codigo = document.getElementById('codigo').value;

                const response = await fetch('verificar.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ token, codigo })
                });
                
                const result = await response.json();
                alert(result.message); // Muestra el mensaje de éxito o error
            }
        </script>";
    } else {
        echo "<p class='error-message'>Token de verificación no válido.</p>";
    }
}
?>

<style>
    /* Estilos generales */
    body {
        font-family: Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
        background-color: #f3f4f6;
    }

    .verification-container {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 400px;
        width: 90%;
        margin: 20px;
    }

    .verification-form h2 {
        text-align: center;
        color: #333333;
        margin-bottom: 20px;
    }

    .verification-form label {
        font-size: 0.9em;
        color: #555555;
    }

    .verification-form input[type="text"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0 20px 0;
        border: 1px solid #dddddd;
        border-radius: 5px;
    }

    .verify-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        width: 100%;
        border: none;
        border-radius: 5px;
        font-size: 1em;
        cursor: pointer;
    }

    .verify-button:hover {
        background-color: #45a049;
    }

    /* Mensajes de error y éxito */
    .success-message {
        color: #2d862d;
        background-color: #e6f5e6;
        padding: 15px;
        border: 1px solid #2d862d;
        border-radius: 5px;
        text-align: center;
    }

    .error-message {
        color: #a94442;
        background-color: #f2dede;
        padding: 15px;
        border: 1px solid #a94442;
        border-radius: 5px;
        text-align: center;
    }

    /* Adaptabilidad para dispositivos móviles */
    @media (max-width: 768px) {
        .verification-container {
            width: 100%;
            padding: 15px;
        }

        .verification-form h2 {
            font-size: 1.2em;
        }

        .verify-button {
            font-size: 0.9em;
        }
    }
</style>
