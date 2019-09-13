<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
$producto=recoge1('producto');
$namefinal="nuevo.jpg";
if($producto==1){
    $foto="foto1";
}
if($producto==2){
    $foto="foto2";
}
if($producto==3){
    $foto="foto3";
}
if($producto==4){
    $foto="foto4";
}
$dml="update products set $foto='".$namefinal."' where id_producto=".$_SESSION['id_producto'];
if(!mysqli_query($con,$dml)){
    die("No se pudo actualizar..");
}else{
    header("location:fotos.php");
}
 
?>



