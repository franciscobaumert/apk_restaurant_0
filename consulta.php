<?php
//Implemetnacion de TEST del webservice
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('lib/nusoap.php');
$wsdl="http://ws.insite.pe/reniec/dni.php?wsdl";
$client=new nusoap_client($wsdl, true);
$param=array('dni'      => '41321131',
             'username' => 'usuario@dominio.com',
             'license'  => 'XXX-XXX-XXX-XXX',
             'format'   => 'plain');
$dni = $client->call('consultaDNI',$param);
header("Content-Type:text/html");
// hacemos la impresion de informacion
echo "<pre>$dni</pre>";
?>

