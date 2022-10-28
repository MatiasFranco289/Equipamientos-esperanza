<?php
//Acordarse de limitar la busqueda a 31 productos, no tiene sentido que busque mas de eso si de todas formas no puede mostrar mas que eso
        require_once("conexion.php");
        AbrirBase();
        $resultado_busqueda;
        $cantidad_productos=0;
        $categorias_encontradas=array("");
        $categorias_encontradas_norepeat=array("");
        $subcategorias_encontradas_norepeat=array("");
        $filtro_categoria='';
        $filtro_subcategoria='';

    function Buscador($busqueda,$from,$categoria,$subcategoria){//Buscador
        global $mysqli,$resultado_busqueda,$cantidad_productos,$filtro_categoria,$filtro_subcategoria;
        $to=$from+31;
        $trozos=explode(" ",$busqueda);
        $numero=count($trozos);

        if($busqueda=="0"){
            $busqueda="%%";
        }

        if($categoria!="0"){//Si hay filtro de categoria
            $filtro_categoria=$categoria;
        }

        if($subcategoria!="0"){//Si hay filtro de subcategoria
            $filtro_subcategoria=$subcategoria;
        }

        if($numero==1){//Si solo debe buscar una palabra
            $query="SELECT nombre_producto,archivo,nombre_categoria,prod.id_producto,nombre_subcategoria,prod.estado
			FROM categoria AS cat
            INNER JOIN subcategoria AS subc
            ON (cat.id_categoria= subc.id_categoria)
            INNER JOIN producto AS prod
            ON (subc.id_subcategoria = prod.id_subcategoria)
            INNER JOIN foto as fot ON(prod.id_producto=fot.id_producto)
            WHERE (nombre_producto SOUNDS LIKE '%$busqueda%' 
            or nombre_producto LIKE '%$busqueda%')
            AND prod.estado='1' AND nombre_categoria LIKE '%$filtro_categoria%' AND nombre_subcategoria LIKE '%$filtro_subcategoria%' GROUP BY prod.id_producto
            LIMIT $from,$to";

        }
        else{//Si debe buscar mas de una palabra
            $query="SELECT nombre_producto,archivo,nombre_categoria,prod.id_producto,nombre_subcategoria, prod.estado,
            MATCH(nombre_producto) AGAINST('$busqueda') AS puntuacion 
            FROM categoria AS cat
            INNER JOIN subcategoria AS subc
            ON (cat.id_categoria= subc.id_categoria)
            INNER JOIN producto AS prod
            ON (subc.id_subcategoria = prod.id_subcategoria)
            INNER JOIN foto as fot ON(prod.id_producto=fot.id_producto)
            WHERE  MATCH (nombre_producto) AGAINST ('$busqueda') AND
            prod.estado='1' AND nombre_categoria LIKE '%$filtro_categoria%' AND nombre_subcategoria LIKE '%$filtro_subcategoria%' GROUP BY prod.id_producto
            ORDER  BY puntuacion DESC LIMIT $from,$to";
        }
        $resultado_busqueda=$mysqli->query($query);

        if(mysqli_num_rows($resultado_busqueda)==0){//Si no encontro ningun resultado
            if(count($trozos)>1){//Si se esta buscando mas de una palabra 
                switch(count($trozos)){//Dependiendo de la cantidad de palabras utilizara una query u otra
                    case 2:
                        $query="SELECT nombre_producto,archivo,nombre_categoria,prod.id_producto,nombre_subcategoria,prod.estado
                        FROM categoria AS cat
                        INNER JOIN subcategoria AS subc
                        ON (cat.id_categoria= subc.id_categoria)
                        INNER JOIN producto AS prod
                        ON (subc.id_subcategoria = prod.id_subcategoria)
                        INNER JOIN foto as fot ON(prod.id_producto=fot.id_producto)
                        WHERE (nombre_producto SOUNDS LIKE '%$trozos[0]%'
                        OR nombre_producto SOUNDS LIKE '%$trozos[1]%') AND prod.estado='1'
                        AND nombre_categoria LIKE '%$filtro_categoria%' AND nombre_subcategoria LIKE '%$filtro_subcategoria%' GROUP BY prod.id_producto
                        LIMIT $from,$to";
                        break;
                    case 3:
                        $query="SELECT nombre_producto,archivo,nombre_categoria,prod.id_producto,nombre_subcategoria,prod.estado
                        FROM categoria AS cat
                        INNER JOIN subcategoria AS subc
                        ON (cat.id_categoria= subc.id_categoria)
                        INNER JOIN producto AS prod
                        ON (subc.id_subcategoria = prod.id_subcategoria)
                        INNER JOIN foto as fot ON(prod.id_producto=fot.id_producto)
                        WHERE (nombre_producto SOUNDS LIKE '%$trozos[0]%'
                        OR nombre_producto SOUNDS LIKE '%$trozos[1]%'
                        OR nombre_producto SOUNDS LIKE '%$trozos[2]%') AND prod.estado='1'
                        AND nombre_categoria LIKE '%$filtro_categoria%' AND nombre_subcategoria LIKE '%$filtro_subcategoria%' GROUP BY prod.id_producto
                        LIMIT $from,$to";
                        break;
                    default:
                        $query="SELECT nombre_producto,archivo,nombre_categoria,prod.id_producto,nombre_subcategoria,prod.estado
                        FROM categoria AS cat
                        INNER JOIN subcategoria AS subc
                        ON (cat.id_categoria= subc.id_categoria)
                        INNER JOIN producto AS prod
                        ON (subc.id_subcategoria = prod.id_subcategoria)
                        INNER JOIN foto as fot ON(prod.id_producto=fot.id_producto)
                        WHERE (nombre_producto SOUNDS LIKE '%$trozos[0]%'
                        OR nombre_producto SOUNDS LIKE '%$trozos[1]%'
                        OR nombre_producto SOUNDS LIKE '%$trozos[2]%'
                        OR nombre_producto SOUNDS LIKE '%$trozos[3]%') AND prod.estado='1'
                        AND nombre_categoria LIKE '%$filtro_categoria%' AND nombre_subcategoria LIKE '%$filtro_subcategoria%' GROUP BY prod.id_producto
                        LIMIT $from,$to";
                        break;
                        
                }
            }
            $resultado_busqueda=$mysqli->query($query);
        }
        $cantidad_productos=mysqli_num_rows($resultado_busqueda);//Cantidad de resultados que encontro
    }



    function SpawnProducts($from){//Hace aparecer los productos encontrados
            global $mysqli,$resultado_busqueda,$cantidad_productos,$categorias_encontradas,$categorias_encontradas_norepeat,$subcategorias_encontradas_norepeat;
            $contador=0;
            $limite=$cantidad_productos;

            if($limite>30){//Si encontro mas de 30 productos
                $limite=30;//Solo mostrara 30
            }

            for($f=0;$f<$limite;$f++){
                $row=$resultado_busqueda->fetch_object();
                $foto=$row->archivo;
                $link="https://equipamientos-esperanza.000webhostapp.com/product?id_product=$row->id_producto";
                //Guardo el nombre de la categoria de todos los productos que imprimo
                $categorias_encontradas[$contador]=$row->nombre_categoria;
                $subcategorias_encontradas[$contador]=$row->nombre_subcategoria;
                $contador++;
                echo "<a style='display:inline-block;' href='$link'>
                <div class='pl_product_container'>
                        <img class='pl_product_image' src='$foto' alt=''>
                        <p class='pl_category'>$row->nombre_categoria</p>
                        <h4 class='pl_name'>$row->nombre_producto</h4>
                    </div>
                    </a>
                ";
            }
                  
            $categorias_encontradas_norepeat=array_values(array_unique($categorias_encontradas));//Elimino valores duplicados

            if(isset($subcategorias_encontradas)){
                $subcategorias_encontradas_norepeat=array_values(array_unique($subcategorias_encontradas));
            }
           
    }

    function SpawnButtons($busqueda,$from){
        global $cantidad_productos,$filtro_categoria,$filtro_subcategoria;
        $redirect=$from+30;
        $atras=$from-30;

        if($filtro_categoria==null){
            $cat=0;
        }
        else{
            $cat=$filtro_categoria;
        }

        if($filtro_subcategoria==null){
            $subc=0;
        }
        else{
            $subc=$filtro_subcategoria;
        }

        if($from!=0){
            if($from>=60){//Si estas en la pagina 3 o mas aparece un boton nuevo para volver a la pagina 1
                echo "<a href='https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=$busqueda&from=0&categoria=$cat&subcategoria=$subc' class='btn pl_btn_nav'><i class='fa fa-chevron-left'></i> ...</a>";
            }
            echo "<a href='https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=$busqueda&from=$atras&categoria=$cat&subcategoria=$subc' class='btn pl_btn_nav'><i class='fa fa-chevron-left'></i> Anterior</a>";
        }

        if($cantidad_productos>30 || $from!=0){//Si se encontraron mas de 30 productos o la busqueda no es desde 0
            $actual=intval(($from/30)+1);//Esta formula obtiene como resultado el numero de pagina actual
            echo "<button class='btn pl_btn_nav' id='btn-nav1' style='background-color:#D10024; color:white;'>$actual</button>";//Se muestra en boton de pagina actual
        }

        if($cantidad_productos>30){//Si se encontraron mas de 30 productos
            //Se muestra el boton de siguiente
            echo "<a href='https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=$busqueda&from=$redirect&categoria=$cat&subcategoria=$subc' class='btn pl_btn_nav'>Siguiente <i class='fa fa-chevron-right'></i></a>";
        }
       
    }

    function SetFiltersVisibility(){
        global $cantidad_productos;
        if($cantidad_productos==0){//No se encontro ningun producto
            echo "visibility:hidden;";
        }
        else{//Se encontraron productos
            echo "visibility:visible;";
        }
    }

    function NoResults(){
        global $cantidad_productos;
        if($cantidad_productos==0){
            echo "visibility:visible;";
        }
        else{
            echo "visibility:hidden;";
        }
    }

    function QuantityOfProducts(){
        global $cantidad_productos;
        return $cantidad_productos;
    }

    function CategoriasEncontradas($busqueda){
        global $categorias_encontradas,$categorias_encontradas_norepeat,$filtro_subcategoria;
        $repetidos=0;
        
        if($filtro_subcategoria==null){
            $subcat=0;
        }
        else{
            $subcat=$filtro_subcategoria;
        }

        for($f=0;$f<count($categorias_encontradas_norepeat);$f++){
            
            for($f1=0;$f1<count($categorias_encontradas);$f1++){//Revisa el array de categorias encontradas con repeticiones incluidas y verifica cuantas veces se repitio
                if($categorias_encontradas_norepeat[$f]==$categorias_encontradas[$f1]){
                    $repetidos++;
                }
            }

            $link="https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=$busqueda&from=0&categoria=$categorias_encontradas_norepeat[$f]&subcategoria=$subcat";
            echo "
            <div>
            <a class='pl_related_category' href='$link'>$categorias_encontradas_norepeat[$f]</a>
            <p class='pl_related_count'>($repetidos)</p>
            </a>
            </div>";
            $repetidos=0;
        }
    }

    function SubcategoriasEncontradas($busqueda){
        global $subcategorias_encontradas_norepeat,$filtro_categoria;

        if($filtro_categoria==null){
            $cat=0;
        }
        else{
            $cat=$filtro_categoria;
        }

        for($f=0;$f<count($subcategorias_encontradas_norepeat);$f++){

            $link="https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=$busqueda&from=0&categoria=$cat&subcategoria=$subcategorias_encontradas_norepeat[$f]";

            echo "
            <div>
            <a class='pl_related_category' href='$link'>$subcategorias_encontradas_norepeat[$f]</a>
            </a>
            </div>";
        }
       
    }

    function QuitFilters($busqueda){//Hace aparecer un boton para quitar los filtros si hay algun filtro activo
        global $filtro_categoria,$filtro_subcategoria;

        if($filtro_categoria!=NULL || $filtro_subcategoria!=NULL){
            $link="https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=$busqueda&from=0&categoria=0&subcategoria=0";
            echo "  
            <div class='dropdown'>
                <a href='$link'>
                <button class='btn dropdown-toggle pl_boton_filtros' type='button'>Eliminar filtros</button>
                </a>
            </div>";
        }

    }

    function ActiveFilters(){
        global $filtro_categoria,$filtro_subcategoria;
        if($filtro_categoria!=NULL){//Si se esta filtrando por categoria
            echo "<a href=''><li class='pl_related_category' style='color:#D10024;'>-Solo categoria $filtro_categoria.</li></a>";
        }

        if($filtro_subcategoria!=NULL){//Si se esta filtrando por subcategoria
            echo "<a href=''><li class='pl_related_category' style='color:#D10024;'>-Solo $filtro_subcategoria.</li></a>";
        }
        
    }

    function GetProductName($busqueda){
        global $filtro_categoria;

        if($busqueda!="0"){
            echo "<h3 class='pl_filters_name'>$busqueda</h2>";
        }
        else{
            echo "<h3 class='pl_filters_name'>$filtro_categoria</h2>";
        }
    }
?>