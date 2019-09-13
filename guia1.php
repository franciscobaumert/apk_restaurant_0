<?php
session_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
include('menu.php');
$tienda1=$_SESSION['tienda'];
$id_guia=recoge1('id_guia'); 
$dir_par=$_POST['dir_par']; 
$fecha=recoge1('fecha'); 
$guia=recoge1('guia');  
$dom_lleg=recoge1('dom_lleg');  
$cont_lleg=recoge1('cont_lleg'); 
$tel_lleg=recoge1('tel_lleg'); 
$hor_lleg=recoge1('hor_lleg'); 
$vehiculo=recoge1('vehiculo');
$serie=recoge1('serie');
$inscripcion=recoge1('inscripcion');
$motivo=recoge1('motivo');
$motivo1 = explode("-", $motivo);
$CODMOTIVO_TRASLADO=$motivo1[0];
$MOTIVO_TRASLADO=$motivo1[1];


$PESO=recoge1('PESO');
$NUMERO_PAQUETES=recoge1('NUMERO_PAQUETES');
recoge1('NUMERO_PAQUETES');
$UBIGEO_PARTIDA=recoge1('UBIGEO_PARTIDA');
$UBIGEO_DESTINO=recoge1('UBIGEO_DESTINO');
$NRO_DOCUMENTO_TRANSPORTE=recoge1('NRO_DOCUMENTO_TRANSPORTE');
$RAZON_SOCIAL_TRANSPORTE=recoge1('RAZON_SOCIAL_TRANSPORTE');
$CODTIPO_TRANSPORTISTA=recoge1('CODTIPO_TRANSPORTISTA');
$lic=recoge1('lic'); 
$dml="update guia set serie='$serie',guia='$guia',dir_par='$dir_par',dom_lleg='$dom_lleg',cont_lleg='$cont_lleg',tel_lleg='$tel_lleg',fecha_lleg='$hor_lleg',vehiculo='$vehiculo',inscripcion='$inscripcion',lic='$lic',fecha='$fecha'
,CODMOTIVO_TRASLADO='$CODMOTIVO_TRASLADO',MOTIVO_TRASLADO='$MOTIVO_TRASLADO',PESO='$PESO',NUMERO_PAQUETES='$NUMERO_PAQUETES',UBIGEO_PARTIDA='$UBIGEO_PARTIDA',UBIGEO_DESTINO='$UBIGEO_DESTINO',NRO_DOCUMENTO_TRANSPORTE='$NRO_DOCUMENTO_TRANSPORTE',RAZON_SOCIAL_TRANSPORTE='$RAZON_SOCIAL_TRANSPORTE',CODTIPO_TRANSPORTISTA='$CODTIPO_TRANSPORTISTA' where id_doc=".$id_guia;
if(!mysqli_query($con,$dml)){
    die("No se pudo actualizar..");
}else{
    header("location:guia.php?accion=$id_guia");
}

$dml="update documento set tienda$tienda1=tienda$tienda1+1 where id_documento=4";
if(!mysqli_query($con,$dml)){
    die("No se pudo actualizar..");
}else{
    header("location:guia.php?accion=$id_guia");
}
header("location:guia.php?accion=$id_guia");

?>