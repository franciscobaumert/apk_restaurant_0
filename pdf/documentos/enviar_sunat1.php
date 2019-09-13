<?php
session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
}
include("../../config/db.php");
include("../../config/conexion.php");
require('lib/pclzip.lib.php'); 
include("funciones.php");
$doc3="20602359647-01-F001-100";


$tienda=$_SESSION['tienda'];
$dato=$doc3;
$porciones = explode("-", $dato);
//$doc2="$ruc1-$tip-$folio-$numero_factura";
$ruc1=$porciones[0]; 
$tip=$porciones[1]; 
if($tip=="01"){

$estado_factura=1;
}
if($tip=="03"){

$estado_factura=2;
}
if($tip=="07"){

$estado_factura=6;
}
if($tip=="08"){

$estado_factura=5;
}


$folio=$porciones[2]; 
$numero_factura=$porciones[3]; 
//------------------ENVIAR XML SUNAT-------------------
// NOMBRE DE ARCHIVO A PROCESAR.
$NomArch=$doc3;
## =============================================================================
## Creación del archivo .ZIP
$fichero="factura-firmada/$NomArch."."xml";
$nuevo_fichero="$NomArch."."xml";

copy($fichero, $nuevo_fichero);

$zip = new PclZip($NomArch.".zip");
$zip->create($NomArch.".xml");
chmod($NomArch.".zip", 0777);




# ==============================================================================
# Procedimiento para enviar comprobante a la SUNAT
class feedSoap extends SoapClient{

    public $XMLStr = "";

    public function setXMLStr($value)
    {
        $this->XMLStr = $value;
    }

    public function getXMLStr()
    {
        return $this->XMLStr;
    }

    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {
        $request = $this->XMLStr;

        $dom = new DOMDocument('1.0');

        try
        {
            $dom->loadXML($request);
        } catch (DOMException $e) {
            die($e->code);
        }

        $request = $dom->saveXML();

        //Solicitud
        return parent::__doRequest($request, $location, $action, $version, $one_way = 0);
    }

    public function SoapClientCall($SOAPXML)
    {
        return $this->setXMLStr($SOAPXML);
    }
}


function soapCall($wsdlURL, $callFunction = "", $XMLString)
{
    $client = new feedSoap($wsdlURL, array('trace' => true));
    $reply  = $client->SoapClientCall($XMLString);
    $client->__call("$callFunction", array(), array());
    return $client->__getLastResponse();
}

//URL para enviar las solicitudes a SUNAT
//DIRECCION DE PRUEBA
$wsdlURL = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
//DIRECCION DE PRODUCCION
//$wsdlURL = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';



//Poner ruc ,username y password
$ruc="20550250889";  //Ruc sol
$usuario_sol="MODDATOS"; //usuario sol
$pass_sol="MODDATOS";    //password sol    
//Estructura del XML para la conexión

$XMLString = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
 <soapenv:Header>
     <wsse:Security>
         <wsse:UsernameToken Id="ABC-123">
             <wsse:Username>' . $ruc . $usuario_sol . '</wsse:Username>
             <wsse:Password>' . $pass_sol . '</wsse:Password>
         </wsse:UsernameToken>
     </wsse:Security>
 </soapenv:Header>
 <soapenv:Body>
     <ser:sendBill>
        <fileName>'.$NomArch.'.zip</fileName>
        <contentFile>' . base64_encode(file_get_contents($NomArch.'.zip')) . '</contentFile>
     </ser:sendBill>
 </soapenv:Body>
</soapenv:Envelope>';

//Realizamos la llamada a nuestra función
$result = soapCall($wsdlURL, $callFunction = "sendBill", $XMLString);
//Descargamos el Archivo Response
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
$sql_factura1=mysqli_query($con,"update facturas set aceptado='aceptada' where numero_factura='".$numero_factura."' and folio='".$folio."' and estado_factura='".$estado_factura."' and tienda='".$tienda."'");
echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-top: 10px;">';
echo 'Su documento electronico ha sido enviado satisfactoriamente.<br>';
echo '<span style="color: #A70202;">Descargar CDR generado:<a href="pdf/documentos/cdr/R-'.$NomArch.'.xml" target="_blank">R-'.$NomArch.'.xml</a>(respuesta de la sunat)</span>';
echo '</div>';

/*Eliminamos los archivos auxiliares creados*/
unlink('C'.$NomArch.'.xml');
unlink($NomArch.'.xml');
unlink($NomArch.'.zip');


