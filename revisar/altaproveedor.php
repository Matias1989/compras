<?php

    if (isset($_POST['submit'])) {
        $id = $_GET['_id'];
        $nombre = $_POST['nombre'];
        $cuit = $_POST['cuit'];
        $telefono = $_POST['telefono'];
        $localidad = $_POST['_localidad'];
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];
        $iva = $_POST['_iva'];
    }

?>

<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
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
			<form method="POST" action="<? htmlspecialchars($_SERVER['PHP_SELF']);?>" id="form-datos">
				<?php
				include 'conecta.php';
				$proveedor = null;
				if (isset($_GET['id'])) {
				$id = $_GET['id'];
				$consulta_proveedor = mysqli_query($conecta, "SELECT * FROM
				proveedores, condiciones_iva, localidades WHERE proveedores.id_proveedor = $id AND
                condiciones_iva.id_cond_iva = proveedores.cod_cond_iva AND localidades.id_localidad = proveedores.cod_localidad");
				$proveedor = mysqli_fetch_array($consulta_proveedor);
				}
				?>
				<input type="hidden" name="_id" value="<?=($proveedor) ?
				$proveedor['id_proveedor']:'';?>">
				<table border="3" align="center">
					<tr>
						<th>Nombre del Proveedor:</th>
						<td><input type="text" name="nombre" value="<?php if (isset($nombre)) echo $nombre?>"></td>
					</tr>
					<tr>
						<th>Número de Cuit:</th>
						<td><input type="text" name="cuit" value="<?php if (isset($cuit)) echo $cuit?>"></td>
					</tr>
					<tr>
						<th>Teléfono:</th>
						<td><input type="text" name="telefono" value="<?php if (isset($telefono)) echo $telefono?>" ></td>
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
								<option value="<?=$localidad['id_localidad'];?>" selected><?=$localidad['localidad'];?>
								</option>
							<?}else{?>
								<option value="<?=$localidad['id_localidad'];?>">
								<?=$localidad['localidad'];?>
								</option>
							<?}}?>
							</select>
						</td>
					</tr>
					<tr>
						<th>Dirección:</th>
						<td><input type="text" name="direccion" value="<?php if (isset($direccion)) echo $direccion?>"></td>
					</tr>
					<tr>
						<th>Correo Electrónico:</th>
						<td><input type="text" name="correo" value="<?php if (isset($correo)) echo $correo?>" ></td>
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
								<option value="<?=$condicion_iva['id_cond_iva'];?>" selected><?=$condicion_iva['descripcion_ci'];?>
								</option>
							<?}else{?>
								<option value="<?=$condicion_iva['id_cond_iva'];?>">
								<?=$condicion_iva['descripcion_ci'];?>
								</option>
							<?}}?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
                            <?php
                                include 'validar-form.php';
                            ?>
							<input type="submit" name="submit" onclick=
							"document.getElementById('form-datos').submit();">
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