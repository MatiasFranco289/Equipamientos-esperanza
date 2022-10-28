<?php
    //@session_start();
    //Inclusion de la conexion a la bd
    include("conexion.php");

    $id_producto = $_REQUEST['id_producto'];
    
    //Seleccion de query
    $qrystr = "SELECT * FROM foto WHERE id_producto = ".$id_producto;
    

    AbrirBase();
    $rs = $mysqli->query($qrystr);
    CerrarBase();
    
    while($obj = $rs->fetch_object()){//Recorre el objeto        
        foreach($obj as &$valor){//Codifica los items del objeto
            $valor = utf8_encode($valor);
        }
        $arr[] = $obj;//Almacena los datos en un arreglo
    }

    echo $response = json_encode($arr);//Envio de respuesta codificada
?>