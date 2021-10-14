<?php
$contador =+1;
include './conexionbd.php'; 
//Creación del objeto de la clase 
$obBD = new Conexion(); 
$link = $obBD->Conectar(); //crear conexion 
//datos de variables del formulario
$id=(isset($_POST['id']))?$_POST['id']:''; 
$fecha_ingreso=(isset($_POST['fecha_ingreso']))?$_POST['fecha_ingreso']:'';
$fecha_salida=(isset($_POST['fecha_salida']))?$_POST['fecha_salida']:'';
$descripcion=(isset($_POST['descripcion']))?$_POST['descripcion']:'';
$id_paciente=(isset($_POST['id_paciente']))?$_POST['id_paciente']:'';
$cama=(isset($_POST['cama']))?$_POST['cama']:'';
$id_servicio=(isset($_POST['id_servicio']))?$_POST['id_servicio']:'';
$id_empleado=(isset($_POST['id_empleado']))?$_POST['id_empleado']:'';
$opciones=(isset($_POST['opcion']))?$_POST['opcion']:''; 

switch($opciones){
    case 1://Insertar datos
	try{
		//Crear el ingreso
		$sql="INSERT INTO ingreso(fecha_ingreso, fecha_salida, descripcion, id_paciente_fk, id_cama_fk) 
		VALUES ('$fecha_ingreso','$fecha_salida','$descripcion','$id_paciente','$cama')";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
		
		//Mostrar los datos insertado en la tabla
        $sql ="select * from ingreso where descripcion='$descripcion'"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
		$id=$data[0]['id_ingreso'];
		//Agregar el servicio
		$sql="INSERT INTO adquirir(id_servicio, id_ingreso) VALUES ('$id_servicio','$id')";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
		//Agregar el empleado 
		$sql="INSERT INTO atender(id_empleado, id_ingreso) VALUES ('$id_empleado','$id')";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        //Marcar la cama como ocupada
		$sql="update cama set id_estado_fk='11' where id_cama='$cama'";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
	} catch(Exception $ex){
		$data = null; 
	}
    break; 
    
    case 2://Agregar en atender
	try{
		$sql="INSERT INTO atender(id_empleado, id_ingreso) VALUES ('$id_empleado','$id')";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
		$data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
	} catch(Exception $ex){
		$data = null; 
	}        
        break; 
    

    case 3://Lo voy a usar para cambiar el estado
      try{
		 //Cambia el estado del paciente
		$sql ="update paciente set id_estado_fk='7' where id_paciente=$id_paciente"; 
        $res = $link->prepare($sql);
        $res->execute();
		
		//Calculo de la factura actual
		$fechaActual = date('Y-m-d');
		$dias = date("d", strtotime($fechaActual))+10;
		$fechaVencimiento = date("Y", strtotime($fechaActual))."-".date("m", strtotime($fechaActual))."-".$dias;
		
		// Agregar la fecha de salida en el ingreso
		$sql ="update ingreso set fecha_salida='$fechaActual' where id_ingreso='$id'"; 
        $res = $link->prepare($sql);
        $res->execute(); 
		
		//GENERAR FACTURA
		
		//Consultar para el valor total
		$sql ="select ingreso.id_ingreso, sum(valor_s), valor_c from ingreso left join adquirir on (ingreso.id_ingreso=adquirir.id_ingreso)
				left join servicio on (adquirir.id_servicio=servicio.id_servicio)
				left join cama on (ingreso.id_cama_fk=cama.id_cama)
				where ingreso.id_paciente_fk='$id';"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
		$data = $res->fetchAll(PDO::FETCH_ASSOC);
		
		//Calcula el valor total
		$valor_total=$data[0]['sum(valor_s)']+$data[0]['valor_c']; 
		
		//Crear Factura
		$sql ="INSERT INTO facturacion (fecha_factura, fecha_pago, valor_total, id_estado_fk, id_ingreso_fk, fecha_vencimiento) 
				VALUES ('$fechaActual','0000-00-00','$valor_total','14','$id','$fechaVencimiento')"; 
        $res = $link->prepare($sql);
        $res->execute(); 
		//finalizar la generación de la factura
		
        //generar pdf
	} catch(Exception $ex){
		$data = null; 
	}
        break; 
    

    case 4://Consultar
        $sql ="select ingreso.id_ingreso,ingreso.fecha_ingreso, ingreso.fecha_salida, ingreso.descripcion,
		paciente.nombre, paciente.apellido, habitacion.id_habi, cama.id_cama
		from ingreso left join paciente on (ingreso.id_paciente_fk=paciente.id_paciente)
		left join cama on (ingreso.id_cama_fk=cama.id_cama) left join habitacion on (habitacion.id_habi=cama.id_habitacion_fk)"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector        
        break; 
		
    case 5://Consultar solo los datos de un solo usuario 
        //Agregar el servicio
		try{
			$sql="INSERT INTO adquirir(id_servicio, id_ingreso) VALUES ('$id_servicio','$id')";
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
		}catch (Exception $ex){
			$data=null;
		}		
        break;
	case 6:
		try{
			$sql="select servicio.id_servicio,valor_s, nombre from ingreso left join adquirir on (ingreso.id_ingreso=adquirir.id_ingreso) left join servicio on (adquirir.id_servicio=servicio.id_servicio) where ingreso.id_ingreso='$id'";
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
		}catch (Exception $ex){
			$data=null;
		}
	break; 
	case 7:
		try{
			$sql="select * from ingreso left join atender on (ingreso.id_ingreso=atender.id_ingreso) left join empleado on (atender.id_empleado=empleado.id_empleado) where ingreso.id_ingreso='$id'";
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
		}catch (Exception $ex){
			$data=null;
		}
	break;
	
	case 8:
		//try{
			$sql="select * from facturacion where id_ingreso_fk='$id'";
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
			if(count($data)==0){
				//Calculo de fechas
				$fechaActual = date('Y-m-d');// obtenemos fecha actual
				$dias = date("d", strtotime($fechaActual))+10;
				$fechaVencimiento = date("Y", strtotime($fechaActual))."-".date("m", strtotime($fechaActual))."-".$dias;
				
				//Actualizar la fecha de salida del ingreso
				$sql="update ingreso set fecha_salida='$fechaActual' where id_ingreso='$id'";
				$res = $link->prepare($sql);//Prepara la consulta para su ejecución
				$res->execute(); //Ejecuta la consulta
				
				//Obtener el id del paciente
				$sql="select * from ingreso left join adquirir on(ingreso.id_ingreso=adquirir.id_ingreso) 
				left join servicio on (adquirir.id_servicio=servicio.id_servicio) left join cama on(ingreso.id_cama_fk=cama.id_cama) where ingreso.id_ingreso='$id'";
				$res = $link->prepare($sql);//Prepara la consulta para su ejecución
				$res->execute(); //Ejecuta la consulta				
				$data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
				$id_paciente=$data[0]['id_paciente_fk'];
				
				//actualizar el estado de paciente
				$sql="update paciente set id_estado_fk='7' where id_paciente='$id_paciente'";
				$res = $link->prepare($sql);//Prepara la consulta para su ejecución
				$res->execute(); //Ejecuta la consulta
				
				//Calculo del valor total
				$sql="select *,sum(valor_s) from ingreso left join adquirir on(ingreso.id_ingreso=adquirir.id_ingreso) 
				left join servicio on (adquirir.id_servicio=servicio.id_servicio) left join cama on(ingreso.id_cama_fk=cama.id_cama) where ingreso.id_ingreso='$id'";
				$res = $link->prepare($sql);//Prepara la consulta para su ejecución
				$res->execute(); //Ejecuta la consulta				
				$data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
				$valorServicion=$data[0]['sum(valor_s)'];
				$valorCama=$data[0]['valor_c'];
				$valor_total=$valorServicion+$valorCama;
				//Insertar factura
				$sql ="INSERT INTO facturacion (fecha_factura, fecha_pago, valor_total, id_estado_fk, id_ingreso_fk, fecha_vencimiento) 
					VALUES ('$fechaActual','0000-00-00','$valor_total','14','$id','$fechaVencimiento')"; 
				$res = $link->prepare($sql);//Prepara la consulta para su ejecución
				$res->execute(); //Ejecuta la consulta
				
			}else{
				$data=null;
			}
		/*}catch (Exception $ex){
			$data=null;
		}*/
	break;
    
}
print json_encode($data,JSON_UNESCAPED_UNICODE); 
//Envio el vector en formato json a AJAX 
$link = null; 
?>