<?php
require('lib/pclzip.lib.php'); 
include "__soap.php";
//URL para enviar las solicitudes a SUNAT
$wsdlURL = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
$ruc="10101010124";  //Ruc sol
$usuario_sol="MODDATOS"; //usuario sol
$pass_sol="MODDATOS";    //password sol
$ticket="1540411205083";
$XMLString = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
        <soapenv:Header>
        <wsse:Security>
        <wsse:UsernameToken>
        <wsse:Username>' . $ruc . $usuario_sol . '</wsse:Username>
        <wsse:Password>' . $pass_sol . '</wsse:Password>
        </wsse:UsernameToken>
        </wsse:Security>
        </soapenv:Header>
        <soapenv:Body>
        <ser:getStatus>
        <ticket>' . $ticket . '</ticket>
        </ser:getStatus>
        </soapenv:Body>
        </soapenv:Envelope>';


//Realizamos la llamada a nuestra función
$result = soapCall($wsdlURL, $callFunction = "getStatus", $XMLString);
//echo $result;
$NomArch="prueba";
//$porciones = explode("content>", $result);
$archivo = fopen('C'.$NomArch.'.xml','w+');
fputs($archivo,$result);
fclose($archivo);


/*LEEMOS EL ARCHIVO XML*/
$xml = simplexml_load_file('C'.$NomArch.'.xml'); 
foreach ($xml->xpath('//applicationResponse') as $response){ }

/*AQUI DESCARGAMOS EL ARCHIVO CDR(CONSTANCIA DE RECEPCIÓN)*/
$cdr=base64_decode($response);

//Dirección donde será guardado el cdr  cdr/
$archivo = fopen('cdr/R-'.$NomArch.'.zip','w+');
fputs($archivo,$cdr);
fclose($archivo);
chmod('cdr/R-'.$NomArch.'.zip', 0777);



$archive = new PclZip('cdr/R-'.$NomArch.'.zip');
if ($archive->extract("cdr/")==0) { 
    die("Error : ".$archive->errorInfo(true)); 
}else{
    chmod('cdr/R-'.$NomArch.'.xml', 0777);    
} 

echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-top: 10px;">';
echo 'Su documento electronico ha sido enviado satisfactoriamente.<br>';
echo '<span style="color: #A70202;">Descargar CDR generado:<a href="pdf/documentos/cdr/R-'.$NomArch.'.xml" target="_blank">R-'.$NomArch.'.xml</a>(respuesta de la sunat)</span>';
echo '</div>';

/*Eliminamos los archivos auxiliares creados*/
unlink('C'.$NomArch.'.xml');
unlink($NomArch.'.xml');
unlink($NomArch.'.zip');

/*
if ($archive->extract('homo/')==0) {
    die("Error : ".$archive->errorInfo(true));
}else{
    chmod('homo/'.$nameXml.'.xml', 0777);
}
*/
//Eliminamos el Archivo Response
//unlink('homo/'.'C'.$nameXml.'.xml');

?>