<?php
include 'conecta.php';
$borrar_id = $_GET['borrar_id'];
$categoria_producto = mysqli_query($conecta,
"SELECT cod_categoria FROM productos WHERE id_producto = $borrar_id");
$_categoria = mysqli_fetch_assoc($categoria_producto);
$_categoria = $_categoria['cod_categoria'];
mysqli_query($conecta, "DELETE FROM productos WHERE id_producto = $borrar_id");
header ("Location: listado_productos.php?_categoria=$_categoria");
?>