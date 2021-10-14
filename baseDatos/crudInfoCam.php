<?php
$contador =+1;
include './conexionbd.php'; 
//Creación del objeto de la clase 
$obBD = new Conexion(); 
$link = $obBD->Conectar(); //crear conexion 
//datos de variables del formulario
$id=(isset($_POST['id']))?$_POST['id']:''; 
$id_paciente=(isset($_POST['id_paciente']))?$_POST['id_paciente']:'';
$cama=(isset($_POST['cama']))?$_POST['cama']:'';
$id_servicio=(isset($_POST['id_servicio']))?$_POST['id_servicio']:'';
$id_empleado=(isset($_POST['id_empleado']))?$_POST['id_empleado']:'';
$opciones=(isset($_POST['opcion']))?$_POST['opcion']:''; 

switch($opciones){
 
    case 1://Consultar
        $sql ="select ingreso.id_ingreso, ingreso.descripcion,
		paciente.nombre as nom, habitacion.id_habi, cama.id_cama,servicio.nombre
		from ingreso left join paciente on (ingreso.id_paciente_fk=paciente.id_paciente)
		left join cama on (ingreso.id_cama_fk=cama.id_cama) 
        left join habitacion on (habitacion.id_habi=cama.id_habitacion_fk)
        left join adquirir on (adquirir.id_ingreso = ingreso.id_ingreso)
        left join servicio on (servicio.id_servicio = adquirir.id_servicio)";        
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
    
}
print json_encode($data,JSON_UNESCAPED_UNICODE); 
//Envio el vector en formato json a AJAX 
$link = null; 
?>