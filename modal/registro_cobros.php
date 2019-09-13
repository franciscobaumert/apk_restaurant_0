	<?php
        
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content" style="background: #F5ECCE;">
		  <div class="modal-header" style="background: #58FAAC;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Realizar cobro</font></h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="nuevo_cobros" name="nuevo_cobros">
			<div id="resultados_ajax2"></div>
			  <div class="form-group">
				<label for="mod_factura" class="col-sm-3 control-label">Factura</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_factura" name="mod_factura"  disabled>
					<input type="hidden" name="mod_id" id="mod_id">
                                        <input type="hidden" name="mod_cliente" id="mod_cliente">
                                        
				</div>
			  </div>
                        <div class="form-group">
				<label for="mod_mon" class="col-sm-3 control-label">Moneda</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_mon" name="mod_mon"  readonly>
					
				</div>
			  </div>
                        <div class="form-group">
				<label for="mod_deuda" class="col-sm-3 control-label">Deuda</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" id="mod_deuda" name="mod_deuda"  readonly="">
					
				</div>
			  </div>
                      
                        <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Nro Documento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="numero_factura" name="numero_factura" placeholder="Nro del documento" required>
				</div>
			  </div>
                        
                        <div class="form-group">
				<label for="vendedor" class="col-sm-3 control-label">Tipo de comprobante</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="estado_factura" name="estado_factura" required>
					<option value="">-- Selecciona Tipo de Comprobante --</option>
                                        <?php                
                                        $sql2="select * from comprobante_pago ";
                                        $i=0;
                                        $rs1=mysqli_query($con,$sql2);
                                        while($row3=mysqli_fetch_array($rs1)){
                                            $nom_cat=$row3["des_comprobante"];
                                            $id_categoria=$row3["id_comprobante"];
                                            ?>
                                            <option value="<?php  echo $id_categoria;?>"><?php  echo $nom_cat;?></option>
                                            <?php
                                            $i=$i+1;
                                        }          
                        ?>
                        </select>
				</div>
			</div>
                        <div class="form-group">
                            <label for="mod_deuda" class="col-sm-3 control-label">Cobro en</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class='form-control input-sm' id="condiciones" name="condiciones" required>
                                    <option value="1">Efectivo</option>
                                    <option value="2">Cheque</option>
                                    <option value="3">Transferencia bancaria</option>
									
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
				<label for="mod_pago" class="col-sm-3 control-label">Cantidad a Cobrar</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_pago" name="mod_pago" title="Ingresa sólo números con 0 ó 2 decimales" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" required>
					
				</div>
			</div>
			<div class="form-group">
				<label for="mod_obs" class="col-sm-3 control-label">Observaciones:</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <textarea  rows="4" class="form-control" id="mod_obs" name="mod_obs"></textarea>
					
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