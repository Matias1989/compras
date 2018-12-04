<?php
if (isset($_POST['submit'])) {
    if(empty($nombre)){
        ?><p class='error'>* Agrega tu nombre. </p>
        <?php
    }elseif(ctype_xdigit($nombre)){
        ?><p class='error'>* Ingrese un nombre correcto. </p>
        <?php
    }

    if(empty($cuit)){
        ?><p class='error'>* Agrega tu cuit. </p>
        <?php
    }elseif(strlen($cuit) != 11 && !is_numeric($cuit)){
        ?><p class='error'>* Cuit incorrecto. </p><?php
    }

    if(empty($telefono)){
        ?><p class='error'>* Agrega tu telefono. </p>
        <?php
    }elseif(!is_numeric($telefono)){
        ?><p class='error'>* Teléfono incorrecto. </p><?php

    }

    if(empty($direccion)){
        ?><p class='error'>* Agrega tu direccion. </p>
        <?php
    }

    if(empty($correo)){
        ?><p class='error'>* Agrega tu correo. </p>
        <?php
    }elseif(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        ?><p class='error'>* El correo es incorrecto. </p>
        <?php
    }
    if ($id == "") {
        mysqli_query($conecta, "INSERT INTO proveedores
        (nombre_proveedor, cuit, telefono, cod_localidad, direccion, correo, cod_cond_iva)
        VALUES ('$nombre','$cuit','$telefono','$localidad','$direccion','$correo','$iva')");
    }else{
        mysqli_query($conecta, "UPDATE proveedores SET nombre = '$nombre',
        cuit = '$cuit', telefono = '$telefono', cod_localidad = $localidad, direccion = '$direccion',
        correo = '$correo', cod_cond_iva = '$iva' WHERE id_proveedor = $id");
    }
}
#    header('Location: listado_proveedor.php');
?>