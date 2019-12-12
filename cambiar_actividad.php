<?php
include 'conecta.php';
$id_proveedor = $_GET['id_proveedor'];
$consulta = mysqli_query($conecta, "SELECT activo FROM proveedores WHERE id_proveedor = $id_proveedor");
$tipo_activo = mysqli_fetch_assoc($consulta);
if($tipo_activo['activo'] == 1){
    mysqli_query($conecta, "UPDATE proveedores SET activo = 0 WHERE id_proveedor = $id_proveedor");
}else if($tipo_activo['activo'] == 0){
    mysqli_query($conecta, "UPDATE proveedores SET activo = 1 WHERE id_proveedor = $id_proveedor");
}
header ("Location: listado_proveedores.php");
?>