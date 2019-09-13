<?php
session_start();
include("menu.php");
 $accion=recoge1('nota');
 $id_factura=recoge1('doc_mod');


if ($accion==2) {
 $_SESSION['doc_ventas']=2;
 $_SESSION['doc_ventas1']="DNI";
}

if ($accion==1) {
 $_SESSION['doc_ventas']=1;
 $_SESSION['doc_ventas1']="RUC";
}



header("location:cerrar_factura.php?id_factura=$id_factura&id_mesa='".$_GET['id_mesa']."'");

?>