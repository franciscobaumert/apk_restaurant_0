<style>
    table tr:nth-child(odd) {background-color: #FBF8EF;}
table tr:nth-child(even) {background-color: #EFFBF5;}
 #valor1 {            
border-bottom: 2px solid #F5ECCE;
}  
#valor1:hover {             
background-color: white;
border-bottom: 2px solid #A9E2F3;
} 
.dt-button.red {
    color: black;
    background:red;
}
.dt-button.orange {
    color: black;
    background:orange;
}
.dt-button.green {
    color: black;
    background:green;
} 
.dt-button.green1 {
    color: black;
    background:#01DFA5;
}  
.dt-button.green2 {
    color: black;
    background:#2E9AFE;
}
tfoot{
    display: table-header-group;
}
</style>
<?php
        include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$tienda1=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else{
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php	
		}
	}
	if($action == 'ajax'){
		$sTable = "clientes";
		$sWhere = "";
		$sWhere.=" WHERE clientes.debe>0";
		$sWhere.=" order by clientes.nombre_cliente asc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
		$sql="SELECT * FROM  $sTable $sWhere ";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table id="example" class="display nowrap" style="width:100%">
                            <tfoot>
                        	<tr>
                                    <th>#</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
				</tr>
                            </tfoot>
                            <thead>
                                <tr  style="background-color:#FE9A2E;color:white; ">
                                    <th>Proveedor</th>
                                    <th>RUC</th>
                                    <th>DNI</th>
                                    <th>Telefono</th>
                                    <th>Deuda</th>
                                    <th class='text-right'>Acciones</th>
				</tr>
                                </thead>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                    $id_cliente=$row['id_cliente'];
                                    $nombre_cliente=$row['nombre_cliente'];
                                    $telefono_cliente=$row['telefono_cliente'];
                                    $email_cliente=$row['email_cliente'];
                                    $telefono=$row['telefono_cliente'];
                                    $ruc=$row['doc'];
                                    $dni=$row['dni'];
                                    $mon="S/.";
                                    $deuda=$row['debe'];
                                    ?>
				<tr id="valor1">
                                    <td><?php echo $nombre_cliente;?></td>
                                    <td><?php echo $ruc;?></td>
                                    <td><?php echo $dni;?></td>
                                    <td><?php echo $telefono;?></td>
                                    <td class='text-right'><?php print"$mon"; echo number_format ($deuda,2); ?></td>	
                                    <td class="text-right">
					<a href="#" class='btn btn-primary btn-xs' title='Descargar Pagos' onclick="imprimir_cobros('<?php echo $id_cliente;?>');"><i class="glyphicon glyphicon-download"></i></a> 
					<a href="pago1.php?a=<?php echo $id_cliente;?>" class='btn btn-warning btn-xs' title='Realizar Pagos' ><i class="glyphicon glyphicon-edit"></i></a> 
                                    </td>
                                    <input type="hidden" value="<?php echo $nombre_cliente;?>" id="cliente<?php echo $id_cliente;?>">
                                    <input type="hidden" value="<?php echo $deuda;?>" id="deuda<?php echo $id_cliente;?>">    
                                </tr>
				<?php
				}
				?>
			</table>
                    </div>
		<?php
		}
        }
	
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
        "processing": "Procesando...",
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
    initComplete: function () {
            this.api().columns([0,1,2,3,4,8,9]).every( function () {
                var column = this;
                var select = $('<select><option value="">Buscar</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    var val = $('<span/>').html(d).text();
                select.append( '<option value="' + val + '">' + val + '</option>' );
                } );
            } );
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
                    extend: 'pageLength',
                    text: 'Mostrar filas',
                    className: 'orange'
                },
                
                {
                    extend: 'copy',
                    text: 'COPIAR',
                    className: 'red'
                },
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    className: 'green'
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'green1'
                },
                {
                    extend: 'print',
                    text: 'IMPRIMIR',
                    className: 'green2'
                }
            ],
    } );
} );
</script>