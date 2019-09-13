<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
$nom_emp=$_POST['nom_emp'];
$des_emp=$_POST['des_emp'];
$mis_emp=$_POST['mis_emp'];
$vis_emp=$_POST['vis_emp'];
$dir_emp=$_POST['dir_emp'];
$tel_emp=$_POST['tel_emp'];
$email_emp=$_POST['email_emp'];
$face_emp=$_POST['face_emp'];
$tiwter_emp=$_POST['tiwter_emp'];
$youtube_emp=$_POST['youtube_emp'];
$linkedin_emp=$_POST['linkedin_emp'];
$comentario1=$_POST['comentario1'];
$comentario2=$_POST['comentario2'];
$comentario3=$_POST['comentario3'];
$comentario4=$_POST['comentario4'];
$comentario5=$_POST['comentario5'];


  $dml="update datosempresa
set nom_emp='".$nom_emp."',des_emp='".$des_emp."',mis_emp='".$mis_emp."',vis_emp='".$vis_emp."'
,dir_emp='".$dir_emp."',tel_emp='".$tel_emp."',linkedin_emp='".$linkedin_emp."',email_emp='".$email_emp."',face_emp='".$face_emp."',tiwter_emp='".$tiwter_emp."',youtube_emp='".$youtube_emp."',comentario1='".$comentario1."',comentario2='".$comentario2."',comentario3='".$comentario3."',comentario4='".$comentario4."',comentario5='".$comentario5."'
where id_emp=1";
if(!mysqli_query($con,$dml)){
    die("No se pudo actualizar..");
}else{
    header("location:empresa.php?mensaje=Datos actualizados");
}

?>



