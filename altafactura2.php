<?php
function transformarFecha($fecha){
	$datos_fecha = str_replace('/','-',$fecha);
	return date('Y-m-d',strtotime($datos_fecha));
}
include 'conecta.php';
$id = $_POST['_id'];
$proveedor = $_POST['_proveedor'];
$tipo_documento = $_POST['_documento'];
$nro_comprobante = $_POST['nro_comprobante'];
$fecha_emision = transformarFecha($_POST['f_emision']);
$fecha_vto = transformarFecha($_POST['f_vto']);
$cond_pago = $_POST['_cpago'];

	if ($id == "") {
		mysqli_query($conecta, "INSERT INTO comprobantes
		(cod_documento, nro_comprobante, fecha_emision, fecha_vto, cod_proveedor, cod_cond_pago)
		VALUES ('$tipo_documento','$nro_comprobante','$fecha_emision','$fecha_vto','$proveedor', '$cond_pago')");
	}else{
		mysqli_query($conecta, "UPDATE comprobantes SET cod_documento = '$tipo_documento',
		nro_comprobante = '$nro_comprobante', fecha_emision = '$fecha_emision', fecha_vto = '$fecha_vto', cod_proveedor = '$proveedor', cod_cond_pago = '$cond_pago' WHERE id_comprobante = '$id'");
	}

	print($id);
	#header('Location:altafactura.php');
