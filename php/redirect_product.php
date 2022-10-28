<?php
    $busqueda = $_POST['busqueda'];
    $categoria = $_POST['categoria'];
    header("Location: https://equipamientos-esperanza.000webhostapp.com/product_list?busqueda=$busqueda&from=0&categoria=$categoria&subcategoria=0");
?>