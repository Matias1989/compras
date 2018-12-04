<?php
include 'conecta.php';
$select = "DELETE FROM datos WHERE id_datos = '".$_GET['borrar_id']."'";
mysqli_query($conecta, $select) or die($select);
header ("Location: consulta.php?borrar_id");
?>