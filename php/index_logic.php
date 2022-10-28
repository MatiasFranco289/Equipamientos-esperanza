<?php
$id_principalCategories=array(0);
$ultimas_categorias=array("","","");
$product_name_last4=array("");
$product_category_last4=array("");
$product_img_last4=array("");
$product_link_last4=array("");

    require_once('conexion.php');
    
    function GetCategorias(){
        global $mysqli;
        global $id_principalCategories;

        //Uno varias tablas y obtengo las tres primeras categorias y una foto de uno de sus productos

        $query="SELECT DISTINCT cat.id_categoria,cat.nombre_categoria,fot.archivo FROM categoria AS cat INNER JOIN
       subcategoria AS subc ON(cat.id_categoria=subc.id_categoria)
       INNER JOIN producto AS prod ON(subc.id_subcategoria=prod.id_subcategoria)
       INNER JOIN foto AS fot ON(prod.id_producto=fot.id_producto) WHERE fot.orden=1  GROUP BY cat.id_categoria LIMIT 3";

        $resultado=$mysqli->query($query);

        for($f=0;$f<3;$f++){//Esto se corre tres veces porque salen tres categorias

            $row=$resultado->fetch_object();
            $id_principalCategories[$f]=$row->id_categoria;//Guardo el id de la categoria aca para usarlo en otra funcion
            $foto=$row->archivo;
            $nombre_categoria=$row->nombre_categoria;
            $link="https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=0&from=0&categoria=$nombre_categoria&subcategoria=0";//Link de la categoria
            echo//Esto es el cuadrito con la imagen y nombre de la categoria           
            "
            <a href='$link'>
            <div class='col-md-4 col-xs-6'>
            <div class='shop'>
            <div class='shop-img'>
            <img src='$foto' alt='CategoriaImage'>
            </div>
            <div class='shop-body'>
            <h3>$nombre_categoria<br>Coleccion</h3>
            <a href='$link' class='cta-btn'>Ver <i class='fa fa-arrow-circle-right'></i></a>
            </div>
            </div>
            </div>
            </a>";
        }
     
    }

    function ProductsFromCategorias(){//Esto muestra 6 productos, 2 de cada categoria
        global $mysqli;
        global $id_principalCategories;
        $array_randoms;
        $contador1=0;
        $contador2=0;
        $contador3=0;
        $nombre_categoria=array(0);
        $nombre_producto=array(0);
        $ruta_foto=array(0);
        $final_randoms=array(0,0);

        for($f=0;$f<3;$f++){//Se corre tres veces, una para cada categoria
            //Selecciono hasta 20 productos pertenecientes a cada una de las primeras 3 categorias
            $query="SELECT * FROM categoria AS cat
            INNER JOIN subcategoria AS subc
            ON (cat.id_categoria= subc.id_categoria)
            INNER JOIN producto AS prod
            ON (subc.id_subcategoria = prod.id_subcategoria) WHERE prod.estado='1' AND
            cat.id_categoria='$id_principalCategories[$f]' GROUP BY prod.id_producto LIMIT 20";


            $resultado=$mysqli->query($query);
            $cant = mysqli_num_rows($resultado);

            for($f1=0;$f1<$cant;$f1++){//Este for se correra la misma cantidad de veces que los productos que encontro
                $array_randoms[$f1]=$contador1;//Relleno el array(0,1,2,3...)
                $contador1++;
            }
            shuffle($array_randoms);//Mezclo el array
            
            //El problema es que a veces saca las dos veces el mismo random

            for($f4=0;$f4<2;$f4++){//Esto se corre dos veces
                if(isset($array_randoms[$f4])){//Si el array existe
                    $final_randoms[$f4]=$array_randoms[$f4];//Igualo $final_randoms al valor del array_randoms en la posicion $random
                }
            }

            sort($final_randoms);//Ordeno el array de menor a mayor
            $contador1=0;
            
            while(($row=$resultado->fetch_object()) && $contador2<2){//Se corre hasta que encuentre dos coincidencias
                if($final_randoms[$contador2]==$contador1){
                    $nombre_producto[$contador3]=$row->nombre_producto;
                    $nombre_categoria[$contador3]=$row->nombre_categoria;
                    $query2="SELECT archivo FROM foto WHERE id_producto='$row->id_producto'";//Busco en la tabla fotos la ruta de la foto que coincida con este producto
                    $resultado2=$mysqli->query($query2);
                    $row2=$resultado2->fetch_object();
                    $ruta_foto[$contador3]=$row2->archivo;//.'/0.png';//Guardo la ruta de la foto
                    $link[$contador3]="https://equipamientos-esperanza.000webhostapp.com/product?id_product=$row->id_producto";//Genera el link para este producto
                    $contador2++;
                    $contador3++;
                }
                $contador1++;
            }
            
            //Resetea variables usadas
            $contador1=0;
            $contador2=0;
            $array_randoms=array(0);
            $final_randoms=array(0);
        }



        for($f=0;$f<$contador3;$f++){//Se corre la cantidad de productos que encontro, deberian ser 6, 2 de cada categoria, pero si encuentra menos muestra solo esos  
            echo//Esto es el cuadrito con la imagen y nombre de la categoria 
            "
            <div class='product'>
            <a href='$link[$f]'>
            <div class='product-img'>
            <img src='$ruta_foto[$f]' alt='product_img'>
            </div>
            <div class='product-body'>
            <p class='product-category'>$nombre_categoria[$f]</p>
            <h3 class='product-name'><a href='$link[$f]'>$nombre_producto[$f]</a></h3>		
            </div>
            
            </a>
            </div>";
        }


    }
   
    function GetNewProducts(){//Esta funcion imprime los ultimos 6 productos de la tabla productos
        global $mysqli;
        $nombre_producto;
        //Solicito los primeros 6 productos de la tabla productos
        $query="SELECT prod.nombre_producto,fot.archivo,cat.nombre_categoria,prod.id_producto
        FROM producto AS prod INNER JOIN foto
        AS fot ON(prod.id_producto=fot.id_producto) INNER JOIN
        subcategoria AS subc ON(prod.id_subcategoria=subc.id_subcategoria)
        INNER JOIN categoria AS cat ON(subc.id_categoria=cat.id_categoria)
        WHERE prod.estado='1' GROUP BY prod.id_producto LIMIT 6";


        
        $resultado=$mysqli->query($query);

        while($row=$resultado->fetch_object()){
            
            $link="https://equipamientos-esperanza.000webhostapp.com/product?id_product=$row->id_producto";
            $ruta_foto=$row->archivo;
            
            echo "
            <div class='product'>
            <a href='$link'>
            <div class='product-img'>
            <img src='$ruta_foto' alt='producto imagen'>
            </div>
            <div class='product-body'>
            <p class='product-category'>$row->nombre_categoria</p>
            <h3 class='product-name'><a href='$link'>$row->nombre_producto</a></h3>
            </div>
            </a>
            </div>";
        }       
    }

    function LastCategoriesNames($category_num){//Devuelve el nombre de las ultimas 3 categorias
        global $mysqli;
        global $ultimas_categorias;
        $contador1=0;
        if($category_num==0){//Si es la primera vez que se llama la funcion
        //Solicito el nombre de las ultimas tres categorias
        $query="SELECT nombre_categoria
        FROM categoria WHERE estado='1'
        ORDER BY id_categoria DESC
        LIMIT 3";

        $resultado=$mysqli->query($query);
        while($row=$resultado->fetch_object()){
            $ultimas_categorias[$contador1]=$row->nombre_categoria;
            $contador1++;
        }
        }
        return $ultimas_categorias[$category_num];
    }

    function UpdateProductsLastCategory($category_num){//Obtiene los primeros 6 productos de cada una de las ultimas 3 categorias 
        global $mysqli;
        global $ultimas_categorias;
        global $product_name_last4;
        global $product_category_last4;
        global $product_img_last4;
        global $product_link_last4;




        $contador=0;
        //Pido los 6 primeros productos de la categoria $category_num
        $query="SELECT cat.nombre_categoria,fot.archivo,prod.nombre_producto,prod.id_producto 
        FROM categoria AS cat
        INNER JOIN subcategoria AS subc
        ON (cat.id_categoria= subc.id_categoria)
        INNER JOIN producto AS prod
        ON (subc.id_subcategoria = prod.id_subcategoria)
        INNER JOIN foto AS fot ON(prod.id_producto=fot.id_producto)
        WHERE cat.nombre_categoria='$ultimas_categorias[$category_num]' AND prod.estado='1' GROUP BY prod.id_producto
        LIMIT 6";

        $resultado=$mysqli->query($query);


        while($row=$resultado->fetch_object()){//Se corre la cantidad de productos que encontro(deberian ser 6)
            $product_name_last4[$contador]=$row->nombre_producto;
            $product_category_last4[$contador]=$row->nombre_categoria;
            $product_img_last4[$contador]=$row->archivo;
            $product_link_last4[$contador]="https://equipamientos-esperanza.000webhostapp.com/product?id_product=$row->id_producto";
            $contador++;
        }

        //Si los valores no son sobreescritos entonces pueden quedar valores residuales, esto vuelve null los espacios que no hayan sido sobreescritos
        for($f=$contador;$f<6;$f++){
            $product_name_last4[$f]=null;
        }
    }

    function ProductsLastCategory($visible){//Imprime los productos, recibe un 3 si originalmente estan visible y un 6 si estan ocultos
        global $product_name_last4;
        global $product_category_last4;
        global $product_img_last4;
        global $product_link_last4;
        $init=$visible-3;
        $entro=false;//esto verifica si entro aunque sea una vez



        for($f=$init;$f<$visible;$f++){
            if(isset($product_name_last4[$f])){//Si el producto existe

                $entro=true;
                echo "
                <a href='$product_link_last4[$f]'>
                <div class='product-widget'>
                <div class='product-img'>
                <img src='$product_img_last4[$f]' alt='imagen producto'>
                </div>
                <div class='product-body'>
                <p class='product-category'>$product_category_last4[$f]</p>
                <h3 class='product-name'><a href='$product_link_last4[$f]'>$product_name_last4[$f]</a></h3>
                </div>
                </div></a>";
            }
        }

        if(!$entro){//Si esto es falso es porque no entro nunca
            for($f=0;$f<6;$f++){//Revisa la variable entera en busca de algun producto que pueda mostrar, aunque este repetido
                if(isset($product_name_last4[$f])){//Si el producto existe
                    echo "
                    <a href='$product_link_last4[$f]'>
                    <div class='product-widget'>
                    <div class='product-img'>
                    <img src='$product_img_last4[$f]' alt='imagen producto'>
                    </div>
                    <div class='product-body'>
                    <p class='product-category'>$product_category_last4[$f]</p>
                    <h3 class='product-name'><a href='$product_link_last4[$f]'>$product_name_last4[$f]</a></h3>
                    </div>
                    </div></a>";

                }
            }
        }
        
    }


   
?>

