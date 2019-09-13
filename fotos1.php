<?php
session_start();
include("menu.php");
$accion=recoge1('accion');
$_SESSION['id_producto']=$accion;
header("location:fotos.php");

?>