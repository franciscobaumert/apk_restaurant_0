<?php
        include('is_logged.php');
	
	if (empty($_POST['nombre_mesa'])) {
           $errors[] = "Mesa vacía";
        } else if (empty($_POST['nombre_mesa'])){
			$errors[] = "Nombre de la mesa vacía";
		} 
                else if (
			!empty($_POST['nombre_mesa']) &&
			!empty($_POST['id_sala']) 
		){
		
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");

		date_default_timezone_set('America/Santiago');
		
		$nombre_mesa=mysqli_real_escape_string($con,(strip_tags($_POST["nombre_mesa"],ENT_QUOTES)));
		$id_sala=mysqli_real_escape_string($con,(strip_tags($_POST["id_sala"],ENT_QUOTES)));
		$mesa_creada=date('Y-m-d H:i:s');
		$status_mesa=0;
		$tienda1=$_SESSION['tienda'];
		$sql="INSERT INTO mesas (id_sala, nombre_mesa, mesa_creada, status_mesa, tienda) VALUES ('$id_sala','$nombre_mesa','$mesa_creada','$status_mesa','$tienda1')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){ ?>
				<script>
						toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.success("Mesa registrada","Exito");
				</script>
			<?php } else{ ?>
				<script>
						toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.warning("Mesa duplicada","Precaucion");
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