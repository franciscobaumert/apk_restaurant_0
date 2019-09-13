<?php
        include('is_logged.php');
	if (empty($_POST['variables'])) {
           $errors[] = "Variable laboral vacía";
        } else if (empty($_POST['variables'])){
			$errors[] = "Nombre de la variable vacía";
		} 
                else if (
			!empty($_POST['variables']) &&
			!empty($_POST['des_var']) 	
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$variables=mysqli_real_escape_string($con,(strip_tags($_POST["variables"],ENT_QUOTES)));
		$des_var=mysqli_real_escape_string($con,(strip_tags($_POST["des_var"],ENT_QUOTES)));
		$cod_var=mysqli_real_escape_string($con,(strip_tags($_POST["cod_var"],ENT_QUOTES)));
                $col_var=mysqli_real_escape_string($con,(strip_tags($_POST["col_var"],ENT_QUOTES)));
		$sql="INSERT INTO laborales (cod_var,variables,des_var,col_var) VALUES ('$cod_var','$variables','$des_var','$col_var')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Variable laboral ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Variable laboral duplicada.";
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
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

