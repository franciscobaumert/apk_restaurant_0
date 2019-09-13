<?php  
if (isset($con))
{
$sql3="select * from datosempresa ";
$rs2=mysqli_query($con,$sql3);
while($row4=mysqli_fetch_array($rs2)){
    $dolar=$row4["dolar"];
}        
?>
<head>
<script> 
function multiplicar(){
m1 = document.getElementById("multiplicando1").value;
m2 = document.getElementById("mod_costo").value;
m3 = document.getElementById("utilidad").value;
r = m1*m2;
var r1 = r.toFixed(2);
document.getElementById("soles").value = r1;

r2=document.getElementById("soles").value;
r3=1*r2+1*m3;

var r4 = r3.toFixed(2);
document.getElementById("mod_precio").value = r4;
}
</script> 
<script>
var mostrarValor = function(x){
    if (x>0){
        x1=1;                 
                        }
    else{
        x1=<?php echo $dolar;?>;                  
    }
     
    document.getElementById('multiplicando1').value=x1;
    m2 = document.getElementById("mod_costo").value;
    m3 = document.getElementById("utilidad").value;
    r = x1*m2;
    var r1 = r.toFixed(2);
    document.getElementById("soles").value = r1;
    r2=document.getElementById("soles").value;
    r2=1*r2+1*m3;
    var r3 = r2.toFixed(2);
    document.getElementById("mod_precio").value = r3;
   
};                         
</script>
</head>
    <body>  
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="myModalLabel"><font color="black">Editar producto</font></h5>
		  </div>
                  <div id="resultados_ajax2"></div>
		  <div class="modal-body" style="height:450px;overflow-y: scroll;">
			<form class="form-horizontal" method="post" id="editar_producto" name="editar_producto" autocomplete="off">
			
			  <div class="form-group">
				<label for="mod_codigo" class="col-sm-3 control-label">Código *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_codigo" name="mod_codigo" placeholder="Código del producto" required onKeyUp="this.value=this.value.toUpperCase();">  
                                  <input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			   <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Nombre *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Nombre del producto" required onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div>
			<div class="form-group">
				<label for="mod_cat" class="col-sm-3 control-label">Categoria *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_cat" name="mod_cat" required>
					<option value="">-- Selecciona categoria de producto --</option>
					
                                         <?php
                                        $nom = array();
                                        $sql2="select * from categorias ";
                                        $rs1=mysqli_query($con,$sql2);
                                        while($row3=mysqli_fetch_array($rs1)){
                                            $nom_cat=$row3["nom_cat"];
                                            $id_categoria=$row3["id_categoria"];
                                        ?>

                                        <option value="<?php echo $id_categoria;?>"><?php  echo $nom_cat;?></option>

                                        <?php
                                        }         
                                        ?>              
				  </select>
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_destino" class="col-sm-3 control-label">Destino *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_destino" name="mod_destino" required>
				 	<option value="">-- Selecciona destino --</option>
					<?php
                                        
                                        $sql3="select * from destino ";
                                        $rs3=mysqli_query($con,$sql3);
                                        while($row4=mysqli_fetch_array($rs3)){
                                            $nombre_destino=$row4["nombre_destino"];
                                            $id_destino=$row4["id_destino"];
                                        ?>

                                        <option value="<?php echo $id_destino;?>"><?php  echo $nombre_destino;?></option>

                                        <?php
                                        }         
                                        ?>    
				  </select>
				</div>
			  </div>

                          <div class="form-group">
				<label for="mod_cat" class="col-sm-3 control-label">Und/Medida *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_und_pro" name="mod_und_pro" required>
					<option value="">-- Selecciona und/medida de producto --</option>
					
                                         <?php
                                        
                                        $sql3="select * from und ";
                                        $rs3=mysqli_query($con,$sql3);
                                        while($row4=mysqli_fetch_array($rs3)){
                                            $nom_und=$row4["nom_und"];
                                            $id_und=$row4["id_und"];
                                        ?>

                                        <option value="<?php echo $id_und;?>"><?php  echo $nom_und;?></option>

                                        <?php
                                        }         
                                        ?>              
				  </select>
				</div>
			  </div>  
                            
                        <div class="form-group">
				<label for="mod_status" class="col-sm-3 control-label">Tipo de producto *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				 <select class="form-control" id="mod_status" name="mod_status" required>
					<option value="">-- Selecciona tipo de producto --</option>
					<option value="1" selected>De venta</option>
					<!--<option value="0">De segunda</option>-->
                                        <option value="2">Insumo</option>
				  </select>
				</div>
			</div>

			<div class="form-group hidden">
				<label for="mod_options" class="col-sm-3 control-label">Opciones</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_options" name="mod_options" placeholder="Opciones de producto separadas por comas (por ejemplo: más queso, cocinar bien, etc ...)" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div>

                        <div class="form-group">
				<label for="mod_costo" class="col-sm-3 control-label">Costo *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" onChange="multiplicar();" id="mod_costo" name="mod_costo" placeholder="Precio de costo del producto" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
                       
			
                        <div class="form-group">
				<label for="mod_precio" class="col-sm-3 control-label">Precio *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" id="mod_precio" name="mod_precio" placeholder="Precio 1" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8"  onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
                            
                       
                        
                       
                        <div class="form-group">
				<label for="mod_marca" class="col-sm-3 control-label">Marca</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_marca" name="mod_marca" placeholder="Marca" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			</div>
                        <div class="form-group">
				<label for="mod_modelo" class="col-sm-3 control-label">Modelo</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_modelo" name="mod_modelo" placeholder="Modelo" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div>
                        <div class="form-group">
				<label for="mod_color" class="col-sm-3 control-label">Color</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" class="form-control" id="mod_color" name="mod_color" placeholder="Color" onKeyUp="this.value=this.value.toUpperCase();">
				</div>
			  </div>
                        <?php 
                        $aa="";
                        if($_SESSION['user_id']<>1){
                            $aa="readonly";
                        }
                        ?>
                        
                         <div class="form-group">
				<label for="mod_inv" class="col-sm-3 control-label">Inventario *</label>
				<div class="col-md-8 col-sm-8 col-xs-12">
				  <input type="text" <?php echo "$aa";?> class="form-control" id="mod_inv" name="mod_inv" placeholder="Precio de costo del producto" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" onKeyUp="this.value=this.value.toUpperCase();">
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
</body>