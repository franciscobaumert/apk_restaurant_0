
<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
            $numero_factura=intval($_GET['id']);
            $del1="UPDATE facturas set activo=0, deuda_total=0 where numero_factura='".$numero_factura."' and ven_com=1";
            $del2="UPDATE detalle_factura set activo=0 where numero_factura='".$numero_factura."' and ven_com=1";
            $sql=mysqli_query($con, "select * from detalle_factura where numero_factura='".$numero_factura."'");
            while ($row=mysqli_fetch_array($sql))
            {
                $id_producto=$row["id_producto"];
                $tienda=$row["tienda"];
                $cantidad=$row["cantidad"];
                $b="b".$tienda;
                $productos1=mysqli_query($con, "UPDATE products SET $b=$b+$cantidad WHERE id_producto=$id_producto and pro_ser=1");
            }
            if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
            <script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.success("Datos eliminados","Exito");
            </script>
			<?php 
		}else {
			?>
            <script>
                    toastr.options = {
                "closeButton":false,
                "progressBar": false
            };
            toastr.error("No se puede eliminar los datos","Error");
            </script>
			<?php
			
		}
	}
	if($action == 'ajax'){
		$sTable = "detalle_factura, products,users";
		$sWhere = "";
		$sWhere.=" WHERE detalle_factura.id_producto=products.id_producto and detalle_factura.numero_factura=0 and users.user_id=detalle_factura.precio_compra";
                $sWhere.=" order by detalle_factura.id_detalle asc";
		include 'pagination.php'; 
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; 
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
			<table id="example" class="table table-bordered table-striped table-hover">
                            <thead>
                <tr class="bg-gray">
                                    <th>Nro</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Producto</th>
                                    <th>Vendedor</th>
                                    <th>Cantidad</th>
                                    <th>Sucursal</th>
                                    <th>Tipo</th>
                                </tr>
                                </thead>
                            <tfoot>
				<tr class="bg-gray">
                                    <th>Nro</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Producto</th>
                                    <th>Vendedor</th>
                                    <th>Cantidad</th>
                                    <th>Sucursal</th>
                                    <th>Tipo</th>
                                </tr>
                                </tfoot>
				<?php
				while ($row=mysqli_fetch_array($query)){
                                        $producto=$row['nombre_producto'];
                                        $fecha=date("d/m/Y", strtotime($row['fecha']));
                                        $fecha1=date("H:i", strtotime($row['fecha']));
                                        $cantidad=$row['cantidad'];
                                        $tienda=$row['tienda'];
                                        $ven_com=$row['ven_com'];
                                        $vendedor=$row['nombres'];
                                        if ($ven_com==1){$text_estado1="Salida";$label_class1='label-success';}
					else{$text_estado1="Entrada";$label_class1='label-warning';}
                                        ?>
					<tr id="valor1">
						<td><?php echo $numrows; ?></td>
						<td><?php echo $fecha; ?></td>
                                                <td><?php echo $fecha1; ?></td>
						<td><?php echo $producto; ?></td>
						<td><?php echo $vendedor; ?></td>
                                                <td><?php echo $cantidad; ?></td>
                                                <td><?php echo $tienda; ?></td>
                                                <td><?php echo $text_estado1; ?></td>
                                        </tr>
					<?php
                                        $numrows=$numrows-1;
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
            <h4 class="alert-title">No hay Tansferencias</h4>
            <p>No se han agregado Tansferencias a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Tansferencias"</b>.</p>
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

 
    

    
  