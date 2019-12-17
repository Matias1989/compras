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
		<title>Registre Producto.</title>
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
			<div align="center"><h3>Inserte datos del Producto</h3></div>
			<form method="POST" action="altaproducto2.php" id="form-datos">
				<?php
				include 'conecta.php';
				$producto = null;
				if (isset($_GET['id_producto'])) {
					$id = $_GET['id_producto'];
					$consulta_producto = mysqli_query($conecta, "SELECT * FROM
					productos, categorias WHERE productos.cod_categoria = categorias.id_categoria AND productos.id_producto = $id");
					$producto = mysqli_fetch_array($consulta_producto);
				}
				?>
				<input type="hidden" name="_id" id="id" value="<?=($producto) ?
				$producto['id_producto']:'';?>">
				<table align="center">
					<tr>
						<th align="right">Nombre Producto</th>
						<td><input type="text" name="nombre" id="nombre" value="<?=convertir(
						($producto) ? $producto['producto']:'');?>" placeholder="Nombre" required pattern="{4,50}"></td>
					</tr>
					<tr>
						<th align="right">Precio Unitario</th>
						<td><input type="text" name="precio" id="precio" value="<?=convertir(
						($producto) ? $producto['precio_unitario']:'');?>" placeholder="Precio Unitario"  pattern="^[0-9]{1,11}$|^[0-9]{1,11}\.[0-9]{1,5}" required/></td>
					</tr>
					<tr>
						<th align="right">Categoria</th>
						<td>
							<select name="_categoria" id="_categoria">
							<?php
								$consulta_categoria = mysqli_query($conecta,
								"SELECT * from categorias");
								while ($categoria =
								mysqli_fetch_array($consulta_categoria)) {
								if ($categoria['id_categoria']==$producto['cod_categoria']){
							?>
								<option value="<?=$categoria['id_categoria'];?>" selected><?=convertir($categoria['categoria']);?>
								</option>
							<?}else{?>
								<option value="<?=$categoria['id_categoria'];?>">
								<?=convertir($categoria['categoria']);?>
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
	
	$("#_categoria").select2();
});

</script>