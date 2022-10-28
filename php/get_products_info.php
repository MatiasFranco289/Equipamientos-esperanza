<?php
require'conexion.php';//ACTUALIZAR RUTA 

class Producto{

    var $nombre_producto;
    var $id_categoria;
    var $categoria;
    var $producto_descripcion;
    var $producto_detalles;
    var $id_foto;
    var $ruta_foto=array(0);
    var $id_subcategoria;
    var $nombre_subcategoria;

    function Producto($id,$related){//Establece conexion con la database, busca el producto con el id informado y rellena las variables de arriba
        global $mysqli;

        require_once("conexion.php");
        AbrirBase();
        $query="SELECT prod.nombre_producto,prod.id_subcategoria,prod.descripcion,prod.especificaciones,
        cat.id_categoria,subc.nombre_subcategoria,cat.nombre_categoria,prod.id_producto,
        prod.estado FROM producto AS prod INNER JOIN 
        subcategoria AS subc ON(prod.id_subcategoria=subc.id_subcategoria)
        INNER JOIN categoria AS cat ON(cat.id_categoria=subc.id_categoria)
        WHERE prod.estado='1' AND prod.id_producto='$id' GROUP BY prod.id_producto";

        $resultado=$mysqli->query($query);
        $tamaño=mysqli_num_rows($resultado);
        

        /*
        if($tamaño==0){
            CerrarBase();
            echo "Error, pagina no encontrada";
            exit();
        }
        */

        if($tamaño!=0){//Si la query dio resultados
            $row=$resultado->fetch_object();
            $this->id_producto=$row->id_producto;
            $this->id_subcategoria=$row->id_subcategoria;
            $this->nombre_producto=$row->nombre_producto;
            $this->producto_descripcion=$row->descripcion;
            $this->producto_detalles=$row->especificaciones;
            $this->id_categoria=$row->id_categoria;
            $this->nombre_subcategoria=$row->nombre_subcategoria;
            /*$this->ruta_foto=$row->archivo;*/
            $this->categoria=$row->nombre_categoria;

            $query="SELECT archivo FROM foto WHERE id_producto='$id'";
            $resultado=$mysqli->query($query);

            $contador=0;
            while($row=$resultado->fetch_object()){
                $this->ruta_foto[$contador]=$row->archivo; 
                $contador++;
            }
        }
        else if(!$related){//Si no encuentro ningun producto con la id dada
                  CerrarBase();
                  echo "Error, pagina no encontrada";
                  exit();
        }

    }

    //Estas funciones devuelven los diferentes datos del producto
    function GetProductName(){
        return $this->nombre_producto;
    }

    function GetProductCategory(){
        return $this->categoria;
    }

    function GetProductIdCategory(){
        return $this->id_categoria;
    }

    function GetProductSubCategory(){
        return $this->nombre_subcategoria;
    }

    function GetProductIdSubCategory(){
        return $this->id_subcategoria;
    }

    function GetProductDescription(){
        return $this->producto_descripcion;
    }

    function GetProductDetails(){
        return $this->producto_detalles;
    }

    function GetImagePath($image_n){//Hay 4 imagenes de cada producto, $imagen_n hace referencia a cual de las 4 queres
        /*$ruta=$this->ruta_foto."/".$image_n.".png";*/
        $ruta=$this->ruta_foto[$image_n];

        if(!file_exists($ruta)){//Si la ruta no existe
            $ruta="img/404.png";//Tiro la imagen de 404
        }
        return $ruta;
    }


    function GetRelatedProducts($id_subcategoria,$id_productoActual,$id_categoria){

     function GetRandoms($matchs){
        $randoms=range(0,$matchs-1);
        shuffle($randoms);
        return $randoms;
     }

        global $mysqli;
         $related_products_id=array("");
         $final_products_id=array("");
         $contador=0;

        $query="SELECT id_producto,id_subcategoria,estado FROM producto WHERE id_subcategoria='$id_subcategoria' AND estado='1' AND id_producto!='$id_productoActual' LIMIT 10";
       
        $resultado=$mysqli->query($query);
        
        while(($row=$resultado->fetch_object())){//Se corre mientras haya productos en la tabla
                $related_products_id[$contador]=$row->id_producto;//Guardo la id del producto aca
                $contador++;//Sumo este contador
        }

        if($contador>4){//Si encontro mas de 4 productos relacionados
            $randoms=array(0,0,0,0);
            $randoms=GetRandoms($contador);//Guardo los randoms obtenidos en el array
            for($f=0;$f<4;$f++){
                $final_products_id[$f]=$related_products_id[$randoms[$f]];
            }
            
        }
        else if($contador==4){//Si encontro 4 productos relacionados
            $final_products_id=$related_products_id;//Como no puede elegir porque hay justo 4 iguala la variable que va a retornar
        }
        else{//Si encontro menos de 4 productos relacionados
            if($contador>0){//Si al menos encontro un producto
                $final_products_id=$related_products_id;//Lo guarda aca
            }
            
            //La query pregunta por posiciones 0,1,2 es posible que alguna de estas posiciones esten vacias en el array asi que lo paso a un array donde si estan vacias los relleno con 0
            $FinalForQuery=array("");

            for($f=0;$f<4;$f++){
                if(isset($final_products_id[$f])){//Si el indice existe
                    $FinalForQuery[$f]=$final_products_id[$f];//Los igualo
                }
                else{
                    $FinalForQuery[$f]="0";
                }
            }


            //Uno tres tablas para poder buscar todos los productos pertenecientes a la misma categoria que este
            $query="SELECT * FROM categoria AS cat
            INNER JOIN subcategoria AS subc
            ON (cat.id_categoria= subc.id_categoria)
            INNER JOIN producto AS prod
            ON (subc.id_subcategoria = prod.id_subcategoria) WHERE (cat.id_categoria='$id_categoria' 
            AND prod.id_producto!='$id_productoActual' 
            AND prod.id_producto!='$FinalForQuery[0]' 
            AND prod.id_producto!='$FinalForQuery[1]'
            AND prod.id_producto!='$FinalForQuery[2]')
            AND prod.estado='1' LIMIT 10";

            $resultado=$mysqli->query($query);
            

            while($row=$resultado->fetch_object()){//Mientras que hayan productos
                    $final_products_id[$contador]=$row->id_producto;
                    $contador++;
            }
            
            shuffle($final_products_id);
            

            if($contador<4){//Si siguen faltando productos
                for($f=$contador;$f<4;$f++){
                    $final_products_id[$f]="0000";
                }
            }
         
        }

        return $final_products_id;
        
    }
}


?>