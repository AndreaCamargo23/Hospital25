<?php
$contador =+1;
include './conexionbd.php'; 
//Creación del objeto de la clase 
$obBD = new Conexion(); 
$link = $obBD->Conectar(); //crear conexion 
//datos de variables del formulario
$id_usuario=(isset($_POST['id_usuario']))?$_POST['id_usuario']:''; 
$codigo=(isset($_POST['codigo']))?$_POST['codigo']:''; 
$email=(isset($_POST['email']))?$_POST['email']:'';
$passwd=(isset($_POST['passwd']))?$_POST['passwd']:'';
$rol=(isset($_POST['rol']))?$_POST['rol']:'';
$estado=(isset($_POST['estado']))?$_POST['estado']:'';
$nomUsua=(isset($_POST['nomUsua']))?$_POST['nomUsua']:'';
$opciones=(isset($_POST['opcion']))?$_POST['opcion']:''; 

switch($opciones){
    case 1://Insertar datos
	try{
		$sql="insert into usuario (email,passwd,id_rol_fk,id_estado_fk,nombre_usua,codigo)
         values('$email','$passwd','$rol','$estado','$nomUsua','$codigo')";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        //Mostrar los datos insertado en la tabla
        $sql ="select * from usuario order by id_usuario desc limit 1"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
	} catch(Exception $ex){
		$data = null; 
	}
    break; 
    
    case 2://Actualizar datos 
	try{
		$sql ="update usuario set email='$email',passwd='$passwd',id_rol_fk='$rol', id_estado_fk='$estado', nombre_usua='$nomUsua', codigo=$codigo where id_usuario=$id_usuario;";
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
    

    case 3://Eliminar
        try{
		$sql ="update usuario set id_estado_fk='3' where id_usuario=$id_usuario"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $sql ="select * from usuario order by id_usuario desc limit 1"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
	} catch(Exception $ex){
		$data = null; 
	}
        break; 
    

    case 4://Consultar
        $sql ="SELECT u.id_usuario, u.nombre_usua,u.email,r.nombre_rol, e.estado
        from usuario u join rol r on(u.id_rol_fk=r.id_rol) join estado e on(e.id_estado=u.id_estado_fk);"; 
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
        
        break; 
    case 5:
        $sql ="select * from usuario where id_usuario=$id_usuario";
        $res = $link->prepare($sql);//Prepara la consulta para su ejecución
        $res->execute(); //Ejecuta la consulta
        $data = $res->fetchAll(PDO::FETCH_ASSOC);//Va almacenar commo un vector
        break;
    
}
print json_encode($data,JSON_UNESCAPED_UNICODE); 
//Envio el vector en formato json a AJAX 
$link = null; 
?>