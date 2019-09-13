<?php
        include('is_logged.php');		
	if (empty($_POST['firstname2'])){
            $errors[] = "Nombres vacíos";
	}  elseif (empty($_POST['user_name2'])) {
            $errors[] = "Nombre de usuario vacío";
        }  elseif (strlen($_POST['user_name2']) > 64 || strlen($_POST['user_name2']) < 2) {
           $errors[] = "Nombre de usuario no puede ser inferior a 2 o más de 64 caracteres";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name2'])) {
            $errors[] = "Nombre de usuario no encaja en el esquema de nombre: Sólo aZ y los números están permitidos , de 2 a 64 caracteres";
        }   elseif (
			!empty($_POST['user_name2'])
			&& !empty($_POST['firstname2'])
			
            && strlen($_POST['user_name2']) <= 64
           && strlen($_POST['user_name2']) >= 2
           && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name2'])
           
          )
         {
            require_once ("../config/db.php");
            require_once ("../config/conexion.php");
            $firstname = mysqli_real_escape_string($con,(strip_tags($_POST["firstname2"],ENT_QUOTES)));
            $user_name = mysqli_real_escape_string($con,(strip_tags($_POST["user_name2"],ENT_QUOTES)));
            $user_email = mysqli_real_escape_string($con,(strip_tags($_POST["user_email2"],ENT_QUOTES)));
            $user_id=intval($_POST['mod_id']);
            $sucursal = $_POST['mod_sucursal'];
            $dni=$_POST['mod_dni'];
            $domicilio=$_POST['dom'];
            $telefono=$_POST['tel'];
            $hora=$_POST['hora'];
            $sql = "UPDATE users SET hora='".$hora."',nombres='".$firstname."', user_name='".$user_name."', user_email='".$user_email."', dni='".$dni."', domicilio='".$domicilio."', telefono='".$telefono."', sucursal='".$sucursal."'
            WHERE user_id='".$user_id."';";
            $query_update = mysqli_query($con,$sql);
                    if ($query_update) { ?>
                        <script>
                            toastr.options = {
                            "closeButton":false,
                            "progressBar": false
                        };
                        toastr.success("Usuario actualizado","Exito");
                        </script>
                    <?php } else { ?>
                        <script>
                            toastr.options = {
                            "closeButton":false,
                            "progressBar": false
                        };
                        toastr.warning("Usuario duplicado","Precaucion");
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