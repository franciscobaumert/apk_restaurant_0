<?php

	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$tienda1=$_SESSION['tienda'];
        $usuario=$_SESSION['user_id'];
        date_default_timezone_set('America/Santiago');
        $fecha1  = date("Y-m-d H:i:s");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_factura=intval($_GET['id']);
		$del1="UPDATE facturas set activo=0 where id_factura='".$id_factura."'";
                $sql1=mysqli_query($con, "select * from facturas where id_factura='".$id_factura."'");
                while ($row1=mysqli_fetch_array($sql1))
                {
                    $numero_factura=$row1["numero_factura"];
                    $tipo_doc=$row1["estado_factura"];
                    $tienda=$row1["tienda"];
                    $id_cliente=$row1["id_cliente"];
         
                }
                $sql=mysqli_query($con, "select * from detalle_factura where numero_factura='".$numero_factura."' and ven_com=2 and tienda=$tienda and id_cliente=$id_cliente and tipo_doc=$tipo_doc" );
                while ($row=mysqli_fetch_array($sql))
                {
                    $id_producto=$row["id_producto"];
                    $tienda=$row["tienda"];
                    $cantidad=$row["cantidad"];
                    $b="b".$tienda;
                    $productos1=mysqli_query($con, "UPDATE products SET $b=$b-$cantidad WHERE id_producto=$id_producto");
                    $sql1=mysqli_query($con, "select * from products where id_producto='".$id_producto."'");
                    while ($row1=mysqli_fetch_array($sql1))
                    {
                        $b=$row1["b$tienda"];
                    }
                    $c=$b+$cantidad;  
                    $insert=mysqli_query($con,"INSERT INTO detalle_factura VALUES (NULL,'$id_cliente','$usuario','$numero_factura','1','$id_producto','$cantidad','0','$tienda1','0','1','$fecha1','0','$tipo_doc','$c','1','')");  
         
                }
                $del2="UPDATE detalle_factura set activo=0 where numero_factura='".$numero_factura."' and ven_com=2 and tienda=$tienda and tipo_doc=$tipo_doc and id_cliente=$id_cliente";
        
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
            <script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.success("Compra eliminada","Exito");
            </script>
			<?php 
		}else {
			?>
            <script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.error("No se puede eliminar la compra","Error");
            </script>
			<?php	
		}
	}
	if($action == 'ajax'){
        //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$sTable = "facturas, clientes, users";
		$sWhere = "";
		$sWhere.=" WHERE facturas.id_cliente=clientes.id_cliente and facturas.id_vendedor=users.user_id and ven_com=2 and activo=1 and facturas.tienda=$tienda1";
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
	                                        <th>Doc</th>
	                                        <th>Tipo</th>
	                                	<th>Fecha</th>
						<th>Proveedor</th>
						<th>Usuario</th>
						<th>Estado</th>
						<th class='text-right'>Total</th>
	                                        <!--<th class='text-right'>Deuda</th>-->
						<th class='text-right'>Acciones</th>	
					</tr>
			  	</thead>

			  	<tfoot>
			  		<tr class="bg-gray">
						<th>Nro</th>
	                                        <th>Doc</th>
	                                        <th>Tipo</th>
	                                	<th>Fecha</th>
						<th>Proveedor</th>
						<th>Usuario</th>
						<th>Estado</th>
						<th class='text-right'>Total</th>
	                                        <!--<th class='text-right'>Deuda</th>-->
						<th class='text-right'>Acciones</th>	
					</tr>
			  	</tfoot>
				
				<tbody>

				<?php
				while ($row=mysqli_fetch_array($query)){
                                                $activo=$row['activo'];
                                                $id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
                        $folio=$row['folio'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$nombre_cliente=$row['nombre_cliente'];
                                                $moneda=$row['moneda'];
                                                if($moneda==1){
                                                    $mon="S/.";
                                                }else{
                                                    $mon="USD";
                                                }
                                                $estado_factura=$row['estado_factura'];
                                                if($estado_factura==1){
                                                    $estado1="Factura";   
                                                }
                                                if($estado_factura==2){
                                                    $estado1="Boleta"; 
                                                }
                                                if($estado_factura==3){
                                                    $estado1="Guia"; 
                                                }
						$telefono_cliente=$row['telefono_cliente'];
						$email_cliente=$row['email_cliente'];
                                                $ruc=$row['doc'];
                                                
                                                $deuda=$row['deuda_total']-$row['cuenta1'];
						$nombre_vendedor=$row['user_name'];
						if ($deuda==0){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Credito";$label_class='label-warning';}
						$total_venta=$row['total_venta'];    
					?>
					<tr id="valor1">
						<td><?php echo $numrows; ?></td>
						<td><?php echo $folio; ?>-<?php echo $numero_factura; ?></td>
                                                <td><?php echo $estado1; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $nombre_cliente;?></td>
						<td><?php echo $nombre_vendedor; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-right'><?php print"$mon ";echo number_format ($total_venta,2); ?></td>
                                                <!--<td class='text-right'><?php print"$mon ";echo number_format ($deuda,2); ?></td>-->
                                                <td class="text-right">
                                                    <a href="#" class='btn btn-primary btn-xs' title='Descargar documento' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="glyphicon glyphicon-download"></i></a> 
                                                    <a href="#" class='btn btn-danger btn-xs' title='Borrar documento' onclick="eliminar('<?php echo $id_factura; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>
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
            <h4 class="alert-title">No hay Compras</h4>
            <p>No se han agregado Compras a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Compras"</b>.</p>
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