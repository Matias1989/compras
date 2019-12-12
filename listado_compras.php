<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<?php 
		function convertir($str){
			$codificacion = mb_detect_encoding($str,"ISO-8859-1,UTF-8");
			$str = iconv($codificacion, 'UTF-8', $str);
			return $str;
		}

		function transformarFecha($fecha){
			$datos_fecha = str_replace('/','-',$fecha);
            return date('Y-m-d',strtotime($datos_fecha));
		}
	?>
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Listado Compras.</title>
		<script src="js/funciones.js"></script>
		<link rel="stylesheet" href="css/estilos.css" />
		<link rel="stylesheet" href="css/select2.min.css" type="text/css" />
		<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
		<script src="js/select2.min.js"></script>
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistema de Compras</h1>
		</div>
		<div align="center">
		<form action='<?php $_SERVER['PHP_SELF'];?>'  method='POST'>
			<div>
				<?php
					$fecha_actual = date("Y-m-d");
					$fecha_mes_anterior = date("Y-m-d",strtotime($fecha_actual."- 1 month")); 
				?>
				<div>
					Desde <input type="date" name="fecha_1" id="fecha_1" value="<?=(isset($_POST['filtro_busqueda'])) ? $_POST['fecha_1']:$fecha_mes_anterior;?>" />
				 	Hasta <input type="date" name="fecha_2" id="fecha_2" value="<?=(isset($_POST['filtro_busqueda'])) ? $_POST['fecha_2']:$fecha_actual;?>" />

					<select name="_proveedor" value="<?=(isset($_POST['filtro_busqueda'])) ? $_POST['_proveedor']:'';?>" id="_proveedor">
						<?php
							include 'conecta.php';
							$consulta_proveedor = mysqli_query($conecta,
							"SELECT * from proveedores");
							?>
							<option disabled value=0 >Seleccione Proveedor</option>
							<? while ($proveedor =
							mysqli_fetch_array($consulta_proveedor)) {
						?>
							
							<option value="<?=$proveedor['id_proveedor'];?>"  selected><?=convertir($proveedor['nombre_proveedor']);?>
							</option>
						<?}?>
					</select>
					<input type="submit" name='filtro_busqueda' value='Consultar'/>
					<input type="hidden" name='proveedor_selected' id='proveedor_selected' value=''/>
				</div>
			</div>
		</form>
		
		<?php
			include 'conecta.php';
			$check_cuenta_corriente = false;
			if(isset($_POST['filtro_busqueda'])){
				$fecha_1 = $_POST['fecha_1'];
				$fecha_2 = $_POST['fecha_2'];
			}else{
				$fecha_1 = transformarFecha($fecha_mes_anterior);
				$fecha_2 = transformarFecha($fecha_actual);
			}

			if(!empty($_POST['proveedor_selected'])){
				$filtro_proveedor = $_POST['proveedor_selected'];
				$consulta_compras=mysqli_query($conecta,"SELECT *, aplicaciones_comprobantes.importe AS importe_recibo, comprobantes.importe AS importe_comprobante FROM comprobantes INNER JOIN documentos ON comprobantes.cod_documento = documentos.id_documento INNER JOIN proveedores ON proveedores.id_proveedor = comprobantes.cod_proveedor INNER JOIN aplicaciones_comprobantes ON aplicaciones_comprobantes.id_comprobante_destino = comprobantes.id_comprobante WHERE fecha_emision BETWEEN '$fecha_1' AND '$fecha_2' AND proveedores.activo = 1 AND comprobantes.cod_documento = 1 AND proveedores.id_proveedor = '$filtro_proveedor' ORDER BY fecha_emision");
			}else{
				$consulta_compras=mysqli_query($conecta,"SELECT *, aplicaciones_comprobantes.importe AS importe_recibo, comprobantes.importe AS importe_comprobante FROM comprobantes INNER JOIN documentos ON comprobantes.cod_documento = documentos.id_documento INNER JOIN proveedores ON proveedores.id_proveedor = comprobantes.cod_proveedor INNER JOIN aplicaciones_comprobantes ON aplicaciones_comprobantes.id_comprobante_destino = comprobantes.id_comprobante WHERE fecha_emision BETWEEN '$fecha_1' AND '$fecha_2' AND proveedores.activo = 1 AND comprobantes.cod_documento = 1 ORDER BY fecha_emision");
			}
        ?>
		<br>
		<div>
			<table style="position:absolute; top:24%; left:0;">
				<tr align="right">
					<td>
						<a href="altafactura1.php"><button><i>Insertar Compra</i></button></a><br/><br/>
					</td>
				</tr>
				<tr align="right">
					<td>
						<a href="listado_productos.php"><button><i>Productos</i></button></a><br/><br/>
					</td>
				</tr>
				<tr align="right">
					<td>
						<a href="listado_proveedores.php"><button><i>Proveedores</i></button></a>
					</td>
				</tr>
			</table>
		</div>
		<div>
			<table>
				<tr bgcolor="#BFBFBF">
					<th bgcolor="white"><h4></h4></th>
					<th><h4>Fecha Emisión</h4></th>
					<th><h4>Proveedor</h4></th>
					<th><h4>Tipo de Documento</h4></th>
					<th><h4>Número</h4></th>
					<th><h4>Monto </h4></th>
					<th bgcolor="white"><h4></h4></th>
				</tr>
			   <?php         
					$total = 0;  
                    while($compras = $consulta_compras ? mysqli_fetch_assoc($consulta_compras) : ''){
						if($compras['importe_comprobante'] == $compras['importe_recibo']){
							$check_cuenta_corriente = false;
							$color = '#82C082';
						}else{
							$check_cuenta_corriente = true;
							$color = '#FF8F8F';
						}	
                ?>
                <tr bgcolor="<?=$color;?>" align="center">
				<?if($check_cuenta_corriente){?>
				<td bgcolor="white"><button onclick="window.location.href='modificar_recibo1.php?id_comprobante=<?=$compras['id_comprobante'];?>'" ><img src="img/modificar.png" height="20" width="30"></button>
				<?}else{?>
					<td bgcolor="white">
				<?}?>
                   	</td>
                    <td><?=convertir($compras['fecha_emision'])?></td>
                    <td><?=convertir($compras['nombre_proveedor'])?></td>
                    <td><?=convertir($compras['nombre_documento'])?></td>
					<td><?=convertir($compras['nro_comprobante'])?></td>
                    <td><?=convertir($compras['importe'])?></td>
					<?php 
						$total += $compras['importe']; 
					?>
                	<td bgcolor="white"><button onclick="window.location.href='ver_factura.php?id_comprobante=<?=$compras['id_comprobante'];?>'" ><img src="img/ver.png" height="20" width="30"></button>
                   	</td>
					<?php   
					}
                    ?>
				<tr bgcolor="#BFBFBF">
					<th bgcolor="white"><h4></h4></th>
					<th colspan='4'><h4>Total</h4></th>
					<th ><h4><?=$total;?></h4></th>
					<th bgcolor="white"><h4></h4></th>
				</tr>
			</table><br>

		</div>
		<footer>
			<br><br>
			<p align="center">Material recopilado y organizado por <b>Matías E. Acosta.</b></p>
		</footer>
	</body>
</HTML>

<script>

$(document).ready(function(){
	$("#_proveedor").val(0).change();

	$("#_proveedor").select2();
	$("#_proveedor").change(function(){
		$("#proveedor_selected").val($(this).val());	
	});	
});

</script>