<?php

session_start();
sleep(1);
$data = intval($_POST['value']);
$field = $_POST['field'];

if($_SESSION['tienda']==1){
    $field1 ="b1";
}
if($_SESSION['tienda']==2){
    $field1 ="b2";
}
if($_SESSION['tienda']==3){
    $field1 ="b3";
}
if($_SESSION['tienda']==4){
    $field1 ="b4";
}
if($_SESSION['tienda']==5){
    $field1 ="b5";
}
if($_SESSION['tienda']==6){
    $field1 ="b6";
}

if($data>=0){

$conexion = new mysqli('localhost','root','_5V!Q8vTS;C1', 'casaroyales');
$update = "UPDATE `products` SET $field1='".$data."' WHERE id_producto=$field";
$conexion->query($update);
echo $data;
}
?>