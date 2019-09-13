<?php
	include('is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['mod_nombre'])){
			$errors[] = "Nombre del personal vacía";
		} 
                else if (
			
			!empty($_POST['mod_nombre'])&&
			!empty($_POST['mod_fecha_entrada'])
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$variable=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cod_var"],ENT_QUOTES)));
                $fecha_entrada=$_POST["mod_fecha_entrada"];
                $asistencia1=0;
                $accion1=mysqli_query($con, "select * from asistencia where fecha_entrada='".$fecha_entrada."' and user_id='".$nombre."'");
                $row1=mysqli_fetch_array($accion1);
                $asistencia1=$row1["id_asistencia"];
                $id_asistencia=$_POST['mod_id'];
		$sql="UPDATE asistencia SET fecha_entrada='".$fecha_entrada."',user_id='".$nombre."' ,asistencia='".$asistencia."' WHERE id_asistencia='".$id_asistencia."'";
                if($id_asistencia<>$asistencia1){
                $query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Variable ha sido actualizada satisfactoriamente.";
			} else{
				
                            $errors []= "Variable duplicada.";
			}
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