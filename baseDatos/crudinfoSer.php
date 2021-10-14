<?php
$contador =+1;
include './conexionbd.php'; 
//Creación del objeto de la clase 
$obBD = new Conexion(); 
$link = $obBD->Conectar(); //crear conexion 
//datos de variables del formulario
$fecha_entrada=(isset($_POST['fecha_entrada']))?$_POST['fecha_entrada']:''; 
$fecha_salida=(isset($_POST['fecha_salida']))?$_POST['fecha_salida']:''; 
$opciones=(isset($_POST['opcion']))?$_POST['opcion']:''; 

switch($opciones){
    case 1:
        $sql ="SELECT s.id_servicio, s.nombre, COUNT(*) FROM ingreso i JOIN
        adquirir on (i.id_ingreso=adquirir.id_ingreso) JOIN
        servicio s on (adquirir.id_servicio=s.id_servicio)
        GROUP BY s.id_servicio HAVING COUNT(*)>0;";
        $res = $link->prepare($sql);
        $res->execute(); 
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        break; 
		
    case 2:
        $sql ="SELECT s.id_servicio, s.nombre, COUNT(*) FROM ingreso i JOIN
        adquirir on (i.id_ingreso=adquirir.id_ingreso) JOIN
        servicio s on (adquirir.id_servicio=s.id_servicio) 
        WHERE i.fecha_ingreso BETWEEN '$fecha_entrada' AND '$fecha_salida'
        GROUP BY s.id_servicio HAVING COUNT(*)>0;";
        $res = $link->prepare($sql);
        $res->execute(); 
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        break;
    
}
print json_encode($data,JSON_UNESCAPED_UNICODE);
$link = null; 
?>