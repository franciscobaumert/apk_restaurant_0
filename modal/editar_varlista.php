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
                        <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i><font color="black"> Editar</font></h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_varlista" name="editar_varlista" autocomplete="off">
			<div id="resultados_ajax"></div>
                        
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Empleado</label>
				<div class="col-sm-8">
                                    
                                    <input type="hidden" name="mod_id" id="mod_id">
				 <select class="form-control" id="mod_nombre" name="mod_nombre" required >
					<option value="">-- Selecciona Empleado --</option>
                        <?php
                        $nom = array();
                        $sql2="select * from users ORDER BY  `users`.`nombres` ASC ";
                        $rs1=mysqli_query($con,$sql2);
                        while($row3=mysqli_fetch_array($rs1)){
                            if($tienda1==$row3["sucursal"]){
                                $user_id=$row3["user_id"];
                                $nombres=$row3["nombres"];
                                $hora=$row3["hora"];
                                ?>
                                <option value="<?php  echo $user_id;?>"><?php  echo $nombres;?> </option>
                                <?php
                            }
                        }                       
                        ?>
                                </select>
				</div>
			  </div>
                        <div class="form-group">
				<label  class="col-sm-3 control-label">Fecha:</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="date" class="form-control" name="mod_fecha_entrada" id="mod_fecha_entrada" required onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
                        <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Tipo de Variable</label>
				<div class="col-sm-8">
				 <select class="form-control" id="mod_cod_var" name="mod_cod_var" required >
					<option value="">-- Selecciona Variable --</option>
			
                        <?php
                            $sql2="select * from laborales ORDER BY  `laborales`.`variables` ASC ";
                            $rs1=mysqli_query($con,$sql2);
                            while($row3=mysqli_fetch_array($rs1)){
                                $id_laboral=$row3["id_laboral"];
                                if($id_laboral>0){
                                    $col_var=$row3["col_var"];
                                    $cod_var=$row3["cod_var"];
                                    $variables=$row3["variables"];
                                    $hora=$row3["hora"];
                                    ?>
                                    <option style="color:<?php  echo $col_var;?>" value="<?php  echo $id_laboral;?>"><?php  echo $cod_var ;?> </option>

                                    <?php

                            }
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