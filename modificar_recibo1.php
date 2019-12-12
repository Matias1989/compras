<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<?php 
		function convertir($str){
			$codificacion = mb_detect_encoding($str,"ISO-8859-1,UTF-8");
			$str = iconv($codificacion, 'UTF-8', $str);
			return $str;
        }

        function transformarFecha($fecha){
            $datos_fecha = str_replace('-','/',$fecha);
            return date('d-m-Y',strtotime($datos_fecha));
        }

        function modificarCiut($cuit){
            $d_iniciales = substr($cuit,0,2);
            $ocho_digitos = substr($cuit, 2, 8);
            $digito_verificador = substr($cuit, 10);
            return $d_iniciales."-".$ocho_digitos."-".$digito_verificador;
        }
        
        function modificarIngresosBrutos($ingresos_brutos){
            $d_iniciales = substr($ingresos_brutos,0,3);
            $seis_digitos = substr($ingresos_brutos, 3, 8);
            $digito_verificador = substr($ingresos_brutos, 9, 10);
            return $d_iniciales."-".$seis_digitos."-".$digito_verificador;
        }
	?>
        
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Menu Principal.</title>
            <script src="js/funciones.js"></script>
            <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<link rel="stylesheet" href="css/estilos.css" />
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Compras</h1>
			<a href="listado_productos.php"><button><i>Productos</i></button></a>
            <a href="listado_compras.php"><button><i><img src="img/back.svg" height="30" width="40"></i></button></a>
			<a href="listado_proveedores.php"><button><i>Proveedores</i></button></a>
		</div>
		<br>
		<div>
            <form method="POST" action="modificar_recibo2.php" id="form-datos">

                <?php 
                include 'conecta.php';
                $compras = null;
                if (isset($_GET['id_comprobante'])) {
                    $id_comprobante = $_GET['id_comprobante'];
                    $consulta_compras = mysqli_query($conecta,"SELECT *, aplicaciones_comprobantes.importe AS importe_recibo, comprobantes.importe AS importe_comprobante FROM comprobantes INNER JOIN documentos ON comprobantes.cod_documento = documentos.id_documento INNER JOIN aplicaciones_comprobantes ON aplicaciones_comprobantes.id_comprobante_destino = comprobantes.id_comprobante INNER JOIN proveedores ON proveedores.id_proveedor = comprobantes.cod_proveedor WHERE comprobantes.id_comprobante = '$id_comprobante'");
                    $compras = mysqli_fetch_array($consulta_compras);  
                }

                ?>
                <input type="hidden" name="_id" id="id" value="<?=($compras) ?
				$compras['id_comprobante']:'';?>">
                <div align="center">
                    <h3 >Completar Recibo</h3>
                </div>
                <table align="center" width="40%">
                    <tr>
                        <td>
                            <b>Proveedor: </b><?=$compras['nombre_proveedor']; ?>
                        </td>
                        <td>
                            <b>N° de Factura:</b>  <?=$compras['nro_comprobante'];?>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <b>Total:</b> <?=$compras['importe_comprobante'];?>
                            <input type="hidden" id="importe_total" value="<?=$compras['importe_comprobante'];?>">
                        </td>
                        <td>
                            <b>Parcial:</b> <?=$compras['importe_recibo'];?>
                            <input type="hidden" id="importe_parcial" name="importe_parcial" value="<?=$compras['importe_recibo'];?>">
                        </td>
                    </tr>
                    <tr align="left">
                        <td> 
                            <input type="text" id="importe_diferencia" name="importe_diferencia" value="">
                        </td>
                        <td>
                            <button type="submit" name="finalizar" id="finalizar" title="Finalizar">
                                <img src="img/finalizar.png" height="25" width="25">
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
		</div>
		<footer>
			<br><br>
			<p align="center">Material recopilado y organizado por <b>Matías E. Acosta.</b></p>
		</footer>
	</body>
</HTML>

<script>

$(document).ready(function(){
    var importeParcial = $("#importe_parcial").val();
    var importeTotal = $("#importe_total").val();
    var importeDiferencia = $("#importe_total").val() - $("#importe_parcial").val();

    $("#importe_diferencia").val(importeDiferencia);
    $("#importe_diferencia").focus();

    $("#finalizar").click(function(){
        var importeVariable = $("#importe_diferencia").val();
        if(importeDiferencia <= importeVariable){
            return true;
        }else{
            alert("Monto Incorrecto.")
            return false;
        }
    });
});

</script>