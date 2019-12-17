<?php

function convertir($str){
	$codificacion = mb_detect_encoding($str,"ISO-8859-1,UTF-8");
	$str = iconv($codificacion, 'UTF-8', $str);
	return $str;
}

function listar_productos($conecta){
	$lista = '';																							
	$sql = "SELECT * FROM productos";  
	$resultado = mysqli_query($conecta, $sql);  
	while($fila = mysqli_fetch_array($resultado)){  
		$lista .= '<option value="'.$fila["id_producto"].'">'.$fila["producto"].'</option>';
	}
	return convertir($lista);
}

function listar_categorias($conecta){
	$lista = '';																							
	$sql = "SELECT * FROM categorias";  
	$resultado = mysqli_query($conecta, $sql);  
	while($fila = mysqli_fetch_array($resultado)){  
		$lista .= '<option value="'.$fila["id_categoria"].'">'.$fila["categoria"].'</option>';
	}
	return convertir($lista);
}

function mostrar_precio($conecta){  
	$salida = '';
	$sql = "SELECT * FROM productos";  
	$resultado = mysqli_query($conecta, $sql);  
	while($fila = mysqli_fetch_array($resultado)){
		// $salida .= 'value="'.$fila["precio_unitario"].'"';
		if(empty($fila['precio_unitario'])){
			$salida = '<input type="text" name="precio_unitario" value = "'.$fila['precio_unitario'].'" placeholder="Precio unitario">';
		}else{
			$salida = '<input type="text" name="precio_unitario" value = "" placeholder="Precio unitario">';
		}
	
	return $salida;  
	}
}
?>	
<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
<?php

?>
	<HEAD>
		<meta charset="utf-8">
		<title>Comprobantes</title>
		<link rel="stylesheet" href="css/estilos.css" />
		<script src="js/funciones.js"></script>
		<link rel="stylesheet" href="css/select2.min.css" type="text/css" />
		<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
		<script src="js/select2.min.js"></script> 
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Compras</h1>
		</div>
		<br>
		<div>
			<div align="center"><h3>Inserte ítem de Producto</h3></div>
			<form method="POST" action="altaitem2.php" id="form-datos">
				<?php
				include 'conecta.php';
				$comprobante_items = null;
				if (isset($_GET['id'])) {   
					$id = $_GET['id'];
					$consulta_comprobante = mysqli_query($conecta, "SELECT * FROM
					comprobantes, productos, proveedores, comprobantes_items, condiciones_pago WHERE comprobantes_items.cod_comprobante = comprobantes.id_comprobante AND comprobantes_items.cod_producto = productos.id_producto AND condiciones_pago.id_cond_pago = comprobantes.cod_cond_pago AND comprobantes_items.cod_comprobante = '$id'");
					$comprobante_items = mysqli_fetch_array($consulta_comprobante);
				}
				?>
				<input type="hidden" name="_id" id="id" value="<?=$id;?>">
				<table align="center">
					<tr>
						<th align="right">Categoria</th>
						<td>
							<select name="_categoria" id="_categoria">
								<option value="">...</option>
								<?=listar_categorias($conecta)?>
							</select>
						</td>
					</tr>
					<tr>
						<th align="right">Seleccione Producto</th>
                        <td>
                            <select name="producto" id="producto">
                                <option value="">...</option>
								<?=listar_productos($conecta)?>
                            </select>
                        </td>
					</tr>
					<tr>
						<th align="right">Precio Unitario</th>
						<td name ="producto" id="precio_unitario"><?=mostrar_precio($conecta);?></td>
					</tr>
					<tr>
						<th align="right">Cantidad</th>
						<td><input type="text" name="cantidad" id="cantidad" value="" placeholder="Cantidad"></td>
					</tr>
					<tr>
						<td colspan="2" align="center" class=""></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<button name="guardar" id="guardar" title="Guardar" onclick="return validarItems()">
								<img src="img/guardar.png" height="40" width="50">
							</button>
							<!-- <input type="reset"> -->
						</td>
					</tr>
				</table>
			<br>
			<?php
				if (isset($comprobante_items['id_comprobante_item'])) {				
				?>
			<div>
				<table align="center">
					<tr> 
						<th colspan='4'> Proveedor: <?=convertir($comprobante_items['nombre_proveedor']);?> </th>
					</tr>
					<tr>
						<th colspan='2'> N° Comprobante: <?=substr($comprobante_items['nro_comprobante'],0,5).'-'.substr($comprobante_items['nro_comprobante'],5,8)?></th>
						<th colspan='2'> Fecha Emisión: <?=$comprobante_items['fecha_emision'];?></th>
					</tr>	
					<tr bgcolor="#BFBFBF">
						<th ><h4>Cantidad</h4></th>
						<th><h4>Descripcion</h4></th>
						<th><h4>Precio Unitario</h4></th>
						<th><h4>Sub total</h4></th>
						<th bgcolor="white"><h4></h4></th>
					</tr>
					<?php   
						$subtotal1 = 0;
						$subtotal2 = 0;
						$total = 0;
						$consulta_items = mysqli_query($conecta, "SELECT * FROM condiciones_pago, productos, proveedores, comprobantes, comprobantes_items WHERE comprobantes_items.cod_comprobante = comprobantes.id_comprobante AND comprobantes.cod_proveedor = proveedores.id_proveedor AND comprobantes_items.cod_producto = productos.id_producto AND comprobantes.cod_cond_pago = condiciones_pago.id_cond_pago AND comprobantes.id_comprobante = '$id'");
						while ($items = mysqli_fetch_array($consulta_items)) {
					?>
					<tr bgcolor="" align="center">
						<td><?=convertir($items['cantidad'])?></td>
						<td align="left"><?=$items['producto']?></td>
						<td><?=$items['precio_unitario_historico']?></td>
						<td><?php 
								$subtotal1 = $items['cantidad'] * $items['precio_unitario_historico'];
								$total = $total + $subtotal1;
								$subtotal2 = $subtotal2 + $subtotal1;
								echo $subtotal1;
						?></td>
						<input type="hidden" name="borra_id_item" id="id" value="<?=$items['id_comprobante_item'];?>">
						<td bgcolor=""><button name="confirmar"><img src="img/eliminar.png" height="18" width="30"></button></td>
						
					</tr>
					<?php 
					}
					
					$consulta_detalle = mysqli_query($conecta, "SELECT detalle FROM comprobantes WHERE comprobantes.id_comprobante = '$id'");
					$detalle = mysqli_fetch_array($consulta_detalle);
					if (empty($detalle)){
						?>
						<tr>
						</tr>
					<?php
					}else{
					?> 
					<tr bgcolor="#BFBFBF">
						<th colspan='4' name='detalle' >Detalle: &nbsp;<?=convertir($detalle['detalle']);?></th>
						<th bgcolor="white"></th>
					</tr>
					<?}?>
					<tr bgcolor="#BFBFBF">
						<th colspan='3'>Total</th>
						<th ><?=$total;?><input name='total' id='total' value='<?=$total;?>' type='hidden'></th>
						<th bgcolor="white"></th>
					</tr>
					<?if(!$comprobante_items['contado']){?>
					<tr bgcolor="#BFBFBF">
						<th colspan='3'>Pago parcial</th>
						<th><input name='pago_parcial' id='pago_parcial' value='' type='text'></th>
						<th bgcolor="white"></th>
					</tr>
					<?}?>
					<tr>
						<td></td>
						<td colspan="5" align="center">
							<button type="submit" name="finalizar" id="finalizar" title="Finalizar">
								<img src="img/finalizar.png" height="35" width="35">
							</button>
							<!-- <input type="reset"> -->
						</td>
					</tr>
					<?}?>	
				</table><br>
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
	
	$("#_categoria").select2({width: '100%'});
	$("#producto").select2({width: '100%'});
	$("#producto").prop("disabled", true);
	$('#producto').change(function(){  
		$("#producto").prop("disabled", false);
		var id_producto = $(this).val();  
		$.ajax({  
			url:"cargar_precio.php",  
			method:"POST",  
			data:{id_producto:id_producto},  
			success:function(data){  
				$('#precio_unitario').html(data);  
			}  
		});  
	});

	$('#_categoria').change(function(){  
		$("#producto").prop("disabled", false);
		var id_categoria = $(this).val();  
		$.ajax({  
			url:"cargar_producto.php",  
			method:"POST",  
			data:{id_categoria:id_categoria},  
			success:function(data){  
				$('#producto').html(data); 
			}  
		});   
	});  

	$("#finalizar").on("click", function(){
		var pagoParcial = $("#pago_parcial").val();
		var total = $("#total").val();
		
		if(pagoParcial == '' || total < pagoParcial){
			alert("Monto parcial incorrecto");
			return false;
		}
	});
	
});  
</script>  