<?php
    //@session_start();
    //Inclusion de la conexion a la bd
    include("conexion.php");

    $id_categoria = $_REQUEST['id_categoria'];
    $busqueda = $_REQUEST['busqueda'];
    
    //Seleccion de query
    if($id_categoria == -1 && $busqueda == -1){//Listado de todas las categorias
        $qrystr = "SELECT * FROM categoria ORDER BY nombre_categoria";
    }
    else{
        if($id_categoria == -2 && $busqueda == -1){//Listado de categorias activas (Para combobox)
            $qrystr = "SELECT id_categoria, nombre_categoria FROM categoria WHERE estado = 1 ORDER BY nombre_categoria";
        }
        else{//Listado de una categoria en particular
            if($busqueda == -1){
                $qrystr = "SELECT * FROM categoria WHERE id_categoria = ".$id_categoria;
            }
            else{
                $qrystr = "SELECT * FROM categoria WHERE nombre_categoria LIKE '%".$busqueda."%'";
            }
           
        }
    }
    

    AbrirBase();
    $rs = $mysqli->query($qrystr);
    CerrarBase();
    
    while($obj = $rs->fetch_object()){//Recorre el objeto
        if($id_categoria == -1){//Transformar el valor de estado solo si es para listado
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