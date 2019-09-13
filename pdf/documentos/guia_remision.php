<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
include("../../config/db.php");
include("../../config/conexion.php");
//include("funciones.php");
require "phpqrcode/qrlib.php";
require_once('api_signature/XMLSecurityKey.php');
require_once('api_signature/XMLSecurityDSig.php');
require_once('api_signature/XMLSecEnc.php');
class Signature {
    public function signature_xml($flg_firma, $ruta, $ruta_firma, $pass_firma,$ruta1) {
        //flg_firma:
        //          01, 03, 07, 08: Firmar en el nodo uno.
        //          00: Firmar en el Nodo Cero (para comprobantes de Percepción o Retención)
        
        $doc = new DOMDocument();

        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->load($ruta . '.xml');

        $objDSig = new XMLSecurityDSig(FALSE);
        $objDSig->setCanonicalMethod(XMLSecurityDSig::C14N);
        $options['force_uri'] = TRUE;
        $options['id_name'] = 'ID';
        $options['overwrite'] = FALSE;

        $objDSig->addReference($doc, XMLSecurityDSig::SHA1, array('http://www.w3.org/2000/09/xmldsig#enveloped-signature'), $options);
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type' => 'private'));

        $pfx = file_get_contents($ruta_firma);
        $key = array();

        openssl_pkcs12_read($pfx, $key, $pass_firma);
        $objKey->loadKey($key["pkey"]);
        $objDSig->add509Cert($key["cert"], TRUE, FALSE);
        $objDSig->sign($objKey, $doc->documentElement->getElementsByTagName("ExtensionContent")->item($flg_firma));

        $atributo = $doc->getElementsByTagName('Signature')->item(0);
        $atributo->setAttribute('Id', 'SignatureSP');
        
        //===================rescatamos Codigo(HASH_CPE)==================
        $hash_cpe = $doc->getElementsByTagName('DigestValue')->item(0)->nodeValue;
       
        //$doc->save($ruta . '.XML');
        //$doc->save($ruta1 . '.xml');
        //chmod(''.$ruta1.'.xml', 0777);
        $doc->save('guia/'.$ruta1.'.xml');
        chmod('guia/'.$ruta1.'.xml', 0777);
        $resp['respuesta'] = 'ok';
        $resp['hash_cpe'] = $hash_cpe;
        return $resp;
    }
}

function tipo_comp($cadena) {
    $cadena1=substr($cadena, 0, 1);
    if($cadena1=="F"){
        return "01";
    }
    if($cadena1=="B"){
        return "03";
    }
}

$accion=$doc1=$_GET['accion'];
$tienda=$_SESSION['tienda'];
$sql2="select * from sucursal where tienda=$tienda"; 
$rs2=mysqli_query($con,$sql2);
$row2= mysqli_fetch_array($rs2);
$ruc=$row2['ruc'];


$sql="select * from facturas,guia, clientes where facturas.id_factura=guia.id_doc and facturas.id_cliente=clientes.id_cliente and facturas.id_factura=$accion"; 
$rs=mysqli_query($con,$sql);
$row= mysqli_fetch_array($rs);
$numero_factura=$row['numero_factura'];  
$folio=$row['folio'];
$serie=$row['serie'];
$tipo_doc=$row['estado_factura'];
$guia=$row['guia'];

$cabecera["SERIE"]=$row['serie'];
$cabecera["SECUENCIA"]=$row['guia'];
$cabecera["FECHA_DOCUMENTO"]=$row['fecha'];
$cabecera["CODIGO"]="09";
$cabecera["NOTA"]="esta es una nota";
$cabecera["TIPO_DOCUMENTO_EMPRESA"]="06";
$cabecera["NRO_DOCUMENTO_EMPRESA"]=$row2['ruc'];
$cabecera["RAZON_SOCIAL_EMPRESA"]=$row2['nombre'];
$cabecera["TIPO_DOCUMENTO_CLIENTE"]="06";
$cabecera["NRO_DOCUMENTO_CLIENTE"]=$row['doc'];
$cabecera["RAZON_SOCIAL_CLIENTE"]=$row['nombre_cliente'];
$cabecera["CODMOTIVO_TRASLADO"]=$row['CODMOTIVO_TRASLADO'];
$cabecera["MOTIVO_TRASLADO"]=$row['MOTIVO_TRASLADO'];
$cabecera["PESO"]=$row['PESO'];
$cabecera["NUMERO_PAQUETES"]=$row['NUMERO_PAQUETES'];
$cabecera["CODTIPO_TRANSPORTISTA"]=$row['CODTIPO_TRANSPORTISTA'];
$cabecera["TIPO_DOCUMENTO_TRANSPORTE"]="06";
$cabecera["NRO_DOCUMENTO_TRANSPORTE"]=$row['NRO_DOCUMENTO_TRANSPORTE'];
$cabecera["RAZON_SOCIAL_TRANSPORTE"]=$row['RAZON_SOCIAL_TRANSPORTE'];
$cabecera["UBIGEO_DESTINO"]=$row['UBIGEO_DESTINO'];
$cabecera["DIR_DESTINO"]=$row['dom_lleg'];
$cabecera["UBIGEO_PARTIDA"]=$row['UBIGEO_PARTIDA'];
$cabecera["DIR_PARTIDA"]=$row['dir_par'];

$doc = new DOMDocument();
$doc->formatOutput = FALSE;
$doc->preserveWhiteSpace = TRUE;
$doc->encoding = 'ISO-8859-1';
    $xmlCPE = '<?xml version="1.0" encoding="iso-8859-1"?>
    <DespatchAdvice xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:ccts="urn:un:unece:uncefact:documentation:2" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1" xmlns="urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2">
        <ext:UBLExtensions>
            <ext:UBLExtension>
                <ext:ExtensionContent>
                </ext:ExtensionContent>
            </ext:UBLExtension>
        </ext:UBLExtensions>
        <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
        <cbc:CustomizationID>1.0</cbc:CustomizationID>
    <cbc:ID>'.$cabecera["SERIE"].'-'.$cabecera["SECUENCIA"].'</cbc:ID>
    <cbc:IssueDate>'.$cabecera["FECHA_DOCUMENTO"].'</cbc:IssueDate>
    <cbc:DespatchAdviceTypeCode>'.$cabecera["CODIGO"].'</cbc:DespatchAdviceTypeCode>
    <cbc:Note>'.$cabecera["NOTA"].'</cbc:Note>
    
    <cac:DespatchSupplierParty>
            <cbc:CustomerAssignedAccountID schemeID="' . $cabecera["TIPO_DOCUMENTO_EMPRESA"] . '">'.$cabecera["NRO_DOCUMENTO_EMPRESA"].'</cbc:CustomerAssignedAccountID>
            <cac:Party>
                <cac:PartyLegalEntity>
    <cbc:RegistrationName><![CDATA['.$cabecera["RAZON_SOCIAL_EMPRESA"].']]></cbc:RegistrationName>
                </cac:PartyLegalEntity>
            </cac:Party>
        </cac:DespatchSupplierParty>
    
    <cac:DeliveryCustomerParty>
    <cbc:CustomerAssignedAccountID schemeID="' . $cabecera["TIPO_DOCUMENTO_CLIENTE"] . '">'.$cabecera["NRO_DOCUMENTO_CLIENTE"].'</cbc:CustomerAssignedAccountID>
            <cac:Party>
                <cac:PartyLegalEntity>
    <cbc:RegistrationName><![CDATA['.$cabecera["RAZON_SOCIAL_CLIENTE"].']]></cbc:RegistrationName>
                </cac:PartyLegalEntity>
            </cac:Party>
        </cac:DeliveryCustomerParty>
    
    <cac:Shipment>
            <cbc:ID>1</cbc:ID>
            <cbc:HandlingCode>'.$cabecera["CODMOTIVO_TRASLADO"].'</cbc:HandlingCode>
            <cbc:Information>'.$cabecera["MOTIVO_TRASLADO"].'</cbc:Information>
            <cbc:GrossWeightMeasure unitCode="KGM">'.$cabecera["PESO"].'</cbc:GrossWeightMeasure>
    <cbc:TotalTransportHandlingUnitQuantity>'.$cabecera["NUMERO_PAQUETES"].'</cbc:TotalTransportHandlingUnitQuantity>
    
            <cac:ShipmentStage>
                <cbc:TransportModeCode>'.$cabecera["CODTIPO_TRANSPORTISTA"].'</cbc:TransportModeCode>
                <cac:TransitPeriod>
                    <cbc:StartDate>'.$cabecera["FECHA_DOCUMENTO"].'</cbc:StartDate>
                </cac:TransitPeriod>
                <cac:CarrierParty>
                    <cac:PartyIdentification>
    <cbc:ID schemeID="'.$cabecera["TIPO_DOCUMENTO_TRANSPORTE"].'">'.$cabecera["NRO_DOCUMENTO_TRANSPORTE"].'</cbc:ID>
                    </cac:PartyIdentification>
                    <cac:PartyName>
                        <cbc:Name><![CDATA['.$cabecera["RAZON_SOCIAL_TRANSPORTE"].']]></cbc:Name>
                    </cac:PartyName>
                </cac:CarrierParty>
            </cac:ShipmentStage>
            
    <cac:Delivery>
                <cac:DeliveryAddress>
                    <cbc:ID>'.$cabecera["UBIGEO_DESTINO"].'</cbc:ID>
                    <cbc:StreetName>'.$cabecera["DIR_DESTINO"].'</cbc:StreetName>
                </cac:DeliveryAddress>
            </cac:Delivery>
            
    <cac:OriginAddress>
                <cbc:ID>'.$cabecera["UBIGEO_PARTIDA"].'</cbc:ID>
                <cbc:StreetName>'.$cabecera["DIR_PARTIDA"].'</cbc:StreetName>
    </cac:OriginAddress>
        </cac:Shipment>
        
        ';
    $sql4="select * from detalle_factura, products where detalle_factura.id_producto=products.id_producto and detalle_factura.numero_factura=$numero_factura and detalle_factura.tipo_doc=$tipo_doc and detalle_factura.folio='$folio' and detalle_factura.tienda=$tienda and ven_com=1"; 
    $rs4=mysqli_query($con,$sql4);
    //print"$sql4";
    $i=1;
    while($row4= mysqli_fetch_array($rs4)){
    $cabecera["ITEM"]=$i;
    $cabecera["DESCRIPCION"]=$row4['nombre_producto'];
    $cabecera["CODIGO_PRODUCTO"]=$row4['codigo_producto'];
    $cabecera["PESO"]=$row4['cantidad'];
    $xmlCPE = $xmlCPE . '<cac:DespatchLine>
            <cbc:ID>'.$cabecera["ITEM"].'</cbc:ID>
    <cbc:DeliveredQuantity unitCode="NIU">'.$cabecera["PESO"].'</cbc:DeliveredQuantity>
    <cac:OrderLineReference>
    </cac:OrderLineReference>
    
    <cac:Item>
                <cbc:Name><![CDATA['.$cabecera["DESCRIPCION"].']]></cbc:Name>
                <cac:SellersItemIdentification>
                    <cbc:ID>'.$cabecera["CODIGO_PRODUCTO"].'</cbc:ID>
                </cac:SellersItemIdentification>
            </cac:Item>
        </cac:DespatchLine>';
    $i=$i+1;
    }
    $xmlCPE = $xmlCPE . '</DespatchAdvice>';

    $doc->loadXML($xmlCPE);
    $doc->save("guia/$ruc-09-$serie-$guia.xml");
    
    $doc3="$ruc-09-$serie-$guia";
    $rutas = array();
    $rutas['ruta_xml'] = "guia/$doc3";
    $rutas['ruta_firma'] = "certificados/beta/firmabeta.pfx";
    $rutas['pass_firma'] = '123456';
    $rutas['ruta_xml1'] = "$doc3";
    $signature = new Signature();
    $flg_firma = "0";
    $resp_firma = $signature->signature_xml($flg_firma, $rutas['ruta_xml'], $rutas['ruta_firma'], $rutas['pass_firma'], $rutas['ruta_xml1']);
    if($resp_firma['respuesta'] == 'error') {
        return $resp_firma;
    }
    //CODIGO HASH
    $hash=$resp_firma['hash_cpe'];
    //$insert_hash=mysqli_query($con, "UPDATE facturas SET cod_hash='$hash' WHERE id_factura=$id_factura");
    
    require('lib/pclzip.lib.php'); 
//$doc3=$_GET['fac'];
//------------------ENVIAR XML SUNAT-------------------

// NOMBRE DE ARCHIVO A PROCESAR.
$NomArch=$doc3;


## =============================================================================
## Creación del archivo .ZIP
$fichero="guia/$NomArch."."xml";
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
$wsdlURL = 'https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService?wsdl';
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

echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-top: 10px;">';
echo 'Su documento electronico ha sido enviado satisfactoriamente.<br>';
echo '<span style="color: #A70202;">Descargar CDR generado:<a href="pdf/documentos/cdr/R-'.$NomArch.'.xml" target="_blank">R-'.$NomArch.'.xml</a>(respuesta de la sunat)</span>';
echo '</div>';

/*Eliminamos los archivos auxiliares creados*/
unlink('C'.$NomArch.'.xml');
unlink($NomArch.'.xml');
unlink($NomArch.'.zip');
    
?>
