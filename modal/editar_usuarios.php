	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document" >
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="myModalLabel"><font color="black">Editar usuario</font></h5>
		  </div>
		  <div class="modal-body">
                       
			<form class="form-horizontal" method="post" id="editar_usuario" name="editar_usuario" autocomplete="off">
			<div id="resultados_ajax2"></div>
			<div class="form-group">
				<label for="firstname2" class="col-sm-3 control-label">Nombres *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="firstname2" name="firstname2" placeholder="Nombres" required onKeyUp="this.value=this.value.toUpperCase();">
				  <input type="hidden" id="mod_id" name="mod_id">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="user_name2" class="col-sm-3 control-label">Usuario *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="user_name2" name="user_name2" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)"required onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div>
                        
			  <div class="form-group">
				<label for="user_email2" class="col-sm-3 control-label">Email</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="email" class="form-control" id="user_email2" name="user_email2" placeholder="Correo electrónico" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div>
			 <div class="form-group">
				<label for="dom" class="col-sm-3 control-label">Domicilio</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="dom" name="dom" placeholder="Domicilio" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div>
                         <div class="form-group">   
                                <label for="dni" class="col-sm-3 control-label">DNI</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_dni" name="mod_dni" placeholder="DNI" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
			<div class="form-group">
				<label for="tel" class="col-sm-3 control-label">Telefono</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="tel" name="tel" placeholder="telefono" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
                        <div class="form-group">
				<label for="hora_entrada" class="col-sm-3 control-label">Hora de Entrada</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="time" class="form-control" id="hora" name="hora" placeholder="Hora de Entrada" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
			  
			  <div class="form-group">
				<label for="hora_entrada" class="col-sm-3 control-label">Tienda *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <select class="form-control col-md-10" id="mod_sucursal" name="mod_sucursal" required="required" tabindex="-1" required>
                            <?php
                            if($tiend>0){
                                
                                if($tiend==7){
                                    $t="Todas";
                                }else{
                                    $t="Tienda $tiend";
                                }
                                
                                ?>
                               <option value="<?php echo $tiend; ?>" ><?php echo $t; ?></option>
                            <?php
                               }else{
                                  ?>
                               <option value="" >Seleccionar</option>
                            <?php  
                               }
                             
                               for($i=1 ;$i<=$tienda1;$i++){
                                ?>
                                    <option value="<?php echo $i;?>" >Tienda <?php echo $i;?></option>              
                               <?php
        
                            }
                               
                               
                            ?>
                                                                                      
                        
                           </select>
				</div>
			</div>
                        <script>   
                        function capturar()
                        {
    
                         document.getElementById("valor").checked = true;    
                        }
                        </script> 

             <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" onclick="capturar()" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		  </div>
		  
		</div>
	  </div>
	</div>
	<?php
		}
	?>