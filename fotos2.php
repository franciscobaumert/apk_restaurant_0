<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$web=$_POST['web'];
$pre_web=$_POST['pre_web'];
$descripcion=$_POST['descripcion'];
$descripcion1=$_POST['descripcion1'];

//if(is_uploaded_file($_FILES['files']['tmp_name']) || is_uploaded_file($_FILES['files1']['tmp_name']) || is_uploaded_file($_FILES['files2']['tmp_name']) || is_uploaded_file($_FILES['files3']['tmp_name']) ) {

if(is_uploaded_file($_FILES['files']['tmp_name']) && $_FILES['files']['type']<300000) {
        
    $ruta_destino = "fotos/";
        $namefinal="1producto".$_SESSION['id_producto'].".jpg"; //linea nueva devuelve la cadena sin espacios al principio o al final
        $uploadfile=$ruta_destino.$namefinal;
        if(move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
        $dml="update products
                  set foto1='".$namefinal."',web='".$web."',pre_web='".$pre_web."',descripcion='".$descripcion."',descripcion1='".$descripcion1."'

               where id_producto=".$_SESSION['id_producto'];
       if(!mysqli_query($con,$dml)){
            die("No se pudo actualizar..");
        }else{
            
            header("location:productos.php");
        }
 }
 }
 
 
 if(is_uploaded_file($_FILES['files1']['tmp_name'])&& $_FILES['files1']['type']<300000) {
$ruta_destino = "fotos/";
        $namefinal="2producto".$_SESSION['id_producto'].".jpg"; //linea nueva devuelve la cadena sin espacios al principio o al final
        $uploadfile=$ruta_destino.$namefinal;
        if(move_uploaded_file($_FILES['files1']['tmp_name'], $uploadfile)) {
        $dml="update products
                  set foto2='".$namefinal."',web='".$web."',pre_web='".$pre_web."',descripcion='".$descripcion."',descripcion1='".$descripcion1."'

               where id_producto=".$_SESSION['id_producto'];
       if(!mysqli_query($con,$dml)){
            die("No se pudo actualizar..");
        }else{
            
            header("location:productos.php");
        }
 }
 }
 

 if(is_uploaded_file($_FILES['files2']['tmp_name'])&& $_FILES['files2']['type']<300000) {
$ruta_destino = "fotos/";
        $namefinal="3producto".$_SESSION['id_producto'].".jpg"; //linea nueva devuelve la cadena sin espacios al principio o al final
        $uploadfile=$ruta_destino.$namefinal;
        if(move_uploaded_file($_FILES['files2']['tmp_name'], $uploadfile)) {
        $dml="update products set foto3='".$namefinal."',web='".$web."',pre_web='".$pre_web."',descripcion='".$descripcion."',descripcion1='".$descripcion1."'

               where id_producto=".$_SESSION['id_producto'];
       if(!mysqli_query($con,$dml)){
            die("No se pudo actualizar..");
        }else{
            
            header("location:productos.php");
        }
 }
 }
  
if(is_uploaded_file($_FILES['files3']['tmp_name'])&& $_FILES['files3']['type']<300000) {
$ruta_destino = "fotos/";
        $namefinal="4producto".$_SESSION['id_producto'].".jpg"; //linea nueva devuelve la cadena sin espacios al principio o al final
        $uploadfile=$ruta_destino.$namefinal;
        if(move_uploaded_file($_FILES['files3']['tmp_name'], $uploadfile)) {
        $dml="update products set foto4='".$namefinal."',web='".$web."',pre_web='".$pre_web."',descripcion='".$descripcion."',descripcion1='".$descripcion1."'
        where id_producto=".$_SESSION['id_producto'];
        if(!mysqli_query($con,$dml)){
            die("No se pudo actualizar..");
        }else{
            
            header("location:productos.php");
        }
 }
 }
 // }else{
        $dml="update products set web='".$web."',pre_web='".$pre_web."',descripcion='".$descripcion."',descripcion1='".$descripcion1."'
        where id_producto=".$_SESSION['id_producto'];
       if(!mysqli_query($con,$dml)){
            die("No se pudo actualizar..");
        }else{
            
            header("location:productos.php");
        }
?>

