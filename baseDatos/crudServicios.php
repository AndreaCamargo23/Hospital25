<?php
$contador =+1;
include './conexionbd.php'; 
//Creación del objeto de la clase 
$obBD = new Conexion(); 
$link = $obBD->Conectar(); //crear conexion 
//datos de variables del formulario
$id_servicio=(isset($_POST['id']))?$_POST['id']:''; 
$name=(isset($_POST['name']))?$_POST['name']:''; 
$valor=(isset($_POST['valor']))?$_POST['valor']:'';
$opciones=(isset($_POST['opcion']))?$_POST['opcion']:''; 

switch($opciones){
    case 1://Insertar datos
	try{
		$sql="insert into servicio (nombre,valor_s)
         values('$name','$valor')";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        //Mostrar los datos insertado en la tabla
        $sql ="select * from servicio order by id_servicio desc limit 1"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
	} catch(Exception $ex){
		$data = null; 
	}
    break; 
    
    case 2://Actualizar datos 
	try{
		$sql ="update servicio set nombre='$name',valor_s='$valor' where id_servicio=$id_servicio;";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        //Mostrar los datos insertdos en la tabla de Alumnos
        $sql ="select * from servicio order by id_servicio desc limit 1"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
	} catch(Exception $ex){
		$data = null; 
	}        
        break; 
    

    case 3://Agregar a un paciente.
        $sql ="SELECT id_habi, count(if(c.id_estado_fk=1,1,null)) as camas
		from habitacion h left join cama c on(h.id_habi=c.id_habitacion_fk)
		group by 1";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
		$data = $res->fetchAll(PDO::FETCH_ASSOC);
        break; 
    

    case 4://Consultar
        $sql ="select servicio.id_servicio, servicio.valor_s, servicio.nombre
		from servicio"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
        
        break; 
    case 5:
        $sql ="select * from servicio where id_servicio='$id_servicio'";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
        break;
    
}
print json_encode($data,JSON_UNESCAPED_UNICODE); 
//Envio el vector en formato json a AJAX 
$link = null; 
?>