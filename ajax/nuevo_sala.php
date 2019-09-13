<?php
        include('is_logged.php');
	
	if (empty($_POST['nombre_sala'])) {
           $errors[] = "Sala vacía";
        } else if (empty($_POST['nombre_sala'])){
			$errors[] = "Nombre de la sala vacía";
		} 
                else if (
			!empty($_POST['nombre_sala']) //&&
			//!empty($_POST['des_cat']) 
		){
		
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");

		date_default_timezone_set('America/Santiago');
		
		$nombre_sala=mysqli_real_escape_string($con,(strip_tags($_POST["nombre_sala"],ENT_QUOTES)));
		$sala_creada=date('Y-m-d H:i:s');
		$tienda1=$_SESSION['tienda'];
		//$des_cat=mysqli_real_escape_string($con,(strip_tags($_POST["des_cat"],ENT_QUOTES)));
		$sql="INSERT INTO salas (nombre_sala, sala_creada, tienda) VALUES ('$nombre_sala','$sala_creada','$tienda1')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){ ?>
				<script>
					toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.success("Sala registrada","Exito");
				</script>
			<?php } else{ ?>
				<script>
					toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.warning("Sala duplicada","Precaucion");
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