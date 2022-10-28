<?php
    //@session_start();
    //Inclusion de la conexion a la bd
    include("conexion.php");

    $id_subcategoria = $_REQUEST['id_subcategoria'];
    $busqueda = $_REQUEST['busqueda'];
    
    //Seleccion de query
    if($id_subcategoria == -1 && $busqueda == -1){//Listado de todas las categorias
        $qrystr = "SELECT id_subcategoria, nombre_subcategoria, estado FROM subcategoria ORDER BY nombre_subcategoria";
    }
    else{
        if($id_subcategoria == -2 && $busqueda == -1){//Listado de subcategorias activas (Para combobox)
            $qrystr = "SELECT id_subcategoria, nombre_subcategoria FROM subcategoria WHERE estado = 1 ORDER BY nombre_subcategoria";
        }
        else{//Listado de una categoria en particular
            if($busqueda == -1){
                $qrystr = "SELECT * FROM subcategoria WHERE id_subcategoria = ".$id_subcategoria;
            }
            else{
                $qrystr = "SELECT * FROM subcategoria WHERE nombre_subcategoria LIKE '%".$busqueda."%'";
            }
        }
    }
    

    AbrirBase();
    $rs = $mysqli->query($qrystr);
    CerrarBase();
    
    while($obj = $rs->fetch_object()){//Recorre el objeto
        if($id_subcategoria == -1){//Transformar el valor de estado solo si es para listado
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
?>