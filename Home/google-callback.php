<?php
session_start();

require '../vendor/autoload.php';
require '../db/conexion.php'; // Incluye la conexión a la base de datos

$config = require 'config.php';

$provider = new League\OAuth2\Client\Provider\Google([
    'clientId'     => $config['google']['client_id'],
    'clientSecret' => $config['google']['client_secret'],
    'redirectUri'  => $config['google']['redirect_uri'],
]);

if (!isset($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
}

if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Estado inválido');
}

try {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    $user = $provider->getResourceOwner($token);

    // Obtiene los detalles del usuario
    $nombre = $user->getName(); // Obtén el nombre
    $correo = $user->getEmail(); // Obtén el correo

    // Prepara la consulta para insertar o actualizar el usuario
    $stmt = $conexion->prepare("INSERT INTO usuarios (username, email) VALUES (?, ?) 
                                 ON DUPLICATE KEY UPDATE username = VALUES(username)");
    $stmt->bind_param("ss", $nombre, $correo);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Almacena la información del usuario en la sesión
        $_SESSION['user'] = $user->toArray();

        header('Location: index.php');
        exit;
    } else {
        exit('Error al guardar el usuario: ' . $stmt->error);
    }

} catch (\Exception $e) {
    exit('Error: ' . $e->getMessage());
}
