<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$fac_ele=$_POST['fac_ele'];
$usuariosol=$_POST['usuariosol'];
$clavesol=$_POST['clavesol'];
$clave=$_POST['clave'];
$ruc=$_POST['ruc'];
if($fac_ele==3){
    $usuariosol="MODDATOS";
    $clavesol="moddatos";
}

if(is_uploaded_file($_FILES['files']['tmp_name'])) {
    $ruta_destino = "pdf/documentos/certificados/produccion/";
        $namefinal=$ruc.".pfx"; //linea nueva devuelve la cadena sin espacios al principio o al final
        $uploadfile=$ruta_destino.$namefinal;
    if(move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
        $dml="update datosempresa
        set fac_ele='".$fac_ele."',usuariosol='".$usuariosol."',clavesol='".$clavesol."',clave='".$clave."'
        where id_emp=1";
        if(!mysqli_query($con,$dml)){
            die("No se pudo actualizar..");
        }else{
            header("location:conf_electronica.php?mensaje=Configuracion actualizada");
        }
      }
}else{
    $dml="update datosempresa
        set fac_ele='".$fac_ele."',usuariosol='".$usuariosol."',clavesol='".$clavesol."',clave='".$clave."'
        where id_emp=1";
        if(!mysqli_query($con,$dml)){
            die("No se pudo actualizar..");
        }else{
            header("location:conf_electronica.php?mensaje=Configuracion actualizada");
        }
}




?>



