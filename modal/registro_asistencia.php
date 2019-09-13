	<!doctype html>
<html lang="en">
<head>
<script>
function limpiarFormulario() {
    document.getElementById("guardar_asistencia").reset();  
}
var mostrarValor = function(x){
var x;
var porciones = x.split('-');
    document.getElementById('valoreninput').value=porciones[1];
};
</script>
</head>
<?php
    if (isset($con))
    {
	$tienda1=$_SESSION['tienda'];
        ?>
        <body>     
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
            <div class="modal-dialog" role="document">
		<div class="modal-content">     
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Agregar nueva asistencia</font></h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_asistencia" name="guardar_asistencia" autocomplete="off">
			<div id="resultados_ajax"></div>
                        
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Empleado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="nombre" name="nombre" required onchange="mostrarValor(this.value);">
					<option value="">-- Selecciona Empleado --</option>
                                        <?php
                                        $nom = array();
                                        $sql2="select * from users ORDER BY  `users`.`nombres` ASC ";
                                        $rs1=mysqli_query($con,$sql2);
                                        while($row3=mysqli_fetch_array($rs1)){
                                        if($tienda1==$row3["sucursal"]){
                                            $user_id=$row3["user_id"];
                                            $nombres=$row3["nombres"];
                                            $hora=$row3["hora"];
                                            $valor=$user_id."-".$hora;
                                            ?>
                                            <option value="<?php  echo $valor;?>"><?php  echo $nombres;?> </option>
                                            <?php

                                        }
                                        }                       
                        ?>
                         </select>
			</div>
			</div>
                        <div class="form-group">
				<label for="nom_cat" class="col-sm-3 control-label">Hora de entrada:</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" name="valoreninput" id="valoreninput" placeholder="Hora" readonly onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
                        <div class="form-group">
				<label for="tipo_reg" class="col-sm-3 control-label">Tipo de Registro:</label>
				<div class="col-sm-8">
				 <select class="form-control" id="tipo_reg" name="tipo_reg" required >
					<option value="">-- Selecciona tipo de registro --</option>
                                        <option value="1">Hora de Ingreso</option>
                                        <option value="2">Hora de Salida</option>
                         </select>
				</div>
			  </div>
                        
		  </div>
		  <div class="modal-footer">
                      
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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


