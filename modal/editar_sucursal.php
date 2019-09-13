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
                        <h5 class="modal-title" id="myModalLabel"><font color="black">Editar Tienda</font></h5>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_sucursal" name="editar_sucursal" autocomplete="off">
			<div id="resultados_ajax2"></div>

			<div class="form-group">
				<label for="mod_ruc" class="col-sm-3 control-label">Ruc *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">

				<div class="input-group">
					  <input type="text" class="form-control"  id="mod_ruc" name="mod_ruc" placeholder="Ingrese RUC" onKeyUp="this.value=this.value.toUpperCase();" required>
					  <div id="botoncitoruc1" class="input-group-addon btn btn-default"><i class="fa fa-search nohidden1"></i><i class="fa fa-check ajaxgif1 hide"></i></div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Razon Social *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Razon Social" required onKeyUp="this.value=this.value.toUpperCase();">
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			</div>
			
			<div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Direccion *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_direccion" name="mod_direccion" placeholder="Direccion" required onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
                        <div class="form-group">
				<label for="mod_correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_correo" name="mod_correo" placeholder="Correo" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
                        <div class="form-group">
				<label for="mod_telefono" class="col-sm-3 control-label">Telefono</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_telefono" name="mod_telefono" placeholder="Telefono" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			 </div>
                        <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Departamento *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="mod_departamento" name="mod_departamento" placeholder="Departamento" onKeyUp="this.value=this.value.toUpperCase();" required>
				  
				</div>
			  </div>
                         <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Provincia *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="mod_provincia" name="mod_provincia" placeholder="Provincia" onKeyUp="this.value=this.value.toUpperCase();" required>
				  
				</div>
			  </div>
                         <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Distrito *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="mod_distrito" name="mod_distrito" placeholder="Distrito" onKeyUp="this.value=this.value.toUpperCase();" required>
				  
				</div>
			  </div>
                        
                        <div class="form-group">
				<label for="mod_ubigeo" class="col-sm-3 control-label">Ubigeo *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_ubigeo" name="mod_ubigeo" placeholder="Ubigeo" required onKeyUp="this.value=this.value.toUpperCase();">
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