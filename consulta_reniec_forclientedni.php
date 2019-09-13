<?php
require 'simple_html_dom.php';
error_reporting(E_ALL ^ E_NOTICE);
	
$cedcliente = $_POST['cedcliente'];

//OBTENEMOS EL VALOR
$consulta = file_get_html('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$cedcliente)->plaintext;

//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES

$partes = explode("|", $consulta);


$datos = array(
		0 => $cedcliente, 
		1 => $partes[0], 
		2 => $partes[1],
		3 => $partes[2],
);

echo "$partes[0] $partes[1] $partes[2]|||";

?>
