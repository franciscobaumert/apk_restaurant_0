<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['inicio'])) {
           $errors[] = "Caja vacío";
        } else if (empty($_POST['inicio'])){
			$errors[] = "Caja vacía";
		} 
                
                
                else if (
			!empty($_POST['inicio']) 
			
                        
                        
			
			
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$inicio=mysqli_real_escape_string($con,(strip_tags($_POST["inicio"],ENT_QUOTES)));
		$fecha=mysqli_real_escape_string($con,(strip_tags($_POST["fecha"],ENT_QUOTES)));
                date_default_timezone_set('America/Santiago');
                $fecha4=date("Y-m-d H:i:s");
                $user_id=$_SESSION['user_id'];
                $tienda=$_SESSION['tienda'];
		
                $consulta9 = "SELECT * FROM caja";
                $result9 = mysqli_query($con, $consulta9);
                $fecha10=0;
                while ($valor9 = mysqli_fetch_array($result9)) {
                if($valor9['fecha']==$fecha and $valor9['tienda']==$tienda){
                    $fecha10=1; ?>
                    <script>
						toastr.options = {
						"closeButton":false,
						"progressBar": false
					};
					toastr.error("Ya ha sido ingresado caja para la fecha especificada","Error");
					</script>
                    
                <?php }
                }
                if($fecha10==0){
		$sql="INSERT INTO caja (usuario_inicio,fec_reg,fecha,inicio,cierre,tienda,usuario_cierre,faltante,fecha_cierre,entrada,salida) VALUES ('$user_id','$fecha4','$fecha','$inicio','0','$tienda','0','0','0000-00-00 00:00:00','0','0')";
		$query_update = mysqli_query($con,"UPDATE sucursal SET caja='1' WHERE tienda=$tienda");
                $query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){ ?>
				<script>
					toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.success("Inicio de caja registrada","Exito");
				</script>
				
			<?php } else{ ?>
				<script>
					toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.warning("Inicio de caja duplicada","Precaucion");
				</script>
			<?php }
                 }       
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