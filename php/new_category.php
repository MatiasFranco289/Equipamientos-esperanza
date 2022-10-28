<?php
    //@session_start();
    //Inclusion de la conexion a la bd
    include("conexion.php");
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
    }
    $nombre = $_REQUEST['nombre'];
    $estado = $_REQUEST['estado'];
    
    if(isset($id)){
        $qrystr = "UPDATE categoria SET nombre_categoria = '$nombre', estado = $estado WHERE id_categoria = $id";
    }
    else{
        $qrystr = "INSERT INTO categoria (nombre_categoria,estado) VALUES ('$nombre',$estado)";
    }
    
    
    AbrirBase();
    $rs = $mysqli->query($qrystr);
    CerrarBase();
    
    echo $response = "ok";//Envio de respuesta codificada
?>