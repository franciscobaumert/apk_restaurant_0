<?php
	include('is_logged.php');
	if (empty($_POST['mod_nombre'])) {
           $errors[] = "Operación vacía";
        } else if (!empty($_POST['mod_pago'])){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
                $ven_com=mysqli_real_escape_string($con,(strip_tags($_POST["mod_ven_com"],ENT_QUOTES)));
                $cliente=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cliente"],ENT_QUOTES)));
                $vendedor=mysqli_real_escape_string($con,(strip_tags($_POST["mod_vendedor"],ENT_QUOTES)));
                $condiciones=mysqli_real_escape_string($con,(strip_tags($_POST["mod_condiciones"],ENT_QUOTES)));
                $pago=mysqli_real_escape_string($con,(strip_tags($_POST["mod_pago"],ENT_QUOTES)));
                $estado_factura=mysqli_real_escape_string($con,(strip_tags($_POST["mod_estado_factura"],ENT_QUOTES)));
                $numero_factura=mysqli_real_escape_string($con,(strip_tags($_POST["mod_numero_factura"],ENT_QUOTES)));
                $obs=mysqli_real_escape_string($con,(strip_tags($_POST["mod_obs"],ENT_QUOTES)));
                $moneda=1;
                $tienda=$_SESSION['tienda'];
                $id_factura=intval($_POST['mod_id']);
		$sql="UPDATE facturas SET nombre='".$nombre."',ven_com='".$ven_com."',id_cliente='".$cliente."',id_vendedor='".$vendedor."',condiciones='".$condiciones."',total_venta='".$pago."',estado_factura='".$estado_factura."',numero_factura='".$numero_factura."', obs='".$obs."' WHERE id_factura='".$id_factura."'";
                $query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Operación ha sido editada satisfactoriamente.";
			} else{
				$errors []= "Error al editar.";
			}
		} else {
			$errors []= "Error desconocido $sql.";
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