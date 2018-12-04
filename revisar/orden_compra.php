<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<HEAD>
		<meta charset="utf-8">
		<title>Orden de Compra.</title>
		<link rel="stylesheet" href="css/main.css" />
        <script src="js/funciones.js"></script>
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Pagos</h1>
		</div>
		<br>
		<div>
			<div align="center"><h3>Orden de Compra:</h3></div>
			<form method="POST" action="orden_compra.php" id="form-comprobantes">
				<?php 
				include 'conecta.php';
				$comprobante = null;
				if (isset($_GET['id_comprobante'])) {
                    $id = $_GET['id_comprobante'];
                    $consulta_comprobante = mysqli_query($conecta, "SELECT * FROM comprobantes, condiciones_pago, condiciones_iva, 
                    formas_pago, productos, datos, categorias WHERE id_comprobante = $id AND datos.id_categoria = categorias.id AND
                    formas_pago.id_forma_pago = datos.cod_forma_pago ANDs
                    condiciones_pago.id_condicion_pago = datos.cod_condicion_pago AND
                    condiciones_iva.id_iva = cod_condicion_iva AND datos.id = comprobantes.id_comprobante");
                    $comprobante = mysqli_fetch_array($consulta_comprobante);
				}
				?>
				<input type="hidden" name="id_datos" value="<?=($comprobante) ? 
				$comprobante['id_datos']:'';?>">
				<table align="center">
					<tr>
						<th>Número:</th>
						<td><? $comprobante['id'] ;?></td>
						<th>Seleccione Proveedor:</th>
						<td>
							<select name="_proveedor">
							<?php
								$consulta_proveedor = mysqli_query($conecta, "SELECT * from datos");
								while ($proveedor = mysqli_fetch_array($consulta_proveedor)) {
								    if ($proveedor['id_datos'] == $producto['cod_proveedor']){?>
                                        <option value="<?=$proveedor['id_datos'];?>" selected>
                                            <?=$proveedor['nombre'];?>
                                        </option>
                                    <?}else{?>
								        <option value="<?=$proveedor['id_datos'];?>">
                                            <?=$proveedor['nombre'];?>
                                        </option><?
                                           }
                                }?>
							</select>
						</td>
					</tr>
					<tr>
						<th>Fecha:</th>
						<td><? $comprobante['fecha'] ;?></td>
						<th>Codiciones de Pago:</th>
						<td>
							<select name="_condicion_pago">
							<?php
								$consulta_condicion_pago = mysqli_query($conecta,
								"SELECT * from condiciones_pago");
								while ($condicion_pago = 
								mysqli_fetch_array($consulta_condicion_pago)) {
								if ($condicion_pago['id_condicion_pago']==$comprobante['cod_condicion_pago']){
							?>
								<option value="<?=$condicion_pago['id_condicion_pago'];?>" selected><?=$condicion_pago['descripcion_condicion_pago'];?>
								</option>         
							<?}else{?>
								<option value="<?=$condicion_pago['id_condicion_pago'];?>">
								<?=$condicion_pago['descripcion_condicion_pago'];?>
								</option>
							<?}}?>
							</select>
						</td>
					</tr>
					<tr>
						<th>Codición ante el IVA:</th>
						<td>
							<select name="_iva">
							<?php
								$consulta_iva = mysqli_query($conecta,
								"SELECT * from condiciones_iva");
								while ($condicion_iva = 
								mysqli_fetch_array($consulta_iva)) {
								if ($condicion_iva['id_iva']==$comprobante['cod_condicion_iva']){
							?>
								<option value="<?=$condicion_iva['id_iva'];?>" selected><?=$condicion_iva['descripcion_iva'];?>
								</option>         
							<?}else{?>
								<option value="<?=$condicion_iva['id_iva'];?>">
								<?=$condicion_iva['descripcion_iva'];?>
								</option>
							<?}}?>
							</select>
						</td>
					</tr>
					<tr>
						<th>Formas de Pago:</th>
						<td>
							<select name="_forma_pago">
							<?php
								$consulta_forma_pago = mysqli_query($conecta,
								"SELECT * from formas_pago");
								while ($forma_pago = 
								mysqli_fetch_array($consulta_forma_pago)) {
								if ($forma_pago['id_forma_pago']==$comprobante['cod_forma_pago']){
							?>
								<option value="<?=$forma_pago['id_forma_pago'];?>" selected><?=$forma_pago['descripcion_pago'];?>
								</option>         
							<?}else{?>
								<option value="<?=$forma_pago['id_forma_pago'];?>">
								<?=$forma_pago['descripcion_pago'];?>
								</option>
							<?}}?>
							</select>
						</td>
                    </tr>
					<tr>
						<td colspan="2" align="center">
							<button onclick=
							"document.getElementById('form-comprobantes').submit();">
							<img src="img/guardar.png" height="40" width="50">
							</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<footer>
			<br><br>
			<p align="center">Material recopilado y organizado por <b>Matías E. Acosta.</b></p>
		</footer>
	</body>
</HTML>