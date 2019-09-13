<?php
	include('is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['mod_nombre'])){
			$errors[] = "Nombre del servicio vacío";
		} 
                else if (
			
			!empty($_POST['mod_codigo'])&&
			!empty($_POST['mod_nombre'])
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$nombre_producto=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$codigo_producto=mysqli_real_escape_string($con,(strip_tags($_POST["mod_codigo"],ENT_QUOTES)));
                $id_producto=$_POST['mod_id'];
		$sql="UPDATE products SET nombre_producto='".$nombre_producto."',codigo_producto='".$codigo_producto."'WHERE id_producto='".$id_producto."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Servicio ha sido actualizado satisfactoriamente.";
			} else{
                            $errors []= "Servicio duplicado.";
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