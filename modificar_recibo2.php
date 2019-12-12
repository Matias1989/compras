<?php
    include 'conecta.php';
    $id_comprobante = $_POST['_id'];
    $id_comprobante_recibo = $id_comprobante +1;
    $importe_recibo = $_POST['importe_parcial'];
    $importe_diferencia = $_POST['importe_diferencia'];
    $monto_actualizado = $importe_recibo + $importe_diferencia;
    var_dump($importe_recibo, $importe_diferencia, $monto_actualizado, $id_comprobante, $id_comprobante_recibo);

    mysqli_query($conecta, "UPDATE comprobantes SET importe = '$monto_actualizado' WHERE id_comprobante = '$id_comprobante_recibo'");

    mysqli_query($conecta, "UPDATE aplicaciones_comprobantes SET importe = '$monto_actualizado' WHERE id_comprobante_destino = '$id_comprobante'");

    header("Location: listado_compras.php");
?>
