<?php
function transformarFecha($fecha){
	$datos_fecha = str_replace('/','-',$fecha);
	return date('Y-m-d',strtotime($datos_fecha));
}
include 'conecta.php';
$id = $_POST['_id'];
$proveedor = $_POST['_proveedor'];
$nro_comprobante = str_pad($_POST['nro_comprobante'], 8, "0", STR_PAD_LEFT); 
$codigo_comprobante = str_pad($_POST['codigo_comprobante'], 5, "0", STR_PAD_LEFT); 
$fecha_emision = transformarFecha($_POST['f_emision']);
$fecha_vto = transformarFecha($_POST['f_vto']);
$cond_pago = $_POST['_cpago'];
$detalle = $_POST['detalle'];

$numeracion_comprobante = (string)$codigo_comprobante.$nro_comprobante;

if ($id == "") {
	$consulta_max = mysqli_query($conecta, "SELECT max(id_comprobante) FROM comprobantes");
	$id_max = mysqli_fetch_array($consulta_max);
	$id_max = $id_max[0]+1;

	#Guardo factura
	mysqli_query($conecta, "INSERT INTO comprobantes
	(cod_documento, nro_comprobante, fecha_emision, fecha_vto, cod_proveedor, cod_cond_pago, importe, detalle)
	VALUES (1,'$numeracion_comprobante','$fecha_emision','$fecha_vto','$proveedor', '$cond_pago','','$detalle')");

	#Guardo recibo
	mysqli_query($conecta, "INSERT INTO comprobantes
	(cod_documento, nro_comprobante, fecha_emision, fecha_vto, cod_proveedor, cod_cond_pago, importe, detalle)
	VALUES (2,'$numeracion_comprobante','$fecha_emision','$fecha_vto','$proveedor', '$cond_pago','','$detalle')");
	header("Location:altaitem1.php?id=$id_max");
}