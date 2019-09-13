<?php
session_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
header("Content-type: application/vnd.ms-excel" ) ; 
header("Content-Disposition: attachment; filename=ventas.xls" ) ; 
        $tienda1=$_SESSION['tienda'];
        $sTable = "facturas, clientes, users";
        
        
		
		$sWhere=" order by id_factura desc";
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable WHERE facturas.id_cliente=clientes.id_cliente and facturas.tienda=$tienda1 and facturas.id_vendedor=users.user_id and facturas.ven_com=1 and facturas.estado_factura<=3 and facturas.activo=1 and facturas.numero_factura>0 $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
                $sql="SELECT * FROM $sTable WHERE facturas.id_cliente=clientes.id_cliente and facturas.tienda=$tienda1 and facturas.id_vendedor=users.user_id and facturas.ven_com=1 and facturas.estado_factura<=3 and facturas.activo=1 and facturas.numero_factura>0 $sWhere ";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			?>
			
                           
			 <table id="example" class="display nowrap" style="width:100%">
                            <thead>
				<tr >
                                       
					<th>Nro Doc</th>
					<th>Tipo de Doc</th>
                                        <th>Fecha</th>
					<th>Cliente</th>
                                        <th>Total</th>
                                        <th>Usuario</th>
                                        <th>Pago</th>
                                        <th>Estado</th>
                                        
				</tr>
                                </thead>
				<?php
                while ($row=mysqli_fetch_array($query)){
                                    
                                                $activo=$row['activo'];
                        if ($activo==1){
                                                $id_factura=$row['id_factura'];
                        $numero_factura=$row['numero_factura'];
                        $fecha=date("d/m/Y", strtotime($row['fecha_factura']));
                        $nombre_cliente=$row['nombre_cliente'];
                        $telefono_cliente=$row['telefono_cliente'];
                                                $ruc=$row['doc'];
                        $email_cliente=$row['email_cliente'];
                                                $folio=$row['folio'];
                                                $dni=$row['dni'];
                                                
                        $nombre_vendedor=$row['nombres'];
                                                $aceptado=$row['aceptado'];
                                                $estado_factura1=$row['estado_factura'];
                        $estado_factura=$row['condiciones'];
                                                $ven_com=$row['ven_com'];
                                                $moneda=$row['moneda'];
                                                if($moneda==1){
                                                    $mon="S/.";
                                                }else{
                                                    $mon="USD";
                                                }
                                                
                                                if($estado_factura1==1){
                                                    $estado1="Factura";
                                                    
                                                }
                                                if($estado_factura1==2){
                                                    $estado1="Boleta";
                                                    
                                                }
                                                if($estado_factura1==3){
                                                    $estado1="Ticket (pendiente)";
                                                }
                                                if($estado_factura1==5){
                                                    $estado1="Nota de Debito";
                                                    
                                                }
                                                if($estado_factura1==6){
                                                    $estado1="Nota de Credito";
                                               }
                                               if($estado_factura1==8){
                                                    $estado1="Cotizacion";
                                               }
                                               if($estado_factura==1){
                                                    $estado2="Efectivo";
                                                }
                                                if($estado_factura==2){
                                                    $estado2="Cheque";
                                                    
                                                }
                                                if($estado_factura==3){
                                                    $estado2="Transf Bancaria";
                                                }
                                                if($estado_factura==4){
                                                    $estado2="Crédito";
                                               }
                                               if($estado_factura==5){
                                                    $estado2="Visa";
                                               }
                                               if($estado_factura==6){
                                                    $estado2="MasterCard";
                                               }
                                               if($estado_factura==7){
                                                    $estado2="American Express";
                                               }
                                               if($estado_factura==8){
                                                    $estado2="Dinners Club";
                                               }
                                                $deuda=$row['deuda_total']-$row['cuenta1'];
                                                $servicio=$row['servicio'];
                                                $guia=0;
                                                $sql1="SELECT * FROM  servicio;";
                                                $query1 = mysqli_query($con, $sql1);
                                               
                                                while ($row1=mysqli_fetch_array($query1)){
                                                  if($row1['doc_servicio']==$numero_factura && $row1['tip_doc']==$estado_factura1)  {
                                                     $guia=$row1['guia'];
                                                 }
                                                }
                                                if ($servicio==0){$text_estado1="Productos";$label_class1='label-success';}
                                                else{$text_estado1="Servicios";$label_class1='label-warning';}
                                            if ($deuda==0){$text_estado="Pagada";$label_class='label-success';}
                        else{$text_estado="Pendiente";$label_class='label-warning';}
                        $total_venta=$row['total_venta'];
                    ?>
                                        <tr id="<?php echo $table;?>">
                                        
                                          	
                                            <td><?php echo $folio; ?>-<?php echo $numero_factura; ?></td>
                                            <td><?php echo $estado1; ?></td>
                                            <td><?php echo $fecha; ?></td>
                                            <td width="50px"><?php echo $nombre_cliente;?></td>
                                            <td ><?php print"$mon"; echo number_format ($total_venta,2); ?></td>
                                            <td width="50px"><?php echo $nombre_vendedor; ?></td>
                                            <td><?php echo $estado2; ?></td>
                                            <td><?php echo $text_estado; ?></td>
                                           
					</tr>
					<?php
                                    }
                                }
				?>
				
			  </table>

			
<?php
                                    }
                              
				?>
