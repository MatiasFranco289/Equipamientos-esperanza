angular.module('MyApp', []).controller('PanelController', function($scope,$http){

      $scope.login = function(){
        //Se oculta el div de log y se muestra el div de Cargando
        $('#login-box').toggle();
        $('#loading').toggle();
        //Resetea los valores de los input de login
        $('form :input').val('');
        //Se envia el request a la base
        $http.post("php/login.php?user="+$scope.user+"&password="+$scope.password).success(function(data){
          //Se oculta el div e Cargando
          $('#loading').toggle();
          if(data == "ok"){
            //cargar paneles
            $('#panel-categoria').toggle();
            $('#panel-subcategoria').toggle();
            $('#panel-producto').toggle();
            $('#loginDiv').toggle();
          }
          else{
            //Cargar modal de datos incorrectos
            overlay('overlayLog','popupLog','cerrarPopupLog');
            $('#login-box').toggle();
          }

        })
      }

      $scope.logout = function(){
        $('#login-box').toggle();
        $('#panel-categoria').toggle();
        $('#panel-subcategoria').toggle();
        $('#panel-producto').toggle();
        $('#loginDiv').toggle();
      }
      //Mostrar Overlay Personalizado
      var overlay = function(id_overlay,id_popup,cerrar_popup){
        
        var overlay = document.getElementById(id_overlay),
          popup = document.getElementById(id_popup),
          btnCerrarPopup = document.getElementById(cerrar_popup);

	      overlay.classList.add('active');
	      popup.classList.add('active');

        btnCerrarPopup.addEventListener('click', function(e){
	        e.preventDefault();
	        overlay.classList.remove('active');
          popup.classList.remove('active');
        });
      }
      //Cerrar Overlay Personalizado
      var cerrarOverlay = function(id_overlay,id_popup){
        var overlay = document.getElementById(id_overlay),
          popup = document.getElementById(id_popup);

        overlay.classList.remove('active');
        popup.classList.remove('active');
      }

      //-----------------------------------------------------------------------------------------------------------------------------------------------------------------

      //Recupera el listado de todas las categorias
      $scope.recuperarCategorias = function(busqueda){
        if(busqueda == -1){
          $http.post("php/get_categories.php?id_categoria=-1&busqueda=-1").success(function(data){
            $scope.categorias = data;
          });
        }
        else{
          $http.post("php/get_categories.php?id_categoria=-1&busqueda="+busqueda).success(function(data){
            $scope.categorias = data;
          });
        }
      }

      $scope.addCategoria = function(){//ABRE OVERLAY PARA INGRESAR LOS DATOS DE NUEVA CATEGORIA
        $scope.titleCat = "Nueva categoría";
        $scope.nombre_categoria = "";
        $scope.estado_categoria = 1;
        overlay('overlayCat','popupCat','cerrarPopupCat');
      }

      var newCategoria = function(){//INSERTA UNA NUEVA CATEGORIA
        $('#loading').toggle();
        $http.post("php/new_category.php?nombre="+$scope.nombre_categoria+"&estado="+$scope.estado_categoria).success(function(data){
          $('#loading').toggle();
          if(data == 'ok'){
            cerrarOverlay('overlayCat','popupCat');
            $scope.recuperarCategorias(-1);
          }
          else{
            alert("No se agrego");
          }
        });
      }

      var editCategoria = function(){//EDITA UNA CATEGORIA EXISTENTE
        $http.post("php/new_category.php?id="+$scope.id_categoria+"&nombre="+$scope.nombre_categoria+"&estado="+$scope.estado_categoria).success(function(data){
          if(data == 'ok'){
            cerrarOverlay('overlayCat','popupCat');
            $scope.recuperarCategorias(-1);
          }
          else{
            alert("No se agrego");
          }
        });
      }

      $scope.viewCategoria = function(id_categoria){//CARGA LA VISTA DETALLADA DE UNA CATEGORIA EXISTENTE
        $scope.titleCat = "Editar categoría";
        overlay('overlayCat','popupCat','cerrarPopupCat');
        $http.post("php/get_categories.php?id_categoria="+id_categoria+"&busqueda=-1").success(function(data){
          categoria = data;
          $scope.id_categoria = categoria[0].id_categoria;
          $scope.nombre_categoria = categoria[0].nombre_categoria;
          $scope.estado_categoria = categoria[0].estado;
        });
      }

      $scope.submitCategoria = function(){//REDIRIJE LA FUNCIONALIDAD DEL BOTON ACEPTAR (SI AGREGA O SI EDITA UNA CATEGORIA)
        if($scope.titleCat == "Nueva categoría"){
            newCategoria();  
        }
        else{
            editCategoria();
        }
      }

      $scope.recuperarCategorias(-1);

      //-----------------------------------------------------------------------------------------------------------------------------------------------------------------

      $scope.recuperarSubcategorias = function(busqueda){
        if(busqueda == -1){
          $http.post("php/get_subcategories.php?id_subcategoria=-1&busqueda=-1").success(function(data){
            $scope.subcategorias = data;
          });
        }
        else{
          $http.post("php/get_subcategories.php?id_subcategoria=-1&busqueda="+busqueda).success(function(data){
            $scope.subcategorias = data;
          });
        }
      }

      $scope.addSubcategoria = function(){//ABRE OVERLAY PARA INGRESAR LOS DATOS DE NUEVA CATEGORIA
        $scope.titleSubcat = "Nueva subcategoría";
        $scope.nombre_subcategoria = "";
        $scope.estado_subcategoria = 1;
        //RECUPERA EL LISTADO DE LAS CATEGORIAS ACTIVAS DISPONIBLES PARA ASIGNAR
        $http.post("php/get_categories.php?id_categoria=-2&busqueda=-1").success(function(data){
          $scope.subcat_categorias = {
            model: null,
            opciones: data 
            };
        });

        overlay('overlaySubCat','popupSubCat','cerrarPopupSubCat');
      }

      var newSubcategoria = function(){//INSERTA UNA NUEVA SUBCATEGORIA
        $('#loading').toggle();
        $http.post("php/new_subcategory.php?id_cat="+$scope.subcat_categorias.model+"&nombre="+$scope.nombre_subcategoria+"&estado="+$scope.estado_subcategoria).success(function(data){
          $('#loading').toggle();
          if(data == 'ok'){
            cerrarOverlay('overlaySubCat','popupSubCat');
            $scope.recuperarSubcategorias(-1);
          }
          else{
            alert("No se agrego");
          }
        });
      }

      var editSubcategoria = function(){//EDITA UNA SUBCATEGORIA EXISTENTE
        $http.post("php/new_subcategory.php?id="+$scope.id_subcategoria+"&id_cat="+$scope.subcat_categorias.model+"&nombre="+$scope.nombre_subcategoria+"&estado="+$scope.estado_subcategoria).success(function(data){
          if(data == 'ok'){
            cerrarOverlay('overlaySubCat','popupSubCat');
            $scope.recuperarSubcategorias(-1);
          }
          else{
            alert("No se agrego");
          }
        });
      }

      $scope.viewSubcategoria = function(id_subcategoria){//CARGA LA VISTA DETALLADA DE UNA CATEGORIA EXISTENTE
        $scope.titleSubcat = "Editar subcategoría";
        overlay('overlaySubCat','popupSubCat','cerrarPopupSubCat');
        
        //Recupera la lista de categorias disponibles para asignar
        $http.post("php/get_categories.php?id_categoria=-2&busqueda=-1").success(function(data){
          $scope.subcat_categorias = {
            model: null,
            opciones: data 
            };
        });
        $http.post("php/get_subcategories.php?id_subcategoria="+id_subcategoria+"&busqueda=-1").success(function(data){
          
          subcategoria = data;

          $scope.id_subcategoria = subcategoria[0].id_subcategoria;       
          $scope.nombre_subcategoria = subcategoria[0].nombre_subcategoria;
          $scope.estado_subcategoria = subcategoria[0].estado;
          $("#pertenece_categoria option[value="+ subcategoria[0].id_categoria +"]").attr("selected",true);
        });

        
      }

      $scope.submitSubcategoria = function(){//REDIRIJE LA FUNCIONALIDAD DEL BOTON ACEPTAR (SI AGREGA O SI EDITA UNA CATEGORIA)
        if($scope.titleSubcat == "Nueva subcategoría"){
            newSubcategoria();  
        }
        else{
            editSubcategoria();
        }
      }

      $scope.recuperarSubcategorias(-1);

      //-----------------------------------------------------------------------------------------------------------------------------------------------------------------
      
      //Recupera el listado de todos los productos
      $scope.recuperarProductos = function(busqueda,subcategoria){
        if(busqueda == ''){
          if(subcategoria == -1){
            $http.post("php/get_products.php?id_producto=-1&id_subcat=-1&busqueda=-1").success(function(data){
              if(data == null){
                $scope.productos = null;
                $('#tabla').hide();
              }
              else{
                $scope.productos = data;  
              }
            });
          }
          else{
            $http.post("php/get_products.php?id_producto=-1&id_subcat="+subcategoria+"&busqueda=-1").success(function(data){
              $scope.productos = data;
            });
          }
        }
        else{
          if(subcategoria == -1){
            $http.post("php/get_products.php?id_producto=-1&id_subcat=-1&busqueda="+busqueda).success(function(data){
              $scope.productos = data;
            });
          }
          else{
            $http.post("php/get_products.php?id_producto=-1&id_subcat="+subcategoria+"&busqueda="+busqueda).success(function(data){
              $scope.productos = data;
            });
          }
        }
      }

      $scope.addProducto = function(){//ABRE OVERLAY PARA INGRESAR LOS DATOS DE NUEVA CATEGORIA

        $scope.titleProd = "Nuevo Producto";
        $scope.nombre_producto = "";
        $scope.detalle_producto = "";
        $scope.especificacion_producto ="";
        $scope.estado_producto = 1;
        //RECUPERA EL LISTADO DE LAS CATEGORIAS ACTIVAS DISPONIBLES PARA ASIGNAR
        $http.post("php/get_subcategories.php?id_subcategoria=-2").success(function(data){
          $scope.prod_subcats = {
            model: null,
            opciones: data 
            };
        });

        //Setear foto en image dafault
        resetSelectedPhoto();
        overlay('overlayProd','popupProd','cerrarPopupProd');
      }

      var resetSelectedPhoto = function(){
        var default_photo = "img/upload_photo2.png";
        var cont = 1;
        while(cont < 5){
          document.getElementById('img_prod'+cont).src = default_photo;
          cont++;
        }
      }

      var newProducto = function(){//INSERTA UN NUEVO PRODUCTO
        $('#loading').toggle();
        
        var foto1 = $('#foto_categoria1').prop('files')[0];
        var foto2 = $('#foto_categoria2').prop('files')[0];
        var foto3 = $('#foto_categoria3').prop('files')[0];
        var foto4 = $('#foto_categoria4').prop('files')[0];

        var form_data = new FormData();
        form_data.append('file1',foto1);
        form_data.append('file2',foto2);
        form_data.append('file3',foto3);
        form_data.append('file4',foto4);
        $.ajax({
          url: "php/new_product.php?nombre="+$scope.nombre_producto+"&detalle="+$scope.detalle_producto+"&especificacion="+$scope.especificacion_producto+"&subcategoria="+$scope.prod_subcats.model+"&estado="+$scope.estado_producto ,
          type: "POST",
          data: form_data,
          contentType: false,
          cache: false,
          processData: false,
          success: function(data){
            if(data == 'ok'){
              alert("El producto se agrego correctamente");
              cerrarOverlay('overlayProd','popupProd');
              $scope.recuperarProductos('',-1);
            }
            else{
              alert(data);
            }
          }
        });
        $('#loading').toggle();
      }

      var editProducto = function(){//EDITA UNA CATEGORIA EXISTENTE
        $('#loading').toggle();

        var foto1 = $('#foto_categoria1').prop('files')[0];
        var foto2 = $('#foto_categoria2').prop('files')[0];
        var foto3 = $('#foto_categoria3').prop('files')[0];
        var foto4 = $('#foto_categoria4').prop('files')[0];

        var form_data = new FormData();
        form_data.append('file1',foto1);
        form_data.append('file2',foto2);
        form_data.append('file3',foto3);
        form_data.append('file4',foto4);
        
        $.ajax({
          url: "php/new_product.php?id="+$scope.id_producto+"&nombre="+$scope.nombre_producto+"&detalle="+$scope.detalle_producto+"&especificacion="+$scope.especificacion_producto+"&subcategoria="+$scope.prod_subcats.model+"&estado="+$scope.estado_producto ,
          type: "POST",
          data: form_data,
          contentType: false,
          cache: false,
          processData: false,
          success: function(data){
            if(data == 'ok'){
              alert("El producto se modifico correctamente");
              cerrarOverlay('overlayProd','popupProd');
              $scope.recuperarProductos('',-1);
            }
            else{
              alert(data);
            }
          }
        });
        $('#loading').toggle();
      }

      $scope.viewProducto = function(id_producto){//CARGA LA VISTA DETALLADA DE UNA CATEGORIA EXISTENTE
        $scope.titleProd = "Editar producto";
        overlay('overlayProd','popupProd','cerrarPopupProd');
        
        //RECUPERA EL LISTADO DE LAS CATEGORIAS ACTIVAS DISPONIBLES PARA ASIGNAR
        $http.post("php/get_subcategories.php?id_subcategoria=-2").success(function(data){
          $scope.prod_subcats = {
            model: null,
            opciones: data 
            };
        });

        //Recupera el producto seleccionado
        $http.post("php/get_products.php?id_producto="+id_producto+"&id_subcat=-1&busqueda=-1").success(function(data){
          producto = data;

          $scope.id_producto = producto[0].id_producto;
          $scope.nombre_producto = producto[0].nombre_producto;
          $scope.detalle_producto = producto[0].descripcion;
          $scope.especificacion_producto = producto[0].especificaciones;
          $scope.estado_producto = producto[0].estado;
          $("#producto_subcategoria option[value="+ producto[0].id_subcategoria +"]").attr("selected",true);

        });
        //Resetear selected photos
        resetSelectedPhoto();
        //Recupera las fotos pertenecientes al producto seleccionado
        $http.post("php/get_photos.php?id_producto="+id_producto).success(function(data){
          
          fotos = data;
          fotos.forEach(function (element, index, array){
            var orden = element.orden;
            document.getElementById('img_prod'+orden).src = element.archivo;
          });

        });        
      }
      
      $scope.submitProducto = function(){//REDIRIJE LA FUNCIONALIDAD DEL BOTON ACEPTAR (SI AGREGA O SI EDITA UNA CATEGORIA)
        if($scope.titleProd == "Nuevo Producto"){
            newProducto();  
        }
        else{
            editProducto();
        }
      }
      
      $scope.busquedaProducto = function(){
        if($scope.busquedaProd == undefined){
          busquedaProd = '';
        }
        else{
          busquedaProd = $scope.busquedaProd;
        }

        if($scope.filterSubcat == undefined || $scope.filterSubcat == -1){
          
          $scope.recuperarProductos(busquedaProd,-1);
        }
        else{
          $scope.recuperarProductos(busquedaProd,$scope.filterSubcat);
        }       
      }

      $scope.busquedaCategoria = function(){
        
        if($scope.busquedaCat == undefined){
          busquedaCat = '';
        }
        else{
          busquedaCat = $scope.busquedaCat;
        }
        
        $scope.recuperarCategorias(busquedaCat);
      }

      $scope.busquedaSubcategoria = function(){
        if($scope.busquedaSubcat == undefined){
          busquedaSubcat = '';
        }
        else{
          busquedaSubcat = $scope.busquedaSubcat;
        }

        $scope.recuperarSubcategorias(busquedaSubcat);
      }

      $scope.recuperarProductos('',-1);

})