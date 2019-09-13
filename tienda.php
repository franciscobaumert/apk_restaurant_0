<?php
session_start();
include("menu.php");
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);
$modulo=$rs1["accesos"];

$b = explode(".", $modulo);
$t=recoge1('t');
$a=recoge1('a');
$_SESSION['servicio1']="0";
$_SESSION['tipo']=0;
if ($t==1) {
    if($b[32]==1){
        $_SESSION['tienda']=1;   
    }
}
if ($t==2) {
    if($b[33]==1){
        $_SESSION['tienda']=2;   
    }
}
if($t==3){
    if($b[34]==1){
        $_SESSION['tienda']=3;   
    }
}
if($t==4){
    if($b[34]==1){
        $_SESSION['tienda']=4;   
    }
}
if($t==5){
    if($b[34]==1){
        $_SESSION['tienda']=5;   
    }
}
if($t==6){
    if($b[34]==1){
        $_SESSION['tienda']=6;   
    }
}
header("location:$a");   
?>