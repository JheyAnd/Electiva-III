
<?php  
include ("../db/conexion.php");

if (isset($_GET['id']) || isset($_GET['nit'])) {
    // Si 'id' existe, lo utiliza; si no, asume que 'nit' existe
    $campo = isset($_GET['id']) ? 'id' : 'nit';
    $valor = isset($_GET['id']) ? $_GET['id'] : $_GET['nit'];

    $resultado = $conexion->query("SELECT * FROM productos WHERE $campo = $valor") or die($conexion->error);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_row($resultado);
    } else {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Electro - HTML Ecommerce Template</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="css/slick.css" />
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style.css" />


	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Perfume | E-Commerce</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css">
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
	<link rel="stylesheet" href="css/index2.css">

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
							<li><a href="#">Inglés</a></li>
							<li><a href="#">Alemán</a></li>
							<li><a href="#">indio</a></li>
						</ul>
					</li>
					<li class="currency">
						<a href="#">COP <i class="fa fa-angle-down"></i></a>
						<ul class="dropdown_currency">
							<li><a href="#">US - EEUU </a></li>


						</ul>
					</li>
					<li class="top_links">
						<a href="#">Mi cuenta <i class="fa fa-angle-down"></i></a>
						<ul class="dropdown_links">
							<li><a href="#">Checkout</a></li>
							<li><a href="#">Mi cuenta</a></li>
							<li><a href="#">Carrito</a></li>
							<li><a href="#">Favoritos</a></li>
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
									<a href="#">View Cart</a>
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

	<!-- HEADER -->
	<header>
        <div class="main_header header_transparent header-mobile-m">
            <div class="header_container sticky-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-2">
                            <div class="logo">
                                <a href="index.php"><img src="" alt=""></a>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <!-- main-menu starts -->
                            <div class="main_menu menu_two menu_position">
                                <nav>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="active">Home <i
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

	
	<!-- /HEADER -->
<br>
	<!-- NAVIGATION -->
	<!-- /NAVIGATION -->

	<!-- BREADCRUMB -->
	<!-- /BREADCRUMB -->
<br>
<br>

	<!-- SECTION -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- Product main img -->
				<div class="col-md-5 col-md-push-2">
					<div id="product-main-img">
						<div class="product-preview">
							<img src="../Admin/<?php echo $fila[11];?>" alt="">
						</div>
					</div>
				</div>
				<!-- /Product main img -->

				<!-- Product thumb imgs -->
				<div class="col-md-2  col-md-pull-5">
					<div id="product-imgs">
						<div class="product-preview">
							<img src="../Admin/<?php echo $fila[12];?>" alt="">
						</div>

						<div class="product-preview">
							<img src="../Admin/<?php echo $fila[13];?>" alt="">
						</div>

						<div class="product-preview">
							<img src="../Admin/<?php echo $fila[14];?>" alt="">
						</div>

						<div class="product-preview">
							<img src="#" alt="">
						</div>
					</div>
				</div>
				<!-- /Product thumb imgs -->

				<!-- Product details -->
				<div class="col-md-5">
					<div class="product-details">
						<h2 class="product-name"><?php echo $fila[1];?></h2>
						<div>
							<div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star-o"></i>
							</div>
							<a class="review-link" href="#">Reseña(s) | Dejar reseña</a>
						</div>
						<div>
							<h3 class="product-price"><?php echo $fila[9];?></h3>
							<span class="product-available">Disponible</span>
						</div>
						<p><?php echo $fila[2];?></p>

						<div class="product-options">
							<label>
								Tamaño
								<select class="input-select">
									<option value="<?php echo $fila[7];?>"><?php echo $fila[7];?></option>
								</select>
							</label>
							<label>
								Cant.
								<input type="number" name="cantidad" id="">
							</label>
						</div>

						<div class="add-to-cart">
							<button class="add-to-cart-btn" data-id="<?php echo $fila[0];?>">
								<i class="fa fa-shopping-cart"></i>Añadir al Carrito
							</button>
						</div>


						<ul class="product-btns">
							<li><a href="#"><i class="fa fa-heart-o"></i> Añadir a favoritos</a></li>
						</ul>

						<ul class="product-links">
							<li>Compartir:</li>
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-envelope"></i></a></li>
						</ul>

					</div>
				</div>
				<!-- /Product details -->

				<!-- Product tab -->
				<div class="col-md-12">
					<div id="product-tab">
						<!-- product tab nav -->
						<ul class="tab-nav">
							<li class="active"><a data-toggle="tab" href="#tab1">Descripción</a></li>
							<li><a data-toggle="tab" href="#tab2">Detalles</a></li>
							<li><a data-toggle="tab" href="#tab3">Reseñas (0)</a></li>
						</ul>
						<!-- /product tab nav -->

						<!-- product tab content -->
						<div class="tab-content">
							<!-- tab1  -->
							<div id="tab1" class="tab-pane fade in active">
								<div class="row">
									<div class="col-md-12">
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
									</div>
								</div>
							</div>
							<!-- /tab1  -->

							<!-- tab2  -->
							<div id="tab2" class="tab-pane fade in">
								<div class="row">
									<div class="col-md-12">
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
									</div>
								</div>
							</div>
							<!-- /tab2  -->

							<!-- tab3  -->
							<div id="tab3" class="tab-pane fade in">
								<div class="row">
									<!-- Rating -->
									<div class="col-md-3">
										<div id="rating">
											<div class="rating-avg">
												<span>4.5</span>
												<div class="rating-stars">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
												</div>
											</div>
											<ul class="rating">
												<li>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
													</div>
													<div class="rating-progress">
														<div style="width: 80%;"></div>
													</div>
													<span class="sum">3</span>
												</li>
												<li>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
													</div>
													<div class="rating-progress">
														<div style="width: 60%;"></div>
													</div>
													<span class="sum">2</span>
												</li>
												<li>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</div>
													<div class="rating-progress">
														<div></div>
													</div>
													<span class="sum">0</span>
												</li>
												<li>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</div>
													<div class="rating-progress">
														<div></div>
													</div>
													<span class="sum">0</span>
												</li>
												<li>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</div>
													<div class="rating-progress">
														<div></div>
													</div>
													<span class="sum">0</span>
												</li>
											</ul>
										</div>
									</div>
									<!-- /Rating -->

									<!-- Reviews -->
									<div class="col-md-6">
										<div id="reviews">
											<ul class="reviews">
												<li>
													<div class="review-heading">
														<h5 class="name">John</h5>
														<p class="date">27 DEC 2018, 8:0 PM</p>
														<div class="review-rating">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o empty"></i>
														</div>
													</div>
													<div class="review-body">
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
													</div>
												</li>
												<li>
													<div class="review-heading">
														<h5 class="name">John</h5>
														<p class="date">27 DEC 2018, 8:0 PM</p>
														<div class="review-rating">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o empty"></i>
														</div>
													</div>
													<div class="review-body">
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
													</div>
												</li>
												<li>
													<div class="review-heading">
														<h5 class="name">John</h5>
														<p class="date">27 DEC 2018, 8:0 PM</p>
														<div class="review-rating">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o empty"></i>
														</div>
													</div>
													<div class="review-body">
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
													</div>
												</li>
											</ul>
											<ul class="reviews-pagination">
												<li class="active">1</li>
												<li><a href="#">2</a></li>
												<li><a href="#">3</a></li>
												<li><a href="#">4</a></li>
												<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
											</ul>
										</div>
									</div>
									<!-- /Reviews -->

									<!-- Review Form -->
									<div class="col-md-3">
										<div id="review-form">
											<form class="review-form">
												<input class="input" type="text" placeholder="Nombre">
												<input class="input" type="email" placeholder="Correo electronico">
												<textarea class="input" placeholder="Tu reseña"></textarea>
												<div class="input-rating">
													<span>Tu calificación: </span>
													<div class="stars">
														<input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
														<input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
														<input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
														<input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
														<input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
													</div>
												</div>
												<button class="primary-btn">Enviar</button>
											</form>
										</div>
									</div>
									<!-- /Review Form -->
								</div>
							</div>
							<!-- /tab3  -->
						</div>
						<!-- /product tab content  -->
					</div>
				</div>
				<!-- /product tab -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /SECTION -->

	<!-- Section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">

				<div class="col-md-12">
					<div class="section-title text-center">
						<h3 class="title">Productos Relacionados</h3>
					</div>
				</div>

				<!-- product -->
				<div class="col-md-3 col-xs-6">
					<div class="product">
						<div class="product-img">
							<img src="./images/products/men/2-1.png" alt="">
							<div class="product-label">
								<span class="sale">-30%</span>
							</div>
						</div>
						<div class="product-body">
							<p class="product-category">Hombre</p>
							<h3 class="product-name"><a href="#">product name goes here</a></h3>
							<h4 class="product-price">$150.000 <del class="product-old-price">$300.000</del></h4>
							<div class="product-rating">
							</div>
							<div class="product-btns">
								<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">a;adir a favoritos</span></button>
								
								<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">vista rápida</span></button>
							</div>
						</div>
						<div class="add-to-cart">
							<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Añadir al carro</button>
						</div>
					</div>
				</div>
				<!-- /product -->

				<!-- product -->
				<div class="col-md-3 col-xs-6">
					<div class="product">
						<div class="product-img">
							<img src="./images/products/men/1-2.png" alt="">
							<div class="product-label">
								<span class="new">NEW</span>
							</div>
						</div>
						<div class="product-body">
							<p class="product-category">Hombre</p>
							<h3 class="product-name"><a href="#">product name goes here</a></h3>
							<h4 class="product-price">$170.000 <del class="product-old-price">$190.000</del></h4>
							<div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</div>
							<div class="product-btns">
								<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">a;adir a favoritos</span></button>
								
								<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">vista rápida</span></button>
							</div>
						</div>
						<div class="add-to-cart">
							<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Añadir al carro</button>
						</div>
					</div>
				</div>
				<!-- /product -->

				<div class="clearfix visible-sm visible-xs"></div>

				<!-- product -->
				<div class="col-md-3 col-xs-6">
					<div class="product">
						<div class="product-img">
							<img src="./images/products/men/3-1.png" alt="">
						</div>
						<div class="product-body">
							<p class="product-category">Hombre</p>
							<h3 class="product-name"><a href="#">product name goes here</a></h3>
							<h4 class="product-price">$380.000 <del class="product-old-price">$410.000</del></h4>
							<div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star-o"></i>
							</div>
							<div class="product-btns">
								<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">a;adir a favoritos</span></button>
								
								<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">vista rápida</span></button>
							</div>
						</div>
						<div class="add-to-cart">
							<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Añadir al carro</button>
						</div>
					</div>
				</div>
				<!-- /product -->

				<!-- product -->
				<div class="col-md-3 col-xs-6">
					<div class="product">
						<div class="product-img">
							<img src="./images/products/men/4-1.png" alt="">
						</div>
						<div class="product-body">
							<p class="product-category">Hombre</p>
							<h3 class="product-name"><a href="#">product name goes here</a></h3>
							<h4 class="product-price">$190.000 <del class="product-old-price">$240.000</del></h4>
							<div class="product-rating">
							</div>
							<div class="product-btns">
								<button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">a;adir a favoritos</span></button>
								
								<button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">vista rápida</span></button>
							</div>
						</div>
						<div class="add-to-cart">
							<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Añadir al carro</button>
						</div>
					</div>
				</div>
				<!-- /product -->

			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /Section -->

	<!-- NEWSLETTER -->
	<!-- /NEWSLETTER -->

	<!-- FOOTER -->
	<footer class="footer_widgets color_two">
		<div class="footer_top">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-6 col-sm-7">
						<div class="widgets_container contact_us">
							<div class="footer_logo">
								<a href="#"><img src="images/logo.png" alt="Logo"></a>
							</div>
							<div class="footer_desc">
								<p>Lorem ipsum, ipsum lorem ist est immer</p>
							</div>
							<p>
								<span>Dirección :</span> Centro comercial El Caraño, Local 313
							</p>
							<p><span>Correo :</span> <a href="#">impss@hotmail.com</a></p>
							<p><span>Telefonos :</span> <a href="tel: +91 8888884444">+57 604-6930170</a> </p>
						</div>
					</div>
					<div class="col-lg-2 col-md-6 col-sm-5">
						<div class="widgets_container widget_menu">
							<h3>Información</h3>
							<div class="footer_menu">
								<ul>
									<li><a href="#">Sobre nosotros</a></li>
									<li><a href="#">Términos y Condiciones</a></li>
									<li><a href="#">Mi cuenta</a></li>
									<li><a href="#">Historial de pedidos</a></li>
									<li><a href="#">Lista de deseados</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="widgets_container widgets_p_product">
							<h3>Relacionados</h3>
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
							<h3>Mas populares</h3>
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
		
		<!-- footer section starts  -->

		<div class="footer_bottom">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6 col-md-6">
						<div class="copyright_area">
							<p>Copyright &copy; 2024 <a href="#">P.C.G Associates </a>Todos los derechos reservados.</p>
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
	<!-- /FOOTER -->

	<!-- jQuery Plugins -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
	<script src="script/countdown.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
	<script src="script/main.js"></script>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
	<script>
		document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        // Redirige a otra página pasando el id como parámetro en la URL
        window.location.href = `../Carrito/index.php?id=${<?php echo $fila[0];?>}`;
    	});
	});

	</script>

</body>

</html>