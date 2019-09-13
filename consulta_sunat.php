<?php
$doc = $_POST['doc'];
$data = file_get_contents("http://softjafs.com/api/index.php/sunat/get/".$doc."?fbclid=IwAR0maCwagQrJ3rcaV1pgFASDIAW3eie727r3rmqFewOVykmA8SEjtlWWOSg");
$info = json_decode($data, true);

if($data==='[]' || $info['ultima_actualizacion']==='--'){
	$datos = array(0 => 'nada');
	echo json_encode($datos);
}else{

$datos = array(
	0 => $info['doc'], 
	1 => $info['nombre_o_razon_social'],
	2 => $info['estado_del_contribuyente'],
	3 => $info['condicion_de_domicilio'],
	4 => $info['ubigeo'],
	5 => $info['tipo_de_via'],
	6 => $info['nombre_de_via'],
	7 => $info['codigo_de_zona'],
	8 => $info['numero'],
	9 => $info['interior'],
	10 => $info['lote'],
	11 => $info['dpto'],
	12 => $info['manzana'],
	13 => $info['kilometro'],
	14 => $info['departamento'],
	15 => $info['provincia'],
	16 => $info['distrito'],
	17 => $info['direccion'],
	18 => $info['direccion_completa'],
	19 => date("d/m/Y H:i:s", strtotime($info['ultima_actualizacion']))
);

echo json_encode($datos);

}

?>