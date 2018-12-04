<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<HEAD>
		<meta charset="utf-8">
		<title>Búsqueda Detallada.</title>
		<link rel="stylesheet" href="css/main.css" />
        <script src="js/funciones.js"></script>
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Pagos</h1>
			<a href="altaproveedor1.php"><button><i>Ingresar Proveedor</i></button></a>
			<a href="listado_proveedor.php"><button><i>Ver lista de Proveedores</i></button></a>
			<a href=""><button><i>Emitir Orden de Compra</i></button></a>
		</div>
		<br>
		<div>
			<div align="center"><h3>Detalle su Búsqueda:</h3></div>
			<?php 
				include 'conecta.php';
			?>
			<form method="POST" action="altabusqueda.php" id="form-datos">
				<table border="3" align="center">
					<tr>
						<th bgcolor="#5F9EA0"><h4>Busque por Nombre:</h4></th>
						<td>
							<input type="text" name="nombre" id="busqueda">
							<input type="submit" value="Buscar">
						</td>
					</tr>
					<tr>
						<th bgcolor="#5F9EA0" rowspan="2"><h4>Busque por Categoria:</h4></th>
						<td align="center">
							<select name="descripcion" onchange="window.location.
							href='?descripcion=' + this.value;">
								<option value="#">Seleccione...</option>
							<?php 
								$consulta = mysqli_query($conecta, "SELECT 
								descripcion_categoria FROM categorias group by 
								descripcion_categoria");
								while($fila = mysqli_fetch_array($consulta)){
								$categoria = $fila['descripcion_categoria'];
								$seleccion = ($_GET['descripcion'] and 
								$_GET['descripcion'] == $categoria) ? 
								'selected' : '';
								?>
								<option value="<?=$categoria;?>".
								<?=$seleccion;?>>
								<?=ucfirst($categoria);?> 
								</option>
							<?php
								}
							?>
							</select>
						<input type="hidden" name="form-datos">
					</tr>
					<tr>
						<td align="center"><input type="submit" 
						value="Visualizar">
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