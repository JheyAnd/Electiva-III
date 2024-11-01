<?php
session_start(); // Asegúrate de que la sesión esté iniciada

require '../vendor/autoload.php';

$config = require 'config.php';

$provider = new League\OAuth2\Client\Provider\Google([
    'clientId'     => $config['google']['client_id'],
    'clientSecret' => $config['google']['client_secret'],
    'redirectUri'  => $config['google']['redirect_uri'],
]);

// Si no hay código de autorización, obtén uno
if (!isset($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState(); // Almacena el estado en la sesión
    header('Location: ' . $authUrl);
    exit;
}
