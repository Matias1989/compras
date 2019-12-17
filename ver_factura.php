<!DOCTYPE HTML>
<HTML lang="es" xml:lang = "es">
	<?php 
		function convertir($str){
			$codificacion = mb_detect_encoding($str,"ISO-8859-1,UTF-8");
			$str = iconv($codificacion, 'UTF-8', $str);
			return $str;
        }

        function transformarFecha($fecha){
            $datos_fecha = str_replace('-','/',$fecha);
            return date('d-m-Y',strtotime($datos_fecha));
        }
        function modificarCiut($cuit){
            $d_iniciales = substr($cuit,0,2);
            $ocho_digitos = substr($cuit, 2, 8);
            $digito_verificador = substr($cuit, 10);
            return $d_iniciales."-".$ocho_digitos."-".$digito_verificador;
        }
        function modificarIngresosBrutos($ingresos_brutos){
            $d_iniciales = substr($ingresos_brutos,0,3);
            $seis_digitos = substr($ingresos_brutos, 3, 8);
            $digito_verificador = substr($ingresos_brutos, 9, 10);
            return $d_iniciales."-".$seis_digitos."-".$digito_verificador;
        }
	?>
        
	<HEAD>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Menu Principal.</title>
            <script src="js/funciones.js"></script>
            <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<link rel="stylesheet" href="css/estilos.css" />
	</HEAD>
	<body bgcolor="">
		<div align="center">
			<h1 align="center">Libreria "V & D" - Sistemas de Compras</h1>
		</div>
        <div align="center">
            <a href="listado_productos.php"><button><i>Productos</i></button></a>
            <a href="listado_compras.php"><button><i><img src="img/back.svg" height="30" width="40"></i></button></a>
            <a href="listado_proveedores.php"><button><i>Proveedores</i></button></a>
		</div>
		<br>
		<div>
            <?php 
                include 'conecta.php';
                $compras = null;
                if (isset($_GET['id_comprobante'])) {
                    $id_comprobante = $_GET['id_comprobante'];
                    $consulta_compras = mysqli_query($conecta,"SELECT * FROM comprobantes INNER JOIN proveedores ON proveedores.id_proveedor = comprobantes.cod_proveedor INNER JOIN condiciones_iva ON proveedores.cod_cond_iva = condiciones_iva.id_cond_iva INNER JOIN localidades ON proveedores.cod_localidad = localidades.id_localidad INNER JOIN condiciones_pago ON condiciones_pago.id_cond_pago = comprobantes.cod_cond_pago WHERE comprobantes.id_comprobante = '$id_comprobante'");
                    $compras = mysqli_fetch_array($consulta_compras);  
                }

            ?>
            <table align="center" class="table" width="45%">
                <tr class="borde">
                    <td>
                    <h3><?=convertir($compras['nombre_proveedor']); ?></h3>

                    <b>Direccion:</b>  <?=convertir($compras['direccion']);?><br/><br/>

                    <b>Localidad:</b> <?=convertir($compras['localidad']);?><br/><br/>

                    <b><?=strtoupper(convertir($compras['descripcion_ci']));?></b>
                    
                    </td>
                    <td align="center" colspan="3">
                            <img src="img/factura-b.png" width="100px" height="160px">
                    </td>
                    <td align="left">
                        <h3>Factura </h3> <?=substr($compras['nro_comprobante'],0,5).'-'.substr($compras['nro_comprobante'],5,8); ?><br/><br/>
                        <b>Fecha de emisión: </b> <?=transformarFecha($compras['fecha_emision']);?><br/><br/>
                        <b>CUIT: </b><?=modificarCiut($compras['cuit']);?><br/><br/>
                        <b>Ingresos Brutos: </b><?=modificarIngresosBrutos($compras['nro_ingresos_brutos']);?><br/><br/>
                    </td>
                </tr>

                <tr class="borde" bgcolor="#BDBDBD">
                    <td colspan="3"><b>Persona/Empresa:</b> V & D Libreria</td>
                    <td colspan="2"><b>Provincia:</b> Santa Fé</td>
                </tr>
                <tr class="borde" bgcolor="#BDBDBD">
                    <td colspan="3"><b>Domicilio:</b> Rivadavia 413</td>
                    <td colspan="2"><b>Localidad:</b> Roldán</td>
                </tr>
                <tr class="borde" bgcolor="#BDBDBD">
                    <td colspan="3"><b>I.V.A: </b>Monotributista</td>
                    <td colspan="2"><b>CUIT: </b>27-33776221-4</td>
                </tr>
                <tr class="borde" bgcolor="#BDBDBD">
                    <td colspan="3"><b>Cond. de Venta: </b><?=$compras['descripcion_cp']?></td>
                    <td colspan="3"><b>Teléfono: </b>3413439122</td>
                </tr>

                <tr align="center" class="thead">
                    <td class="borde"><b>CANTIDAD</b></td>
                    <td colspan="2" class="borde"><b>DESCRIPCIÓN</b></td>
                    <td class="borde"><b>PRECIO UNITARIO</b></td>
                    <td class="borde"><b>SUB TOTAL</b></td>
                </tr>
                <?php
                    $consulta_items=mysqli_query($conecta,"SELECT *
                    FROM productos, comprobantes_items, comprobantes WHERE productos.id_producto = comprobantes_items.cod_producto AND comprobantes_items.cod_comprobante = '$id_comprobante' AND comprobantes_items.cod_comprobante = comprobantes.id_comprobante ORDER BY producto");
                    while($items = mysqli_fetch_assoc($consulta_items)) {
                ?>
                <tr align="center">     
                    <td class="borde"><?=$items['cantidad'];?></td>
                    <td colspan="2" class="borde" align="left"><?=convertir($items['producto']);?></td>
                    <td class="borde"><?=$items['precio_unitario_historico'];?></td>
                    <td class="borde">
                    <?php
                    $subtotal = $items['cantidad'] * $items['precio_unitario_historico'];
                    echo $subtotal;
                    ?>

                    </td>
                </tr>
                <?}?>
                <tr align="center" class="borde">
                    <td colspan="3" align='left'><b>DETALLE: </b><?=convertir($compras['detalle']);?></td>
                    <td><b>TOTAL: </b></td>
                    <td ><b><?=$compras['importe'];?></b></td>
                </tr>
            </table>
		</div><br>
       <div align='center'>
       <?php
        $consulta_recibo=mysqli_query($conecta,"SELECT * FROM aplicaciones_comprobantes, comprobantes WHERE aplicaciones_comprobantes.id_comprobante_destino = '$id_comprobante' AND comprobantes.id_comprobante = aplicaciones_comprobantes.id_comprobante_origen");
        $array_recibo = [];
        while($recibo = mysqli_fetch_assoc($consulta_recibo)) {
            array_push($array_recibo,$recibo['importe'].'|'.substr($recibo['nro_comprobante'],0,5).'-'.substr($recibo['nro_comprobante'],5,8).'|'.transformarFecha($recibo['fecha_emision']));

            $str_recibo = implode($array_recibo,'~');
        }?>
            <input type='hidden' value='<?=$str_recibo?>' id='datos_recibo'>
            <button id='ver_recibo'><i><b>Ver Recibos</b></i></button>
        </div> 
		<footer>
			<br><br>
			<p align="center">Propiedad de <b>Matías E. Acosta.</b></p>
		</footer>
	</body>
</HTML>
<script> 
$(document).ready(function(){

    $("#ver_recibo").on('click',function(){
        var datosRecibo = $("#datos_recibo").val();
        datosRecibo = datosRecibo.split('~');
        var textHtml = '';
        for (var i = 0; i < datosRecibo.length; i++) {
            textHtml += 'Nro Recibo: '+datosRecibo[i].split('|')[1]+
            '\nFecha emisión: '+datosRecibo[i].split('|')[2]+
            '\nImporte: $'+datosRecibo[i].split('|')[0]+'\n\n';
        }
        alert(textHtml);
    });
});
</script>