	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Datos del Servicio al Equipo</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_servicios3" name="editar_servicios3">
			<div id="resultados_ajax2"></div>
                        <div class="form-group">
				<label for="mod_nombre_cliente" class="col-sm-3 control-label">Razon Social</label>
				<div class="col-sm-8">
                                    <input type="text" class="form-control" id="mod_nombre_cliente" name="mod_nombre_cliente"  readonly required>
					<input type="hidden" name="mod_id" id="mod_id">          
				</div>
			  </div>
                         <div class="form-group">
				<label for="mod_equipo" class="col-sm-3 control-label">Equipo1</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_equipo" name="mod_equipo" readonly required>
				</div>
			  </div>
                         <div class="form-group">
				<label for="mod_nom_ser" class="col-sm-3 control-label">Servicio</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nom_ser" name="mod_nom_ser" readonly required>
				</div>
                         </div>
                         <div class="form-group">
				<label for="mod_nom_ser" class="col-sm-3 control-label">Precio</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_pre_ser" readonly name="mod_pre_ser">
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_fecha" class="col-sm-3 control-label">Fecha Documento</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_fecha" readonly ame="mod_fecha">
				</div>
			  </div>
                          <div class="form-group">
				<label for="fecha_emision" class="col-sm-3 control-label">Fecha Emision</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="fecha_emision" readonly name="fecha_emision">
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_doc_servicio" class="col-sm-3 control-label">Guia</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_doc_servicio" readonly name="mod_doc_servicio">
				</div>
			  </div>
                        <div class="form-group">
				<label for="mod_telefono1" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_telefono" readonly name="mod_telefono">
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_des_ser" class="col-sm-3 control-label">Diagnóstico</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_des_ser" readonly name="mod_des_ser" ></textarea>
				</div>
			  </div>
                          <div class="form-group">
				<label for="mod_datos" class="col-sm-3 control-label">Características</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_datos" readonly name="mod_datos" ></textarea>
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_com_ser" class="col-sm-3 control-label">Comentario Servicio</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_com_ser" name="mod_com_ser" ></textarea>
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_estado" class="col-sm-3 control-label">Registrar fecha del estado del Equipo</label>
				<div class="col-sm-8">
				 <select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="0">Sin Reparar</option>
                                        <option value="1" selected>Reparado</option>
					<option value="2" selected>Saliente</option>
                                        <option value="3" selected>Desechado</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="fecha_reparado" class="col-sm-3 control-label">Fecha Repación:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="fecha_reparado" readonly name="fecha_reparado">
				</div>
			  </div>
			 <div class="form-group">
				<label for="saliente" class="col-sm-3 control-label">Fecha Equipo Saliente</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="saliente" readonly name="saliente">
				</div>
			  </div>
                         <div class="form-group">
				<label for="desechado" class="col-sm-3 control-label">Fecha Equipo Desechado</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="desechado" readonly name="desechado">
				</div>
			  </div>
                        <div class="form-group">
				<label for="cerrado" class="col-sm-3 control-label">Cerrar Reparación</label>
				<div class="col-sm-8">
				 <select class="form-control" id="cerrado" name="cerrado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="0">Sin Cerrar</option>
                                        <option value="1" selected>Cerrado</option>
					
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