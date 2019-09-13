<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['fac_ele'])) {
           $errors[] = "Nombre de empresa esta vacío";
        }else if (empty($_POST['usuariosol'])) {
           $errors[] = "Teléfono esta vacío";
        } else if (empty($_POST['clavesol'])) {
           $errors[] = "E-mail esta vacío";
        } else if (empty($_POST['clave'])) {
           $errors[] = "IVA esta vacío";
        } else if (empty($_POST['ruc'])) {
           $errors[] = "Moneda esta vacío";
        } else if (
			!empty($_POST['fac_ele']) &&
			!empty($_POST['usuariosol']) &&
			!empty($_POST['clavesol']) &&
			!empty($_POST['clave']) &&
			!empty($_POST['ruc'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$fac_ele=mysqli_real_escape_string($con,(strip_tags($_POST["fac_ele"],ENT_QUOTES)));
		$usuariosol=mysqli_real_escape_string($con,(strip_tags($_POST["usuariosol"],ENT_QUOTES)));
		$clavesol=mysqli_real_escape_string($con,(strip_tags($_POST["clavesol"],ENT_QUOTES)));
		$clave=mysqli_real_escape_string($con,(strip_tags($_POST["clave"],ENT_QUOTES)));
		$ruc=mysqli_real_escape_string($con,(strip_tags($_POST["ruc"],ENT_QUOTES)));

		if($fac_ele==3){
		    $usuariosol="MODDATOS";
		    $clavesol="moddatos";
		}

		if(is_uploaded_file($_FILES['files']['tmp_name'])) {
		    $ruta_destino = "pdf/documentos/certificados/produccion/";
		        $namefinal=$ruc.".pfx"; //linea nueva devuelve la cadena sin espacios al principio o al final
		        $uploadfile=$ruta_destino.$namefinal;
		    if(move_uploaded_file($_FILES['files']['tmp_name'], $uploadfile)) {
		        $dml="UPDATE datosempresa SET fac_ele='".$fac_ele."',usuariosol='".$usuariosol."',clavesol='".$clavesol."',clave='".$clave."' where id_emp=1";
		        $query_update = mysqli_query($con,$dml);
				        if ($query_update){ ?>
						<script>
								toastr.options = {
							"closeButton":false,
							"progressBar": false
						};
						toastr.success("Datos actualizados","Exito");
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
		      
		}else{
		    $dml="UPDATE datosempresa
		        SET fac_ele='".$fac_ele."',usuariosol='".$usuariosol."',clavesol='".$clavesol."',clave='".$clave."'
		        where id_emp=1";
		        $query_update = mysqli_query($con,$dml);
		        if ($query_update){ ?>
						<script>
								toastr.options = {
							"closeButton":false,
							"progressBar": false
						};
						toastr.success("Datos actualizados","Exito");
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
				 else { ?>
					<script>
							toastr.options = {
						"closeButton":false,
						"progressBar": false
					};
					toastr.error("Error desconocido","Error");
					</script>
				<?php }
		}
				
		
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