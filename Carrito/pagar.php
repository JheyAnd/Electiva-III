<?php
require __DIR__ . '/../vendor/autoload.php';

MercadoPago\SDK::setAccessToken("APP_USR-5840777523190303-111118-f75d2f1be70839cc791c1b06759f7e35-2089933937"); // Reemplaza con tu token

// Crear preferencia
$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->title = "My product";
$item->quantity = 1;
$item->unit_price = 2000;

$preference->items = array($item);

try {
    $preference->save();
    
    // Verificar si la preferencia tiene un ID
    if (!empty($preference->id)) {
        echo "Preferencia creada con éxito. ID: " . $preference->id;
    } else {
        echo "Hubo un problema al crear la preferencia.";
    }
} catch (Exception $e) {
    echo "Error al crear la preferencia: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago con Mercado Pago</title>
</head>
<body>
    <!-- El formulario ahora no tiene el action, ya que el script de MercadoPago maneja la redirección -->
    <form method="POST">
        <script
            src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js"
            data-preference-id="<?php echo $preference->id; ?>">
        </script>
    </form>
</body>
</html>
