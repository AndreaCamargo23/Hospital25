<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
    if($_SESSION['user']==null){
        header('Location:../login.php');
    } 

	include "../../baseDatos/conexionbd.php";//conexion a la base de datos 
	require_once '../pdf/vendor/autoload.php';//incluye la libreria de pdf
	use Dompdf\Dompdf;//usar el archivo

	if(empty($_REQUEST['ci']))//validar que las variables no esten vacias
	{
		echo "No es posible generar la factura.";
	}else{
		echo "Entro";
		$codIngreso = $_REQUEST['ci'];
		$anulada = '';	
		$obBD = new Conexion(); 
		$link = $obBD->Conectar(); //crear conexion 
		$sql ="select * from facturacion where id_ingreso_fk='$codIngreso'"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
		$factura = $res->fetchAll(PDO::FETCH_ASSOC);
		if($factura>0){
			$fechaActual = date('d-m-Y');
			$hora =date('h:i:s a');
			//Consulta historia
			$sql ="SELECT id_ingreso, DATE_FORMAT(fecha_ingreso,'%d/%m/%Y'), DATE_FORMAT(fecha_salida,'%d/%m/%Y'), descripcion, id_paciente_fk, id_cama_fk FROM ingreso
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
			
			//Consulta para empleado
			
			
			//Consulta para datos del servicio

			ob_start();//guardar en memoria 
		    include(dirname('__FILE__').'/factura.php');//este archivo //acceder a la direccion del archivo 
		    $html = ob_get_clean();//caragar todo el html de ese archivo

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();//creacion de un objeto

			$dompdf->loadHtml($html);//cargar el contenido que se va a mostrar en ese pdf
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');//El tamaño del papel y la horientacion
			// Render the HTML as PDF
			$dompdf->render();//Leer el html para trasladarlo a pdf
			// Output the generated PDF to Browser
			$dompdf->stream('factura_'.$noFactura.'.pdf',array('Attachment'=>0));//especificar la salida
			exit;
		}else{
			echo "No se pudo generar la factura no existe.";
		}
	}

?>