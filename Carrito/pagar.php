<?php
require __DIR__ . '/../vendor/autoload.php';

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

// Establecer el access token de Mercado Pago (mejor almacenarlo en una variable de entorno)
SDK::setAccessToken("APP_USR-2824503991782324-111119-30bd7af095ddc096af10e258df59645d-2089933937");

$preference = new Preference();

// Crear el item que se va a pagar
$item = new Item();
$item->title = "Producto de Ejemplo";
$item->quantity = 1;
$item->unit_price = 2000;

// Agregar los items a la preferencia
$preference->items = array($item);

try {
    // Guardar la preferencia
    $preference->save();

    if (!empty($preference->id)) {
        $preference_id = $preference->id;
    } else {
        throw new Exception("Hubo un problema al crear la preferencia.");
    }
} catch (Exception $e) {
    // Mostrar errores más detallados
    echo "Error al crear la preferencia: " . $e->getMessage();
    var_dump($preference); // Puedes revisar qué contiene el objeto $preference
    $preference_id = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago con Mercado Pago</title>
    <!-- Cargar el SDK de Mercado Pago -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>

    <?php if ($preference_id): ?>
        <!-- Contenedor donde se mostrará el brick de Wallet -->
        <div id="wallet_container"></div>

        <script>
            // Inicializar Mercado Pago con tu Public Key
            const mp = new MercadoPago('APP_USR-57551004-1297-4757-b51e-69b58f06dcaa'); // Reemplaza con tu Public Key

            // Crear el brick de Wallet
            mp.bricks().create("wallet", "wallet_container", {
                initialization: {
                    preferenceId: "<?php echo $preference_id; ?>", // El ID de la preferencia generada desde PHP
                },
                customization: {
                    texts: {
                        valueProp: 'smart_option', // Personaliza el texto que aparece en el brick
                    },
                },
            });
        </script>
    <?php else: ?>
        <p>Hubo un problema al generar la preferencia de pago. Inténtalo más tarde.</p>
    <?php endif; ?>

</body>
</html>
