<?php 
    $contador =+1;
    include ('./conexionbd.php'); 
    
    $obBD = new Conexion(); 
    $link = $obBD->Conectar();

    
    $password=(isset($_POST['password']))?$_POST['password']:'';    
    $user=(isset($_POST['user']))?$_POST['user']:'';
    $codigo=(isset($_POST['codigo']))?$_POST['codigo']:''; 

    $sql="update usuario set passwd='$password' where nombre_usua='$user' and codigo='$codigo';";

    $rews=$link->prepare($sql);
    $rews->execute();
    
    if($rews->rowCount()>=1){
        $data=$rews->fetchAll(PDO::FETCH_ASSOC);
       
    
    }else{
        $data=NULL;
    }
    print json_encode($data,JSON_UNESCAPED_UNICODE);
    $link=null;    
?>