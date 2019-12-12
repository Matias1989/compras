<?php
function convertir($str){
    $codificacion = mb_detect_encoding($str,"ISO-8859-1,UTF-8");
    $str = iconv($codificacion, 'UTF-8', $str);
    return $str;
}

include 'conecta.php';
$salida = "";
$query = "SELECT * FROM productos, categorias WHERE productos.cod_categoria = categorias.id_categoria AND categorias.id_categoria = 1 order by producto";

if(isset($_POST['categoria']) && $_POST['consulta'] != ''){
    $id_categoria = $_POST['categoria'];
    $q = mysqli_real_escape_string($conecta, $_POST['consulta']);
    $query = "SELECT *, MATCH (producto) AGAINST ('%".$q."%' IN BOOLEAN MODE) AS puntuacion FROM productos, categorias WHERE productos.cod_categoria = categorias.id_categoria AND categorias.id_categoria = ".$id_categoria." AND MATCH (producto) AGAINST ('%".$q."%' IN BOOLEAN MODE) ORDER BY puntuacion DESC"; 
}elseif(isset($_POST['categoria'])){
    $id_categoria = $_POST['categoria'];
    $query = "SELECT * FROM productos, categorias WHERE productos.cod_categoria = categorias.id_categoria AND categorias.id_categoria = ".$id_categoria." order by producto"; 
}

$resultado = mysqli_query($conecta, $query);

if($resultado != ''){
    $salida = "<table align='center'>
				
    <tr bgcolor='#BFBFBF'>
        <th bgcolor='white'><h4></h4></th>
        <th><h4>Nombre Producto</h4></th>
        <th><h4>Precio Unitario</h4></th>
        <th bgcolor='white'><h4></h4></th>
    </tr>";

    while($producto = mysqli_fetch_assoc($resultado)){
        #$id_producto = $producto['id_producto'].','.'producto';
        $tipo = "producto";
        $location = 'window.location.href="altaproducto1.php?id_producto='.$producto["id_producto"].'"';
        $salida .= "<tr align='left'>
        <td ><button id='modificar_producto' onclick='".$location."'><img src='img/modificar.png' height='18' width='30'></button></td>
        <td>".convertir($producto['producto'])."</td>
        <td>".$producto['precio_unitario']."</td>
        <td ><button value='".$producto['id_producto']."' id='borrar_producto' onclick='confirmar(".$producto['id_producto'].",`producto`)'><img img src='img/eliminar.png' height='18' width='30'></button></td>";
    }
    $salida.="</table><br/>";
}

echo $salida;

?>