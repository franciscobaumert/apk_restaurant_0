<?php
        session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../login.php");
		exit;
        }
	require_once('api_signature/XMLSecurityKey.php');
require_once('api_signature/XMLSecurityDSig.php');
require_once('api_signature/XMLSecEnc.php');
include "__soap.php";
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
        //$doc->save($ruta1 . '.xml');
        //chmod(''.$ruta1.'.xml', 0777);
        $doc->save('resumen/'.$ruta1.'.xml');
        chmod('resumen/'.$ruta1.'.xml', 0777);
        $resp['respuesta'] = 'ok';
        $resp['hash_cpe'] = $hash_cpe;
        return $resp;
    }
}
	if (empty($_POST['fecha'])) {
           $errors[] = "Fecha vacía";
        }  
                else if (
			!empty($_POST['fecha']) 
		){
		
		require_once ("../../config/db.php");
		require_once ("../../config/conexion.php");
        date_default_timezone_set('America/Santiago');        
        $fecha=mysqli_real_escape_string($con,(strip_tags($_POST["fecha"],ENT_QUOTES)));
        $tienda=$_SESSION['tienda'];
	$sql=mysqli_query($con, "select * from  sucursal where tienda='".$tienda."'");
        $row=mysqli_fetch_array($sql);
        
        $sql1=mysqli_query($con, "select * from documento where id_documento=7");
        $row1=mysqli_fetch_array($sql1);
        $doc1=$row1["tienda$tienda"];
        $id1=0;
        $sql3=mysqli_query($con, "select * from resumen_documentos where fecha='$fecha'");
        $row3=mysqli_fetch_array($sql3);
        $id1=$row3["id_resumen"];
        
        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM facturas WHERE ven_com=1 and resumen=0 and estado_factura=2 and DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha'");
	$row4= mysqli_fetch_array($count_query);
	$numrows = $row4['numrows'];
        if($numrows>0){
        //if(($id1==0 or $id1=="") and $numrows>0){
        
        $cabecera["RAZON_SOCIAL_EMPRESA"]=$row["nombre"];
        $cabecera["NRO_DOCUMENTO_EMPRESA"]=$row["ruc"];
        $ruc1=$row["ruc"];
        $cabecera["TIPO_DOCUMENTO_EMPRESA"]=6;
        $cabecera["CODIGO"]="RC";
        $cabecera["SERIE"]=date("Ymd", strtotime($fecha));
        $cabecera["SECUENCIA"]=$doc1;
        //$cabecera["FECHA_DOCUMENTO"]=date('Y-m-d');
        $cabecera["FECHA_DOCUMENTO"]=date("Y-m-d", strtotime($fecha));;
        $cabecera["FECHA_REFERENCIA"]=$fecha;
        $doc4=$cabecera["CODIGO"]."-".$cabecera["SERIE"]."-".$cabecera["SECUENCIA"];
        $ruta="resumen/";
        $i=1;
        $doc = new DOMDocument();
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $doc->encoding = 'ISO-8859-1';
        $xmlCPE = '<?xml version="1.0" encoding="iso-8859-1" standalone="no"?>
        <SummaryDocuments 
        xmlns="urn:sunat:names:specification:ubl:peru:schema:xsd:SummaryDocuments-1" 
        xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" 
        xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" 
        xmlns:ds="http://www.w3.org/2000/09/xmldsig#" 
        xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" 
        xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1"
        xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" 
        xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2">
        <ext:UBLExtensions>
            <ext:UBLExtension>
                            <ext:ExtensionContent>
                </ext:ExtensionContent>
            </ext:UBLExtension>
        </ext:UBLExtensions>
        <cbc:UBLVersionID>2.0</cbc:UBLVersionID>
        <cbc:CustomizationID>1.1</cbc:CustomizationID>
        <cbc:ID>'.$cabecera["CODIGO"].'-'.$cabecera["SERIE"].'-'.$cabecera["SECUENCIA"].'</cbc:ID>
        <cbc:ReferenceDate>'.$cabecera["FECHA_REFERENCIA"].'</cbc:ReferenceDate>
        <cbc:IssueDate>'.$cabecera["FECHA_DOCUMENTO"].'</cbc:IssueDate>
        <cac:Signature>
            <cbc:ID>' . $cabecera["NRO_DOCUMENTO_EMPRESA"] . '</cbc:ID>
            <cac:SignatoryParty>
                <cac:PartyIdentification>
                    <cbc:ID>' . $cabecera["NRO_DOCUMENTO_EMPRESA"] . '</cbc:ID>
                </cac:PartyIdentification>
                <cac:PartyName>
                    <cbc:Name>' . $cabecera["RAZON_SOCIAL_EMPRESA"] . '</cbc:Name>
                </cac:PartyName>
            </cac:SignatoryParty>
            <cac:DigitalSignatureAttachment>
                <cac:ExternalReference>
                    <cbc:URI>' . $cabecera["CODIGO"] . '-' . $cabecera["SERIE"] . '-' . $cabecera["SECUENCIA"] . '</cbc:URI>
                </cac:ExternalReference>
            </cac:DigitalSignatureAttachment>
        </cac:Signature>
        <cac:AccountingSupplierParty>
            <cbc:CustomerAssignedAccountID>' . $cabecera["NRO_DOCUMENTO_EMPRESA"] . '</cbc:CustomerAssignedAccountID>
            <cbc:AdditionalAccountID>' . $cabecera["TIPO_DOCUMENTO_EMPRESA"] . '</cbc:AdditionalAccountID>
            <cac:Party>
                <cac:PartyLegalEntity>
                    <cbc:RegistrationName>' . $cabecera["RAZON_SOCIAL_EMPRESA"] . '</cbc:RegistrationName>
                </cac:PartyLegalEntity>
            </cac:Party>
        </cac:AccountingSupplierParty>';
        $sql2=mysqli_query($con, "select * from facturas,clientes where facturas.id_cliente=clientes.id_cliente and facturas.resumen=0 and facturas.estado_factura=2 and facturas.ven_com=1 and DATE_FORMAT(facturas.fecha_factura, '%Y-%m-%d')='$fecha'");
        while($row2=mysqli_fetch_array($sql2)){
            $id_factura=$row2["id_factura"];
            $cabecera["TIPO_COMPROBANTE"]="03";
            $cabecera["NRO_COMPROBANTE"]=$row2["folio"]."-".$row2["numero_factura"];
            $cabecera["COD_MONEDA"]="PEN";
            $cabecera["EXONERADO"]=0;
            $cabecera["INAFECTO"]=0;
            $cabecera["EXPORTACION"]=0;
            $cabecera["GRATUITAS"]=0;
            $cabecera["MONTO_CARGO_X_ASIG"]=0;
            $cabecera["ISC"]=0;
            $cabecera["OTROS"]=0;
            $cabecera["STATUS"]=1;
            if($row2["doc"]==0){
                $cabecera["NRO_DOCUMENTO"]=$row2["dni"];
                $cabecera["TIPO_DOCUMENTO"]="01";
            }else{
                $cabecera["NRO_DOCUMENTO"]=$row2["doc"];
                $cabecera["TIPO_DOCUMENTO"]="06";
            }
            
            
            $cabecera["TOTAL"]=round($row2["total_venta"],2);
            $cabecera["GRAVADA"]=round($row2["total_venta"]/1.18,2);
            $cabecera["IGV"]=round(0.18*($row2["total_venta"]/1.18),2);
            $xmlCPE = $xmlCPE . '<sac:SummaryDocumentsLine>
            <cbc:LineID>' . $i . '</cbc:LineID>
            <cbc:DocumentTypeCode>' . $cabecera["TIPO_COMPROBANTE"] . '</cbc:DocumentTypeCode>
            <cbc:ID>' . $cabecera["NRO_COMPROBANTE"] . '</cbc:ID>
            <cac:AccountingCustomerParty>
                <cbc:CustomerAssignedAccountID>' . $cabecera["NRO_DOCUMENTO"] . '</cbc:CustomerAssignedAccountID>
                <cbc:AdditionalAccountID>' . $cabecera["TIPO_DOCUMENTO"] . '</cbc:AdditionalAccountID>
            </cac:AccountingCustomerParty>';
                    if ($cabecera["TIPO_COMPROBANTE"]=="07"||$cabecera["TIPO_COMPROBANTE"]=="08"){
             $xmlCPE = $xmlCPE . '<cac:BillingReference>
                <cac:InvoiceDocumentReference>
                    <cbc:ID>' . $cabecera["NRO_COMPROBANTE_REF"] . '</cbc:ID>
                    <cbc:DocumentTypeCode>' . $cabecera["TIPO_COMPROBANTE_REF"] . '</cbc:DocumentTypeCode>
                </cac:InvoiceDocumentReference>
            </cac:BillingReference>';
                    }
            $xmlCPE = $xmlCPE . '<cac:Status>
                <cbc:ConditionCode>' . $cabecera["STATUS"] . '</cbc:ConditionCode>
            </cac:Status>                
            <sac:TotalAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["TOTAL"] . '</sac:TotalAmount>
            
                    <sac:BillingPayment>
                <cbc:PaidAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["GRAVADA"] . '</cbc:PaidAmount>
                <cbc:InstructionID>01</cbc:InstructionID>
            </sac:BillingPayment>';
                    
                    if (intval($cabecera["EXONERADO"]) > 0) {
                    $xmlCPE = $xmlCPE . '<sac:BillingPayment>
                <cbc:PaidAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["EXONERADO"] . '</cbc:PaidAmount>
                <cbc:InstructionID>02</cbc:InstructionID>
            </sac:BillingPayment>';
                    }
                    
                    if (intval($cabecera["INAFECTO"]) > 0) {
                    $xmlCPE = $xmlCPE . '<sac:BillingPayment>
                <cbc:PaidAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["INAFECTO"] . '</cbc:PaidAmount>
                <cbc:InstructionID>03</cbc:InstructionID>
            </sac:BillingPayment>';
                    }
                    
                    if (intval($cabecera["EXPORTACION"]) > 0) {
                    $xmlCPE = $xmlCPE . '<sac:BillingPayment>
                <cbc:PaidAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["EXPORTACION"] . '</cbc:PaidAmount>
                <cbc:InstructionID>04</cbc:InstructionID>
            </sac:BillingPayment>';
                    }
                    
                    if (intval($cabecera["GRATUITAS"]) > 0) {
                    $xmlCPE = $xmlCPE . '<sac:BillingPayment>
                <cbc:PaidAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["GRATUITAS"] . '</cbc:PaidAmount>
                <cbc:InstructionID>05</cbc:InstructionID>
            </sac:BillingPayment>';
                    }
                    
                    if (intval($cabecera["MONTO_CARGO_X_ASIG"]) > 0) {
                        $xmlCPE = $xmlCPE . '<cac:AllowanceCharge>';
                        if ($cabecera["CARGO_X_ASIGNACION"] == 1) {
                            $xmlCPE = $xmlCPE . '<cbc:ChargeIndicator>true</cbc:ChargeIndicator>';
                        }else{
                            $xmlCPE = $xmlCPE . '<cbc:ChargeIndicator>false</cbc:ChargeIndicator>';
                        }
                        $xmlCPE = $xmlCPE . '<cbc:Amount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["MONTO_CARGO_X_ASIG"] . '</cbc:Amount>
                        </cac:AllowanceCharge>';
                    }
                    if(intval($cabecera["ISC"]) > 0){
            $xmlCPE = $xmlCPE . '<cac:TaxTotal>
                <cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["ISC"] . '</cbc:TaxAmount>
                <cac:TaxSubtotal>
                    <cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["ISC"] . '</cbc:TaxAmount>
                    <cac:TaxCategory>
                        <cac:TaxScheme>
                            <cbc:ID>2000</cbc:ID>
                            <cbc:Name>ISC</cbc:Name>
                            <cbc:TaxTypeCode>EXC</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                    </cac:TaxCategory>
                </cac:TaxSubtotal>
            </cac:TaxTotal>';
                    }
                    $xmlCPE = $xmlCPE . '<cac:TaxTotal>
                <cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["IGV"] . '</cbc:TaxAmount>
                <cac:TaxSubtotal>
                    <cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["IGV"] . '</cbc:TaxAmount>
                    <cac:TaxCategory>
                        <cac:TaxScheme>
                            <cbc:ID>1000</cbc:ID>
                            <cbc:Name>IGV</cbc:Name>
                            <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                    </cac:TaxCategory>
                </cac:TaxSubtotal>
            </cac:TaxTotal>';
                    
                    if(intval($cabecera["OTROS"]) > 0){
                    $xmlCPE = $xmlCPE . '<cac:TaxTotal>
                <cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["OTROS"] . '</cbc:TaxAmount>
                <cac:TaxSubtotal>
                    <cbc:TaxAmount currencyID="' . $cabecera["COD_MONEDA"] . '">' . $cabecera["OTROS"] . '</cbc:TaxAmount>
                    <cac:TaxCategory>
                        <cac:TaxScheme>
                            <cbc:ID>9999</cbc:ID>
                            <cbc:Name>OTROS</cbc:Name>
                            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                    </cac:TaxCategory>
                </cac:TaxSubtotal>
            </cac:TaxTotal>';
                    }
        $xmlCPE = $xmlCPE . '</sac:SummaryDocumentsLine>';
         $i=$i+1;
         
         
         $cambio=mysqli_query($con, "UPDATE facturas SET resumen='1' WHERE id_factura='".$id_factura."'");
         
        }
        $xmlCPE = $xmlCPE . '</SummaryDocuments>';
    
        $doc->loadXML($xmlCPE);
        $doc->save("resumen/$ruc1-$doc4.xml");
        $doc5="$ruc1-$doc4";
        $valor1=mysqli_query($con, "UPDATE documento SET tienda$tienda=tienda$tienda+1 WHERE id_documento=7");
        
        $messages[] = "Resumen ha sido ingresado satisfactoriamente.";
        
        
        $rutas = array();
        $rutas['ruta_xml'] = "resumen/$doc5";
//archivo donde esta alojado el certificado digital para beta:

        $rutas['ruta_firma'] = "certificados/beta/firmabeta.pfx";
        $rutas['pass_firma'] = '123456';
        $rutas['ruta_xml1'] = "$doc5";
        $signature = new Signature();
        $flg_firma = "0";
        $resp_firma = $signature->signature_xml($flg_firma, $rutas['ruta_xml'], $rutas['ruta_firma'], $rutas['pass_firma'], $rutas['ruta_xml1']);
        if($resp_firma['respuesta'] == 'error') {
            return $resp_firma;
        } 

        ///ZIP Y ENVIAR---------------------------------------
        require('lib/pclzip.lib.php'); // Librería que comprime archivos en .ZIP
    ## Creación del archivo .ZIP
    $zip = new PclZip($ruta.$doc5.'.zip');
    $zip->create($ruta.$doc5.'.xml',PCLZIP_OPT_REMOVE_ALL_PATH);
    chmod($ruta.$doc5.'.zip', 0777);
    $wsdlURL = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
    //$wsdlURL = "billService.wsdl";
    $XMLString = '<?xml version="1.0" encoding="UTF-8"?>
        <soapenv:Envelope
        xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
         xmlns:ser="http://service.sunat.gob.pe"
         xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
        <soapenv:Header>
        <wsse:Security>
        <wsse:UsernameToken>
        <wsse:Username>'.$ruc1.'MODDATOS</wsse:Username>
        <wsse:Password>MODDATOS</wsse:Password>
        </wsse:UsernameToken>
        </wsse:Security>
        </soapenv:Header>
        <soapenv:Body>
        <ser:sendSummary>
        <fileName>'.$doc5.'.zip</fileName>
        <contentFile>' . base64_encode(file_get_contents($ruta.$doc5.'.zip')) . '</contentFile>
        </ser:sendSummary>
        </soapenv:Body>
        </soapenv:Envelope>';
    //$resul = soapCall($wsdlURL, $callFunction = "sendSummary", $XMLString);
    //echo $resul;


    preg_match_all('/<ticket>(.*?)<\/ticket>/is', soapCall($wsdlURL, $callFunction = "sendSummary", $XMLString), $ticket); $ticket= $ticket[1][0];
    //echo $ticket;

    $XMLString2 = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
        <soapenv:Header>
        <wsse:Security>
        <wsse:UsernameToken>
        <wsse:Username>'.$ruc1.'MODDATOS</wsse:Username>
        <wsse:Password>MODDATOS</wsse:Password>
        </wsse:UsernameToken>
        </wsse:Security>
        </soapenv:Header>
        <soapenv:Body>
        <ser:getStatus>
        <ticket>'.$ticket.'</ticket>
        </ser:getStatus>
        </soapenv:Body>
        </soapenv:Envelope>';
    //echo $XMLString2;

    preg_match_all('/<statusCode>(.*?)<\/statusCode>/is',soapCall($wsdlURL, $callFunction = "getStatus", $XMLString2) , $codigo); $codigo = $codigo[1][0];
    //echo $codigo;

    if($codigo == '0' || $codigo == '0098'){
        
        $insert=mysqli_query($con,"INSERT INTO resumen_documentos VALUES ('','$doc1','$fecha','1','$doc5','$ticket')");
        $messages[]= 'El Resumen existe y fue procesado correctamente Ticket Nro '.$ticket;
        
    }else{
        
        $errors []= 'hubo un error al enviar el resumen intentelo mas tarde';
        
    }
 
        }else{
            
            if($numrows==0){
               $errors []= "No existe ninguna boleta de venta para la fecha ingresada."; 
            }
        }       
	
                }
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>