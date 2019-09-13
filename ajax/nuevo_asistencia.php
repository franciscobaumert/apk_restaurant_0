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
		$tipo_reg=mysqli_real_escape_string($con,(strip_tags($_POST["tipo_reg"],ENT_QUOTES)));
                $porciones = explode("-", $nombre);
                $nombre1= $porciones[0]; 
                $hora= $porciones[1]; 
                date_default_timezone_set('America/Santiago');
                $fecha_entrada=date("Y-m-d");
                $valor=$nombre."-".$fecha_entrada;
		$hora_entrada=date("H:i:s");
                function calcular_tiempo_trasnc($hora1,$hora2){ 
                    $separar[1]=explode(':',$hora1); 
                    $separar[2]=explode(':',$hora2); 
                    $total_minutos_trasncurridos[1] = ($separar[1][0]*60)+$separar[1][1]; 
                    $total_minutos_trasncurridos[2] = ($separar[2][0]*60)+$separar[2][1]; 
                    $total_minutos_trasncurridos = $total_minutos_trasncurridos[1]-$total_minutos_trasncurridos[2]; 
                    if($total_minutos_trasncurridos<=59) return("00".":".$total_minutos_trasncurridos.' Minutos'); 
                    elseif($total_minutos_trasncurridos>59){ 
                    $HORA_TRANSCURRIDA = round($total_minutos_trasncurridos/60); 
                    if($HORA_TRANSCURRIDA<=9) $HORA_TRANSCURRIDA='0'.$HORA_TRANSCURRIDA; 
                    $MINUITOS_TRANSCURRIDOS = $total_minutos_trasncurridos%60; 
                    if($MINUITOS_TRANSCURRIDOS<=9) $MINUITOS_TRANSCURRIDOS='0'.$MINUITOS_TRANSCURRIDOS; 
                    return ($HORA_TRANSCURRIDA.':'.$MINUITOS_TRANSCURRIDOS.' Horas'); 
            } } 
$hora_salida=0;
$accion1=mysqli_query($con, "select * from asistencia where fecha_entrada='".$fecha_entrada."' and user_id='".$nombre1."'");
$row1=mysqli_fetch_array($accion1);
$hora_salida=$row1["hora_salida"];        
$resultado=calcular_tiempo_trasnc($hora_entrada,$hora); 
                $sql="";
		if($tipo_reg==1){
		$sql="INSERT INTO asistencia (unico,user_id, hora_entrada,fecha_entrada,hora_base,hora_salida,fecha_salida,min_tardanza,asistencia) VALUES ('$valor','$nombre1','$hora_entrada','$fecha_entrada','$hora','00:00:00','$fecha_entrada','$resultado','0')";
		}
                if($tipo_reg==2 && $hora_salida=='00:00:00'){
                $sql="UPDATE asistencia SET fecha_salida='".$fecha_entrada."',hora_salida='".$hora_entrada."' WHERE fecha_entrada='".$fecha_entrada."' and user_id='".$nombre1."'";
                }
                $query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Asistencia ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Error en ingreso de asistencia.";
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