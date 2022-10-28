<?php
// CONFIGURACION BASE DE DATOS
$url= $_SERVER['HTTP_HOST'];
$dir_web = "equipamientoscomerciales.000webhostapp.com";
$dir_local = "localhost";

@session_start();	 

if ($url==$dir_local)//local
  {
	$c_database = "equipamientoscomerciales";//Nombre de tu base de datos
    $c_conexion ="localhost";//Esto dejalo asi
    $c_usuario ="root" ;
    $c_password = "";
  }
else//deploy
  {     
    $c_database = "id19777873_equipamientoscomerciales";  
    $c_conexion ="localhost";
    $c_usuario ="id19777873_deshens" ;
    $c_password = "User-1234567";
  }   
 
 
function AbrirBase()//Esto abre la base da datos
{
 global $c_database, $c_conexion, $c_usuario, $c_password, $mysqli;
 if (isset($mysqli)) $mysqli->close();
 $mysqli = new mysqli($c_conexion, $c_usuario, $c_password, $c_database);
 if ($mysqli->connect_errno) {
      echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                             }
 return $mysqli;
}

function CerrarBase(){//Esto cierra la conexion
  global $mysqli;
  mysqli_close($mysqli);
}
?>