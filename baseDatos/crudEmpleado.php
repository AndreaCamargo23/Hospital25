<?php
$contador =+1;
include './conexionbd.php'; 
//Creación del objeto de la clase 
$obBD = new Conexion(); 
$link = $obBD->Conectar(); //crear conexion 
//datos de variables del formulario
$id=(isset($_POST['id']))?$_POST['id']:''; 
$nom=(isset($_POST['nom']))?$_POST['nom']:'';
$ape=(isset($_POST['ape']))?$_POST['ape']:'';
$dire=(isset($_POST['dire']))?$_POST['dire']:'';
$fecha_nac=(isset($_POST['fecha_nac']))?$_POST['fecha_nac']:'';
$email=(isset($_POST['email']))?$_POST['email']:'';
$cargo=(isset($_POST['cargo']))?$_POST['cargo']:'';
$estado=(isset($_POST['estado']))?$_POST['estado']:'';
$opciones=(isset($_POST['opcion']))?$_POST['opcion']:''; 

switch($opciones){
    case 1://Insertar datos
	try{
		$sql="insert into empleado (id_empleado,nombre,apellido,direccion,fecha_nac,email,id_cargo_fk,id_estado_fk)
         values('$id','$nom','$ape','$dire','$fecha_nac','$email','$cargo','$estado')";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        //Mostrar los datos insertado en la tabla
        $sql ="select * from empleado order by id_empleado desc limit 1"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
	} catch(Exception $ex){
		$data = null; 
	}
    break; 
    
    case 2://Actualizar datos 
	try{
		$sql ="UPDATE empleado SET nombre='$nom',apellido='$ape',direccion='$dire',fecha_nac='$fecha_nac',email='$email',id_cargo_fk='$cargo',id_estado_fk='$estado' WHERE id_empleado='$id'";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        //Mostrar los datos insertdos en la tabla de Alumnos
        $sql ="select * from usuario order by id_usuario desc limit 1"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
	} catch(Exception $ex){
		$data = null; 
	}        
        break; 
    

    case 3://Cambiar estado a inactivo 
        try{
		$sql ="update empleado set id_estado_fk='2' where id_empleado=$id"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $sql ="select * from empleado where id_empleado=$id"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
	} catch(Exception $ex){
		$data = null; 
	}
        break; 
    

    case 4://Consultar
        $sql ="SELECT id_empleado, concat(nombre,apellido), direccion,fecha_nac, email, cargo, estado  
		FROM empleado em join estado e ON (e.id_estado=em.id_estado_fk) join cargo c on (c.id_cargo=em.id_cargo_fk);"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector        
        break; 
    case 5://Consultar solo los datos de un solo usuario 
        $sql ="select * from empleado where id_empleado=$id";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
        break;
    
}
print json_encode($data,JSON_UNESCAPED_UNICODE); 
//Envio el vector en formato json a AJAX 
$link = null; 
?>