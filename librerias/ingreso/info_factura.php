<?php
ob_start();//llenar el buffer para que todo el contenido quede en una variabe
if(empty($_REQUEST['ci'])){
		echo "No es posible generar el informe";
	}else{
		
		include "../../baseDatos/conexionbd.php";//conexion a la base de datos 
		$obBD = new Conexion(); 
		$link = $obBD->Conectar(); //crear conexion 
			
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INFORME FACTURAS</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']?>/Distrital/APLICACIONES/librerias/ingreso/style.css">
	<!-- Bootstrap CSS -->
</head>
<body>
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="https://png.pngtree.com/png-vector/20200329/ourlarge/pngtree-hospital-icon-design-illustration-png-image_2166843.jpg" style="width:135px; height:135px;">
				</div>
			</td>
			<td></td>
			<td class="info_empresa">
				<div>
					<span class="h2">HOSPITAL BAM</span>
					<p>Calle 13 carrera 16</p>
					<p>Teléfono: +(601) 3625986</p>
					<p>Email: info@gmail.com</p>
				</div>
			</td>
			<td class="">
				<td class="">
				<?php
					$codInforme = $_REQUEST['ci'];
					$sql ="select * from informe left join estado on(informe.tipo=estado.id_estado) where id_info=$codInforme"; 
					$res = $link->prepare($sql);//Prepara la consulta para su ejecución
					$res->execute(); //Ejecuta la consulta
					$informe = $res->fetchAll(PDO::FETCH_ASSOC);
					$id_estado=$informe[0]['id_estado'];
					$fechaActual = date('Y-m-d');
					$star=$informe[0]['starDate'];
					$end=$informe[0]['endDate'];
					$sql ="select count(id_fact) from facturacion where fecha_factura BETWEEN '$star' and '$end' and id_estado_fk='$id_estado'"; 
					$res = $link->prepare($sql);//Prepara la consulta para su ejecución
					$res->execute(); //Ejecuta la consulta
					$cantidad = $res->fetchAll(PDO::FETCH_ASSOC);	
				?>
				<div class="round">
					<span class="h3">Informe Facturas</span>					
					<p>No. Informe: <strong><?php echo strtoupper($informe[0]['id_info']); ?></strong></p>
					<p>Fecha de Emision: <?php echo ($fechaActual); ?></p>
					<p>Estado del informe: <?php echo ($informe[0]['estado']); ?></p>
				</div>
			</td>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<span class="h3">Informe</span>
					<table class="datos_cliente">
						<tr>
							<td><label>Fecha Inicial:</label><p><?php echo ($informe[0]['starDate']); ?></p></td>
							<td><label>Estado:</label> <p><?php echo ($informe[0]['estado']); ?></p></td>
						</tr>
						<tr>
							<td><label>Fecha Final:</label> <p><?php echo ($informe[0]['endDate']); ?></p></td>
							<td><label>Cantidad de facturas:</label> <p><?php echo ($cantidad[0]['count(id_fact)']); ?></p></td>
						</tr>						
					</table>					
				</div>
			</td>

		</tr>
	</table>
	<?php
	//Consulta para datos del servicio
			$sql ="select * from facturacion where fecha_factura BETWEEN '$star' and '$end' and id_estado_fk='$id_estado'"; 
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$facturacion = $res->fetchAll(PDO::FETCH_ASSOC);
			
			$sql ="select sum(valor_total) from facturacion where fecha_factura BETWEEN '$star' and '$end' and id_estado_fk='$id_estado'"; 
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$total = $res->fetchAll(PDO::FETCH_ASSOC);
	?>
	<h3>Facturas <?php echo ($informe[0]['estado']); ?>s</h3>
	<table id="factura_detalle">
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">Fecha de emision</th>
					<th scope="col">Fecha de vencimiento</th>
					<th scope="col">No Ingreso</th>
					<th scope="col">Valor total</th>					
				</tr>
			</thead>
			<tbody id="detalle_productos">				
				<?php

				if(count($facturacion) > 0){

					for($i=0; $i<count($facturacion); $i++){
			 ?>
				<tr>
					<td><?php echo $facturacion[$i]['id_fact']; ?></td>
					<td><?php echo $facturacion[$i]['fecha_factura']; ?></td>
					<td><?php echo $facturacion[$i]['fecha_vencimiento']; ?></td>
					<td><?php echo $facturacion[$i]['id_ingreso_fk']; ?></td>
					<td><?php echo $facturacion[$i]['valor_total']; ?></td>
				</tr>
			<?php
					}
				}
				
			?>
			</tbody>
			<tfoot>
				<tr id="detalle_totales">
					<td class="textcenter"><span>Cantidad</span></td>
					<td class="textright"><span><?php echo ($cantidad[0]['count(id_fact)']); ?></span></td>
					<td class="textright"><span>Valor Total</span></td>
					<td class="textright" colspan="2"><span><?php echo "$ ".number_format($total[0]['sum(valor_total)']); ?></span></td>
				</tr>
		</tfoot>
	</table>
	<div>
		<p class="nota">Documento informativo</p>		
	</div>

</div>
<!-- Option 1: Bootstrap Bundle with Popper -->
</body>
</html>
<?php
}

$html= ob_get_clean();
//echo $html;
require_once '../pdf/dompdf/autoload.inc.php';//Para crear un objeto 
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$options = $dompdf->getOptions();//activar opciones obtenga imagenes 
$options->set(array('isRemoteEnabled'=>true));
$dompdf->setOptions($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('letter');//Crear con formato de carta
$dompdf->render();//Poner todo lo que se indico visible
$dompdf->stream("informeFacturas.pdf",array("Attachment"=>false));

?>