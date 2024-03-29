<?php	
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");

$title="Documentos Electronicos";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[7]==0){
   header("location:error.php");    
}

?>

<?php include ("header.php"); ?>
<?php

menu1();

?>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      DOCUMENTOS ELECTRONICOS
      <small>
        LISTADO GENERAL
      </small>
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="dashboard.php">
          <i class="fa fa-dashboard"></i> 
          TABLERO
        </a>
      </li>
      <li class="active">
        DOCUMENTOS ELECTRONICOS
      </li>
    </ol>
  </section>
  <!-- ContentH eader End -->
<section class="content">

<div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <div class="btn-group pull-right">
              <a class="btn btn-info" href="disponibilidad.php"><span class="glyphicon glyphicon-plus" ></span> Nueva Venta</a>
            </div>
            <h3 class="box-title">
              LISTA DE DOCUMENTOS ELECTRONICOS
            </h3>
          </div>
          <div class="box-body">
            <form class="form-horizontal" role="form" id="datos_cotizacion" autocomplete="off">
        
            <div class="form-group row">
              
              <div class="col-md-4">
                                                                Buscar Cliente
                <input type="text" autocomplete="off" class="form-control" id="q" placeholder="Nombre del cliente " onkeyup='load(1); this.value=this.value.toUpperCase();'>
              </div>
              <div class="col-md-2">
                                                                Buscar Doc
                <input type="text" autocomplete="off" class="form-control" id="q1" placeholder="Nro doc " onkeyup='load(1); this.value=this.value.toUpperCase();'>
              </div>
              <div class="col-md-3">
                                                                Buscar Fecha
                <input type="date"  class="form-control" id="q2"  onkeyup='load(1);'>
              </div>
              <div class="col-md-3" style="margin-top: 19px;">
                <button type="button" class="btn btn-default" onclick='load(1);'>
                  <span class="glyphicon glyphicon-search" ></span> Realizar Busqueda</button>
                <!--<span id="loader"></span>-->
              </div>
              
            </div>
        
      </form>
            <span id="loader"></span>
            <div id="resultados"></div>
            <div class='outer_div'></div>
          </div>
        </div>
      </div>
    </div>
</section>
</div>

<?php include("footer.php"); ?>

  <script src="assets/js/jquery.scrollTo.min.js"></script>
  <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

  <script src="assets/js/common-scripts.js"></script>

  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>

<script type="text/javascript" src="js/usuarios.js"></script>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="js/facturas2.js"></script>
  
      <script>
       function enviar (id)
		{
			var q= $("#q").val();
			
		$.ajax({
        type: "GET",
        url: "./pdf/documentos/enviar_sunat.php",
        data: "fac="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html('<img src="assets/itsolution24/img/loading2.gif">');
      $('#resultados').addClass('ajax-loader');
		  },
        success: function(datos){
		$("#resultados").html(datos);
    $('#resultados').removeClass('ajax-loader');
		load(1);
		}
			});
		
		}   
          
      </script>    

  </body>
</html>


















