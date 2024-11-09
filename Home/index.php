<?php
include ("../db/conexion.php");

// Consulta para obtener todas las categorías
$consultaCategorias = "SELECT id, nombre FROM categorias";
$resultadoCategorias = $conexion->query($consultaCategorias);

// Arreglo para almacenar las categorías y sus productos
$categorias = [];

// Verificar si hay resultados en categorías
if ($resultadoCategorias->num_rows > 0) {
    // Llenar el arreglo con las categorías
    while ($categoria = $resultadoCategorias->fetch_assoc()) {
        $categorias[$categoria['id']] = [
            'nombre' => $categoria['nombre'],
            'productos' => []
        ];
    }
}

// Consulta para obtener todos los productos con su categoría correspondiente
$consultaProductos = "SELECT p.id, p.nombre, p.descripcion, p.precio_x1, p.imagen1,p.imagen2, p.categoria_id
                      FROM productos p
                      INNER JOIN categorias c ON p.categoria_id = c.id";
$resultadoProductos = $conexion->query($consultaProductos);

// Verificar si hay resultados en productos
if ($resultadoProductos->num_rows > 0) {
    // Llenar los productos en el arreglo de categorías
    while ($producto = $resultadoProductos->fetch_assoc()) {
        $categorias[$producto['categoria_id']]['productos'][] = $producto;
    }
}

// Cerrar la conexión
$conexion->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfume | E-Commerce</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div class="off_canvars_overlay"></div>

    <div class="offcanvas_menu offcanvas_two">
        <div class="canvas_open">
            <a href="javascript:void(0)"><i class="fa fa-bars"></i></a>
        </div>
        <div class="offcanvas_menu_wrapper">
            <div class="canvas_close">
                <a href="javascript:void(0)"><i class="fa fa-times"></i></a>
            </div>
            <div class="header_account">
                <ul>
                    <li class="language">
                        <a href="#"><img src="images/icon/language.png" alt="English"> EN <i
                                class="fa fa-angle-down"></i></a>
                        <ul class="dropdown_language">
                            <li><a href="#">Spain</a></li>                            
                        </ul>
                    </li>
                    <li class="currency">
                        <a href="#">COP <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown_currency">
                            <li><a href="#">US - EEUU </a></li>
                            
                            
                        </ul>
                    </li>
                    <li class="top_links">
                        <a href="#">My Account <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown_links">
                            <li><a href="#">Checkout</a></li>
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Shopping Cart</a></li>
                            <li><a href="#">Wishlist</a></li>
                        </ul>
                    </li>

                </ul>
            </div>

            <div class="header_right_info">
                <ul>
                    <li class="search_box">
                        <a href="javascript:void(0)"><i class="fa fa-search"></i></a>
                        <div class="search_widget">
                            <form action="#">
                                <input type="text" placeholder="Search Your Perfume">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </li>
                    <li class="header_wishlist">
                        <a href="#"><i class="fa fa-heart-o"></i>
                            <span class="item_count">4</span>
                        </a>
                    </li>
                    <li class="mini_cart_wrapper">
                        <a href="javascript:void(0)">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="item_count">2</span>
                        </a>
                        <div class="mini_cart mini_cart2">
                            <div class="cart_gallery">
                                <div class="cart_item">
                                    <div class="cart_img">
                                        <a href="#"><img src="images/small-product/mini1.png" alt="Perfume"></a>
                                    </div>
                                    <div class="cart_info">
                                        <a href="#">Hugo Boss</a>
                                        <p><span>COP 3640</span> X 1</p>
                                    </div>
                                    <div class="cart_remove">
                                        <a href="#"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="cart_item">
                                    <div class="cart_img">
                                        <a href="#"><img src="images/small-product/mini2.png" alt="Perfume"></a>
                                    </div>
                                    <div class="cart_info">
                                        <a href="#">Bvlgari</a>
                                        <p><span>COP 8350</span> X 1</p>
                                    </div>
                                    <div class="cart_remove">
                                        <a href="#"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mini_cart_table">
                                <div class="cart_table_border">
                                    <div class="cart_total">
                                        <span>Sub Total :</span>
                                        <span class="price">COP 11990</span>
                                    </div>

                                    <div class="cart_total mt-10">
                                        <span>Total :</span>
                                        <span class="price">COP 11990</span>
                                    </div>

                                </div>
                            </div>
                            <div class="mini_cart_footer">
                                <div class="cart_button">
                                    <a href="../Carrito/index.php">View Cart</a>
                                </div>
                                <div class="cart_button">
                                    <a href="#">Checkout</a>
                                </div>
                            </div>
                        </div>
                        <!-- mini cart ends here -->
                    </li>
                </ul>
            </div>

            <div id="menu" class="text-left">
                <ul class="offcanvas_main_menu">
                    <li class="menu-item-has-children active">
                        <a href="#">Home</a>
                        <ul class="sub-menu">
                            <li><a href="#">Men</a></li>
                            <li><a href="#">Women</a></li>
                            <li><a href="#">Unisex</a></li>
                            <li><a href="#">Kids</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">Brands</a>
                        <ul class="sub-menu">
                            <li class="menu-item-has-children">
                                <a href="#">Men</a>
                                <ul class="sub-menu">
                                    <li><a href="#">Versace</a></li>
                                    <li><a href="#">Hugo Boss</a></li>
                                    <li><a href="#">Jaguar</a></li>
                                    <li><a href="#">Armani</a></li>
                                    <li><a href="#">Paco Rabbane</a></li>
                                    <li><a href="#">Ralph Lauren</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Women</a>
                                <ul class="sub-menu">
                                    <li><a href="#">Bvlgari</a></li>
                                    <li><a href="#">Coach</a></li>
                                    <li><a href="#">Kenzo</a></li>
                                    <li><a href="#">D&G</a></li>
                                    <li><a href="#">Jean Paul Gaultier</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Unisex</a>
                                <ul class="sub-menu">
                                    <li><a href="#">Ajmal</a></li>
                                    <li><a href="#">Calvin Klein</a></li>
                                    <li><a href="#">The Body Shop</a></li>
                                    <li><a href="#">Lattafa</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">Blog</a>
                        <ul class="sub-menu">
                            <li><a href="#">Newsletter</a></li>
                            <li><a href="#">Social Media</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">My Account</a>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">About Us</a>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">User</a>
                        <ul class="sub-menu">
                            <li><a href="#">Login In</a></li>
                            <li><a href="#">Sign up</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="offcanvas_footer">
                <span><a href="#"><i class="fa fa-envelope-0"></i>deo@gmail.com</a></span>
                <ul>
                    <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                    <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                </ul>
            </div>
        </div>

    </div>


    <header>
        <div class="main_header header_transparent header-mobile-m">
            <div class="header_container sticky-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-2">
                            <div class="logo">
                                <a href="index.html"><img src="images/logoo.png" alt=""></a>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <!-- main-menu starts -->
                            <div class="main_menu menu_two menu_position">
                                <nav>
                                    <ul>
                                        <li>
                                            <a href="index.html" class="active">Home <i
                                                    class="fa fa-angle-down"></i></a>
                                            <ul class="sub_menu">
                                                <li><a href="#">Men</a></li>
                                                <li><a href="#">Women</a></li>
                                                <li><a href="#">Unisex</a></li>
                                                <li><a href="#">Kids</a></li>
                                            </ul>

                                        </li>

                                        <li class="mega_items">
                                            <a href="#">Brands <i class="fa fa-angle-down"></i></a>
                                            <div class="mega_menu">
                                                <ul class="mega_menu_inner">
                                                    <li>
                                                        <a href="#">Men</a>
                                                        <ul>
                                                            <li><a href="#">Versace</a></li>
                                                            <li><a href="#">Hugo Boss</a></li>
                                                            <li><a href="#">Jaguar</a></li>
                                                            <li><a href="#">Armani</a></li>
                                                            <li><a href="#">Paco Rabbane</a></li>
                                                            <li><a href="#">Ralph Lauren</a></li>
                                                        </ul>

                                                    </li>
                                                    <li>
                                                        <a href="#">Women</a>
                                                        <ul>
                                                            <li><a href="#">Bvlgari</a></li>
                                                            <li><a href="#">Coach</a></li>
                                                            <li><a href="#">Kenzo</a></li>
                                                            <li><a href="#">D&G</a></li>
                                                            <li><a href="#">Jean Paul Gaultier</a></li>
                                                        </ul>

                                                    </li>
                                                    <li>
                                                        <a href="#">Unisex</a>
                                                        <ul>
                                                            <li><a href="#">Ajmal</a></li>
                                                            <li><a href="#">Calvin Klein</a></li>
                                                            <li><a href="#">The Body Shop</a></li>
                                                            <li><a href="#">Lattafa</a></li>
                                                        </ul>

                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#">Blog <i class="fa fa-angle-down"></i></a>
                                            <ul class="sub_menu pages">
                                                <li><a href="#">Newsletter</a></li>
                                                <li><a href="#">Social Media</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">About Us</a></li>
                                        <li><a href="#">Contact Us</a></li>
                                        <li>
                                            <a href="#">User <i class="fa fa-angle-down"></i></a>
                                            <ul class="sub_menu pages">
                                                <li><a href="login.php">Login In</a></li>
                                                <li><a href="#">Sign Up</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                            <!-- main menu ends -->
                        </div>
                        <div class="col-lg-4">
                            <div class="header_top_right">
                                <div class="header_right_info">
                                    <ul>
                                        <li class="search_box">
                                            <a href="javascript:void(0)">
                                                <i class="fa fa-search"></i>
                                            </a>
                                            <div class="search_widget">
                                                <form action="#">
                                                    <input type="text" placeholder="Search your perfume">
                                                    <button type="submit"><i class="fa fa-search"></i></button>
                                                </form>
                                            </div>
                                        </li>
                                        <li class="header_wishlist">
                                            <a href="#">
                                                <i class="fa fa-heart-o"></i>
                                                <span class="item_count">4</span>
                                            </a>
                                        </li>
                                        <li class="mini_cart_wrapper">
                                            <a href="javascript:void(0)">
                                                <i class="fa fa-shopping-cart"></i>
                                                <span class="item_count">2</span>
                                            </a>

                                            <!-- mini cart  -->
                                            <div class="mini_cart mini_cart2">
                                                <div class="cart_gallery">
                                                    <div class="cart_item">
                                                        <div class="cart_img">
                                                            <a href="#"><img src="images/small-product/mini1.png"
                                                                    alt="Perfume"></a>
                                                        </div>
                                                        <div class="cart_info">
                                                            <a href="#">Hugo Boss</a>
                                                            <p><span>COP 3640</span> X 1</p>
                                                        </div>
                                                        <div class="cart_remove">
                                                            <a href="#"><i class="fa fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="cart_item">
                                                        <div class="cart_img">
                                                            <a href="#"><img src="images/small-product/mini2.png"
                                                                    alt="Perfume"></a>
                                                        </div>
                                                        <div class="cart_info">
                                                            <a href="#">Bvlgari</a>
                                                            <p><span>COP 8350</span> X 1</p>
                                                        </div>
                                                        <div class="cart_remove">
                                                            <a href="#"><i class="fa fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mini_cart_table">
                                                    <div class="cart_table_border">
                                                        <div class="cart_total">
                                                            <span>Sub Total :</span>
                                                            <span class="price">COP 11990</span>
                                                        </div>

                                                        <div class="cart_total mt-10">
                                                            <span>Total :</span>
                                                            <span class="price">COP 11990</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="mini_cart_footer">
                                                    <div class="cart_button">
                                                        <a href="../Carrito/index.php">View Cart</a>
                                                    </div>
                                                    <div class="cart_button">
                                                        <a href="#">Checkout</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- mini cart ends -->
                                        </li>
                                    </ul>
                                </div>
                                <div class="header_account">
                                    <ul>
                                        <li class="top_links">
                                            <a href="#">
                                                <i class="fa fa-cog"></i>
                                            </a>
                                            <ul class="dropdown_links">
                                                <li><a href="#">Checkout</a></li>
                                                <li><a href="#">My Account</a></li>
                                                <li><a href="#">Shopping cart</a></li>
                                                <li><a href="#">Wishlist</a></li>
                                            </ul>
                                        </li>
                                        <li class="language">
                                            <a href="#"><img src="images/icon/language.png" alt="English"> EN <i
                                                    class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown_language">
                                                <li><a href="#">English</a></li>
                                                <li><a href="#">Spanish</a></li>
                                                
                                            </ul>
                                        </li>
                                        <li class="currency">
                                            <a href="#">COP <i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown_currency">
                                                <li><a href="#">US - EEUU</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <!-- slider section starts  -->
    <section class="slider_section slider_section2 mb-66">
        <div class="slider_area owl-carousel">
            <div class="single_slider d-flex align-items-center" data-bgimg="images/slider/slider1.jpg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6 col-md-6 offset-md-6">
                            <div class="slider_content slider_content2 content_right">
                                <h1>Men's Collection</h1>
                                <h2>Wild Stone</h2>
                                <p>The rich aromatic notes of rosemary and nerolu combined with the sophistication of
                                    tonka beans and white beans and white woods to create the perfect accompaniment for
                                    the suited look.</p>
                                <a href="#" class="button">Shop Now <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="single_slider d-flex align-items-center" data-bgimg="images/slider/slider2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-7">
                            <div class="slider_content slider_content2 content_left">
                                <h1>Watch</h1>
                                <h2>Maison Micallef</h2>
                                <p>This perfume is a wonderful elixir that heightens both the scents of gourmet Bourbon
                                    vanilla and those refined of tuberose and jasmine. The delightful alliance reminds
                                    of tropical paradise.</p>
                                <a href="#" class="button">Shop Now <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- product area starts -->
                <div class="product_area product_area_two mb-65">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <h2>New Products</h2>
                        <div class="product_tab_btn">
                            <ul class="nav" role="tablist">
                                
                            <?php
                                // Verificar que hay categorías
                                if (!empty($categorias)) {
                                    foreach ($categorias as $categoriaId => $categoria) {
                                        $categoriaNombre = isset($categoria['nombre']) ? htmlspecialchars($categoria['nombre']) : 'Sin Nombre';
                                        $categoriaHref = str_replace(' ', '-', $categoriaNombre);
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="tab-<?php echo $categoriaHref; ?>" data-toggle="tab" href="#<?php echo $categoriaHref; ?>" role="tab" aria-controls="<?php echo $categoriaHref; ?>" aria-selected="false">
                                                <?php echo $categoriaNombre; ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    echo "<li class='nav-item'><a class='nav-link'>No hay categorías disponibles</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

           <!-- Contenido de las pestañas -->
           <div class="tab-content">
    <?php foreach ($categorias as $categoriaId => $categoria): ?>
        <?php $categoriaHref = isset($categoria['nombre']) ? str_replace(' ', '-', htmlspecialchars($categoria['nombre'])) : ''; ?>
        <div class="tab-pane fade" id="<?php echo $categoriaHref; ?>" role="tabpanel">
            <div class="row">
                <?php if (!empty($categoria['productos'])): ?>
                    <?php foreach ($categoria['productos'] as $producto): ?>
                        <?php 
                            $nombreProducto = isset($producto['nombre']) ? htmlspecialchars($producto['nombre']) : 'Sin Nombre';
                            $precioProducto = isset($producto['precio_x1']) ? htmlspecialchars($producto['precio_x1']) : 'Sin Precio';
                            $imagen1 = isset($producto['imagen1']) ? htmlspecialchars($producto['imagen1']) : 'ruta/imagen1.png';
                            $imagen2 = isset($producto['imagen2']) ? htmlspecialchars($producto['imagen2']) : 'ruta/imagen2.png';
                        ?>
                        <div class="col-lg-3">
                            <article class="single_product">
                                <figure>
                                    <div class="product_thumb">
                                        <a href="#" class="primary_img">
                                            <img src="../Admin/<?php echo $imagen1; ?>" alt="">
                                        </a>
                                        <a href="product.php" class="secondary_img">
                                            <img src="../Admin/<?php echo $imagen2; ?>" alt="">
                                        </a>
                                        <div class="action_links">
                                            <ul>
                                                <li class="add_to_cart">
                                                    <a href="#" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                                </li>
                                                <li class="wishlist">
                                                    <a href="#" title="Add to Wishlist"><i class="fa fa-heart-o"></i></a>
                                                </li>
                                                <li class="compare">
                                                    <a href="#" title="Add to Compare"><i class="fa fa-random"></i></a>
                                                </li>
                                                <li class="quick_button">
                                                    <a href="#" data-toggle="modal" data-target="#modal_box" title="Quick View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <figcaption class="product_content">
                                        <h4 class="product_name"><a href="#"><?php echo $nombreProducto;?></a></h4>
                                        <div class="price_box">
                                            <span class="current_price">COP <?php echo $precioProducto; ?></span>
                                        </div>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay productos en esta categoría.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
                          
                                            
    <!-- product area ends -->


    <!-- banner area starts -->
    <div class="banner_area mb-66">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="#">
                                <img src="images/banner/banner1.jpg" alt="">
                            </a>
                            <div class="banner_content">
                                <h3>Sale up to</h3>
                                <h2>50%</h2>
                                <p>Perfume <span> & </span> Body Spray</p>
                            </div>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="#">
                                <img src="images/banner/banner2.jpg" alt="">
                            </a>
                            <div class="banner_content">
                                <h3>Sale up to</h3>
                                <h2>70%</h2>
                                <p>Deodrants</p>
                            </div>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-md-4">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="#">
                                <img src="images/banner/banner3.jpg" alt="">
                            </a>
                            <div class="banner_content">
                                <h3>Sale up to</h3>
                                <h2>30%</h2>
                                <p>Cologne</p>
                            </div>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!-- banner area ends -->

    <!-- home section area starts  -->

    <div class="home_section_two color_two mb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="home_section_left">
                        <!-- deals product area starts -->

                        <div class="deals_product_area mb-68">
                            <div class="section_title section_title_style2">
                                <h2>Hot Deals</h2>
                            </div>
                            <div class="row">
                                <div class="deals_carousel product_column1 owl-carousel">
                                    <div class="col-lg-3">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a href="#" class="primary_img">
                                                        <img src="images/Deals/D1-1.png" alt="">
                                                    </a>
                                                    <a href="#" class="secondary_img">
                                                        <img src="images/Deals/D1-2.png" alt="">
                                                    </a>
                                                    <div class="action_links">
                                                        <ul>
                                                            <li class="add_to_cart">
                                                                <a href="#" title="Add to Cart">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li class="wishlist">
                                                                <a href="#" title="Add to Wishlist">
                                                                    <i class="fa fa-heart-o"></i>
                                                                </a>
                                                            </li>
                                                            <li class="compare">
                                                                <a href="#" title="Add to Compare">
                                                                    <i class="fa fa-random"></i>
                                                                </a>
                                                            </li>
                                                            <li class="quick_button">
                                                                <a href="#" data-toggle="modal" data-target="#modal_box"
                                                                    title="Quick View">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <figcaption class="product_content">
                                                    <!-- for deals timing -->
                                                    <div class="product_timing">
                                                        <div data-countdown="2021/1/15"></div>
                                                    </div>
                                                    <h4 class="product_name">
                                                        <a href="#">Boss Men Bottled Infinte EAU</a>
                                                    </h4>

                                                    <div class="price_box">
                                                        <span class="old_price">COP 9100</span>
                                                        <span class="current_price">COP 8650</span>
                                                    </div>

                                                </figcaption>
                                            </figure>

                                        </article>
                                    </div>

                                    <div class="col-lg-3">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a href="#" class="primary_img">
                                                        <img src="images/Deals/D2-1.png" alt="">
                                                    </a>
                                                    <a href="#" class="secondary_img">
                                                        <img src="images/Deals/D2-2.png" alt="">
                                                    </a>
                                                    <div class="action_links">
                                                        <ul>
                                                            <li class="add_to_cart">
                                                                <a href="#" title="Add to Cart">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li class="wishlist">
                                                                <a href="#" title="Add to Wishlist">
                                                                    <i class="fa fa-heart-o"></i>
                                                                </a>
                                                            </li>
                                                            <li class="compare">
                                                                <a href="#" title="Add to Compare">
                                                                    <i class="fa fa-random"></i>
                                                                </a>
                                                            </li>
                                                            <li class="quick_button">
                                                                <a href="#" data-toggle="modal" data-target="#modal_box"
                                                                    title="Quick View">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <figcaption class="product_content">
                                                    <!-- for deals timing -->
                                                    <div class="product_timing">
                                                        <div data-countdown="2021/1/26"></div>
                                                    </div>
                                                    <h4 class="product_name">
                                                        <a href="#">Ralph Lauren Men Polo Blue Bear</a>
                                                    </h4>

                                                    <div class="price_box">
                                                        <span class="old_price">COP 7499</span>
                                                        <span class="current_price">COP 7300</span>
                                                    </div>

                                                </figcaption>
                                            </figure>

                                        </article>
                                    </div>

                                    <div class="col-lg-3">
                                        <article class="single_product">
                                            <figure>
                                                <div class="product_thumb">
                                                    <a href="#" class="primary_img">
                                                        <img src="images/Deals/D3-1.png" alt="">
                                                    </a>
                                                    <a href="#" class="secondary_img">
                                                        <img src="images/Deals/D3-2.png" alt="">
                                                    </a>
                                                    <div class="action_links">
                                                        <ul>
                                                            <li class="add_to_cart">
                                                                <a href="#" title="Add to Cart">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </a>
                                                            </li>
                                                            <li class="wishlist">
                                                                <a href="#" title="Add to Wishlist">
                                                                    <i class="fa fa-heart-o"></i>
                                                                </a>
                                                            </li>
                                                            <li class="compare">
                                                                <a href="#" title="Add to Compare">
                                                                    <i class="fa fa-random"></i>
                                                                </a>
                                                            </li>
                                                            <li class="quick_button">
                                                                <a href="#" data-toggle="modal" data-target="#modal_box"
                                                                    title="Quick View">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <figcaption class="product_content">
                                                    <!-- for deals timing -->
                                                    <div class="product_timing">
                                                        <div data-countdown="2021/1/20"></div>
                                                    </div>
                                                    <h4 class="product_name">
                                                        <a href="#">Bvlgari Man In Black Orient</a>
                                                    </h4>

                                                    <div class="price_box">
                                                        <span class="old_price">COP 7499</span>
                                                        <span class="current_price">COP 6950</span>
                                                    </div>

                                                </figcaption>
                                            </figure>

                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- deals product area ends -->

                        <!-- small product area starts -->

                        <div class="small_product_area mb-68">
                            <div class="section_title section_title_style2">
                                <h2>Best Sellers</h2>
                            </div>
                            <div class="small_product_container sidebar_product_column1 owl-carousel">
                                <div class="small_product_list">
                                    <article class="single_product">


                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B1-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img"><img
                                                        src="images/best-product/B1-2.png" alt=""></a>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#">Dolce & Gabbana Women</a>
                                                </h4>
                                                <div class="product_rating">
                                                    <ul>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="price_box">
                                                    <span class="old_price">COP 9999</span>
                                                    <span class="current_price">COP 9000</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">


                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B2-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img"><img
                                                        src="images/best-product/B2-2.png" alt=""></a>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#">Jean Paul Gaultier</a>
                                                </h4>
                                                <div class="product_rating">
                                                    <ul>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="price_box">
                                                    <span class="old_price">COP 7999</span>
                                                    <span class="current_price">COP 7400</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">


                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B3-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img"><img
                                                        src="images/best-product/B3-2.png" alt=""></a>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#">Carolina Harrera Women 212 VIP</a>
                                                </h4>
                                                <div class="product_rating">
                                                    <ul>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="price_box">
                                                    <span class="old_price">COP 7499</span>
                                                    <span class="current_price">COP 6700</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>

                                </div>

                                <div class="small_product_list">
                                    <article class="single_product">


                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B4-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img"><img
                                                        src="images/best-product/B4-2.png" alt=""></a>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#">Mugler Aura Women</a>
                                                </h4>
                                                <div class="product_rating">
                                                    <ul>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="price_box">
                                                    <span class="old_price">COP 7999</span>
                                                    <span class="current_price">COP 7550</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">


                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B5-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img"><img
                                                        src="images/best-product/B5-2.png" alt=""></a>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#">Jimmy Choo Women Fever</a>
                                                </h4>
                                                <div class="product_rating">
                                                    <ul>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="price_box">
                                                    <span class="old_price">COP 7499</span>
                                                    <span class="current_price">COP 7200</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">


                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B6-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img"><img
                                                        src="images/best-product/B6-2.png" alt=""></a>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#">Dloce & Gabbana Women </a>
                                                </h4>
                                                <div class="product_rating">
                                                    <ul>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="price_box">
                                                    <span class="old_price">COP 7499</span>
                                                    <span class="current_price">COP 7200</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>

                                </div>
                            </div>
                        </div>

                        <!-- small product area ends -->

                        <!-- testimonial section starts  -->

                        <div class="testimonial_style_two mb-60">
                            <div class="testimonial_container">
                                <div class="section_title section_title_style2">
                                    <h2>Testimonial</h2>
                                </div>
                                <div class="testimonial_sidebar_carousel owl-carousel">
                                    <div class="single_testimonial">
                                        <div class="testimonial_img">
                                            <a href="#"><img src="images/testimonial/testimonial1.jpg" alt=""></a>
                                        </div>
                                        <div class="testimonial_content">
                                            <h4><a href="#">Navnit Kumar</a></h4>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius omnis nam
                                                eum iusto aspernatur cupiditate, ipsam deleniti labore dolorem saepe
                                                nostrum exercitationem amet quod harum blanditiis sint atque soluta
                                                quaerat.</p>
                                        </div>
                                    </div>
                                    <div class="single_testimonial">
                                        <div class="testimonial_img">
                                            <a href="#"><img src="images/testimonial/testimonial2.jpg" alt=""></a>
                                        </div>
                                        <div class="testimonial_content">
                                            <h4><a href="#">Ravi Kumawat</a></h4>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla,
                                                aspernatur fugit obcaecati officia eligendi minus possimus, quae eius ex
                                                quasi delectus dolorem. Commodi consectetur saepe magnam atque
                                                reprehenderit suscipit pariatur.

                                            </p>
                                        </div>
                                    </div>
                                    <div class="single_testimonial">
                                        <div class="testimonial_img">
                                            <a href="#"><img src="images/testimonial/testimonial3.jpg" alt=""></a>
                                        </div>
                                        <div class="testimonial_content">
                                            <h4><a href="#">Nilay Hirpara</a></h4>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore
                                                accusantium quas excepturi, quam explicabo repudiandae vitae quisquam
                                                ratione voluptatum molestiae exercitationem architecto temporibus eaque
                                                fugit dolores, rerum laborum, optio itaque.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- testimonial section ends -->

                        <!-- Newsletter section starts -->

                        <div class="newsletter_style2">
                            <div class="newsletter_container">
                                <div class="section_title section_title_style2">
                                    <h2>Newsletter</h2>
                                </div>
                                <div class="subscribe_form">
                                    <form>
                                        <input type="email" autocomplete="off" placeholder="example@gmail.com">
                                        <button>
                                            <i class="fa fa-envelope-o"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="newsletter_content">
                                    <p>Sign up to get news and get 25% off instantly.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Newsletter section ends -->

                    </div>
                </div>

                <div class="col-lg-9 col-md-12">
                    <div class="home_section_right">
                        <!-- product area starts  -->

                        <div class="product_area mb-65">
        <div class="section_title section_title_style2">
            <h2>New Products</h2>
        </div>
        <div class="row">
            <div class="product_carousel product_column3 owl-carousel">
                <?php
                // Incluir el archivo con la lista de productos
                include("listar_productos.php");

                // Verificar que hay productos y mostrarlos
                if (!empty($productos)) {
                    foreach ($productos as $producto) {
                        $nombre = htmlspecialchars($producto['nombre']);
                        $precio = number_format($producto['precio'], 2);
                        $imagen = htmlspecialchars($producto['imagen']);
                        $imagen2 = htmlspecialchars($producto['imagen2']);
                        ?>
                        <div class="col-lg-3">
                            <article class="single_product">
                                <figure>
                                    <div class="product_thumb">
                                        <a href="#" class="primary_img">
                                            <img src="../Admin/<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>">
                                        </a>
                                        <a href="#" class="secondary_img">
                                            <img src="../Admin/<?php echo $imagen2; ?>" alt="<?php echo $nombre; ?>">
                                        </a>
                                        <div class="action_links">
                                            <ul>
                                                <li class="add_to_cart"><a href="#" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                                                <li class="wishlist"><a href="#" title="Add to Wishlist"><i class="fa fa-heart-o"></i></a></li>
                                                <li class="compare"><a href="#" title="Add to Compare"><i class="fa fa-random"></i></a></li>
                                                <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box" title="Quick View"><i class="fa fa-eye"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <figcaption class="product_content">
                                        <h4 class="product_name"><a href="#"><?php echo $nombre; ?></a></h4>
                                        <div class="product_rating">
                                            <ul>
                                                <?php echo str_repeat('<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>', 5); ?>
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            <span class="current_price">COP <?php echo $precio; ?></span>
                                        </div>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No hay productos disponibles.</p>";
                }
                ?>
            </div>
        </div>
    </div>
                                    
                        <!-- product area ends -->

                        <!-- Long banner area starts  -->
                        <div class="banner_area banner_style_two mb-58">
                            <div class="single_banner">
                                <div class="banner_thumb">
                                    <a href="#">
                                        <img src="images/banner/banner4.png" alt="">

                                    </a>
                                    <div class="banner_content">
                                        <h3 style="color: tomato;">Sale up to </h3>
                                        <h2>45%</h2>
                                        <p>Versace</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Long Banner area ends -->

                        <!-- product section starts  -->
                        <div class="product_area">
                            <div class="section_title section_title_style2">
                                <h2>On Sale</h2>
                            </div>
                            <div class="row">
                                <div class="product_carousel product_column3 owl-carousel">
                                    <div class="col-lg-3">
                                        <div class="product_items">
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D1-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D1-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Paco Rabbane Pure XS for Her</a>
                                                        </h4>
                                                        <div class="product_rating">
                                                            <ul>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="price_box">
                                                            <span class="old_price">COP 6550</span>
                                                            <span class="current_price">COP 5240</span>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D2-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D2-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Paco Rabanne Women Olympea</a>
                                                        </h4>
                                                        <div class="product_rating">
                                                            <ul>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="price_box">
                                                            <span class="old_price">COP 5999</span>
                                                            <span class="current_price">COP 5100</span>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="product_items">
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D3-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D3-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Issey Miyake Women L'Eau
                                                                <div class="product_rating">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="price_box">
                                                                    <span class="old_price">COP 5999</span>
                                                                    <span class="current_price">COP 5100</span>
                                                                </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D4-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D4-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Paco Rabanne Million</a>
                                                        </h4>
                                                        <div class="product_rating">
                                                            <ul>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="price_box">
                                                            <span class="old_price">COP 5999</span>
                                                            <span class="current_price">COP 5100</span>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="product_items">
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D5-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D5-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Lacoste Women
                                                                <div class="product_rating">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="price_box">
                                                                    <span class="old_price">COP 6000</span>
                                                                    <span class="current_price">COP 5000</span>
                                                                </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D6-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D6-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Narciso Rodiguez For Him</a>
                                                        </h4>
                                                        <div class="product_rating">
                                                            <ul>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="price_box">
                                                            <span class="old_price">COP 5500</span>
                                                            <span class="current_price">COP 5000</span>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="product_items">
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D7-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D7-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Nina Ricci Women
                                                                <div class="product_rating">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="price_box">
                                                                    <span class="old_price">COP 5500</span>
                                                                    <span class="current_price">COP 5000</span>
                                                                </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D8-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D8-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Mercedes Benz Women</a>
                                                        </h4>
                                                        <div class="product_rating">
                                                            <ul>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="price_box">
                                                            <span class="old_price">COP 5900</span>
                                                            <span class="current_price">COP 4838</span>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="product_items">
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D9-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D9-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Chopard Women Wish
                                                                <div class="product_rating">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="price_box">
                                                                    <span class="old_price">COP 5500</span>
                                                                    <span class="current_price">COP 4950</span>
                                                                </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D10-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D10-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Mont Blanc Lady Emblem</a>
                                                        </h4>
                                                        <div class="product_rating">
                                                            <ul>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="price_box">
                                                            <span class="old_price">COP 4999</span>
                                                            <span class="current_price">COP 4500</span>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="product_items">
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D11-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D11-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Jimmy Choo Illicit Flower
                                                                <div class="product_rating">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-star"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="price_box">
                                                                    <span class="old_price">COP 4999</span>
                                                                    <span class="current_price">COP 4200</span>
                                                                </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                            <article class="single_product">
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="#" class="primary_img">
                                                            <img src="images/onsale/D12-1.png" alt="">
                                                        </a>
                                                        <a href="#" class="secondary_img">
                                                            <img src="images/onsale/D12-2.png" alt="">
                                                        </a>

                                                        <div class="action_links">
                                                            <ul>
                                                                <li class="add_to_cart">
                                                                    <a href="#" title="Add to Cart">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="wishlist">
                                                                    <a href="#" title="Add to Wishlist">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="compare">
                                                                    <a href="#" title="Add to Compare">
                                                                        <i class="fa fa-random"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="quick_button">
                                                                    <a href="#" data-toggle="modal"
                                                                        data-target="#modal_box" title="Quick View">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <figcaption class="product_content">
                                                        <h4 class="product_name">
                                                            <a href="#">Bvlgari Women Goldea</a>
                                                        </h4>
                                                        <div class="product_rating">
                                                            <ul>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="price_box">
                                                            <span class="old_price">COP 3999</span>
                                                            <span class="current_price">COP 3700</span>
                                                        </div>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- product section ends -->
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- home section area ends -->


    <!-- blog section starts  -->

    <section class="blog_section blog_two color_two mb-65">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <h2>From Our Blog</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="blog_carousel blog_column3 owl-carousel">
                    <div class="col-lg-3">
                        <div class="single_blog">
                            <figure>
                                <div class="blog_thumb">
                                    <a href="#">
                                        <img src="images/blog/blog1.jpg" alt="">
                                    </a>
                                </div>
                                <figcaption class="blog_content">
                                    <h4 class="post_title">
                                        <a href="#">
                                            Flavours of Perfume
                                        </a>
                                    </h4>
                                    <p class="post_desc">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse excepturi cumque
                                        nulla saepe. Error, rem odio perferendis ullam facere veniam commodi minima
                                        delectus velit at obcaecati. Nam dolorem eligendi voluptates.
                                    </p>
                                    <footer class="btn_more">
                                        <a href="#">Read More...</a>
                                    </footer>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="single_blog">
                            <figure>
                                <div class="blog_thumb">
                                    <a href="#">
                                        <img src="images/blog/blog2.jpg" alt="">
                                    </a>
                                </div>
                                <figcaption class="blog_content">
                                    <h4 class="post_title">
                                        <a href="#">
                                            Divine Of India
                                        </a>
                                    </h4>
                                    <p class="post_desc">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse excepturi cumque
                                        nulla saepe. Error, rem odio perferendis ullam facere veniam commodi minima
                                        delectus velit at obcaecati. Nam dolorem eligendi voluptates.
                                    </p>
                                    <footer class="btn_more">
                                        <a href="#">Read More...</a>
                                    </footer>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="single_blog">
                            <figure>
                                <div class="blog_thumb">
                                    <a href="#">
                                        <img src="images/blog/blog3.jpg" alt="">
                                    </a>
                                </div>
                                <figcaption class="blog_content">
                                    <h4 class="post_title">
                                        <a href="#">
                                            Wardrobe Collection
                                        </a>
                                    </h4>
                                    <p class="post_desc">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse excepturi cumque
                                        nulla saepe. Error, rem odio perferendis ullam facere veniam commodi minima
                                        delectus velit at obcaecati. Nam dolorem eligendi voluptates.
                                    </p>
                                    <footer class="btn_more">
                                        <a href="#">Read More...</a>
                                    </footer>
                                </figcaption>
                            </figure>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="single_blog">
                            <figure>
                                <div class="blog_thumb">
                                    <a href="#">
                                        <img src="images/blog/blog4.jpg" alt="">
                                    </a>
                                </div>
                                <figcaption class="blog_content">
                                    <h4 class="post_title">
                                        <a href="#">
                                            Best Perfume for Party
                                        </a>
                                    </h4>
                                    <p class="post_desc">
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse excepturi cumque
                                        nulla saepe. Error, rem odio perferendis ullam facere veniam commodi minima
                                        delectus velit at obcaecati. Nam dolorem eligendi voluptates.
                                    </p>
                                    <footer class="btn_more">
                                        <a href="#">Read More...</a>
                                    </footer>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- blog section ends -->

    <footer class="footer_widgets color_two">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-7">
                        <div class="widgets_container contact_us">
                            <div class="footer_logo">
                                <a href="#"><img src="images/logoo.png" alt="Logo"></a>
                            </div>
                            <div class="footer_desc">
                                <p>Get all types of perfume from us within 2 day delivery. We can even order the
                                    perfumes which are not in our database. To do that kindly send a E-mail to the
                                    company's mail id.</p>
                            </div>
                            <p>
                                <span>Address :</span> International Business Center, Vesu, Surat, Gujarat
                            </p>
                            <p><span>Email :</span> <a href="#">YJY-Gerency@Asossiates.com</a></p>
                            <p><span>Phone :</span> <a href="tel: +91 8888884444">+91 8888884444</a> </p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-5">
                        <div class="widgets_container widget_menu">
                            <h3>Information</h3>
                            <div class="footer_menu">
                                <ul>
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Prices Drop</a></li>
                                    <li><a href="#">New Products</a></li>
                                    <li><a href="#">Best Sales</a></li>
                                    <li><a href="#">Terms & Conditions</a></li>
                                    <li><a href="#">Gift Certificate</a></li>
                                    <li><a href="#">My Account</a></li>
                                    <li><a href="#">Order History</a></li>
                                    <li><a href="#">Wish List</a></li>
                                    <li><a href="#">Specials</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widgets_container widgets_p_product">
                            <h3>Featured Products</h3>
                            <div class="small_product_container small_product_column1 owl-carousel">
                                <div class="small_product_list">
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/onsale/D12-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img">
                                                    <img src="images/onsale/D12-2.png" alt="">
                                                </a>


                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Bvlgari Women Goldea</a>
                                                </h4>

                                                <div class="price_box">
                                                    <span class="old_price">COP 3999</span>
                                                    <span class="current_price" style="color: white;">COP 3700</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/onsale/D11-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img">
                                                    <img src="images/onsale/D11-2.png" alt="">
                                                </a>


                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Jimmy Choo Illicit Flower
                                                    </a>
                                                </h4>
                                                <div class="price_box">
                                                    <span class="old_price">COP 4999</span>
                                                    <span class="current_price" style="color: white;">COP
                                                        4200</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B5-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img">
                                                    <img src="images/best-product/B5-2.png" alt="">
                                                </a>

                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Jimmy Choo Women Fever</a>
                                                </h4>

                                                <div class="price_box">
                                                    <span class="old_price">COP 7499</span>
                                                    <span class="current_price" style="color: white;">COP 7200</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                </div>
                                <div class="small_product_list">
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B4-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img">
                                                    <img src="images/best-product/B4-2.png" alt="">
                                                </a>


                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Mugler Aura Women</a>
                                                </h4>

                                                <div class="price_box">
                                                    <span class="old_price">COP 7999</span>
                                                    <span class="current_price" style="color: white;">COP 7550</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/onsale/D1-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img">
                                                    <img src="images/onsale/D1-2.png" alt="">
                                                </a>


                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Paco Rabbane Pure XS for her
                                                    </a>
                                                </h4>
                                                <div class="price_box">
                                                    <span class="old_price">COP 6550</span>
                                                    <span class="current_price" style="color: white;">COP
                                                        4250</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/new-product/N5-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img">
                                                    <img src="images/new-product/N5-2.png" alt="">
                                                </a>


                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Kenzo Women World</a>
                                                </h4>

                                                <div class="price_box">
                                                    <span class="old_price">COP 5999</span>
                                                    <span class="current_price" style="color: white;">COP 5900</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="widgets_container widgets_p_product">
                            <h3>Most Viewed Products</h3>
                            <div class="small_product_container small_product_column1 owl-carousel">
                                <div class="small_product_list">
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/onsale/D12-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img">
                                                    <img src="images/onsale/D12-2.png" alt="">
                                                </a>


                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Bvlgari Women Goldea</a>
                                                </h4>

                                                <div class="price_box">
                                                    <span class="old_price">COP 3999</span>
                                                    <span class="current_price" style="color: white;">COP 3700</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/onsale/D11-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img">
                                                    <img src="images/onsale/D11-2.png" alt="">
                                                </a>


                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Jimmy Choo Illicit Flower
                                                    </a>
                                                </h4>
                                                <div class="price_box">
                                                    <span class="old_price">COP 4999</span>
                                                    <span class="current_price" style="color: white;">COP
                                                        4200</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">
                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B5-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img">
                                                    <img src="images/best-product/B5-2.png" alt="">
                                                </a>

                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Jimmy Choo Women Fever</a>
                                                </h4>

                                                <div class="price_box">
                                                    <span class="old_price">COP 7499</span>
                                                    <span class="current_price" style="color: white;">COP 7200</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                </div>
                                <div class="small_product_list">
                                    <article class="single_product">


                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B4-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img"><img
                                                        src="images/best-product/B4-2.png" alt=""></a>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Mugler Aura Women</a>
                                                </h4>

                                                <div class="price_box">
                                                    <span class="old_price">COP 7999</span>
                                                    <span class="current_price" style="color: white;">COP 7550</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">


                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B5-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img"><img
                                                        src="images/best-product/B5-2.png" alt=""></a>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Jimmy Choo Women Fever</a>
                                                </h4>

                                                <div class="price_box">
                                                    <span class="old_price">COP 7499</span>
                                                    <span class="current_price" style="color: white;">COP 7200</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                    <article class="single_product">


                                        <figure>
                                            <div class="product_thumb">
                                                <a href="#" class="primary_img">
                                                    <img src="images/best-product/B6-1.png" alt="">
                                                </a>
                                                <a href="#" class="secondary_img"><img
                                                        src="images/best-product/B6-2.png" alt=""></a>
                                            </div>
                                            <figcaption class="product_content">
                                                <h4 class="product_name">
                                                    <a href="#" style="color: white;">Dloce & Gabbana Women </a>
                                                </h4>

                                                <div class="price_box">
                                                    <span class="old_price">COP 7499</span>
                                                    <span class="current_price" style="color: white;">COP 7200</span>
                                                </div>
                                            </figcaption>
                                        </figure>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer_link">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ul>
                            <li><a href="#">Order History</a></li>
                            <li><a href="#">Wish List</a></li>
                            <li><a href="#">Affiliate</a></li>
                            <li><a href="#">Site Map</a></li>
                            <li><a href="#">Newsletter</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer section starts  -->

        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="copyright_area">
                            <p>Copyright &copy; 2021 <a href="#">Perfume Store </a>All right Reserved.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="footer_payment text-right">
                            <ul>
                                <li><a href="#"><img src="images/icon/paypal.jpg" alt=""></a></li>
                                <li><a href="#"><img src="images/icon/paypal1.jpg" alt=""></a></li>
                                <li><a href="#"><img src="images/icon/paypal2.jpg" alt=""></a></li>
                                <li><a href="#"><img src="images/icon/paypal3.jpg" alt=""></a></li>
                                <li><a href="#"><img src="images/icon/paypal4.jpg" alt=""></a></li>
                                <li><a href="#"><img src="images/icon/paypal5.jpg" alt=""></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- footer section ends -->

    <!-- modal section starts  -->


    <div class="modal fade" id="modal_box" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" data-dismiss="modal" aria-label="close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal_body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="modal_tab">
                                    <div class="tab-content product-details-large">
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="#"><img src="images/new-product/N1-1.png" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="#"><img src="images/new-product/N2-1.png" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="#"><img src="images/new-product/N3.png" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab4" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="#"><img src="images/new-product/N4-1.png" alt=""></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal_tab_button">
                                        <ul class="nav product_navactive owl-carousel" role="tablist">
                                            <li>
                                                <a href="#tab1" class="nav-link active" data-toggle="tab" role="tab"
                                                    aria-controls="tab1" aria-selected="false">
                                                    <img src="images/new-product/N1-1.png" alt="">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab2" class="nav-link" data-toggle="tab" role="tab"
                                                    aria-controls="tab2" aria-selected="false">
                                                    <img src="images/new-product/N2-1.png" alt="">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab3" class="nav-link" data-toggle="tab" role="tab"
                                                    aria-controls="tab3" aria-selected="false">
                                                    <img src="images/new-product/N3.png" alt="">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab4" class="nav-link" data-toggle="tab" role="tab"
                                                    aria-controls="tab4" aria-selected="false">
                                                    <img src="images/new-product/N4-1.png" alt="">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7 col-md-7 col-sm-12">
                                <div class="modal_right">
                                    <div class="modal_title mb-10">
                                        <h2>Paco Rabbane Men Invictus</h2>
                                    </div>
                                    <div class="modal_price mb-10">
                                        <span class="new_price">COP 7600</span>
                                        <span class="old_price">COP 8100</span>
                                    </div>
                                    <div class="modal_description mb-15">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis earum
                                            nesciunt consequatur deleniti nam dicta eligendi iusto quaerat dolores
                                            debitis, est natus omnis consequuntur sequi. Ipsam sint rerum minus eos?</p>
                                    </div>
                                    <div class="variants_selects">
                                        <div class="variants_size">
                                            <h2>Size</h2>
                                            <select class="select_option">
                                                <option value="1" selected>10ml</option>
                                                <option value="1">25ml</option>
                                                <option value="1">50ml</option>
                                                <option value="1">100ml</option>
                                                <option value="1">250ml</option>
                                            </select>
                                        </div>
                                        <div class="variants_fragrance">
                                            <h2>Fragrance</h2>
                                            <select class="select_option">
                                                <option value="1" selected>Rose</option>
                                                <option value="1">Chocolate</option>
                                                <option value="1">Sweet</option>
                                                <option value="1">Fruit</option>
                                                <option value="1">Intense</option>
                                            </select>
                                        </div>
                                        <div class="modal_add_to_cart">
                                            <form action="#">
                                                <input type="number" min="1" max="100" step="1" value="1">
                                                <button type="submit">Add to cart</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal_social">
                                        <h2>Follow us on</h2>
                                        <ul>
                                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a>
                                            </li>
                                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <!-- modal section ends -->




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
    <script src="script/countdown.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <script src="script/main.js"></script>

</body>

</html>