<?php
	function convertir($str){
		$codificacion = mb_detect_encoding($str,"UTF-8, ISO-8859-1");
		$str = iconv($codificacion, 'ISO-8859-1', $str);
		return $str;
	}
	include 'conecta.php';

	$nombre = convertir($_POST['nombre']);
	mysqli_query($conecta, "INSERT INTO categorias(categoria) VALUES ('$nombre')");
	header("Location:listado_productos.php");

?>