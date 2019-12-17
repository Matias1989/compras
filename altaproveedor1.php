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
		<title>Registre Proveedor.</title>
		<link rel="stylesheet" href="css/estilos.css" />
		<script src="js/funciones.js"></script>
		<link rel="stylesheet" href="css/select2.min.css" type="text/css" />
		<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
		<script src="js/select2.min.js"></script>
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Compras</h1>
		</div>
		<div>
			<table align="right" style="position:absolute; top:24%; left:0;">
				<tr align="right">
					<td>
						<a href="listado_compras.php"><button><i>Compras</i></button></a><br/><br/>
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
		
		<div><br/>
			<div align="center"><h3>Inserte datos del Proveedor</h3></div>
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
					<tr align="right">
						<th>Nombre del Proveedor</th>
						<td><input type="text" name="nombre" id="nombre" value="<?=convertir(
						($proveedor) ? $proveedor['nombre_proveedor']:'');?>" placeholder="Nombre" required pattern="{4,50}"></td>
					</tr>
					<tr align="right">
						<th>Número de Cuit</th>
						<td><input type="text" name="cuit" id="cuit" value="<?=convertir(
						($proveedor) ? $proveedor['cuit']:'');?>" placeholder="Cuit" required pattern="[0-9]{11}"></td>
					</tr>
					<tr align="right">
						<th>Número Ingresos Brutos</th>
						<td><input type="text" name="nro_ingresos_brutos" id="nro_ingresos_brutos" value="<?=convertir(
						($proveedor) ? $proveedor['nro_ingresos_brutos']:'');?>" placeholder="Número Ingresos Brutos" required pattern="[0-9]{10,11}"></td>
					</tr>
					<tr align="right">
						<th>Teléfono</th>
						<td><input type="text" name="telefono" id="telefono" value="<?=convertir(
						($proveedor) ? $proveedor['telefono']:'');?>" placeholder="Teléfono" required pattern="[0-9]{10,15}"></td>
					</tr>
					<tr align="right">
						<td colspan="2" align="center" class=""></td>
					</tr>
					<tr align="right">
						<th>Localidad</th>
						<td align="left">
							<select name="_localidad" id="_localidad">
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
					<tr align="right">
						<th>Dirección</th>
						<td><input type="text" name="direccion" id="direccion" value="<?=convertir(
						($proveedor) ? $proveedor['direccion']:'');?>" placeholder="Dirección" required pattern="[A-Za-z-\t-A-Za-z-ZñÑáéíóúÁÉÍÓÚ\s]{5,50}"></td>
					</tr>
					<tr>
						<td colspan="2" align="center" class=""></td>
					</tr>
					<tr align="right">
						<th>Correo Electrónico</th>
						<td><input type="email" name="email" id="email" value="<?=convertir(
						($proveedor) ? $proveedor['email']:'');?>" placeholder="Email" maxlength="50" required/></td>
					</tr>
					<tr>
						<td colspan="2" align="center" class=""></td>
					</tr>
					<tr align="right">
						<th>Codición ante el IVA</th>
						<td align="left">
							<select name="_iva" id="_iva">
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
						</td>
					</tr>
				</table>
			</form>
		</div>
		<footer>
			<br><br>
			<p align="center">Propiedad de <b>Matías E. Acosta.</b></p>
		</footer>
	</body>
</HTML>
<script>

$(document).ready(function(){
	
	$("#_localidad").select2();
	$("#_iva").select2();

});

</script>