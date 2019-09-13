<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Resumen Ventas";

$consulta1 = "SELECT * FROM clientes ";
$result1 = mysqli_query($con, $consulta1);
$producto = array();
$i=0;
while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    $producto[$i]=$valor1['nombre_cliente'];
    $i=$i+1;
}
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$sql2="select * from sucursal ORDER BY  `sucursal`.`tienda` DESC ";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$tienda1=$rs2["tienda"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[25]==0){
    header("location:error.php");    
    
}

?>
<?php include ("header.php"); ?>
<?php

menu1();

?>

<?php 
$consulta2 = "SELECT * FROM consultas ";
$result2 = mysqli_query($con, $consulta2);
$d=0;
$cliente="";
$fecha1="";
$fecha2="";
$tienda=0;
$tipo="";
while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
     if ($valor1['tipo']==6){
          $d=$valor1['id'];
         $tipo=$valor1['a1'];
          //$nom_pro=trim($nom_pro1);
          $fecha1=$valor1['a2'];
          
          $fecha2=$valor1['a3'];
          $tiend=$valor1['a4'];
          if($tiend==7){
              $tienda1=1;
              $tienda2=$tienda1;
          }else{
              $tienda1=$tiend;
              $tienda2=$tiend;
          }
          
          if ($fecha1<>""){
            $d1 = explode("-", $fecha1);
            $dia1=$d1[0]; 
            $mes1=$d1[1];
            $ano1=$d1[2];
         }
        $dd1=$ano1."-".$mes1."-".$dia1;
        if ($fecha2<>""){
            $d2 = explode("-", $fecha2);
            $dia2=$d2[0]; 
            $mes2=$d2[1];
            $ano2=$d2[2];
            $dd2=$ano2."-".$mes2."-".$dia2;
        }
   }   
}  
            ?>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      VENTAS
      <small>
        RESUMEN DE VENTAS
      </small>
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="dashboard.php">
          <i class="fa fa-dashboard"></i> 
          TABLERO
        </a>
      </li>
      <li class="active">
        VENTAS
      </li>
    </ol>
  </section>
  <!-- ContentH eader End -->
<section class="content">

<div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">
              REALIZAR REPORTE
            </h3>
          </div>
          <div class="box-body">
            <form   name="myForm" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="GET" action="resumenventas1.php">
                               
                        <div class="col-md-3 col-sm-3 col-xs-12">
                        <label>Tipo:</label>
                           <select class="form-control col-md-10" name="tipo" required="required" tabindex="-1">
                                <option value="<?php echo $tipo;?>"><?php echo $tipo;?></option>
                                <option value="Clientes">Clientes</option>
                                <option value="Vendedores">Vendedores</option>
                                                                                         
                            </select>
                        <br>
                        <br>
                        </div>
                      
                     
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha Inicial:</label>
                            <input  name="fecha1"  data-validate-length-range="4" type="date"  class="form-control col-md-10" style="float: left;" id="fecha1"   value="<?php echo $fecha1;?>" required>
                        </div>
                      
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha Final:</label>
                            <input  name="fecha2"  data-validate-length-range="4" type="date"  class="form-control col-md-10" style="float: left;" id="fecha2"   value="<?php echo $fecha2;?>" required>
                         
                        </div>
                     
                      
                        <div class="col-md-3 col-sm-3 col-xs-12">
                        <label>Tienda:</label>
                           <select class="form-control col-md-10" name="tienda" required="required" tabindex="-1">
                            <?php
                            if($tiend>0){
                                if($tiend==4){
                                    $t="Todas";
                                }else{
                                    $t="Tienda $tiend";
                                }
                                
                                ?>
                            <option value="<?php echo $tiend; ?>" ><?php echo $t; ?></option>
                            <?php
                               }else{
                                  ?>
                               <option value="" >Escoger</option>
                            <?php  
                               }
                             for($i=1 ;$i<=$tienda1;$i++){
                                ?>
                            <option value="<?php echo $i;?>" >Tienda <?php echo $i;?></option>              
                               <?php
        
                            } 
                            ?>
                          <option value="7" >Todas</option>                                                              
                          </select>
                        <br>
                      <br>
                      </div>
                        <input type="hidden" name="d" value="1">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <button id="send" type="submit" name="enviar" class="btn btn-success">Buscar</button>
                        </div>
                        </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">
              RESULTADOS
            </h3>
          </div>
          <div class="box-body">
            <?php     
$total11=0;
$total22=0;
if($d==0){
//$sql="select * from products ORDER BY  `products`.`id_producto` DESC LIMIT 0 , 100";
    $sql="";
}else{
  if($tipo=="Clientes"){
           
    $host= $_SERVER["HTTP_HOST"];
    $url= $_SERVER["REQUEST_URI"];
    $aa="http://".$host.$url;

?>
      
    <div class="table-responsive">          
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr class="bg-gray">
                    <th>N°</th>
                    <th>Cliente </th>
                    <th>N° Ventas </th>
                    <th>Total S/.</th>
                </tr>
            </thead>

            <tfoot>
                <tr class="bg-gray">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        <tbody>  
 <?php   
$sql="select * from clientes"; 
$total=0;
$rs=mysqli_query($con,$sql);
$s=0;
$j=0;
$a1=array();
$nom1=array();
while($row= mysqli_fetch_array($rs)){  
    $id_cliente=$row['id_cliente'];
    $nombre_cliente=$row['nombre_cliente'];
    $nom1[$j]=$nombre_cliente;
    $sql1="select * from $db_facturas where ven_com=1 and activo=1 and estado_factura<=2"; 
    $rs1=mysqli_query($con,$sql1);
    $num=0;
    $total1=0;
    $total2=0;
    $a1[$j]=0;
    while($row1= mysqli_fetch_array($rs1)){
        $fecha3=$row1['fecha_factura'];
        $venta=$row1['total_venta'];
        $tienda=$row1['tienda'];
        $id_cliente1=$row1['id_cliente'];
        $moneda=$row1['moneda'];
        $d3 = explode("-",$fecha3);
        $dia=date("d",strtotime($fecha3)); 
        $mes=date("m",strtotime($fecha3));  
        $ano=$d3[0];
        $dd=$ano."-".$mes."-".$dia;
        $dd5=$mes."-".$dia."-".$ano;
        $fecha=strtotime($dd);
        $fech1=strtotime($dd1);
        $fech2=strtotime($dd2);
        if($id_cliente==$id_cliente1  && $fecha>=$fech1 && $fecha<=$fech2 && $tienda>=$tienda1 && $tienda<=$tienda2){    
            $num=$num+1;
            if($moneda==1){
                $total1=$total1+$venta;
                $mon="S/.";
            }
        }
    }
    if($total1>0 or $total2>0){
    $s=$s+1;
    ?>
    <tr id="valor1">
        <td class=" "><?php echo $s;?></td>
        <td class=" "><?php echo utf8_decode($nombre_cliente);?></td>
        <td class=" "><?php echo $num;?></td>
        <td class='text-left'><?php  echo number_format($total1,2);?></td>
     
    </tr>                
    <?php
    $j=$j+1;
    $total11=$total11+$total1;
    $total22=$total22+$total2;
    }
}                       
   if($_SESSION['tabla']>0){
        ?>
        <!--<tr><td colspan="2"></td><td class='text-right'><h2 style="color:blue;">Total Ventas :</h2></td><td class='text-right'><h2 style="color:red;">S/.<?php echo number_format ($total11,2);?></h2></td></tr>-->
        <?php
    }
    ?>
        </tbody>
    </table>
            </div>
              
              
            <?php
    }
    if($tipo=="Vendedores"){
        $host= $_SERVER["HTTP_HOST"];
        $url= $_SERVER["REQUEST_URI"];
        $aa="http://".$host.$url;
    ?>
    <div class="table-responsive">
        <table id="example" class="table table-bordered table-striped table-hover">
            <thead>
                <tr class="bg-gray">
                    <th>N°</th>
                    <th>Usuario</th>
                    <th>N° Ventas </th>
                    <th>Total S/.</th>
                    <!--<th>Ventas USD/.</th>-->
               </tr>
             </thead>

             <tfoot>
                <tr class="bg-gray">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <!--<th>Ventas USD/.</th>-->
               </tr>
             </tfoot>

        <tbody>  
 <?php   
$sql="select * from users"; 
$rs=mysqli_query($con,$sql);
$s=0;
$j=0;
$a1=array();
$nom1=array();
while($row= mysqli_fetch_array($rs)){
    $id_cliente=$row['user_id'];
    $nombre_cliente=$row['user_name'];
    $nom=$nombre_cliente;
    $sql1="select * from facturas where ven_com=1 and activo=1 and estado_factura<=2"; 
    $rs1=mysqli_query($con,$sql1);
    $num=0;
    $total1=0;
    $total2=0;
    $total3=0;
    $a1[$j]=0;
    while($row1= mysqli_fetch_array($rs1)){
        $fecha3=$row1['fecha_factura'];
        $venta=$row1['total_venta'];
        $tienda=$row1['tienda'];
        $moneda=$row1['moneda'];
        $ven=$venta*$moneda;
        $id_cliente1=$row1['id_vendedor'];
        $d3 = explode("-",$fecha3);
        $dia=date("d",strtotime($fecha3)); 
        $mes=date("m",strtotime($fecha3));  
        $ano=$d3[0];
        $dd=$ano."-".$mes."-".$dia;
        $fecha=strtotime($dd);
        $fech1=strtotime($dd1);
        $fech2=strtotime($dd2);
        if($id_cliente==$id_cliente1  && $fecha>=$fech1 && $fecha<=$fech2 && $tienda>=$tienda1 && $tienda<=$tienda2){    
            $num=$num+1;
            $total3=$total3+$ven;
            if($moneda==1){
                $total1=$total1+$venta;
                $mon="S/.";
            }
        }
    }
    if($total1>0){
        $s=$s+1;
        ?>
        <tr id="valor1">
            <td class=" "><?php echo $s;?></td>
            <td class=" "><?php print"$nombre_cliente ";?></td>
            <td class=" "><?php echo $num;?></td>
            <td class='text-left'><?php  echo number_format($total1,2);?></td>
            <!--<td class='text-right'><?php  echo number_format($total2,2);?></td>-->
        </tr>                
        <?php
        if($total1>0){
            $nom1[$j]=$nom;
            $a1[$j]=$total3;
            $j=$j+1; 
        }
        $total11=$total11+$total1;
    $total22=$total22+$total2;
    }
}                       
    ?>
    </tbody>
    <?php 
        if($_SESSION['tabla']>0)        {
            ?>
            <!--<tr><td colspan="3"></td><td class='text-right'><h2 style="color:blue;">Total Ventas :</h2></td><td class='text-right'><h2 style="color:red;">S/.<?php echo number_format ($total11,2);?></h2></td></tr>-->
            <?php
        }
        ?>
    </table>
 
    </div>
            
     <?php
    }
}
?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">
              GRAFICO
            </h3>
          </div>
          <div class="box-body">
            <?php
          
        if($tipo=="Vendedores"){
        ?>
            <div class="table-responsive">
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
            <div class="x_title">
            <?php
            if(count($nom1)>0){
                ?>
                
                <?php
            }
            ?>
               <div class="clearfix"></div>
                </div>
                <div class="x_content1">
                  <div id="graph_bar_group" style="width:100%; height:280px;"></div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <?php
}
?>

          </div>
        </div>
      </div>
    </div>

</section>
</div>

<?php include("footer.php"); ?>

  <script src="assets/js/jquery.scrollTo.min.js"></script>
  <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

  <script src="assets/js/common-scripts.js"></script>

  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>


  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->

  <script type="text/javascript">
    $(function() {
      'use strict';
      
      var data =[
      <?php
                    for($i = 0;$i<count($producto);$i++){
                ?>
                '<?php echo $producto[$i];?>',
                <?php } ?>];
     
      
      
      var countriesArray = $.map(data, function(value, key) {
        return {
          value: value,
          data: key
        };
      });
      // Initialize autocomplete with custom appendTo:
      $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
      });
    });
  </script>
  
  <script src="js/select/select2.full.js"></script>
  <!-- form validation -->
  
  <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Seleccionar",
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "Con Max Selección límite de 4",
        allowClear: true
      });
    });
  </script>
  <script language="javascript">
$(document).ready(function() {
  $(".botonExcel").click(function(event) {
    $("#datos_a_enviar").val( $("<div>").append( $("#example").eq(0).clone()).html());
    $("#FormularioExportacion").submit();
});
});
</script>
<script>
     $(function () {

    /* data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type */
    var day_data = [
        
        <?php
                    for($i = 0;$i<count($nom1);$i++){
                ?>
                {"period": "<?php print"$nom1[$i]";?>", "Ventas": <?php print"$a1[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group',
        data: day_data,
        xkey: 'period',
        barColors: ['#FAAC58', '#DF0101', '#ACADAC', '#3498DB'],
        ykeys: ['Ventas'],
        labels: ['Ventas'],
        hideHover: 'auto',
        xLabelAngle: 60
    });

  
});
</script>  
<script src="js/moris/raphael-min.js"></script>
<script src="js/moris/morris.min.js"></script> 
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

        "footerCallback": function ( row, data, start, end, display ) {
            var pageTotal;
            var api = this.api();
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === "string" ?
                    i.replace(/[\$,]/g, "")*1 :
                    typeof i === "number" ?
                        i : 0;
            };

            // Total over this page
            pageTotal = api
                .column( 2, { page: "current"} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            $( api.column( 2 ).footer() ).html(
                window.formatDecimal(pageTotal, 2)
            );

            // Total over this page
            pageTotal = api
                .column( 3, { page: "current"} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            $( api.column( 3 ).footer() ).html(
                window.formatDecimal(pageTotal, 2)
            );
            
            
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
                    footer: true,
                    text: '<i class="fa fa-copy"></i>',
                    className: 'red',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'excel',
                    footer: true,
                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'green',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    className: 'green',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'csv',
                    footer: true,
                    text: '<i class="fa fa-file"></i>',
                    className: 'green1',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'print',
                    footer: true,
                    text: '<i class="fa fa-print"></i>',
                    className: 'green2',
                    exportOptions: {
                    columns: ':visible'
                }
                },
            ],
         "pageLength": -1,
        
    } );

} );
</script>

<script type="text/javascript">
    
    $('#informes').addClass("treeview active");
    $('#resumenventas').addClass("active");

</script>

</body>

</html>




