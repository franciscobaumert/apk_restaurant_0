<?php
session_start();
include("menu.php");
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
$accion=recoge1('accion');
$precio=recoge1('precio');
$ser=recoge1('ser');
$id=recoge1('id');
 
if ($accion==0) {
    $_SESSION['servicio1']="0";
    $_SESSION['tipo']=0;
    $consulta1 = "DELETE FROM servicio WHERE activo=0";
    if (mysqli_query($con, $consulta1)) {
        header("location:ingresoservicios.php");
    }        
} 
if ($accion==1) {
 $_SESSION['tipo']=1;
}
if ($accion==2) {
 $_SESSION['tipo']=2;
}
if ($accion==3) {
 $_SESSION['tipo']=3;
}
if ($accion==4) {
 $_SESSION['tipo']=4;
}
if ($accion==5) {
 $_SESSION['tipo']=5;
}
if ($accion==6) {
 $_SESSION['tipo']=6;
}
if ($accion==6) {
 
 $_SESSION['id']=$id;
 $_SESSION['precio']=$precio;
}
if ($accion==7) {
 $_SESSION['servicio1']=$ser;
}
header("location:ingresoservicios.php");

?>