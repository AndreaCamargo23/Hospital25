<?php
$contador =+1;
include './conexionbd.php'; 
//Creación del objeto de la clase 
$obBD = new Conexion(); 
$link = $obBD->Conectar(); //crear conexion 
//datos de variables del formulario
$id_habi=(isset($_POST['id_habi']))?$_POST['id_habi']:'';
$valorCama=(isset($_POST['valorCama']))?$_POST['valorCama']:'';
$tipo=(isset($_POST['tipo']))?$_POST['tipo']:'';
$opciones=(isset($_POST['opcion']))?$_POST['opcion']:''; 

switch($opciones){
    case 1://Insertar datos
	try{
		$sql="insert into habitacion (id_habi,id_estado_fk)
         values('$id_habi','12')";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        //Mostrar los datos insertado en la tabla
        $sql ="select * from habitacion order by id_habi desc limit 1"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
	} catch(Exception $ex){
		$data = null; 
	}
    break; 
    
    case 2://insertar datos de la cama
	try{
		$sql ="insert into cama (valor_c,id_estado_fk,id_habitacion_fk,id_tipo_fk)
		values ('$valorCama','1','$id_habi','$tipo');";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
		$data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
	} catch(Exception $ex){
		$data = null; 
	}
        break; 
    

    case 3://Ver paciente
        $sql ="Select paciente.id_paciente,nombre, apellido 
		from paciente left join ingreso on (paciente.id_paciente=ingreso.id_paciente_fk) 
		left join cama on (ingreso.id_cama_fk=cama.id_cama) where cama.id_habitacion_fk='$id_habi'";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
		$data = $res->fetchAll(PDO::FETCH_ASSOC);
        break; 
    

    case 4://Consultar
        $sql ="SELECT id_habi, count(c.id_cama) as camas , e.estado, 
		count(if(c.id_estado_fk=1,1,null)) as disponibles
		from habitacion h left join cama c on(h.id_habi=c.id_habitacion_fk) left join estado e on(h.id_estado_fk=e.id_estado) 
		group by 1;"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
        for($i=0; $i<count($data); $i++){
			if($data[$i]['camas']==0){
				$data[$i]['estado']="sin camas";
				$sql ="update habitacion set id_estado_fk='12' where id_habi='".$data[$i]['id_habi']."'";
				$res = $link->prepare($sql);//Prepara la consulta para su ejecución
				$res->execute(); //Ejecuta la consulta
			}else if($data[$i]['disponibles']==0){
				$data[$i]['estado']="Ocupada";
				$sql ="update habitacion set id_estado_fk='11' where id_habi='".$data[$i]['id_habi']."'";
				$res = $link->prepare($sql);//Prepara la consulta para su ejecución
				$res->execute(); //Ejecuta la consulta
			}else if($data[$i]['disponibles']>=1){
				$data[$i]['estado']="Disponible";
				$sql ="update habitacion set id_estado_fk='10' where id_habi='".$data[$i]['id_habi']."'";
				$res = $link->prepare($sql);//Prepara la consulta para su ejecución
				$res->execute(); //Ejecuta la consulta
			}		
		}	
		$sql ="SELECT id_habi, count(c.id_cama) as camas , e.estado,
		count(if(c.id_estado_fk=1,1,null)) as disponibles
		from habitacion h left join cama c on(h.id_habi=c.id_habitacion_fk) left join estado e on(h.id_estado_fk=e.id_estado)
		group by 1;"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
        break; 
    
}
print json_encode($data,JSON_UNESCAPED_UNICODE); 
//Envio el vector en formato json a AJAX 
$link = null; 
?>