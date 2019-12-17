<?php
	function convertir($str){
		$codificacion = mb_detect_encoding($str,"UTF-8, ISO-8859-1");
		$str = iconv($codificacion, 'ISO-8859-1', $str);
		return $str;
	}
	include 'conecta.php';

	$id = $_POST['_id'];
	$nombre = convertir($_POST['nombre']);
	$precio = $_POST['precio'];
	$categoria = $_POST['_categoria'];
	#var_dump($id, $nombre, $precio, $categoria);
	if ($id == "") {
		mysqli_query($conecta, "INSERT INTO productos
		(producto, precio_unitario, cod_categoria)
		VALUES ('$nombre','$precio','$categoria')");
	}else{
		mysqli_query($conecta, "UPDATE productos SET producto = '$nombre',
		precio_unitario = '$precio', cod_categoria = '$categoria' WHERE id_producto = '$id'");
	}
	header("Location:listado_productos.php?_categoria=$categoria");
