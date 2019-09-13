<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
        $tienda1=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		
		$sTable = "facturas";
                $sWhere = "";
		$sWhere.=" WHERE  facturas.tienda=$tienda1 and facturas.resumen=0 and facturas.ven_com=1 and facturas.estado_factura=2 and facturas.numero_factura>0";
		if ( $_GET['q'] != "" )
		{
			$sWhere.= " and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$q' )";
		}
                $sWhere.=" order by facturas.id_factura desc";
		include 'pagination.php';
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 999999; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
                $num=1;
                
		if ($numrows>0){
			?>
			<div class="table-responsive" style="height: 300px;">
			  <table class="table table-bordered table-striped table-hover">
			  	<thead>
			  		<tr class="bg-gray">
                                        <th>Nro</th>
						<th>Boleta</th>
						<th>Total S/.</th>
	                                        <th>Fecha</th>
						<th>Hora</th>
						<th>Estado</th>
					</tr>
			  	</thead>

			  	<tfoot>
			  		<tr class="bg-gray">
                                        <th>Nro</th>
						<th>Boleta</th>
						<th>Total S/.</th>
	                                        <th>Fecha</th>
						<th>Hora</th>
						<th>Estado</th>
					</tr>
			  	</tfoot>

			  	<tbody>
				
				<?php
				while ($row=mysqli_fetch_array($query)){
					$folio=$row['folio'];
					$numero_factura=$row['numero_factura'];
					$activo=$row['activo'];
                                        if($activo==0){
                                            $mensaje="<font color=red>Anulado</font>";
                                        }
                                        if($activo==1){
                                            $mensaje="<font color=blue>Activo</font>";
                                        }
                                        $total=$row['total_venta'];
                                        $fecha=date("d/m/Y", strtotime($row['fecha_factura']));
                                        $hora=date("H:i", strtotime($row['fecha_factura']));
					?>
					<tr style="background-color: #81F7BE;color:black;">
                                                <td><?php print"$num"; ?></td>
                                                <td><?php print"$folio-$numero_factura"; ?></td>
						<td><?php echo $total; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $hora; ?></td>
                                                <td><?php echo $mensaje; ?></td>
					</tr>
					<?php
                                        $num=$num+1;
				}
				?>
				</tbody>
				
			  </table>
			</div>
			<?php
        }else{
          ?>
          <br><br><br>
          <div class="alert alert-danger alert-custom alert-dismissible">
            <br><br>
            <h4 class="alert-title">No hay Boletas</h4>
            <p>No se han encontrado boletas con la fecha seleccionada.</p>
            <br><br>
          </div>
          <br><br><br>
          <?php
        }}
      ?>
