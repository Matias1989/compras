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
		<title>Comprobantes</title>
		<link rel="stylesheet" href="css/estilos.css" />
		<script src="js/funciones.js"></script>
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Compras</h1>
			<a href="listado_proveedor.php"><button><i>Ver lista de Proveedores</i></button></a>
			<a href="busqueda.php"><button><i>Filtrar busqueda de Proveedor</i></button></a>
		</div>
		<br>
		<div>
			<div align="center"><h3>Complete los siguientes datos:</h3></div>
			<form method="POST" action="altafactura2.php" id="form-datos">
				<?php
				include 'conecta.php';
				$comprobante = null;
				if (isset($_GET['id_comprobante'])) {   
					$id = $_GET['id_comprobante'];
					$consulta_comprobante = mysqli_query($conecta, "SELECT * FROM
					comprobantes, documentos, proveedores, condiciones_pago WHERE documentos.id_documento = comprobantes.cod_documento AND proveedores.id_proveedor = comprobantes.cod_proveedor AND condiciones_pago.id_cond_pago = comprobantes.cod_cond_pago");
					$comprobante = mysqli_fetch_array($consulta_comprobante);
				}
				?>
				<input type="hidden" name="_id" id="id" value="<?=($comprobante) ?
				$comprobante['id_comprobante']:'';?>">
				<table align="center">
					<tr>
						<th>Seleccione Proveedor:</th>
                        <td>
                            <select name="_proveedor">
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
						<th>Tipo de Comprobante:</th>
                        <td>
                            <select name="_documento">
                            <?php
                                $consulta_documento = mysqli_query($conecta,
                                "SELECT * from documentos");
                                while ($documento =
                                mysqli_fetch_array($consulta_documento)) {
                                if ($documento['id_documento']==$comprobante['cod_documento']){
                            ?>
                                <option value="<?=$documento['id_documento'];?>" selected><?=convertir($documento['nombre_documento']);?>
                                </option>
                            <?}else{?>
                                <option value="<?=$documento['id_documento'];?>">
                                <?=convertir($documento['nombre_documento']);?>
                                </option>
                            <?}}?>
                            </select>
                        </td>
					</tr>
					<tr>
						<th>Número del Comprobante:</th>
						<td><input type="text" name="nro_comprobante" id="nro_comprobante" value="<?=convertir(
						($comprobante) ? $comprobante['nro_comprobante']:'');?>" placeholder="N° Comprobante" pattern="[0-9]{10,15}" required/></td>
					</tr>
					<tr>
						<th>Fecha de Emisión:</th>
						<td><input type="date" name="f_emision" id="f_emision" value="<?=convertir(
						($comprobante) ? $comprobante['fecha_emision']:'');?>"></td>
					</tr>
					
					<tr>
						<th>Fecha de Vencimiento:</th>
						<td><input type="date" name="f_vto" id="f_vto" value="<?=convertir(
						($comprobante) ? $comprobante['fecha_vto']:'');?>"></td>
					</tr>
					<tr>
						<th>Condición de Pago:</th>
						<td>
							<select name="_cpago">
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