<?php
function convertir($str){
    $codificacion = mb_detect_encoding($str,"ISO-8859-1,UTF-8");
    $str = iconv($codificacion, 'UTF-8', $str);
    return $str;
}
function modificarCiut($cuit){
    $d_iniciales = substr($cuit,0,2);
    $ocho_digitos = substr($cuit, 2, 8);
    $digito_verificador = substr($cuit, 10);
    return $d_iniciales."-".$ocho_digitos."-".$digito_verificador;
}
include 'conecta.php';
$salida = "";

if(!empty($_POST['consulta'])){
    $q = mysqli_real_escape_string($conecta,$_POST['consulta']);
    $query = "SELECT *, MATCH (nombre_proveedor, direccion, email) AGAINST ('%".$q."%' IN BOOLEAN MODE) AS puntuacion_proveedor, MATCH (localidad) AGAINST ('%".$q."%' IN BOOLEAN MODE) AS puntuacion_localidad FROM proveedores LEFT JOIN localidades ON proveedores.cod_localidad = localidades.id_localidad WHERE MATCH (nombre_proveedor, direccion, email) AGAINST ('%".$q."%' IN BOOLEAN MODE) OR MATCH (localidad) AGAINST ('%".$q."%' IN BOOLEAN MODE) ORDER BY (puntuacion_proveedor + puntuacion_localidad) DESC"; 

}else{
    $query = "SELECT * FROM proveedores, localidades WHERE proveedores.cod_localidad = localidades.id_localidad order by id_proveedor DESC limit 10";
}

$resultado = mysqli_query($conecta, $query);

if($resultado != ''){
    $salida = "<table class='tabla_datos' align='center'>
    <tr bgcolor='#BFBFBF'>
        <th bgcolor='white'><h4></h4></th>
        <th><h4>Nombre</h4></th>
        <th><h4>Número Cuit</h4></th>
        <th><h4>Teléfono</h4></th>
        <th><h4>Localidad</h4></th>
        <th><h4>Dirección</h4></th>
        <th><h4>Correo Electrónico</h4></th>
        <th bgcolor='white'><h4></h4></th>
    </tr>";

    while($proveedor = mysqli_fetch_assoc($resultado)){
        $location = 'window.location.href="altaproveedor1.php?id_proveedor='.$proveedor["id_proveedor"].'"';
        if($proveedor['activo'] == 1){
            $img_activo = 'green.png';
        }else{
            $img_activo = 'red.png';
        }
        $salida .= "<tr align='left'>
        <td ><button id='modificar_proveedor' onclick='".$location."'><img src='img/modificar.png' height='18' width='30'></button></td>
        <td>".convertir($proveedor['nombre_proveedor'])."</td>
        <td>".modificarCiut($proveedor['cuit'])."</td>
        <td>".convertir($proveedor['telefono'])."</td>
        <td>".convertir($proveedor['localidad'])."</td>
        <td>".convertir($proveedor['direccion'])."</td>
        <td>".convertir($proveedor['email'])."</td>
        <td ><button id='activo' onclick='confirmarActividad(".$proveedor['id_proveedor'].")'><img src='img/".$img_activo."' height='18' width='30'></button></td>";
    }
    $salida.="</table><br/>";
}

echo $salida;

?>