<?php
    //Post del formulario de login
    $user = $_REQUEST["user"];
    $password = $_REQUEST["password"];

    //Inclusion de la conexion a la bd
    include("conexion.php");

    //Corroborar usuario
    AbrirBase();
    $rs = $mysqli->query("SELECT * FROM usuario WHERE alias = '$user'");
    CerrarBase();
    if($row = $rs->fetch_object()){
        if($row->password == $password){
            @session_start();

            $_SESSION["user"] = $row->alias;
            $_SESSION["perfil"] = $row->perfil;
            $response="ok";
        }
        else{
            $response = "Los datos ingresados no son correctos, intente nuevamente";
        }
    }
    else{
        $response = "Los datos ingresados no son correctos, intente nuevamente";
    }
    echo $response;
?>