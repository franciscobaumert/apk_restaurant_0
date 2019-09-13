<?php
session_start();
include("menu.php");
 $accion=recoge1('accion');
 $accion2=recoge1('accion2');
 $accion3=recoge1('accion3');
 $accion1=recoge1('accion1');
 if ($accion==1) {
 $_SESSION['servicio']=0;
}
if ($accion==2) {
 $_SESSION['servicio']=1;
}
if ($accion==3) {
 $_SESSION['servicio']=2;
 $_SESSION['entregado']=2;
  $_SESSION['desechado']=2;
  $_SESSION['ser']=5;
}
if ($accion2==1) {
 $_SESSION['entregado']=0;
}
if ($accion2==2) {
 $_SESSION['entregado']=1;
}
if ($accion2==3) {
 $_SESSION['servicio']=2;
 $_SESSION['entregado']=2;
  $_SESSION['desechado']=2;
  $_SESSION['ser']=5;
}
 
if ($accion3==1) {
 $_SESSION['desechado']=0;
}
if ($accion3==2) {
 $_SESSION['desechado']=1;
}
if ($accion3==3) {
 $_SESSION['servicio']=2;
 $_SESSION['entregado']=2;
  $_SESSION['desechado']=2;
  $_SESSION['ser']=5;
}

if ($accion1==1) {
 $_SESSION['ser']=1;
}
if ($accion1==2) {
 $_SESSION['ser']=2;
}
if ($accion1==3) {
 $_SESSION['ser']=3;
}
if ($accion1==4) {
 $_SESSION['ser']=4;
}
if ($accion1==5) {
  $_SESSION['servicio']=2;
 $_SESSION['entregado']=2;
  $_SESSION['desechado']=2;
  $_SESSION['ser']=5;
}
header("location:servicios1.php");
?>