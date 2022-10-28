<?php

$nombre = $_POST['nombre'];
$mail = $_POST['mail'];
$telefono = $_POST['telefono'];
$asunto = $_POST['asunto'];


$header = 'From: ' . $mail . " \r\n";
$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
$header .= "Mime-Version: 1.0 \r\n";
$header .= "Content-Type: text/plain";

$mensaje = "Este mensaje fue enviado por " . $nombre . ",\r\n";
$mensaje .= "Su e-mail es: " . $mail . " \r\n";
$mensaje .= "Su telefono es: " . $telefono . " \r\n";
$mensaje .= "Mensaje: " . $_POST['mensaje'] . " \r\n";
$mensaje .= "Enviado el " . date('d/m/Y', time());

$para = 'a_esperanza@hotmail.com';//Cambiar aca el mail si es necesario

mail($para, $asunto, utf8_decode($mensaje), $header);

header("Location:https://equipamientos-esperanza.000webhostapp.com/contacto?send=1");

?>