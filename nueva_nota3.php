<?php
session_start();
include("menu.php");
 $accion=recoge1('nota');
 $id_factura=recoge1('doc_mod');


if ($accion==9) {
 $_SESSION['doc_ventas']=9;
 $_SESSION['doc_ventas1']="RUC";
}

if ($accion==10) {
 $_SESSION['doc_ventas']=10;
 $_SESSION['doc_ventas1']="RUC";
}



header("location:nueva_nota2.php?id_factura=$id_factura");

?>