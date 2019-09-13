<?php
	include('is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_codigo'])) {
           $errors[] = "Código vacío";
        } 
        else if ($_POST['mod_status']==""){
			$errors[] = "Selecciona el tipo de producto";
		}
        
         else if ($_POST['mod_cat']==""){
			$errors[] = "Selecciona la categoria";
		}       
          
                
        else if (empty($_POST['mod_nombre'])){
			$errors[] = "Nombre del producto vacío";
		}  else if (empty($_POST['mod_precio'])){
			$errors[] = "Precio de venta vacío";
		} else if (empty($_POST['mod_costo'])){
			$errors[] = "Precio de costo vacío";
		}
                else if ($_POST['mod_inv']<0){
			$errors[] = "Inventario no valido";
		}
                
                else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_codigo']) &&
			!empty($_POST['mod_nombre']) &&
                        
                        $_POST['mod_status']!="" &&
                        $_POST['mod_cat']!="" &&
			!empty($_POST['mod_precio'])&&
			!empty($_POST['mod_costo'])
		){

		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
                $codigo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_codigo"],ENT_QUOTES)));
		$marca=mysqli_real_escape_string($con,(strip_tags($_POST["mod_marca"],ENT_QUOTES)));
                $modelo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_modelo"],ENT_QUOTES)));
                $color=mysqli_real_escape_string($con,(strip_tags($_POST["mod_color"],ENT_QUOTES)));
                $estado=intval($_POST['mod_status']);
                $mon_costo=1;
                $mon_venta=1;
		$precio_venta=floatval($_POST['mod_precio']);
                
                $costo=floatval($_POST['mod_costo']);
                $dolar=1;
                $precio_costo=$costo*$dolar;
                $cat_pro=intval($_POST['mod_cat']);
                $destino=intval($_POST['mod_destino']);
                $options=mysqli_real_escape_string($con,(strip_tags($_POST["mod_options"],ENT_QUOTES)));
                $und_pro=intval($_POST['mod_und_pro']);
                $inv=intval($_POST['mod_inv']);
                $tienda=$_SESSION['tienda'];
                $b="b".$tienda;
		$id_producto=$_POST['mod_id'];
		$sql="UPDATE products SET cat_pro='".$cat_pro."',nombre_producto='".$nombre."', codigo_producto='".$codigo."',status_producto='".$estado."', precio_producto='".$precio_venta."', costo_producto='".$precio_costo."' , marca='".$marca."', modelo='".$modelo."', color='".$color."',$b='".$inv."',mon_costo='".$mon_costo."',mon_venta='".$mon_venta."',und_pro='".$und_pro."', destino='".$destino."', options='".$options."' WHERE id_producto='".$id_producto."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){ ?>
				<script>
					toastr.options = {
				"closeButton":false,
				"progressBar": false
			};
			toastr.success("Producto actualizado","Exito");
				</script>
			<?php } else{ ?>
				<script>
					toastr.options = {
				"closeButton":false,
				"progressBar": false
			};
			toastr.warning("Codigo duplicado $sql","Precaucion");
				</script>
			<?php }
		} else { ?>
			<script>
					toastr.options = {
				"closeButton":false,
				"progressBar": false
			};
			toastr.error("Error desconocido","Error");
				</script>
		<?php }
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>