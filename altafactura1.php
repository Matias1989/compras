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
		<meta charset="utf-8">
		<title>Registre Comprobante.</title>
		<link rel="stylesheet" href="css/estilos.css" />
		<script src="js/funciones.js"></script>
		<link rel="stylesheet" href="css/select2.min.css" type="text/css" />
		<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
		<script src="js/select2.min.js"></script>
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistema de Compras</h1>
		</div>
		<br>
		<div>
			<div align="center"><h3>Inserte datos del Comprobante</h3></div>
			<div>
				<table align="right" style="position:absolute; top:24%; left:0;">
					<tr align="right">
						<td>
							<a href="listado_compras.php"><button><i>Compras</i></button></a><br/><br/>
						</td>
					</tr>
					<tr align="right">
						<td>
							<a href="listado_compras.php"><button><i>Pagos</i></button></a><br/><br/>
						</td>
					</tr>
					<tr align="right">
						<td>
							<a href="listado_productos.php"><button><i>Productos</i></button></a><br/><br/>
						</td>
					</tr>
					<tr align="right">
						<td>
							<a href="listado_proveedores.php"><button><i>Proveedores</i></button></a>
						</td>
					</tr>
				</table>
			</div>
			<form method="POST" action="altafactura2.php" id="form-datos">
				<?php
				include 'conecta.php';
				$comprobante = null;
				if (isset($_GET['id_comprobante'])) {   
					$id = $_GET['id_comprobante'];
					$consulta_comprobante = mysqli_query($conecta, "SELECT * FROM
					comprobantes, documentos, proveedores, condiciones_pago WHERE documentos.id_documento = comprobantes.cod_documento AND proveedores.id_proveedor = comprobantes.cod_proveedor AND condiciones_pago.id_cond_pago = comprobantes.cod_cond_pago WHERE comprobantes.id_comprobante = '$id'");
					$comprobante = mysqli_fetch_array($consulta_comprobante);
				}
				?>
				<input type="hidden" name="_id" id="id" value="<?=($comprobante) ?
				$comprobante['id_comprobante']:'';?>">
				<table align="center">
					<tr>
						<th align="right">Seleccione Proveedor</th>
                        <td>
                            <select name="_proveedor" id="_proveedor">
                            <?php
                                $consulta_proveedor = mysqli_query($conecta,
                                "SELECT * from proveedores");
                                while ($proveedor =
                                mysqli_fetch_array($consulta_proveedor)) {
                                if ($proveedor['id_proveedor']==$comprobante['cod_proveedor']){
                            ?>
                                <option value="<?=$proveedor['id_proveedor'];?>" selected><?=convertir($proveedor['nombre_proveedor']);?>
                                </option>
                            <?}else{?>
                                <option value="<?=$proveedor['id_proveedor'];?>">
                                <?=convertir($proveedor['nombre_proveedor']);?>
                                </option>
                            <?}}?>
                            </select>
                        </td>
					</tr>
					<tr>
						<th align="right">Número del Comprobante</th>
						<td><input type="text" name="codigo_comprobante" id="codigo_comprobante" 
						value="<?=convertir(($comprobante) ? $comprobante['codigo_comprobante']:'');?>" placeholder="N°" pattern="[0-9]{1,5}" size="2" required>

						<input type="text" name="nro_comprobante" id="nro_comprobante" 
						value="<?=convertir(($comprobante) ? $comprobante['nro_comprobante']:'');?>" placeholder="Comprobante" pattern="[0-9]{1,8}" size="8" required></td>
					</tr>
					<tr>
						<th align="right">Fecha de Emisión</th>
						<td><input type="date" name="f_emision" id="f_emision" value="<?=convertir(
						($comprobante) ? $comprobante['fecha_emision']:'');?>" required/></td>
					</tr>
					
					<tr>
						<th align="right">Fecha de Vencimiento</th>
						<td><input type="date" name="f_vto" id="f_vto" value="<?=convertir(
						($comprobante) ? $comprobante['fecha_vto']:'');?>" required/></td>
					</tr>
					<tr>
						<th align="right">Condición de Pago</th>
						<td align="left">
							<select name="_cpago" id="_cpago">
							<?php
								$consulta_cpago = mysqli_query($conecta,
								"SELECT * from condiciones_pago");
								while ($cpago =
								mysqli_fetch_array($consulta_cpago)) {
								if ($cpago['id_cond_pago']==$comprobante['cod_cond_pago']){
							?>
								<option value="<?=$cpago['id_cond_pago'];?>" selected><?=convertir($cpago['descripcion_cp']);?>
								</option>
							<?}else{?>
								<option value="<?=$cpago['id_cond_pago'];?>">
								<?=convertir($cpago['descripcion_cp']);?>
								</option>
							<?}}?>
							</select>
						</td>
					</tr>
					<tr>
						<th><i style="color:#FF0000";>*opcional</i>&nbsp;&nbsp; Detalle de Pago</th>
						<td><input type="text" name="detalle" id="detalle" value="<?=convertir(
						($comprobante) ? $comprobante['detalle']:'');?>" placeholder="Detalle"></td>
					</tr>
					<tr>
						<td colspan="2" align="center" class=""></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<button type="submit" name="submit">
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
	
	$("#_proveedor").select2();
	$("#_cpago").select2();

});

</script>