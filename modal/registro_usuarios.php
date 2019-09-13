	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
        <script>
  function limpiarFormulario() {
    document.getElementById("guardar_usuario").reset();
  }
</script>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="myModalLabel"><font color="black">Nuevo usuario</font></h5>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_usuario" name="guardar_usuario" autocomplete="off">
			
                        <div id="resultados_ajax"></div>
			<div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Nombres *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Nombres" required onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
			<div class="form-group">
				<label for="user_name" class="col-sm-3 control-label">Usuario *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)"required onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
			<div class="form-group">
				<label for="user_email" class="col-sm-3 control-label">Email</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Correo electrónico" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
                        <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Telefonos</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefonos"  onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
                            
                        <div class="form-group">
				<label for="domicilio" class="col-sm-3 control-label">Domicilio</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="domicilio" name="domicilio" placeholder="Domiclio"  onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>

			<div class="form-group">
			  
				<label for="dni" class="col-sm-3 control-label">DNI</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI"  onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
			<div class="form-group">
				<label for="user_password_new" class="col-sm-3 control-label">Contraseña *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="password" class="form-control" id="user_password_new" name="user_password_new" placeholder="Contraseña" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required onKeyUp="this.value=this.value.toUpperCase();">
				</div>

			</div>

			<div class="form-group">
			 
				<label for="user_password_repeat" class="col-sm-3 control-label">Repetir *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="password" class="form-control" id="user_password_repeat" name="user_password_repeat" placeholder="Repite contraseña" pattern=".{6,}" required onKeyUp="this.value=this.value.toUpperCase();">
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