<?php

    
    include('is_logged.php');
    require_once ("../config/db.php");
    require_once ("../config/conexion.php");
    $tienda1=$_SESSION['tienda'];
        $usuario=$_SESSION['user_id'];
        date_default_timezone_set('America/Santiago');
        $fecha1  = date("Y-m-d H:i:s");
    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if($action == 'ajax'){
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
                $q1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q1'], ENT_QUOTES)));
                $q2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q2'], ENT_QUOTES)));
        $sTable = "facturas, clientes, users";
        $sWhere = "";
        $sWhere.=" WHERE facturas.id_cliente=clientes.id_cliente and facturas.tienda=$tienda1 and (facturas.estado_factura<=2 or facturas.estado_factura=5 or facturas.estado_factura=6 or facturas.estado_factura=9 or facturas.estado_factura=10)and facturas.id_vendedor=users.user_id and facturas.ven_com=1 and facturas.activo=1 and facturas.numero_factura>0";
                 if ( $_GET['q'] != "" )
        {
        $sWhere.= " and  (clientes.nombre_cliente like '%$q%' )";
        }
                if ( $_GET['q1'] != "" )
        {
        $sWhere.= " and  (facturas.numero_factura like '%$q1%' )";
        }
                
                if ( $_GET['q2'] != "" )
        {
        $sWhere.= " and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$q2' )";
        }
        $sWhere.=" order by facturas.id_factura asc";
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
                $sql1="SELECT * FROM sucursal where tienda=$tienda1";
        $query1 = mysqli_query($con, $sql1);
                $row1=mysqli_fetch_array($query1);
                $ruc1=$row1['ruc'];
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
                        <th>Cliente</th>
                        <th>Total</th>
                                            <th>Hora Envio|Obs</th>
                                            <th>Enviar</th>
                                            <th>Firma|CDR</th>
                        <th>Estado</th>
                                            <th>Imprimir</th>
                                            <!--<th>Ticket</th>-->
                                            <!--<th>Correo</th>-->
                                            <th></th>
                    </tr>
                </thead>

                <tfoot>
                    <tr class="bg-gray">
                        <th>Nro</th>
                        <th>Doc</th>
                                            <th>Tipo</th>
                                            
                                            <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Total</th>
                                            <th>Hora Envio|Obs</th>
                                            <th>Enviar</th>
                                            <th>Firma|CDR</th>
                        <th>Estado</th>
                                            <th>Imprimir</th>
                                            <!--<th>Ticket</th>-->
                                            <!--<th>Correo</th>-->
                                            <th></th>
                    </tr>
                </tfoot>
                
                <tbody>
                <?php
                while ($row=mysqli_fetch_array($query)){
                                               $activo=$row['activo'];
                        if ($activo==1){
                                                $id_factura=$row['id_factura'];
                        $numero_factura=$row['numero_factura'];
                        $resumen=$row['resumen'];
                        $fecha=date("d/m/Y", strtotime($row['fecha_factura']));
                        $nombre_cliente=$row['nombre_cliente'];
                        
                        $telefono_cliente=$row['telefono_cliente'];
                                                $ruc=$row['doc'];
                        $email_cliente=$row['email_cliente'];
                                                $folio=$row['folio'];
                                                $dni=$row['dni'];
                                                
                        $nombre_vendedor=$row['nombres'];
                                                $tip=0;
                                                $estado_factura1=$row['estado_factura'];
                                                if($estado_factura1==1){
                                                    $tip="01";
                                                }
                                                if($estado_factura1==2){
                                                    $tip="03";
                                                }
                                                if($estado_factura1==6){
                                                    $tip="07";
                                                }
                                                if($estado_factura1==5){
                                                    $tip="08";
                                                }
                                                if($estado_factura1==10){
                                                    $tip="07";
                                                }
                                                if($estado_factura1==9){
                                                    $tip="08";
                                                }
                                                $numero_factura1=str_pad($numero_factura, 8, "0", STR_PAD_LEFT);
                                                $doc1="$ruc1-$tip-$folio-$numero_factura1.XML";
                                                
                                                $doc2="$ruc1-$tip-$folio-$numero_factura1";
                                                
                                                $doc3="R-$ruc1-$tip-$folio-$numero_factura1.XML";
                                                $aceptado1="No enviado";
                                                $fecha3="";
                                                $hora3="";
                                                if (file_exists('../pdf/documentos/cdr/'.$doc3.'')) {
                                                    $xml = file_get_contents('../pdf/documentos/cdr/'.$doc3.'');
                                                    #== Obteniendo datos del archivo .XML 
                                                    $aceptado="";
                                                    $DOM = new DOMDocument('1.0', 'ISO-8859-1');
                                                    $DOM->preserveWhiteSpace = FALSE;
                                                    $DOM->loadXML($xml);
                                                    ### DATOS DE LA FACTURA ####################################################
                                                    // Obteniendo RUC.
                                                    $DocXML = $DOM->getElementsByTagName('Description');
                                                    foreach($DocXML as $Nodo){
                                                        $aceptado = $Nodo->nodeValue; 
                                                    }  
                                                    $DocXML = $DOM->getElementsByTagName('ResponseDate');
                                                    foreach($DocXML as $Nodo){
                                                        $fecha3 = $Nodo->nodeValue; 
                                                    }
                                                    $DocXML = $DOM->getElementsByTagName('ResponseTime');
                                                    foreach($DocXML as $Nodo){
                                                    $hora3 = $Nodo->nodeValue; 
                                                    }
                                                    $fecha3=date("d/m/Y", strtotime($fecha3));
                                                    $pos = strpos($aceptado, "aceptada");
                                                    if ($pos === false) {
                                                        $aceptado1= "No aceptada";
                                                    } else {
                                                    $aceptado1= "Aceptada";
   
                                                    }
                         }
                                                 if($row['aceptado']=="Aceptada"){
                                                    $aceptado1= "Aceptada"; 
                                                 } elseif($row['aceptado']=="No aceptada") {
                                                    $aceptado1= "Rechazado";
                                                    $fecha3=$row['obs'];
                                                 }
                                                 //print"$aceptado1";
                                                 if($fecha3=="" and $aceptado1=="Aceptada"){
                                                     $fecha3=$row['obs'];
                                                 } 
                                                $estado_factura=$row['condiciones'];
                                                $ven_com=$row['ven_com'];
                                                $moneda=$row['moneda'];
                                                $mon="S/.";
                                                if($estado_factura1==1){
                                                    $estado1="Factura";
                                                    
                                                }
                                                if($estado_factura1==2){
                                                    $estado1="Boleta";    
                                                }
                                                if($estado_factura1==3){
                                                    $estado1="Ticket";   
                                                }
                                                if($estado_factura1==5){
                                                    $estado1="Nota de Debito"; 
                                                }
                                                if($estado_factura1==6){
                                                    $estado1="Nota de Credito";    
                                                }
                                                if($estado_factura1==9){
                                                    $estado1="Nota de Debito"; 
                                                }
                                                if($estado_factura1==10){
                                                    $estado1="Nota de Credito";    
                                                }
                                                if($estado_factura==1){
                                                    $estado2="Efectivo";
                                                }
                                                if($estado_factura==2){
                                                    $estado2="Cheque";
                                                    
                                                }
                                                if($estado_factura==3){
                                                    $estado2="Transf Bancaria";
                                                }
                                                if($estado_factura==4){
                                                    $estado2="Crédito";
                                               }
                                               if($estado_factura==5){
                                                    $estado2="Visa";
                                               }
                                               if($estado_factura==6){
                                                    $estado2="MasterCard";
                                               }
                                               if($estado_factura==7){
                                                    $estado2="American Express";
                                               }
                                               if($estado_factura==8){
                                                    $estado2="Dinners Club";
                                               }
                                                
                                                $deuda=$row['deuda_total'];
                                                $servicio=$row['servicio'];
                                                $sql1="SELECT * FROM  servicio;";
                                                $query1 = mysqli_query($con, $sql1);
                                                while ($row1=mysqli_fetch_array($query1)){
                                                  if($row1['doc_servicio']==$numero_factura && $row1['tip_doc']==$estado_factura1)  {
                                                     $guia=$row1['guia'];
                                                    }
                                                }
                                                if ($servicio==0){$text_estado1="Productos";$label_class1='label-success';}
                        else{$text_estado1="Servicios";$label_class1='label-warning';}
                                                
                        if ($deuda==0){$text_estado="Pagada";$label_class='label-success';}
                        else{$text_estado="Pendiente";$label_class='label-warning';}
                        $total_venta=$row['total_venta'];
                    ?>
                    <tr id="<?php echo $doc2;?>">
                        <td><?php echo $numrows; ?></td>
                                                <td><?php print"$folio" ; ?>-<?php print"$numero_factura";?></td>
                                                <td><?php echo $estado1; ?></td>
                                               
                                                <td><?php echo $fecha; ?></td>
                        <td><?php echo $nombre_cliente;?></td>   
                                    <td class='text-right'><?php print"$mon"; echo number_format ($total_venta,2); ?></td>
                                                
                                                    <td class='text-right'><font color='black'><strong><?php print"$fecha3&nbsp;&nbsp;"; echo $hora3; ?></strong></font></td>    
                                                
                                                
                        
                                                <td class="text-right">
                                                    <?php
                                                    if($aceptado1== "No enviado"){
                                                        ?>
                                                    <a style="cursor: pointer;" class='btn btn-warning btn-xs' title='Enviar SUNAT' onclick="enviar('<?php echo $doc2;?>');"><i class="fa fa-paper-plane"></i></a> 
                         
                                                            <?php
                                                    }elseif ($aceptado1== "Rechazado"){
                                                        ?>
                                                    <a style="cursor: pointer;" class='btn btn-danger btn-xs' title='Error en envio' disabled ><strong><b>X</b></strong></a> 
                                                    
                         
                                                            <?php
                                                    } elseif ($aceptado1== "Aceptada") { ?>
                                                        <a class='btn btn-success btn-xs' disabled title='Documento enviado'><i class="fa fa-check"></i></a>
                                                    <?php }
                                                    ?>
                                                    <a  style="cursor: pointer;" class='btn btn-info btn-xs' title='Enviar correo' onclick="enviar_correo('<?php echo $id_factura;?>');"><i class="fa fa-envelope-o"></i></a> 
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    if($aceptado1=="No enviado"){
                                                    ?>
                                                    <a style="cursor: pointer;" class='btn btn-info btn-xs' title='Descargar XML sin firmar' onclick="imprimir_factura('<?php echo $doc1;?>');">XML</a> 
                                                    <?php
                                                    }
                                                    if($aceptado1<>"No enviado"){
                                                        ?>
                                                    <a style="cursor: pointer;" class='btn btn-primary btn-xs' title='Descargar XML firmado' onclick="imprimir_factura2('<?php echo $doc1;?>');">XML</a> 
                                                            <?php
                                                    }


                                                    if($folio<>"" and ($estado_factura1<=2 or $estado_factura1==5 or $estado_factura1==6 or $estado_factura1==9 or $estado_factura1==10)){
                                                    ?>
                                                    <?php
                                                    if($aceptado1== "Aceptada"){
                                                        ?>
                                                    <a style="cursor: pointer;" class='btn btn-success btn-xs' title='Descargar CDR' onclick="imprimir_factura1('<?php echo $doc3;?>');">CDR</a>
                                                <?php } elseif ($aceptado1== "Rechazado") { ?>
                                                    <a style="cursor: pointer;" class='btn btn-danger btn-xs' title='Documento rechazado' disabled>CDR</a>
                                                <?php } elseif ($aceptado1== "" or $aceptado1=="No enviado") { ?>
                                                    <a style="cursor: pointer;" class='btn btn-warning btn-xs' title='Documento pendiente' disabled>CDR</a>
                                                <?php } ?>
                                                    <?php
                                                    }
                                                    ?>

                                                
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    if($folio<>"" and ($estado_factura1<=2 or $estado_factura1==5 or $estado_factura1==6 or $estado_factura1==9 or $estado_factura1==10)){
                                                    ?>
                                                    <?php
                                                    if($aceptado1== "Aceptada"){
                                                        ?>
                                                    <span class="label label-success">Aceptada</span>
                                                <?php } elseif ($aceptado1== "Rechazado") { ?>
                                                    <span class="label label-danger">Rechazado</span>
                                                <?php } elseif ($aceptado1== "" or $aceptado1=="No enviado") { ?>
                                                    <span class="label label-warning">Pendiente</span>
                                                <?php } ?>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                
                                                   
                                                        <a  style="cursor: pointer;" class='btn btn-primary btn-xs' title='Descargar PDF' onclick="imprimir_facturas2('<?php echo $id_factura;?>');">A4</a>
                                                    
                                                      
                                                     
                                                    <a  style="cursor: pointer;" class='btn btn-primary btn-xs' title='Descargar Ticket' onclick="imprimir_facturas3('<?php echo $id_factura;?>');">Ticket</a>
                                                
                                                <td><input <?php if ($aceptado1=="Aceptada") {
                                                    echo "disabled";
                                                } else { echo "checked"; } ?> type="checkbox" name="customer_id[]" value="<?php echo $doc2;?>" /></td>
                    </tr>
                    <?php
                                        $numrows=$numrows-1;
                        }
                                }
                ?>

                        </tbody>
                        <div class="center">
                            <button type="button" name="btn_delete" id="btn_delete" class="btn btn-warning btn-sm" title='Enviar documentos seleccionados a SUNAT'><i class="fa fa-paper-plane"></i> Enviar seleccionados (SUNAT)</button>
                        </div>
            </table>
                    </div>

                    

                    <?php
        }else{
          ?>
          <br><br><br>
          <div class="alert alert-danger alert-custom alert-dismissible">
            <br><br>
            <h4 class="alert-title">No hay Ventas</h4>
            <p>No se han encontrado Ventas en la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Ventas"</b>.</p>
            <br><br>
          </div>
          <br><br><br>
          <?php
        }}
      ?>

<script>
$(document).ready(function() {

        $('#btn_delete').click(function(){
            
                var id = [];
                $(':checkbox:checked').each(function(i){
                    id[i] = $(this).val();
                });

                if (id.length === 0)
                {
                    //alert("Selecciona un registro");
                    window.swal({
                      title: "Alerta!",
                      text: 'Seleccione uno o varios registros',
                      icon: "warning",
                      //buttons: true,
                      dangerMode: false,
                    });
                }
            
            else
            {
               for (var i=0; i<id.length; i++) {
                   enviar (id[i]+'');
               }
            }
        });
    
    
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
        "search": "Otros criterios:",
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
                    orientation: 'landscape',
                    pageSize: 'A4',
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