	<!doctype html>
<html lang="en">
<head>
</head>
<?php
if (isset($con))
{
$tienda1=$_SESSION['tienda'];
?>
<body>  
    <div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background: #F5ECCE;">
                  <div class="modal-header" style="background: #58FAAC;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Agregar nuevo bus</font></h4>
		  </div>
		  <div class="modal-body">
			 <font color="black">LLenar los campos obligatorios</font> <font style="background-color:#F7BE81;color:white; "> &nbsp;&nbsp;&nbsp;&nbsp;</font>
                            <form class="form-horizontal" method="post" id="guardar_buses" name="guardar_buses" >
			<div id="resultados_ajax"></div>
                        <div class="form-group">
				<label for="nom_cat" class="col-sm-3 control-label">Nro de Bus:</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" name="buses" id="buses" >
				</div>
			</div>
                        <div class="form-group">
				<label for="nom_cat" class="col-sm-3 control-label">Placa:</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" name="placa" id="placa" >
				</div>
			</div> 
		  </div>
		  <div class="modal-footer">
                      
			<button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

      
        
            
            </body>
            
</html>


