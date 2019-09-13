<?php

	
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
    /* Connect To Database*/
    require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
    
    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    
    if($action == 'ajax'){
    $tienda=$_SESSION['tienda'];    // escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $aColumns = array('nom_cat');//Columnas de busqueda
         $sTable = "caja";
                 $sWhere = "";
         $sWhere.=" WHERE caja.tienda=$tienda";
        if ( $_GET['q'] != "" )
        {
        $sWhere.= " and  (caja.fecha like '%$q%')";
            
        }
        $sWhere.=" order by id_caja desc";
        include 'pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 10; //how much records you want to show
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
        $row= mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows/$per_page);
        $reload = './caja.php';
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table id="example" class="table table-bordered table-hover">
               
                    <tr class="bg-gray">
                        <th>Nro</th>
                    <th>Fecha</th>
                    <th>Inicio</th>
                                        <th class="danger">Inicia</th>
                                        <th>Entradas</th>
                                        <th>Salidas</th>
                                        <th>Cierre Optimo</th>
                                        <th class="warning">Cierre Real</th>
                                        <th class="danger">Cierra</th>
                                        <th class="warning">Diferencia</th>
                                        <th>Acciones</th>
                    
                </tr>
               

                
				
                
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_caja=$row['id_caja'];
                                                $fecha=date("d/m/Y", strtotime($row['fecha']));
						$fecha2=date("Y-m-d", strtotime($row['fecha']));
                                                date_default_timezone_set('America/Santiago');
                                                $fecha4=date("d/m/Y");
                                                $nombres1="";
                                                $nombres2="";
                                                $usuario_inicio=$row['usuario_inicio'];
                                                $usuario1= mysqli_query($con, "SELECT*FROM users  where user_id=$usuario_inicio");
                                                $row6= mysqli_fetch_array($usuario1);
                                                $nombres1 = $row6['user_name'];
                                                
                                                $usuario_cierre=$row['usuario_cierre'];
                                                $usuario2= mysqli_query($con, "SELECT*FROM users  where user_id=$usuario_cierre");
                                                $row7= mysqli_fetch_array($usuario2);
                                                $nombres2 = $row7['user_name'];
                                                //$fecha=$row['fecha'];
						$inicio=$row['inicio'];
                                                $faltante=$row['faltante'];
						$fin=$row['cierre'];
                
                                                
                                                if($usuario_cierre>0){
                                                    $entrada=$row['entrada'];
                                                    $salida=$row['salida'];
                                                }else{
                                                    $suma1= mysqli_query($con, "SELECT SUM(total_venta) AS total1 FROM facturas  where condiciones<=8 and (estado_factura<=2 or estado_factura=5) and activo=1 and ven_com=1 and tienda=$tienda and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
                                                    $row1= mysqli_fetch_array($suma1);
                                                    $total1 = $row1['total1'];
                                                    
                                                    $suma4= mysqli_query($con, "SELECT SUM(total_venta) AS total4 FROM facturas  where  condiciones<=8 and activo=1 and (ven_com=5 or ven_com=3) and tienda=$tienda and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
                                                    $row4= mysqli_fetch_array($suma4);
                                                    $total4 = $row4['total4'];
                                                    
                                                    $suma2= mysqli_query($con, "SELECT SUM(total_venta) AS total2 FROM facturas  where condiciones<=8 and estado_factura=6 and activo=1 and ven_com=1 and tienda=$tienda and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
                                                    $row2= mysqli_fetch_array($suma2);
                                                    $total2 = $row2['total2'];
                                                    
                                                    $suma3= mysqli_query($con, "SELECT SUM(total_venta) AS total3 FROM facturas  where condiciones<=8 and activo=1 and (ven_com=2 or ven_com=4) and tienda=$tienda and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
                                                    $row3= mysqli_fetch_array($suma3);
                                                    $total3 = $row3['total3'];
                                                    
                                                    $suma5= mysqli_query($con, "SELECT SUM(total_venta) AS total5 FROM facturas  where condiciones<=8 and activo=1 and ven_com=6 and tienda=$tienda and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha2' )");
                                                    $row5= mysqli_fetch_array($suma4);
                                                    $total5 = $row5['total5'];
                                                    
                                                    $entrada=$total1+$total4;
                                                    $salida=$total2+$total3+$total5;
                                                    
                                                }
						$color="white";
                                                $mensaje="";
                                              if($fecha==$fecha4) {
                                                  $color="success";
                                                  $mensaje="<font color=red><strong> (Hoy)</strong></font>";
                                              }
                                                
                                          $faltante=$inicio+$entrada-$salida;      
					?>
					
					<input type="hidden" value="<?php echo $entrada;?>" id="entrada<?php echo $id_caja;?>">
                                        <input type="hidden" value="<?php echo $salida;?>" id="salida<?php echo $id_caja;?>">
                                        <input type="hidden" value="<?php echo $faltante;?>" id="faltante<?php echo $id_caja;?>">
                                        <input type="hidden" value="<?php echo $inicio;?>" id="inicio<?php echo $id_caja;?>">
					
                                        <tr class="<?php echo $color;?>">
                                            <td><?php echo $numrows; ?></td>
						<td><?php echo $fecha; print"$mensaje";?></td>
						<td>S/. <?php echo $inicio; ?></td>
                                                <td><?php echo $nombres1; ?></td>
						<td>S/. <?php echo $entrada; ?></td>
                                                <td>S/. <?php echo $salida; ?></td>
                                                <td>S/. <?php echo $faltante; ?></td>
                                                <td><font color="red"><strong>S/. <?php echo $fin; ?></strong></font></td>
                                                 <td><?php echo $nombres2; ?></td>
                                                <td><font color="blue"><strong>S/. <?php echo $faltante1=$fin-$faltante; ?></strong></font></td>
						<td><span class="pull-center">
                                                <?php
                                                if($usuario_cierre==0){
                                                    if($mensaje<>"<font color=red><strong> (Hoy)</strong></font>"){
                                                    ?>
                                                    <a  style="cursor: pointer;" class='btn btn-warning btn-xs' title='Editar inicio caja' onclick="obtener_datos('<?php echo $id_caja;?>');" data-toggle="modal" data-target="#myModal2">Cerrar</a> 
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <a disabled style="cursor: pointer;" class='btn btn-info btn-xs' title='Sin acceso'   >Cerrar</a> 
                                                    <?php
                                                    }
                                                        
                                                }else{
                                                    print"<font color=red><strong>Cerrado</strong></font>";
                                                }
                                                ?>
                                                        
                                                </td>
					</tr>
					<?php
                                        $numrows=$numrows-1;
                        }
                                
                ?>
               <tr>
                    <td colspan=11><span class="pull-right"><?PHP
                     echo paginate($reload, $page, $total_pages, $adjacents);
                    ?></span></td>
                </tr>
			  </table>
			</div>
			<?php
        }else{
          ?>
          <br><br><br>
          <div class="alert alert-danger alert-custom alert-dismissible">
            <br><br>
            <h4 class="alert-title">No hay Caja</h4>
            <p>No se han agregado Caja a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Caja"</b>.</p>
            <br><br>
          </div>
          <br><br><br>
          <?php
        }}
      ?>