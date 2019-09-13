<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$tienda1=$_SESSION['tienda'];
        $usuario=$_SESSION['user_id'];
        date_default_timezone_set('America/Santiago');
        $fecha1  = date("Y-m-d H:i:s");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
                $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
                $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
		$sTable = "facturas, clientes, users";
		$sWhere = "";
		$sWhere.=" WHERE facturas.id_cliente=clientes.id_cliente and facturas.tienda=$tienda1 and facturas.id_vendedor=users.user_id and facturas.ven_com=1 and facturas.estado_factura<8 and facturas.activo=0 and facturas.numero_factura>0";
                if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' )";
		}
                if ( $_GET['q1'] != "" )
		{
		$sWhere.= " and  (facturas.numero_factura like '%$q1%' )";
		}
                
                if ( $_GET['q2'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$q2' )";
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
		$reload = './facturas.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table id="example" class="table table-bordered table-striped table-hover">
          <thead>
            <tr class="bg-gray">
              <th>Nro</th>
                                        <th>Nro Doc</th>
                                        <th class='text-right'>Tipo de Doc</th>
                            <th>Fecha</th>
              <th>Cliente</th>
                                            <th class='text-right'>Total</th>
                                            <!--<th class='text-right'>Deuda</th>-->
                                            <th>Vendedor</th>
                                            <th>Ticket</th>
                                            <th class='text-center'>Mensaje</th>
                                            <th class='text-right'>XML</th>
                                            <th class='text-right'>CDR</th>
                                            
                                            <th class='text-right'>PDF</th> 
            </tr>
          </thead>

          <tfoot>
            <tr class="bg-gray">
              <th>Nro</th>
                                        <th>Nro Doc</th>
                                        <th class='text-right'>Tipo de Doc</th>
                            <th>Fecha</th>
              <th>Cliente</th>
                                            <th class='text-right'>Total</th>
                                            <!--<th class='text-right'>Deuda</th>-->
                                            <th>Vendedor</th>
                                            <th>Ticket</th>
                                            <th class='text-center'>Mensaje</th>
                                            <th class='text-right'>XML</th>
                                            <th class='text-right'>CDR</th>
                                            
                                            <th class='text-right'>PDF</th> 
            </tr>
          </tfoot>

          <tbody>
				
				<?php
				while ($row=mysqli_fetch_array($query)){
                                                $activo=$row['activo'];
                                                $id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
                        $resumen=$row['resumen'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
                                                $ruc=$row['doc'];
						$email_cliente=$row['email_cliente'];
                                                $baja=$row['baja'];
                                                $dni=$row['dni'];
                                                $folio=$row['folio'];
						$nombre_vendedor=$row['nombres'];
                                                $estado_factura1=$row['estado_factura'];
						$estado_factura=$row['condiciones'];
                                                $ven_com=$row['ven_com'];
                                                $moneda=$row['moneda'];
                                                $aceptado=$row['aceptado'];
                                                $pos = strpos($aceptado, "aceptada");
                                                if ($pos === false) {
                                                        $aceptado1= "No enviado";
                                                }else{
                                                    $aceptado1= "Aceptada";
   
                                                }
                                                
                                                $mon="S/.";
                                                if($estado_factura1==1){
                                                    $estado1="Factura";
                                                    
                                                }
                                                if($estado_factura1==2){
                                                    $estado1="Boleta";  
                                                }
                                                
                                                
                                                $deuda=$row['deuda_total'];
                                               
                                               
                                                $ticket="";
                                                $sql1="SELECT * FROM  baja_sunat Where id_doc1=$id_factura";
                                                $query1 = mysqli_query($con, $sql1);
                                                while ($row1=mysqli_fetch_array($query1)){
                                                    $ticket=$row1['ticket'];
                                       
                                                }
                                                $xml=$baja.".XML";
						$cdr="R-".$baja.".XML";
						$total_venta=$row['total_venta'];
					?>
					<tr id="valor1">
            <td><?php echo $numrows; ?></td>                              
						<td><?php print"$folio"; ?>-<?php print"$numero_factura"; ?></td>
                                                <td><?php echo $estado1; ?></td>
                                                <td><?php echo $fecha; ?></td>
						<td ><?php echo $nombre_cliente;?></td>   
                                                <td class='text-right'><?php print"$mon"; echo number_format ($total_venta,2); ?></td>					
                                                <!--<td class='text-right'><?php print"$mon"; echo number_format ($deuda,2); ?></td>-->
                                                <td><?php echo $nombre_vendedor; ?></td>
                                                <td><?php echo $ticket; ?></td>
                                                <td class="text-right">
						   
                                                  <?php
                                                  //print"$estado_factura1 $baja $aceptado1";
                                                  if($estado_factura1==1 && $baja=="0" ){
                                                       ?>
                                                   <a  style="cursor: pointer;" class='btn btn-danger btn-xs' title='Enviar doc de baja' onclick="imprimir_facturas1('<?php echo $id_factura;?>');"><i class="fa fa-paper-plae"> Enviar</i></a> 
						  <?php 
                                                  }else{
                                                      if($estado_factura1==1){
                                                          print"<font color=blue><strong>Enviado y aceptado</strong></font>";
                                                      }else{
                                                        if ($resumen==0) {
                                                           print"<font color=red><strong>Enviar en resumen</strong></font>";
                                                        } else
                                                            print"<font color=blue><strong>Enviado en resumen</strong></font>";
                                                          
                                                      }
                                                      
                                                  }
                                                  
                                                  ?>    
                                                </td>
                                                <td>
                                                    <?php
                                                    if($estado_factura1<=2 && $baja<>"0" ){
                                                       ?>
                                                    <a  style="cursor: pointer;" class='btn btn-info btn-xs' title='XML' onclick="xml('<?php echo $xml;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                                    
                                                    <?php 
                                                    }
                                                    ?> 
                                                </td>
                                                 <td>
                                                    <?php
                                                    if($estado_factura1<=2 && $baja<>"0" ){
                                                       ?>
                                                   
                                                     <a  style="cursor: pointer;" class='btn btn-success btn-xs' title='CDR' onclick="cdrxml('<?php echo $cdr;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                                    <?php 
                                                    }
                                                    ?> 
                                                </td>
                                                
						
                                                <td class="text-right">
                                                    <a  style="cursor: pointer;" class='btn btn-primary btn-xs' title='Descargar doc' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="fa fa-file-pdf-o"></i></a> 
						 
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
            <h4 class="alert-title">No hay Anulaciones</h4>
            <p>No se han anulado ventas.</p>
            <br><br>
          </div>
          <br><br><br>
          <?php
        }}
      ?>

<script>
$(document).ready(function() {
    
    
        $('#example').DataTable( {
        language: {
        "url": "/dataTables/i18n/de_de.lang",
                "decimal": "",
        "show": "Mostrar",
        "emptyTable": "No hay informacion",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "<img src='./assets/itsolution24/img/loading2.gif'>",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        buttons: {
                copyTitle: 'Copiar filas al portapapeles',
                
                copySuccess: {
                    _: 'Copiado %d fias ',
                    1: 'Copiado 1 fila'
                },
                
                pageLength: {
                _: "Mostrar %d filas",
                '-1': "Mostrar Todo"
            }
            },
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }

    },

         bDestroy: true,
            dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        buttons: 

         [
                
             {
                    extend: 'colvis',
                    text: 'Columnas',
                    className: 'green2',
                    exportOptions: {
                    columns: ':visible'
                }
                
                },   
                          
{
                    extend: 'pageLength',
                    text: 'Filas',
                    className: 'orange',
                    exportOptions: {
                    columns: ':visible'
                }
                
                },
                
                {
                    extend: 'copy',
                    text: '<i class="fa fa-copy"></i>',
                    className: 'red',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'green',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    className: 'green',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file"></i>',
                    className: 'green1',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    className: 'green2',
                    exportOptions: {
                    columns: ':visible'
                }
                },
            ],
         "pageLength": 10,
        
    } );

} );
</script>