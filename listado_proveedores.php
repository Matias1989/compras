<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Listado Proveedores.</title>
		<script src="js/funciones.js"></script>
		<link rel="stylesheet" href="css/estilos.css" />
		<link rel="stylesheet" href="css/select2.min.css" type="text/css" />
		<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
		<script src="js/select2.min.js"></script>
	</HEAD>
	<body bgcolor="">
		<div>
			<table style="position:absolute; top:166px; left:0;">
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
						<a href="altaproveedor1.php"><button><i>Insertar Proveedor</i></button></a>
					</td>
				</tr>
			</table>
		</div>
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Compras</h1>
		</div>
		<div align="center">
			<label for='busqueda_proveedor'><b>Buscar</b>
			<input type='text' name='busqueda_proveedor' id='busqueda_proveedor'></label>
		</div>
		<div id='datos_proveedor'>

		</div>
		<script src="js/proveedor.js"></script>
		

	</body>
</HTML>

<script>

$(document).ready(function(){});

</script>