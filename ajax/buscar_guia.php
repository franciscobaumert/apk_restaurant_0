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
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
                $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
                $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
		$sTable = "facturas, clientes, guia";
		$sWhere = "";
		$sWhere.=" WHERE guia.guia>0 and facturas.id_cliente=clientes.id_cliente and facturas.tienda=$tienda1 and facturas.ven_com=1 and facturas.estado_factura=1 and facturas.id_factura=guia.id_doc";
                if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' )";
		}
                if ( $_GET['q1'] != "" )
		{
		$sWhere.= " and  (guia.guia like '%$q1%' )";
		}
                
                if ( $_GET['q2'] != "" )
		{
		$sWhere.= " and  (DATE_FORMAT(guia.fecha, '%Y-%m-%d')='$q2' )";
		}
                
		$sWhere.=" order by facturas.id_factura asc";
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
			<div class="table-responsive">
			  <table id="example" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="bg-gray">
                        <th>Nro</th>
                        <th>Guia</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Factura</th>          
                        <th>Mensaje</th> 
                        <th>Editar</th>
                        <th>XML</th>
                        <th>CDR</th>
                        <th>PDF</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="bg-gray">
                        <th>Nro</th>
                        <th>Guia</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Factura</th>          
                        <th>Mensaje</th> 
                        <th>Editar</th>
                        <th>XML</th>
                        <th>CDR</th>
                        <th>PDF</th>
                    </tr>
                </tfoot>
				
                <tbody>
                		<?php
				while ($row=mysqli_fetch_array($query)){
                                    
                                                $id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
                                                $folio=$row['folio'];
                                                $serie=$row['serie'];
                                                $id_guia=$row['id'];
                                                $guia=$row['guia'];
						$fecha=date("d/m/Y", strtotime($row['fecha']));
						$nombre_cliente=$row['nombre_cliente'];
                                                $aceptado=$row['aceptado_guia'];
                                                $doc_guia=$row['doc_guia'].".XML";
                                                $cdr_guia="R-".$row['doc_guia'].".XML";
                                                $pos = strpos($aceptado, "aceptado");
                                                $aceptado2= "";
                                                $color="red";
                                                if ($pos === false) {
                                                    $aceptado1= "No enviada | Falta editar";
                                                    $aceptado2= "disabled";
                                                }else {
                                                   $aceptado1="Enviado y aceptado";
                                                   $aceptado2= "disabled";
                                                   $color="blue";
                                                }   
                                                
                                                
					?>
					<tr id="valor1">
                        <td><?php echo $numrows; ?></td>                   
						<td><?php print"$serie" ; ?>-<?php print"$guia" ; ?></td>
                                               
                                                <td><?php echo $fecha; ?></td>
						<td><?php echo $nombre_cliente;?></td>
                                              
                                                <td><?php print"$folio"; ?>-<?php print"$numero_factura"; ?></td>
                                                <td style="width: 15%; "><font color="<?php echo $color;?>"><?php echo $aceptado1;?></font></td>
                                                <td> <a href="guia.php?accion=<?php echo $id_factura;?>" class='btn btn-primary btn-xs' title='Guia de remision' ><i class="glyphicon glyphicon-download"></i></a> </td>
                                                
                                                
                                                 <td><?php
                                                if ($pos==true) {
                                                    ?>
                                                    <a  style="cursor: pointer;"  class='btn btn-success btn-xs' title='Descargar xml' onclick="imprimir_xmlguia('<?php echo $doc_guia;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                <?php
                                                }else{
                                                   ?>
                                                    <a  style="cursor: pointer;"  class='btn btn-success btn-xs' title='Xml no generado' ><i class="glyphicon glyphicon-download"></i></a> 
                                                <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($pos==true) {
                                                    ?>
                                                    <a  style="cursor: pointer;"  class='btn btn-info btn-xs' title='Descargar cdr' onclick="imprimir_cdrguia('<?php echo $cdr_guia;?>');"><i class="glyphicon glyphicon-download"></i></a>
                                               
                                                <?php
                                                }else{
                                                   ?>
                                                    <a  style="cursor: pointer;"  class='btn btn-info btn-xs' title='cdr no generado' ><i class="glyphicon glyphicon-download"></i></a> 
                                                <?php
                                                }
                                                ?> 
                                                </td>
                                                <td>
                                               
                                                    <a  style="cursor: pointer;"  class='btn btn-warning btn-xs' title='Descargar guia' onclick="imprimir_guia('<?php echo $id_guia;?>');"><i class="fa fa-file-pdf-o"></i></a>
                                               
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
            <h4 class="alert-title">No hay Guias</h4>
            <p>No se han agregado Guias a la base de datos.</p>
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