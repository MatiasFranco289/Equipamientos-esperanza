<?php
    //@session_start();
    //Inclusion de la conexion a la bd
    include("conexion.php");

    $id_producto = $_REQUEST['id_producto'];
    $id_subcat = $_REQUEST['id_subcat'];
    $busqueda = $_REQUEST['busqueda'];
    
    //Seleccion de query
    if($id_producto == -1){
        if($id_subcat == -1){
            if($busqueda == -1){//Listado de todos los productos de todas las categorias
                $qrystr = "SELECT id_producto, nombre_producto, nombre_subcategoria, p.estado estado 
                    FROM producto p 
                    JOIN subcategoria s 
                    ON p.id_subcategoria = s.id_subcategoria 
                    ORDER BY nombre_producto";
            }
            else{//Busqueda en todos los productos de todas las categorias
                $qrystr = "SELECT id_producto, nombre_producto, nombre_subcategoria, p.estado estado 
                    FROM producto p 
                    JOIN subcategoria s 
                    ON p.id_subcategoria = s.id_subcategoria
                    AND nombre_producto LIKE '%".$busqueda."%' 
                    ORDER BY nombre_producto";
            }            
        }
        else{
            if($busqueda == -1){//Listado de todos los productos de una categoria en especifico
                $qrystr = "SELECT id_producto, nombre_producto, nombre_subcategoria, p.estado estado 
                    FROM producto p 
                    JOIN subcategoria s 
                    ON p.id_subcategoria = s.id_subcategoria 
                    AND p.id_subcategoria = ".$id_subcat." 
                    ORDER BY nombre_producto";
            }
            else{//Busqueda en todos los productos de una determinada categoria
                $qrystr = "SELECT id_producto, nombre_producto, nombre_subcategoria, p.estado estado 
                    FROM producto p 
                    JOIN subcategoria s 
                    ON p.id_subcategoria = s.id_subcategoria 
                    AND p.id_subcategoria = ".$id_subcat."  
                    AND nombre_producto LIKE '%".$busqueda."%' 
                    ORDER BY nombre_producto";
            }
        }       
    }
    else{//Retorna un producto en base a su ID
        $qrystr = "SELECT * FROM producto WHERE id_producto = ".$id_producto;
    }
    
    //echo $qrystr;
    AbrirBase();
    $rs = $mysqli->query($qrystr);
    CerrarBase();
    //echo $rs;
    $cant = mysqli_num_rows($rs);
    if($cant > 0){
        while($obj = $rs->fetch_object()){//Recorre el objeto
            if($id_producto == -1){//Transformar el valor de estado solo si es para listado
                if($obj->estado == 1)
                    $obj->estado = "Activa";
                else
                    $obj->estado = "Baja";
            }
            
            foreach($obj as &$valor){//Codifica los items del objeto
                $valor = utf8_encode($valor);
            }
            $arr[] = $obj;//Almacena los datos en un arreglo
        }
        echo $response = json_encode($arr);//Envio de respuesta codificada
    }
    else{
        echo $response = null;
    }
    

    
?>