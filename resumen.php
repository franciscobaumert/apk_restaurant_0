<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
require_once ("class/class.php");

$title="Tablero";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$tienda1=$_SESSION['tienda'];
$sql2="select * from caja where tienda=$tienda1 ORDER BY  `caja`.`id_caja` DESC ";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$fecha1=$rs2["fecha"];
$usuario_cierre=$rs2["usuario_cierre"];
$inicio=$rs2["inicio"];
$id_caja=$rs2["id_caja"];

date_default_timezone_set('America/Santiago');
$fecha2=date("Y-m-d");

$entrada1=0;
$salida1=0;
if($fecha1==$fecha2){
    


$suma1= mysqli_query($con, "SELECT SUM(total_venta) AS total1 FROM facturas  where condiciones=1 and (estado_factura<=3 or estado_factura=5) and activo=1 and ven_com=1 and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha1' )");
$row1= mysqli_fetch_array($suma1);
$total1 = $row1['total1'];
$suma4= mysqli_query($con, "SELECT SUM(total_venta) AS total4 FROM facturas  where  condiciones=1 and activo=1 and (ven_com=5 or ven_com=3) and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha1' )");
$row4= mysqli_fetch_array($suma4);
$total4 = $row4['total4'];
                                                    
$suma2= mysqli_query($con, "SELECT SUM(total_venta) AS total2 FROM facturas  where condiciones=1 and estado_factura=6 and activo=1 and ven_com=1 and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha1' )");
$row2= mysqli_fetch_array($suma2);
$total2 = $row2['total2'];
                                                    
$suma3= mysqli_query($con, "SELECT SUM(total_venta) AS total3 FROM facturas  where condiciones=1 and activo=1 and (ven_com=2 or ven_com=4) and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha1' )");
$row3= mysqli_fetch_array($suma3);
$total3 = $row3['total3'];
                                                    
$suma5= mysqli_query($con, "SELECT SUM(total_venta) AS total5 FROM facturas  where condiciones=1 and activo=1 and ven_com=6 and tienda=$tienda1 and  (DATE_FORMAT(fecha_factura, '%Y-%m-%d')='$fecha1' )");
$row5= mysqli_fetch_array($suma4);
$total5 = $row5['total5'];
                                                    
$entrada1=$total1+$total4;
$salida1=$total2+$total3+$total5;
}
$faltante=$inicio+$entrada1-$salida1;

if($usuario_cierre==""){
    $tipo2="CERRADO";
    $inicio1=0;
}else{
    if($usuario_cierre==0){
        $tipo2="ABIERTO";
        $inicio1=$inicio+$salida1-$entrada1;
    }else{
        $tipo2="CERRADO";
        $inicio1=0;
    }
    
}

$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[1]==0){
    header("location:error.php");    
}

$d=date("d");
$m=date("m");
$aa=date("Y");
$dd1=$aa."-".$m."-".$d;
$fech1=strtotime($dd1);
$f1=$fech1/(24*3600);
$a1=array();
$a2=array();
$a3=array();
$a4=array();
$fec=array();
$j=0;
$total1=0;
$total2=0;
$total3=0;
$total4=0;
for($i=($f1-9);$i<=$f1;$i++){
$fec[$j]=0;
$sql1="select * from facturas where activo=1 and estado_factura<=2"; 
$rs1=mysqli_query($con,$sql1);
$total1=0;
$total2=0;
$total3=0;
$total4=0;
$efectivo1=0;
$efectivo2=0;
$entrada=0;
$salida=0;
$a1[$j]=0;
$a2[$j]=0;
$a3[$j]=0;
$a4[$j]=0;
$a=0;
while($row1= mysqli_fetch_array($rs1)){
$fecha3=$row1['fecha_factura'];
$tienda=$row1['tienda'];
$tipo=$row1['ven_com'];
$condiciones=$row1['condiciones'];
$estado=$row1['estado_factura'];
$d3 = explode("-",$fecha3);
$dia=date("d",strtotime($fecha3)); 
$mes=date("m",strtotime($fecha3));  
$ano=$d3[0];
$dd=$ano."-".$mes."-".$dia;
$fecha=strtotime($dd);
if($fecha==$i*24*3600 && $tienda==$_SESSION['tienda']){    
    if(($tipo==1 || $tipo==3 || $tipo==5) and $estado<>6){
    if($condiciones>0){
        $entrada=$row1['total_venta'];
        if($tipo==1 and $estado<=4){
          $total1=$total1+$entrada;  
        }
        if($condiciones<>4){
        $total2=$total2+$entrada;}
        $salida=0;
    }else{
        $salida=0;
        $entrada=0;
    }
}
if($tipo==2 || $tipo==4 || $tipo==6 || ($tipo==1 and $estado==6)){
    
    if($condiciones>0){
        $salida=$row1['total_venta'];
        if($tipo==2){
          $total3=$total3+$salida;  
        }
        if($condiciones<>4){
            $total4=$total4+$salida;
        }
        $entrada=0;
    }else{
        $salida=0;
        $entrada=0;
    }
}

  $a=$a+1;  
}
}

$fec[$j]=date('d-m-Y',$i*24*3600);
$a1[$j]=$total1;
$a2[$j]=$total2;
$a3[$j]=$total3;
$a4[$j]=$total4;
$j=$j+1;
}
$a5=array();
$a6=array();
$a7=array();
$a8=array();
$fec1=array();
$j=1;
$total5=0;
$total6=0;
$total7=0;
$total8=0;    
$m1=date("m");
$ano=date("Y");  
    for($i=1;$i<=$m1;$i++){
 
    $fec1[$j]=0;
    $sql1="select * from facturas where activo=1"; 
    $rs1=mysqli_query($con,$sql1);
    $total5=0;
    $total6=0;
    $total7=0;
    $total8=0;
    $efectivo1=0;
    $efectivo2=0;
    $entrada=0;
    $salida=0;
    $a5[$j]=0;
    $a6[$j]=0;
    $a7[$j]=0;
    $a8[$j]=0;
    $a=0;
    while($row1= mysqli_fetch_array($rs1)){
        $fecha3=$row1['fecha_factura'];
        $tienda=$row1['tienda'];
        $tipo=$row1['ven_com'];
        $condiciones=$row1['condiciones'];
        $estado=$row1['estado_factura'];
        $d3 = explode("-",$fecha3);
        $dia=date("d",strtotime($fecha3)); 
        $mes=date("m",strtotime($fecha3));  
        $ano1=date("Y",strtotime($fecha3));  
        if($mes==$i && $ano==$ano1 && $tienda==$_SESSION['tienda']){    
            if(($tipo==1 || $tipo==3 || $tipo==5) and $estado<>6){
                if($condiciones>0){
                    $entrada=$row1['total_venta'];
                    if($tipo==1 and $estado<5){
                        $total5=$total5+$entrada;  
                    }
                if($condiciones<>4){
                    $total6=$total6+$entrada;}
                    $salida=0;
                }else{
                    $salida=0;
                    $entrada=0;
                }
            }
            if($tipo==2 || $tipo==4 || $tipo==6 || ($tipo==1 and $estado==6)){
                if($condiciones>0){
                    $salida=$row1['total_venta'];
                    if($tipo==2){
                        $total7=$total7+$salida;  
                    }
                    if($condiciones<>4){
                        $total8=$total8+$salida;
                    }
                    $entrada=0;
                }else{
                    $salida=0;
                    $entrada=0;
                }
            }
            $a=$a+1;  
        }
    }
  if($j==1){
      $mes2="Enero";
  }  
  if($j==2){
      $mes2="Febrero";
  } 
  if($j==3){
      $mes2="Marzo";
  } 
  if($j==4){
      $mes2="Abril";
  } 
  if($j==5){
      $mes2="Mayo";
  } 
  if($j==6){
      $mes2="Junio";
  } 
  if($j==7){
      $mes2="Julio";
  } 
  if($j==8){
      $mes2="Agosto";
  } 
  if($j==9){
      $mes2="Septiembre";
  } 
  if($j==10){
      $mes2="Octubre";
  } 
  if($j==11){
      $mes2="Noviembre";
  } 
  if($j==12){
      $mes2="Diciembre";
  }   
$fec1[$j]=$mes2."-".$ano;
$a5[$j]=$total5;
$a6[$j]=$total6;
$a7[$j]=$total7;
$a8[$j]=$total8;
$j=$j+1;
}


$sql_count1=mysqli_query($con,"select * from clientes where tipo1='1' and tienda='$tienda1'");
$contarclientes=mysqli_num_rows($sql_count1);

$sql_count2=mysqli_query($con,"select * from clientes where tipo1='2' and tienda='$tienda1'");
$contarproveedores=mysqli_num_rows($sql_count2);

$sql_count3=mysqli_query($con,"select * from products");
$contarproductos=mysqli_num_rows($sql_count3);

$sql_count4=mysqli_query($con,"select * from facturas where activo='1' and estado_factura<=2 and tienda='$tienda1'");
$contarventas=mysqli_num_rows($sql_count4);

$products_sold = mysqli_query($con,"select products.nombre_producto, COUNT(detalle_factura.id_producto) AS totalSold, SUM(detalle_factura.cantidad) AS totalQty FROM detalle_factura LEFT JOIN products ON products.id_producto = detalle_factura.id_producto where tienda='".$_SESSION['tienda']."' GROUP BY detalle_factura.id_producto ORDER BY SUM(detalle_factura.cantidad) DESC LIMIT 5 ");

$recent_sales = mysqli_query($con,"select * FROM facturas, clientes, users WHERE facturas.id_cliente=clientes.id_cliente and facturas.tienda=$tienda1 and facturas.id_vendedor=users.user_id and facturas.ven_com=1 and facturas.estado_factura<=2 and facturas.activo=1 and facturas.numero_factura>0  order by facturas.id_factura desc limit 5");


?>



<?php include ("header.php"); ?>
<?php

menu1();

?>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      TABLERO
      <small>
        RESUMEN GENERAL
      </small>
    </h1>
    
  </section>
  <!-- ContentH eader End -->
<section class="content">

    <div class="action-button-sm">
    <?php include 'botones.php'; ?>
    </div>

    <hr>

    <!-- Small Boxes Start -->

  <div class="row">
      <div class="col-lg-3 col-xs-6">
        <div id="invoice-count" class="small-box bg-blue">
          <div class="inner">
            <h4>
              <i>CLIENTES</i> 
            </h4>
            <h4>
              <span class="total-invoice"><?php echo $contarclientes; ?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
            <a href="clientes.php" class="small-box-footer">
              DETALLES 
              <i class="fa fa-arrow-circle-right"></i>
            </a>          
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div id="customer-count" class="small-box bg-orange">
          <div class="inner">
            <h4>
              <i>PROVEEDORES</i>
            </h4>
            <h4>
              <span class="total-invoice"><?php echo $contarproveedores; ?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-user"></i>
          </div>
            <a href="proveedores.php" class="small-box-footer">
              DETALLES
              <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div id="supplier-count" class="small-box bg-teal">
          <div class="inner">
            <h4>
              <i>PRODUCTOS</i>
            </h4>
            <h4>
              <span class="total-invoice"><?php echo $contarproductos; ?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-barcode"></i>
          </div>
          
            <a href="credito-debito.php" class="small-box-footer">
              DETALLES
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div id="product-count" class="small-box bg-olive">
          <div class="inner">
            <h4>
              <i>VENTAS</i>
            </h4>
            <h4>
              <span class="total-invoice"><?php echo $contarventas; ?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-shopping-cart"></i>
          </div>
          
            <a href="facturas.php" class="small-box-footer">
              DETALLES
              <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <div id="invoice-count" class="small-box bg-green">
          <div class="inner">
            <h4>
              <i>VENTAS TOTAL:</i> <span class="total-invoice">S/.<?php echo $total1;?></span>
            </h4>
            <h4>
              <i>FECHA:</i> <span class="total-invoice"><?php echo date("d-m-Y");?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-usd"></i>
          </div>
            <a href="facturas.php" class="small-box-footer">
              DETALLES 
              <i class="fa fa-arrow-circle-right"></i>
            </a>          
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div id="customer-count" class="small-box bg-red">
          <div class="inner">
            <h4>
              <i>ENTRADAS TOTAL:</i> <span class="total-invoice">S/.<?php echo $total2;?></span>
            </h4>
            <h4>
              <i>FECHA :</i> <span class="total-invoice"><?php echo date("d-m-Y");?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-cube"></i>
          </div>
            <a href="facturaelectronica.php" class="small-box-footer">
              DETALLES
              <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div id="supplier-count" class="small-box bg-purple">
          <div class="inner">
            <h4>
              <i>SALIDAS TOTAL:</i> <span class="total-invoice">S/.<?php echo $total4;?></span>
            </h4>
            <h4>
              <i>FECHA:</i> <span class="total-invoice"><?php echo date("d-m-Y");?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-fw fa-shopping-cart"></i>
          </div>
          
            <a href="credito-debito.php" class="small-box-footer">
              DETALLES
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <div id="product-count" class="small-box bg-yellow">
          <div class="inner">
            <h4>
              <i>COMPRAS TOTAL:</i> <span class="total-invoice">S/.<?php echo $total3;?></span>
            </h4>
            <h4>
              <i>FECHA:</i> <span class="total-invoice"><?php echo date("d-m-Y");?></span>
            </h4>
          </div>
          <div class="icon">
            <i class="fa fa-credit-card"></i>
          </div>
          
            <a href="compras.php" class="small-box-footer">
              DETALLES
              <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
      </div>
    </div>
    <!--Small Box End -->

<div class="row">
   <div class="col-md-6">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>PRODUCTOS MAS VENDIDOS</span>
         </strong>
       </div>
       <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed">
          <thead>
           <tr>
             <th>NOMBRE</th>
             <!--<th>VENDIDO</th>-->
             <th>TOTAL</th>
           </tr>
          </thead>
          <tbody>
            <?php foreach ($products_sold as  $product_sold): ?>
              <tr>
                <td><?php echo $product_sold['nombre_producto']; ?></td>
                <!--<td><?php echo (int)$product_sold['totalSold']; ?></td>-->
                <td><?php echo (int)$product_sold['totalQty']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
         </table>
       </div>
     </div>
   </div>
   <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>ULTIMAS VENTAS</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed">
       <thead>
         <tr>
           <th class="text-center" style="width: 50px;">#</th>
           <th>DOCUMENTO</th>
           <th>FECHA</th>
           <th>IMPORTE</th>
         </tr>
       </thead>
       <tbody>
        <?php $nro=1; ?>
         <?php foreach ($recent_sales as  $recent_sale): ?>
         <tr>
           <td class="text-center"><?php echo $nro++; ?></td>
           <td>
            
             <?php echo $recent_sale['folio']; ?>-<?php echo $recent_sale['numero_factura']; ?>
           
           </td>
           <td><?php echo $recent_sale['fecha_factura']; ?></td>
           <td>S/. <?php echo $recent_sale['total_venta']; ?></td>
        </tr>

       <?php endforeach; ?>
       </tbody>
     </table>
    </div>
   </div>
  </div>
 </div>

        
<div class="row">
  <div class="col-md-12">
    <div class="box box-info">
      <div id="loader"></div>
      <div class="box-footer">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="box box-default banking-box">
              <div class="box-header with-border">
                <h3 class="box-title">VENTAS Y COMPRAS (10 DIAS)</h3>
              </div>
              <div class="box-body">
                <div class="x_content1">
              <div id="graph_bar_group1" style="width:100%; height:280px;"></div>
              
              
            </div>
              </div>
              
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="box box-default banking-box">
              <div class="box-header with-border">
                <h3 class="box-title">ENTRADAS Y SALIDAS (10 DIAS)</h3>
              </div>
              <div class="box-body">
                <div class="x_content1">
              
              
              <div id="graph_bar_group" style="width:100%; height:280px;"></div>
            </div>
              </div>
              
            </div>
          </div>
          
        </div>

      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-footer">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="box box-default banking-box">
              <div class="box-header with-border">
                <h3 class="box-title">VENTAS Y COMPRAS (ULTIMOS MESES)</h3>
              </div>
              <div class="box-body">
                <div class="x_content1">
              <div id="graph_bar_group2" style="width:100%; height:280px;"></div>
              
              
            </div>
              </div>
              
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="box box-default banking-box">
              <div class="box-header with-border">
                <h3 class="box-title">ENTRADAS Y SALIDAS (ULTIMOS MESES)</h3>
              </div>
              <div class="box-body">
                <div class="x_content1">
              
              
              <div id="graph_bar_group3" style="width:100%; height:280px;"></div>
            </div>
              </div>
              
            </div>
          </div>
          
        </div>

      </div>
    </div>
  </div>
</div> 
         
         
</section>
</div>

         <?php include ("footer.php"); ?>
        <!-- /footer content -->


  <script src="assets/js/jquery.scrollTo.min.js"></script>
  <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

  <script src="assets/js/common-scripts.js"></script>

  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->


  <script>
     $(function () {

    var day_data = [
        
        <?php
                    for($i = 0;$i<=9;$i++){
                ?>
                {"period": "<?php print"$fec[$i]";?>", "Entradas": <?php print"$a2[$i]";?>, "Salidas": <?php print"$a4[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group',
        data: day_data,
        xkey: 'period',
        barColors: ['#04B431', 'orange', '#ACADAC', 'orange'],
        ykeys: ['Entradas', 'Salidas'],
        labels: ['Entradas', 'Salidas'],
        hideHover: 'auto',
        xLabelAngle: 60
    });

 

});
    $(function () {

   
    var day_data = [
        
        <?php
                    for($i = 0;$i<=9;$i++){
                ?>
                {"period": "<?php print"$fec[$i]";?>", "Ventas": <?php print"$a1[$i]";?>, "Compras": <?php print"$a3[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group1',
        data: day_data,
        xkey: 'period',
        barColors: ['#0000FF', '#FF0000', '#ACADAC', '#3498DB'],
        ykeys: ['Ventas', 'Compras'],
        labels: ['Ventas', 'Compras'],
        hideHover: 'auto',
        xLabelAngle: 60
    });



var day_data = [
        
        <?php
                    for($i = 1;$i<=$m1;$i++){
                ?>
                {"period": "<?php print"$fec1[$i]";?>", "Entradas": <?php print"$a6[$i]";?>, "Salidas": <?php print"$a8[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group3',
        data: day_data,
        xkey: 'period',
        barColors: ['#04B431', 'orange', '#ACADAC', 'orange'],
        ykeys: ['Entradas', 'Salidas'],
        labels: ['Entradas', 'Salidas'],
        hideHover: 'auto',
        xLabelAngle: 60
    });
    
    
    var day_data = [
        
        <?php
                    for($i = 1;$i<=$m1;$i++){
                ?>
                {"period": "<?php print"$fec1[$i]";?>", "Ventas": <?php print"$a5[$i]";?>, "Compras": <?php print"$a7[$i]";?>},
                <?php } ?>
        
        
        
    ];
    Morris.Bar({
        element: 'graph_bar_group2',
        data: day_data,
        xkey: 'period',
        barColors: ['#0000FF', '#FF0000', '#ACADAC', '#3498DB'],
        ykeys: ['Ventas', 'Compras'],
        labels: ['Ventas', 'Compras'],
        hideHover: 'auto',
        xLabelAngle: 60
    });
 

});
 $(document).ready(function(){
      load();
    });
                
 function load(){
      
      $("#loader").fadeIn('slow');
      $.ajax({
        url:'resumen.php',
         beforeSend: function(objeto){
         $('#loader').html('<img src="assets/itsolution24/img/loading2.gif">');
         $('#loader').addClass('ajax-loader');
        },
        success:function(data){
          $(".outer_div").html(data).fadeIn('slow');
          $('#loader').html('');
          $('#loader').removeClass('ajax-loader');
          
        }
      })
    }               
                
$( "#guardar_caja" ).submit(function( event ) {
$('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/nuevo_caja.php",
      data: parametros,
       beforeSend: function(objeto){
        //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
      success: function(datos){
      $("#resultados_ajax").html(datos);
      $('#guardar_datos').html('Guardar datos');
      $('#guardar_datos').attr("disabled", false);
      location.reload(true);
      }
  });
  event.preventDefault();
})
$( "#editar_caja" ).submit(function( event ) {
$('#actualizar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/editar_caja.php",
      data: parametros,
       beforeSend: function(objeto){
        //$("#resultados_ajax2").html("Mensaje: Cargando...");
        },
      success: function(datos){
      $("#resultados_ajax2").html(datos);
      $('#actualizar_datos').html('Actualizar datos');
      $('#actualizar_datos').attr("disabled", false);
      location.reload(true);
      }
  });
  event.preventDefault();
})

  
  function obtener_datos(id){
      var salida = $("#salida"+id).val();
                        var entrada = $("#entrada"+id).val();
                        var faltante = $("#faltante"+id).val();
                         var inicio = $("#inicio"+id).val();
                        $("#salida").val(salida);
                        $("#entrada").val(entrada);
                        $("#faltante").val(faltante);
                        $("#mod_inicio").val(inicio);
                        $("#mod_id").val(id);
    
    }           
  </script> 
  <script src="js/moris/raphael-min.js"></script>
  <script src="js/moris/morris.min.js"></script>

<script type="text/javascript">
    
    //$('#usuarios1').addClass("treeview active");
    $('#resumen').addClass("active");

</script>
 
</body>

</html>