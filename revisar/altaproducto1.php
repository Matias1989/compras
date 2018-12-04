<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<HEAD>
		<meta charset="utf-8">
		<title>Ingrese Producto.</title>
		<link rel="stylesheet" href="css/main.css" />
        <script src="js/funciones.js"></script>
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Pagos</h1>
		</div>
		<br>
		<div>
			<div align="center"><h3>Complete los siguientes datos:</h3></div>
			<form method="POST" action="altaproducto2.php" id="form-productos">
				<?php
				include 'conecta.php';
				$producto = null;
				if (isset($_GET['id'])) {
                    $id_producto = $_GET['id'];
                    $consulta_producto = mysqli_query($conecta, "SELECT * FROM
                    productos, categorias WHERE id_producto = $id_producto AND categorias.id_categoria = productos.cod_categoria");
                    $producto = mysqli_fetch_array($consulta_producto);
				}
				?>
				<input type="hidden" name="_id" value="<?=($producto) ?
				$producto['id_producto']:'';?>">
				<table border="1" align="center">
					<tr>
						<th>Nombre del Producto:</th>
						<td><input type="text" name="nombre_producto" value="<?=
						($producto) ? $producto['nombre_producto']:'';?>"></td>
					</tr>
					<tr>
						<th>Precio Unitario:</th>
						<td><input type="text" name="precio_unitario" value="<?=
						($producto) ? $producto['precio_unitario']:'';?>"></td>
					</tr>
					<tr>
						<th>Seleccione Proveedor:</th>
						<td>
							<select name="_categoria">
							<?php
								$consulta_categoria = mysqli_query($conecta, "SELECT * from categorias");
								while ($categoria = mysqli_fetch_array($consulta_categoria)) {
								    if ($categoria['id_categoria'] == $producto['cod_producto']){?>
                                        <option value="<?=$categoria['id_categoria'];?>" selected>
                                            <?=$categoria['categoria'];?>
                                        </option>
                                    <?}else{?>
								        <option value="<?=$categoria['id_categoria'];?>">
                                            <?=$categoria['categoria'];?>
                                        </option><?
                                           }
                                }?>
							</select>
						</td>
					</tr>
                </table>
            </form><br>
        </div>
        <div align="center">
            <button onclick='window.location.href="listado_producto.php"'>
                <img src="img/back.ico" width="50" height="50"><br>
                <strong>Volver</strong>
            </button>
            <button onclick="document.getElementById('form-productos').submit();">
                <img src="img/guardar.png" height="50" width="50"><br>
                <strong>Guardar</strong>
            </button>
        </div>
		<footer>
			<br><br>
			<p align="center">Material recopilado y organizado por <b>Matías E. Acosta.</b></p>
		</footer>
	</body>
</HTML>