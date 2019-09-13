<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");

$title="Productos";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$sql2="select * from datosempresa where id_emp=1";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$alerta=$rs2["alerta"];
$precio2=$rs2["precio2"];
$precio3=$rs2["precio3"];
$consulta1 = "SELECT * FROM products ";
$result1 = mysqli_query($con, $consulta1);
$producto = array();
$i=0;
while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    
    $producto[$i]=$valor1['nombre_producto'];
    $i=$i+1;
    
}   
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[11]==0){
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
      PRODUCTOS
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
        PRODUCTOS
      </li>
    </ol>
  </section>
  <!-- ContentH eader End -->
<section class="content">

<?php
include("modal/registro_productos.php");
include("modal/editar_productos.php");
?>

<div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <div class="btn-group pull-right">
              <button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus" ></span> Nuevo Producto</button>
            </div>
            <h3 class="box-title">
              LISTA DE PRODUCTOS
            </h3>
          </div>
          <div class="box-body">
        <span id="loader"></span>
        <div id="resultados"></div><!-- Carga los datos ajax -->
        <div class='outer_div'></div><!-- Carga los datos ajax -->
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
<script>

$(document).ready(function(){
      load(1);
    });

    function load(page){
      var q= $("#q").val();
      $("#loader").fadeIn('slow');
      $.ajax({
        url:'./ajax/buscar_productos.php?action=ajax',
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
    if (confirm("Realmente deseas eliminar el producto")){  
    $.ajax({
        type: "GET",
        url: "./ajax/buscar_productos.php",
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


$( "#guardar_producto" ).submit(function( event ) {
$('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_producto.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax_productos").html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
			success: function(datos){
			$("#resultados_ajax_productos").html(datos);
      $('#guardar_datos').html('Guardar datos');
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_producto" ).submit(function( event ) {
$('#actualizar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_producto.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax2").html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
      $('#actualizar_datos').html('Actualizar datos');
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
			var codigo_producto = $("#codigo_producto"+id).val();
			var nombre_producto = $("#nombre_producto"+id).val();
			
			var precio_producto = $("#precio_producto"+id).val();
                        var costo_producto = $("#costo_producto"+id).val();
                        var status = $("#status"+id).val();
                         var monventa = $("#mon_venta"+id).val();   
                        var moncosto = $("#mon_costo"+id).val();
                        var cat_pro = $("#cat"+id).val();
                        var inv = $("#inv"+id).val();
                        var marca = $("#marca"+id).val();
                       var modelo = $("#modelo"+id).val(); 
                        var color = $("#color"+id).val();
                        var dolar = $("#dolar"+id).val();
                        var costo = $("#costo"+id).val();
                        var utilidad = $("#utilidad"+id).val();
                        var precio2 = $("#precio2"+id).val();
                        var precio3 = $("#precio3"+id).val();
                        var und_pro = $("#und_pro"+id).val();
                        var destino = $("#destino"+id).val();
                        var options = $("#options"+id).val();
                        
			$("#mod_id").val(id);
			$("#mod_codigo").val(codigo_producto);
			$("#mod_nombre").val(nombre_producto);
			$("#mod_precio").val(precio_producto);
                        $("#mod_costo").val(costo_producto);
                        $("#mod_status").val(status);
                        $("#mod_monventa").val(monventa);
                        $("#mod_moncosto").val(moncosto);
                        $("#mod_cat").val(cat_pro);
                        $("#mod_inv").val(inv);
                        $("#mod_marca").val(marca);
                        $("#mod_modelo").val(modelo);
                        $("#mod_color").val(color);
                        $("#multiplicando1").val(dolar);
                        $("#soles").val(costo);
                        $("#utilidad").val(utilidad);
                        $("#mod_precio2").val(precio2);
                        $("#mod_precio3").val(precio3);
                        $("#mod_und_pro").val(und_pro);
                        $("#mod_destino").val(destino);
                        $("#mod_options").val(options);
		}
</script>

<script type="text/javascript">
    
    $('#productos1').addClass("treeview active");
    $('#productos').addClass("active");

</script>

</body>

</html>







