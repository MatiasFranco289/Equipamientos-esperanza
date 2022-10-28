<!DOCTYPE html>
<html lang="en">		
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Esperanza - Equipamientos comerciales</title>	
 		<!-- Google font -->
 		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

 		<!-- Bootstrap -->
 		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
 		<!-- Slick -->
 		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
 		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

 		<!-- nouislider -->
 		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

 		<!-- Font Awesome Icon -->
		 <link rel="stylesheet" href="css/font-awesome.min.css">
		 

 		<!-- Custom stlylesheet -->
 		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- <link rel="stylesheet" href="css/estilos.css">  Estilos de pop up-->

		<link rel="apple-touch-icon" sizes="57x57" href="img/icons/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="img/icons//apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="img/icons//apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="img/icons//apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="img/icons//apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="img/icons//apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="img/icons//apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="img/icons//apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="img/icons//apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="img/icons//android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="img/icons//favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="img/icons//favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="img/icons//favicon-16x16.png">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
	</head>

	<?php
            require_once("php/get_products_info.php");//Toma la id dada por la pagina anterior

			//Obtiene los datos del producto con ese id y los guarda en las variables de aca abajo
			$id_producto=$_GET['id_product'];
			$producto_actual=new Producto($id_producto,false);
			$product_name=$producto_actual->GetProductName();
			$product_category=$producto_actual->GetProductCategory();
			$product_id_category=$producto_actual->GetProductIdCategory();
			$product_subcategory=$producto_actual->GetProductSubCategory();
			$product_subcategory_id=$producto_actual->GetProductIdSubCategory();
            $product_description=$producto_actual->GetProductDescription();
			$product_details=$producto_actual->GetProductDetails();

			$related_products_id=$producto_actual->GetRelatedProducts($product_subcategory_id,$id_producto,$product_id_category);
			
			for($f=0;$f<4;$f++){//Se corre 4 veces, una para cada imagen de producto
				$product_image[$f]=$producto_actual->GetImagePath($f);//Obtiene la ruta de las imagenes

					$related_product[$f]=new Producto($related_products_id[$f],true);//Crea un nuevo producto con las id de los productos relacionados
					if($related_products_id[$f]!="0000"){
						$related_links[$f]="https://equipamientos-esperanza.000webhostapp.com/product?id_product=".$related_products_id[$f];
					}
					else{
						$related_links[$f]="";
					}
					
			}

		?>
	

	<body>
	<div class="overlay" id="overlay">
			<div class="popup" id="popup">
				<a href="#" id="btn-cerrar-popup" class="btn-cerrar-popup"><i class="fa fa-times"></i></a>
				<h3>CONTACTANOS</h3>
				<br><br>
				<h4><i style="color:#ef233c" class="fa fa-phone text-left"></i> 1144343604</h4>
				<h4><i style="color:#ef233c" class="fa fa-envelope-o text-left"></i> a_esperanza@hotmail.com</h4>
				<h4><i style="color:#ef233c" class="fa fa-map-marker"></i> 1978 Av. del Libertador(R. 23) Moreno</h4>

				<div class="col-md-5 "style="display:flex; justify-content:center; width:100%;">
						<div class="product-details">      
						
							<div class="add-to-cart">
								<br>
							<a href="https://equipamientos-esperanza.000webhostapp.com/contacto"><button style="outline:none;" class="add-to-cart-btn"><i class="fa fa-envelope"></i>Envianos un mail</button></a>
							</div>	
							</div>
						</div>
			</div>
		</div>
	</div>



<header>
			<div id="top-header">
				<div class="header_info_container">
				<ul class="header-links">
						<li><a><i class="fa fa-phone"></i> 1144343604</a></li>
						<li><a><i class="fa fa-envelope-o"></i> a_esperanza@hotmail.com</a></li>
						<li><a><i class="fa fa-map-marker"></i> 1978 Av. del Libertador(R. 23) Moreno</a></li>
					</ul>
				</div>
			</div>
			<div class=main_header>
				<div class="logo_section">
					<div class="logo_container">
						<a href="https://equipamientos-esperanza.000webhostapp.com/index">
						<img src="img/logo.png" alt="logo" style="width:100%;">
						</a>
					</div>
				</div>

				<div class="search_section">
					<div class="search_container">
						
					<div class="header-search">
								<form method="post" action="php/redirect_product.php" style=" width:100%;">
									<select class="input-select" style="outline:none;" name="categoria">
										<option value="0" style="">Todas las categorias</option>
										<?php
											require_once("php/conexion.php");
											AbrirBase();
											$query="SELECT nombre_categoria FROM categoria WHERE estado='1' AND id_categoria!='0000'";
											$resultado=$mysqli->query($query);
											while($row=$resultado->fetch_object()){
												echo "<option value='$row->nombre_categoria'>$row->nombre_categoria</option>";
											}
											
										?>

									</select>
									<input class="input" name="busqueda" required="required" placeholder="Escribe aqui">
									<button class="search-btn" type="submit" style="outline:none;">Buscar</button>
								</form>
							</div>
					</div>
				</div>
				
			</div>
		</header>

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li><a href="https://equipamientos-esperanza.000webhostapp.com/index">Inicio</a></li>
						<li><a href="https://equipamientos-esperanza.000webhostapp.com/categorias">Categorias</a></li>
						<li><a href="https://equipamientos-esperanza.000webhostapp.com/contacto">Contacto</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->

		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="#">Home</a></li>
							<li><a href="#">Categorias</a></li>
							<li><a href="#" class="font-weight-bold"><?php echo $product_category; ?></a></li>
							<li class="active"><?php echo $product_subcategory; ?></li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /BREADCRUMB -->

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
								<img src=<?php echo $product_image[0]; ?> alt="">
							</div>

							<div class="product-preview">
								<img src=<?php echo $product_image[1]; ?> alt="">
							</div>

							<div class="product-preview">
								<img src=<?php echo $product_image[2]; ?> alt="">
							</div>

							<div class="product-preview">
								<img src=<?php echo $product_image[3]; ?> alt="">
							</div>
						</div>
					</div>
					<!-- /Product main img -->

					<!-- Product thumb imgs -->
					<div class="col-md-2  col-md-pull-5">
						<div id="product-imgs">
							<div class="product-preview">
								<img src=<?php echo $product_image[0]; ?> alt="">
							</div>

							<div class="product-preview">
								<img src=<?php echo $product_image[1]; ?> alt="">
							</div>

							<div class="product-preview">
								<img src=<?php echo $product_image[2]; ?> alt="">
							</div>

							<div class="product-preview">
								<img src=<?php echo $product_image[3]; ?> alt="">
							</div>
						</div>
					</div>
					<!-- /Product thumb imgs -->

					<!-- Product details -->
					<div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name"><?php echo $product_name; ?></h2>
							                       
						
							<div class="add-to-cart">
								<br>
								<button style="outline:none;" class="add-to-cart-btn" id="btn-abrir-popup"><i class="fa fa-shopping-cart"></i>Contactanos!</button>
							</div>	

							<p><?php echo $product_description; ?></p>




						</div>
					</div>
					<!-- /Product details -->

					<!-- Product tab -->
					<div class="col-md-12">
						<div id="product-tab">
							<!-- product tab nav -->
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Especificaciones</a></li>
								<li><a data-toggle="tab" href="#tab2"></a></li>
							</ul>
							<!-- /product tab nav -->

							<!-- product tab content -->
							<div class="tab-content">
								<!-- tab1  -->
								<div id="tab1" class="tab-pane fade in active">
									<div class="row">
										<div class="col-md-12">
											<p><?php echo $product_details; ?></p>
										</div>
									</div>
								</div>
								<!-- /tab1  -->							
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
							<h3 class="title">Productos relacionados</h3>
						</div>
					</div>

					<!-- product -->
					<a href=<?php echo $related_links[0]; ?>>
					<div class="col-md-3 col-xs-6">
						<div class="product">
							<div class="product-img">
								<img src=<?php echo $related_product[0]->GetImagePath("0") ?> alt="">
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $related_product[0]->GetProductCategory(); ?></p>
                                <h3 class="product-name"><a href="#"><?php echo $related_product[0]->GetProductName(); ?></a></h3>
                                
							</div>
						</div>
					</div>
					</a>
					<!-- /product -->

					<!-- product -->
					<a href=<?php echo $related_links[1]; ?>>
					<div class="col-md-3 col-xs-6">
						<div class="product">
							<div class="product-img">
								<img src=<?php echo $related_product[1]->GetImagePath("0") ?> alt="">
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $related_product[1]->GetProductCategory(); ?></p>
								<h3 class="product-name"><a href="#"><?php echo $related_product[1]->GetProductName(); ?></a></h3>

							</div>
						</div>
					</div>
					</a>
					<!-- /product -->

					<div class="clearfix visible-sm visible-xs"></div>

					<!-- product -->
					<a href=<?php echo $related_links[2]; ?>>
					<div class="col-md-3 col-xs-6">
						<div class="product">
							<div class="product-img">
								<img src=<?php echo $related_product[2]->GetImagePath("0") ?> alt="">
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $related_product[2]->GetProductCategory(); ?></p>
								<h3 class="product-name"><a href="#"><?php echo $related_product[2]->GetProductName(); ?></a></h3>
								
							</div>
						</div>
					</div>
					</a>
					<!-- /product -->

					<!-- product -->
					<a href=<?php echo $related_links[3]; ?>>
					<div class="col-md-3 col-xs-6">
						<div class="product">
							<div class="product-img">
								<img src=<?php echo $related_product[3]->GetImagePath("0") ?> alt="">
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $related_product[3]->GetProductCategory(); ?></p>
								<h3 class="product-name"><a href="#"><?php echo $related_product[3]->GetProductName(); ?></a></h3>

							</div>
						</div>
					</div>
					</a>
					<!-- /product -->

				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /Section -->

		

		<!-- FOOTER -->
		<footer id="footer">
			<div class="footer_container">	
			<div class="footer_column">
				  <h3 class="footer-title">Sobre nosotros</h3>
					<div id="footer_aboutus">
							<p style="text-align:left;">Somos una empresa con mas de 30 años de trayectoria.Nos dedicamos principalmente a la venta de equipamientos comerciales.</p>				
					</div>

					

			</div>									

			<div class="footer_column">
				<h3 class="footer-title">Secciones</h3>
				<ul class="footer-links">
									<li><a href="https://equipamientos-esperanza.000webhostapp.com/index">Inicio</a></li>
									<li><a href="https://equipamientos-esperanza.000webhostapp.com/categorias">Categorias</a></li>
									<li><a href="https://equipamientos-esperanza.000webhostapp.com/contacto">Contacto</a></li>
				</ul>
			</div>

			<div class="footer_column">
				<h3 class="footer-title">Categorias</h3>
				<ul class="footer-links">
				<?php
					require_once('php/conexion.php');
					AbrirBase();
					$query="SELECT nombre_categoria FROM categoria WHERE estado='1' LIMIT 3";
					$resultado=$mysqli->query($query);
					while($row=$resultado->fetch_object()){
						$link="https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=0&from=0&categoria=$row->nombre_categoria&subcategoria=0";
						echo "<li><a href='$link'>$row->nombre_categoria</a></li>";
					}
				?>
				<li><a href="https://equipamientos-esperanza.000webhostapp.com/categorias">...</a></li>
				</ul>
			</div>

			<div class="footer_column">
					<h3 class="footer-title">Contacto</h3>
					<ul class="footer-links">
									<li><a><i class="fa fa-map-marker"></i> 1978 Av. del Libertador(R. 23) Moreno</a></li>
									<li><a><i class="fa fa-phone"></i> 1144343604</a></li>
									<li><a><i class="fa fa-envelope-o"></i> a_esperanza@hotmail.com</a></li>
					</ul>
			</div>
		</div>

		<span class="copyright" style="margin-top:100px;">
		<p style="text-align:center; margin-top:80px; margin-bottom:40px;">Copyright <i class="fa fa-copyright"></i> Sunless Software.</p>
		</span>

		</footer>

		<!-- /FOOTER -->


		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/popup.js"></script>
	</body>

	<?php
		CerrarBase();
	?>
</html>
