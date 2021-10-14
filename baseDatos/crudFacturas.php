<?php
$contador =+1;
include './conexionbd.php'; 
//Creación del objeto de la clase 
$obBD = new Conexion(); 
$link = $obBD->Conectar(); //crear conexion 
//datos de variables del formulario
$id=(isset($_POST['id']))?$_POST['id']:''; 
$fechaVencimiento=(isset($_POST['fecha_vencimiento']))?$_POST['fecha_vencimiento']:''; 
$opciones=(isset($_POST['opcion']))?$_POST['opcion']:''; 

switch($opciones){
    case 1://Insertar datos
	try{
		$sql ="SELECT s.valor_s, s.nombre FROM ingreso JOIN
        adquirir on (ingreso.id_ingreso=adquirir.id_ingreso) JOIN
        servicio s on (adquirir.id_servicio=s.id_servicio) WHERE ingreso.id_ingreso='$id'";
        $res = $link->prepare($sql);
        $res->execute(); 
		$data = $res->fetchAll(PDO::FETCH_ASSOC);
	} catch(Exception $ex){
		$data = null; 
	}
    break; 
    
    case 2://Actualizar datos 
	try{
		$sql ="UPDATE facturacion SET fecha_vencimiento='$fechaVencimiento' WHERE id_fact='$id';";
        $res = $link->prepare($sql);
        $res->execute(); 
        
        $sql ="select * from facturacion order by id_fact desc limit 1"; 
        $res = $link->prepare($sql);
        $res->execute(); 
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
	} catch(Exception $ex){
		$data = null; 
	}        
        break; 
    

    case 3://Cambiar estado a inactivo 
        $sql ="SELECT p.nombre, p.apellido, c.valor_c, f.valor_total FROM ingreso JOIN
        paciente p on (id_paciente_fk=p.id_paciente) JOIN
        cama c on (id_cama_fk=c.id_cama) JOIN
        facturacion f on (id_ingreso=f.id_ingreso_fk)
        WHERE id_ingreso='$id'";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
		$data = $res->fetchAll(PDO::FETCH_ASSOC);
        break; 
    

    case 4:
        $sql ="SELECT f.id_fact, f.fecha_factura, f.fecha_pago, f.valor_total, f.fecha_vencimiento, e.estado, f.id_ingreso_fk 
        FROM facturacion f join estado e on(e.id_estado=f.id_estado_fk)"; 
        $res = $link->prepare($sql);
        $res->execute(); 
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        break; 
		
    case 5:
        $sql ="SELECT fecha_vencimiento FROM facturacion WHERE id_fact='$id'";
        $res = $link->prepare($sql);
        $res->execute(); 
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        break;
    
}
print json_encode($data,JSON_UNESCAPED_UNICODE);
$link = null; 
?>