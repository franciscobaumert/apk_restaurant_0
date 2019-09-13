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
		<div class="modal-content" style="background: #F5ECCE;">   
		  <div class="modal-header" style="background: #58FAAC;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Agregar nueva asistencia</font></h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_varlista" name="guardar_varlista" >
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
                                $valor=$user_id;
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
				<label for="nom_cat" class="col-sm-3 control-label">Fecha:</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="date" class="form-control" name="fecha_entrada" id="fecha_entrada" >
				</div>
			  </div>
                         <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Tipo de Variable</label>
				<div class="col-sm-8">
				 <select class="form-control" id="variable" name="variable" required >
					<option value="">-- Selecciona Variable --</option>
                                <?php  
                                $sql2="select * from laborales ORDER BY  `laborales`.`variables` ASC ";
                                $rs1=mysqli_query($con,$sql2);
                                while($row3=mysqli_fetch_array($rs1)){
                                    $id_laboral=$row3["id_laboral"];  
                                    if($id_laboral>0){
                                        $col_var=$row3["col_var"];
                                        $cod_var=$row3["cod_var"];
                                        $variables=$row3["variables"];
                                        $hora=$row3["hora"];
                                        ?>
                                        <option style="color:<?php  echo $col_var;?>" value="<?php  echo $id_laboral;?>"><?php  echo $cod_var ;?> </option>
                                        <?php
                                    }
                                }                       
                            ?>
                     
                        </select>
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


