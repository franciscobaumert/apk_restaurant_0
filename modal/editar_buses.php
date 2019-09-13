<?php
if (isset($con))
{
?>
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content" style="background: #F5ECCE;">
                   <div class="modal-header" style="background: #58FAAC;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Editar Buses</font></h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_buses" name="editar_buses" >
			<div id="resultados_ajax"></div>
                        <div class="form-group">
				<label  class="col-sm-3 control-label">Nro de Bus:</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" name="mod_buses" id="mod_buses" required>
				</div>
			  </div>
                 	<div class="form-group">
				<label  class="col-sm-3 control-label">Placa:</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" name="mod_placa" id="mod_placa" required>
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