<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "validaciondedatos.php";
include "procesarcomprobante.php";
date_default_timezone_set('America/Santiago');
function generar_numero_aleatorio($longitud){
    $key = '';
    $pattern = '1234567890';
    $max = strlen($pattern)-1;
    for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
	return $key;
}
$data = array(
	
	//Cabecera del documento
	"codigo"						=> "RA",
	"serie"							=> date('Ymd'),
    "secuencia"             		=> (string)generar_numero_aleatorio(2),
    "fecha_referencia"             	=> date('Y-m-d'),
	"fecha_baja"            		=> date('Y-m-d'),

	//data de la empresa emisora o contribuyente que entrega el documento electrónico.
    "emisor" => array(
		"ruc"						=> "20100066603",
		"tipo_doc" 					=> "6",
		"nom_comercial" 			=> "Tu Empresa SRL",
		"razon_social" 				=> "Tu Empresa SRL",
		"codigo_ubigeo" 			=> "070104",
		"direccion"					=> "Jr. Puno 4654",
		"direccion_departamento" 	=> "LIMA",
		"direccion_provincia" 		=> "LIMA",
		"direccion_distrito" 		=> "LIMA",
		"direccion_codigopais" 		=> "PE",
		"usuariosol"				=> "MODDATOS",
		"clavesol"					=> "moddatos"
	),

	//items
    "detalle" => array( 
                    array(
                        "ITEM"          	=> "1",
                        "TIPO_COMPROBANTE"  => "01",
                        "SERIE"           	=> "F001",
                        "NUMERO"            => "456896",
                        "MOTIVO"          	=> "Error en Factura"
                    )
	)
);
        $array_emisor = get_array_emisor($data);
	$array_detalle = get_array_detalle($data);
	$array_cabecera = get_array_cabecera($data, $array_emisor);
	$tipodeproceso = (isset($data['tipo_proceso'])) ? $data['tipo_proceso'] : "3";

	//rutas y nombres de archivos_xml_sunat
	$url_base = '../archivos_xml_sunat/';
        $content_folder_xml = 'cpe_xml/';
	$content_firmas = 'certificados/';
	
	$nombre_archivo = $array_emisor['ruc'] . '-' . $data['codigo'] . '-' . $data['serie'].'-'.$data['secuencia'];

	if ($tipodeproceso == '1') {
        $ruta = $url_base . $content_folder_xml . 'produccion/' . $array_emisor['ruc'] . "/" . $nombre_archivo;
        $ruta_cdr = $url_base . $content_folder_xml . 'produccion/' . $array_emisor['ruc'] . "/";
        $ruta_firma = $url_base . $content_firmas . 'produccion/' . $array_emisor['ruc'] . '.pfx';
        $ruta_ws = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
	}
	
    if ($tipodeproceso == '3') {
		$ruta = $url_base . $content_folder_xml . 'beta/' . $array_emisor['ruc'] . "/" . $nombre_archivo;
        $ruta_cdr = $url_base . $content_folder_xml . 'beta/' . $array_emisor['ruc'] . "/";
        $ruta_firma = $url_base . $content_firmas.'beta/firmabeta.pfx';
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
	echo json_encode($resp);
	exit();
	
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

?>