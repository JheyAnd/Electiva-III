<?php
session_start();

include '../db/conexion.php';
if (!isset($_SESSION['carrito'])) {
    header("Location: ../Home/index.php");
}
$total = 0;
$iva = 0;
$totalNuevo = 0;
$arreglo = $_SESSION['carrito'];
for ($i = 0; $i < count($arreglo); $i++) {
    $total += $arreglo[$i]['Precio'] * $arreglo[$i]['Cantidad'];
}
$iva = $total * 0.19;
$totalNuevo = $total + $iva;

$password = "";
if (isset($_POST['c_account_password'])) {
    if ($_POST['c_account_password'] != "") {
        $password = $_POST['c_account_password'];
    }
}
$hash_contraseña = password_hash($password, PASSWORD_ARGON2ID);

// Inserción en la tabla usuarios
$conexion->query("INSERT INTO usuarios (username, password) 
VALUES (
    '" . $_POST['c_fname'] . " " . $_POST['c_lname'] . "',
    '" . $hash_contraseña . "'
)") or die($conexion->error);

$id_usuario = $conexion->insert_id;
$fecha = date('Y-m-d H:i:s');

// Inserción en la tabla ventas
$conexion->query("INSERT INTO ventas(usuario_id, total, fecha)
VALUES ($id_usuario, $totalNuevo, '$fecha')") or die($conexion->error);

$id_ventas = $conexion->insert_id;

// Inserción en la tabla productos_ventas
for ($i = 0; $i < count($arreglo); $i++) {
    $conexion->query("INSERT INTO productos_ventas(id_ventas, id_productos, cantidad, precio, subtotal)
    VALUES (
        $id_ventas,
        " . $arreglo[$i]['Id'] . ",
        " . $arreglo[$i]['Cantidad'] . ",
        " . $arreglo[$i]['Precio'] . ",
        " . $arreglo[$i]['Precio'] * $arreglo[$i]['Cantidad'] . "
    )") or die($conexion->error);

    $conexion->query("UPDATE productos SET cantidad = cantidad - ".$arreglo[$i]['Cantidad']." WHERE id = ".$arreglo[$i]['Id']) or die($conexion->error);

}

// Inserción en la tabla envios
$conexion->query("INSERT INTO envios (pais, direccion, estado, cp, id_ventas) 
VALUES (
    '" . $_POST['country'] . "',
    '" . $_POST['c_address'] . "',
    '" . $_POST['c_state_country'] . "',
    '" . $_POST['c_postal_zip'] . "',
    $id_ventas
)") or die($conexion->error);

// Limpiar carrito
unset($_SESSION['carrito']);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
   <title>Tienda</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/styles.css">
    
  </head>
  <body>
  
  <div class="site-wrap">
   <?php include("./layouts/header.php"); ?> 

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <span class="icon-check_circle display-3 text-success"></span>
            <h2 class="display-3 text-black">Thank you!</h2>
            <p class="lead mb-5">You order was successfuly completed.</p>
            <p><a href="../Home/index.php" class="btn btn-sm btn-primary">Back to shop</a></p>
          </div>
        </div>
      </div>
    </div>

    <?php include("./layouts/footer.php"); ?> 

  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>