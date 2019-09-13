<?php
	session_start();
        include('menu.php');
        require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Caja";
       
   $sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo


$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
        
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

        if($a[32]==0){
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
      CAJAS
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
        CAJAS
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
              <button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus" ></span> Nueva Caja</button>
            </div>
            <h3 class="box-title">
              LISTA DE CAJAS
            </h3>
          </div>
          <div class="box-body">
          	
<?php
include("modal/registro_caja.php");
include("modal/editar_caja.php");
?>
          	<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Fecha</label>
							<div class="col-md-5">
								<input type="date" class="form-control" id="q" placeholder="Fecha" onkeyup='load(1);'>
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
  
  
 

<script>
        $(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_caja.php?action=ajax&page='+page+'&q='+q,
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
		if (confirm("Realmente deseas eliminar la caja")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_caja.php",
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
		
		
	
$( "#guardar_caja" ).submit(function( event ) {
$('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_caja.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax").html('<img src="assets/itsolution24/img/loading2.gif">');
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
      $('#guardar_datos').html('Guardar datos');
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_caja" ).submit(function( event ) {
$('#actualizar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_caja.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax2").html('<img src="assets/itsolution24/img/loading2.gif">');
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
			var salida = $("#salida"+id).val();
                        var entrada = $("#entrada"+id).val();
                        var faltante = $("#faltante"+id).val();
                         var inicio = $("#inicio"+id).val();
                        $("#salida").val(salida);
                        $("#entrada").val(entrada);
                        $("#faltante").val(faltante);
                        $("#mod_inicio").val(inicio);
                        $("#mod_id").val(id);
		
		}
        
        
        
        
        </script>
<script type="text/javascript">
    
    //$('#usuarios1').addClass("treeview active");
    $('#caja').addClass("active");

</script>


</body>

</html>







