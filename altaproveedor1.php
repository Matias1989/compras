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
		<title>Ingrese Proveedor.</title>
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
			<form method="POST" action="altaproveedor2.php" id="form-datos" onsubmit="return validar()">
				<?php
				include 'conecta.php';
				$proveedor = null;
				if (isset($_GET['id_proveedor'])) {
					$id = $_GET['id_proveedor'];
					$consulta_proveedor = mysqli_query($conecta, "SELECT * FROM
					proveedores, condiciones_iva, localidades WHERE proveedores.id_proveedor = $id AND
					condiciones_iva.id_cond_iva = proveedores.cod_cond_iva AND
					localidades.id_localidad = proveedores.cod_localidad");
					$proveedor = mysqli_fetch_array($consulta_proveedor);
				}
				?>
				<input type="hidden" name="_id" id="id" value="<?=($proveedor) ?
				$proveedor['id_proveedor']:'';?>">
				<table align="center">
					<tr>
						<th>Nombre del Proveedor:</th>
						<td><input type="text" name="nombre" id="nombre" value="<?=convertir(
						($proveedor) ? $proveedor['nombre_proveedor']:'');?>" placeholder="Nombre" required pattern="[A-Za-z-\t-A-Za-z]{4,50}"></td>
					</tr>
					<tr>
						<th>Número de Cuit:</th>
						<td><input type="text" name="cuit" id="cuit" value="<?=convertir(
						($proveedor) ? $proveedor['cuit']:'');?>" placeholder="Cuit" required pattern="[0-9]{11}"></td>
					</tr>
					<tr>
						<th>Teléfono:</th>
						<td><input type="text" name="telefono" id="telefono" value="<?=convertir(
						($proveedor) ? $proveedor['telefono']:'');?>" placeholder="Teléfono" required pattern="[0-9]{10,15}"></td>
					</tr>
					<tr>
						<td colspan="2" align="center" class=""></td>
					</tr>
					<tr>
						<th>Localidad:</th>
						<td>
							<select name="_localidad">
							<?php
								$consulta_localidad = mysqli_query($conecta,
								"SELECT * from localidades");
								while ($localidad =
								mysqli_fetch_array($consulta_localidad)) {
								if ($localidad['id_localidad']==$proveedor['cod_localidad']){
							?>
								<option value="<?=$localidad['id_localidad'];?>" selected><?=convertir($localidad['localidad']);?>
								</option>
							<?}else{?>
								<option value="<?=$localidad['id_localidad'];?>">
								<?=convertir($localidad['localidad']);?>
								</option>
							<?}}?>
							</select>
						</td>
					</tr>
					<tr>
						<th>Dirección:</th>
						<td><input type="text" name="direccion" id="direccion" value="<?=convertir(
						($proveedor) ? $proveedor['direccion']:'');?>" placeholder="Dirección" required pattern="[A-Za-z-\t-A-Za-z]{5,50}"></td>
					</tr>
					<tr>
						<td colspan="2" align="center" class=""></td>
					</tr>
					<tr>
						<th>Correo Electrónico:</th>
						<td><input type="email" name="email" id="email" value="<?=convertir(
						($proveedor) ? $proveedor['email']:'');?>" placeholder="Email" maxlength="50" required/></td>
					</tr>
					<tr>
						<td colspan="2" align="center" class=""></td>
					</tr>
					<tr>
						<th>Codición ante el IVA:</th>
						<td>
							<select name="_iva">
                                <?php
                                    $consulta_iva = mysqli_query($conecta,
                                    "SELECT * from condiciones_iva");
                                    while ($condicion_iva =
                                    mysqli_fetch_array($consulta_iva)) {
                                    if ($condicion_iva['id_cond_iva']==$proveedor['cod_cond_iva']){
                                ?>
                                    <option value="<?=$condicion_iva['id_cond_iva'];?>" selected><?=convertir($condicion_iva['descripcion_ci']);?>
                                    </option>
                                <?}else{?>
                                    <option value="<?=$condicion_iva['id_cond_iva'];?>">
                                    <?=convertir($condicion_iva['descripcion_ci']);?>
                                    </option>
                                <?}}?>
							</select>
						</td>
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