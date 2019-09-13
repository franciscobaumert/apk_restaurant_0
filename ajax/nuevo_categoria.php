<?php
        include('is_logged.php');
	
	if (empty($_POST['nom_cat'])) {
           $errors[] = "Categoría vacía";
        } else if (empty($_POST['nom_cat'])){
			$errors[] = "Nombre de la categoría vacía";
		} 
                else if (
			!empty($_POST['nom_cat']) &&
			!empty($_POST['des_cat']) 
		){
		
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		
		$nom_cat=mysqli_real_escape_string($con,(strip_tags($_POST["nom_cat"],ENT_QUOTES)));
		$des_cat=mysqli_real_escape_string($con,(strip_tags($_POST["des_cat"],ENT_QUOTES)));
		$sql="INSERT INTO categorias (nom_cat, des_cat) VALUES ('$nom_cat','$des_cat')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){ ?>
				<script>
						toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.success("Categoria registrada","Exito");
				</script>
			<?php } else{ ?>
				<script>
						toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.warning("Categoria duplicada","Precaucion");
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