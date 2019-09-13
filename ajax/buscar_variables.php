<?php

	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_variable=intval($_GET['id']);
		$query=mysqli_query($con, "select * from asistencia where asistencia='".$id_variable."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM laborales WHERE id_laboral='".$id_variable."'")){
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
			  <strong>Error!</strong> No se pudo eliminar ésta variable. 
			</div>
			<?php
		}	
	}
	if($action == 'ajax'){
         //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$aColumns = array('variables','cod_var','des_var');//Columnas de busqueda
		$sTable = "laborales";
		$sWhere = "";
		$sWhere.=" order by id_laboral asc";
		include 'pagination.php'; //include pagination file
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './variableslab.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){ ?>
			<div class="table-responsive">
			  <table id="example" class="table table-bordered table-striped table-hover">
			  	<thead>
			  		<tr class="bg-gray">
			  			<th>Nro</th>
                        <th>Color</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
					</tr>
			  	</thead>

			  	<tfoot>
			  		<tr class="bg-gray">
			  			<th>Nro</th>
                        <th>Color</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
					</tr>
			  	</tfoot>

			  	<tbody>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$id_laboral=$row['id_laboral'];
					$variables=$row['variables'];
					$des_var=$row['des_var'];
					$col_var=$row['col_var'];
                    $cod_var=$row['cod_var'];   
					?>
					<input type="hidden" value="<?php echo $variables;?>" id="variables<?php echo $id_laboral;?>">
					<input type="hidden" value="<?php echo $des_var;?>" id="des_var<?php echo $id_laboral;?>">
					<input type="hidden" value="<?php echo $cod_var;?>" id="cod_var<?php echo $id_laboral;?>">
					<input type="hidden" value="<?php echo $col_var;?>" id="col_var<?php echo $id_laboral;?>">

                    <tr>
                    	<td><?php echo $numrows; ?></td>
                        <td bgcolor="<?php echo $col_var; ?>"> </td>
                        <td><?php echo $cod_var; ?></td>
                        <td><?php echo $variables; ?></td>
                        <td><?php echo $des_var; ?></td>
                        <td>
                            <?php
                            if($id_laboral>0){
                            ?>
                            <span class="pull-right"><a href="#" class='btn btn-warning btn-xs' title='Editar variable' onclick="obtener_datos('<?php echo $id_laboral;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i></a> 
                            <a href="#" class='btn btn-danger btn-xs' title='Borrar variable' onclick="eliminar('<?php echo $id_laboral; ?>')"><i class="glyphicon glyphicon-trash"></i></a></span>
							<?php }?>
                        </td>
					</tr>
					<?php $numrows=$numrows-1; } ?>
				</tbody>
			  </table>
			</div>
			<?php
        }else{ ?>
        <br><br><br>
        <div class="alert alert-danger alert-custom alert-dismissible">
	        <br><br>
	        <h4 class="alert-title">No hay Variables</h4>
	        <p>No se han agregado Variables a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Variables"</b>.</p>
	        <br><br>
        </div>
        <br><br><br>
        <?php } } ?>

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