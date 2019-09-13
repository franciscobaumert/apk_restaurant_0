<?php

	
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos

    $tienda1=$_SESSION['tienda'];
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_mesa=intval($_GET['id']);
		$query=mysqli_query($con, "select * from facturas where id_mesa='".$id_mesa."'");
		$count=mysqli_num_rows($query);
                
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM mesas WHERE id_mesa='".$id_mesa."'")){
			?>
			<script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.success("Mesa eliminada","Exito");
                </script>
			<?php 
		}else {
			?>
			<script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.error("Error desconocido","Error");
                </script>
			<?php
			
		}
			
		} else {
			?>
			<script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.warning("Mesa asociada con ventas","Precaucion");
                </script>
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nom_cat');//Columnas de busqueda
		 $sTable = "mesas, salas";
		 $sWhere = "";
		
		$sWhere.="WHERE mesas.id_sala=salas.id_sala and mesas.tienda=$tienda1";
        $sWhere.=" order by mesas.id_mesa desc";
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
		$reload = './mesas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table id="example" class="table table-bordered table-striped table-hover">
                                <thead>
				<tr class="bg-gray">
                    <th>Nro</th>
					<th>Nombre Sala</th>
                    <th>Nombre | Numero Mesa</th>
					<th>Estado</th>
                    <th>Fecha Creada</th>
                                        <th>Acciones</th>
					
				</tr>
                                </thead>

                                <tfoot>
                <tr class="bg-gray">
                    <th>Nro</th>
                    <th>Nombre Sala</th>
                    <th>Nombre | Numero Mesa</th>
                    <th>Estado</th>
                    <th>Fecha Creada</th>
                                        <th>Acciones</th>
                    
                </tr>
                                </tfoot>
                                <tbody>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_mesa=$row['id_mesa'];
                        $nombre_sala=$row['nombre_sala'];
						$id_sala=$row['id_sala'];
						$nombre_mesa=$row['nombre_mesa'];
                        $status_mesa=$row['status_mesa'];
                        $mesa_creada=$row['mesa_creada'];

                        if ($status_mesa==0){$text_estado="DISPONIBLE";$label_class='label-success';}
                        else{$text_estado="OCUPADA";$label_class='label-warning';}
				        
					?>
					
                                        <tr>
                                                <input type="hidden" value="<?php echo $nombre_sala;?>" id="nombre_sala<?php echo $id_mesa;?>">
                                                <input type="hidden" value="<?php echo $id_sala;?>" id="id_sala<?php echo $id_mesa;?>">
                                                <input type="hidden" value="<?php echo $nombre_mesa;?>" id="nombre_mesa<?php echo $id_mesa;?>">
                                                <input type="hidden" value="<?php echo $status_mesa;?>" id="status_mesa<?php echo $id_mesa;?>">
                                                <input type="hidden" value="<?php echo $mesa_creada;?>" id="mesa_creada<?php echo $id_mesa;?>">
					<td><?php echo $numrows; ?></td>
					<td><?php echo $nombre_sala; ?></td>
					<td><?php echo $nombre_mesa; ?></td>
                    <td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
                    <td><?php echo $mesa_creada; ?></td>
                                        <td >
					<a href="#" class='btn btn-warning btn-xs' title='Editar mesa' onclick="obtener_datos('<?php echo $id_mesa;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i></a> 
					<a href="#" class='btn btn-danger btn-xs' title='Borrar mesa' onclick="eliminar('<?php echo $id_mesa; ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
						
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
            <h4 class="alert-title">No hay Mesas</h4>
            <p>No se han agregado Mesas a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Mesas"</b>.</p>
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


  
 