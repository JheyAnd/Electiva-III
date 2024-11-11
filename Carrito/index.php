<?php  
session_start();

include ("../db/conexion.php");

// Verifica si el carrito existe y si se ha pasado un ID de producto
if (isset($_SESSION['carrito'])) {
    if (isset($_GET['id'])) {
        $arreglo = $_SESSION['carrito'];
        $encontro = false;
        $numero = 0;
        
        // Recorre el carrito para encontrar el producto
        for ($i = 0; $i < count($arreglo); $i++) {
            if ($arreglo[$i]['Id'] == $_GET['id']) {
                $encontro = true;
                $numero = $i;
            }
        }

        if ($encontro) {
            // Verifica si se pasó el parámetro 'accion=incrementar' en la URL
            if (isset($_GET['accion']) && $_GET['accion'] == 'incrementar') {
                // Incrementa la cantidad solo si se pide explícitamente
                $arreglo[$numero]['Cantidad'] += 1;
                $_SESSION['carrito'] = $arreglo;
            }
        } else {
            // Producto nuevo en el carrito
            $nombre = '';
            $precio = 0;
            $imagen = '';
            $res = $conexion->query("SELECT * FROM productos WHERE id = ".$_GET['id']) or die($conexion->error);
            $fila = mysqli_fetch_row($res);
            $nombre = $fila[1];
            $precio = $fila[9];
            $imagen = $fila[12];

            $arregloNuevo = array(
                'Id' => $_GET['id'],
                'Nombre' => $nombre,
                'Precio' => $precio,
                'Imagen' => $imagen,
                'Cantidad' => 1
            );

            array_push($arreglo, $arregloNuevo);
            $_SESSION['carrito'] = $arreglo;
        }
    }
} else {
    if (isset($_GET['id'])) {
        $nombre = '';
        $precio = 0;
        $imagen = '';
        $res = $conexion->query("SELECT * FROM productos WHERE id = ".$_GET['id']) or die($conexion->error);
        $fila = mysqli_fetch_row($res);
        $nombre = $fila[1];
        $precio = $fila[9];
        $imagen = $fila[12];
        
        $arreglo[] = array(
            'Id' => $_GET['id'],
            'Nombre' => $nombre,
            'Precio' => $precio,
            'Imagen' => $imagen,
            'Cantidad' => 1
        );
        
        $_SESSION['carrito'] = $arreglo;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tienda </title>
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
        <div class="row mb-5">
          <form class="col-md-12" method="post">
            <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        $total = 0;
                        if(isset($_SESSION['carrito'])){

                            $arregloCarrito = $_SESSION['carrito'];
                            for($i = 0; $i<count($arregloCarrito);$i++){
                                $total = $total + ($arregloCarrito[$i]['Precio']*$arregloCarrito[$i]['Cantidad']);
                            ?>
                        
                  <tr>
                    <td class="product-thumbnail">
                      <img src="../Admin/<?php echo $arregloCarrito[$i]['Imagen'];?>" alt="Image" class="img-fluid">
                    </td>
                    <td class="product-name">
                      <h2 class="h5 text-black"><?php echo $arregloCarrito[$i]['Nombre'];?></h2>
                    </td>
                    <td><?php echo number_format($arregloCarrito[$i]['Precio'], 2); ?></td>
                    <td>
                      <div class="input-group mb-3" style="max-width: 120px;">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-primary js-btn-minus btnIncrementar"  type="button">&minus;</button>
                        </div>
                        <input type="text" class="form-control text-center txtCantidad btnIncrementar"
                        data-precio="<?php echo $arregloCarrito[$i]['Precio'];?>"
                        data-id="<?php echo $arregloCarrito[$i]['Id'];?>" 
                        value="<?php echo $arregloCarrito[$i]['Cantidad'];?>" 
                        placeholder="" aria-label="Example text with button addon" 
                        aria-describedby="button-addon1">
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary js-btn-plus btnIncrementar" type="button">&plus;</button>
                        </div>
                      </div>

                    </td>
                    <td class="canti<?php echo $arregloCarrito[$i]['Id'];?>">
                        $<?php echo number_format($arregloCarrito[$i]['Precio']*$arregloCarrito[$i]['Cantidad'],2);?></td>
                    <td><a href="#" class="btn btn-primary btn-sm btnEliminar" data-id= "<?php echo $arregloCarrito[$i]['Id'] ?>">X</a></td>
                  </tr>
                  <?php }} ?>
                </tbody>
              </table>
            </div>
          </form>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-6 mb-3 mb-md-0">
                <button class="btn btn-primary btn-sm btn-block">Update Cart</button>
              </div>
              <div class="col-md-6">
                <button class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="text-black h4" for="coupon">Coupon</label>
                <p>Enter your coupon code if you have one.</p>
              </div>
              <div class="col-md-8 mb-3 mb-md-0">
                <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary btn-sm">Apply Coupon</button>
              </div>
            </div>
          </div>
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                  </div>
                </div>
                <div class="row mb-3">
    <div class="col-md-6">
        <span class="text-black">Subtotal</span>
    </div>
    <div class="col-md-6 text-right">
        <strong class="text-black subtotal"><?php echo number_format($total, 2); ?></strong>
    </div>
    <div class="col-md-6">
        <span class="text-black">IVA % 19</span>
    </div>
    <div class="col-md-6 text-right">
        <strong class="text-black iva"><?php echo number_format($iva = ($total * 0.19), 2); ?></strong>
    </div>
</div>
<div class="row mb-5">
    <div class="col-md-6">
        <span class="text-black">Total</span>
    </div>
    <div class="col-md-6 text-right">
        <strong class="text-black total"><?php echo number_format(($iva + $total), 2); ?></strong>
    </div>
</div>


                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary btn-lg py-3 btn-block" onclick="window.location='checkout.php'">Proceed To Checkout</button>
                  </div>
                </div>
              </div>
            </div>
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
  <script>
   $(document).ready(function(){
    // Eliminar producto del carrito
    $(".btnEliminar").click(function(event){
        event.preventDefault();
        var id = $(this).data('id');
        var boton = $(this);
        $.ajax({
            method : 'post',
            url: 'eliminarCarrito.php',
            data: { id: id }
        }).done(function(respuesta){
            alert(respuesta)
            boton.parent('td').parent('tr').remove();
            actualizarCarrito(); // Actualizar carrito después de eliminar producto
        });
    });

    // Incrementar o disminuir la cantidad
    $(".btnIncrementar").click(function(){
        var inputCantidad = $(this).parent('div').parent('div').find('input');
        var precio = inputCantidad.data('precio');
        var id = inputCantidad.data('id');
        var cantidad = parseInt(inputCantidad.val());

        // Verificar si es decrementar o incrementar
        if ($(this).hasClass('js-btn-plus')) {
            cantidad += 1;
        } else if ($(this).hasClass('js-btn-minus') && cantidad > 1) {
            cantidad -= 1;
        }

        inputCantidad.val(cantidad); // Actualiza el input de cantidad
        actualizarCarritoProducto(cantidad, precio, id); // Llamar función para actualizar carrito
    });

    // Función para actualizar el producto en el carrito
    function actualizarCarritoProducto(cantidad, precio, id) {
        var mult = cantidad * precio;
        $(".canti" + id).text("$" + mult.toFixed(2)); // Actualiza el subtotal de ese producto

        $.ajax({
            method: 'post',
            url: 'actualizarCarrito.php',
            data: { id: id, cantidad: cantidad }
        }).done(function(respuesta) {
            var resultado = JSON.parse(respuesta);

            // Actualiza los valores del subtotal, IVA y total
            $(".subtotal").text("$" + resultado.subtotal.toFixed(2));
            $(".iva").text("$" + resultado.iva.toFixed(2));
            $(".total").text("$" + resultado.total.toFixed(2));
        });
    }

    // Función para actualizar todo el carrito
    function actualizarCarrito() {
        $.ajax({
            method: 'post',
            url: 'actualizarCarrito.php', // Asumiendo que 'actualizarCarrito.php' también maneja la actualización completa
            data: {} // Sin parámetros adicionales, solo actualizamos el carrito
        }).done(function(respuesta) {
            var resultado = JSON.parse(respuesta);

            $(".subtotal").text("$" + resultado.subtotal.toFixed(2));
            $(".iva").text("$" + resultado.iva.toFixed(2));
            $(".total").text("$" + resultado.total.toFixed(2));
        });
    }
});

  </script>
    
  </body>
</html>