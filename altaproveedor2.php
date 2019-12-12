<?php

include 'conecta.php';
$id = $_POST['_id'];
$nombre = $_POST['nombre'];
$cuit = $_POST['cuit'];
$nro_ingresos_brutos = $_POST['nro_ingresos_brutos'];
$telefono = $_POST['telefono'];
$localidad = $_POST['_localidad'];
$direccion = $_POST['direccion'];
$email = $_POST['email'];
$iva = $_POST['_iva'];

	if ($id == "") {
		mysqli_query($conecta, "INSERT INTO proveedores
		(nombre_proveedor, cuit, telefono, cod_localidad, direccion, email, cod_cond_iva, nro_ingresos_brutos, activo)
		VALUES ('$nombre','$cuit','$telefono','$localidad','$direccion','$email','$iva','$nro_ingresos_brutos',1)");
	}else{
		mysqli_query($conecta, "UPDATE proveedores SET nombre_proveedor = '$nombre',
		cuit = '$cuit', telefono = '$telefono', cod_localidad = '$localidad', direccion = '$direccion',
		email = '$email', cod_cond_iva = '$iva', nro_ingresos_brutos = '$nro_ingresos_brutos' WHERE id_proveedor = '$id'");
	}
	header('Location:listado_proveedores.php');
