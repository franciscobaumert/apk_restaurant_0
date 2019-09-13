<?php
session_start();
include("menu.php");
 $accion=recoge1('nota');
 $id_factura=recoge1('doc_mod');


if ($accion==5) {
 $_SESSION['doc_ventas']=5;
 $_SESSION['doc_ventas1']="RUC";
}

if ($accion==6) {
 $_SESSION['doc_ventas']=6;
 $_SESSION['doc_ventas1']="RUC";
}



header("location:nueva_nota.php?id_factura=$id_factura");

?>