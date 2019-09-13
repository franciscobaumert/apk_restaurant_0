<?php

$url = 'http://www.sunat.gob.pe/w/wapS01Alias?ruc='.$_POST["txtruc"];
error_reporting(0);
if (@file_get_contents($url)) {
    $options = array('http' => array('header' => 'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.9.0.6) Gecko/2009011913 Firefox/3.0.6' . PHP_EOL));
    $context = stream_context_create($options);
    $xml = @file_get_contents($url, false, $context);
    $doc = new DOMDocument();
    $doc->loadHTML($xml);
    $nodes = $doc->getElementsByTagName('small');
    $ruc = strval($nodes->item(0)->nodeValue);
    $estado = strval($nodes->item(3)->nodeValue);
    $dir = strval($nodes->item(6)->nodeValue);
    
    $array[0] = $ruc;
    $i = explode('-', $array[0]);
    $razon = $i[1];
    $cadena1 = trim(substr($ruc = $i[0], 13));
    $cadena2 = $razon = $i[1];
    $cadena3 = substr($array[2] = $estado, 7);
    $cadena4 = $array[3] = $dir;
    
    echo "RUC: ".$cadena1."<br>";
    echo "RAZON SOCIAL: ".$cadena2."<br>";
    echo "ESTADO: ".$cadena3."<br>";
    echo "DIRECCION: ".substr($cadena4,11);
}

