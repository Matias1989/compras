<?php  

include 'conecta.php';
$salida = '<option value="">...</option>';  
if(isset($_POST["id_categoria"])){  
    $sql = "SELECT * FROM productos WHERE cod_categoria = '".$_POST["id_categoria"]."'";  
}
$resultado = mysqli_query($conecta, $sql);

while($fila = mysqli_fetch_array($resultado)){  
    $salida .= '<option value="'.$fila["id_producto"].'">'.$fila["producto"].'</option>';
}

echo $salida;
?>