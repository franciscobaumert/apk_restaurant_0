<?php
session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
		exit;
}
include("../../config/db.php");
include("../../config/conexion.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "validaciondedatos.php";
include "procesarcomprobante.php";
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
            <form method="get" accept-charset="utf-8" action="bajaDocumento1.php?id_factura=<?php echo $id_factura;?>" name="loginform" autocomplete="off" role="form" class="form-signin">
			
                
                Indicar Motivo de Anulacion1:
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

date_default_timezone_set('America/Santiago');


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
        
        $sql_empresa=mysqli_query($con,"select * from datosempresa where id_emp=1");
        $rw_empresa=mysqli_fetch_array($sql_empresa);
        $fac_ele=$rw_empresa['fac_ele'];
        $usuariosol=$rw_empresa['usuariosol'];
        $clavesol=$rw_empresa['clavesol'];
        $clave=$rw_empresa['clave'];
        $sql_factura2=mysqli_query($con,"select * from sucursal where tienda='".$tienda1."'");
        $rw_factura2=mysqli_fetch_array($sql_factura2);
        $ruc_emisor=$rw_factura2['ruc'];
        $tipo_doc_emisor="6";
        $razon_social_emisor=$rw_factura2['nombre'];
        $nombre_comercial_emisor=$rw_factura2['nombre'];
        $ubigeo=$rw_factura2['ubigeo'];
        $direccion_emisor=$rw_factura2['direccion'];
        $departamento=$rw_factura2['dep_suc'];
        $provincia=$rw_factura2['pro_suc'];
        $distrito=$rw_factura2['dis_suc'];
        
        
        $pais="PER";
        $motivo_baja=$_GET['motivo'];  
        $count_query3= mysqli_query($con, "SELECT count(*) AS numrows FROM facturas where fec_eli='$arc1'");       
	$row3= mysqli_fetch_array($count_query3);
	$numrows1=$row3['numrows'];
        $i=$numrows1+1;
        $arc=$ruc_emisor.'-RA-'.date('Ymd').'-'.($i);

$data = array(
	
	//Cabecera del documento
	"codigo"						=> "RA",
	"serie"							=> date('Ymd'),
    "secuencia"             		=> $i,
    "fecha_referencia"             	=> date('Y-m-d'),
	"fecha_baja"            		=> date('Y-m-d'),

	//data de la empresa emisora o contribuyente que entrega el documento electrónico.
    "emisor" => array(
		"ruc"						=> $ruc_emisor,
		"tipo_doc" 					=> "6",
		"nom_comercial" 			=> $razon_social_emisor,
		"razon_social" 				=> $razon_social_emisor,
		"codigo_ubigeo" 			=> $ubigeo,
		"direccion"					=> $direccion_emisor,
		"direccion_departamento" 	=> $departamento,
		"direccion_provincia" 		=> $provincia,
		"direccion_distrito" 		=> $distrito,
		"direccion_codigopais" 		=> "PE",
		"usuariosol"				=> $usuariosol,
		"clavesol"					=> $clavesol
	),

	//items
    "detalle" => array( 
                    array(
                        "ITEM"          	=> "1",
                        "TIPO_COMPROBANTE"  => $tipo_documento,
                        "SERIE"           	=> $folio,
                        "NUMERO"            => $numero_documento,
                        "MOTIVO"          	=> $motivo_baja
                    )
	)
);

function get_array_emisor($data) {
		$data_emisor = $data['emisor'];

		//si estamos ofreciendo un servicio de facturación electrónica, aquí podemos recibir el ruc, y el resto de datos podemos extraerlos desde nuestra base de datos.
		//en este caso, asumimos que todos los datos llegan desde la petición.

		$emisor['ruc'] 						= (isset($data_emisor['ruc'])) ? $data_emisor['ruc'] : '';
		$emisor['tipo_doc'] 				= (isset($data_emisor['tipo_doc'])) ? $data_emisor['tipo_doc'] : '6';
		$emisor['nom_comercial'] 			= (isset($data_emisor['nom_comercial'])) ? $data_emisor['nom_comercial'] : '';
		$emisor['razon_social'] 			= (isset($data_emisor['razon_social'])) ? $data_emisor['razon_social'] : '';
		$emisor['codigo_ubigeo'] 			= (isset($data_emisor['codigo_ubigeo'])) ? $data_emisor['codigo_ubigeo'] : '';
		$emisor['direccion'] 				= (isset($data_emisor['direccion'])) ? $data_emisor['direccion'] : '';
		$emisor['direccion_departamento'] 	= (isset($data_emisor['direccion_departamento'])) ? $data_emisor['direccion_departamento'] : '';
		$emisor['direccion_provincia'] 		= (isset($data_emisor['direccion_provincia'])) ? $data_emisor['direccion_provincia'] : '';
		$emisor['direccion_distrito'] 		= (isset($data_emisor['direccion_distrito'])) ? $data_emisor['direccion_distrito'] : '';
		$emisor['direccion_codigopais'] 	= (isset($data_emisor['direccion_codigopais'])) ? $data_emisor['direccion_codigopais'] : '';
		$emisor['usuariosol'] 				= (isset($data_emisor['usuariosol'])) ? $data_emisor['usuariosol'] : '';
		$emisor['clavesol'] 				= (isset($data_emisor['clavesol'])) ? $data_emisor['clavesol'] : '';

		//Todos los campos anteriores son obligatorios
		//Aquí se pueden generar todas las validaciones que se necesiten.
		//por ejemplo: si ruc está vacio, retornar un error

		return $emisor;
	}
        
        function get_array_cabecera($data, $emisor) {
		$cabecera = array(
			
			'CODIGO' => $data['codigo'],
			'SERIE' => $data['serie'],
			'SECUENCIA' => $data['secuencia'],
			'FECHA_REFERENCIA' => $data['fecha_referencia'],
			'FECHA_BAJA' => $data['fecha_baja'],
			
	        //===============================================
			'NRO_DOCUMENTO_EMPRESA' => $emisor['ruc'],
			'TIPO_DOCUMENTO_EMPRESA' => $emisor['tipo_doc'], //RUC
			'NOMBRE_COMERCIAL_EMPRESA' => $emisor['nom_comercial'],
			'CODIGO_UBIGEO_EMPRESA' => $emisor['codigo_ubigeo'],
	        'DIRECCION_EMPRESA' => $emisor['direccion'],
	        'DEPARTAMENTO_EMPRESA' => $emisor['direccion_departamento'],
	        'PROVINCIA_EMPRESA' => $emisor['direccion_provincia'],
	        'DISTRITO_EMPRESA' => $emisor['direccion_distrito'],
			'CODIGO_PAIS_EMPRESA' => $emisor['direccion_codigopais'],
			'RAZON_SOCIAL_EMPRESA' => $emisor['razon_social'],
			'CONTACTO_EMPRESA' => "",
	        //===================CLAVES SOL EMISOR====================//
	        'EMISOR_RUC' => $emisor['ruc'],
	        'EMISOR_USUARIO_SOL' => $emisor['usuariosol'],
			'EMISOR_PASS_SOL' => $emisor['clavesol']
		);
		
		return $cabecera;
	}

	function get_array_detalle($data) {

		/* la estructura del array con los items debe tener la siguiente estructura!
		"detalle" => [
                    {
                        "txtITEM"          			=> 1,
                        "txtUNIDAD_MEDIDA_DET"      => "NIU",
                        "txtCANTIDAD_DET"           => "1",
                        "txtPRECIO_DET"             => "100",
                        "txtSUB_TOTAL_DET"          => "84.75",
                        "txtPRECIO_TIPO_CODIGO"     => "01",
                        "txtIGV"                 	=> "15.25",
                        "txtISC"                  	=> "0",
                        "txtIMPORTE_DET"            => "84.75",
                        "txtCOD_TIPO_OPERACION"     => "10",
                        "txtCODIGO_DET"             => "DSDFG",
                        "txtDESCRIPCION_DET"   		=> "Producto 01",
                        "txtPRECIO_SIN_IGV_DET"  	=> 84.75
					}
				]
		*/
		
		$detalle_documento = $data['detalle'];
		return $detalle_documento;
	}
        
        $array_emisor = get_array_emisor($data);
	$array_detalle = get_array_detalle($data);
	$array_cabecera = get_array_cabecera($data, $array_emisor);
	$tipodeproceso = (isset($data['tipo_proceso'])) ? $data['tipo_proceso'] : $fac_ele;

	//rutas y nombres de archivos_xml_sunat
	$url_base = '../archivos_xml_sunat/';
        $content_folder_xml = 'cpe_xml/';
	$content_firmas = 'certificados/';
	
	$nombre_archivo = $array_emisor['ruc'] . '-' . $data['codigo'] . '-' . $data['serie'].'-'.$data['secuencia'];

	if ($tipodeproceso == '1') {
        $ruta = "documentos/" . $nombre_archivo;
        $ruta_cdr = "cdrdocumentos/";
        $ruta_firma = $content_firmas . 'produccion/' . $array_emisor['ruc'] . '.pfx';
        $pass_firma = $clave;
        $ruta_ws = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
	}
	
    if ($tipodeproceso == '3') {
		$ruta = "documentos/" . $nombre_archivo;
        $ruta_cdr = "cdrdocumentos/";
        $ruta_firma = $content_firmas.'beta/firmabeta.pfx';
        $pass_firma = '123456';
        $ruta_ws = 'https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService';
	}

	$rutas = array();
    $rutas['nombre_archivo'] = $nombre_archivo;
    $rutas['ruta_xml'] = $ruta;
    $rutas['ruta_cdr'] = $ruta_cdr;
    $rutas['ruta_firma'] = $ruta_firma;
    $rutas['pass_firma'] = $pass_firma;
	$rutas['ruta_ws'] = $ruta_ws;
	
	$procesarcomprobante = new Procesarcomprobante();
	$resp = $procesarcomprobante->procesar_baja_sunat($array_cabecera, $array_detalle, $rutas);
	$resp['ruta_xml'] = 'archivos_xml_sunat/cpe_xml/beta/20100066603/'.$nombre_archivo.'.XML';
	$resp['ruta_cdr'] = 'archivos_xml_sunat/cpe_xml/beta/20100066603/R-'.$nombre_archivo.'.XML';
	$resp['ruta_pdf'] = 'controllers/prueba.php?tipo=factura&id=0';
	$resp['ruta_xml'] = "";
	$resp['url_xml'] = "";
	$resp['ruta_cdr'] = "";
        if($resp['respuesta']=='ok'){
            $ticket=$resp['nro_ticket'];
            $aceptado=$resp['msj_sunat'];
            $hash_cpe=$resp['hash_cpe'];
            $sql_factura1=mysqli_query($con,"update facturas set fec_eli='$arc1', baja='$arc' where id_factura='".$id_factura."'");
            $insert=mysqli_query($con,"INSERT INTO baja_sunat VALUES (NULL,'$id_factura','$i','$arc1','$aceptado','$arc','$ticket','$hash_cpe','')");    
            print"<strong><font color=red size=5>Respuesta de la sunat Documento de baja.</font><br>";
            echo $resp['msj_sunat'];
            $cdr="R-$nombre_archivo";
            print"<br><font color=blue><a target=_blank download=XML-GUIA-REMISION href=$ruta.XML>Descargar XML.</a></font>";
            print"<br><font color=blue><a target=_blank download=CDR-GUIA-REMISION href=$ruta_cdr$cdr.XML>Descargar CDR.</a></font></strong>";
            
        }
//echo json_encode($resp);
	//exit();
	
	

	


    
    
}
?>
