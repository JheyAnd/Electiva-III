<?php
session_start();

// Verifica si el carrito está presente
if (isset($_SESSION['carrito'])) {
    $arreglo = $_SESSION['carrito'];

    // Recorre el carrito y actualiza la cantidad
    for ($i = 0; $i < count($arreglo); $i++) {
        if ($arreglo[$i]['Id'] == $_POST['id']) {
            $arreglo[$i]['Cantidad'] = $_POST['cantidad'];
            $_SESSION['carrito'] = $arreglo;
            break;
        }
    }

    // Calcula el nuevo total
    $total = 0;
    $iva = 0;

    foreach ($arreglo as $producto) {
        $total += $producto['Precio'] * $producto['Cantidad'];
    }

    // Calcula el IVA (19%)
    $iva = $total * 0.19;

    // Envía la respuesta con los nuevos valores
    $response = array(
        'subtotal' => $total,
        'iva' => $iva,
        'total' => $total + $iva
    );

    // Devuelve la respuesta en formato JSON
    echo json_encode($response);
}
?>
