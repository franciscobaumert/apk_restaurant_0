<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Configuracion Documentos";

$consulta1 = "SELECT * FROM clientes ";
$result1 = mysqli_query($con, $consulta1);
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

$mensaje=recoge1('mensaje');


?>

<?php include ("header.php"); ?>

<script>
  function limpiarFormulario() {
    document.getElementById("guardar_producto").reset();
  }
  var mostrarValor = function(x){
            document.getElementById('precio').value=x;
            
           
            }
 
 
 
    var mostrarValor2 = function(x){
            
        
        
        document.getElementById('precio').value=x;
        
        
        
            }
  
</script>
<SCRIPT LANGUAGE="JavaScript" SRC="calendar.js"></SCRIPT>
<style type="text/css"> 
    .fijo {
  background: #333;
  color: white;
  height: 10px;
  
  width: 100%; /* hacemos que la cabecera ocupe el ancho completo de la página */
  left: 0; /* Posicionamos la cabecera al lado izquierdo */
  top: 0; /* Posicionamos la cabecera pegada arriba */
  position: fixed; /* Hacemos que la cabecera tenga una posición fija */
} 

</style>

<?php

menu1();

?>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      DOCUMENTOS
      <small>
        CONFIGURACION DE DOCUMENTOS
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
        DOCUMENTOS
      </li>
    </ol>
  </section>
  <!-- ContentH eader End -->
<section class="content">

<div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">
              SERIES Y CORRELATIVOS
            </h3>
          </div>
          <div class="box-body">

            <?php
                      if($mensaje<>"")
              {
              ?>
          <script>
            toastr.options = {
            "closeButton":false,
            "progressBar": false
          };
          toastr.success("<?php echo $mensaje;?>","Exito");
          </script>
             <?php 
          }
          ?>

<form name="myForm" class="form-horizontal form-label-left" action="documentos1.php" id="perfil" enctype="multipart/form-data" method="post">      
            <?php
$tien="tienda".$_SESSION['tienda'];
$fol="folio".$_SESSION['tienda'];
$consulta3 = "SELECT * FROM documento ";
$result3 = mysqli_query($con, $consulta3);
while ($valor3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
    if($valor3['id_documento']==1){
    $factura=$valor3["$tien"];
    $folio1=$valor3["$fol"];
    
    }
    if($valor3['id_documento']==2){
    $boleta=$valor3["$tien"];
    $folio2=$valor3["$fol"];
    }
    if($valor3['id_documento']==3){
    $folio8=$valor3["$fol"];
    $guia=$valor3["$tien"];
    }   
    if($valor3['id_documento']==4){
    $folio9=$valor3["$fol"];
    $remision=$valor3["$tien"];
    }
    
    if($valor3['id_documento']==5){
    $nota_debito=$valor3["$tien"];
    $folio3=$valor3["$fol"];
    }
    if($valor3['id_documento']==6){
    $nota_credito=$valor3["$tien"];
    $folio4=$valor3["$fol"];
    }
    
    if($valor3['id_documento']==8){
    $cotizacion=$valor3["$tien"];
    $folio5=$valor3["$fol"];
    }
    if($valor3['id_documento']==9){
    $nota_debito1=$valor3["$tien"];
    $folio6=$valor3["$fol"];
    }
    if($valor3['id_documento']==10){
    $nota_credito1=$valor3["$tien"];
    $folio7=$valor3["$fol"];
    }
    
} 

?>

<div class="form-group">
        <label for="producto" class="col-sm-3 control-label">Factura:</label>
        <div class="col-sm-4">
         <input type="text" class="form-control" name="folio1" id="folio1" value="<?php echo $folio1;?>" placeholder="Folio" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
           
                                </div>
                                
                                <div class="col-sm-4">
         <input type="text" class="form-control" name="factura" id="factura" value="<?php echo $factura;?>" placeholder="Numero de Factura" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
           
                                </div>
        </div>
                         
            <div class="form-group">
        <label for="inventario" class="col-sm-3 control-label">Boleta:</label>
        <div class="col-sm-4">
         <input type="text" class="form-control" name="folio2" id="folio2" value="<?php echo $folio2;?>" placeholder="Folio" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
           
                                </div>
                                
                                <div class="col-sm-4">
         <input type="text" class="form-control"  id="boleta" name="boleta" value="<?php echo $boleta;?>" placeholder="Numero de Boleta" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        </div>
    
                           <div class="form-group">
        <label for="inventario" class="col-sm-3 control-label">Nota Debito Factura:</label>
        <div class="col-sm-4">
         <input type="text" class="form-control" name="folio3" id="folio3" value="<?php echo $folio3;?>" placeholder="Folio" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
           
                                </div>
                                
                                <div class="col-sm-4">
         <input type="text" class="form-control"  id="nota_debito" name="nota_debito" value="<?php echo $nota_debito;?>" placeholder="Numero de Nota de Debito" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        </div>
                          
                        <div class="form-group">
        <label for="inventario" class="col-sm-3 control-label">Nota Credito Factura:</label>
        <div class="col-sm-4">
         <input type="text" class="form-control" name="folio4" id="folio4" value="<?php echo $folio4;?>" placeholder="Folio" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
           
                                </div>
                                
                                <div class="col-sm-4">
         <input type="text" class="form-control"  id="nota_credito" name="nota_credito" value="<?php echo $nota_credito;?>" placeholder="Numero de Nota de Credito" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        </div>

        <div class="form-group">
        <label for="inventario" class="col-sm-3 control-label">Nota Debito Boleta:</label>
        <div class="col-sm-4">
         <input type="text" class="form-control" name="folio6" id="folio6" value="<?php echo $folio6;?>" placeholder="Folio" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
           
                                </div>
                                
                                <div class="col-sm-4">
         <input type="text" class="form-control"  id="nota_debito1" name="nota_debito1" value="<?php echo $nota_debito1;?>" placeholder="Numero de Nota de Debito" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        </div>
                          
                        <div class="form-group">
        <label for="inventario" class="col-sm-3 control-label">Nota Credito Boleta:</label>
        <div class="col-sm-4">
         <input type="text" class="form-control" name="folio7" id="folio7" value="<?php echo $folio7;?>" placeholder="Folio" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
           
                                </div>
                                
                                <div class="col-sm-4">
         <input type="text" class="form-control"  id="nota_credito1" name="nota_credito1" value="<?php echo $nota_credito1;?>" placeholder="Numero de Nota de Credito" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        </div>

      <div class="form-group">
        <label for="precio" class="col-sm-3 control-label">Cotizacion:</label>
        <div class="col-sm-4">
         <input type="text" class="form-control" name="folio5" id="folio5" value="<?php echo $folio5;?>" placeholder="Folio" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
           
                                </div>
                                <div class="col-sm-4">
                                    
          <input type="text"  class="form-control" id="cotizacion" name="cotizacion" value="<?php echo $cotizacion;?>" placeholder="Numero de Cotización" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
                                
                               
        </div>
    
    
      <div class="form-group">
        <label for="precio" class="col-sm-3 control-label">Ticket (nota de venta):</label>

        <div class="col-sm-4">
         <input type="text" class="form-control" name="folio8" id="folio8" value="<?php echo $folio8;?>" placeholder="Folio" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
           
                                </div>

        <div class="col-sm-4">
                                    
          <input type="text"  class="form-control" id="guia" name="guia" value="<?php echo $guia;?>" placeholder="Numero de Guia" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        </div>
          
                          
                           <div class="form-group">
        <label for="precio" class="col-sm-3 control-label">Guia de Remision:</label>

        <div class="col-sm-4">
         <input type="text" class="form-control" name="folio9" id="folio9" value="<?php echo $folio9;?>" placeholder="Folio" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
           
                                </div>

        <div class="col-sm-4">
                                    
          <input type="text"  class="form-control" id="remision" name="remision" value="<?php echo $remision;?>" placeholder="Numero de Guia" autocomplete="off" onKeyUp="this.value=this.value.toUpperCase();">
        </div>
        </div>
   
          
          
          <?php
          
          
          $tienda=$_SESSION['tienda'];
          
          ?>
          <div class="modal-footer">
          
          <button type="submit" class="btn btn-primary" name="aceptar" id="guardar_datos">Guardar datos</button>

          </div>
           </form>

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


<script type="text/javascript" src="js/facturas.js"></script>
  <script type="text/javascript" src="js/VentanaCentrada.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>

<script>
$( "#perfil" ).submit(function( event ) {
$('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      //type: "POST",
      //url: "conf_electronica1.php",
      //data: parametros,
       //beforeSend: function(objeto){
        //$("#resultados_ajax").html("Mensaje: Cargando...");
        //},
      //success: function(datos){
      //$("#resultados_ajax").html(datos);
      //$('#guardar_datos').html('Guardar datos');
      //$('#guardar_datos').attr("disabled", false);

      //}
  });
  //event.preventDefault();
})





    
</script>

  <script>
    $(document).ready(function() {
      $('input.tableflat').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
      });
    });

    var asInitVals = new Array();
    $(document).ready(function() {
      var oTable = $('#example').dataTable({
        "oLanguage": {
          "sSearch": "Search all columns:"
        },
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
          } //disables sorting for column one
        ],
        'iDisplayLength': 12,
        "sPaginationType": "full_numbers",
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
          "sSwfPath": "js/datatables/tools/swf/copy_csv_xls_pdf.swf"
        }
      });
      $("tfoot input").keyup(function() {
        /* Filter on the column based on the index of this element's parent <th> */
        oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
      });
      $("tfoot input").each(function(i) {
        asInitVals[i] = this.value;
      });
      $("tfoot input").focus(function() {
        if (this.className == "search_init") {
          this.className = "";
          this.value = "";
        }
      });
      $("tfoot input").blur(function(i) {
        if (this.value == "") {
          this.className = "search_init";
          this.value = asInitVals[$("tfoot input").index(this)];
        }
      });
    });
  </script>
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script type="text/javascript">
    $(function() {
      'use strict';
      
      var data =[
      <?php
                    for($i = 0;$i<count($producto);$i++){
                ?>
                '<?php echo $producto[$i];?>',
                <?php } ?>];
     
      
      
      var countriesArray = $.map(data, function(value, key) {
        return {
          value: value,
          data: key
        };
      });
      // Initialize autocomplete with custom appendTo:
      $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
      });
    });
  </script>
  
  <script src="js/select/select2.full.js"></script>
  <!-- form validation -->
  
  <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Seleccionar",
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "Con Max Selección limite de 4",
        allowClear: true
      });
    });
    
    
    $( "#nuevoProducto1" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "registro_productos.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax2").html("Mensaje: Cargando...");
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
      var descripcion = $("#descripcion"+id).val();
                        var equipo = $("#equipo"+id).val();
                        var com_ser = $("#com_ser"+id).val();
                        var des_ser = $("#des_ser"+id).val();
                        
                        
                        $("#mod_descripcion").val(descripcion);
                        $("#mod_equipo").val(equipo);
                        $("#mod_com_ser").val(com_ser);
                        $("#mod_des_ser").val(des_ser);
        $("#mod_id").val(id);
    
    }
     function imprimir_factura(id_factura){
      VentanaCentrada('./pdf/documentos/ver_factura.php?id_factura='+id_factura,'Factura','','1024','768','true');
    }
  </script>
  
  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  
        
        
        <script>
    $(function() {
            $("#nombre_producto").autocomplete({
              source: "./ajax/autocomplete/productos.php",
              minLength: 2,
              select: function(event, ui) {
                event.preventDefault();
                $('#id_producto').val(ui.item.id_producto);
                $('#nombre_producto').val(ui.item.nombre_producto);
                $('#precio_producto').val(ui.item.precio_producto);
                $('#inv_producto').val(ui.item.inv_producto);
                                
                
               }
            });
             
            
          });
          
  $("#nombre_producto" ).on( "keydown", function( event ) {
            if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
            {
              $("#id_producto" ).val("");
              $("#inv_producto" ).val("");
              $("#precio_producto" ).val("");
                      
            }
            if (event.keyCode==$.ui.keyCode.DELETE){
              $("#nombre_producto" ).val("");
              $("#id_producto" ).val("");
              $("#inv_producto" ).val("");
              $("#precio_producto" ).val("");
            }
      }); 
  
        
        
        
        
        
      
 
  </script>
  
<script type="text/javascript">
    
    $('#adm').addClass("treeview active");
    $('#documentos').addClass("active");

</script>  
  
  
</body>

</html>