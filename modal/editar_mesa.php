	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="myModalLabel"><font color="black">Editar mesa</font></h5>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_categoria" name="editar_categoria" autocomplete="off">
			<div id="resultados_ajax2"></div>
			  <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Nombre | Numero</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Nombre de la mesa" required onKeyUp="this.value=this.value.toUpperCase();">
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_cat" class="col-sm-3 control-label">Sala</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  
				  <select class="form-control" id="mod_cat" name="mod_cat" required>
					<option value="">-- Selecciona Sala --</option>
					
                    <?php
                    $nom = array();
                    $sql2="select * from salas ";
                    $rs1=mysqli_query($con,$sql2);
                    while($row3=mysqli_fetch_array($rs1)){
                        $nombre_sala=$row3["nombre_sala"];
                        $id_sala=$row3["id_sala"];
                    ?>

                    <option value="<?php echo $id_sala;?>"><?php  echo $nombre_sala;?></option>

                    <?php
                    }         
                    ?>              
				  </select>
				</div>
			  </div>	
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>