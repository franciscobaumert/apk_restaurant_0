<?php
	include('is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['mod_nombre'])){
			$errors[] = "Nombre de la categoria vacía";
	} 
        else if (
            !empty($_POST['mod_nombre'])&&
            !empty($_POST['mod_cat'])
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$nombre_mesa=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$id_sala=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cat"],ENT_QUOTES)));
        $id_mesa=$_POST['mod_id'];
		$sql="UPDATE mesas SET nombre_mesa='".$nombre_mesa."',id_sala='".$id_sala."'WHERE id_mesa='".$id_mesa."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){ ?>
				<script>
						toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.success("Mesa actualizada","Exito");
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