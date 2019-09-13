<?php
session_start();
include("menu.php");

$t=recoge1('t');
$r=recoge1('r');

$a=recoge1('a');
if ($t==0) {
 $_SESSION['tabla']="1";
}
if ($t==1) {
 $_SESSION['tabla']="";
}

if ($t==2) {
 $_SESSION['tabla']="2";
}

header("location:$a");





?>