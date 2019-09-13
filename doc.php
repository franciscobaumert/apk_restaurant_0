<?php
session_start();
include("menu.php");


 $accion=recoge1('accion');
 $tipo=recoge1('tipo');
if ($accion==1) {
 $_SESSION['doc_ventas']=1;
 $_SESSION['doc_ventas1']="RUC";
}
if ($accion==2) {
 $_SESSION['doc_ventas']=2;
 $_SESSION['doc_ventas1']="DNI";
}

if ($accion==3) {
 $_SESSION['doc_ventas']=3;
 $_SESSION['doc_ventas1']="RUC O DNI";
}
if ($accion==8) {
 $_SESSION['doc_ventas']=8;
 $_SESSION['doc_ventas1']="RUC O DNI";
}
if ($accion==5) {
 $_SESSION['doc_ventas']=5;
 $_SESSION['doc_ventas1']="RUC";
}

if ($accion==6) {
 $_SESSION['doc_ventas']=6;
 $_SESSION['doc_ventas1']="RUC";
}


if($tipo==1){
header("location:nueva_factura.php?&id_mesa='".$_GET['id_mesa']."'");
}elseif ($tipo==2){
 header("location:editar_factura.php?id_factura=$id_factura?&id_mesa='".$_GET['id_mesa']."'");   
} else {
	header("location:nueva_compras.php");  
}
?>