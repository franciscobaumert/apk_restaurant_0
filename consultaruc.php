<?php
class cURL
	{
		protected $_useragent = 'Mozilla/5.0 (X11; Fedora; Linux x86_64; rv:53.0) Gecko/20100101 Firefox/53.0';
		protected $_url;
		protected $_followlocation;
		protected $_timeout;
		protected $_httpheaderData = array();
		protected $_httpheader = array('Expect:');
		protected $_maxRedirects;
		protected $_cookieFileLocation;
		protected $_post;
		protected $_postFields;
		protected $_referer ="https://www.google.com/";
 
		protected $_session;
		protected $_webpage;
		protected $_includeHeader;
		protected $_noBody;
		protected $_status;
		protected $_binary;
		protected $_binaryFields;
 
		public    $authentication = false;
		public    $auth_name      = '';
		public    $auth_pass      = '';
 
		public function __construct( $followlocation = true, $timeOut = 30, $maxRedirecs = 4, $binary = false, $includeHeader = false, $noBody = false )
		{
			$this->_followlocation = $followlocation;
			$this->_timeout = $timeOut;
			$this->_maxRedirects = $maxRedirecs;
			$this->_noBody = $noBody;
			$this->_includeHeader = $includeHeader;
			$this->_binary = $binary;
 
			$this->_cookieFileLocation = dirname(__FILE__).'/cookie.txt';
		}
 
		public function useAuth( $use )
		{
			$this->authentication = false;
			if($use == true) $this->authentication = true;
		}
 
		public function setName( $name )
		{
			$this->auth_name = $name;
		}
		public function setPass( $pass )
		{
			$this->auth_pass = $pass;
		}
 
		public function setReferer( $referer )
		{
			$this->_referer = $referer;
		}
 
		public function setHttpHeader( $httpheader=array() )
		{
			$this->_httpheader = array();
			foreach( $httpheader as $i=>$v )
			{
				$this->_httpheaderData[$i]=$v;
			}
			foreach( $this->_httpheaderData as $i=>$v )
			{
				$this->_httpheader[]=$i.":".$v;
			}
		}
 
		public function setCookiFileLocation( $path )
		{
			$this->_cookieFileLocation = $path;
			if ( !file_exists($this->_cookieFileLocation) )
			{
				file_put_contents($this->_cookieFileLocation,"");
			}
		}
 
		public function setPost( $postFields = array() )
		{
			$this->_binary = false;
			$this->_post = true;
			$this->_postFields = http_build_query($postFields);
		}
 
		public function setBinary( $postBinaryFields = "" )
		{
			$this->_post = false;
			$this->_binary = true;
			$this->_binaryFields = $postBinaryFields;
		}
 
		public function setUserAgent( $userAgent )
		{
			$this->_useragent = $userAgent;
		}
 
		public function createCurl( $url = 'nul' )
		{
			if($url != 'nul')
			{
				$this->_url = $url;
			}
 
			$s = curl_init();
			curl_setopt($s,CURLOPT_URL,$this->_url);
			curl_setopt($s,CURLOPT_HTTPHEADER,$this->_httpheader);
			curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout);
			curl_setopt($s,CURLOPT_MAXREDIRS,$this->_maxRedirects);
			curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($s,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
			curl_setopt($s,CURLOPT_COOKIEJAR,$this->_cookieFileLocation);
			curl_setopt($s,CURLOPT_COOKIEFILE,$this->_cookieFileLocation);
 
			if($this->authentication == true)
			{
				curl_setopt($s, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
			}
 
			if($this->_post)
			{
				curl_setopt($s,CURLOPT_POST,true);
				curl_setopt($s,CURLOPT_POSTFIELDS,$this->_postFields);
			}
 
			if($this->_binary)
			{
				curl_setopt($s,CURLOPT_BINARYTRANSFER,true);
				curl_setopt($s,CURLOPT_POSTFIELDS, $this->_binaryFields);
				$this->setHttpHeader( array('Content-Length'=>strlen($this->_binaryFields)) );
			}
 
			if($this->_includeHeader)
			{
				curl_setopt($s,CURLOPT_HEADER,true);
			}
 
			if($this->_noBody)
			{
				curl_setopt($s,CURLOPT_NOBODY,true);
			}
 
			curl_setopt($s,CURLOPT_USERAGENT,$this->_useragent);
			curl_setopt($s,CURLOPT_REFERER,$this->_referer);
			$this->_webpage = curl_exec($s);
			$this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);
			curl_close($s);
		}
 
		public function getHttpStatus()
		{
			return $this->_status;
		}
 
		public function __toString()
		{
			return $this->_webpage;
		}
		// simplificado
		public function send($url, array $post = array() )
		{
			if( count($post)!=0 )
				$this->setPost( $post );
 
			$this->createCurl( $url );
			return $this->_webpage;
		}
		public function sendBinary($url,$binary="")
		{
			if( $binary != "" )
				$this->setBinary( $binary );
			$this->createCurl( $url );
			return $this->_webpage;
		}
	}
?>

<?php


	class Sunat{
		var $cc;  // cUrl
		function __construct()
		{
			$this->cc = new cURL();
		}
		function getNumRand()
		{
			$url="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=random";
			$numRand = $this->cc->send($url);
			return $numRand;
		}
		function getDataRUC( $ruc )
		{
			$numRand = $this->getNumRand();
			
			if($ruc != "" && $numRand!=false)
			{
				$data = array(
					"nroRuc" => $ruc,
					"accion" => "consPorRuc",
					"numRnd" => $numRand
				);
 
				$url = "http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
				$Page = $this->cc->send($url,$data);
 
				//RazonSocial
				$patron='/<input type="hidden" name="desRuc" value="(.*)">/';
				$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
				if(isset($matches[0]))
				{
					$RS = utf8_encode(str_replace('"','', ($matches[0][1])));
					$rtn = trim($RS);
                                        
				}
 
				
				
			}
			
				return $rtn;
			
			return false;
		}
	}



	class Sunat1{
		var $cc;  // cUrl
		function __construct()
		{
			$this->cc = new cURL();
		}
		function getNumRand1()
		{
			$url="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=random";
			$numRand = $this->cc->send($url);
			return $numRand;
		}
		function getDataRUC1( $ruc )
		{
			$numRand = $this->getNumRand1();
			
			if($ruc != "" && $numRand!=false)
			{
				$data = array(
					"nroRuc" => $ruc,
					"accion" => "consPorRuc",
					"numRnd" => $numRand
				);
 
				$url = "http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
				$Page = $this->cc->send($url,$data);
 
				//RazonSocial
				$patron='/<td class="bgn" colspan=1>Tel&eacute;fono\(s\):<\/td>[ ]*-->\r\n<!--\t[ ]*<td class="bg" colspan=1>(.*)<\/td>/';
				$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
				if( isset($matches[0]) )
				{
					$rtn = trim($matches[0][1]);
				}
 
				
				
			}
			
				return $rtn;
			
			
		}
	}
        
        
        class Sunat2{
		var $cc;  // cUrl
		function __construct()
		{
			$this->cc = new cURL();
		}
		function getNumRand2()
		{
			$url="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=random";
			$numRand = $this->cc->send($url);
			return $numRand;
		}
		function getDataRUC2( $ruc )
		{
			$numRand = $this->getNumRand2();
			
			if($ruc != "" && $numRand!=false)
			{
				$data = array(
					"nroRuc" => $ruc,
					"accion" => "consPorRuc",
					"numRnd" => $numRand
				);
 
				$url = "http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
				$Page = $this->cc->send($url,$data);
 
				//RazonSocial
				$busca=array(
					
					"Direccion" 			=> "Direcci&oacute;n del Domicilio Fiscal"
					
				);
				foreach($busca as $i=>$v)
				{
					$patron='/<td class="bgn"[ ]*colspan=1[ ]*>'.$v.':[ ]*<\/td>\r\n[\t]*[ ]+<td class="bg" colspan=[1|3]+>(.*)<\/td>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn = trim(utf8_encode( preg_replace( "[\s+]"," ", ($matches[0][1]) ) ) );
					}
				}
 
				
				
			}
			
				return $rtn;
			
			
		}
	}
        session_start();
include('menu.php');
//include('funciones.php');
include('conexion.php');
        $a1=recoge1('ruc');
    $cliente = new Sunat();
 	//$ruc="20549500553";
    $a2=$cliente->getDataRUC($a1);
    
    $clientes = new Sunat1();
 	//$ruc="20549500553";
    $a3=$clientes->getDataRUC1($a1);
    
    $clientes1 = new Sunat2();
 	//$ruc="20549500553";
    $a4=$clientes1->getDataRUC2($a1);




  
$db_ruc = $db_db.'.ruc';
$db = conectar1();



  $doc="";
    $nombre="";  
    $doc1="";
$sql2="select * from $db_ruc where ruc=$a1";
    $rw2=mysqli_query($db,$sql2);//recuperando el registro
    $rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
    
    $email=$rs2["email"];
    $web=$rs2["web"];
    $rubro=$rs2["rubro"];
    $doc1=$rs2["ruc"];
    
    $doc=$a1;
    $nombre=$a2;
    $telefono=$a3;
    $direccion=$a4;
    
    
    
    
    
    
    
    
    $departamento="";
    $provincia="";
    $distrito="";
    
 if(isset($direccion)) {
     
     $direccion1=$direccion;
     $p1 = explode(" - ", $direccion1);
    //$departamento=$p1[0]; // porción1
    
  $r="";   

$resultado = strpos($direccion1,"LA LIBERTAD -");
 
if($resultado !== FALSE){
    $departamento="LA LIBERTAD";
}
    
$resultado1 = strpos($direccion1,"AMAZONAS -");
 
if($resultado1 !== FALSE){
    $departamento="AMAZONAS";
}

$resultado2 = strpos($direccion1,"ANCASH -");
 
if($resultado2 !== FALSE){
    $departamento="ANCASH";
}

$resultado2 = strpos($direccion1,"APURIMAC -");
 
if($resultado2 !== FALSE){
    $departamento="APURIMAC";
}

$resultado2 = strpos($direccion1,"AYACUCHO -");
 
if($resultado2 !== FALSE){
    $departamento="AYACUCHO";
}
 
$resultado2 = strpos($direccion1,"CAJAMARCA -");
 
if($resultado2 !== FALSE){
    $departamento="CAJAMARCA";
}

$resultado2 = strpos($direccion1,"CALLAO -");
 
if($resultado2 !== FALSE){
    $departamento="CALLAO";
}

$resultado2 = strpos($direccion1,"CUSCO -");
 
if($resultado2 !== FALSE){
    $departamento="CUSCO";
}

$resultado2 = strpos($direccion1,"HUANCAVELICA -");
 
if($resultado2 !== FALSE){
    $departamento="HUANCAVELICA";
}

$resultado2 = strpos($direccion1,"HUANUCO -");
 
if($resultado2 !== FALSE){
    $departamento="HUANUCO";
}

$resultado2 = strpos($direccion1,"ICA -");
 
if($resultado2 !== FALSE){
    $departamento="ICA";
}


$resultado2 = strpos($direccion1,"JUNIN -");
 
if($resultado2 !== FALSE){
    $departamento="JUNIN";
}


$resultado2 = strpos($direccion1,"LAMBAYEQUE -");
 
if($resultado2 !== FALSE){
    $departamento="LAMBAYEQUE";
}

$resultado2 = strpos($direccion1,"LIMA -");
 
if($resultado2 !== FALSE){
    $departamento="LIMA";
}

$resultado2 = strpos($direccion1,"LORETO -");
 
if($resultado2 !== FALSE){
    $departamento="LORETO";
}

$resultado2 = strpos($direccion1,"MADRE DE DIOS -");
 
if($resultado2 !== FALSE){
    $departamento="MADRE DE DIOS";
}

$resultado2 = strpos($direccion1,"MOQUEGUA -");
 
if($resultado2 !== FALSE){
    $departamento="MOQUEGUA";
}

$resultado2 = strpos($direccion1,"PASCO -");
 
if($resultado2 !== FALSE){
    $departamento="PASCO";
}

$resultado2 = strpos($direccion1,"PIURA -");
 
if($resultado2 !== FALSE){
    $departamento="PIURA";
}

$resultado2 = strpos($direccion1,"PUNO -");
 
if($resultado2 !== FALSE){
    $departamento="PUNO";
}


$resultado2 = strpos($direccion1,"SAN MARTIN -");
 
if($resultado2 !== FALSE){
    $departamento="SAN MARTIN";
}

$resultado2 = strpos($direccion1,"TACNA -");
 
if($resultado2 !== FALSE){
    $departamento="TACNA";
}

$resultado2 = strpos($direccion1,"TUMBES -");
 
if($resultado2 !== FALSE){
    $departamento="TUMBES";
}

$resultado2 = strpos($direccion1,"UCAYALI -");
 
if($resultado2 !== FALSE){
    $departamento="UCAYALI";
}
    $provincia=$p1[1];
    $distrito=$p1[2];
 }  
    
if($doc==$doc1)    {
$sql="UPDATE $db_ruc set nombre='$nombre',telefono='$telefono',departamento='$departamento',provincia='$provincia',distrito='$distrito',direccion='$direccion'
   WHERE ruc='$doc'";
$row=mysqli_query($db,$sql);
}
if($doc1=="")    {
 $sql="INSERT INTO $db_ruc values ('','$ruc','$nombre','$direccion','$departamento','$provincia','$distrito','$telefono','','','')";
    
    if (mysqli_query($db,$sql)){
        die("");
    } else{
        die("");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="ruc,<?php echo $doc;?>,<?php echo $nombre;?>">
  <title> 
  
  Consulta Ruc <?php echo $doc;?> <?php echo $nombre;?>
  </title>

 <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">
  <link href="css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">
 <link href="css/select/select2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <script>
  function limpiarFormulario() {
    document.getElementById("guardar_cliente").reset();
    
  }
</script>
<style type="text/css"> 
    .fijo {
	background: #333;
	color: white;
	height: 10px;
	
	width: 100%; /* hacemos que la cabecera ocupe el ancho completo de la página */
	left: 0; /* Posicionamos la cabecera al lado izquierdo */
	top: 0; /* Posicionamos la cabecera pegada arriba */
	position: fixed; /* Hacemos que la cabecera tenga una posición fija */
} 


.textfield10:hover {
                    border:3px solid black; 
}
.textfield10:focus {border:3px solid black;
                    -moz-box-shadow:inset 0 0 5px #FAFAFA;
-webkit-box-shadow:inset 0 0 5px #FAFAFA;
box-shadow:inset 0 0 5px #FAFAFA;
                  background-color:#FAFAFA;  
                  color:black;
}
.textfield10{display: block;  float:left;  background-color:white; width:600px;color:#0489B1;
          padding-left: 5px;
          padding-top: 4px; margin:1.5px;	border: 3px solid #BDBDBD;
}

</style>
  
   


 
<style>
    table tr:nth-child(odd) {background-color: #FBF8EF;}

table tr:nth-child(even) {background-color: #EFFBF5;}
 .valor1 {
              

border-bottom: 2px solid #F5ECCE;

}  

-valor1:hover {
              
background-color: white;
border-bottom: 2px solid #A9E2F3;

} 


</style>


</head>

<body class="nav-md">




   

      

        
       

      
      <!-- /top navigation -->


      <!-- page content -->
      <div class="right_col" role="main">

          <div style="background:#81F79F;"> 
          
          <div class="panel panel-info">
		<div class="panel-heading">
		   
                    <h3><img src="images/sunat.png" width="50" height="30"> Buscar ruc Sunat:</h3>
		</div>        
        </div>  
          
          
          
          
        <div class="modal-body" style="height:450px;overflow-y: scroll;">
                      
                      
                      
            <form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente" action="consultaruc1.php">
		  
                        <div class="form-group">
				<label for="doc" class="col-sm-3 control-label">RUC</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" value="<?php echo $doc;?>" id="doc" name="doc" placeholder="BUSCAR RUC SUNAT" required="">
				</div>
                              
			  </div>
                          
                            
                           
                             
                            
                            
                            
                            <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Razon Social</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control"  value="<?php echo $nombre;?>" id="nombre" name="nombre" placeholder="Razon Social" >
				</div>
			  </div>
                            
                      
                        
                        
                        
			  <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" value="<?php echo $telefono;?>" id="telefono" name="telefono" placeholder="Teléfono" >
				</div>
			  </div>
			  
                <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control"  id="direccion" name="direccion"   maxlength="255" placeholder="Dirección"><?php echo $direccion;?></textarea>
				  
				</div>
			  </div>
                 <div class="form-group">
				<label for="departamento" class="col-sm-3 control-label">Departamento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" value="<?php echo $departamento;?>" id="departamento" name="departamento" placeholder="Departamento">
				  
				</div>
			  </div>
                            
                           <div class="form-group">
				<label for="provincia" class="col-sm-3 control-label">Provincia</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" value="<?php echo $provincia;?>" id="provincia" name="provincia" placeholder="Provincia">
				  
				</div>
			  </div> 
                            
                            
                            
                            <div class="form-group">
				<label for="distrito" class="col-sm-3 control-label">Distrito</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" value="<?php echo $distrito;?>" id="distrito" name="distrito" placeholder="Distrito">
				  
				</div>
			  </div>  
                            
                            
			  
                
                
                
                
                
			  <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Email</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="email" class="form-control" value="<?php echo $email;?>" placeholder="Email">
				  
				</div>
			  </div>
			  
                <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Web</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" value="<?php echo $web;?>" placeholder="Web">
				  
				</div>
			  </div>
                
                <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Rubro</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" value="<?php echo $rubro;?>" placeholder="Rubro">
				  
				</div>
			  </div>
                
                            
			  
                           
			 
			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary" name="ruc1" value="1" id="ruc1">Buscar Ruc Sunat</button> 
		  </div>
		  </form>
          
          
          
           </div>
          </div>
         
     


  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  
  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>


  <!-- Datatables -->
  <script src="js/datatables/js/jquery.dataTables.js"></script>
  <script src="js/datatables/tools/js/dataTables.tableTools.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script>
    $(document).ready(function() {
      $('input.tableflat').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
      });
    });

    var asInitVals = new Array();
    $(document).ready(function() {
      var oTable = $('#example').dataTable({
        "oLanguage": {
          "sSearch": "Search all columns:"
        },
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
          } //disables sorting for column one
        ],
        'iDisplayLength': 12,
        "sPaginationType": "full_numbers",
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
          "sSwfPath": "js/datatables/tools/swf/copy_csv_xls_pdf.swf"
        }
      });
      $("tfoot input").keyup(function() {
        /* Filter on the column based on the index of this element's parent <th> */
        oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
      });
      $("tfoot input").each(function(i) {
        asInitVals[i] = this.value;
      });
      $("tfoot input").focus(function() {
        if (this.className == "search_init") {
          this.className = "";
          this.value = "";
        }
      });
      $("tfoot input").blur(function(i) {
        if (this.value == "") {
          this.className = "search_init";
          this.value = asInitVals[$("tfoot input").index(this)];
        }
      });
    });
  </script>
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script type="text/javascript">
    $(function() {
      'use strict';
      
      var data =[
      <?php
                    for($i = 0;$i<count($producto);$i++){
                ?>
                '<?php echo $producto[$i];?>',
                <?php } ?>];
     
      
      
      var countriesArray = $.map(data, function(value, key) {
        return {
          value: value,
          data: key
        };
      });
      // Initialize autocomplete with custom appendTo:
      $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
      });
    });
  </script>
  
  <script src="js/select/select2.full.js"></script>
  <!-- form validation -->
  
  <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Seleccionar",
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "Con Max Selección límite de 4",
        allowClear: true
      });
    });
  </script>
  
  
  
</body>

</html>




