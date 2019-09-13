<?php
    include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$tienda1=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_cliente=intval($_GET['id']);
		$query=mysqli_query($con, "select * from facturas where id_cliente='".$id_cliente."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM clientes WHERE id_cliente='".$id_cliente."'")){
			?>
			<script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.success("Cliente eliminado","Exito");
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
            toastr.warning("Cliente asociado con documentos","Precaucion");
                </script>
			<?php
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         //$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$aColumns = array('nombre_cliente','doc');//Columnas de busqueda
		$sTable = "clientes";
		$sWhere = " ";
        include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 999999; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable WHERE tipo1=1 and tienda=$tienda1 ");
                $row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
                $reload = './clientes.php';
                $sql="SELECT * FROM  $sTable WHERE tipo1=1 and tienda=$tienda1 ";
                $query = mysqli_query($con, $sql);
		if ($numrows>0){	
			?>
			<div class="table-responsive">
			  <table id="example" class="table table-bordered table-striped table-hover">
                             
                              <thead>
				<tr class="bg-gray">
                                    <th>Nro</th>
                                    <th>Razon Social</th>
                                    <th>Documento</th>
                                    <th>Tipo</th>
                                    <th style="width: 20px;">Telefono</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
					
				</tr>
                                 </thead>

                                 <tfoot>
                <tr class="bg-gray">
                                    <th>Nro</th>
                                    <th>Razon Social</th>
                                    <th>Documento</th>
                                    <th>Tipo</th>
                                    <th style="width: 20px;">Telefono</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                    
                </tr>
                                 </tfoot>

                                 <tbody>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_cliente=$row['id_cliente'];
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
						$email_cliente=$row['email_cliente'];
						$direccion_cliente=$row['direccion_cliente'];
                                                
                                                
                                                $doc=$row['doc'];
                                                $dni=$row['dni'];
                                                $ce=$row['ce'];
                                                if($doc>0){
                                                    $doc1=$doc;
                                                    $tipo="RUC";
                                                    $tipo1="2";
                                                }
                                                if($dni>0){
                                                    $doc1=$dni;
                                                    $tipo="DNI";
                                                    $tipo1="1";
                                                }
                                                if($ce>0){
                                                    $doc1=$ce;
                                                    $tipo="CE";
                                                    $tipo1="3";
                                                }
                                                
                                                $departamento=$row['departamento'];
                                                $provincia=$row['provincia'];
                                                $distrito=$row['distrito'];
                                                $cuenta=$row['cuenta'];
                                                $vendedor=$row['vendedor'];
						$status_cliente=$row['status_cliente'];
						if ($status_cliente==1){$estado="Activo";}
						else {$estado="Inactivo";}
						$date_added= date('d/m/Y', strtotime($row['date_added']));
						
					?>
				    <tr id="valor1">
                                        <input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $telefono_cliente;?>" id="telefono_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $email_cliente;?>" id="email_cliente<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $doc1;?>" id="doc<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $vendedor;?>" id="vendedor<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $direccion_cliente;?>" id="direccion_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $status_cliente;?>" id="status_cliente<?php echo $id_cliente;?>">
					
                                        <input type="hidden" value="<?php echo $departamento;?>" id="departamento<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $provincia;?>" id="provincia<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $distrito;?>" id="distrito<?php echo $id_cliente;?>">
                                        <input type="hidden" value="<?php echo $cuenta;?>" id="cuenta<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $tipo;?>" id="tipo<?php echo $id_cliente;?>">
                                        <td><?php echo $numrows; ?></td>
					<td width="300"><?php echo $nombre_cliente; ?></td>
                                        <td><?php echo $doc1; ?></td>
                                        <td><?php echo $tipo; ?></td>
					<td><?php echo $telefono_cliente; ?></td>
					<td><?php echo $email_cliente;?></td>
					<td><?php echo $estado;?></td>	
					<td >
					<a href="#" class='btn btn-warning btn-xs' title='Editar cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i></a> 
					<a href="#" class='btn btn-danger btn-xs' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></td>	
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
            <h4 class="alert-title">No hay Clientes</h4>
            <p>No se han agregado Clientes a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Clientes"</b>.</p>
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