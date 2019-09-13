<?php
//https://api.sunat.cloud/ruc/10403322097
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
$a2=$_POST['tip_doc'];

if($a2==2){
    

$ruta = "https://ruc.com.pe/api/v1/ruc";
//$token = "54717bd7-6ea9-455d-bc88-32f98aed36e5-bd1e97f0-02d6-4a8b-ba4b-9daf058c0287";
$token = "0bae3a3e-1b43-4437-a99e-c0348ec0809e-f1a3e64d-d894-4be6-8199-4916a221d48c";
$a1=$_POST['doc1'];
$rucaconsultar =$a1;

$data = ("token|" . $token . "|\r\n". "ruc|". $rucaconsultar . "|\r\n");
	
$data_txt = $data;

// Invocamos el servicio a ruc.com.pe
// Ejemplo para TXT
// Cuidado con los saltos de linea
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ruta);
curl_setopt(
	$ch, CURLOPT_HTTPHEADER, array(
	'Content-Type: text/plain',
	)
);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_txt);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$respuesta  = curl_exec($ch);
curl_close($ch);

$leer_respuesta = $respuesta;

// Mostramos la respuesta
// Cuidado con los saltos de linea
//echo "Respuesta de la API:<br>";
//print_r($leer_respuesta);

$pizza  = $leer_respuesta;
$porciones = explode("|", $pizza);
$porciones[5] = str_replace("&","",$porciones[5]);
//echo $porciones[5]; // porción1
echo "$porciones[5]|$porciones[41]";
}

if($a2==1){
    require 'simple_html_dom.php';
    error_reporting(E_ALL ^ E_NOTICE);
	
    $dni = $_POST['doc1'];

//OBTENEMOS EL VALOR
    $consulta = file_get_html('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni)->plaintext;

//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES

$partes = explode("|", $consulta);


$datos = array(
		0 => $dni, 
		1 => $partes[0], 
		2 => $partes[1],
		3 => $partes[2],
);

echo "$partes[0] $partes[1] $partes[2]|";
}
?>