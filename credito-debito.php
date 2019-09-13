<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Credito - Debito";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo

$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[29]==0){
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
      NOTA CREDITO - DEBITO
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
        NOTA CREDITO - DEBITO
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
              <div class="dropdown btn btn-info">
                        <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="glyphicon glyphicon-plus" ></span> Nueva Nota</div>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="nueva_nota.php"><i class="fa fa-plus"></i> Factura</a></li>
                <li><a href="nueva_nota2.php"><i class="fa fa-plus"></i> Boleta</a></li>

                            </ul>
                </div>
            </div>
            <h3 class="box-title">
              LISTA DE NOTA CREDITO - DEBITO
            </h3>
          </div>
          <div class="box-body">
            <form class="form-horizontal" role="form" id="datos_cotizacion" autocomplete="off">
        
            <div class="form-group row">
              
              <div class="col-md-4">
                                                                Buscar Cliente
                <input type="text" autocomplete="off" class="form-control" id="q" placeholder="Nombre del cliente " onkeyup='load(1);this.value=this.value.toUpperCase();'>
              </div>
              <div class="col-md-2">
                                                                Buscar Doc
                <input type="text" autocomplete="off" class="form-control" id="q1" placeholder="Nro doc " onkeyup='load(1);this.value=this.value.toUpperCase();'>
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
<script type="text/javascript" src="js/creditodebito.js"></script>

  </body>
</html>


















