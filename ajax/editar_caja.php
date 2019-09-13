<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        } else if (empty($_POST['cierre'])){
			$errors[] = "cierre";
		} 
                else if (
			
			!empty($_POST['cierre'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$entrada=$_POST['entrada'];
                $salida=$_POST['salida'];
                $cierre=$_POST['cierre1'];
		date_default_timezone_set('America/Santiago');
                $fecha4=date("Y-m-d H:i:s");
                $user_id=$_SESSION['user_id'];
                $tienda=$_SESSION['tienda'];
                
                
		$id_caja=$_POST['mod_id'];
		$sql="UPDATE caja SET entrada='$entrada',cierre='$cierre',salida='$salida',usuario_cierre='$user_id',fecha_cierre='$fecha4' WHERE id_caja='".$id_caja."'";
		$query_update1 = mysqli_query($con,"UPDATE sucursal SET caja='0' WHERE tienda=$tienda");
                $query_update = mysqli_query($con,$sql);
			if ($query_update){ ?>

			<script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.success("Cierre registrado","Exito");
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