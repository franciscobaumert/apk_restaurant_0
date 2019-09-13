<?php
session_start();
include('menu.php');
//include('conexion.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Clientes";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[19]==0){
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
      CLIENTES
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
        CLIENTES
      </li>
    </ol>
  </section>
  <!-- ContentH eader End -->
<section class="content">

<?php
include("modal/registro_clientes.php");
include("modal/registro_clientes_ruc.php");
include("modal/registro_clientes_ce.php");
include("modal/editar_clientes.php");                
?>

<div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <div class="btn-group pull-right">
              <div class="dropdown btn btn-info">
                        <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</div>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="#" data-toggle="modal" data-target="#nuevoClienteruc"><i class="fa fa-plus"></i> Buscar RUC</a></li>
                <li><a href="#" data-toggle="modal" data-target="#nuevoCliente"><i class="fa fa-plus"></i> Buscar DNI</a></li>
                <li><a href="#" data-toggle="modal" data-target="#nuevoClientece"><i class="fa fa-plus"></i> Carnet Extranjería</a></li>

                            </ul>
                </div>
            </div>
            <h3 class="box-title">
              LISTA DE CLIENTES
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
			
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_clientes.php?action=ajax',
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
		if (confirm("Realmente deseas eliminar el cliente")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_clientes.php",
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
		
		
	
$( "#guardar_cliente" ).submit(function( event ) {
    $('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
    $('#guardar_datos').attr("disabled", true);
      
     var parametros = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "ajax/nuevo_cliente.php",
          data: parametros,
           beforeSend: function(objeto){
            //$("#resultados_ajax").html('<img src="./img/ajax-loader.gif"> Cargando...');
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

$( "#guardar_cliente_ce" ).submit(function( event ) {
    $('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
    $('#guardar_datos').attr("disabled", true);
      
     var parametros = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "ajax/nuevo_cliente.php",
          data: parametros,
           beforeSend: function(objeto){
            //$("#resultados_ajax").html('<img src="./img/ajax-loader.gif"> Cargando...');
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

$( "#guardar_cliente_ruc" ).submit(function( event ) {
    $('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
    $('#guardar_datos').attr("disabled", true);
      
     var parametros = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "ajax/nuevo_cliente.php",
          data: parametros,
           beforeSend: function(objeto){
            //$("#resultados_ajax").html('<img src="./img/ajax-loader.gif"> Cargando...');
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


$( "#editar_cliente" ).submit(function( event ) {
$('#actualizar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_cliente.php",
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
			var nombre_cliente = $("#nombre_cliente"+id).val();
                        var doc = $("#doc"+id).val();
                        var dni = $("#dni"+id).val();
                        var vendedor = $("#vendedor"+id).val();
			var telefono_cliente = $("#telefono_cliente"+id).val();
			var email_cliente = $("#email_cliente"+id).val();
			var direccion_cliente = $("#direccion_cliente"+id).val();
			var status_cliente = $("#status_cliente"+id).val();
                        
                        var departamento = $("#departamento"+id).val();
                        var provincia = $("#provincia"+id).val();
                        var distrito = $("#distrito"+id).val();
                        var cuenta = $("#cuenta"+id).val();
                        var tipo = $("#tipo"+id).val();
                        
                        $("#mod_nombre").val(nombre_cliente);
                        $("#mod_doc").val(doc);
                        $("#mod_dni").val(dni);
                        $("#mod_ven").val(vendedor);
			$("#mod_telefono").val(telefono_cliente);
			$("#mod_email").val(email_cliente);
			$("#mod_direccion").val(direccion_cliente);
			$("#mod_estado").val(status_cliente);                      
                        $("#mod_id").val(id);
                        
                        $("#mod_departamento").val(departamento);    
                        $("#mod_provincia").val(provincia);    
                        $("#mod_distrito").val(distrito);    
                        $("#mod_cuenta").val(cuenta);
                        $("#mod_tipo").val(tipo);
                        
                  }
</script>

<script>
    $(function(){
      $('#botoncitoruc').on('click', function(){
        var ruc = $('#ruc').val();
        var url = 'consulta_sunat_forclienteruc.php';
        $('.ajaxgif').removeClass('hide');
        $('.nohidden').addClass('hide');
        $.ajax({
          type:'POST',
          url:url,
          data:'ruc='+ruc,
          success: function(datos_dni){
            $('.ajaxgif').addClass('hide');
            $('.nohidden').removeClass('hide');
            var datos = eval(datos_dni);
            var nada ='nada';
            if(datos[0]==nada){
              alert('DNI o RUC no válido o no registrado');
            }else{
              $('#numero_ruc').text(datos[0]);
              $('#nomclienteruc').val(datos[1]);
              $('#estado_del_contribuyente').val(datos[2]);
              $('#condicion_de_domicilio').val(datos[3]);
              $('#ubgclienteruc').val(datos[4]);
              $('#tipo_de_via').val(datos[5]);
              $('#nombre_de_via').val(datos[6]);
              $('#codigo_de_zona').val(datos[7]);
              $('#numero').val(datos[8]);
              $('#interior').val(datos[9]);
              $('#lote').val(datos[10]);
              $('#dpto').val(datos[11]);
              $('#manzana').val(datos[12]);
              $('#kilometro').val(datos[13]);
              $('#depclienteruc').val(datos[14]);
              $('#proclienteruc').val(datos[15]);
              $('#disclienteruc').val(datos[16]);
              $('#direccion').val(datos[17]);
              $('#direcclienteruc').val(datos[18]);
              $('#ultima_actualizacion').val(datos[19]);
            }   
          }
        });
        return false;
      });
    });
  </script>

  <script type="text/javascript">
    $(function(){
      $('#botoncito').on('click', function(){
        var cedcliente = $('#cedcliente').val();
        var url = 'consulta_reniec_forclientedni.php';
        $('.ajaxgif1').removeClass('hide');
        $('.nohidden1').addClass('hide');
        $.ajax({
          type:'POST',
          url:url,
          data:'cedcliente='+cedcliente,
          success: function(datos_dni){
            $('.ajaxgif1').addClass('hide');
            $('.nohidden1').removeClass('hide');
            porciones = datos_dni.split('|');
            document.getElementById("nomcliente").value = porciones[0];
            document.getElementById("direccion_cliente").value = porciones[1];
            document.getElementById("tel1").value = porciones[2];
            document.getElementById("mail").value = porciones[3];
          }
        });
        return false;
      });
    });
  </script>
  
<script type="text/javascript">
    
    //$('#usuarios1').addClass("treeview active");
    $('#clientes').addClass("active");

</script>

  </body>
</html>






























