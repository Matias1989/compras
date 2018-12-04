<?php
include 'conecta.php';
$id_producto = $_POST['_id'];
$nombre_producto = $_POST['nombre_producto'];
$precio = $_POST['precio_unitario'];
$categoria = $_POST['_categoria'];
if ($id_producto == "") {
	mysqli_query($conecta, "INSERT INTO productos
	(nombre_producto, precio_unitario, cod_categoria)
	VALUES ('$nombre_producto', '$precio', '$categoria')");
}else{
	mysqli_query($conecta, "UPDATE productos SET nombre_producto = '$nombre_producto',
	precio_unitario = '$precio', cod_categoria = '$categoria' WHERE id_producto = $id_producto");
}
header('Location: listado_producto.php');
?>