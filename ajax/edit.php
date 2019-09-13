<?php
session_start();
include('is_logged.php');
require_once ("../config/db.php");
		require_once ("../config/conexion.php");
//Archivo verifica que el usario que intenta acceder a la URL esta logueado
//$session_id= session_id();
sleep(1);
$data = $_POST['value'];
$field = $_POST['field'];
$porciones = explode("-",$field);
$data1=$porciones[0]; // porción1
$data2=$porciones[1]; // porción2

//$precio = $_POST['precio'];


if($data>=0){

//$conexion = new mysqli('localhost', 'akadeg3r_usuario', 'jocelyn2016', 'akadeg3r_sistema');

    
    //$update = "UPDATE `tmp` SET `'".$data1."'`='".$data."' WHERE id_tmp=$data2";
//$update = "UPDATE `tmp` SET `$data1`='".$data."' WHERE id_tmp=$data2";
$productos1=mysqli_query($con, "UPDATE `tmp` SET `$data1`='".$data."' WHERE id_tmp=$data2");
echo $data;
}
?>

