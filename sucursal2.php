<?php
session_start();
include("menu.php");
$accion=recoge1('accion');
$_SESSION['sucursal']=$accion;
header("location:sucursal1.php");
?>