<?php

	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$user_id=intval($_GET['id']);
		$query=mysqli_query($con, "select * from users where user_id='".$user_id."'");
		$rw_user=mysqli_fetch_array($query);
		$count=$rw_user['user_id'];
                $query1=mysqli_query($con, "select * from detalle_factura where id_vendedor='".$user_id."'");
		$count1=mysqli_num_rows($query1);
                $query3=mysqli_query($con, "select * from facturas where id_vendedor='".$user_id."'");
		$count3=mysqli_num_rows($query3);
                $query4=mysqli_query($con, "select * from servicio where user_id='".$user_id."'");
		$count4=mysqli_num_rows($query4);
		if ($count>1 && $count1==0 && $count3==0 && $count4==0){
			if ($delete1=mysqli_query($con,"DELETE FROM users WHERE user_id='".$user_id."'")){
			?>
			<script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.success("Usuario eliminado","Exito");
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
            toastr.warning("Usuario asociada con otros datos","Precaucion");
                </script>
			<?php
		}
        }
	if($action == 'ajax'){
		$aColumns = array('nombres', 'user_name');//Columnas de busqueda
		$sTable = "users";
		$sWhere = "";
		$sWhere.=" order by user_id desc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 999999; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './usuarios.php';
		$sql="SELECT * FROM  $sTable $sWhere";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table id="example" class="table table-bordered table-striped table-hover">
                               
                              <thead>
				<tr class="bg-gray">
                    <th>Nro</th>
					<th>Foto</th>
					<th>Nombres</th>
					<th>Usuario</th>
					<th>Email</th>
                                        <th>DNI</th>
					<th><span>Acciones</span></th>
					
				</tr>
                                </thead>

                                <tfoot>
                <tr class="bg-gray">
                    <th>Nro</th>
                    <th>Foto</th>
                    <th>Nombres</th>
                    <th>Usuario</th>
                    <th>Email</th>
                                        <th>DNI</th>
                    <th><span>Acciones</span></th>
                    
                </tr>
                                </tfoot>

                <tbody>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                    $user_id=$row['user_id'];
                                    $fullname=$row['nombres'];
                                    $user_name=$row['user_name'];
                                    $user_email=$row['user_email'];
                                    $dni=$row['dni'];
                                    $dom=$row['domicilio'];
                                    $tel=$row['telefono'];
                                    $hora=$row['hora'];
                                    $sucursal=$row['sucursal'];
                                    $foto=$row['foto'];
                                    $date_added= date('d/m/Y', strtotime($row['date_added']));
                                    $accesos=$row['accesos'];
                                    $a=explode(".",$accesos);
                             	?>
				<tr id="valor1">
                                        <input type="hidden" value="<?php echo $row['nombres'];?>" id="nombres<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $user_name;?>" id="usuario<?php echo $user_id;?>">
					<input type="hidden" value="<?php echo $user_email;?>" id="email<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $dni;?>" id="dni<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $dom;?>" id="dom<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $tel;?>" id="tel<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $hora;?>" id="hora<?php echo $user_id;?>">
                                        <input type="hidden" value="<?php echo $sucursal;?>" id="sucursal<?php echo $user_id;?>">
                                        <td><?php echo $numrows; ?></td>
                                        <td> 
                                            <img src="images/<?php echo $foto;?>" class="" alt="Avatar" width="30">
                                        </td>
						<td><?php echo $fullname; ?></td>
						<td><?php echo $user_name; ?></td>
						<td ><?php echo $user_email; ?></td>
						 <td><?php echo $dni;?></td>
						
					<td>
					<a href="acceso.php?usuario=<?php echo $fullname;?>" class='btn btn-info btn-xs' title='Acceso'><i class="fa fa-key"></i></a>        
                                        <a href="user2.php?accion=<?php echo $user_id;?>" class='btn btn-success btn-xs' title='Editar foto'><i class="fa fa-picture-o"></i></a>        
                                        <a href="#" class='btn btn-warning btn-xs' title='Editar usuario' onclick="obtener_datos('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i></a> 
					<a href="#" class='btn btn-primary btn-xs' title='Cambiar clave' onclick="get_user_id('<?php echo $user_id;?>');" data-toggle="modal" data-target="#myModal3"><i class="fa fa-lock"></i></a>
					<a href="#" class='btn btn-danger btn-xs' title='Borrar usuario' onclick="eliminar('<?php echo $user_id; ?>')"><i class="glyphicon glyphicon-trash"></i></a>
                                        
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
            <h4 class="alert-title">No hay Usuarios</h4>
            <p>No se han agregado Usuarios a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Usuarios"</b>.</p>
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