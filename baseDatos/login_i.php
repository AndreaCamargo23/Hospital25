<?php
session_start();
include ('./conexionbd.php');
$obBD = new Conexion(); 
$link = $obBD->Conectar();

$user=(isset($_POST['user'])?$_POST['user']:'');
$password=(isset($_POST['password'])?$_POST['password']:'');

$sql="select u.id_rol_fk,r.nombre_rol as rol from usuario u join rol as r on u.id_rol_fk=r.id_rol where nombre_usua='$user' and passwd='$password'";

$rews=$link->prepare($sql);
$rews->execute();

if($rews->rowCount()>=1){
    $data=$rews->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['user']=$user;
    $_SESSION['rol']=$data[0]['id_rol_fk'];
    $_SESSION['desc']=$data[0]['rol'];

    

}else{ 
    $_SESSION['user']=NULL;
    $data=NULL;
}
print json_encode($data,JSON_UNESCAPED_UNICODE);
$link=null;
?>