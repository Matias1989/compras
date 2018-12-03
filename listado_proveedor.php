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
		<title>Menu Principal.</title>
		<script src="js/funciones.js"></script>
		<link rel="stylesheet" href="css/estilos.css" />
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Compras</h1>
		</div>
        <?php
            include 'conecta.php';
            $consulta_proveedor=mysqli_query($conecta,"SELECT *
            FROM proveedores, localidades, condiciones_iva
            WHERE proveedores.cod_cond_iva = condiciones_iva.id_cond_iva AND 
            proveedores.cod_localidad = localidades.id_localidad order by nombre_proveedor");
        ?>
		<br>
		<div>
			<table align="center">
				<tr bgcolor="#BFBFBF">
					<th ><h4>¿Modificar?</h4></th>
					<th><h4>Nombre</h4></th>
					<th><h4>Número Cuit</h4></th>
					<th><h4>Teléfono</h4></th>
					<th><h4>Localidad</h4></th>
					<th><h4>Dirección</h4></th>
					<th><h4>Correo Electrónico</h4></th>
					<th><h4>Condiciones ante el IVA</h4></th>
					<th><h4>Estado</h4></th>
				</tr>
               <?php           
                    while($proveedor = mysqli_fetch_assoc($consulta_proveedor)){
                ?>
                <tr bgcolor="" align="center">
                	<td bgcolor=""><button onclick="window.location.href='altaproveedor1.php?id_proveedor=<?=$proveedor['id_proveedor'];?>'" ><img src="img/modificar.png" height="18" width="30"></button>
                   	</td>
                    <td><?=convertir($proveedor['nombre_proveedor'])?></td>
                    <td><?=convertir($proveedor['cuit'])?></td>
                    <td><?=convertir($proveedor['telefono'])?></td>
					<td><?=convertir($proveedor['localidad'])?></td>
                    <td><?=convertir($proveedor['direccion'])?></td>
                    <td><?=convertir($proveedor['email'])?></td>
                    <td><?=convertir($proveedor['descripcion_ci'])?></td>
                    <?php 
                        
                        if($proveedor['estado'] == 1){
                            ?><td><button type="button" name="borrar" onclick="confirmarEstado(<?=$proveedor['id_proveedor'];?>)"><img src="img/green.png" height="18" width="30"></button></td>
                        <?} else{?>
                            <td><button type="button" name="borrar" onclick="confirmarEstado(<?=$proveedor['id_proveedor'];?>)"><img src="img/red.png" height="18" width="30"></button></td>
                </tr>
                    <?php
                            }
                                }
                    ?>
			</table><br>
        <div align="center">
			<a href="listado_producto.php"><button><i>Productos</i></button></a>
			<a href="altaproveedor1.php"><button><i>Insertar Proveedor</i></button></a>
			<a href="listado_compras.php"><button><i>Compras</i></button></a>
		</div>
		</div>
		<footer>
			<br><br>
			<p align="center">Material recopilado y organizado por <b>Matías E. Acosta.</b></p>
		</footer>
	</body>
</HTML>