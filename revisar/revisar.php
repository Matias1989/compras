<?php 

$errores = array();
$mensajes = array();
// Patrón para usar en expresiones regulares (admite letras acentuadas y espacios):
$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
$patron_correo = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";
// Comprobar si se ha enviado el formulario:
    if(isset($nombre) && isset($cuit) ){
        // Nombre:
        if(empty($nombre)){
            $errores[] = "Debe especificar el nombre";
        // Comprobar mediante una expresión regular, que sólo contiene letras y espacios:
        }elseif(preg_match($patron_texto, $nombre)){
            $mensajes[] = "Nombre: [".$nombre."]";
        }else{
            $errores[] = "El nombre sólo puede contener letras y espacios";
        }

    }else{
        echo "<p>No se han especificado todos los datos requeridos.</p>";
    }
    // Si han habido errores se muestran, sino se mostrán los mensajes
    if(count($errores) > 0){
        echo "<p>ERRORES ENCONTRADOS:</p>";
        // Mostrar los errores:
        for( $contador=0; $contador < count($errores); $contador++ ){
            echo $errores[$contador]."<br/>";
            }
    }else{
        if ($id == "") {
            mysqli_query($conecta, "INSERT INTO proveedores
            (nombre_proveedor, cuit, telefono, cod_localidad, direccion, correo, cod_cond_iva)
            VALUES ('$nombre','$cuit','$telefono','$localidad','$direccion','$correo','$iva')");
        }else{
            mysqli_query($conecta, "UPDATE proveedores SET nombre_proveedor = '$nombre',
            cuit = '$cuit', telefono = '$telefono', cod_localidad = '$localidad', direccion = '$direccion',
            correo = '$correo', cod_cond_iva = $iva WHERE id_proveedor = $id");
        }
        #header('Location:listado_proveedor.php');

}
?>