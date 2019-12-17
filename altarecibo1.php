<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<?php 
		function convertir($str){
			$codificacion = mb_detect_encoding($str,"ISO-8859-1,UTF-8");
			$str = iconv($codificacion, 'UTF-8', $str);
			return $str;
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
            <form method="POST" action="altarecibo2.php" id="form-datos">

                <?php 
                include 'conecta.php';
                $compras = null;
                if (isset($_GET['id_comprobante'])) {
                    $id_comprobante = $_GET['id_comprobante'];
                    $subtotal_recibo = 0;
                    $consulta_compras = mysqli_query($conecta,"SELECT * FROM comprobantes, proveedores, condiciones_pago WHERE proveedores.id_proveedor = comprobantes.cod_proveedor AND comprobantes.cod_cond_pago = condiciones_pago.id_cond_pago AND comprobantes.id_comprobante = '$id_comprobante'");
                    $compras = mysqli_fetch_array($consulta_compras);  

                    $consulta_recibo = mysqli_query($conecta,"SELECT importe FROM aplicaciones_comprobantes WHERE aplicaciones_comprobantes.id_comprobante_destino = '$id_comprobante'");
                    while($consulta_recibo_array = mysqli_fetch_assoc($consulta_recibo)){
                        $subtotal_recibo += $consulta_recibo_array['importe'];
                    }
                }

                ?>
                <input type="hidden" name="_id" id="id" value="<?=($compras) ?
				$compras['id_comprobante']:'';?>">
                <div align="center">
                    <h3 >Completar Recibo</h3>
                </div>
                <table align="center">
                    <tr>
                        <td align="right" ><b>Proveedor: </b> <?=convertir($compras['nombre_proveedor']); ?>
                        <input type="hidden" name='proveedor' value='<?=convertir($compras['cod_proveedor']);?>'>
                        
                        </td>
                        <td><b>N° Factura: </b> <?=substr($compras['nro_comprobante'],0,5).'-'.substr($compras['nro_comprobante'],5,8); ?></td>
                    </tr>
                    <tr>
                        <td align="right"><b>Importe Factura: </b><?=$compras['importe'];?></td>
                        <input type="hidden" id="importe_total" 
                        value="<?=$compras['importe'];?>">

                        <input type="hidden" id="cond_pago"
                        name="cond_pago" 
                        value="<?=$compras['cod_cond_pago'];?>">

                        <td align="left"> <b>Importe Parcial: </b><?=$subtotal_recibo;?></td>
                        <input type="hidden" id="importe_parcial" name="importe_parcial" 
                        value="<?=$subtotal_recibo;?>">
                    </tr>
                    <tr>
                        
                    </tr>
					<tr>
						<th align="right">Número de Recibo</th>
						<td><input type="text" name="codigo_recibo" id="codigo_recibo" 
						value="" placeholder="N°" pattern="[0-9]{1,5}" size="2" required>

						<input type="text" name="nro_recibo" id="nro_recibo" 
						value="" placeholder="Recibo" pattern="[0-9]{1,8}" size="8" required></td>
					</tr>
					<tr>
						<th align="right">Fecha de Emisión</th>
						<td><input type="date" name="f_emision" id="f_emision" value="<?=convertir(
						($comprobante) ? $comprobante['fecha_emision']:'');?>" required/></td>
					</tr>
                    <tr>
                        <th align="right">Importe Recibo</th>
                        <td> 
                            <input type="text" id="importe_diferencia" name="importe_diferencia"   value="" pattern="^[0-9]{1,11}$|^[0-9]{1,11}\.[0-9]{1,5}" required>
                        </td>
                    </tr>
                    <tr>
						<td colspan="2" align="center">
							<button type="submit" name="finalizar" id="finalizar">
								<img src="img/guardar.png" height="40" width="50">
							</button>
							<!-- <input type="reset"> -->
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
    $("#codigo_recibo").focus();

    $("#finalizar").click(function(){
        var importeVariable = $("#importe_diferencia").val();
        if(importeDiferencia >= importeVariable){
            return true;
        }else{
            alert("Monto Incorrecto.")
            return false;
        }
    });
});

</script>