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
date_default_timezone_set('America/Santiago');        
        $fecha=mysqli_real_escape_string($con,(strip_tags($_POST["fecha"],ENT_QUOTES)));
        $tienda=$_SESSION['tienda'];
	$sql=mysqli_query($con, "select * from  sucursal where tienda='".$tienda."'");
        $row=mysqli_fetch_array($sql);
        
        $sql_empresa=mysqli_query($con,"select * from datosempresa where id_emp=1");
        $rw_empresa=mysqli_fetch_array($sql_empresa);
        $fac_ele=$rw_empresa['fac_ele'];
        $usuariosol=$rw_empresa['usuariosol'];
        $clavesol=$rw_empresa['clavesol'];
        $clave=$rw_empresa['clave'];
        
        $id1=0;
        $sql3=mysqli_query($con, "select * from resumen_documentos where fecha='$fecha'");
        $row3=mysqli_fetch_array($sql3);
        $id1=$row3["id_resumen"];
        
        $count_query1   = mysqli_query($con, "SELECT count(*) AS numrows FROM resumen_documentos WHERE DATE_FORMAT(fecha, '%Y-%m-%d')='$fecha'");
	$row5= mysqli_fetch_array($count_query1);
	$numrows1 = $row5['numrows'];
        $valor=$numrows1+1;
        
        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM facturas WHERE ven_com=1 and resumen=0 and estado_factura=2 and DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha'");
	$row4= mysqli_fetch_array($count_query);
	$numrows = $row4['numrows'];
        if($numrows>0){
 
        $cabecera["RAZON_SOCIAL_EMPRESA"]=$row["nombre"];
        $cabecera["NRO_DOCUMENTO_EMPRESA"]=$row["ruc"];
        $ruc1=$row["ruc"];
        $cabecera["TIPO_DOCUMENTO_EMPRESA"]=6;
        $cabecera["CODIGO"]="RC";
        $cabecera["SERIE"]=date("Ymd", strtotime($fecha));
        $cabecera["SECUENCIA"]=$numrows1+1;
        //$cabecera["FECHA_DOCUMENTO"]=date('Y-m-d');
        $cabecera["FECHA_DOCUMENTO"]=date("Y-m-d", strtotime($fecha));
        $cabecera["FECHA_REFERENCIA"]=$fecha;
        $doc4=$cabecera["CODIGO"]."-".$cabecera["SERIE"]."-".$cabecera["SECUENCIA"];
        $ruta="resumen/";
        $i=1;

        }

$data = array(
	
	//Cabecera del documento
	"codigo"						=> "RC",
	"serie"							=> date("Ymd", strtotime($fecha)),
    "secuencia"             		=>$valor,
    "fecha_referencia"             	=> $fecha,
	"fecha_documento"          		=> date("Y-m-d", strtotime($fecha)),

	//data de la empresa emisora o contribuyente que entrega el documento electrónico.
    "emisor" => array(
		"ruc"						=> $row["ruc"],
		"tipo_doc" 					=> "6",
		"nom_comercial" 			=> $row["nombre"],
		"razon_social" 				=> $row["nombre"],
		"codigo_ubigeo" 			=> $row["ubigeo"],
		"direccion"					=> $row["direccion"],
		"direccion_departamento" 	=> $row["dep_suc"],
		"direccion_provincia" 		=> $row["pro_suc"],
		"direccion_distrito" 		=> $row["dis_suc"],
		"direccion_codigopais" 		=> "PE",
		"usuariosol"				=> $usuariosol,
		"clavesol"					=> $clavesol
	)
);
$i=0;
$sql2=mysqli_query($con, "select * from facturas,clientes where facturas.id_cliente=clientes.id_cliente and facturas.resumen=0 and facturas.estado_factura=2 and facturas.ven_com=1 and DATE_FORMAT(facturas.fecha_factura, '%Y-%m-%d')='$fecha'");
        while($row2=mysqli_fetch_array($sql2)){
            $id_factura=$row2["id_factura"];
            $detalle[$i]["ITEM"]=$i+1;
            $detalle[$i]["TIPO_COMPROBANTE"]="03";
            $detalle[$i]["NRO_COMPROBANTE"]=$row2["folio"]."-".$row2["numero_factura"];
            $detalle[$i]["COD_MONEDA"]="PEN";
            $detalle[$i]["EXONERADO"]=0;
            $detalle[$i]["INAFECTO"]=0;
            $detalle[$i]["EXPORTACION"]=0;
            $detalle[$i]["GRATUITAS"]=0;
            $detalle[$i]["MONTO_CARGO_X_ASIG"]=0;
            $detalle[$i]["ISC"]=0;
            $detalle[$i]["OTROS"]=0;
            if($row2["activo"]==1){
                $detalle[$i]["STATUS"]=1;
            }
            if($row2["activo"]==0){
                $detalle[$i]["STATUS"]=3;
            }
            if($row2["doc"]==0){
                $detalle[$i]["NRO_DOCUMENTO"]=$row2["dni"];
                $detalle[$i]["TIPO_DOCUMENTO"]="01";
            }else{
                $detalle[$i]["NRO_DOCUMENTO"]=$row2["doc"];
                $detalle[$i]["TIPO_DOCUMENTO"]="06";
            }
            $detalle[$i]["TOTAL"]=round($row2["total_venta"],2);
            $detalle[$i]["GRAVADA"]=round($row2["total_venta"]/1.18,2);
            $detalle[$i]["IGV"]=round(0.18*($row2["total_venta"]/1.18),2);
            $i=$i+1;
            $cambio=mysqli_query($con, "UPDATE facturas SET resumen='1' WHERE id_factura='".$id_factura."'");
}
        $array_emisor = get_array_emisor($data);
        if(isset($detalle)){
            $array_detalle = $detalle;
            
        }
	
        if(!isset($detalle)){
            $errors []= 'Ya se envio resumen';
            exit;
        }
        
	$array_cabecera = get_array_cabecera($data, $array_emisor);
	$tipodeproceso = (isset($data['tipo_proceso'])) ? $data['tipo_proceso'] : $fac_ele;

	//rutas y nombres de archivos_xml_sunat
	$url_base = '../archivos_xml_sunat/';
        $content_folder_xml = 'cpe_xml/';
	$content_firmas = 'certificados/';
	
	$nombre_archivo = $array_emisor['ruc'] . '-' . $data['codigo'] . '-' . $data['serie'].'-'.$data['secuencia'];

	if ($tipodeproceso == '1') {
        $ruta ="resumen/" . $nombre_archivo;
        $ruta_cdr = "cdrresumen/";
        $ruta_firma = $content_firmas . 'produccion/' . $array_emisor['ruc'] . '.pfx';
        $pass_firma = $clave;
        $ruta_ws = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
	}
	
    if ($tipodeproceso == '3') {
	$ruta ="resumen/" . $nombre_archivo;
        $ruta_cdr = "cdrresumen/";
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
	$resp = $procesarcomprobante->procesar_resumen_boletas($array_cabecera, $array_detalle, $rutas);
	
	$resp['ruta_xml'] = 'archivos_xml_sunat/cpe_xml/beta/20100066603/'.$nombre_archivo.'.XML';
	$resp['ruta_cdr'] = 'archivos_xml_sunat/cpe_xml/beta/20100066603/R-'.$nombre_archivo.'.XML';
	$resp['ruta_pdf'] = 'controllers/prueba.php?tipo=factura&id=0';
	$resp['ruta_xml'] = "";
	$resp['url_xml'] = "";
	//$resp['ruta_cdr'] = "";
	//echo json_encode($resp);
	$doc5="$ruc1-$doc4";
        if($resp['respuesta']=='ok'){
        $ticket=$resp['nro_ticket'];
        $aceptado=$resp['msj_sunat'];
        $hash_cpe=$resp['hash_cpe'];
        $sql2=mysqli_query($con, "select * from facturas,clientes where facturas.id_cliente=clientes.id_cliente and facturas.resumen=0 and facturas.estado_factura=2 and facturas.ven_com=1 and DATE_FORMAT(facturas.fecha_factura, '%Y-%m-%d')='$fecha'");
        while($row2=mysqli_fetch_array($sql2)){
            $id_factura=$row2["id_factura"];
            //$cambio=mysqli_query($con, "UPDATE facturas SET resumen='1' WHERE id_factura='".$id_factura."'");
        }
        
        $insert=mysqli_query($con,"INSERT INTO resumen_documentos VALUES (NULL,'$valor','$fecha','$aceptado','$doc5','$ticket','$hash_cpe','')");
        $cambio=mysqli_query($con, "UPDATE facturas SET resumen='1' WHERE id_factura='".$id_factura."'");
        $messages[]= "$aceptado  se genero el Ticket Nro ".$ticket;
        }else{
        	$cambio=mysqli_query($con, "UPDATE facturas SET resumen='0' WHERE id_factura='".$id_factura."'");
            $errors []= 'hubo un error al enviar el resumen intentelo mas tarde';
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
	
	function get_array_cabecera($data, $emisor) {
		$cabecera = array(
			
			'CODIGO' 					=> $data['codigo'],
			'SERIE' 					=> $data['serie'],
			'SECUENCIA' 				=> $data['secuencia'],
			'FECHA_REFERENCIA' 			=> $data['fecha_referencia'],
			'FECHA_DOCUMENTO' 			=> $data['fecha_documento'],
			
	        //===============================================
			'NRO_DOCUMENTO_EMPRESA' 	=> $emisor['ruc'],
			'TIPO_DOCUMENTO_EMPRESA' 	=> $emisor['tipo_doc'], //RUC
			'NOMBRE_COMERCIAL_EMPRESA' 	=> $emisor['nom_comercial'],
			'CODIGO_UBIGEO_EMPRESA' 	=> $emisor['codigo_ubigeo'],
	        'DIRECCION_EMPRESA' 		=> $emisor['direccion'],
	        'DEPARTAMENTO_EMPRESA' 		=> $emisor['direccion_departamento'],
	        'PROVINCIA_EMPRESA' 		=> $emisor['direccion_provincia'],
	        'DISTRITO_EMPRESA' 			=> $emisor['direccion_distrito'],
			'CODIGO_PAIS_EMPRESA' 		=> $emisor['direccion_codigopais'],
			'RAZON_SOCIAL_EMPRESA' 		=> $emisor['razon_social'],
			'CONTACTO_EMPRESA' 			=> "",
	        //===================CLAVES SOL EMISOR====================//
	        'EMISOR_RUC' 				=> $emisor['ruc'],
	        'EMISOR_USUARIO_SOL' 		=> $emisor['usuariosol'],
			'EMISOR_PASS_SOL' 			=> $emisor['clavesol']
		);
		
		return $cabecera;
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