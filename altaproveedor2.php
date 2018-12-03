<?php

include 'conecta.php';
$id = $_POST['_id'];
$nombre = $_POST['nombre'];
$cuit = $_POST['cuit'];
$telefono = $_POST['telefono'];
$localidad = $_POST['_localidad'];
$direccion = $_POST['direccion'];
$email = $_POST['email'];
$iva = $_POST['_iva'];

	if ($id == "") {
		mysqli_query($conecta, "INSERT INTO proveedores
		(nombre_proveedor, cuit, telefono, cod_localidad, direccion, email, cod_cond_iva, estado)
		VALUES ('$nombre','$cuit','$telefono','$localidad','$direccion','$email','$iva',1)");
	}else{
		mysqli_query($conecta, "UPDATE proveedores SET nombre_proveedor = '$nombre',
		cuit = '$cuit', telefono = '$telefono', cod_localidad = '$localidad', direccion = '$direccion',
		email = '$email', cod_cond_iva = '$iva' WHERE id_proveedor = '$id'");
	}
	// header('Location:listado_proveedor.php');
