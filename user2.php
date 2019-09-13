<?php
session_start();
include("menu.php");
$accion=recoge1('accion');
$_SESSION['user']=$accion;
header("location:user1.php");
?>