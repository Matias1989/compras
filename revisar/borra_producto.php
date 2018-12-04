<?php
include 'conecta.php';
$borrar_id = $_GET['borrar_id'];
mysqli_query($conecta, "DELETE FROM productos WHERE id_producto = $borrar_id");
header ("Location: listado_producto.php");
?>