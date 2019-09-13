<?php
	include('is_logged.php');
	
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if ($_POST['cerrado']==1 && $_SESSION['user_id']<>1){
			$errors[] = "Servicio Tecnico Cerrado";
		}else if (
			!empty($_POST['mod_id'])
		){
		
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		$com_ser=mysqli_real_escape_string($con,(strip_tags($_POST["mod_com_ser"],ENT_QUOTES)));
                $fecha_reparado=mysqli_real_escape_string($con,(strip_tags($_POST["fecha_reparado"],ENT_QUOTES)));
                $saliente=mysqli_real_escape_string($con,(strip_tags($_POST["saliente"],ENT_QUOTES)));
                $desechado=mysqli_real_escape_string($con,(strip_tags($_POST["desechado"],ENT_QUOTES)));
                $rep=mysqli_real_escape_string($con,(strip_tags($_POST["rep"],ENT_QUOTES)));
                $ent=mysqli_real_escape_string($con,(strip_tags($_POST["ent"],ENT_QUOTES)));
                $ter=mysqli_real_escape_string($con,(strip_tags($_POST["ter"],ENT_QUOTES)));
                $reparado=intval($_POST['reparado']);
                $entregado=intval($_POST['entregado']);
                $id_reparado=intval($_POST['id_reparado']);
                $id_entregado=intval($_POST['id_entregado']);
                $ter_ser=mysqli_real_escape_string($con,(strip_tags($_POST["mod_ter_ser"],ENT_QUOTES)));
		$user_id=$_SESSION['user_id'];
                if($_POST['cerrado']==1 && $_SESSION['user_id']<>1){
                   $cerrado=1; 
                }else{
                   $cerrado=$_POST['mod_cancelado']; 
                }
                date_default_timezone_set('America/Santiago');
                $fecha  = date("Y-m-d H:i:s");
                $id_servicio=intval($_POST['mod_id']);
                if($ter_ser==$ter){
                    $desechado1=$desechado;  
                }else{  
                    if($ter_ser==1){
                        $desechado1=$fecha;
                    }else{
                        $desechado1="0";
                        
                    }
                    
                }
                if($entregado==$ent){
                    
                    $entregado1=$saliente;
                    $id_entregado1=$id_entregado;
                }else{
                    
                    if($entregado==1){
                        $entregado1=$fecha;
                        $id_entregado1=$user_id;
                    }else{
                        $entregado1="0";
                        $id_entregado1=0;
                    }  
                }
                if($reparado==$rep){
                    
                    $reparado1=$fecha_reparado;
                    $id_reparado1=$id_reparado;
                    
                }else{
                    if($reparado==1){
                        $reparado1=$fecha;
                        $id_reparado1=$user_id;
                    }else{
                        $reparado1="0";
                        $id_reparado1=0;
                    }   
                }
                $sql="UPDATE servicio SET id_entregado='".$id_entregado1."',id_reparado='".$id_reparado1."',saliente='".$entregado1."',entregado='".$entregado."',cancelado='".$cerrado."',com_ser='".$com_ser."', fecha_reparado='".$reparado1."', reparado='".$reparado."', ter_ser='".$ter_ser."', desechado='".$desechado1."' WHERE id_servicio='".$id_servicio."'";
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