<?php
    //@session_start();
    //Inclusion de la conexion a la bd
    include("conexion.php");
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
    }
    $nombre = $_REQUEST['nombre'];
    $detalle = $_REQUEST['detalle'];
    $especificacion = $_REQUEST['especificacion'];
    $id_subcategoria = $_REQUEST['subcategoria'];
    $estado = $_REQUEST['estado'];
    
    $response = 'ok';

    if(isset($id)){//Editar producto
        $qrystr = "UPDATE producto SET id_subcategoria = $id_subcategoria, nombre_producto = '$nombre', descripcion = '$detalle', especificaciones = '$especificacion', estado = $estado WHERE id_producto = $id";
        AbrirBase();
        $rs = $mysqli->query($qrystr);
        
        for ($i=1; $i<5 ; $i++) { 
            $foto = "file$i";
            //Guardar foto
            if(isset($_FILES[$foto])){
                $file = $_FILES[$foto];
                
                $fileName = $_FILES[$foto]['name'];   
                $fileTmpName = $_FILES[$foto]['tmp_name'];       
                $fileSize = $_FILES[$foto]['size'];        
                $fileError = $_FILES[$foto]['error'];        
                $fileType = $_FILES[$foto]['type'];
        
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
        
                $allowed = array('jpg','jpeg','png');
        
                if(in_array($fileActualExt,$allowed)){
                    if($fileError == 0){
                        if($fileSize < 500000){//Check size
                            $fileNameNew = uniqid('', true).".".$fileActualExt;
                            $destination_path = getcwd().DIRECTORY_SEPARATOR;
                            //$target_path = $destination_path . basename( $_FILES["profpic"]["name"]);
                            //$fileDestination = "img/uploads/".$id_subcategoria."/".$id_newProduct."/".$fileNameNew;
                            $archivo = "img/uploads/".$fileNameNew;
                            //$archivo = "/img/uploads/".$id_subcategoria."/".$id_newProduct."/".$fileNameNew;
                            //$fileDestination = $destination_path."..".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$id_subcategoria.DIRECTORY_SEPARATOR.$id_newProduct.DIRECTORY_SEPARATOR.$fileNameNew;
                            $fileDestination = $destination_path."..".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$fileNameNew;
                            move_uploaded_file($fileTmpName, $fileDestination);
        
                            $qrystr = "INSERT INTO foto (id_producto, orden, archivo) VALUES ($id,$i,'$archivo')";
        
                            AbrirBase();
                            $rs = $mysqli->query($qrystr);
        
                            $response = "ok";
                        }
                        else{
                            $response = "El archivo es demasiado grande.";
                        }
                    }
                    else{
                        $response = "Ocurrio un error al subir el archivo.";
                    }
                }
                else{
                    $response = "Tipo de archivo seleccionado inválido.";
                }
            }
        }
        CerrarBase();
    }
    else{//Nuevo producto
        $qrystr = "INSERT INTO producto (id_subcategoria, nombre_producto, descripcion, especificaciones, estado) VALUES ($id_subcategoria,'$nombre', '$detalle', '$especificacion', $estado)";
        AbrirBase();
        $rs = $mysqli->query($qrystr);
        $rs = $mysqli->query("SELECT id_producto FROM producto ORDER BY id_producto DESC LIMIT 1");
        //CerrarBase();

        $rs = $rs->fetch_object();
        $id_newProduct = $rs->id_producto;
        for ($i=1; $i<5 ; $i++) { 
            $foto = "file$i";
            //Guardar foto
            if(isset($_FILES[$foto])){
                $file = $_FILES[$foto];
                
                $fileName = $_FILES[$foto]['name'];        
                $fileTmpName = $_FILES[$foto]['tmp_name'];       
                $fileSize = $_FILES[$foto]['size'];        
                $fileError = $_FILES[$foto]['error'];        
                $fileType = $_FILES[$foto]['type'];
        
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
        
                $allowed = array('jpg','jpeg','png');
        
                if(in_array($fileActualExt,$allowed)){
                    if($fileError == 0){
                        if($fileSize < 500000){//Check size
                            $fileNameNew = uniqid('', true).".".$fileActualExt;
                            $destination_path = getcwd().DIRECTORY_SEPARATOR;
                            //$target_path = $destination_path . basename( $_FILES["profpic"]["name"]);
                            //$fileDestination = "img/uploads/".$id_subcategoria."/".$id_newProduct."/".$fileNameNew;
                            $archivo = "img/uploads/".$fileNameNew;
                            //$archivo = "/img/uploads/".$id_subcategoria."/".$id_newProduct."/".$fileNameNew;
                            //$fileDestination = $destination_path."..".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$id_subcategoria.DIRECTORY_SEPARATOR.$id_newProduct.DIRECTORY_SEPARATOR.$fileNameNew;
                            $fileDestination = $destination_path."..".DIRECTORY_SEPARATOR."img".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$fileNameNew;
                            move_uploaded_file($fileTmpName, $fileDestination);
        
                            $qrystr = "INSERT INTO foto (id_producto, orden, archivo) VALUES ($id_newProduct,$i,'$archivo')";
        
                            AbrirBase();
                            $rs = $mysqli->query($qrystr);
        
                            $response = "ok";
                        }
                        else{
                            $response = "El archivo es demasiado grande.";
                        }
                    }
                    else{
                        $response = "Ocurrio un error al subir el archivo.";
                    }
                }
                else{
                    $response = "Tipo de archivo seleccionado inválido.";
                }
            }
        }
        CerrarBase();      
    }
    
    echo $response;//Envio de respuesta codificada
?>