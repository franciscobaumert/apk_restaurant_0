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

function generar_numero_aleatorio($longitud){
	$key = '';
	$pattern = '1234567890';
	$max = strlen($pattern)-1;
	for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
	return $key;
}
$accion=$_GET['accion'];
$tienda=$_SESSION['tienda'];
$sql2="select * from sucursal where tienda=$tienda"; 
$rs2=mysqli_query($con,$sql2);
$row2= mysqli_fetch_array($rs2);
$ruc=$row2['ruc'];
$departamento=$row2['dep_suc'];
$provincia=$row2['pro_suc'];
$distrito=$row2['dis_suc'];

$sql="select * from facturas,guia, clientes where facturas.id_factura=guia.id_doc and facturas.id_cliente=clientes.id_cliente and facturas.id_factura=$accion"; 
$rs=mysqli_query($con,$sql);
$row= mysqli_fetch_array($rs);
$numero_factura=$row['numero_factura'];  
$folio=$row['folio'];
$serie=$row['serie'];
$tipo_doc=$row['estado_factura'];
$guia=$row['guia'];
$id=$row['id'];

$nro_guia=str_pad($guia, 8, "0", STR_PAD_LEFT);

$sql_empresa=mysqli_query($con,"select * from datosempresa where id_emp=1");
        $rw_empresa=mysqli_fetch_array($sql_empresa);
        $fac_ele=$rw_empresa['fac_ele'];
        $usuariosol=$rw_empresa['usuariosol'];
        $clavesol=$rw_empresa['clavesol'];
        $clave=$rw_empresa['clave'];
$data = array(
	
	//Cabecera del documento
    "serie_comprobante"             => $row['serie'],
    "numero_comprobante"            => $nro_guia,
    "fecha_comprobante"             => $row['fecha'],
	"cod_tipo_documento"            => "09",
	"nota"							=> "esta es una nota",
	
	//01 VENTA, 14 VENTA SUJETA A CONFIRMACION DEL COMPRADOR, 02 COMPRA
	//04 TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA, 18 TRASLADO EMISOR ITINERANTE CP
	//08 IMPORTACION, 09 EXPORTACION, 19 TRASLADO A ZONA PRIMARIA, 13 OTROS
	"codmotivo_traslado"			=> $row['CODMOTIVO_TRASLADO'],
	"motivo_traslado"				=> $row['MOTIVO_TRASLADO'],
	"peso"							=> $row['PESO'],
	"numero_paquetes"				=> $row['NUMERO_PAQUETES'],
	"codtipo_transportista"			=> $row['CODTIPO_TRANSPORTISTA'], //01 Transporte público, 02 Transporte privado

	"tipo_documento_transporte"		=> "6", //6: indica RUC: Catálogo 06
	"nro_documento_transporte"		=> $row['NRO_DOCUMENTO_TRANSPORTE'],
	"razon_social_transporte"		=> $row['RAZON_SOCIAL_TRANSPORTE'],
	"ubigeo_destino"				=> $row['UBIGEO_DESTINO'],
	"dir_destino"					=> $row['dom_lleg'],
	"ubigeo_partida"				=> $row['UBIGEO_PARTIDA'],
	"dir_partida"					=> $row['dir_par'],

	//Datos del cliente
    "cliente_numerodocumento"       => $row['doc'],
    "cliente_nombre"                => $row['nombre_cliente'],
    "cliente_tipodocumento"         => "6", //1: DNI

	//data de la empresa emisora o contribuyente que entrega el documento electrónico.
    "emisor" => array(
		"ruc"						=> $row2['ruc'],
		"tipo_doc" 					=> "6",
		"nom_comercial" 			=> $row2['nombre'],
		"razon_social" 				=> $row2['nombre'],
		"codigo_ubigeo" 			=> $row2['ubigeo'],
		"direccion"					=> $row2['direccion'],
		"direccion_departamento" 	=> $departamento,
		"direccion_provincia" 		=> $provincia,
		"direccion_distrito" 		=> $distrito,
		"direccion_codigopais" 		=> "PE",
		"usuariosol"				=> $usuariosol,
		"clavesol"					=> $clavesol
	)
);
    $sql4="select * from detalle_factura, products where detalle_factura.id_producto=products.id_producto and detalle_factura.numero_factura=$numero_factura and detalle_factura.tipo_doc=$tipo_doc and detalle_factura.folio='$folio' and detalle_factura.tienda=$tienda and ven_com=1"; 
    $rs4=mysqli_query($con,$sql4);
    //print"$sql4";
    $i=0;
    while($row4= mysqli_fetch_array($rs4)){
        $detalle[$i]["ITEM"]=$i+1;
        $detalle[$i]["DESCRIPCION"]=$row4['nombre_producto'];
        $detalle[$i]["CODIGO_PRODUCTO"]=$row4['codigo_producto'];
        $detalle[$i]["PESO"]=$row4['cantidad'];
        $detalle[$i]["NUMERO_ORDEN"]=1;
        $i=$i+1;
    }

	$array_emisor = get_array_emisor($data);
	$array_detalle = $detalle;
	$array_cabecera = get_array_cabecera($data, $array_emisor);
	$tipodeproceso = (isset($data['tipo_proceso'])) ? $data['tipo_proceso'] : $fac_ele;

	//rutas y nombres de archivos_xml_sunat
	$url_base = '../archivos_xml_sunat/';
    $content_folder_xml = 'cpe_xml/';
	$content_firmas = 'certificados/';
	
	$nombre_archivo = $array_emisor['ruc'] . '-' . $data['cod_tipo_documento'] . '-' . $data['serie_comprobante'].'-'.$data['numero_comprobante'];

	if ($tipodeproceso == '1') {
        $ruta = "guia/" . $nombre_archivo;
        $ruta_cdr = "cdrguia/";
        $ruta_firma =$content_firmas . 'produccion/' . $array_emisor['ruc'] . '.pfx';
        $pass_firma = $clave;
        $ruta_ws = 'https://e-guiaremision.sunat.gob.pe/ol-ti-itemision-guia-gem/billService';
	}
	
    if ($tipodeproceso == '3') {
		$ruta = "guia/" . $nombre_archivo;
        $ruta_cdr = "cdrguia/";
        $ruta_firma = $content_firmas.'beta/firmabeta.pfx';
        $pass_firma = '123456';
        $ruta_ws = 'https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService';
	}

	$rutas = array();
        $rutas['nombre_archivo'] = $nombre_archivo;
        $rutas['ruta_xml'] = $ruta;
        $rutas['ruta_cdr'] = $ruta_cdr;
        $rutas['ruta_firma'] = $ruta_firma;
        $rutas['pass_firma'] = $pass_firma;
	$rutas['ruta_ws'] = $ruta_ws;
	
	$procesarcomprobante = new Procesarcomprobante();
	$resp = $procesarcomprobante->procesar_guia_de_remision($array_cabecera, $array_detalle, $rutas);
	$resp['ruta_xml'] = 'archivos_xml_sunat/cpe_xml/beta/20100066603/'.$nombre_archivo.'.XML';
	$resp['ruta_cdr'] = 'archivos_xml_sunat/cpe_xml/beta/20100066603/R-'.$nombre_archivo.'.XML';
	$resp['ruta_pdf'] = 'controllers/prueba.php?tipo=factura&id=0';
	$resp['ruta_xml'] = "";
	$resp['url_xml'] = "";
	$resp['ruta_cdr'] = "";
        if($resp['respuesta']=='ok'){
              $cambio1=mysqli_query($con, "UPDATE guia SET hash_cpe='$resp[hash_cpe]',cod_sunat='$resp[cod_sunat]',aceptado_guia='$resp[msj_sunat]',doc_guia='$nombre_archivo' WHERE id=$id");
              print"<strong><font color=red size=5>Respuesta de la sunat de la guia de remision.</font><br>";
              echo $resp['msj_sunat'];
              $cdr="R-$nombre_archivo";
              print"<br><font color=blue><a target=_blank download=XML-GUIA-REMISION href=$ruta.XML>Descargar XML.</a></font>";
              print"<br><font color=blue><a target=_blank download=CDR-GUIA-REMISION href=$ruta_cdr$cdr.XML>Descargar CDR.</a></font></strong>";
        }else{
              $cambio1=mysqli_query($con, "UPDATE guia SET cod_sunat='$resp[cod_sunat]',aceptado_guia='$resp[mensaje]',doc_guia='$nombre_archivo' WHERE id=$id");
               print"<strong><font color=red size=5>Respuesta de la sunat de la guia de remisión.</font><br>Error Nro:";
              echo $resp['mensaje'];
              
        }
        //echo json_encode($resp);
        
	exit();
	
	function get_array_cabecera($data, $emisor) {
		$cabecera = array(
			'SERIE' => $data['serie_comprobante'],
			'SECUENCIA' => $data['numero_comprobante'],
			'FECHA_DOCUMENTO' => $data['fecha_comprobante'],
			'CODIGO' => $data['cod_tipo_documento'],
			'NOTA' => $data['nota'],
			//01 VENTA, 14 VENTA SUJETA A CONFIRMACION DEL COMPRADOR, 02 COMPRA
			//04 TRASLADO ENTRE ESTABLECIMIENTOS DE LA MISMA EMPRESA, 18 TRASLADO EMISOR ITINERANTE CP
			//08 IMPORTACION, 09 EXPORTACION, 19 TRASLADO A ZONA PRIMARIA, 13 OTROS
			'CODMOTIVO_TRASLADO' => $data['codmotivo_traslado'],
			'MOTIVO_TRASLADO' => $data['motivo_traslado'],
			'PESO'	=> $data['peso'],
			'NUMERO_PAQUETES' => $data['numero_paquetes'],
			'CODTIPO_TRANSPORTISTA' => $data['codtipo_transportista'], //01 Transporte público, 02 Transporte privado
			'TIPO_DOCUMENTO_TRANSPORTE' => $data['tipo_documento_transporte'], //6: indica RUC: Catálogo 06
			'NRO_DOCUMENTO_TRANSPORTE' => $data['nro_documento_transporte'],
			'RAZON_SOCIAL_TRANSPORTE' => $data['razon_social_transporte'],
			'UBIGEO_DESTINO' => $data['ubigeo_destino'],
			'DIR_DESTINO' => $data['dir_destino'],
			'UBIGEO_PARTIDA' => $data['ubigeo_partida'],
			'DIR_PARTIDA' => $data['dir_partida'],
			
	        //==================================================
	        'NRO_DOCUMENTO_CLIENTE' => $data['cliente_numerodocumento'],
			'RAZON_SOCIAL_CLIENTE' => $data['cliente_nombre'],
			'TIPO_DOCUMENTO_CLIENTE' => $data['cliente_tipodocumento'],
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
                
		/*la estructura del array con los items debe tener la siguiente estructura!
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
        
        print"valor";
?>

