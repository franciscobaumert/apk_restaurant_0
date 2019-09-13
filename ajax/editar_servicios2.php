<?php
	include('is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if ($_POST['mod_estado']==""){
			$errors[] = "Selecciona el estado del Servicio";
		}  else if (
			!empty($_POST['mod_id']) &&
			
			$_POST['mod_estado']!="" 
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$com_ser=mysqli_real_escape_string($con,(strip_tags($_POST["mod_com_ser"],ENT_QUOTES)));
		$estado=mysqli_real_escape_string($con,(strip_tags($_POST["mod_estado"],ENT_QUOTES)));
		$cancelado=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cancelado"],ENT_QUOTES)));
		$id_servicio=intval($_POST['mod_id']);
		$sql="UPDATE servicio SET com_ser='".$com_ser."', ter_ser='".$estado."', cancelado='".$cancelado."' WHERE id_servicio='".$id_servicio."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Servicio ha sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Error.";
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