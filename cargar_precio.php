<?php  

include 'conecta.php';
$salida = '';  
if(isset($_POST["id_producto"])){  
    $sql = "SELECT precio_unitario FROM productos WHERE id_producto = '".$_POST["id_producto"]."'";  
}
$resultado = mysqli_query($conecta, $sql);
$fila = mysqli_fetch_array($resultado);  

$salida .= '<input type="text" name="precio_unitario" id="precio_unitario" value = "'.$fila['precio_unitario'].'" placeholder="Precio unitario">';

echo $salida;
?>  