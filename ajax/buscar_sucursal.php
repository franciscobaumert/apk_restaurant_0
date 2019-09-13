<?php

	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
        $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_categoria=intval($_GET['id']);
		$query=mysqli_query($con, "select * from products where cat_pro='".$id_categoria."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM categorias WHERE id_categoria='".$id_categoria."'")){
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
			  <strong>Error!</strong> No se pudo eliminar ésta categoria.Existen productos asignados a esta categoría. 
			</div>
			<?php
		}	
	}
	if($action == 'ajax'){
            
		 $aColumns = array('nombre');//Columnas de busqueda
		 $sTable = "sucursal";
		 $sWhere = "";
		$sWhere.=" order by tienda asc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 999999; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './sucursal.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			?>
			<div class="table-responsive">
			  <table id="example" class="table table-bordered table-striped table-hover">
			  	<thead>
			  		<tr class="bg-gray">	
                                    <th>Logo</th>
                                    <th>Nombre</th>
                                    <th>Ruc</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
				</tr>
			  	</thead>

			  	<tfoot>
			  		<tr class="bg-gray">	
                                    <th>Logo</th>
                                    <th>Nombre</th>
                                    <th>Ruc</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
				</tr>
			  	</tfoot>
				
				<?php
				while ($row=mysqli_fetch_array($query)){
					$id_sucursal=$row['id_sucursal'];
					$nombre=$row['nombre'];
					$ruc=$row['ruc'];
                                        $direccion=$row['direccion'];
                                        $correo=$row['correo'];
					$telefono=$row['telefono'];
                                        $ubigeo=$row['ubigeo'];
                                        $departamento=$row['dep_suc'];
                                        $provincia=$row['pro_suc'];
                                        $distrito=$row['dis_suc'];
                                        $foto=$row['foto'];
                                        if($foto==""){
                                            $foto1="logo.jpg";
                                        }else{
                                            $foto1=$foto; 
                                        }
                                        $tien=$row['tienda'];
                                        ?>
                                        <input type="hidden" value="<?php echo $nombre;?>" id="nombre<?php echo $id_sucursal;?>">
					<input type="hidden" value="<?php echo $ruc;?>" id="ruc<?php echo $id_sucursal;?>">
					<input type="hidden" value="<?php echo $direccion;?>" id="direccion<?php echo $id_sucursal;?>">
					<input type="hidden" value="<?php echo $correo;?>" id="correo<?php echo $id_sucursal;?>">
                                        <input type="hidden" value="<?php echo $telefono;?>" id="telefono<?php echo $id_sucursal;?>">
                                        <input type="hidden" value="<?php echo $ubigeo;?>" id="ubigeo<?php echo $id_sucursal;?>">
                                        
                                        <input type="hidden" value="<?php echo $departamento;?>" id="departamento<?php echo $id_sucursal;?>">
                                        <input type="hidden" value="<?php echo $provincia;?>" id="provincia<?php echo $id_sucursal;?>">
                                        <input type="hidden" value="<?php echo $distrito;?>" id="distrito<?php echo $id_sucursal;?>">

                    <tbody>
                    	<tr id="valor1">
					<td><img width="100" height="30" src="pdf/documentos/<?php echo $foto1; ?>"</td>
					<td><?php echo $nombre; ?></td>
					<td><?php echo $ruc; ?></td>
                                        <td><?php echo $telefono; ?></td>
                                        <td><?php echo $correo; ?></td>
                                        <td>
                                            <a href="sucursal2.php?accion=<?php echo $tien;?>" class='btn btn-success btn-xs' title='Editar logo'><i class="fa fa-image"></i></a>                                   
                                            <a href="#" class='btn btn-warning btn-xs' title='Editar sucursal' onclick="obtener_datos('<?php echo $id_sucursal;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i></a> 
					</td>	
					</tr>
                    </tbody>
                                   
					<?php
				}
				?>
			  </table>
			</div>
			<?php
        }else{
          ?>
          <br><br><br>
          <div class="alert alert-danger alert-custom alert-dismissible">
            <br><br>
            <h4 class="alert-title">No hay Tiendas</h4>
            <p>No se han agregado Tiendas a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Tiendas"</b>.</p>
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


  