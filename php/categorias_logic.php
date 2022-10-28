<?php
    require_once("conexion.php");//Incluyo el archivo de conexion 

    AbrirBase();//Abro la base
        
        //Guardo la peticion a la base de datos en una variable llamada $query
        //Joineo varias tablas para obtener todas las categorias con la foto de alguno de sus productos 
        $query="SELECT DISTINCT nombre_categoria,fot.archivo,cat.estado FROM producto as prod INNER JOIN
        foto AS fot ON(prod.id_producto=fot.id_producto)
        INNER JOIN subcategoria AS subc ON(prod.id_subcategoria=subc.id_subcategoria)
        INNER JOIN categoria AS cat ON(cat.id_categoria=subc.id_categoria) WHERE cat.estado='1' AND fot.orden='1' GROUP BY cat.id_categoria";

        $resultado=$mysqli->query($query);//Envio la peticion a la base de datos y la guardo en esta variable

        //$resultado->fetch_object() baja una fila en la tabla cada vez que se llamada y ademas devuelve TRUE si la fila de hecho existe FALSE si no existe
        //entonces al guardar esto en $row el while de abajo se corre solo mientras $row sea cierto, es decir, mientras todavia hayan filas en la tabla 

        while($row=$resultado->fetch_object()){
            $foto=$row->archivo;//Guardo en foto lo que hay en el campo "archivo" de la tabla
             echo 
            "
            <a href='https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=0&from=0&categoria=$row->nombre_categoria&subcategoria=0'>
            <div class='col-md-4 col-xs-6'>
            <div class='shop'>
                <div class='shop-img'>
                    <img src='$foto' alt=''>
                </div>
                <div class='shop-body'>
                    <h3>$row->nombre_categoria</h3>
                    <a href='https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=0&from=0&categoria=$row->nombre_categoria&subcategoria=0' class='cta-btn'>Ver <i class='fa fa-arrow-circle-right'></i></a>
                </div>
            </div>
            </div>
            </a>";
        }
    
?>