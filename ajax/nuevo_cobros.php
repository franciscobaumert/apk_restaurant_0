<?php
	include('is_logged.php');
	
	if (empty($_POST['mod_pago'])) {
           $errors[] = "Cobro vacío";
        } else if ($_POST['mod_pago']>$_POST['mod_deuda'] && $_POST['mod_pago']>0){
			$errors[] = "La cantidad a cobrar debe ser menor a la deuda y positiva";
	} 
        else if (!empty($_POST['mod_pago'])){
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
                $id=mysqli_real_escape_string($con,(strip_tags($_POST["mod_id"],ENT_QUOTES)));
                $numero_factura=mysqli_real_escape_string($con,(strip_tags($_POST["numero_factura"],ENT_QUOTES)));
                $estado_factura=mysqli_real_escape_string($con,(strip_tags($_POST["estado_factura"],ENT_QUOTES)));
		$pago=mysqli_real_escape_string($con,(strip_tags($_POST["mod_pago"],ENT_QUOTES)));
                $obs=mysqli_real_escape_string($con,(strip_tags($_POST["mod_obs"],ENT_QUOTES)));
                $condiciones=mysqli_real_escape_string($con,(strip_tags($_POST["condiciones"],ENT_QUOTES)));
                $dolar1=mysqli_query($con, "SELECT*FROM datosempresa WHERE id_emp=1");
                $row1=mysqli_fetch_array($dolar1);
                $dolar=$row1['dolar'];
                $moneda=$_POST["mod_mon"];
                $mon1=1;
                $cliente=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cliente"],ENT_QUOTES)));
                $vendedor=$_SESSION['user_id'];
                $tienda=$_SESSION['tienda'];
                date_default_timezone_set('America/Santiago');
		$date_added=date("Y-m-d H:i:s");
                $cuenta="Se cobra las ventas de mercaderias";
                $dato=mysqli_query($con, "UPDATE facturas SET deuda_total=deuda_total-$pago WHERE id_factura=$id");
		$sql="INSERT INTO facturas (numero_factura,fecha_factura,fecha_entrega,ot,id_cliente,baja,id_vendedor,condiciones,total_venta,deuda_total,estado_factura,tienda,ven_com,activo,servicio,moneda,nombre,obs,cuenta1,cuenta2,dias,folio) VALUES ('$numero_factura','$date_added','0','0','$cliente','0','$vendedor','$condiciones','$pago','0','$estado_factura','$tienda','3','1','$id','$mon1','$cuenta','$obs','0','0','0','0')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Cobro ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Cobro duplicado.";
			}
		} else {
			$errors []= "Error desconocido1.";
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