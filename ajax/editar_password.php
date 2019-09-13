<?php
include('is_logged.php');	
	if (empty($_POST['user_id_mod'])){
            $errors[] = "ID vacío";
	}  elseif (empty($_POST['user_password_new3']) || empty($_POST['user_password_repeat3'])) {
            $errors[] = "Contraseña vacía";
        } elseif ($_POST['user_password_new3'] !== $_POST['user_password_repeat3']) { ?>
            <script>
				toastr.options = {
				"closeButton":false,
				"progressBar": false
			};
			toastr.warning("Las contraseñas no coinciden","Precaucion");
			</script>
        <?php }  elseif (
			 !empty($_POST['user_id_mod'])
			&& !empty($_POST['user_password_new3'])
            && !empty($_POST['user_password_repeat3'])
            && ($_POST['user_password_new3'] === $_POST['user_password_repeat3'])
        ) {
            require_once ("../config/db.php");
			require_once ("../config/conexion.php");
                    $user_id=intval($_POST['user_id_mod']);
                    $user_password = $_POST['user_password_new3'];
                    $sql = "UPDATE users SET clave='".$user_password."' WHERE user_id='".$user_id."'";
                    $query = mysqli_query($con,$sql);
                    if ($query) { ?>
                        <script>
							toastr.options = {
							"closeButton":false,
							"progressBar": false
						};
						toastr.success("Contraseña actualizada","Exito");
						</script>
                    <?php } else { ?>
                        <script>
								toastr.options = {
							"closeButton":false,
							"progressBar": false
						};
						toastr.warning("Fallo inesperado, intentelo nuevamente","Error");
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