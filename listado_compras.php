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
		<br>
		<div>
                    <form method="POST" action="<? htmlspecialchars($_SERVER['PHP_SELF']);?>" id="form-datos">
                        <input type="hidden" name="_id" value="<?=($compras) ? $compras['id_comprobante']:'';?>">
                        <table align="center" class="table" width="35%">
                                <tr class="borde">
                                        <td>
                                                <h2> 
                                                    <select name="_proveedor">
                                                        <?php
                                                            include 'conecta.php';
                                                            $consulta_proveedor = mysqli_query($conecta,
                                                            "SELECT * from proveedores");
                                                            while ($proveedor =
                                                            mysqli_fetch_array($consulta_proveedor)) {
                                                        ?>
                                                            <option value="<?=$proveedor['id_proveedor'];?>">
                                                            <?=convertir($proveedor['nombre_proveedor']);?>
                                                            </option>
                                                        <?}?>
                                                    </select>
                                                </h2>
                                                <?php 
                                                    include 'conecta.php';
                                                    $compras = null;
                                                    if (isset($_GET['id_comprobante'])) {
                                                    $id_comprobante = $_GET['id_comprobante'];
                                                    $id_proveedor = $proveedor['id_proveedor'];
                                                    $consulta_compras = mysqli_query($conecta,"SELECT direccion, "
                                                            . "localidad, telefono, nro_comprobante, cuit, "
                                                            . "descripcion_ci, fecha_emision, fecha_vto FROM "
                                                            . "proveedores, localidades, comprobantes, condiciones_iva "
                                                            . "WHERE '$id_proveedor' = comprobantes.cod_proveedor AND proveedores.cod_localidad = localidades.id_localidad "
                                                            . "AND condiciones_iva.id_cond_iva = proveedores.cod_cond_iva AND '$id_comprobante' = id_comprobante");
                                                    $compras = mysqli_fetch_array($consulta_compras);  
                                                    }

                                                  ?>
                                                <h4>
                                                    Direccion: 
                                                    <?=$proveedor['direccion'];?><br>

                                                    Localidad 
                                                    <?=$proveedor['localidad'];?><br>

                                                    Telefono 
                                                    <?=$proveedor['telefono'];?><br>
                                                </h4>
                                        </td>
                                        <td align="center" colspan="3">
                                                <img src="img/factura-b.png" width="100px" height="160px">
                                        </td>
                                        <td align="center" colspan="2">
                                                <h2>Factura</h2>
                                                <h4>N° 0000 - 0001<br>Fecha:<br>CUIT:</h4>
                                        </td>
                                </tr>
                                <tr>
                                        <td colspan="5" align="left" class="borde">Responsable inscripto</td>
                                </tr>
                                <tr>
                                        <td colspan="5" class="borde"><b>Persona/Empresa:</b> V & D Libreria</td>

                                </tr>
                                <tr class="borde">
                                        <td colspan="3"><b>Domicilio:</b> Rivadavia 413</td>
                                        <td colspan="2"><b>Localidad:</b> Roldán</td>
                                </tr>
                                <tr class="borde">
                                        <td colspan="3"><b>I.V.A: </b>Monotributista</td>
                                        <td colspan="2"><b>CUIT: </b>- - - - - - - - - - </td>
                                </tr>
                                <tr class="borde">
                                        <td colspan="5"><b>Condición de Venta:</b></td>
                                </tr>

                                <tr align="center" class="thead">
                                        <td class="borde"><b>CANT</b></td>
                                        <td colspan="2" class="borde"><b>DESCRIPCIÓN</b></td>
                                        <td class="borde"><b>P. UNITARIO</b></td>
                                        <td class="borde"><b>SUB TOTAL</b></td>
                                </tr>
                                <tr align="center">
                                        <td class="borde"></td>
                                        <td colspan="2" class="borde"></td>
                                        <td class="borde"></td>
                                        <td class="borde"></td>
                                </tr>
                                <tr align="center" class="borde">
                                        <td colspan="3"><b>DETALLE</b></td>
                                        <td><b>TOTAL</b></td>
                                        <td></td>
                                </tr>
                                <tr align="center" class="borde">
                                        <td colspan="3"></td>
                                        <td><b>VENCIMIENTO:</b></td>
                                        <td></td>
                                </tr>
                        </table>
            </form>
		</div>
        <div align="center">
			<a href="listado_producto.php"><button><i>Productos</i></button></a>
			<a href="altaproveedor1.php"><button><i>Insertar Proveedor</i></button></a>
			<a href=""><button><i>Compras</i></button></a>
		</div>
		</div>
		<footer>
			<br><br>
			<p align="center">Material recopilado y organizado por <b>Matías E. Acosta.</b></p>
		</footer>
	</body>
</HTML>