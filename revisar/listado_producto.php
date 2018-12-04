<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<HEAD>
		<meta charset="utf-8">
		<title>Menu Principal.</title>
		<script src="js/funciones.js"></script>
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Compras</h1>
		    <br><a href="altaproducto1.php"><button><i>Insertar Producto</i></button></a>
		</div>
		<br>
		<div>
			<table border="3" align="center">
				<tr bgcolor="#5F9EA0">
					<th><h3>¿Modificar?</h3></th>
					<th><h3>Codigo del Producto</h3></th>
					<th><h3>Descripcion del Producto</h3></th>
					<th><h3>Precio Unitario</h3></th>
					<th><h3>Categoria</h3></th>
					<th><h3>¿Borrar?</h3></th>
					<?php
					include 'conecta.php';
					$consulta_producto=mysqli_query($conecta,"SELECT * FROM productos, categorias
					WHERE productos.cod_categoria = categorias.id_categoria order by nombre_producto");
					while($producto = mysqli_fetch_array($consulta_producto)){
					?>
				</tr>
                <tr align="center">
                	<td><button onclick="window.location.href='altaproducto1.php?id=<?=$producto['id_producto'];?>'" ><img src="img/modificar.png" height="18" width="30"></button>
                   	</td>
                   	<td><?=$producto['id_producto'];?></td>
                    <td><?=$producto['nombre_producto'];?></td>
                    <td><?=$producto['precio_unitario'];?></td>
                    <td><?=$producto['categoria'];?></td>
                    <td><button type="button" name="borrar" onclick="confirmar(<?=$producto['id_producto'];?>, 'producto')"><img src="img/eliminar.png" height="18" width="30"></button></td>
                </tr>
			<?php
			}
			?>
			</table>
		</div>
		<div align="center">
		    <br><a href="listado_proveedor.php"><button><i>Proveedores</i></button></a>
			<a href=""><button><i>Compras</i></button></a>
		</div>
		<footer>
			<br><br>
			<p align="center">Material recopilado y organizado por <b>Matías E. Acosta.</b></p>
		</footer>
	</body>
</HTML>