<?php
session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
}
include("../../config/db.php");
include("../../config/conexion.php");
$id_factura= intval($_GET['id_factura']);
if(!isset($_GET['motivo'])){
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Motivo de Anulación.</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <!-- CSS  -->
   <link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
 <div class="container">
        <div class="card card-container">
           
            <p id="profile-name" class="profile-name-card"></p>
            <form method="get" accept-charset="utf-8" action="bajaDocumento.php?id_factura=<?php echo $id_factura;?>" name="loginform" autocomplete="off" role="form" class="form-signin">
			
                
                Indicar Motivo de Anulacion:
                <input type="hidden" name="id_factura" id="id_factura" value="<?php echo $id_factura;?>">
                <input class="form-control" placeholder="Motivo" id="motivo" name="motivo" type="text" value="" autocomplete="off" required>
                <button type="submit" class="btn btn-lg btn-success btn-block btn-signin" name="login" id="submit">Enviar</button>
            </form><!-- /form -->
            
        </div><!-- /card-container -->
    </div><!-- /container -->
  </body>
</html>


<?php
}
if(isset($_GET['motivo']) and $_GET['motivo']<>""){
//------------------FIRMA DE XML--------------------------
require_once('api_signature/XMLSecurityKey.php');
require_once('api_signature/XMLSecurityDSig.php');
require_once('api_signature/XMLSecEnc.php');
//funcion para firmar
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
        $doc->save($ruta1 . '.xml');
        chmod(''.$ruta1.'.xml', 0777);
        $doc->save('baja/'.$ruta1.'.xml');
        chmod('baja/'.$ruta1.'.xml', 0777);
        $resp['respuesta'] = 'ok';
        $resp['hash_cpe'] = $hash_cpe;
        return $resp;
    }
}
$id_factura= intval($_GET['id_factura']);  
$arc1=date('Y-m-d');
$sql_count=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
$count=mysqli_num_rows($sql_count);
if ($count==0)
{
	echo "<script>alert('Factura no encontrada')</script>";
	echo "<script>window.close();</script>";
	exit;
}
$tienda1=$_SESSION['tienda'];
$sql_factura=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
$rw_factura=mysqli_fetch_array($sql_factura);
date_default_timezone_set('America/Santiago');
$moneda="PEN";
$folio=$rw_factura['folio'];
$baja=$rw_factura['baja'];
$numero_documento=$rw_factura['numero_factura'];
$fecha_emision=date("Y-m-d", strtotime($rw_factura['fecha_factura']));
//tipo de documento 01 factura   02 boleta
$estado=$rw_factura['estado_factura'];
if($estado==1)
{
$tipo_documento="01";    
}    
if($estado==2)
{
$tipo_documento="03";    
} 
        $sql_factura2=mysqli_query($con,"select * from sucursal where tienda='".$tienda1."'");
        $rw_factura2=mysqli_fetch_array($sql_factura2);
        $ruc_emisor=$rw_factura2['ruc'];
        $tipo_doc_emisor="6";
        $razon_social_emisor=$rw_factura2['nombre'];
        $nombre_comercial_emisor=$rw_factura2['nombre'];
        $direccion_emisor=$rw_factura2['direccion'];;
        $pais="PER";
        $representante_legal="Chamorro Ysca";
        $motivo_baja=$_GET['motivo'];  
        
        $count_query3= mysqli_query($con, "SELECT count(*) AS numrows FROM facturas where baja<>'' and cuenta2='$arc1'");       
	$row3= mysqli_fetch_array($count_query3);
	$numrows1=$row3['numrows'];
        
        $i=$numrows1+1;
        $ruta = 'baja/';
      // 1.- crear documento XML
        $xml = new DomDocument('1.0', 'ISO-8859-1'); $xml->standalone = false; $xml->preserveWhiteSpace = false;
        $Invoice = $xml->createElement('VoidedDocuments'); $Invoice = $xml->appendChild($Invoice);
        $Invoice->setAttribute('xmlns',"urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1");
        $Invoice->setAttribute('xmlns:cac',"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2");
        $Invoice->setAttribute('xmlns:cbc',"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2");
        $Invoice->setAttribute('xmlns:ds',"http://www.w3.org/2000/09/xmldsig#");
        $Invoice->setAttribute('xmlns:ext',"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2");
        $Invoice->setAttribute('xmlns:sac',"urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1");
        $Invoice->setAttribute('xmlns:xsi',"http://www.w3.org/2001/XMLSchema-instance");
        $UBLExtension = $xml->createElement('ext:UBLExtensions'); $UBLExtension = $Invoice->appendChild($UBLExtension);
        $ext = $xml->createElement('ext:UBLExtension'); $ext = $UBLExtension->appendChild($ext);
        $contents = $xml->createElement('ext:ExtensionContent'); $contents = $ext->appendChild($contents);
        $cbc = $xml->createElement('cbc:UBLVersionID', '2.0'); $cbc = $Invoice->appendChild($cbc);
        $cbc = $xml->createElement('cbc:CustomizationID', '1.0'); $cbc = $Invoice->appendChild($cbc);
        $cbc = $xml->createElement('cbc:ID', 'RA-'.date('Ymd').'-'.$i); $cbc = $Invoice->appendChild($cbc);
        $cbc = $xml->createElement('cbc:ReferenceDate', "$fecha_emision"); $cbc = $Invoice->appendChild($cbc);
        $cbc = $xml->createElement('cbc:IssueDate', date('Y-m-d')); $cbc = $Invoice->appendChild($cbc);
        $cac_accounting = $xml->createElement('cac:AccountingSupplierParty'); $cac_accounting = $Invoice->appendChild($cac_accounting);
        $cbc = $xml->createElement('cbc:CustomerAssignedAccountID', "$ruc_emisor"); $cbc = $cac_accounting->appendChild($cbc);
        $cbc = $xml->createElement('cbc:AdditionalAccountID', $tipo_doc_emisor); $cbc = $cac_accounting->appendChild($cbc);
        $cac_party = $xml->createElement('cac:Party'); $cac_party = $cac_accounting->appendChild($cac_party);
        $cac = $xml->createElement('cac:PartyName'); $cac = $cac_party->appendChild($cac);
        $cbc = $xml->createElement('cbc:Name', "$razon_social_emisor"); $cbc = $cac->appendChild($cbc);
        $legal = $xml->createElement('cac:PartyLegalEntity'); $legal = $cac_party->appendChild($legal);
        $cbc = $xml->createElement('cbc:RegistrationName', "$nombre_comercial_emisor"); $cbc = $legal->appendChild($cbc);
        $VoidedDocumentsLine = $xml->createElement('sac:VoidedDocumentsLine'); $VoidedDocumentsLine = $Invoice->appendChild($VoidedDocumentsLine);
        $cbc = $xml->createElement('cbc:LineID','1'); $cbc = $VoidedDocumentsLine->appendChild($cbc);
        $cbc = $xml->createElement('cbc:DocumentTypeCode',$tipo_documento); $cbc = $VoidedDocumentsLine->appendChild($cbc);
        $sac = $xml->createElement('sac:DocumentSerialID',"$folio"); $sac = $VoidedDocumentsLine->appendChild($sac);
        $sac = $xml->createElement('sac:DocumentNumberID',"$numero_documento"); $sac = $VoidedDocumentsLine->appendChild($sac);
        $sac = $xml->createElement('sac:VoidReasonDescription',"$motivo_baja"); $sac = $VoidedDocumentsLine->appendChild($sac);
        $xml->formatOutput = true;
        $strings_xml = $xml->saveXML();
        $xml->save($ruta.''.$ruc_emisor.'-RA-'.date('Ymd').'-'.($i).'.xml');
    // 2.- Firmar documento xml
    // ========================
$doc3=$ruc_emisor.'-RA-'.date('Ymd').'-'.($i);
$rutas = array();
$rutas['ruta_xml'] = "baja/$doc3";
//archivo donde esta alojado el certificado digital para beta:

$rutas['ruta_firma'] = "certificados/beta/firmabeta.pfx";
$rutas['pass_firma'] = '123456';
$rutas['ruta_xml1'] = "$doc3";
$signature = new Signature();
$flg_firma = "0";
$resp_firma = $signature->signature_xml($flg_firma, $rutas['ruta_xml'], $rutas['ruta_firma'], $rutas['pass_firma'], $rutas['ruta_xml1']);
if($resp_firma['respuesta'] == 'error') {
    return $resp_firma;
}    

// 3.- Enviar documento xml y obtener respuesta
// ============================================
require('./lib/pclzip.lib.php'); // Librería que comprime archivos en .ZIP
## Creación del archivo .ZIP
$arc=$ruc_emisor.'-RA-'.date('Ymd').'-'.($i);

$zip = new PclZip($ruta.''.$ruc_emisor.'-RA-'.date('Ymd').'-'.($i).'.zip');
$zip->create($ruta.''.$ruc_emisor.'-RA-'.date('Ymd').'-'.($i).'.xml',PCLZIP_OPT_REMOVE_ALL_PATH);
chmod($ruta.''.$ruc_emisor.'-RA-'.date('Ymd').'-'.($i).'.zip', 0777);   
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
    //echo "REQUEST:\n" . $client->__getFunctions() . "\n";
    $client->__call("$callFunction", array(), array());
    //$request = prettyXml($client->__getLastRequest());
    //echo highlight_string($request, true) . "<br/>\n";
    return $client->__getLastResponse();
}
// URL para enviar las solicitudes a SUNAT
$wsdlURL = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
//Estructura del XML para la conexión
$XMLString = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope 
 xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
 xmlns:ser="http://service.sunat.gob.pe" 
 xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
 <soapenv:Header>
     <wsse:Security>
          <wsse:UsernameToken Id="ABC-123">
             <wsse:Username>'.$ruc_emisor.'MODDATOS</wsse:Username>
             <wsse:Password>MODDATOS</wsse:Password>
         </wsse:UsernameToken>
     </wsse:Security>
 </soapenv:Header>
 <soapenv:Body>
     <ser:sendSummary>
        <fileName>'.''.$ruc_emisor.'-RA-'.date('Ymd').'-'.($i).'.zip</fileName>
        <contentFile>' . base64_encode(file_get_contents($ruta.''.$ruc_emisor.'-RA-'.date('Ymd').'-'.($i).'.zip')) . '</contentFile>
     </ser:sendSummary>
 </soapenv:Body>
</soapenv:Envelope>
';
//Realizamos la llamada a nuestra función
$result = soapCall($wsdlURL, $callFunction = "sendSummary", $XMLString);
// Actualiza documento
$sql_factura1=mysqli_query($con,"update facturas set cuenta2='$arc1', baja='$arc' where id_factura='".$id_factura."'");
echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16pt; color: #000000; margin-bottom: 10px;">';
echo 'SUNAT. Facturacion electronica Peru.<br>';
echo '<span style="color: #6A0888; font-size: 15pt;">';
echo 'Documento de Baja.';
echo '</span>';
echo '<div style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12pt; color: #000099; margin-top: 10px;">';
echo 'La factura '.$folio.'-'.$numero_documento.' ha sido dado de baja. Cerrar esta ventana.';
echo '</div>';
}
?>
