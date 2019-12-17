<?php
	function convertir($str){
		$codificacion = mb_detect_encoding($str,"UTF-8, ISO-8859-1");
		$str = iconv($codificacion, 'ISO-8859-1', $str);
		return $str;
	}

	include 'conecta.php';
	$id_comprobante = $_POST['_id'];
	$id_comprobante_recibo = $id_comprobante + 1;
	$precio_unitario = $_POST['precio_unitario'];
	$cantidad = $_POST['cantidad'];
	
	if (isset($_POST['producto'])) {
		$producto = $_POST['producto'];
	}
	if (isset($_POST['total'])) {
		$monto = $_POST['total'];
	}

	$monto_actualizado = 0;
	if(isset($_POST['guardar'])){
		$consulta_producto = mysqli_query($conecta, "SELECT id_comprobante_item, cantidad FROM comprobantes_items, comprobantes WHERE comprobantes.id_comprobante = comprobantes_items.cod_comprobante AND comprobantes_items.cod_producto = '$producto' AND comprobantes_items.cod_comprobante = '$id_comprobante'");
		$array_producto = mysqli_fetch_assoc($consulta_producto);
		if($array_producto == null){
			mysqli_query($conecta, "INSERT INTO comprobantes_items(cod_comprobante, cod_producto, cantidad, precio_unitario_historico) VALUES ('$id_comprobante','$producto','$cantidad','$precio_unitario')");
		}else{
			$cantidad += $array_producto['cantidad'];
			$id_comprobante_item = $array_producto['id_comprobante_item'];

			mysqli_query($conecta, "UPDATE comprobantes_items SET cantidad = '$cantidad', precio_unitario_historico = '$precio_unitario' WHERE id_comprobante_item = '$id_comprobante_item'");
		}
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
				$consulta_producto = mysqli_query($conecta, "SELECT id_comprobante_item, cantidad FROM comprobantes_items, comprobantes WHERE comprobantes.id_comprobante = comprobantes_items.cod_comprobante AND comprobantes_items.cod_producto = '$producto' AND comprobantes_items.cod_comprobante = '$id_comprobante'");
				$array_producto = mysqli_fetch_assoc($consulta_producto);
				if($array_producto == null){
					mysqli_query($conecta, "INSERT INTO comprobantes_items(cod_comprobante, cod_producto, cantidad, precio_unitario_historico) VALUES ('$id_comprobante','$producto','$cantidad','$precio_unitario')");
				}else{
					$cantidad += $array_producto['cantidad'];
					$id_comprobante_item = $array_producto['id_comprobante_item'];

					mysqli_query($conecta, "UPDATE comprobantes_items SET cantidad = '$cantidad', precio_unitario_historico = '$precio_unitario' WHERE id_comprobante_item = '$id_comprobante_item'");
				}

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