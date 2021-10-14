<?php
ob_start();//llenar el buffer para que todo el contenido quede en una variabe
if(empty($_REQUEST['ci'])){
		echo "No es posible generar la factura.";
	}else{
		
		include "../../baseDatos/conexionbd.php";//conexion a la base de datos 
			
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Historia Clinica</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']?>/Distrital/APLICACIONES/librerias/ingreso/style.css">
</head>
<body>
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="https://png.pngtree.com/png-vector/20200329/ourlarge/pngtree-hospital-icon-design-illustration-png-image_2166843.jpg" style="width:135px height:0px;">
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
					$codIngreso = $_REQUEST['ci'];
					$obBD = new Conexion(); 
					$link = $obBD->Conectar(); //crear conexion 
					$sql ="select * from facturacion where id_ingreso_fk='$codIngreso'"; 
					$res = $link->prepare($sql);//Prepara la consulta para su ejecución
					$res->execute(); //Ejecuta la consulta
					$factura = $res->fetchAll(PDO::FETCH_ASSOC);
					$sql ="select * from estado left join facturacion on (estado.id_estado=facturacion.id_estado_fk) where id_ingreso_fk='$codIngreso'"; 
					$res = $link->prepare($sql);//Prepara la consulta para su ejecución
					$res->execute(); //Ejecuta la consulta
					$estadoFactura = $res->fetchAll(PDO::FETCH_ASSOC);
					if(count($factura) > 0){
						$fechaActual = date('d-m-Y');
						$hora =date('h:i:s a');
						
				?>
				<div class="round">
					<span class="h3">Factura</span>					
					<p>No. Factura: <strong><?php echo strtoupper($factura[0]['id_fact']); ?></strong></p>
					<p>Fecha de Emision: <?php echo ($factura[0]['fecha_factura']); ?></p>
					<p>Hora: 10:30am</p>
					<p>Fecha Vencemiento: <?php echo ($factura[0]['fecha_vencimiento']); ?></p>
					<p>Estado: <?php echo ($estadoFactura[0]['estado']); ?></p>
				</div>
			</td>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
				<?php
				//Consulta historia
					$sql ="SELECT id_ingreso, DATE_FORMAT(fecha_ingreso,'%d/%m/%Y') as ingreso, DATE_FORMAT(fecha_salida,'%d/%m/%Y') as salida, descripcion, id_paciente_fk, id_cama_fk FROM ingreso
					WHERE id_ingreso='$codIngreso'"; 
					$res = $link->prepare($sql);//Prepara la consulta para su ejecución
					$res->execute(); //Ejecuta la consulta
					$historia = $res->fetchAll(PDO::FETCH_ASSOC);
					
				//consulta para paciente 
					$sql ="select *, concat(nombre,' ',apellido) as nombreCompleto,TIMESTAMPDIFF(YEAR,fecha_nac,CURDATE()) AS edad from ingreso left join paciente on (ingreso.id_paciente_fk=paciente.id_paciente) left join genero on(paciente.id_genero_fk=genero.id_genero)
					left join rh on (paciente.id_rh_fk=rh.id_rh)
					where ingreso.id_ingreso='$codIngreso'"; 
					$res = $link->prepare($sql);//Prepara la consulta para su ejecución
					$res->execute(); //Ejecuta la consulta
					$paciente = $res->fetchAll(PDO::FETCH_ASSOC);
					$id_cama = $historia[0]['id_cama_fk'];
					
					//consulta para cama
					$sql ="select * from cama left join habitacion on (cama.id_habitacion_fk=habitacion.id_habi) where id_cama='$id_cama'"; 
					$res = $link->prepare($sql);//Prepara la consulta para su ejecución
					$res->execute(); //Ejecuta la consulta
					$camaYhab = $res->fetchAll(PDO::FETCH_ASSOC);					
					
				?>
					<span class="h3">Paciente</span>
					<table class="datos_cliente">
						<tr>
							<td><label>Nombre:</label><p><?php echo ($paciente[0]['nombreCompleto']); ?></p></td>
							<td><label>Edad:</label> <p><?php echo ($paciente[0]['edad']); ?></p></td>
						</tr>
						<tr>
							<td><label>Identificacion:</label> <p><?php echo ($paciente[0]['id_paciente']); ?></p></td>
							<td><label>Fecha de nacimiento:</label> <p><?php echo ($paciente[0]['fecha_nac']); ?></p></td>
						</tr>
						<tr>
							<td><label>Dirección:</label> <p><?php echo ($paciente[0]['direccion']); ?></p></td>
							<td><label>Genero:</label> <p><?php echo ($paciente[0]['genero']); ?></p></td>
						</tr>
						<tr>
							<td><label>Telefono:</label> <p><?php echo ($paciente[0]['celular']); ?></p></td>
							<td><label>Rh:</label> <p><?php echo ($paciente[0]['rh']); ?></p></td>
						</tr>
						
					</table>
					<hr>
					<span class="h3">Ingreso</span>
					<table class="datos_cliente">
						<tr>
							<td><label>Fecha de ingreso:</label><p><?php echo ($historia[0]['ingreso']); ?></p></td>
							<td><label>Cama:</label> <p><?php echo ($camaYhab[0]['id_cama']); ?></p></td>
						</tr>
						<tr>
							<td><label>Fecha salida:</label> <p><?php echo ($historia[0]['salida']); ?></p></td>
							<td><label>Valor cama:</label> <p><?php echo "$ ".number_format($camaYhab[0]['valor_c']); ?></p></td>
						</tr>
						<tr>
							<td><label>Habitacion:</label> <p><?php echo ($camaYhab[0]['id_habi']); ?></p></td>
							<td><label>Descripcion:</label> <p><?php echo ($historia[0]['descripcion']); ?></p></td>
						</tr>
						
					</table>
				</div>
			</td>

		</tr>
	</table>
	<?php
	//Consulta para empleado
			$sql ="select * from empleado left join cargo on (empleado.id_cargo_fk=cargo.id_cargo) left join atender on (atender.id_empleado=empleado.id_empleado) where atender.id_ingreso='$codIngreso'"; 
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$empleado = $res->fetchAll(PDO::FETCH_ASSOC);
	?>
	<h3>Empleados que lo atendieron</h3>
	<table id="factura_detalle">
			<thead>
				<tr>
					<th width="50px"></th>
					<th class="textleft">Nombre</th>
					<th class="textleft">Apellido</th>
					<th class="textleft">Cargo</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
				<?php

				if(count($empleado) > 0){

					for($i=0; $i<count($empleado); $i++){
			 ?>
				<tr>
					<td class="textcenter"></td>
					<td><?php echo $empleado[$i]['nombre']; ?></td>
					<td class="textright"><?php echo $empleado[$i]['apellido']; ?></td>
					<td class="textright"><?php echo $empleado[$i]['cargo']; ?></td>
				</tr>
			<?php
					}
				}
			?>
			</tbody>
	</table>
	<?php
	//Consulta para datos del servicio
			$sql ="select * from servicio left join adquirir on (servicio.id_servicio=adquirir.id_servicio) where adquirir.id_ingreso='$codIngreso'"; 
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$servicio = $res->fetchAll(PDO::FETCH_ASSOC);
			//sub total
			$sql ="select sum(valor_s) as total from servicio left join adquirir on (servicio.id_servicio=adquirir.id_servicio) where adquirir.id_ingreso='$codIngreso'"; 
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$hola = $res->fetchAll(PDO::FETCH_ASSOC);
	?>
	<h3>Servicios Adquiridos</h3>
	<table id="factura_detalle">
			<thead>
				<tr>
					<th width="50px">No</th>
					<th class="textleft">Servicio</th>
					<th></th>
					<th class="textright" width="150px">Precio Unitario</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">				
				<?php

				if(count($servicio) > 0){

					for($i=0; $i<count($servicio); $i++){
			 ?>
				<tr>
					<td class="textcenter"><?php echo $servicio[$i]['id_servicio']; ?></td>
					<td><?php echo $servicio[$i]['nombre']; ?></td>
					<td></td>
					<td class="textright"><?php echo "$ ".number_format($servicio[$i]['valor_s']); ?></td>
				</tr>
			<?php
					}
				}
				
			?>
			</tbody>
			<tfoot id="detalle_totales">
				<tr>
					<td colspan="3" class="textright"><span>SUBTOTAL</span></td>
					<td class="textright"><span><?php echo "$ ".number_format($hola[0]['total']); ?></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>VALOR CAMA</span></td>
					<td class="textright"><span><?php echo "$ ".number_format($camaYhab[0]['valor_c']); ?></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright" style="font-size:65px"><span>TOTAL A PAGAR</span></td>
					<td class="textright"><span><?php echo "$ ".number_format($factura[0]['valor_total']); ?></span></td>
				</tr>
		</tfoot>
	</table>
	<div>
		<p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con nombre, teléfono y Email</p>
		
	</div>

</div>|
</body>
</html>
<?php
}
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
$dompdf->stream("Factura.pdf",array("Attachment"=>false));

?>