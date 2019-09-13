	<!doctype html>
<html lang="en">
<head>
<script>
  function limpiarFormulario() {
    document.getElementById("guardar_sucursal").reset();
  }
</script>
 <style type="text/css"> 
.thumb {
            height: 100px;
            width:170px;
            border: 1px solid #000;
            margin: 10px 5px 0 0;
          }
</style> 
</head>

<?php
       
        if (isset($con))
	{
	?>
  
          <body>  
            
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	     
            <div class="modal-dialog" role="document">
              
		<div class="modal-content">
                   
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title" id="myModalLabel">Agregar nueva Tienda</h5>
		  </div>
		  <div class="modal-body" style="height:450px;overflow-y: scroll;">
			<form class="form-horizontal" action="" enctype="multipart/form-data" method="post" id="guardar_sucursal" name="guardar_sucursal" autocomplete="off">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="nom_cat" name="nombre" placeholder="Nombre de la sucursal" required onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div>
			  <div class="form-group">
				<label for="ruc" class="col-sm-3 control-label">Ruc</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="ruc" name="ruc" placeholder="ruc" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>
                        
                        <?php
                        $sql2="select * from sucursal ";
                        $rs1=mysqli_query($con,$sql2);
                        $row3=mysqli_fetch_array($rs1);
                        $tienda=$row3["tienda"]+1;
                        ?>
                        <input type="hidden" nombre="mod_tienda" id="mod_tienda" value="<?php echo $tienda;?>" >
                      
                        <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Direccion</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="direccion" name="direccion" placeholder="direccion" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>
                        <div class="form-group">
				<label for="correo" class="col-sm-3 control-label">Correo</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="correo" name="correo" placeholder="correo" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>
			 
			<div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Telefono</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>
                         <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Departamento</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>
                         <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Provincia</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="provincia" name="provincia" placeholder="Provincia" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>
                         <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Distrito</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="distrito" name="distrito" placeholder="Distrito" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>
                        
                        
                        <div class="form-group">
				<label for="ubigeo" class="col-sm-3 control-label">Ubigeo</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
					<input type="text" class="form-control" id="ubigeo" name="ubigeo" placeholder="ubigeo" onKeyUp="this.value=this.value.toUpperCase();">
				  
				</div>
			  </div>
		  </div>
		  <div class="modal-footer">
                       <button type="button" class="btn btn-warning" onclick="limpiarFormulario()">Limpiar</button>
			<button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>
      </body>
        <script>
        
         function archivo(evt) {
			var files = evt.target.files; // FileList object
		
			// Obtenemos la imagen del campo "file".
			for (var i = 0, f; f = files[i]; i++) {
			  //Solo admitimos imágenes.
			  if (!f.type.match('image.*')) {
				continue;
			  }
		
			  var reader = new FileReader();
		
			  reader.onload = (function(theFile) {
				return function(e) {
				  // Insertamos la imagen
				 document.getElementById("list").innerHTML = ['<img  class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
				};
			  })(f);
		
			  reader.readAsDataURL(f);
			}
		  }
        document.getElementById('files').addEventListener('change', archivo, false);
        </script>    
</html>