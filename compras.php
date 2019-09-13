<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Compras";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[34]==0){
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
      COMPRAS
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
        COMPRAS
      </li>
    </ol>
  </section>
  <!-- ContentH eader End -->
<section class="content">

<?php
include("modal/registro_categorias.php");
include("modal/editar_categorias.php");
?>

<div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <div class="btn-group pull-right">
              <a href="nueva_compras.php" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nueva Compra</a>
            </div>
            <h3 class="box-title">
              LISTA DE COMPRAS
            </h3>
          </div>
          <div class="box-body">
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
	

  <script>
    
    $(document).ready(function(){
      load(1);
      
    });

    function load(page){
      var q= $("#q").val();
      $("#loader").fadeIn('slow');
      $.ajax({
        url:'./ajax/buscar_compras.php?action=ajax',
         beforeSend: function(objeto){
         $('#loader').html('<img src="assets/itsolution24/img/loading2.gif">');
         $('#loader').addClass('ajax-loader');
        },
        success:function(data){
          $(".outer_div").html(data).fadeIn('slow');
          $('#loader').html('');
          $('#loader').removeClass('ajax-loader');
          
        }
      })
    }

  
    
      function eliminar (id)
    {
      var q= $("#q").val();
    if (confirm("Realmente deseas eliminar la compra")){  
    $.ajax({
        type: "GET",
        url: "./ajax/buscar_compras.php",
        data: "id="+id,"q":q,
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
    }
    
    function imprimir_factura(id_factura){
      VentanaCentrada('./pdf/documentos/ver_factura1.php?id_factura='+id_factura,'Factura','','1024','768','true');
    }


  </script>

<script type="text/javascript">
    
    $('#compras1').addClass("treeview active");
    $('#compras').addClass("active");

</script>

</body>

</html>














