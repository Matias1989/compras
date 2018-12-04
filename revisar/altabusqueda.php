<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<HEAD>
		<meta charset="utf-8">
		<title>Página Principal.</title>
		<script src="js/funciones.js"></script>
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Pagos</h1>
			<a href="altaproveedor1.php"><button><i>Ingresar Proveedor</i>
			</button></a>
			<a href="listado.php"><button><i>Ver lista de Proveedores</i></button></a>
			<a href=""><button><i>Emitir Orden de Compra</i></button></a>
		</div>
		<br>
		<div>
			<form method="POST" action="altaproveedor1.php">
				<table border="3" align="center">
					<tr bgcolor="#5F9EA0">
						<th><h3>¿Modificar?</h3></th>
						<th><h3>Nombre</h3></th>
						<th><h3>Número Cuit</h3></th>
						<th><h3>Teléfono</h3></th>
						<th><h3>Dirección</h3></th>
						<th><h3>Correo Electrónico</h3></th>
						<th><h3>Condición ante el IVA</h3></th>
						<th><h3>Condiciones de Pago</h3></th>
						<th><h3>Formas de Pago</h3></th>
						<th><h3>Categoria</h3></th>
						<th><h3>¿Borrar?</h3></th>
						<?php
							$nombre = "";
							$nombre = $_POST['nombre'];
							$categoria = $_POST['descripcion_categoria'];
							include 'conecta.php';
							if ($nombre!=""){
                                $consulta = mysqli_query($conecta,"SELECT * FROM 
                                datos, categorias WHERE categorias.id = 
                                datos.id_categoria AND nombre LIKE '%".$nombre."%'");
							}else{
                                $consulta = mysqli_query($conecta,"SELECT * FROM 
                                datos, categorias WHERE categorias.id = 
                                datos.id_categoria AND descripcion_categoria LIKE 
                                '%".$categoria."%'");
							}
							while($fila = mysqli_fetch_array($consulta)){
						?>
					</tr>
	                <tr align="center">
	                	<td><button onclick="window.location.
	                	href='altaproveedor1.php?id_datos=<?=$fila
	                	['id_datos'];?>'"><img src="img/modificar.png" 
	                	height="18" width="30"></button>
	                   	</td>
	                    <td><?=$fila['nombre'];?></td>
						<td><?=$fila['cuit'];?></td>
	                    <td><?=$fila['telefono'];?></td>
						<td><?=$fila['direccion'];?></td>
						<td><?=$fila['telefono'];?></td>
	                    <td><?=$fila['correo'];?></td>
						<td><?=$fila['condicion_iva'];?></td>
						<td><?=$fila['condicion_pago'];?></td>
						<td><?=$fila['forma_pago'];?></td>
	                    <td><?=$fila['descripcion_categoria'];?></td>
						<td><button type="button" name="borrar" onclick="confirmar(<?=$fila['id_datos'];?>)"><img src="img/eliminar.png" height="18" width="30"></button></td>
	                <script language="javascript">
	                	function confirmar(borrarid){
	                		if(confirm("¿Desea realmente eliminar el registro?")){
	                			window.location.href='borra_busqueda.php?borrar_id=' 
	                			+borrarid+ '';
	                			return true;
	                		}
	                	}
	                </script>
				<?php 
				}
				?>
				</table>
			</form>
		</div>
		<footer>
			<br>
			<p align="center">Material recopilado y organizado por <b>Matías E. Acosta.</b></p>
		</footer>
	</body>
</HTML>