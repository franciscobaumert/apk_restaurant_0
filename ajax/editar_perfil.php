<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nom_emp'])) {
           $errors[] = "Nombre de empresa esta vacío";
        }else if (empty($_POST['des_emp'])) {
           $errors[] = "Teléfono esta vacío";
        } else if (empty($_POST['mis_emp'])) {
           $errors[] = "E-mail esta vacío";
        } else if (empty($_POST['vis_emp'])) {
           $errors[] = "IVA esta vacío";
        } else if (empty($_POST['dir_emp'])) {
           $errors[] = "Moneda esta vacío";
        } else if (empty($_POST['tel_emp'])) {
           $errors[] = "Dirección esta vacío";
        } else if (empty($_POST['email_emp'])) {
           $errors[] = "Dirección esta vacío";
        }   else if (
			!empty($_POST['nom_emp']) &&
			!empty($_POST['des_emp']) &&
			!empty($_POST['mis_emp']) &&
			!empty($_POST['vis_emp']) &&
			!empty($_POST['dir_emp']) &&
			!empty($_POST['tel_emp']) &&
			!empty($_POST['email_emp']) 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nom_emp=mysqli_real_escape_string($con,(strip_tags($_POST["nom_emp"],ENT_QUOTES)));
		$des_emp=mysqli_real_escape_string($con,(strip_tags($_POST["des_emp"],ENT_QUOTES)));
		$mis_emp=mysqli_real_escape_string($con,(strip_tags($_POST["mis_emp"],ENT_QUOTES)));
		$vis_emp=mysqli_real_escape_string($con,(strip_tags($_POST["vis_emp"],ENT_QUOTES)));
		$dir_emp=mysqli_real_escape_string($con,(strip_tags($_POST["dir_emp"],ENT_QUOTES)));
		$tel_emp=mysqli_real_escape_string($con,(strip_tags($_POST["tel_emp"],ENT_QUOTES)));
		$email_emp=mysqli_real_escape_string($con,(strip_tags($_POST["email_emp"],ENT_QUOTES)));
		$face_emp=mysqli_real_escape_string($con,(strip_tags($_POST["face_emp"],ENT_QUOTES)));
		$tiwter_emp=mysqli_real_escape_string($con,(strip_tags($_POST["tiwter_emp"],ENT_QUOTES)));
		$youtube_emp=mysqli_real_escape_string($con,(strip_tags($_POST["youtube_emp"],ENT_QUOTES)));
		$linkedin_emp=mysqli_real_escape_string($con,(strip_tags($_POST["linkedin_emp"],ENT_QUOTES)));
		$comentario1=mysqli_real_escape_string($con,(strip_tags($_POST["comentario1"],ENT_QUOTES)));
		$comentario2=mysqli_real_escape_string($con,(strip_tags($_POST["comentario2"],ENT_QUOTES)));
		$comentario3=mysqli_real_escape_string($con,(strip_tags($_POST["comentario3"],ENT_QUOTES)));
		$comentario4=mysqli_real_escape_string($con,(strip_tags($_POST["comentario4"],ENT_QUOTES)));
		$comentario5=mysqli_real_escape_string($con,(strip_tags($_POST["comentario5"],ENT_QUOTES)));
		
		$sql="UPDATE datosempresa SET nom_emp='".$nom_emp."', des_emp='".$des_emp."', mis_emp='".$mis_emp."', vis_emp='".$vis_emp."', dir_emp='".$dir_emp."', tel_emp='".$tel_emp."', email_emp='".$email_emp."', face_emp='".$face_emp."', tiwter_emp='$tiwter_emp', youtube_emp='$youtube_emp', linkedin_emp='$linkedin_emp', comentario1='$comentario1', comentario2='$comentario2', comentario3='$comentario3', comentario4='$comentario4', comentario5='$comentario5' WHERE id_emp='1'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){ ?>
				<script>
						toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.success("Datos actualizados","Exito");
				</script>
			<?php } else{ ?>
				<script>
						toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.error("Error inesperado","Error");
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