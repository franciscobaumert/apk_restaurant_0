<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Consultar Precios";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
        
}
if($a[16]==0){
    header("location:error.php");    
}

?>
<?php include ("header.php"); ?>

<?php

menu1();

?>

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
  
  <script>
  function limpiarFormulario() {
    document.getElementById("consultaprecios").reset();
  }
</script>

<?php
$foto=recoge1('foto');
$producto1=recoge1('producto');
$inv_producto=recoge1('inv_producto');
$precio=recoge1('precio');
$tipo=recoge1('tipo');
$marca=recoge1('marca');
$modelo=recoge1('modelo');
$color=recoge1('color');      
print"<form name=\"myForm\" name=\"consultaprecios\" class=\"form-horizontal form-label-left\" id=\"consultaprecios\" enctype=\"multipart/form-data\" action=\"consultaprecios.php\" method=\"POST\">
";

?>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      PRECIOS
      <small>
        CONSULTA DE PRECIOS
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
        PRECIOS
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
              CONSULTAR
            </h3>
          </div>
          <div class="box-body">
            <div class="form-group">
        <label for="producto" class="col-sm-3 control-label">Nombre del Producto:</label>
        <div class="col-sm-8">
                                    <input type="search" class="form-control" id="nombre_producto" name="producto" value="<?php echo $producto1;?>" placeholder="Nombre del producto" onKeyUp="this.value=this.value.toUpperCase();">
            <input id="id_producto" name="id_producto" type='hidden'>
                                
                                </div>
        </div>
                         
                        <div class="form-group">
        <label for="inventario" class="col-sm-3 control-label">Inventario:</label>
        <div class="col-sm-8">
         <input type="text" onKeyUp="this.value=this.value.toUpperCase();" class="form-control" readonly id="inv_producto" value="<?php echo $inv_producto;?>" name="inv_producto" >
        </div>
        </div>
        
      <div class="form-group">
        <label for="precio" class="col-sm-3 control-label">Precio S/:</label>
        <div class="col-sm-8">
                                    
          <input type="text" onKeyUp="this.value=this.value.toUpperCase();" readonly class="form-control" id="precio_producto" name="precio" value="<?php echo $precio;?>" placeholder="precio producto">
        </div>
        </div>
    
                          
                        <div class="form-group">
        <label for="tipo" class="col-sm-3 control-label">Tipo de Producto:</label>
        <div class="col-sm-8">
                                    
          <input type="text" onKeyUp="this.value=this.value.toUpperCase();" readonly class="form-control" id="tipo" name="tipo" value="<?php echo $tipo;?>" placeholder="tipo">
        </div>
        </div>
          
          
          
                        <div class="form-group">
        <label for="marca" class="col-sm-3 control-label">Marca:</label>
        <div class="col-sm-8">
                                    
          <input type="text" onKeyUp="this.value=this.value.toUpperCase();" readonly class="form-control" id="marca" name="marca" value="<?php echo $marca;?>" placeholder="marca">
        </div>
        </div>
              
                        <div class="form-group">
        <label for="modelo" class="col-sm-3 control-label">Modelo:</label>
        <div class="col-sm-8">
                                    
          <input type="text" onKeyUp="this.value=this.value.toUpperCase();"  readonly class="form-control" id="modelo" name="modelo" value="<?php echo $modelo;?>" placeholder="modelo">
        </div>
      </div>
                        <div class="form-group">
        <label for="color" class="col-sm-3 control-label">Color:</label>
        <div class="col-sm-8">
                                    
          <input type="text" onKeyUp="this.value=this.value.toUpperCase();" readonly class="form-control" id="color" name="color" value="<?php echo $color;?>" placeholder="color">
        </div>
      </div>
             
         
                 <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">Limpiar</button>
 
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
  
  
  <!-- form validation -->
  

  

  
        <script>
		$(function() {
						$("#nombre_producto").autocomplete({
							source: "./ajax/autocomplete/productos1.php",
							minLength: 1,
							select: function(event, ui) {
								event.preventDefault();
								$('#id_producto').val(ui.item.id_producto);
								$('#nombre_producto').val(ui.item.nombre_producto);
								$('#precio_producto').val(ui.item.precio_producto);
                                                                $('#precio_producto2').val(ui.item.precio_producto2);
                                                                $('#precio_producto3').val(ui.item.precio_producto3);
								$('#inv_producto').val(ui.item.inv_producto);
								$('#marca').val(ui.item.marca);
                                                                $('#modelo').val(ui.item.modelo);
                                                                $('#color').val(ui.item.color);
                                                                $('#tipo').val(ui.item.tipo);
								$('#foto').val(ui.item.foto);
                                                               
                                                                
							 }
						});
						 
						
					});
					
	$("#nombre_producto" ).on( "keydown", function( event ) {
						if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
						{
							$("#id_producto" ).val("");
							$("#inv_producto" ).val("");
							$("#precio_producto" ).val("");
                                                        $("#precio_producto2" ).val("");
                                                        $("#precio_producto3" ).val("");
                                                        $('#inv_producto').val("");
                                                        $('#marca').val("");
                                                        $('#modelo').val("");
                                                        $('#color').val("");
                                                        $('#tipo').val("");
							$('#foto').val("");
											
						}
						if (event.keyCode==$.ui.keyCode.DELETE){
							$("#nombre_producto" ).val("");
							$("#id_producto" ).val("");
							$("#inv_producto" ).val("");
							$("#precio_producto" ).val("");
                                                        $("#precio_producto2" ).val("");
                                                        $("#precio_producto3" ).val("");
                                                        $('#inv_producto').val("");
                                                        $('#marca').val("");
                                                        $('#modelo').val("");
                                                        $('#color').val("");
                                                        $('#tipo').val("");
                                                        $('#foto').val("");
                                                                
						}
			});	
	
  </script>
 
<script type="text/javascript">
    
    $('#productos1').addClass("treeview active");
    $('#consultaprecios').addClass("active");

</script>

</body>

</html>