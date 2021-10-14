<?php 
    $contador =+1;
    include ('./conexionbd.php'); 
    
    $obBD = new Conexion(); 
    $link = $obBD->Conectar();

    $id_usuario=(isset($_POST['id_usuario']))?$_POST['id_usuario']:''; 
    $email=(isset($_POST['email']))?$_POST['email']:'';
    $password=(isset($_POST['password']))?$_POST['password']:'';
    $rol=(isset($_POST['rol']))?$_POST['rol']:'';
    $estado=(isset($_POST['estado']))?$_POST['estado']:'';
    $user=(isset($_POST['user']))?$_POST['user']:'';
    $codigo=(isset($_POST['codigo']))?$_POST['codigo']:''; 

   
    try{
        $sql="insert into usuario (email,passwd,id_rol_fk,id_estado_fk,nombre_usua,codigo) values('$email','$password','$rol','$estado','$user','$codigo')";

        $rews=$link->prepare($sql);
        $rews->execute();
        
        $data=$rews->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $ex){
        $data=null;
    }
    print json_encode($data,JSON_UNESCAPED_UNICODE);
    $link=null;    
?>