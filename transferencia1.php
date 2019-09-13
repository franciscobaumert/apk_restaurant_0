<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Traslados";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[14]==0){
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
      TRASLADOS
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
        TRASLADOS
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
              <a href="transferencia.php" class="btn btn-info" ><span class="glyphicon glyphicon-plus" ></span> Nueva Traslado</a>
            </div>
            <h3 class="box-title">
              PRODUCTOS TRASLADADOS
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


<script>
        $(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_servicios.php?action=ajax&page='+page+'&q='+q,
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
		if (confirm("Realmente deseas eliminar el servicio")){	
		$.ajax({
                type: "GET",
                url: "./ajax/buscar_servicios.php",
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
        $( "#guardar_servicios" ).submit(function( event ) {
        $('#guardar_datos').attr("disabled", true);
        var parametros = $(this).serialize();
	$.ajax({
            type: "POST",
            url: "ajax/nuevo_servicios.php",
            data: parametros,
            beforeSend: function(objeto){
		$("#resultados_ajax").html('<img src="assets/itsolution24/img/loading2.gif">');
            },
            success: function(datos){
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
                load(1);
            }
	});
    event.preventDefault();
})

$( "#editar_servicios" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_servicios.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html('<img src="assets/itsolution24/img/loading2.gif">');
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})
function obtener_datos(id){
    var nombre = $("#nombre"+id).val();
    var codigo = $("#codigo"+id).val(); 
    $("#mod_nombre").val(nombre);
    $("#mod_codigo").val(codigo);
    $("#mod_id").val(id);
}      
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <script>
	$(function() {
		$("#q").autocomplete({
                    source: "./ajax/autocomplete/productos.php",
                    minLength: 1,
                    select: function(event, ui) {
			event.preventDefault();
			$('#id_producto').val(ui.item.id_producto);
			$('#q').val(ui.item.nombre_producto);
			$('#precio_producto').val(ui.item.precio_producto);
			$('#inv_producto').val(ui.item.inv_producto);
                    }
		});
        });
					
	$("#q" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_producto" ).val("");
							$("#inv_producto" ).val("");
							$("#precio_producto" ).val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#q" ).val("");
							$("#id_producto" ).val("");
							$("#inv_producto" ).val("");
							$("#precio_producto" ).val("");
						}
			});	

  </script>

<script type="text/javascript">
    
    $('#traslados').addClass("treeview active");
    $('#transferencia1').addClass("active");

</script>

<script src="js/select/select2.full.js"></script>
</body>
</html>







