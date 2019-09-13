<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	if (!isset($_SESSION['servicio'])){
            $a=2;
        }else{
            $a=$_SESSION['servicio'];
        }
        if (!isset($_SESSION['entregado'])){
            $aa=2;
        }else{
            $aa=$_SESSION['entregado'];
        }
        
        if (!isset($_SESSION['desechado'])){
            $aaa=2;
        }else{
            $aaa=$_SESSION['desechado'];
        }
        if($a==0){
            $b1="sin reparar";
            $d1=0;
            $d2=0;
           
        }
        if($a==1){
            $b1="reparado(s)";
            $d1=1;
            $d2=1;
            
        }
        if($a==2){
            $b1="";
            $d1=0;
             $d2=1;
            
        }
        if($aa==0){
            $bb="en taller";
            $e1=0;
            $e2=0;
           
        }
        if($aa==1){
            $bb="entregado";
            $e1=1;
            $e2=1;  
        }
        if($aa==2){
            $bb="";
            $e1=0;
             $e2=1;
            
        }
        if($aaa==0){
            $bbb="no desechado";
            $g1=0;
            $g2=0;
           
        }
        if($aaa==1){
            $bbb="desechado";
            $g1=1;
            $g2=1;
            
        }
        if($aaa==2){
            $bbb="";
            $g1=0;
             $g2=1;
            
        }
        if (!isset($_SESSION['ser'])){
            $e=5;
        }else{
            $e=$_SESSION['ser'];
        }
        
        if($e==1){
            $c="Laptops";
            $f1=1;
            $f2=1;
        }
        if($e==2){
            $c="Computadora(s)";
            $f1=2;
            $f2=2;
        }
        if($e==3){
            $c="Impresoras";
            $f1=3;
            $f2=3;
        }
        if($e==4){
            $c="Monitores";
            $f1=4;
            $f2=4;
        }
        if($e==5){
            $c="Equipo(s)";
            $f1=1;
             $f2=5;
        }
        $tienda1=$_SESSION['tienda']; 
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
        if (isset($_GET['id'])){
		$id_servicio=$_GET['id'];
                $idservicio =explode("-",$id_servicio);
                $idservicio1=$idservicio[0];
                $idservicio2=$idservicio[1];
		$query=mysqli_query($con, "select * from servicio WHERE doc_servicio='".$idservicio1."' and tip_doc='".$idservicio2."'");
		$count=mysqli_num_rows($query);
		if ($count>0){
			if ($delete1=mysqli_query($con,"DELETE FROM servicio WHERE doc_servicio='".$idservicio1."' and tip_doc='".$idservicio2."'")){
                            $delete3=mysqli_query($con,"DELETE FROM facturas WHERE numero_factura='".$idservicio1."' and estado_factura='".$idservicio2."'");     
                            $query=mysqli_query($con, "select * from detalle_factura WHERE numero_factura='".$idservicio1."' and ven_com=1 and tipo_doc='".$idservicio2."'");
                            $_SESSION['servicio1']="0";
                $_SESSION['tipo']=0; 
            while ($valor5=mysqli_fetch_array($query)){
                $id_producto=$valor5['id_producto'];
                $tienda=$valor5['tienda'];
                $cantidad=$valor5['cantidad'];
                $precio1=$valor5['precio_venta'];
                $b="b$tienda";
                $productos1=mysqli_query($con, "UPDATE products SET $b=$b+$cantidad,precio_producto=$precio1 WHERE id_producto=$id_producto and pro_ser=1");
            }      
            $delete2=mysqli_query($con,"DELETE FROM detalle_factura WHERE numero_factura='".$idservicio1."' and tipo_doc='".$idservicio2."'");  
            ?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> El servicio está cerrado.
			</div>
			<?php
		}	
	}
        if($action == 'ajax'){
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$sTable = "servicio, clientes, users";
		$sWhere = "";
		$sWhere.=" WHERE servicio.id_cliente=clientes.id_cliente and servicio.user_id=users.user_id and servicio.ter_ser>=$g1 and servicio.ter_ser<=$g2 and servicio.tipo>=$f1 and servicio.entregado<=$e2 and servicio.entregado>=$e1 and servicio.reparado<=$d2 and servicio.reparado>=$d1 and servicio.tipo<=$f2 and servicio.activo=1 and servicio.tienda=$tienda1";
                if ( $_GET['q'] != "" )
		{
		if ($_SESSION['user_id']== 1) {
                   $sWhere.= " and  (clientes.nombre_cliente like '%$q%' or servicio.doc_servicio like '%$q%')"; 
                }else{
                   $sWhere.= " and  (clientes.nombre_cliente = '$q' or servicio.doc_servicio = '$q')";
                }
		}
		$sWhere.=" order by servicio.id_servicio desc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		if($q==""){
                   if ($_SESSION['user_id']== 1) {
                    $count_query= mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");   
                  }else    {
                   $count_query= "";   
                   }
                }
                else
                {
                $count_query= mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");    
                }
                $row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './servicios1.php';
		if($q==""){
                if ($_SESSION['user_id']== 1) {
                  $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";}  
                else{
                 $sql="";   
                }       
                }
                else{   
                $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";}
                $query = mysqli_query($con, $sql);
		if ($numrows>0){
			echo mysqli_error($con);
			?>
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Se tienen <?php echo $numrows;?> <?php echo $c;?> <?php echo $b1;?> <?php echo $bb;?> <?php echo $bbb;?>.</strong>
			</div>
                        <div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#Guia</th>
                                        <th>Equipo</th>
					<th>Fecha</th>
                                        <th>Hora Ingreso</th>
                                        <th>Nro Dias</th>
					<th>Cliente</th>
					<th>Vendedor</th>
					<?php
                                        if($_SESSION['user_id']==1){
                                            ?>
                                        <th class='text-right'>Total</th> 
                                        <?php
                                        }
                                        ?>                     
                                        <th class='text-right'>Estado</th>
                                        <th class='text-right'>Acciones</th>
                                </tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                                $pre_ser=$row['pre_ser'];
                                                $ade_ser=$row['ade_ser'];
                                                $id_servicio=$row['id_servicio'];
                                                $doc_servicio=$row['guia'];
                                                $tipo=$row['tipo'];
                                                
                                                if($tipo==1){
                                                    $tipo1="Laptop";
                                                }
                                                if($tipo==2){
                                                    $tipo1="Computadora";
                                                }
                                                if($tipo==2){
                                                   $tipo1="Impresora"; 
                                                }
                                                if($tipo==2){
                                                   $tipo1="Monitor"; 
                                                }
                                                
						$fecha=date("d/m/Y", strtotime($row['fecha']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
						$email_cliente=$row['email_cliente'];
                                                $nom_ser=$row['nom_ser'];
                                                $des_ser=$row['des_ser'];
                                                $aceptar3=$row['aceptar_guia'];
                                                if($aceptar3==2){
                                                    $color="#A9F5D0";
                                                }
                                                if($aceptar3==1){
                                                    $color="#F5ECCE";
                                                }
                                                $numerofactura=$row['doc_servicio'];
                                                $tipdoc=$row['tip_doc'];
                                                $id_servicio1=$numerofactura."-".$tipdoc;
                                                $car1=$row['car1'];
                                                $car2=$row['car2'];
                                                $car3=$row['car3'];
                                                $car4=$row['car4'];
                                                $car5=$row['car5'];
                                                $car6=$row['car6'];
                                                $com_ser=$row['com_ser'];
                                                $cancelado=$row['cancelado'];  
                                                $telefono=$row['telefono1'];   
                                                $cerrado=$row['cancelado']; 
                                                $ter_ser=$row['ter_ser']; 
                                                $reparado=$row['reparado'];
                                                $entregado=$row['entregado'];
                                                $id_reparado=$row['id_reparado']; 
                                                $id_entregado=$row['id_entregado']; 
                                                $hora=date("H:i", strtotime($row['fecha_emision']));
                                                date_default_timezone_set('America/Santiago');
                                                $mes1=date("m", strtotime($row['fecha_emision']));
                                                $dia1=date("d", strtotime($row['fecha_emision']));
                                                $ano1=date("Y", strtotime($row['fecha_emision']));
                                                $dia2=mktime(0,0,0,$mes1,$dia1,$ano1); 
                                                $dia=mktime(0,0,0,date("m"),date("d"),date("Y"));
                                                $dias=($dia-$dia2)/(24*3600);    
                                                $sql1="SELECT * FROM  sub_tipo;";
                                                $query1 = mysqli_query($con, $sql1);
                                                $car = array();
                                                $i=0;
                                                while ($row1=mysqli_fetch_array($query1)){
                                                  if($row1['id_tipo']==$tipo)  {
                                                     $car[$i]=$row1['sub_tipo'];
                                                     $equipo=$row1['nombre']; 
                                                     $i=$i+1;
                                                  }
                                                }
                                                if($i==4){
                                                $datos="$car[0]:$car1  $car[1]:$car2  $car[2]:$car3  $car[3]:$car4  ";
                                                }
                                                if($i==5){
                                                $datos="$car[0]:$car1  $car[1]:$car2  $car[2]:$car3  $car[3]:$car4  $car[4]:$car5  ";
                                                }
                                                if($i==6){
                                                $datos="$car[0]:$car1  $car[1]:$car2  $car[2]:$car3  $car[3]:$car4  $car[4]:$car5  $car[5]:$car6";
                                                }
						$nombre_vendedor=$row['nombres'];
						$estado=$row['ter_ser'];
                                                if($reparado==1){
                                                    $estado1="Reparado";
                                                    $label_class='label-success';
                                                }else{
                                                    $estado1="Sin Reparar";
                                                    $label_class='label-danger';
                                                }
                                                $doc=$row['doc_servicio'];    
                                                $tipo_doc=$row['tip_doc'];
                                                $fecha_reparado=$row['fecha_reparado'];
                                                $fecha_emision=$row['fecha_emision'];
                                                $saliente=$row['saliente'];
                                                $desechado=$row['desechado'];
                                                $count_query1   = mysqli_query($con, "SELECT*FROM facturas WHERE numero_factura=$doc and estado_factura=$tipo_doc and tienda=$tienda1");
                                                $row1= mysqli_fetch_array($count_query1);
                                                $id_factura=$row1['id_factura'];
                                                if($dias>7){
                                                    $label_class1='label-danger';
                                                }else{
                                                    $label_class1='label-success';
                                                }   	
                                            ?>
                                            <tr style="background-color:<?php echo $color;?>;color:black;">
						<td><?php echo $doc_servicio; ?></td>
                                                <td><img src="images/<?php echo $equipo; ?>" width="30" height="30"><?php echo $equipo; ?></td>
						<td><?php echo $fecha; ?></td>
                                                <td><?php echo $hora; ?></td>
                                                <td><span class="label <?php echo $label_class1;?>"><?php echo $dias; ?></span></td>
						<td width="100"><?php echo $nombre_cliente;?></td>
						<td width="100"><?php echo $nombre_vendedor; ?></td>
                                                <input type="hidden" value="<?php echo $equipo;?>" id="equipo<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $fecha_reparado;?>" id="fecha_reparado<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $fecha_emision;?>" id="fecha_emision<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $saliente;?>" id="saliente<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $desechado;?>" id="desechado<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $nom_ser;?>" id="nom_ser<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $pre_ser;?>" id="pre_ser<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $ade_ser;?>" id="ade_ser<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $fecha;?>" id="fecha<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $doc_servicio;?>" id="doc_servicio<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $des_ser;?>" id="des_ser<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $datos;?>" id="datos<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $com_ser;?>" id="com_ser<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $cancelado;?>" id="cancelado<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $cerrado;?>" id="cerrado<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $reparado;?>" id="reparado<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $entregado;?>" id="entregado<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $ter_ser;?>" id="ter_ser<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $reparado;?>" id="rep<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $entregado;?>" id="ent<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $ter_ser;?>" id="ter<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $id_reparado;?>" id="id_reparado<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $id_entregado;?>" id="id_entregado<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $id_reparado;?>" id="id_rep<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $id_entregado;?>" id="id_ent<?php echo $id_servicio;?>">
                                                <input type="hidden" value="<?php echo $telefono;?>" id="telefono<?php echo $id_servicio;?>">
                                                <?php
                                                if($_SESSION['user_id']==1){
                                                ?>
                                                <td class='text-right'>S/.<?php echo number_format ($pre_ser,2); ?></td>	 
                                                <?php
                                                }
                                                ?>                    
                                                <td><span class="label <?php echo $label_class;?>"><?php echo $estado1; ?></span></td>
                                                <td class="text-right">
                                                <a href="#" class="btn btn-primary btn-xs" title='Ver Doc' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="fa fa-folder"></i>  </a>   
                                                <a href="#" title='Editar servicio' onclick="obtener_datos('<?php echo $id_servicio;?>');" data-toggle="modal" data-target="#myModal2" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>  </a>
                                                <a title='Editar Documento' href="tipo.php?accion=7&ser=<?php echo $doc_servicio;?>" class="btn btn-warning btn-xs"><i class="fa fa-trash-o"></i>  </a>
                                                <a href="#" class='btn btn-danger btn-xs' title='Borrar doc' onclick="eliminar('<?php echo $id_servicio1; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span>
                                                </td>
                                            </tr>
					<?php
				
                                }
				?>
				<tr>
					<td colspan=10><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
           }
	
?>