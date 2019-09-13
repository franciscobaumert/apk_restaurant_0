	<!doctype html>
<html lang="en">
<head>
<script>
  function limpiarFormulario() {
    document.getElementById("guardar_categoria").reset();
  }
</script>
</head>
<?php
if (isset($con))
{
?>
	<!-- Modal -->
<body>      
	<div class="modal fade" id="nuevoResumen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">  
            <div class="modal-dialog" role="document">  
		<div class="modal-content">  
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="myModalLabel"><font color="black">Enviar resumen diario de boletas</font></h5>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_resumen" name="guardar_resumen">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nom_cat" class="col-sm-3 control-label">Fecha del resumen</label>
				<div class="col-md-4 col-sm-4 col-xs-12">
				  <input type="date" class="form-control" onclick="load1(1)" id="fecha" name="fecha"  required>
				</div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
				  <button type="button" class="btn btn-default" onclick="load1(1)" ><span class='glyphicon glyphicon-search'></span></button>
				</div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
				  <button type="submit" class="btn btn-primary" id="guardar_datos">Enviar</button>
				</div>
			  </div>
                         <div class="modal-footer">
                       
			
			
		  </div>
			
                    <div id="loader1"></div><!-- Carga gif animado -->
					<div class="outer_div1" ></div>
		  </div>
		 
                    
		  </form>
                      <!-- Datos ajax Final -->
		</div>
	  </div>
	</div>
	<?php
		}
	?>

      
        
            
            </body>
            
</html>