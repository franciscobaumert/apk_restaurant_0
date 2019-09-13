<?php
	include('is_logged.php');
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['mod_cat'])){
			$errors[] = "Nombre de la categoria vacía";
		} 
                else if (
			
			!empty($_POST['mod_cat'])&&
			!empty($_POST['mod_des'])
		){
		
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$categoria=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cat"],ENT_QUOTES)));
		$des=mysqli_real_escape_string($con,(strip_tags($_POST["mod_des"],ENT_QUOTES)));
		$id_categoria=$_POST['mod_id'];
		$sql="UPDATE categorias SET nom_cat='".$categoria."',des_cat='".$des."'WHERE id_categoria='".$id_categoria."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Producto ha sido actualizado satisfactoriamente.";
			} else{
                            $errors []= "Categoria duplicada.";
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