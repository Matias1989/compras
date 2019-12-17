<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<HEAD>
		<meta charset="utf-8">
		<title>Registre Categoria.</title>
		<link rel="stylesheet" href="css/estilos.css" />
		<script src="js/funciones.js"></script>
		<link rel="stylesheet" href="css/select2.min.css" type="text/css" />
		<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
		<script src="js/select2.min.js"></script>
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Compras</h1>
			<div>
				<table style="position:absolute; top:24%; left:0;">
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
							<a href="listado_proveedores.php"><button><i>Proveedor</i></button></a>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<br>
		<div>
			<div align="center"><h3>Inserte Categoría</h3></div>
			<form method="POST" action="altacategoria2.php" id="form-datos">
				<table align="center">
					<tr>
						<th align="right">Nombre Categoría</th>
						<td><input type="text" name="nombre" id="nombre" value="" placeholder="Nombre" required pattern="{4,50}"></td>
					</tr>
					<tr>
						<td colspan="2" align="center" class=""></td>
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