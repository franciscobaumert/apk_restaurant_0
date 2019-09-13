<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Tiendas";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
    if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
  exit;
    }
    if($a[2]==0){
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
      TIENDAS
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
        TIENDAS
      </li>
    </ol>
  </section>
  <!-- ContentH eader End -->
<section class="content">

<?php
include("modal/registro_sucursal.php");
include("modal/editar_sucursal.php");
?>

<div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <div class="btn-group pull-right">
              <button type='button' class="btn btn-info" data-toggle="modal" data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus" ></span> Nueva Tienda</button>
            </div>
            <h3 class="box-title">
              LISTA DE TIENDAS
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
        url:'./ajax/buscar_sucursal.php?action=ajax',
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
    if (confirm("Realmente deseas eliminar la categoria")){ 
    $.ajax({
        type: "GET",
        url: "./ajax/buscar_sucursal.php",
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
    
    
  
$( "#guardar_sucursal" ).submit(function( event ) {
$('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/nuevo_sucursal.php",
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

$( "#editar_sucursal" ).submit(function( event ) {
$('#actualizar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/editar_sucursal.php",
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
      var nombre = $("#nombre"+id).val();
                        var ruc = $("#ruc"+id).val();
                        var direccion = $("#direccion"+id).val();
                        var correo = $("#correo"+id).val();
                        var telefono = $("#telefono"+id).val();
                        var ubigeo = $("#ubigeo"+id).val();
                        var departamento = $("#departamento"+id).val();
                        var provincia = $("#provincia"+id).val();
                        var distrito = $("#distrito"+id).val();
                        
                        $("#mod_nombre").val(nombre);
                        $("#mod_ruc").val(ruc);
                        $("#mod_direccion").val(direccion);
                        $("#mod_correo").val(correo);
                        $("#mod_telefono").val(telefono);
                        $("#mod_id").val(id);
                        $("#mod_ubigeo").val(ubigeo);
                        $("#mod_departamento").val(departamento);
                        $("#mod_provincia").val(provincia);
                        $("#mod_distrito").val(distrito);
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
              $('#nom_cat').val(datos[1]);
              $('#estado_del_contribuyente').val(datos[2]);
              $('#condicion_de_domicilio').val(datos[3]);
              $('#ubigeo').val(datos[4]);
              $('#tipo_de_via').val(datos[5]);
              $('#nombre_de_via').val(datos[6]);
              $('#codigo_de_zona').val(datos[7]);
              $('#numero').val(datos[8]);
              $('#interior').val(datos[9]);
              $('#lote').val(datos[10]);
              $('#dpto').val(datos[11]);
              $('#manzana').val(datos[12]);
              $('#kilometro').val(datos[13]);
              $('#departamento').val(datos[14]);
              $('#provincia').val(datos[15]);
              $('#distrito').val(datos[16]);
              $('#direccion1').val(datos[17]);
              $('#direccion').val(datos[18]);
              $('#ultima_actualizacion').val(datos[19]);
            }   
          }
        });
        return false;
      });
    });
  </script>

  <script>
    $(function(){
      $('#botoncitoruc1').on('click', function(){
        var mod_ruc = $('#mod_ruc').val();
        var url = 'consulta_ruc_config.php';
        $('.ajaxgif1').removeClass('hide');
        $('.nohidden1').addClass('hide');
        $.ajax({
          type:'POST',
          url:url,
          data:'mod_ruc='+mod_ruc,
          success: function(datos_dni){
            $('.ajaxgif1').addClass('hide');
            $('.nohidden1').removeClass('hide');
            var datos = eval(datos_dni);
            var nada ='nada';
            if(datos[0]==nada){
              alert('DNI o RUC no válido o no registrado');
            }else{
              $('#numero_ruc').text(datos[0]);
              $('#mod_nombre').val(datos[1]);
              $('#estado_del_contribuyente').val(datos[2]);
              $('#condicion_de_domicilio').val(datos[3]);
              $('#mod_ubigeo').val(datos[4]);
              $('#tipo_de_via').val(datos[5]);
              $('#nombre_de_via').val(datos[6]);
              $('#codigo_de_zona').val(datos[7]);
              $('#numero').val(datos[8]);
              $('#interior').val(datos[9]);
              $('#lote').val(datos[10]);
              $('#dpto').val(datos[11]);
              $('#manzana').val(datos[12]);
              $('#kilometro').val(datos[13]);
              $('#mod_departamento').val(datos[14]);
              $('#mod_provincia').val(datos[15]);
              $('#mod_distrito').val(datos[16]);
              $('#direccion1').val(datos[17]);
              $('#mod_direccion').val(datos[18]);
              $('#ultima_actualizacion').val(datos[19]);
            }   
          }
        });
        return false;
      });
    });
  </script>


</body>

</html>







