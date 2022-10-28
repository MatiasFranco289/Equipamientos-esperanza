<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <title>Panel de Administracion</title>
</head>
<body ng-app='MyApp' ng-controller="PanelController">
    <header>
        <div id="header">
            <div class="container">
                <div class="col-md-3">
                    <img src="img/logo.png" width="180px" height="90px" alt="">
                </div>
                <div class="col-md-6" style="padding-top:15px">
                    <h2 align="center" style="color:white;">Panel de Administración</h2>
                </div>
                <div class="col-md-3" id="loginDiv" style="display:none;">
                    <button class="btn-default" ng-click="logout()">Salir</button>
                </div>
            </div>
        </div>
    </header>
    <!-- Cuerpo del panel de administracion --> 
    <div class="container-panel-box">
        <!-- Formulario de login-->
        <div class="login-box" id="login-box">
            <img class="avatar" src="img/logo.png" alt="Equipamientos Comerciales" width="180px" height="90px">
            <br>
            <h1 style="color:white;">Ingrese aquí</h1>
            <form id="form_login">
                <label for="usuario">Usuario</label>
                <input ng-model="user" type="text" name="user" placeholder="Ingrese usuario">

                <label for="password">Contraseña</label>
                <input ng-model="password" type="password" name="password" placeholder="Ingrese contraseña">

                <button ng-click="login()">Ingresar</button>                
            </form>
        </div>
        <!-- Gif Cargando -->
        <div class="loading" style="display:none;" id="loading">
            <img src="img/loading.gif" alt="Cargando...">
        </div>
        
        <!-- Mensaje de login incorrecto -->
        <div class="overlay" id="overlayLog">
            <div class="popup" id="popupLog">
                <a href="#" id="cerrarPopupLog" class="btn-cerrar-popup"><i class="fa fa-times"></i></a>
                <h3>Contraseña incorrecta</h3>
                <br><br>
                <p>El usuario o la contraseña proporcionada no corresponde a un usuario asociado al sistema.</p>
                <p>Por favor, verifique e intente ingresar nuevamente.</p>
                <p>Si el problema persiste, contáctese con el administrador.</p>
            </div>
        </div>

        <!-- Panel de Categorias-->
        <div>
            <div class="panel-box" id="panel-categoria">
                <div class="header-box">
                    <h3 class="tittle-box">Categorias</h3>
                    <button class="btnAdd" ng-click="addCategoria()">Añadir</button>               
                </div>
                <div class="header-search">
                    <form action="" >
                        <input class="input" name="busqueda" style="color:black; border-radius: 40px 0px 0px 40px;width:325px" placeholder="Escribe aqui..." ng-model="busquedaCat" value="">
					    <button ng-click="busquedaCategoria()" class="search-btn" style="outline:none;">Buscar</button>
                    </form>
                </div>
                <div class="body-box">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:80%;">Nombre</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="categoria in categorias" ng-click="viewCategoria(categoria.id_categoria)">
                                <td>{{categoria.nombre_categoria}}</td>
                                <td>{{categoria.estado}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            

            <!-- Panel de Subategorias-->
            <div class="panel-box" id="panel-subcategoria">
                <div class="header-box">
                    <h3 class="tittle-box">Subcategorias</h3>
                    <button class="btnAdd" ng-click="addSubcategoria()">Añadir</button>               
                </div>
                <div class="header-search">
                    <form action="" >
                        <input class="input" name="busqueda" style="color:black; border-radius: 40px 0px 0px 40px;width:325px" placeholder="Escribe aqui..." ng-model="busquedaSubcat" value="">
					    <button ng-click="busquedaSubcategoria()" class="search-btn" style="outline:none;">Buscar</button>
                    </form>
                </div>
                <div class="body-box">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:80%;">Nombre</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="subcategoria in subcategorias" ng-click="viewSubcategoria(subcategoria.id_subcategoria)">
                                <td>{{subcategoria.nombre_subcategoria}}</td>
                                <td>{{subcategoria.estado}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <!-- Panel de PRODUCTOS-->
            <div class="panel-box" id="panel-producto">
                <div class="header-box">
                    <h3 class="tittle-box">Productos</h3>
                    <button class="btnAdd" ng-click="addProducto()">Añadir</button>               
                </div>
                <div class="header-search">
                    <form action="">
                        <select class="input-select" style="outline:none;color:black;" ng-model="filterSubcat">
                            <option value="" disabled hidden>Filtrar</option>
                            <option value="-1" selected>Todas las subcategorias</option>
                                <?php
                                    require_once("php/conexion.php");
                                    AbrirBase();
                                    $query="SELECT id_subcategoria, nombre_subcategoria FROM subcategoria WHERE estado='1'";
                                    $resultado=$mysqli->query($query);
                                    while($row=$resultado->fetch_object()){
                                        echo "<option value='$row->id_subcategoria'>$row->nombre_subcategoria</option>";
                                    }											
                                ?>
                        </select>
                        <input class="input" name="busqueda" style="color:black;" placeholder="Escribe aqui..." ng-model="busquedaProd" value="">
					    <button ng-click="busquedaProducto()" class="search-btn" style="outline:none;">Buscar</button>
                    </form>
                </div>
                <div class="body-box">
                    <div id="tabla">            
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Subategoria</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="producto in productos" ng-click="viewProducto(producto.id_producto)">
                                    <td>{{producto.nombre_producto}}</td>
                                    <td>{{producto.nombre_subcategoria}}</td>
                                    <td>{{producto.estado}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div ng-show="!productos.length">
                        <img src="img/no_results.jpg" alt="Sin resultados">
                    </div>
                </div>
            </div>
        </div>

        <!-- Crear nueva categoria -->
        <div class="overlay" id="overlayCat">
            <div class="popup" id="popupCat">
                <a href="#" id="cerrarPopupCat" class="btn-cerrar-popup"><i class="fa fa-times"></i></a>
                <h3>{{titleCat}}</h3>
                <br><br>
                <form>
                    <div>
                        <label style="visibility: hidden;">{{categoria_id}}</label>
                        <label for="nombre_categoria">Nombre</label>
                        <input class="form-control" id="nombre_categoria" type="text" ng-model="nombre_categoria" placeholder="Ingrese categoría">
                    </div>
                    <div>
                        <label for="estado_categoria">Estado</label>
                        <select class="form-control" id="estado_categoria" ng-model="estado_categoria">
                            <option value="1">Activa</option>
                            <option value="0">Baja</option>
                        </select>
                    </div>
                    <button class="btn-default" ng-click="submitCategoria()">Aceptar</button>
                </form>
            </div>
        </div>
        
        <!-- Crear nueva subcategoria -->
        <div class="overlay" id="overlaySubCat">
            <div class="popup" id="popupSubCat">
                <a href="#" id="cerrarPopupSubCat" class="btn-cerrar-popup"><i class="fa fa-times"></i></a>
                <h3>{{titleSubcat}}</h3>
                <br><br>
                <form>
                    <div>
                        <label style="visibility: hidden;">{{id_subcategoria}}</label>
                        <label for="nombre_subcategoria">Nombre</label>
                        <input class="form-control" id="nombre_subcategoria" type="text" ng-model="nombre_subcategoria" placeholder="Ingrese subcategoría">
                    </div>
                    <div>
                        <label for="estado_subcategoria">Estado</label>
                        <select class="form-control" id="estado_subcategoria" ng-model="estado_subcategoria">
                            <option value="1">Activa</option>
                            <option value="0">Baja</option>
                        </select>
                    </div>
                    <div>
                        <label for="pertenece_categoria">Pertenece a</label>
                        <select class="form-control" id="pertenece_categoria" ng-model="subcat_categorias.model">
                            <option ng-repeat="option in subcat_categorias.opciones" value="{{option.id_categoria}}">{{option.nombre_categoria}}</option>
                        </select>
                    </div>
                    <button class="btn-default" ng-click="submitSubcategoria()">Aceptar</button>
                </form>
            </div>
        </div>

        <!-- Crear nuevo producto -->
        <div class="overlay" id="overlayProd">
            <div class="popup" id="popupProd">
                <a href="#" id="cerrarPopupProd" class="btn-cerrar-popup"><i class="fa fa-times"></i></a>
                <h3>{{titleProd}}</h3>
                <br><br>
                <form>
                    <div class="form-group">
                        <label style="visibility: hidden;">{{producto_id}}</label>
                        <input class="form-control" id="nombre_producto" type="text" ng-model="nombre_producto" placeholder="Ingrese nombre del producto">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" cols="30" rows="5" ng-model="detalle_producto" placeholder="Ingrese detalles del producto..."></textarea>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" cols="30" rows="5" ng-model="especificacion_producto" placeholder="Ingrese especificaciones del producto..."></textarea>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="producto_subcategoria" ng-model="prod_subcats.model">
                            <option ng-repeat="prod_subcat in prod_subcats.opciones" value="{{prod_subcat.id_subcategoria}}">{{prod_subcat.nombre_subcategoria}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="estado_producto" ng-model="estado_producto">
                            <option value="1">Activa</option>
                            <option value="0">Baja</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="upload-btn-wrapper">                          
                            <button class="btn"><img id="img_prod1" width="80px" height="80px"></button>
                            <input type="file" name="foto_categoria" id="foto_categoria1" onchange="document.getElementById('img_prod1').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="upload-btn-wrapper">
                            <button class="btn"><img id="img_prod2" width="80px" height="80px"></button>
                            <input type="file" name="foto_categoria" id="foto_categoria2" onchange="document.getElementById('img_prod2').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="upload-btn-wrapper">
                            <button class="btn"><img id="img_prod3" width="80px" height="80px"></button>
                            <input type="file" name="foto_categoria" id="foto_categoria3" onchange="document.getElementById('img_prod3').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        <div class="upload-btn-wrapper">
                            <button class="btn"><img id="img_prod4" width="80px" height="80px"></button>
                            <input type="file" name="foto_categoria" id="foto_categoria4" onchange="document.getElementById('img_prod4').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                    </div>
                    <button class="btn-default" ng-click="submitProducto()">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="js/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="js/controlador_panel.js"></script>


</body>
</html>