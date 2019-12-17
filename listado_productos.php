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
		<title>Listado Productos.</title>
		<script src="js/funciones.js"></script>
		<link rel="stylesheet" href="css/estilos.css" />
		<link rel="stylesheet" href="css/select2.min.css" type="text/css" />
		<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
		<script src="js/select2.min.js"></script>
	</HEAD>
	<body bgcolor="">
		<div>
			<table style="position:absolute; top:24%; left:0;">
				<tr align="right">
					<td>
						<a href="listado_compras.php"><button><i>Compras</i></button></a><br/><br/>
					</td>
				</tr>
				<tr align="right">
					<td>
						<a href="altaproducto1.php"><button><i>Insertar Producto</i></button></a><br/><br/>
					</td>
				</tr>
				<tr align="right">
					<td>
						<a href="altacategoria1.php"><button><i>Insertar Categoría</i></button></a><br/><br/>
					</td>
				</tr>
				<tr align="right">
					<td>
						<a href="listado_proveedores.php"><button><i>Proveedores</i></button></a>
					</td>
				</tr>
			</table>
		</div>
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Compras</h1>
			<div>
				<select name="_categoria" id="_categoria">
					<?php
						include 'conecta.php';
						$consulta_categoria = mysqli_query($conecta,
						"SELECT * from categorias");
						while ($categoria =
						mysqli_fetch_array($consulta_categoria)) {
					?>
						<option value="<?=$categoria['id_categoria'];?>"><?=convertir($categoria['categoria']);?>
						</option>
					<?}?>
				</select>
				<input type="hidden" name="_id_categoria" id="_id_categoria" value="<?=(isset($_GET['_categoria'])) ? $_GET['_categoria']:'';?>">
				<label for='busqueda_producto'>
					<input type='text' name='busqueda_producto' id='busqueda_producto'>
				</label>
			</div>
			<br/><br/>
			<div id='datos_producto'>
				
			</div>
			<script src="js/producto.js"></script>

			<footer>
				<p align="center">Propiedad de <b>Matías E. Acosta.</b></p>
			</footer>
	</body>
</HTML>
<script>

$(document).ready(function(){
	
	$("#_categoria").select2();
});

</script>