<?php
include 'conecta.php';
$borrar_id = $_GET['borrar_id'];
mysqli_query($conecta, "DELETE FROM comprobantes_items WHERE id_comprobante_item = $borrar_id");
header ("Location: altaitem1.php");
?>