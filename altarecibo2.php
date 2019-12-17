<?php

    function transformarFecha($fecha){
        $datos_fecha = str_replace('/','-',$fecha);
        return date('Y-m-d',strtotime($datos_fecha));
    }

    function convertir($str){
		$codificacion = mb_detect_encoding($str,"UTF-8, ISO-8859-1");
		$str = iconv($codificacion, 'ISO-8859-1', $str);
		return $str;
	}

    include 'conecta.php';
    $id_comprobante = $_POST['_id'];
    $importe_recibo = $_POST['importe_parcial'];
    $importe_diferencia = $_POST['importe_diferencia'];
    $proveedor = $_POST['proveedor'];
    $nro_recibo = str_pad($_POST['nro_recibo'], 8, "0", STR_PAD_LEFT); 
    $codigo_recibo = str_pad($_POST['codigo_recibo'], 5, "0", STR_PAD_LEFT);
    $cond_pago = $_POST['cond_pago'];
    $fecha_emision = transformarFecha($_POST['f_emision']);

    $numeracion_recibo = (string)$codigo_recibo.$nro_recibo;
    
    $consulta_max = mysqli_query($conecta, "SELECT max(id_comprobante) FROM comprobantes");
	$id_max = mysqli_fetch_array($consulta_max);
    $id_max = $id_max[0]+1;
    
    #Guardo Recibo
	mysqli_query($conecta, "INSERT INTO comprobantes
	(cod_documento, nro_comprobante, fecha_emision, fecha_vto, cod_proveedor, cod_cond_pago, importe, detalle)
    VALUES (2,'$numeracion_recibo','$fecha_emision','','$proveedor', '$cond_pago','$importe_diferencia','')");

    mysqli_query($conecta, "INSERT INTO aplicaciones_comprobantes(id_comprobante_origen, id_comprobante_destino, importe) VALUES ('$id_max','$id_comprobante','$importe_diferencia')");
    header("Location: listado_compras.php");
?>
