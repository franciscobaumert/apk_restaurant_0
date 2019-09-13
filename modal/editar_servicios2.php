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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Datos del Servicio al Equipo</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_servicios1" name="editar_servicios1">
			<div id="resultados_ajax2"></div>
			  <div class="form-group">
				<label for="mod_nombre_cliente" class="col-sm-3 control-label">Razon Social</label>
				<div class="col-sm-8">
                                    <input type="text" class="form-control" id="mod_nombre_cliente" name="mod_nombre_cliente"  readonly required>
					<input type="hidden" name="mod_id" id="mod_id">
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
				<label for="mod_fecha" class="col-sm-3 control-label">Fecha</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_fecha" readonly ame="mod_fecha">
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
				<label for="mod_cancelado" class="col-sm-3 control-label">Pago</label>
				<div class="col-sm-8">
				 <select class="form-control" id="mod_cancelado" name="mod_cancelado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="0">Sin Cancelar</option>
                                        <option value="1" selected>Cancelado</option>
					
				  </select>
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_estado" class="col-sm-3 control-label">Estado del Equipo</label>
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