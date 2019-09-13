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
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">  
            <div class="modal-dialog" role="document">  
		<div class="modal-content">  
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="myModalLabel"><font color="black" >Agregar nueva mesa</font></h5>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_categoria" name="guardar_categoria" autocomplete="off">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nombre_mesa" class="col-sm-3 control-label">Nombre | Numero</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="nombre_mesa" name="nombre_mesa" placeholder="Nombre de la mesa" onKeyUp="this.value=this.value.toUpperCase();" required="" aria-required="true">
				</div>
			  </div>
			  <div class="form-group">
				<label for="id_sala" class="col-sm-3 control-label">Sala</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<select class="form-control col-md-10" id="id_sala" name="id_sala" required="required" tabindex="-1" required>
						<option value="">-- Selecciona Sala --</option>
                            <?php
                        $nom = array();
                        $tienda1=$_SESSION['tienda'];
                        $sql2="select * from salas where tienda=$tienda1";
                        $i=0;
                        $rs1=mysqli_query($con,$sql2);
                        while($row3=mysqli_fetch_array($rs1)){
                            $nombre_sala=$row3["nombre_sala"];
                            $id_sala=$row3["id_sala"];
                            ?>
                            <option value="<?php  echo $id_sala;?>"><?php  echo $nombre_sala;?></option>
                            <?php
                            $i=$i+1;
                        }
                        
                        ?>
                    </select>
				  
				</div>
			  </div>	
		  </div>
		  <div class="modal-footer">
                       <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">Limpiar</button>
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