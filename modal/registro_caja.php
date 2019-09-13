	<!doctype html>
<html lang="en">
<head>
<script>
  function limpiarFormulario() {
    document.getElementById("guardar_caja").reset();
  }
</script>
</head>
<?php
      date_default_timezone_set('America/Santiago');    
      $fecha=date("Y-m-d");
      $tienda1=$_SESSION['tienda'];          
      $id_caja=0;
                $sql2="select * from caja where fecha='$fecha' and tienda=$tienda1";
                $rs1=mysqli_query($con,$sql2);
                $row3=mysqli_fetch_array($rs1);
                $id_caja=$row3["id_caja"];
                
  
		if (isset($con))
		{
	
        ?>
 
        <body>  
            
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	
            <div class="modal-dialog" role="document">
          
		<div class="modal-content">
              
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title" id="myModalLabel">Apertura de caja</h5>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_caja" name="guardar_caja" autocomplete="off">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nom_cat" class="col-sm-3 control-label">Fecha</label>
				<div class="col-sm-8">
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date("Y-m-d");?>" readonly required>
				</div>
			  </div>
                          <?php
                          if($id_caja==0 or $id_caja==""){
                              ?>
                          <div class="form-group">
				<label for="des_cat" class="col-sm-3 control-label">Inicio de caja en S/.</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="inicio" name="inicio" placeholder="Solo número de dos decimales" required onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>    
                          <?php    
                          }
                          ?>
			  
               
		  </div>
                    <?php
                          if($id_caja==0 or $id_caja==""){
                              ?>
		  <div class="modal-footer">
                       <button type="button" class="btn btn-default" onclick="limpiarFormulario()">Limpiar</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Abrir Caja</button>
		  </div>
                     <?php    
                          }else{
                          ?>
                     <div class="modal-header" style="background: red;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title" id="myModalLabel" style="text-align: center; color: #fff;"> La caja ha sido aperturada o cerrada.</h5>
		  </div>
                    
                    <?php
                          }
                          ?>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>

            </body>
            
</html>