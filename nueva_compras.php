<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");

$title="Nueva Compra";
//include('conexion.php');
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$sql2="select * from datosempresa where id_emp=1";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$dolar=$rs2["dolar"];

$tienda1=$_SESSION['tienda'];
$sql3="select * from sucursal where tienda=$tienda1";
$rw3=mysqli_query($con,$sql3);//recuperando el registro
$rs3=mysqli_fetch_array($rw3);//trasformar el registro en un vector asociativo
$caja=$rs3["caja"];

$session_id=session_id();
$delete2=mysqli_query($con, "delete from tmp where session_id='".$session_id."'");
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
   header("location: login.php");
    exit;
}

if($a[20]==0){
   header("location:error.php");    
   
}
if($caja==0){
    header("location:error1.php");    
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
        REALIZAR COMPRA
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

<div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <?php
          $read="";  
          $required="";
          $color="";
          $form="facturas.php";
          if ($_SESSION['doc_ventas']>=5 and $_SESSION['doc_ventas']<8) {
              $_SESSION['doc_ventas']=1;
          }
          if ($_SESSION['doc_ventas']==1) {
              $doc="Factura";
              $read="readonly";
              $required="required";
              $color="#F5D0A9";
              $dato="INGRESAR RUC";
              
          }
          if ($_SESSION['doc_ventas']==2) {
              $doc="Boleta";
              $read="readonly";
              $dato="INGRESAR DNI";
          }
          if ($_SESSION['doc_ventas']==3) {
              $doc="Guia";
              $read="readonly";
              $dato="INGRESAR RUC/DNI";
          }
          if ($_SESSION['doc_ventas']==8) {
              $doc="Cotizacion";
              $read="readonly";
              $dato="INGRESAR RUC/DNI";
          }
          if ($_SESSION['doc_ventas']==5) {
              $doc="Nota de Debito";
              $form="credito-debito.php";
          }
          if ($_SESSION['doc_ventas']==6) {
              $doc="Nota de Credito";
              $form="credito-debito.php";
          }


          ?>
          <div class="box-header">
            <div class="btn-group pull-right">
              <button type="button" class="btn btn-danger">Tipo de documento</button>
              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
               
              </button>
              <ul class="dropdown-menu" role="menu">
                  <li><a href="doc.php?accion=1&tipo=3">Factura</a>
                </li>
                <li><a href="doc.php?accion=2&tipo=3">Boleta</a>
                </li>
               
                
              </ul>
            </div>
            <h3 class="box-title">
              NUEVA COMPRA (<?php echo "$doc";?>)
            </h3>
          </div>
          <div class="box-body">
            <?php
      
              include("modal/buscar_productos.php");
              include("modal/registro_productos.php");
              include("modal/registro_proveedores.php");
              include("modal/registro_proveedores_ruc.php");
              
            ?>

            <?php

            $consulta3 = "SELECT * FROM documento ";
            $result3 = mysqli_query($con, $consulta3);
            while ($valor3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
                if($valor3['id_documento']==$_SESSION['doc_ventas']){
                    
                   if($_SESSION['tienda']==1){
                        $doc=$valor3['tienda1']+1;
                        $doc11=$valor3['folio1'];
                    }
                    if($_SESSION['tienda']==2){
                        $doc=$valor3['tienda2']+1;
                        $doc11=$valor3['folio2'];         
                    }
                    if($_SESSION['tienda']==3){
                        $doc=$valor3['tienda3']+1;
                        $doc11=$valor3['folio3'];
                    }
                    if($_SESSION['tienda']==4){
                        $doc=$valor3['tienda4']+1;
                        $doc11=$valor3['folio4'];
                    }
                    if($_SESSION['tienda']==5){
                        $doc=$valor3['tienda5']+1;
                        $doc11=$valor3['folio5'];
                    }
                    if($_SESSION['tienda']==6){
                        $doc=$valor3['tienda6']+1;
                        $doc11=$valor3['folio6'];
                    } 
                
                }
            }

            ?>
            <form class="form-horizontal" role="form" id="datos_factura" action="compras.php" autocomplete="off" method="post">

                        
                            <div class="form-group row">
          
          <div class="col-md-4 col-sm-4 col-xs-12">
                                      Proveedor *

            <div class="input-group">
                                        <select class="form-control select2" name="id_proveedores" id="id_proveedores" required>
                      <option value="">Selecciona Proveedor</option>
                      <?php 
                      $query_categoria=mysqli_query($con,"select * from clientes order by nombre_cliente");
                      while($rw=mysqli_fetch_array($query_categoria)) {
                        ?>
                      <option value="<?php echo $rw['id_cliente'];?>"><?php echo $rw['nombre_cliente'];?></option>      
                        <?php
                      }
                      ?>
                      
                                        </select>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-plus"></i> Nuevo
               
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                  <li><a href="#" data-toggle="modal" data-target="#nuevoProveedores"><i class="fa fa-search"></i> Buscar DNI</a>
                </li>
                <li><a href="#" data-toggle="modal" data-target="#nuevoProveedoresruc"><i class="fa fa-search"></i> Buscar RUC</a>
                </li>
               
                
              </ul>
                      </span>
                      </div> 
          </div>
              
              <?php date_default_timezone_set('America/Santiago');?>

              <div class="col-md-2">
                                        Fecha *
                                        <div class="input-group">
                                            <input type="date" class="form-control" value="<?php echo date("Y-m-d");?>" id="fecha" required>
                      <span class="input-group-btn ">
                        <button class="btn btn-default " type="button"><i class="fa fa-calendar "></i></button>
                      </span>
                                           
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-3 col-xs-12 hidden">
                                                            Hora: *
                <input  type="time" class="form-control" value="<?php echo date("H:i:s");?>" id="hora" required>
              </div>

              <div class="col-md-2 col-sm-2 col-xs-12">
                                                            
                Folio *<input type="text" class="form-control" id="folio" placeholder="Folio" required onKeyUp="this.value=this.value.toUpperCase();" >
              </div>

              <div class="col-md-2 col-sm-2 col-xs-12">
                                                            
                Numero *<input type="text" class="form-control" id="factura" placeholder="Numero" required onKeyUp="this.value=this.value.toUpperCase();" >
              </div>

              <div class="col-md-2">

                                        Agregar productos
                                       <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'></i> Buscar productos</button>
                                    </div>
                                  
                                                        <input type="hidden" class="form-control" id="ot"  value="0" >
          
              <div class="col-md-2 col-sm-2 col-xs-12 hidden">
                                                            Teléfono
                <input type="text" class="form-control" id="tel1" placeholder="Teléfono" readonly>
              </div>
          
              <div class="col-md-2 col-sm-2 col-xs-12 hidden">
                                                            Email
                <input type="text" class="form-control hidden" id="mail" placeholder="Email" readonly>
              </div>
        
                                                </div>
            <div class="form-group row hidden">
            
              
                            
              
                                                        
                                                  
                                                    <input type="hidden" class="form-control" value="1" name="moneda" id="moneda"  required>
                                                    <input type="hidden" class="form-control" value="12" name="tcp" id="tcp"  required>
              <div class="col-md-3 col-sm-3 col-xs-12">
                                                            Pago *
                <select class='form-control' id="condiciones">
                  <option value="1">Efectivo</option>
                  <option value="2">Cheque</option>
                  <option value="3">Transferencia bancaria</option>
                  <!--<option value="4">Credito</option>-->
                </select>
              </div>
                                                        
                                                        
                                                        
              <div class="col-md-3 col-sm-3 col-xs-12 hidden">
                                                            Nro Dias *
                <input type="text" value="0" class="form-control" id="dias" name="dias" placeholder="Número de días de crédito">
              </div>
                                                        
            </div>
        
        
                                    <div class="col-md-12">
          <div class="pull-right">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#nuevoProducto">
             <span class="fa fa-plus"></span> Nuevo Producto
            </button>
            <button type="submit" class="btn btn-primary">
              <span class="fa fa-save"></span> Guardar Datos
            </button>
          </div>  
        </div>
      </form> 

      <br><br><br>
      
    <div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->      
    </div>
  </div>    
      <div class="row-fluid">
      <div class="col-md-12">
      
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
  
  <script type="text/javascript" src="js/VentanaCentrada.js"></script>
  
  


  <script>

  $(function () {

    //datepicker
    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
       endDate: '-1d',
      autoclose: true
    });
    });

    $(function() {
            $("#nombre_proveedores").autocomplete({
              source: "./ajax/autocomplete/proveedores.php",
              minLength: 2,
              select: function(event, ui) {
                event.preventDefault();
                $('#id_proveedores').val(ui.item.id_proveedores);
                $('#nombre_proveedores').val(ui.item.nombre_proveedores);
                $('#tel1').val(ui.item.telefono_proveedores);
                $('#mail').val(ui.item.email_proveedores);
                                
                
               }
            });
             
            
          });
          
  $("#nombre_proveedores" ).on( "keydown", function( event ) {
            if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
            {
              $("#id_proveedores" ).val("");
              $("#tel1" ).val("");
              $("#mail" ).val("");
                      
            }
            if (event.keyCode==$.ui.keyCode.DELETE){
              $("#nombre_proveedores" ).val("");
              $("#id_proveedores" ).val("");
              $("#tel1" ).val("");
              $("#mail" ).val("");
            }
      }); 
  
        
        
        
        
        
        $(document).ready(function(){
      load(1);
      $( "#resultados" ).load( "ajax/agregar_compras.php" );
    });

    function load(page){
      var q= $("#q").val();
      $("#loader").fadeIn('slow');
      $.ajax({
        url:'./ajax/productos_compras.php?action=ajax&page='+page+'&q='+q,
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

  function agregar (id)
    {
      var precio_venta=document.getElementById('precio_venta_'+id).value;
      var cantidad=document.getElementById('cantidad_'+id).value;
                        var stock=document.getElementById('stock_'+id).value;
      //Inicia validacion
      if (isNaN(cantidad))
      {
      alert('Esto no es un numero');
      document.getElementById('cantidad_'+id).focus();
      return false;
      }                     
                       
                           
                        
                        
      if (isNaN(precio_venta))
      {
      alert('Esto no es un numero');
      document.getElementById('precio_venta_'+id).focus();
      return false;
      }
      //Fin validacion
      
      $.ajax({
        type: "POST",
        url: "./ajax/agregar_compras.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&stock="+stock,
     beforeSend: function(objeto){
      //$("#resultados").html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
        success: function(datos){
    $("#resultados").html(datos);
    }
      });
    }
    
      function eliminar (id)
    {
      
      $.ajax({
        type: "GET",
        url: "./ajax/agregar_compras.php",
        data: "id="+id,
     beforeSend: function(objeto){
      //$("#resultados").html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
        success: function(datos){
    $("#resultados").html(datos);
    }
      });

    }
    
    $("#datos_factura").submit(function(){
      var id_proveedores = $("#id_proveedores").val();
      var id_vendedor = $("#id_vendedor").val();
      var condiciones = $("#condiciones").val();
      var folio = $("#folio").val();
                  var factura = $("#factura").val();
      var moneda = $("#moneda").val();
                  var fecha = $("#fecha").val();
                    var hora = $("#hora").val();
                    var ot = $("#ot").val();
                    var tcp = $("#tcp").val();
                     var dias = $("#dias").val();
                    
      if (id_proveedores==""){
        alert("Debes seleccionar un proveedor");
        $("#nombre_proveedores").focus();
        return false;
      }
     VentanaCentrada('./pdf/documentos/factura1_pdf.php?id_proveedores='+id_proveedores+'&id_vendedor='+id_vendedor+'&factura='+factura+'&moneda='+moneda+'&condiciones='+condiciones+'&fecha='+fecha+'&hora='+hora+'&dias='+dias+'&tcp='+tcp+'&folio='+folio,'Factura','','1024','768','true');
    });
    
    $( "#guardar_proveedores" ).submit(function( event ) {
    $('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
    $('#guardar_datos').attr("disabled", true);
      
     var parametros = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "ajax/nuevo_proveedores.php",
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

$( "#guardar_proveedores_ruc" ).submit(function( event ) {
    $('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
    $('#guardar_datos').attr("disabled", true);
      
     var parametros = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "ajax/nuevo_proveedores.php",
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

        </script>
<script>
    $(".select2").select2();
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
    
    $('#compras1').addClass("treeview active");
    $('#nueva_compras').addClass("active");

</script>

</body>

</html>















