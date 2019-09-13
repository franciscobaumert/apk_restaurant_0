<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
    $tienda1=$_SESSION['tienda'];
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_producto=intval($_GET['id']);
		$query=mysqli_query($con, "select * from detalle_factura where id_producto='".$id_producto."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM products WHERE id_producto='".$id_producto."'")){
			?>
			<script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.success("Producto eliminado","Exito");
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
            toastr.warning("Producto asociado con documentos","Precaucion");
                </script>
			<?php
		}
        }
	if($action == 'ajax'){
	$query1=mysqli_query($con, "select * from datosempresa where id_emp=1");
        $row1=mysqli_fetch_array($query1);
        $alerta=$row1['alerta'];
        $aColumns = array('codigo_producto', 'nombre_producto');//Columnas de busqueda
        $sTable = "products";
        $sWhere = " ";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 999999; 
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");     
		        $row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		        $reload = './productos.php';
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
					<th>Código</th>
					<th>Producto</th>
                                        <th>Stock</th>
					<th>Tipo</th>
                                        <!--<th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Color</th>-->
                                        <th>Precio</th>
					
                                        <th>Acciones</th>
				</tr>
                                </thead>

                                <tfoot>
                <tr class="bg-gray">
                    <th>Nro</th>
                                        <th>Foto</th>
                    <th>Código</th>
                    <th>Producto</th>
                                        <th>Stock</th>
                    <th>Tipo</th>
                                        <!--<th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Color</th>-->
                                        <th>Precio</th>
                    
                                        <th>Acciones</th>
                </tr>
                                </tfoot>

                                <tbody>
				<?php
                                $i=0;
				while ($row=mysqli_fetch_array($query)){
					$pro_ser=$row['pro_ser'];
                                        if ($pro_ser==1){
                                            
                                            if($i%2==0){
                                                $table="valor1";
                                            }else{
                                                $table="valor2";
                                            }
                                            $i=$i+1;
                                            $id_producto=$row['id_producto'];
                                            $codigo_producto=$row['codigo_producto'];
                                            $nombre_producto=$row['nombre_producto'];
                                            $status_producto=$row['status_producto'];
                                            $marca=$row['marca'];
                                            $modelo=$row['modelo'];
                                            $color=$row['color'];
                                            $cat_pro=$row['cat_pro'];
                                            $destino=$row['destino'];
                                            $options=$row['options'];
                                            $pro_ser=$row['pro_ser'];
                                            $foto=$row['foto1'];
                                            $tienda=$_SESSION['tienda'];   
                                            $b=$row["b$tienda"];
                                            $mon_venta=$row['mon_venta'];
                                            $dolar=$row['mon_costo'];
                                            $mon_costo=1;
                                            if($b<=$alerta)
                                            {$label_class='label-danger';}
                                            else
                                            {$label_class='label-success';}
                                            if ($status_producto==1){$estado="De venta";}
                                            if ($status_producto==0){$estado="Segunda";}
                                            if ($status_producto==2){$estado="Insumo";}
                                            $mon="S/";
                                            $date_added= date('d/m/Y', strtotime($row['date_added']));
                                            $precio_producto=$row['precio_producto'];
                                            $precio2=$row['precio2'];
                                            $precio3=$row['precio3'];
                                            $und_pro=$row['und_pro'];
                                            $costo_producto=$row['costo_producto']/$row['mon_costo'];
                                            $costo=$row['costo_producto'];
                                            $utilidad=$row['precio_producto']-$row['costo_producto'];
                                             
					?>
                                        <tr id="<?php echo $table;?>">
                                        <input type="hidden" value="<?php echo $codigo_producto;?>" id="codigo_producto<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $nombre_producto;?>" id="nombre_producto<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $b;?>" id="inv<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $estado;?>" id="estado<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo $marca;?>" id="marca<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $modelo;?>" id="modelo<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $color;?>" id="color<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $status_producto;?>" id="status<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $destino;?>" id="destino<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $options;?>" id="options<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $cat_pro;?>" id="cat<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $mon_venta;?>" id="mon_venta<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $mon_costo;?>" id="mon_costo<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $mon_costo;?>" id="mon_costo<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo number_format($dolar,2,'.','');?>" id="dolar<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo number_format($costo,2,'.','');?>" id="costo<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo number_format($precio_producto,2,'.','');?>" id="precio_producto<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo number_format($precio2,2,'.','');?>" id="precio2<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo number_format($precio3,2,'.','');?>" id="precio3<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo number_format($costo_producto,2,'.','');?>" id="costo_producto<?php echo $id_producto;?>">
					<input type="hidden" value="<?php echo number_format($utilidad,2,'.','');?>" id="utilidad<?php echo $id_producto;?>">
                                        <input type="hidden" value="<?php echo $und_pro;?>" id="und_pro<?php echo $id_producto;?>">
                                            <td><?php echo $numrows; ?></td>
                                            <td>
                                                <a class="thumbnail1">
                                                <img  class="imagen2" src="fotos/<?php echo $foto;?>" width="30" height="30" border="0" />
                                                </a>  
                                            </td>	
                                            <td><?php echo $codigo_producto; ?></td>
                                            <td><?php echo $nombre_producto; ?></td>
                                            <td ><span class="label <?php echo $label_class;?>"><?php echo $b; ?></span></td>
                                            <td><?php echo $estado;?></td>
                                            <!--<td><?php echo $marca;?></td>
                                            <td><?php echo $modelo;?></td>
                                            <td><?php echo $color;?></td>-->
                                            <td>S/. <?php echo number_format($precio_producto,2);?></td>
                                         <td>
                                                <a href="fotos1.php?accion=<?php echo $id_producto;?>" class='btn btn-success btn-xs' title='Editar fotos'><i class="fa fa-image"></i></a>
                                                <a href="#" class='btn btn-warning btn-xs' title='Editar producto' onclick="obtener_datos('<?php echo $id_producto;?>');" data-toggle="modal" data-target="#myModal2"><i class="fa fa-pencil"></i></a> 
                                                <a href="#" class="btn btn-danger btn-xs" title='Borrar producto' onclick="eliminar('<?php echo $id_producto; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></td>
                                            
					</tr>
					<?php
                                        }
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
            <h4 class="alert-title">No hay Productos</h4>
            <p>No se han agregado Productos a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Productos"</b>.</p>
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