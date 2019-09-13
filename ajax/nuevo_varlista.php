<?php
        include('is_logged.php');
	if (empty($_POST['nombre'])) {
           $errors[] = "Asistencia vacía";
        } else if (empty($_POST['nombre'])){
			$errors[] = "Nombre de la asistencia vacía";
		} 
               else if (
			!empty($_POST['nombre']) 
		){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$variable=mysqli_real_escape_string($con,(strip_tags($_POST["variable"],ENT_QUOTES)));
                $fecha_entrada=$_POST["fecha_entrada"];
                $unico=$nombre."-".$fecha_entrada;
                $query=mysqli_query($con,"select * from asistencia where fecha_entrada='".$fecha_entrada."' and user_id='".$nombre."' ");
		$count=mysqli_num_rows($query);
		$sql="INSERT INTO asistencia (unico,user_id, hora_entrada,fecha_entrada,hora_base,hora_salida,fecha_salida,min_tardanza,asistencia) VALUES ('$unico','$nombre','','$fecha_entrada','','','','','$variable')";
                $query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Error en ingreso o existe un persoanl asignado a esta fecha.";
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