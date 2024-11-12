<?php
session_start();

if(!isset($_SESSION['carrito'])){
  header('Location: ../Home/index.php');
}
$arreglo = $_SESSION['carrito'];
require __DIR__ . '/../vendor/autoload.php';

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

// Establecer el access token de Mercado Pago (mejor almacenarlo en una variable de entorno)
SDK::setAccessToken("APP_USR-2824503991782324-111119-30bd7af095ddc096af10e258df59645d-2089933937");

$preference = new Preference();
$total = 0;
$iva = 0;
$totalNuevo = 0;
for ($i = 0; $i < count($arreglo); $i++){
$total = $arreglo[$i]['Precio']*$arreglo[$i]['Cantidad'];
$iva = $total * 0.19;
$totalNuevo = $iva + $total;
$item = new Item();
$item->title = $arreglo[$i]['Nombre'];
$item->quantity = $arreglo[$i]['Cantidad'];
$item->unit_price = $totalNuevo;
}
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
<html lang="en">
  <head>
    <title>Shoppers &mdash; Colorlib e-Commerce Template</title>
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
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <link rel="stylesheet" href="css/styles.css">
    
  </head>
  <body>
  
  <div class="site-wrap">
    <?php include("./layouts/header.php"); ?> 
    <form action="thankyou.php" method="post">
    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-12">
            <div class="border p-4 rounded" role="alert">
              Returning customer? <a href="#">Click here</a> to login
            </div>
          </div>
        </div>
        <div class="row">
          
          <div class="col-md-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black">Billing Details</h2>
            <div class="p-3 p-lg-5 border">
              <div class="form-group">
                <label for="c_country" class="text-black">Country <span class="text-danger">*</span></label>
                <select id="c_country" class="form-control" name="country">
                  <option value="">Select a country</option>    
                  <option value="Colombia">Colombia</option>    
                      
                </select>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_fname" name="c_fname">
                </div>
                <div class="col-md-6">
                  <label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_lname" name="c_lname">
                </div>
              </div>


              <div class="form-group row">
                <div class="col-md-12">
                  <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Street address">
                </div>
              </div>


              <div class="form-group row">
                <div class="col-md-6">
                  <label for="c_state_country" class="text-black">State / Country <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_state_country" name="c_state_country">
                </div>
                <div class="col-md-6">
                  <label for="c_postal_zip" class="text-black">Posta / Zip <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip">
                </div>
              </div>

              <div class="form-group row mb-5">
                <div class="col-md-6">
                  <label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_email_address" name="c_email_address">
                </div>
                <div class="col-md-6">
                  <label for="c_phone" class="text-black">Phone <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_phone" name="c_phone" placeholder="Phone Number">
                </div>
              </div>

              <div class="form-group">
                <label for="c_create_account" class="text-black" data-toggle="collapse" href="#create_an_account" role="button" aria-expanded="false" aria-controls="create_an_account"><input type="checkbox" value="1" id="c_create_account"> Create an account?</label>
                <div class="collapse" id="create_an_account">
                  <div class="py-2">
                    <p class="mb-3">Create an account by entering the information below. If you are a returning customer please login at the top of the page.</p>
                    <div class="form-group">
                      <label for="c_account_password" class="text-black">Account Password</label>
                      <input type="password" class="form-control" id="c_account_password" name="c_account_password"  placeholder="">
                    </div>
                  </div>
                </div>
              </div>


              
              <div class="form-group">
                <label for="c_order_notes" class="text-black">Order Notes</label>
                <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>
              </div>

            </div>
          </div>
          <div class="col-md-6">

            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Coupon Code</h2>
                <div class="p-3 p-lg-5 border">
                  
                  <label for="c_code" class="text-black mb-3">Enter your coupon code if you have one</label>
                  <div class="input-group w-75">
                    <input type="text" class="form-control" id="c_code" placeholder="Coupon Code" aria-label="Coupon Code" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-sm" type="button" id="button-addon2">Apply</button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            
            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Your Order</h2>
                <div class="p-3 p-lg-5 border">
                  <table class="table site-block-order-table mb-5">
                    <thead>
                      <th>Product</th>
                      <th>Total</th>
                    </thead>
                    <tbody>
                      <?php
                          $total = 0;
                          for($i=0;$i<count($arreglo);$i++){
                            $total = $total+ ($arreglo[$i]['Precio']*$arreglo[$i]['Cantidad']);
                          

                      ?>
                      <tr>
                        <td><?php echo $arreglo[$i]['Nombre'] ?><strong class="mx-2">x</strong> <?php echo $arreglo[$i]['Cantidad'];?></td>
                        <td><?php echo number_format( $arreglo[$i]['Precio']); ?></td>
                      </tr>
                        <?php 
                       }
                      ?>
                       <tr>
                        <td>IVA % 19 <strong class="mx-2"></td>
                        <td>$<?php echo number_format ($iva= ($total*0.19),2)?></td>
                      </tr>
                      <tr>
                        <td>Order Total<strong class="mx-2"></td>
                        <td>$<?php echo number_format ($iva + $total,2)?></td>
                      </tr>
                    </tbody>

                  </table>


                  <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsecheque" role="button" aria-expanded="false" aria-controls="collapsecheque">Cheque Payment</a></h3>

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
                  </div>

                  <div class="form-group">
                    <button class="btn btn-primary btn-lg py-3 btn-block"type = "submit">Place Order</button>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>
        
        <!-- </form> -->
      </div>
    </div>
    </form>
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