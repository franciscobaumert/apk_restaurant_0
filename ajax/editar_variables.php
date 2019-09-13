<?php
	include('is_logged.php');
	
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['mod_variables'])){
			$errors[] = "Nombre de la variable vacía";
		} 
                else if (
			
			!empty($_POST['mod_variables'])&&
			!empty($_POST['mod_des_var'])
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$variables=mysqli_real_escape_string($con,(strip_tags($_POST["mod_variables"],ENT_QUOTES)));
		$des_var=mysqli_real_escape_string($con,(strip_tags($_POST["mod_des_var"],ENT_QUOTES)));
		$cod_var=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cod_var"],ENT_QUOTES)));
                $col_var=mysqli_real_escape_string($con,(strip_tags($_POST["mod_col_var"],ENT_QUOTES)));
		$id_laboral=$_POST['mod_id'];
		$sql="UPDATE laborales SET variables='".$variables."',des_var='".$des_var."' ,cod_var='".$cod_var."',col_var='".$col_var."' WHERE id_laboral='".$id_laboral."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Variable ha sido actualizada satisfactoriamente.";
			} else{
                            $errors []= "Variable duplicada.";
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