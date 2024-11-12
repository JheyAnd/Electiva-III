<?php
include ("../db/conexion.php");
session_start();
 // Asegúrate de que la sesión esté iniciada

// Verificar si el usuario está autenticado
if (isset($_SESSION['user'])) {
    // Obtener los datos del usuario almacenados en la sesión
    $userData = $_SESSION['user'];

    // Ejemplo: obtener el nombre y correo del usuario
    $nombre = $userData['name'];  // El nombre del usuario (lo obtienes al autenticarse)
    $correo = $userData['email']; // El correo del usuario (también al autenticarse)
} else {
    // Si no hay sesión activa, redirigir al usuario a la página de inicio de sesión
    if (isset($_SESSION['usuario'])){

    $correo = $_SESSION['usuario'];

    }else{
        header("Location : login.php");
    }
}

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
                        <!-- mini cart ends here -->
                    
                </ul>
            </div>

            <div id="menu" class="text-left">
                <ul class="offcanvas_main_menu">
                    <li class="menu-item-has-children active">
                        <a href="home.php">Home</a>
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
                        <a href="#">My Account</a>
                    </li>
                    
                    <li class="menu-item-has-children">
                        <a href="#">User</a>
                        <ul class="sub-menu">
                            <?php if (!isset($correo)): ?>
                                <li><a href="login.php">Login In</a></li>
                            <?php else: ?>
                                <li><a href="perfil.php">Perfil</a></li>
                                <li><a href="../Registro&Seccion/cerrar_sesion.php">Cerrar Sesion</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>


                </ul>
            </div>

            <div class="offcanvas_footer">
                <span><a href="#"><i class="fa fa-envelope-0"></i>YJ</a></span>
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
                                            <a href="home.php" class="active">Home <i
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
                                        
                                        <li><a href="#">About Us</a></li>
                                        <li>
                                            <a href="#">User <i class="fa fa-angle-down"></i></a>
                                            <ul class="sub_menu pages">
                                            <?php if (!isset($correo)): ?>
                                            <!-- Mostrar solo si el usuario no está logueado -->
                                            <li><a href="login.php">Login In</a></li>
                                        <?php else: ?>
                                            <!-- Mostrar solo si el usuario está logueado -->
                                            <li><a href="perfil.php">Perfil</a></li>
                                            <li><a href="../Registro&Seccion/cerrar_sesion.php">Cerrar sesión</a></li>
                                        <?php endif; ?>
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
                                        

                                            <!-- mini cart  -->
                                           
                                    </ul>
                                </div>
                                <div class="header_account">
                                    <ul>
                                        <li class="top_links">
                                            <a href="#">
                                                <i class="fa fa-user"></i>
                                            </a>
                                            <ul class="dropdown_links">
                                                <li><a href="#">Checkout</a></li>
                                                <li><a href="#">My Account</a></li>
                                                <li><a href="#">Shopping cart</a></li>
                                                <li><a href="#">Wishlist</a></li>
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
                            $nombreID = isset($producto['id'])  ? htmlspecialchars($producto['id']) : 'Sin ID';
                        ?>
                        <div class="col-lg-3">
                            <article class="single_product">
                                <figure>
                                    <div class="product_thumb">
                                        <a href="" class="primary_img">
                                            <img src="../Admin/<?php echo $imagen1; ?>" alt="">
                                        </a>
                                        <a href="product.php?id=<?php echo $nombreID; ?>" class="secondary_img">
                                            <img src="../Admin/<?php echo $imagen2; ?>" alt="">
                                        </a>
                                    </div>
                                    <figcaption class="product_content">
                                        <h4 class="product_name"><a href="product.php?id=<?php echo $nombreID; ?>"><?php echo $nombreProducto;?></a></h4>
                                        <div class="price_box">
                                            <span class="current_price">COP <?php echo number_format($precioProducto,2); ?></span>
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
                                            
                                        <?php include ("../Admin/content_pg.php"); 
                                        if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <figure>
                                                    <div class="product_thumb">
                                                        <a href="product.php?nit=<?php echo $row['nit']; ?>" class="primary_img">
                                                            <img src="../Admin/<?php echo $row['imagen1']; ?>" alt="<?php echo $row['nombre']; ?>">
                                                        </a>
                                                        <a href="product.php?nit=<?php echo $row['nit']; ?>" class="secondary_img">
                                                            <img src="../Admin/<?php echo $row['imagen2']; ?>" alt="<?php echo $row['nombre']; ?>">
                                                        </a>
                                                        <div class="action_links">
                                                           
                                                        </div>
                                                    </div>
                                                    <figcaption>
                                                        <h3><?php echo $row['nombre']; ?></h3>
                                                        <p>Precio: $<?php echo number_format ($row['precio']); ?></p>
                                                        <p>Descuento: <?php echo $row['descuento']; ?></p>
                                                    </figcaption>
                                                </figure>
                                            <?php
                                                }
                                            } else {
                                                echo "<p>No hay productos disponibles.</p>";
                                            }
                                            ?>
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

                                        <?php

                                            include ("../Admin/content_pg.php");
                                            // Verificar si se encontraron productos
                                            if ($result2->num_rows > 0) {
                                                while ($row = $result2->fetch_assoc()) {
                                                    // Generar el HTML dinámicamente para cada producto
                                                    echo '
                                                    <article class="single_product">
                                                        <figure>
                                                            <div class="product_thumb">
                                                                <a href="product.php?nit='.  $row['nit'] .'" class="primary_img">
                                                                    <img src="../Admin/' . $row['imagen1'] . '" alt="">
                                                                </a>
                                                                <a href="product.php?nit='.  $row['nit'] .'" class="secondary_img">
                                                                    <img src="../Admin/' . $row['imagen2'] . '" alt="">
                                                                </a>
                                                            </div>
                                                            <figcaption class="product_content">
                                                                <h4 class="product_name">
                                                                    <a href="product.php?nit='.  $row['nit'] .'">' . $row['nombre'] . '</a>
                                                                </h4>
                                                                <div class="product_rating">
                                                                    <ul>
                                                                        <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                                        <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                                        <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                                        <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                                        <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="price_box">
                                                                    <span class="old_price">COP ' . number_format($row['precio'], 0, ',', '.') . '</span>
                                                                    <span class="current_price">COP ' . number_format($row['descuento'], 0, ',', '.') . '</span>
                                                                </div>
                                                            </figcaption>
                                                        </figure>
                                                    </article>
                                                    ';
                                                }
                                            } else {
                                                echo '<p>No se encontraron productos en "Best Sellers".</p>';
                                            }
                                            ?>
                                        
                                    </article>
                                </div>
                            </div>
                        </div>

                        <!-- small product area ends -->

                        <!-- testimonial section starts  -->

                       
                        <!-- testimonial section ends -->

                        <!-- Newsletter section starts -->

                       
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
                        $id=htmlspecialchars($producto['id']);
                        $nombre = htmlspecialchars($producto['nombre']);
                        $precio = number_format($producto['precio'], 2);
                        $imagen = htmlspecialchars($producto['imagen']);
                        $imagen2 = htmlspecialchars($producto['imagen2']);
                        ?>
                        <div class="col-lg-3">
                            <article class="single_product">
                                <figure>
                                    <div class="product_thumb">
                                        <a href="product.php?id=<?php echo $id; ?>" class="primary_img">
                                            <img src="../Admin/<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>">
                                        </a>
                                        <a href="product.php?id=<?php echo $id?>" class="secondary_img">
                                            <img src="../Admin/<?php echo $imagen2; ?>" alt="<?php echo $nombre; ?>">
                                        </a>
                                        
                                    </div>
                                    <figcaption class="product_content">
                                        <h4 class="product_name"><a href="product.php?id=<?php echo $id?>"><?php echo $nombre; ?></a></h4>
                                        <div class="product_rating">
                                            <ul>
                                                <?php echo str_repeat('<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>', 5); ?>
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            <span class="current_price">COP <?php echo  $precio; ?></span>
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
                                <?php
                                        include ("../Admin/content_pg.php");

                                        // Verificar si se encontraron productos
                                        if ($result3->num_rows > 0) {
                                            while ($row = $result3->fetch_assoc()) {
                                                echo '
                                                <div class="col-lg-3">
                                                    <div class="product_items">   
                                                        <article class="single_product">
                                                            <figure>
                                                                <div class="product_thumb">
                                                                    <a href="product.php?nit='.  $row['nit'] .'" class="primary_img">
                                                                        <img src="../Admin/' . $row['imagen1'] . '" alt="">
                                                                    </a>
                                                                    <a href="product.php?nit='.  $row['nit'] .'" class="secondary_img">
                                                                        <img src="../Admin/' . $row['imagen2'] . '" alt="">
                                                                    </a>
                                                                    <div class="action_links">
                                                                       
                                                                    </div>
                                                                </div>
                                                                <figcaption class="product_content">
                                                                    <h4 class="product_name">
                                                                        <a href="product.php?nit='.  $row['nit'] .'">' . $row['nombre'] . '</a>
                                                                    </h4>
                                                                    <div class="product_rating">
                                                                        <ul>
                                                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="price_box">
                                                                        <span class="old_price">COP ' . number_format($row['descuento'], 0, ',', '.') . '</span>
                                                                        <span class="current_price">COP ' .number_format($row['precio'], 0, ',', '.') . '</span>
                                                                    </div>
                                                                </figcaption>
                                                            </figure>
                                                        </article>
                                                    </div>
                                                </div>';
                                            }
                                        } else {
                                            echo '<p>No se encontraron productos en "On Sale".</p>';
                                        }
                                        ?>
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
<footer class="footer_widgets color_two">
         <!-- footer section starts  -->

        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="copyright_area">
                            <p>Copyright &copy; 2024 <a href="#">Imperial Essences </a>Todos los derechos reservados</p>
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