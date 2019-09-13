<?php
	include('is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['mod_cat'])){
			$errors[] = "Nombre de la sala vacía";
	} 
        else if (
            !empty($_POST['mod_cat'])//&&
            //!empty($_POST['mod_des'])
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$nombre_sala=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cat"],ENT_QUOTES)));
		//$des=mysqli_real_escape_string($con,(strip_tags($_POST["mod_des"],ENT_QUOTES)));
        $id_sala=$_POST['mod_id'];
		$sql="UPDATE salas SET nombre_sala='".$nombre_sala."' WHERE id_sala='".$id_sala."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){ ?>
				<script>
					toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.success("Sala actualizada","Exito");
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