<?php
    //@session_start();
    //Inclusion de la conexion a la bd
    include("conexion.php");
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
    }
    $id_cat = $_REQUEST['id_cat'];
    $nombre = $_REQUEST['nombre'];
    $estado = $_REQUEST['estado'];
    
    if(isset($id)){
        $qrystr = "UPDATE subcategoria SET id_categoria = $id_cat, nombre_subcategoria = '$nombre', estado = $estado WHERE id_subcategoria = $id";
    }
    else{
        $qrystr = "INSERT INTO subcategoria (id_categoria,nombre_subcategoria,estado) VALUES ($id_cat,'$nombre',$estado)";
    }
    
    
    AbrirBase();
    $rs = $mysqli->query($qrystr);
    CerrarBase();
    
    echo $response = "ok";//Envio de respuesta codificada
?>