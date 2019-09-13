<?php
//https://api.sunat.cloud/ruc/10403322097
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
$a2=$_POST['tip_doc'];
$doc1=$_POST['doc1'];
$nombre_cliente="";
$sql1="select * from clientes where documento=$doc1";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$nombre_cliente=$rs1["nombre_cliente"];
$direccion_cliente=$rs1["direccion_cliente"];
$telefono_cliente=$rs1["telefono_cliente"];
$email_cliente=$rs1["email_cliente"];

if($nombre_cliente<>""){
    echo "$nombre_cliente|$direccion_cliente|$telefono_cliente|$email_cliente";
}else{
    
if($a2==2){
$a1=$_POST['doc1'];
$data = @file_get_contents("https://api.sunat.cloud/ruc/".$a1);
$info = json_decode($data, true);
$razon_social = str_replace("&","",$info['razon_social']);
$domicilio=$info['domicilio_fiscal'];//echo $porciones[5]; // porción1
echo "$razon_social|$domicilio||";
}

if($a2==1){
    require 'simple_html_dom.php';
    error_reporting(E_ALL ^ E_NOTICE);
	
    $dni = $_POST['doc1'];

//OBTENEMOS EL VALOR
    $consulta = @file_get_contents('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni);

//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES

$partes = explode("|", $consulta);


$datos = array(
		0 => $dni, 
		1 => $partes[0], 
		2 => $partes[1],
		3 => $partes[2],
);

echo "$partes[0] $partes[1] $partes[2]|||";
}
}
?>