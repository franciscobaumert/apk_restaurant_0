<?php
		if (isset($con))
		{
	?>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="myModalLabel"><font color="black">Editar proveedores</font></h5>
		  </div>
		  <div class="modal-body" style="height:450px;overflow-y: scroll;">
			<form class="form-horizontal" method="post" id="editar_proveedores" name="editar_proveedores" autocomplete="off">
			<div id="resultados_ajax2"></div>
			 <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Razon Social</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre" onKeyUp="this.value=this.value.toUpperCase();" required>
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
                        <div class="form-group">
				<label for="mod_doc" class="col-sm-3 control-label">Documento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" readonly id="mod_doc" name="mod_doc" placeholder="Nro de Documento">
				</div>
			</div>
                        <div class="form-group">
				<label for="mod_doc" class="col-sm-3 control-label">Tipo de doc</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" readonly id="mod_tipo" name="mod_tipo" >
				</div>
			</div>
			<div class="form-group">
				<label for="mod_telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_telefono" name="mod_telefono" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
			<div class="form-group">
				<label for="mod_email" class="col-sm-3 control-label">Email</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <input type="email" class="form-control" id="mod_email" name="mod_email" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			 </div>
			<div class="form-group">
				<label for="mod_departamento" class="col-sm-3 control-label">Departamento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="mod_departamento" name="mod_departamento" placeholder="Departamento" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			</div>
                        <div class="form-group">
				<label for="mod_provincia" class="col-sm-3 control-label">Provincia</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="mod_provincia" name="mod_provincia" placeholder="Provincia" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			</div> 
                        <div class="form-group">
				<label for="mod_distrito" class="col-sm-3 control-label">Distrito</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="mod_distrito" name="mod_distrito" placeholder="Distrito" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			</div>    
			<div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control" id="mod_direccion" name="mod_direccion"   maxlength="255" placeholder="Dirección" onKeyUp="this.value=this.value.toUpperCase();"></textarea>
				  
				</div>
			</div> 
                        <div class="form-group">
				<label for="mod_cuenta" class="col-sm-3 control-label">Cuenta Bancaria</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<textarea class="form-control" id="mod_cuenta" name="mod_cuenta"   maxlength="255" placeholder="Cuenta Bancaria" onKeyUp="this.value=this.value.toUpperCase();"></textarea>
				  
				</div>
			</div> 
                        <div class="form-group">
				<label for="mod_ven" class="col-sm-3 control-label">Vendedor</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_ven" name="mod_ven" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
			<div class="form-group">
				<label for="mod_estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>

	<?php
		}
	?>