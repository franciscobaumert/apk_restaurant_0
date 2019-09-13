<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Resumen Boletas";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo

$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[6]==0){
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
      RESUMEN DIARIO
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
        RESUMEN DIARIO
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
              <button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoResumen"><span class="glyphicon glyphicon-plus" ></span> Nuevo Resumen</button>
            </div>
            <h3 class="box-title">
              LISTA DE RESUMEN DIARIO
            </h3>
          </div>
          <?php include("pdf/documentos/resumen_documentos.php"); ?>
          <div class="box-body">
            <form class="form-horizontal" role="form" id="datos_cotizacion" autocomplete="off">
        
            <div class="form-group row">
              <label for="q" class="col-md-2 control-label">Buscar fecha </label>
              <div class="col-md-5">
                <input type="date" class="form-control" id="q" placeholder="Nombre del cliente o # de doc " onkeyup='load(1);this.value=this.value.toUpperCase();'>
              </div>
              
              
              
              <div class="col-md-3">
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
<script type="text/javascript" src="js/facturas3.js"></script>
<script>
     $(document).ready(function(){
			load1(1);
		});
function load1(page){
			var q= $("#fecha").val();
			$("#loader1").fadeIn('slow');
			$.ajax({
				url:'./ajax/resumen.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader1').html('<img src="assets/itsolution24/img/loading2.gif">');
         $('#loader1').addClass('ajax-loader');
			  },
				success:function(data){
					$(".outer_div1").html(data).fadeIn('slow');
					$('#loader1').html('');
          $('#loader1').removeClass('ajax-loader');
					
				}
			})
		}

</script>
  </body>
</html>


















