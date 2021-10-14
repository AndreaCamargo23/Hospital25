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
$genero=(isset($_POST['genero']))?$_POST['genero']:'';
$rh=(isset($_POST['rh']))?$_POST['rh']:'';
$estado=(isset($_POST['estado']))?$_POST['estado']:'';
$celu=(isset($_POST['celu']))?$_POST['celu']:'';
$opciones=(isset($_POST['opcion']))?$_POST['opcion']:''; 

switch($opciones){
    case 1://Insertar datos
	try{
		$sql="INSERT INTO paciente (id_paciente,nombre,apellido,direccion,fecha_nac,email,celular,id_genero_fk,id_rh_fk,id_estado_fk)
		VALUES ('$id','$nom','$ape','$dire','$fecha_nac','$email','$celu','$genero','$rh','$estado')";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        //Mostrar los datos insertado en la tabla
        $sql ="select * from paciente order by id_paciente desc limit 1"; 
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
		  $sql ="select * from ingreso join facturacion on (facturacion.id_ingreso_fk=ingreso.id_ingreso) where id_paciente_fk='$id'"; 
		  $res = $link->prepare($sql);//Prepara la consulta para su ejecución
		  $res->execute(); //Ejecuta la consulta.
		  $data = $res->fetchAll(PDO::FETCH_ASSOC);
		 if(count($data)!=0){
			 $data=null;
		 }else{
			 $sql ="update paciente set id_estado_fk='5' where id_paciente=$id"; 
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta.
			$fechaActual = date('Y-m-d');// obtenemos fecha actual
			$dias = date("d", strtotime($fechaActual))+10;
			$fechaVencimiento = date("Y", strtotime($fechaActual))."-".date("m", strtotime($fechaActual))."-".$dias;
			// Agregar la fecha de salida en el ingreso
			$sql ="update ingreso set fecha_salida='$fechaActual' where id_paciente_fk='$id'"; 
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			
			//generar la factura
			
			//Consultar para el valor total
			$sql ="select ingreso.id_ingreso, sum(valor_s), valor_c from ingreso left join adquirir on (ingreso.id_ingreso=adquirir.id_ingreso)
					left join servicio on (adquirir.id_servicio=servicio.id_servicio)
					left join cama on (ingreso.id_cama_fk=cama.id_cama)
					where ingreso.id_paciente_fk='$id';"; 
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$data = $res->fetchAll(PDO::FETCH_ASSOC);
			$valor_total=$data[0]['sum(valor_s)']+$data[0]['valor_c']; //obtenemos valor total	
			$id_ingreso=$data[0]['id_ingreso']; 
			//Insertar factura
			$sql ="INSERT INTO facturacion (fecha_factura, fecha_pago, valor_total, id_estado_fk, id_ingreso_fk, fecha_vencimiento) 
					VALUES ('$fechaActual','0000-00-00','$valor_total','14','$id_ingreso','$fechaVencimiento')"; 
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			//finalizar la generación de la factura
			$sql ="select * from paciente left join ingreso on(paciente.id_paciente=ingreso.id_paciente_fk) 
			where id_paciente=$id"; 
			$res = $link->prepare($sql);//Prepara la consulta para su ejecución
			$res->execute(); //Ejecuta la consulta
			$data = $res->fetchAll(PDO::FETCH_ASSOC);
		 }
		
	} catch(Exception $ex){
		$data = null; 
	}
        break; 
    

    case 4://Consultar
        $sql ="SELECT id_paciente, concat(nombre, apellido), direccion, fecha_nac, email, celular,TIMESTAMPDIFF(YEAR,fecha_nac,CURDATE()) AS edad, genero.genero,
		rh.rh, estado.estado FROM paciente join genero on(genero.id_genero=paciente.id_genero_fk) 
		join rh on (rh.id_rh=paciente.id_rh_fk) join estado on (estado.id_estado=paciente.id_estado_fk)"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector        
        break; 
		
    case 5://Consultar solo los datos de un solo usuario 
        $sql ="select * from paciente where id_paciente=$id";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
        break;
    case 6://historial
        $sql ="select ingreso.id_ingreso, ingreso.descripcion,ingreso.fecha_ingreso,
		concat(paciente.nombre,' ',paciente.apellido) as nom, fecha_nac, habitacion.id_habi, cama.id_cama,servicio.nombre
		from ingreso left join paciente on (ingreso.id_paciente_fk=paciente.id_paciente)
		left join cama on (ingreso.id_cama_fk=cama.id_cama) 
        left join habitacion on (habitacion.id_habi=cama.id_habitacion_fk)
        left join adquirir on (adquirir.id_ingreso = ingreso.id_ingreso)
        left join servicio on (servicio.id_servicio = adquirir.id_servicio)";        
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector        
        break; 
    
}
print json_encode($data,JSON_UNESCAPED_UNICODE); 
//Envio el vector en formato json a AJAX 
$link = null; 
?>