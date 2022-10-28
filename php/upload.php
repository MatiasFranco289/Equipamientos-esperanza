<?php
    //@session_start();
    //Inclusion de la conexion a la bd
    include("conexion.php");

    $categoria = $_REQUEST['categoria'];
    $subcategoria = $_REQUEST['subcategoria'];
    $producto = $_REQUEST['producto'];

    if(isset($_FILES['foto_categoria'])){
        $file = $_FILES['foto_categoria'];
        
        $fileName = $_FILES['foto_categoria']['name'];        
        $fileTmpName = $_FILES['foto_categoria']['tmp_name'];       
        $fileSize = $_FILES['foto_categoria']['size'];        
        $fileError = $_FILES['foto_categoria']['error'];        
        $fileType = $_FILES['foto_categoria']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg','jpeg','png');

        if(in_array($fileActualExt,$allowed)){
            if($fileError == 0){
                if($fileSize < 500000){//Check size
                    $fileNameNew = uniqid('', true).".".$fileActualExt;

                    $fileDestination = "img/uploads/".$categoria."/".$subcategoria."/".$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    $qrystr = "INSERT INTO foto (id_producto, archivo) VALUES ($producto,'$fileDestination')";

                    AbrirBase();
                    $rs = $mysqli->query($qrystr);
                    CerrarBase();

                    $response = "ok";
                }
                else{
                    $response = "El archivo es demasiado grande";
                }
            }
            else{
                $response = "Ocurrio un error al subir el archivo";
            }
        }
        else{
            $response = "Tipo de archivo seleccionado inválido";
        }
    }    
    
?>