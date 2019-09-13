<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
if(is_uploaded_file($_FILES['files']['tmp_name']) && $_FILES['files']['type']<300000) {
    $ruta_destino = "images/";
    $namefinal="usuario".$_SESSION['user'].".jpg"; //linea nueva devuelve la cadena sin espacios al principio o al final
    $uploadfile=$ruta_destino.$namefinal;
    if(move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
        $dml="update users set foto='".$namefinal."' where user_id=".$_SESSION['user'];
       if(!mysqli_query($con,$dml)){
            die("No se pudo actualizar..");
        }else{
            header("location:usuarios.php");
        }
 }
 }
?>



