
<?php
//
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoClientece" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="myModalLabel"><font color="black">Agregar nuevo cliente C.E.</font></h5>
		  </div>
                      
                    
                  <div id="resultados_ajax"></div> 
		  <div class="modal-body">  
			<form class="form-horizontal" method="post" id="guardar_cliente_ce" name="guardar_cliente_ce" autocomplete="off">

				<div class="form-group hidden">
				<label for="estado" class="col-sm-3 control-label">Tipo *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="tipo" name="tipo" required>
					<!--<option value="">-- Selecciona tipo de doc --</option>
					<option value="2">RUC</option>-->
					<!--<option value="1">DNI</option>-->
					<option value="3">Carnet Extranjería</option>
				  </select>
				</div>
			  </div>

			  <div class="form-group">
				<label for="doc" class="col-sm-3 control-label">Documento *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					    <input type="text" class="form-control" name="doc" id="cedcliente" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Carnet Extranjeria de Cliente" required>
				</div>
			  </div>
                            <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombres *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control"  id="nomcliente" name="nombre" placeholder="Nombres" required onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div> 
                          
                         
			  <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Email</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="email" class="form-control" id="email" name="email" placeholder="Email" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>
                          <div class="form-group hidden">
				<label for="departamento" class="col-sm-3 control-label">Departamento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div> 
                           <div class="form-group hidden">
				<label for="provincia" class="col-sm-3 control-label">Provincia</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="provincia" name="provincia" placeholder="Provincia" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div> 
                          <div class="form-group hidden">
				<label for="distrito" class="col-sm-3 control-label">Distrito</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="distrito" name="distrito" placeholder="Distrito" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>  
			  <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="direccion_cliente" name="direccion" placeholder="Dirección" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>
                          <div class="form-group hidden">
				<label for="cuenta" class="col-sm-3 control-label">Cuenta Bancaria</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input class="form-control" id="cuenta" name="cuenta"   maxlength="255" placeholder="Cuenta Bancaria" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div> 
                           <div class="form-group hidden">
				<label for="ven" class="col-sm-3 control-label">Vendedor</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="ven" name="ven" placeholder="Vendedor" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div>   
			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>	
		  </div>
		  <div class="modal-footer">
			<button type="reset" class="btn btn-warning">Limpiar</button>
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



