<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	$tienda1=$_SESSION['tienda'];
        $usuario=$_SESSION['user_id'];
        date_default_timezone_set('America/Santiago');
        $fecha1  = date("Y-m-d H:i:s");
 	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_factura=intval($_GET['id']);
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$sTable = "resumen_documentos";
		$sWhere = "";
		$sWhere.=" WHERE id_resumen>0";
                if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (numero like '%$q%' or fecha like '%$q%' )";
		}
		$sWhere.=" order by fecha desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 999999; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive" style="height: 300px;">
			  <table class="table table-bordered table-striped table-hover">
			  	<thead>
			  		<tr class="bg-gray">
			  			<th>Nro</th>
                                <th>Numero</th>
                              
                                <th>Fecha</th>
				
					<th class='text-center'>Nombre XML</th>
	                                <th class='text-center'>Ticket</th>
	                                <th class='text-center'>Mensaje</th>
	                                <th class='text-center'>XML</th>
	                                <th class='text-center'>CDR</th>
					</tr>
			  	</thead>

			  	<tbody>
				
                		<?php
				while ($row=mysqli_fetch_array($query)){
                                    
                                                $id=$row['id_resumen'];
                                                
						$numero_factura=$row['numero'];
						$fecha=$row['fecha'];
                                                $xml=$row['xml'];
                                                $doc=$xml.".".'XML';
                                                $cdrdoc="R-".$xml.".".'XML';
                                                $ticket=$row['ticket'];
					?>
					<tr id="valor1">
                        <td><?php echo $numrows; ?></td>
						<td><?php print"$numero_factura" ; ?></td> 
                                                <td><?php echo $fecha; ?></td>
                                                <td class='text-center'><?php echo $xml; ?></td>
                                                <td class='text-center'><?php echo $ticket; ?></td>
                                                <?php
                                                if($ticket<>""){
                                                    ?>
                                                <td class='text-center'><font color="blue"><strong>Enviado y aceptado</strong></font></td>
                                                <?php
                                                }
                                                 ?>
                                            	<td class="text-center">
                                                    <a style="cursor: pointer;" class='btn btn-info btn-xs' title='Descargar xml' onclick="resumen('<?php echo $doc;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                </td>
                                                <td class="text-center">
                                                    <a style="cursor: pointer;" class='btn btn-success btn-xs' title='Descargar xml' onclick="cdrresumen('<?php echo $cdrdoc;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                </td>
					</tr>
					<?php
                                        
                                       $numrows=$numrows-1;  
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
            <h4 class="alert-title">No hay Resumen</h4>
            <p>No se han agregado Resumen a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Resumen"</b>.</p>
            <br><br>
          </div>
          <br><br><br>
          <?php
        }}
      ?>
