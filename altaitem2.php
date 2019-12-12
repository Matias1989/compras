<?php
include 'conecta.php';
$id_comprobante = $_POST['_id'];
$id_comprobante_recibo = $id_comprobante + 1;
$precio_unitario = $_POST['precio_unitario'];
$cantidad = $_POST['cantidad'];
$producto = $_POST['producto'];

if (isset($_POST['total'])) {
	$monto = $_POST['total'];
}

$monto_actualizado = 0;
if(isset($_POST['guardar'])){
	mysqli_query($conecta, "INSERT INTO comprobantes_items
	(cod_comprobante, cod_producto, cantidad, precio_unitario_historico)
	VALUES ('$id_comprobante','$producto','$cantidad','$precio_unitario')");
	header("Location:altaitem1.php?id=$id_comprobante");

}else if (isset($_POST['finalizar'])) {
	if (!isset($_POST['_id_items'])){
		if((empty($producto) || empty($precio_unitario) || empty($cantidad))) {
			$monto_actualizado = $monto;
			mysqli_query($conecta, "UPDATE comprobantes SET importe = '$monto_actualizado' WHERE id_comprobante = '$id_comprobante'");

			if(isset($_POST['pago_parcial'])){
				$monto_actualizado = $_POST['pago_parcial'];
			}

			mysqli_query($conecta, "UPDATE comprobantes SET importe = '$monto_actualizado' WHERE id_comprobante = '$id_comprobante_recibo'");

			mysqli_query($conecta, "INSERT INTO aplicaciones_comprobantes
			(id_comprobante_origen, id_comprobante_destino, importe)
			VALUES ('$id_comprobante_recibo','$id_comprobante','$monto_actualizado')");

			header("Location:listado_compras.php");

		}else{
			mysqli_query($conecta, "INSERT INTO comprobantes_items
			(cod_comprobante, cod_producto, cantidad, precio_unitario_historico)
			VALUES ('$id_comprobante','$producto','$cantidad','$precio_unitario')");

			$monto_actualizado = $monto + ($cantidad * $precio_unitario);
			mysqli_query($conecta, "UPDATE comprobantes SET importe = '$monto_actualizado' WHERE id_comprobante = '$id_comprobante'");

			if(isset($_POST['pago_parcial'])){
				$monto_actualizado = $_POST['pago_parcial'];
			}

			mysqli_query($conecta, "UPDATE comprobantes SET importe = '$monto_actualizado' WHERE id_comprobante = '$id_comprobante_recibo'");

			mysqli_query($conecta, "INSERT INTO aplicaciones_comprobantes
			(id_comprobante_origen, id_comprobante_destino, importe)
			VALUES ('$id_comprobante_recibo','$id_comprobante','$monto_actualizado')");

			header("Location:listado_compras.php");
		}

	}
}else if(isset($_POST['confirmar'])){
	$borrar_id = $_POST['borra_id_item'];
	mysqli_query($conecta, "DELETE FROM comprobantes_items WHERE id_comprobante_item = $borrar_id");
	header("Location: altaitem1.php?id=$id_comprobante");
}