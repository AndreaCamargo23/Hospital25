<?php
$contador =+1;
include './conexionbd.php'; 
//Creación del objeto de la clase 
$obBD = new Conexion(); 
$link = $obBD->Conectar(); //crear conexion 
//datos de variables del formulario
$id_cama=(isset($_POST['id_cama']))?$_POST['id_cama']:''; 
$valor_c=(isset($_POST['valor_c']))?$_POST['valor_c']:''; 
$tipo=(isset($_POST['tipo']))?$_POST['tipo']:''; 
$id_habitacion_fk=(isset($_POST['id_habitacion_fk']))?$_POST['id_habitacion_fk']:''; 
$estado=(isset($_POST['estado']))?$_POST['estado']:''; 
$opciones=(isset($_POST['opcion']))?$_POST['opcion']:''; 
switch($opciones){
    case 1://Insertar datos
	try{
		$sql="INSERT INTO cama(valor_c, id_estado_fk, id_habitacion_fk, id_tipo_fk) 
		VALUES ('$valor_c','$estado','$id_habitacion_fk','$tipo')";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        //Mostrar los datos insertado en la tabla
        $sql ="select * from cama order by id_cama desc limit 1"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
	} catch(Exception $ex){
		$data = null; 
	}
    break; 
    
    case 2://Actualizar datos 
	try{
		$sql ="UPDATE paciente SET nombre='$nom',apellido='$ape',direccion='$dire',fecha_nac='$fecha_nac',email='$email',id_genero_fk='$genero',id_rh_fk='$rh',
		id_estado_fk='$estado' WHERE id_paciente=$id";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        //Mostrar los datos insertdos en la tabla de Alumnos
        $sql ="select * from paciente order by id_paciente desc limit 1"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
	} catch(Exception $ex){
		$data = null; 
	}        
        break; 
    

    case 3://Cambiar estado a inactivo 
      try{
		$sql ="update cama set id_estado_fk='2' where id_cama='$id_cama'"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta.
	} catch(Exception $ex){
		$data = null; 
	}
        break; 
    

    case 4://Consultar
        $sql ="select id_cama,valor_c,tipo,id_habitacion_fk,estado from cama left join tipo on(cama.id_tipo_fk=tipo.id_tipo)
		left join estado on (cama.id_estado_fk=estado.id_estado)"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector        
        break; 
		
    case 5://Consultar solo los datos de un solo usuario 
        $sql ="select * from cama where id_cama='$id_cama'";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
        break;
    
}
print json_encode($data,JSON_UNESCAPED_UNICODE); 
//Envio el vector en formato json a AJAX 
$link = null; 
?>