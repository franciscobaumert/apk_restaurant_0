<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Trasladar";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$sql2="select * from sucursal ORDER BY  `sucursal`.`tienda` DESC ";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$tienda1=$rs2["tienda"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[13]==0){
    header("location:error.php");    
}
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
      TRASLADOS
      <small>
        GESTIONAR
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
            <h3 class="box-title">
              TRASLADAR PRODUCTOS
            </h3>
          </div>
          <div class="box-body">
            <?php
print"<form name=\"myForm\" class=\"form-horizontal form-label-left\" id=\"guardar_producto\" enctype=\"multipart/form-data\" action=\"transferencia2.php\" method=\"POST\">";
$mensaje=recoge1('mensaje');  
?>
    
        <div class="form-group">
            <label for="producto" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre del Producto:</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
                    <input onKeyUp="this.value=this.value.toUpperCase();" type="text" class="form-control" id="nombre_producto" placeholder="Selecciona un producto" required>
      <input id="id_producto" name="id_producto" type='hidden'>
                                
                </div>
        </div>
        <div class="form-group">
            <label for="inventario" class="control-label col-md-3 col-sm-3 col-xs-12">Inventario:</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
                    <input onKeyUp="this.value=this.value.toUpperCase();" type="text" class="form-control" readonly id="inv_producto" name="inv_producto" >
            </div>
  </div>
  <div class="form-group">
            <label for="precio" class="control-label col-md-3 col-sm-3 col-xs-12">Precio del Producto S/:</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
                    <input onKeyUp="this.value=this.value.toUpperCase();" type="text" readonly class="form-control" id="precio_producto" name="precio" placeholder="precio_producto">
    </div>
  </div>  
        <?php
        $tienda=$_SESSION['tienda'];
          
        ?>
        <div class="form-group">
            <label for="cantidad" class="control-label col-md-3 col-sm-3 col-xs-12">Cantidad a trasladar de la Tienda <font color="red"><strong><?php echo $tienda;?></strong></font>:</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <input onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad del Producto" required>
            </div>
        </div>
  <div class="form-group">
            <label for="tienda2" class="control-label col-md-3 col-sm-3 col-xs-12">A la Tienda</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
                    <select onKeyUp="this.value=this.value.toUpperCase();" class="form-control" id="tienda2" name="tienda2" required>
      <option value="">-- Selecciona Tienda --</option>
                            <?php 
                                $prod = array();
                                for($i=1 ;$i<=$tienda1;$i++){
                                    if($i<>$tienda){
          
                                    ?>
                                    <option value="<?php echo $i;?>">Tienda <?php echo $i;?></option>                         
                                    <?php
                                    }
        
                                }  
                            ?>                                   
                                   
                    </select>
    </div>
  </div>
        <div class="form-group" style="margin-left: 0px;">
            <button type="submit" class="btn btn-primary" name="aceptar" >Aceptar Traslado</button>
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

<!-- SCRIPTS DE FACTURAS -->

<script type="text/javascript" src="js/facturas.js"></script>
<script type="text/javascript" src="js/VentanaCentrada.js"></script>

<!-- FIN SCRIPTS DE FACTURAS -->


  <script src="js/pace/pace.min.js"></script>
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

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
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
        placeholder: "Con Max Selección límite de 4",
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
  



	<script>
		$(function() {
						$("#nombre_producto").autocomplete({
							source: "./ajax/autocomplete/productos.php",
							minLength: 1,
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
    
    $('#traslados').addClass("treeview active");
    $('#transferencia').addClass("active");

</script>

</body>

</html>