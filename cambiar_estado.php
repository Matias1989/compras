<?php
include 'conecta.php';
$id_estado = $_GET['estado'];
$consulta = mysqli_query($conecta, "SELECT estado FROM proveedores WHERE id_proveedor = $id_estado");
$tipo_estado = mysqli_fetch_assoc($consulta);
if($tipo_estado['estado'] == 1){
    mysqli_query($conecta, "UPDATE proveedores SET estado = 0 WHERE id_proveedor = $id_estado");
}else if($tipo_estado['estado'] == 0){
    mysqli_query($conecta, "UPDATE proveedores SET estado = 1 WHERE id_proveedor = $id_estado");
}
header ("Location: listado_proveedor.php");
?>