<?php
include('is_logged.php');
	
	if (empty($_POST['codigo'])) {
           $errors[] = "Código vacío";
        } else if (empty($_POST['nombre'])){
			$errors[] = "Nombre del producto vacío";
		} else if ($_POST['estado']==""){
			$errors[] = "Selecciona el estado del producto";
		} else if (empty($_POST['precio'])){
			$errors[] = "Precio de venta vacío";
		} else if (empty($_POST['costo'])){
			$errors[] = "Precio de costo vacío";
		} else if (empty($_POST['inventario'])){
			$errors[] = "Inventario vacío";
		} 
                else if (
			!empty($_POST['codigo']) &&
			!empty($_POST['nombre']) &&
                        !empty($_POST['costo']) &&
                        !empty($_POST['inventario']) &&
                        
			$_POST['estado']!="" &&
                        $_POST['cat_pro']!="" &&
			!empty($_POST['precio'])
		){
		
		require_once ("../config/db.php");
		require_once ("../config/conexion.php");
		
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$options=mysqli_real_escape_string($con,(strip_tags($_POST["options"],ENT_QUOTES)));
		$estado=intval($_POST['estado']);
		$destino=intval($_POST['destino']);
                $und_pro=intval($_POST['und_pro']);
		$precio_venta=floatval($_POST['precio']);
                $precio_costo=floatval($_POST['costo']);
                $inventario=floatval($_POST['inventario']);
                //$precio2=floatval($_POST['precio2']);
               // $precio3=floatval($_POST['precio3']);
                $tienda=$_SESSION['tienda'];
                $cat_pro=floatval($_POST['cat_pro']);
                $marca=mysqli_real_escape_string($con,(strip_tags($_POST["marca"],ENT_QUOTES)));
                $modelo=mysqli_real_escape_string($con,(strip_tags($_POST["modelo"],ENT_QUOTES)));
                $color=mysqli_real_escape_string($con,(strip_tags($_POST["color"],ENT_QUOTES)));
                $prod = array();
                for($i=1 ;$i<=6;$i++){
                    if($i==$tienda){
                        $prod[$i]=$inventario;
                    }else{
                        $prod[$i]=0; 
                    }
                }
                date_default_timezone_set('America/Santiago');
		$date_added=date("Y-m-d H:i:s");
		$sql="INSERT INTO products (codigo_producto, nombre_producto, status_producto, date_added, precio_producto,costo_producto,mon_costo,mon_venta,marca,modelo,color,b1,b2,b3,b4,b5,b6,cat_pro,pro_ser,foto1,foto2,foto3,foto4,web,pre_web,descripcion,descripcion1,megusta,nomegusta,precio2,precio3,und_pro,destino,options) VALUES ('$codigo','$nombre','$estado','$date_added','$precio_venta','$precio_costo','1','1','$marca','$modelo','$color','$prod[1]','$prod[2]','$prod[3]','$prod[4]','$prod[5]','$prod[6]','$cat_pro','1','nuevo.jpg','nuevo.jpg','nuevo.jpg','nuevo.jpg','1','$precio_venta','','','0','0','0','0','$und_pro','$destino','$options')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){ ?>
				<script>
						toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.success("Producto registrado","Exito");
				</script>
			<?php } else{ ?>
				<script>
						toastr.options = {
					"closeButton":false,
					"progressBar": false
				};
				toastr.warning("Lo siento, algo salio mal","Precaucion");
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