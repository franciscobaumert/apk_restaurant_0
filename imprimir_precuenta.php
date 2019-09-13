<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");

$title="Imprimir Precuenta";



//include('conexion.php');
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$sql2="select * from datosempresa where id_emp=1";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$dolar=$rs2["dolar"];
$count=0;
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
   header("location: login.php");
    exit;
}
        $tienda1=$_SESSION['tienda'];
        $sql3="select * from sucursal where tienda=$tienda1";
        $rw3=mysqli_query($con,$sql3);//recuperando el registro
        $rs3=mysqli_fetch_array($rw3);//trasformar el registro en un vector asociativo
        $caja=$rs3["caja"];
        if($caja==0){
            header("location:error1.php");    
        }
        if (isset($_GET['id_factura']) && $_GET["id_mesa"])
  {
    $id_factura=intval($_GET['id_factura']);
    $id_mesa=intval($_GET['id_mesa']);
    $campos="clientes.direccion_cliente,clientes.id_cliente, clientes.nombre_cliente, clientes.documento, clientes.telefono_cliente, clientes.email_cliente, facturas.id_vendedor, facturas.fecha_factura, facturas.folio, facturas.condiciones, facturas.estado_factura, facturas.numero_factura, facturas.observaciones, mesas.id_mesa";
    $sql_factura=mysqli_query($con,"select $campos from facturas, clientes, mesas where facturas.estado_factura=3 and facturas.id_cliente=clientes.id_cliente and facturas.id_mesa=mesas.id_mesa and id_factura='".$id_factura."'");
    $count=mysqli_num_rows($sql_factura);
    if ($count==1)
    {
        $tienda=$_SESSION['tienda'];
        $rw_factura=mysqli_fetch_array($sql_factura);
        $id_cliente=$rw_factura['id_cliente'];
        $nombre_cliente=$rw_factura['nombre_cliente'];
        $telefono_cliente=$rw_factura['telefono_cliente'];
        $direccion_cliente=$rw_factura['direccion_cliente'];
        $folio=$rw_factura['folio'];
        $doc1=$rw_factura['documento'];
        $numero_factura=$rw_factura['numero_factura'];
        $observaciones=$rw_factura['observaciones'];
        $email_cliente=$rw_factura['email_cliente'];
        $id_vendedor_db=$rw_factura['id_vendedor'];
        $estado_factura=$rw_factura['estado_factura'];
        $session_id=session_id();
        //$delete2=mysqli_query($con, "delete from tmp where session_id='".$session_id."'");
        $sql2=mysqli_query($con, "select * from  detalle_factura where numero_factura='".$numero_factura."' and folio='".$folio."' and tienda=$tienda and tipo_doc=3");
                                //$sql4="select * from  detalle_factura where numero_factura='".$numero_factura."' and folio='".$folio."' and tienda=$tienda and tipo_doc=1";
                                while ($row2=mysqli_fetch_array($sql2))
                                {
                                    $precio_venta=$row2['precio_venta'];
                                    $cantidad=$row2['cantidad'];
                                    $id=$row2['id_producto'];
                                    $id_detalle=$row2['id_detalle'];
                                    //$insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,tienda) VALUES ('$id','$cantidad','$precio_venta','$session_id','1000')");
                                }
        $_SESSION['id_factura']=$id_factura;
        $_SESSION['numero_factura']=$numero_factura;
                                
                                
                                
                                if($a[38]==0){
                                    header("location:error.php");    
   
                                }
                                
    } 
    else
    {
      header("location: disponibilidad.php");
      exit; 
    }
  } 

  
?>


<?php
$read="";  
$required="";
$color="";
$form="precuenta.php";
$select1="";
$select2="";
$doc="nota";
$_SESSION['doc_ventas']=3;
//print"$sql4";

?>



<!DOCTYPE html>
<html lang="en" ng-app="angularApp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=9">
  <title>.:: Imprimir Precuenta | Casa Royales ::. </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="google" content="notranslate">
    
  <!-- Favicon -->
    
    <link rel="shortcut icon" href="assets/itsolution24/img/logo-favicons/nofavicon.png">

  <!-- ALL CSS -->
    
      <!-- Bootstrap CSS -->
      <link href="assets/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet">

      <!-- jquery UI CSS -->
        <link type="text/css" href="assets/jquery-ui/jquery-ui.min.css" type="text/css" rel="stylesheet">

      <!-- Font Awesome CSS -->
      <link href="assets/font-awesome/css/font-awesome.css" type="text/css" rel="stylesheet">

      <!-- Datepicker3 CSS -->
    <link href="assets/datepicker/datepicker3.css" type="text/css" rel="stylesheet">

    <!-- Bootstrap Timepicker CSS -->
    <link href="assets/timepicker/bootstrap-timepicker.min.css" type="text/css" rel="stylesheet">

      <!-- Perfect Scrollbar CSS -->
      <link href="assets/perfectScroll/css/perfect-scrollbar.css" type="text/css" rel="stylesheet">

      <!-- Select2 CSS -->
      <link href="assets/select2/select2.min.css" type="text/css" rel="stylesheet">

      <!-- Toastr CSS -->
      <link href="assets/toastr/toastr.min.css" type="text/css" rel="stylesheet">

      <!-- jQuery ContextMenu CSS -->
      <link  href="assets/contextMenu/dist/jquery.contextMenu.min.css" type="text/css" rel="stylesheet">

    <!-- Filemanager CSS -->
      <link href="assets/itsolution24/css/filemanager/dialogs.css" type="text/css" rel="stylesheet">
      <link href="assets/itsolution24/css/filemanager/main.css" type="text/css" rel="stylesheet">

      <!-- Theme CSS -->
      <link href="assets/itsolution24/css/theme.css" type="text/css" rel="stylesheet">

      <!-- Skin Black CSS -->
      <link href="assets/itsolution24/css/skins/skin-black.css" type="text/css" rel="stylesheet">

      <!-- Skin Blue CSS -->
      <link href="assets/itsolution24/css/skins/skin-blue.css" type="text/css" rel="stylesheet">

      <!-- Skin Green CSS -->
      <link href="assets/itsolution24/css/skins/skin-green.css" type="text/css" rel="stylesheet">

      <!-- Skin Red CSS -->
      <link href="assets/itsolution24/css/skins/skin-red.css" type="text/css" rel="stylesheet">

      <!-- Skin Yellow CSS -->
      <link href="assets/itsolution24/css/skins/skin-yellow.css" type="text/css" rel="stylesheet">

      <!-- Main CSS -->
      <link href="assets/itsolution24/css/main.css" type="text/css" rel="stylesheet">

    <!-- Skeleton CSS -->
    <link href="assets/itsolution24/css/pos/skeleton.css" rel="stylesheet" type="text/css">

    <!-- Main CSS -->
    <link href="assets/itsolution24/css/pos/pos.css" rel="stylesheet" type="text/css">

    <!-- Responsive CSS -->
    <link href="assets/itsolution24/css/pos/responsive.css" rel="stylesheet" type="text/css">


  <!-- This is Mandatory -->
  <style type="text/css">
    body::after { 
      content: ""; background: url(assets/itsolution24/img/pos/patterns/brickwall.jpg) repeat repeat;opacity: 0.4;filter: alpha(opacity=40);top: 0;left: 0;bottom: 0;right: 0;position: absolute;z-index: -1;
    }
    .modal-lg .modal-content {
      border-color: #ffffff;
    }

  </style>


  <!-- JS -->

</head>
<body class="pos sidebar-mini  skin-black   right-panel" ng-controller="PosController">
<div class="hidden"><?php include('assets/itsolution24/img/iconmin/icon.svg');?></div>
<div id="skeleton">
  <div class="skeleton-topbar"></div>
  <div class="skeleton-sidebar"></div>
  <div class="skeleton-left-side"></div>
</div>
  <!-- POS Content-Wrapper Start -->
  <div class="pos-content-wrapper">

    <div id="vertial-toolbar">
      <span data-toggle="modal" data-target="#nuevoProducto" class="toolbar-icon bg-orange mt-5" title="Nuevo Producto">
        <span class="expand bg-orange">Nuevo</span>
        <!--<svg class="svg-icon"><use href="#icon-card"></svg>-->
        <i class="fa fa-plus"></i>
      </span>

      <!--<span data-toggle="modal" data-target="#myModal1" class="toolbar-icon bg-orange mt-5" title="Servicio | Descripcion">
        <span class="expand bg-orange">Servicio</span>
        <svg class="svg-icon"><use href="#icon-card"></svg>
        <i class="fa fa-search"></i>
      </span>-->
    </div>

    <?php include('top.php'); ?>

    <?php 
  //include("modal/buscar_productos.php");
  include("modal/registro_productos.php");
  include("modal/buscar_servicio.php");
  include("modal/registro_clientes_ruc.php");
  include("modal/registro_clientes.php");
  
?>



<?php if(isset($_GET["id_factura"]) && $_GET["id_mesa"]){

$sql_factura2=mysqli_query($con,"select * from mesas where id_mesa=".$_GET['id_mesa']."");
$rw_factura2=mysqli_fetch_array($sql_factura2);
$id_mesa=$rw_factura2['id_mesa'];
$nombre_mesa=$rw_factura2['nombre_mesa'];

?>
    <!-- Content Wrapper Start -->
    <div class="content-area">
      <div class="row-group">
        <div class="content-row">
          
          <!-- All Product List Section Start-->
          <div id="left-panel" class="pos-content" style="">
            <div class="contents">
              <div id="searchbox">
                
                  <input type="text" autocomplete="off" id="q" placeholder="Buscar producto por nombre / escáner de código de barras" onkeyup="load(1); this.value=this.value.toUpperCase();" autofocus>
                                
                <svg class="svg-icon search-btn"><use href="#icon-pos-search"></svg>

                <div class="category-search">
                  <select class='form-control select2' style="width: 100%;" name='id_categoria' id='id_categoria' onchange="load(1);">
                      <option value="">Ver todos los productos</option>
                      <?php 
                      $query_categoria=mysqli_query($con,"select * from categorias order by nom_cat");
                      while($rw=mysqli_fetch_array($query_categoria)) {
                        ?>
                      <option value="<?php echo $rw['id_categoria'];?>"><?php echo $rw['nom_cat'];?></option>      
                        <?php
                      }
                      ?>
                  </select>
                </div>
                
              </div>
              <div id="item-list">
                <div class="pos-product-pagination pagination-top"></div>
                <!--<div class="ajax-loader">-->
                  <div id="loader"></div>
                <!--</div>-->

                <div class="add-new-product-wrapper" data-ng-class="{'show': showAddProductBtn}">
                  <div class="add-new-product">
                    <div class="add-new-product-btn">
                      <button ng-click="createNewProduct()" class="btn btn-lg btn-danger" style="width:auto;">
                        <span class="fa fa-fw fa-plus"></span>
                        <span>123</span>
                      </button>
                      <button ng-click="OpenBuyingProductModal();" class="btn btn-lg btn-danger" style="width:auto;">
                        <span class="fa fa-fw fa-money"></span>
                        <span>123</span>
                      </button>
                    </div>
                  </div>
                </div>
                
                <!--<div class="outer_div" ></div>-->
                
                <div class="pos-product-pagination pagination-bottom"></div>
              </div>
              <?php
                             

$consulta3 = "SELECT * FROM documento ";
$result3 = mysqli_query($con, $consulta3);
while ($valor3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
    if($valor3['id_documento']==$_SESSION['doc_ventas']){
        
       if($_SESSION['tienda']==1){
            $doc=$valor3['tienda1']+1;
            $doc11=$valor3['folio1'];
        }
        if($_SESSION['tienda']==2){
            $doc=$valor3['tienda2']+1;
            $doc11=$valor3['folio2'];         
        }
        if($_SESSION['tienda']==3){
            $doc=$valor3['tienda3']+1;
            $doc11=$valor3['folio3'];
        }
        if($_SESSION['tienda']==4){
            $doc=$valor3['tienda4']+1;
            $doc11=$valor3['folio4'];
        }
        if($_SESSION['tienda']==5){
            $doc=$valor3['tienda5']+1;
            $doc11=$valor3['folio5'];
        }
        if($_SESSION['tienda']==6){
            $doc=$valor3['tienda6']+1;
            $doc11=$valor3['folio6'];
        } 
    
    }
}
                                  ?>
              <div id="total-amount">
                <div class="total-amount-inner">
                  <span class="currency-symbol">
                  </span> 
                  <span class="main-amount">
                    <?php echo $rw_factura2['nombre_mesa']; ?> |
                    <?php echo $folio;?>-<?php echo $numero_factura;?>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <!-- All Product Section End -->

          <!--Invoive Section Start-->
          <div id="right-panel" class="pos-content" style="">
            <?php
                    $read="";  
                    $required="";
                    $color="";
                    $form="precuenta.php";

                    // $_SESSION['doc_ventas']==3 ;
                        $doc="Ticket";
                        $read="readonly";
                        $dato="INGRESAR RUC/DNI";
                    
                    


                    ?>

            <form class="form-horizontal" role="form" id="datos_factura" action="<?php echo $form;?>" method="post">
            <input type="hidden" name="id_mesa" id="id_mesa" value="<?php echo $rw_factura2['id_mesa']; ?>">
            <input type="hidden" name="id_detalle" id="id_detalle" value="<?php echo $id_detalle; ?>"> 
            <div class="invoice-area">
              <div class="well well-sm">
                
                <!-- Customer Area Start-->
                <div id="customer-area">
                  <input type="text" autocomplete="off" name="doc1" id="doc1" placeholder="<?php echo $dato;?>" required onKeyUp="this.value=this.value.toUpperCase();" value="11111111" class="form-control" readonly>
                  
                  <div class="customer-icon">
                    <a >
                      <svg class="svg-icon"><use href="#icon-pos-customer"></svg>
                    </a>
                  </div>




                  <input type="text" id="nombre_cliente" placeholder="Nombre del cliente" required onKeyUp="this.value=this.value.toUpperCase();" value="CLIENTES VARIOS" autocomplete="off" class="form-control hidden" readonly>
                  <input id="id_cliente" type='hidden'>


                  <div class="col-md-6 hidden"> 
                  <label class="control-label">Tipo Doc: <span class="symbol required"></span></label>
                  <select  class='form-control ' id="tip_doc" name="tip_doc" style="height: 30px;">
                  <?php         
                  if ($_SESSION['doc_ventas']==1 or $_SESSION['doc_ventas']>=3) {
                  ?>

                  <option value="2" selected>RUC</option>
                  <?php
                  }         
                  if ($_SESSION['doc_ventas']==2 or $_SESSION['doc_ventas']==3 or $_SESSION['doc_ventas']==8) {
                  ?>
                  <option value="1" selected>DNI</option>
                  <?php
                  }         

                  ?>


                  </select>
                  </div>


                  <div type="button" class="edit-icon pointer btn btn-warning hidden" id="btn-ingresar" style="position: absolute;right: 140px;color: #fff;top: 0px;height:50px;">
                    <i class="fa fa-search" style="margin-top: 10px;"></i>
                  </div>
                  <div class="dropdown add-icon">
                            <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><svg class="svg-icon"><use href="#icon-pos-plus"></svg></div>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    <li><a href="#" data-toggle="modal" data-target="#nuevoClienteruc"><i class="fa fa-plus"></i> Buscar RUC</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#nuevoCliente"><i class="fa fa-plus"></i> Buscar DNI</a></li>

                                </ul>
                    </div>

                  <div class="previous-due" style="height: 50px;">
                    <div class="previous-due-inner" style="margin-top: 11px;">
                      <h4 xng-click="duePaid()">
                        <a style="cursor: pointer; height: 15px;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span id="dueAmount">
                          <?php echo "$doc";?> <!--<i class="fa fa-angle-down"></i>-->
                    <!--<ul class="dropdown-menu" role="menu">-->
                        <!--<li><a href="doc.php?accion=1&tipo=1?&id_mesa=<?php echo $id_mesa; ?>">Factura</a>
                      </li>
                      <li><a href="doc.php?accion=2&tipo=1?&id_mesa=<?php echo $id_mesa; ?>">Boleta</a>
                      </li>-->
                     <!--<li><a href="doc.php?accion=3&tipo=1?&id_mesa=<?php echo $id_mesa; ?>">Ticket</a>-->
                      <!--</li>
                       <li><a href="doc.php?accion=8&tipo=1?&id_mesa=<?php echo $id_mesa; ?>">Cotizacion</a>
                      </li>-->
                    <!--</ul>-->
                        </span>
                        </a>
                      </h4>
                    </div>
                  </div>



                  <?php
                             

$consulta3 = "SELECT * FROM documento ";
$result3 = mysqli_query($con, $consulta3);
while ($valor3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
    if($valor3['id_documento']==$_SESSION['doc_ventas']){
        
       if($_SESSION['tienda']==1){
            $doc=$valor3['tienda1']+1;
            $doc11=$valor3['folio1'];
        }
        if($_SESSION['tienda']==2){
            $doc=$valor3['tienda2']+1;
            $doc11=$valor3['folio2'];         
        }
        if($_SESSION['tienda']==3){
            $doc=$valor3['tienda3']+1;
            $doc11=$valor3['folio3'];
        }
        if($_SESSION['tienda']==4){
            $doc=$valor3['tienda4']+1;
            $doc11=$valor3['folio4'];
        }
        if($_SESSION['tienda']==5){
            $doc=$valor3['tienda5']+1;
            $doc11=$valor3['folio5'];
        }
        if($_SESSION['tienda']==6){
            $doc=$valor3['tienda6']+1;
            $doc11=$valor3['folio6'];
        } 
    
    }
}
                                  ?>

                  <div class="row hidden">
                  <div class="col-md-12 ">
                  <label class="control-label">Direccion del cliente: <span class="symbol required"></span></label>
                  <input type="text" autocomplete="off" class="form-control " id="direccion_cliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Dirección del cliente" <?php echo $required;?> style="height: 30px;">
                  </div>
                  </div>

                  

                   <div class="row hidden">
                    <div class="col-md-12"> 
                    <label class="control-label">Stock de productos: <span class="symbol required"></span></label>
                    <select class='form-control ' id="des" required>


                    <option value=0>NO MOVER STOCK</option>
                  


                    </select>
                    </div>
                     </div>

                     <?php date_default_timezone_set('America/Santiago');?>


                      <div class="row"> 
                        <div class="col-md-6 hidden"> 
                      <label class="control-label">Fecha: <span class="symbol required"></span></label>
                      <input style="height: 30px;" type="date" class="form-control " id="fecha" value="<?php echo date("Y-m-d");?>" required>
                        </div>

                        <div class="col-md-6 hidden"> 
                      <label class="control-label">Hora: <span class="symbol required"></span></label>
                      <input style="height: 30px;" type="time" class="form-control " id="hora" value="<?php echo date("H:i:s");?>" required>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-2 col-xs-12 hidden">
                      Teléfono
                      <input type="text" autocomplete="off" class="form-control " id="tel1" placeholder="Teléfono" onKeyUp="this.value=this.value.toUpperCase();">
                      </div>

                      <div class="col-md-2 col-sm-2 col-xs-12 hidden">
                      Email
                      <input type="text" autocomplete="off" class="form-control " id="mail" placeholder="Email" onKeyUp="this.value=this.value.toUpperCase();">
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12 hidden">

                      Folio<input type="text" value="<?php echo $folio;?>" class="form-control " id="folio" placeholder="Folio" readonly required>
                      </div>

                      <div class="col-md-4 col-sm-4 col-xs-12 hidden">

                      Número de Documento<input type="text" value="<?php echo $numero_factura;?>" class="form-control " id="factura" placeholder="Número de doc" readonly required>
                      </div>


                  
                </div>
                <!-- Customer Area Start-->

                <!-- Invoice Item Start-->
                <div id="invoice-item">
                  <!-- Selected Product List Title Start -->
                  <table id="invoice-item-head" class="table table-striped">
                    <thead>
                      <tr>
                        <th>
                          Cantidad
                        </th> 
                        <th>
                          Producto
                        </th>
                        <th>
                          Precio
                        </th>
                        <th>
                          Subtotal
                        </th>
                        <th>&nbsp; </th>
                      </tr>
                    </thead>
                  </table>
                  <!-- Selected Product List Title Start -->

                  <!-- Selected Product List Section Start-->
                  <div id="invoice-item-list">
                    <div id="resultados"></div>
                  </div>
                  <!-- Selected Product List Section End-->

                  <!-- Selected Product Calculation Section Start-->

                  <div id="invoice-calculation" class="clearfix hidden">

                  <div class="col-md-12">
                    <textarea class="form-control" name="observaciones" id="observaciones" cols="30" rows="2" style="resize: none;" placeholder="Observaciones..." onKeyUp="this.value=this.value.toUpperCase();"><?php echo $observaciones; ?></textarea>
                  </div>

                  <div class="col-md-6" style="padding-top: 5px; padding-bottom: 5px;"> 
                  <select style="height: 30px;" class='form-control ' id="condiciones">
                  <option value="1">EFECTIVO</option>
                  <option value="2">CHEQUE</option>
                  <option value="3">TRANSF. BANCARIA</option>
                  <option value="5">TARJETA</option>
                  <?php
                  if ($_SESSION['doc_ventas']<5) {
                  ?>
                  <option value="4" class="">CREDITO</option>
                  <?php            
                  }
                  ?>


                  </select>
                  </div>

                  <div class="col-md-6" style="padding-top: 5px; padding-bottom: 5px;"> 
                  <select style="height: 30px;" class='form-control ' id="tip" required>


                  <?php

                  print"<option value=0>CON IVA</option>";


                  print"<option value=1>EXCENTA</option>";



                                          
                  ?>


                  </select>
                  </div>
                  <input autocomplete="off" type="hidden" value="0" class="form-control " id="dias" name="dias" placeholder="Número de días de crédito">
                  </div>
                  <!-- Selected Product Calculation Section End-->
                </div>
                <!-- Invoice Item End-->

                <!-- Go Button Section Start-->
            
                <div id="pay-button" class="">
                  <button type="submit" class="btn btn-block btn-lg" title="Procesar Pedido">
                    <span class="fa fa-fw fa-print"></span> 
                    <span class="hidden-xs">Precuenta</span>
                  </button>
                </div>

                

                <!-- Go Button Section End-->
                
                <div class="clearfix"></div>
              </div>
            </div>
            </form>
          </div>

          
          <!-- Invoice Section End -->

        </div>
      </div>
    </div>
    <?php } else { ?>

      <script>
            toastr.options = {
            "closeButton":false,
            "progressBar": false
        };
        toastr.warning("Debe seleccionar una mesa","Precaucion");
      </script>

    <?php }  ?>
    
    <!-- Content Wrapper End -->

  </div>   
  <!-- POS Content Wrapper End -->

  <!-- Rightbar Toggle Handler -->
  <div id="minicart">
    <div class="minicart-content">
      <div class="heading">
        <div class="title"></div>
      </div>
      <div class="body">
        <div class="items"><i class="fa fa-arrow-right"></i></div>
      </div>
      <div class="footer"></div>
    </div>
  </div>




    <!-- jQuery JS  -->
      <script src="assets/jquery/jquery.min.js" type="text/javascript"></script> 

      <!-- jQuery Ui JS -->
        <script src="assets/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

      <!-- Bootstrap JS -->
      <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- Angular JS -->
      <script src="assets/itsolution24/angularmin/angular.js" type="text/javascript"></script> 

      <!-- AngularApp JS -->
      <script src="assets/itsolution24/angular/angularApp.js" type="text/javascript"></script>

      <!-- Filemanager JS -->
      <script src="assets/itsolution24/angularmin/filemanager.js" type="text/javascript"></script>

      <!-- Angular JS Modal -->
    <script src="assets/itsolution24/angularmin/modal.js" type="text/javascript"></script>

    <!-- Bootstrap Datepicker JS -->
    <script src="assets/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>

    <!-- Bootstrap Timepicker JS -->
    <script src="assets/timepicker/bootstrap-timepicker.min.js" type="text/javascript" ></script>

    <!-- Select2 JS -->
    <script src="assets/select2/select2.min.js" type="text/javascript"></script>

    <!-- Perfect Scroolbar JS -->
    <script src="assets/perfectScroll/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>

    <!-- Sweet ALert JS -->
    <script src="assets/sweetalert/sweetalert.min.js" type="text/javascript"></script>

    <!-- Toastr JS -->
    <script src="assets/toastr/toastr.min.js" type="text/javascript"></script>

    <!-- Accounting JS -->
    <script src="assets/accounting/accounting.min.js" type="text/javascript"></script>

    <!-- Underscore JS -->
    <script src="assets/underscore/underscore.min.js" type="text/javascript"></script> 

    <!-- Context Menue JS -->
    <script src="assets/contextMenu/dist/jquery.contextMenu.min.js"></script>

    <!-- IE JS -->
    <script src="assets/itsolution24/js/ie.js" type="text/javascript"></script>

    <!-- Common JS -->
    <script src="assets/itsolution24/js/common.js" type="text/javascript"></script>

    <!-- Main JS -->
    <script src="assets/itsolution24/js/main.js" type="text/javascript"></script>

    <!-- POS Main JS -->
    <script src="assets/itsolution24/js/pos/pos.js" type="text/javascript"></script>



<!-- POS Controller JS -->
<script src="assets/itsolution24/angular/modals/AddCustomerMobileNumberModal.js" type="text/javascript"></script>
<script src="assets/itsolution24/angular/controllers/PosController.js" type="text/javascript"></script>

<script type="text/javascript" src="js/VentanaCentrada.js"></script>


<script>

$(window).on("load", function() {
  // hide pos skeleton
  var $skeleton = $("#skeleton");
    $skeleton.fadeOut(100); 
});

    $(function() {
            $("#doc1").autocomplete({
              source: "./ajax/autocomplete/clientes1.php",
              minLength: 1,
              select: function(event, ui) {
                event.preventDefault();
                $('#id_cliente').val(ui.item.id_cliente);
                $('#nombre_cliente').val(ui.item.nombre_cliente);
                $('#tel1').val(ui.item.telefono_cliente);
                $('#mail').val(ui.item.email_cliente);
                $('#doc1').val(ui.item.doc1);
                                                                $('#direccion_cliente').val(ui.item.direccion_cliente);
                
               }
            });
             
            
          });
          
  $("#doc1" ).on( "keydown", function( event ) {
            if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
            {
              $("#id_cliente" ).val("");
              $("#tel1" ).val("");
              $("#mail" ).val("");
                                                        $("#doc1" ).val("");
              $("#direccion_cliente" ).val("");       
            }
            if (event.keyCode==$.ui.keyCode.DELETE){
              $("#nombre_cliente" ).val("");
              $("#id_cliente" ).val("");
              $("#tel1" ).val("");
              $("#mail" ).val("");
                                                        $("#doc1" ).val("");
                                                        $("#direccion_cliente" ).val("");
            }
      }); 
     $(document).ready(function(){
      load(1);
      $( "#resultados" ).load( "ajax/precuenta.php" );
      


      



      $("#minicart").on("click", function() {
    var rightPanel = $("#right-panel");

    if (rightPanel.hasClass("visible")) {
      rightPanel.removeClass("visible");
    } else {
      rightPanel.addClass("visible");
    }
  });

    });







    function load(page){
      var q= $("#q").val();
      var id_categoria= $("#id_categoria").val();
      var parametros={'action':'ajax','page':page,'q':q,'id_categoria':id_categoria};
      $("#loader").fadeIn('slow');
      $.ajax({
        data: parametros,
        url:'./ajax/productos_factura.php',
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


  function agregar (id)
    {
      var precio_venta=document.getElementById('precio_venta_'+id).value;
      var cantidad=document.getElementById('cantidad_'+id).value;
                        var stock=document.getElementById('stock_'+id).value;
      //Inicia validacion
      if (isNaN(cantidad))
      {
      alert('Esto no es un numero');
      document.getElementById('cantidad_'+id).focus();
      return false;
      }                     
                if (isNaN(precio_venta))
      {
      alert('Esto no es un numero');
      document.getElementById('precio_venta_'+id).focus();
      return false;
      }
      //Fin validacion
      
      $.ajax({
        type: "POST",
        url: "./ajax/precuenta.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&stock="+stock,
     beforeSend: function(objeto){
      //$("#resultados").html("Mensaje: Cargando...");
      },
        success: function(datos){
    $("#resultados").html(datos);
    }
      });
    }
    
                
                
               function agregar1 ()
    {
      var precio_venta=document.getElementById('precio_venta').value;
      var cantidad=document.getElementById('cantidad').value;
                        var id=document.getElementById('descripcion').value;
                        var stock=document.getElementById('stock').value;
      //Inicia validacion
      if (isNaN(cantidad))
      {
      alert('Esto no es un numero');
      document.getElementById('cantidad').focus();
      return false;
      }                     
                  if (isNaN(precio_venta))
      {
      alert('Esto no es un numero');
      document.getElementById('precio_venta').focus();
      return false;
      }
      //Fin validacion
      
      $.ajax({
        type: "POST",
        url: "./ajax/precuenta.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&stock="+stock,
     beforeSend: function(objeto){
      //$("#resultados").html("Mensaje: Cargando...");
      },
        success: function(datos){
    $("#resultados").html(datos);
    }
      });
    } 
             
      function eliminar (id)
    {
      
      $.ajax({
        type: "GET",
        url: "./ajax/precuenta.php",
        data: "id="+id,
     beforeSend: function(objeto){
      //$("#resultados").html("Mensaje: Cargando...");
      },
        success: function(datos){
    $("#resultados").html(datos);
    }
      });

    }


    
    $("#datos_factura").submit(function(){
      var id_cliente = $("#id_cliente").val();
      var id_vendedor = $("#id_vendedor").val();
      var condiciones = $("#condiciones").val();
                 
                  var factura = $("#factura").val();
       var fecha = $("#fecha").val();
                    var hora = $("#hora").val();
                     var moneda = $("#moneda").val();
                     var dias = $("#dias").val();
                      var tcp = $("#tcp").val();
                    var folio = $("#folio").val();
                    var nro_doc = $("#nro_doc").val();
                    var motivo = $("#motivo").val();
                    var nombre_cliente = $("#nombre_cliente").val();
                    var doc1 = $("#doc1").val();
                    var tip_doc = $("#tip_doc").val();
                    var tel1 = $("#tel1").val();
                    var mail = $("#mail").val();
                    var direccion = $("#direccion_cliente").val();
                    var des = $("#des").val();
                    var tip = $("#tip").val();
                    var id_mesa = $("#id_mesa").val();
                    var id_detalle = $("#id_detalle").val();
                         var n = doc1.length;
                    
                        if ((n == 11 && tip_doc==2) |  (n == 8 && tip_doc==1) ) {
                            VentanaCentrada('./pdf/documentos/pedido2.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor+'&factura='+factura+'&dias='+dias+'&condiciones='+condiciones+'&fecha='+fecha+'&hora='+hora+'&moneda='+moneda+'&tcp='+tcp+'&folio='+folio+'&nro_doc='+nro_doc+'&motivo='+motivo+'&nombre_cliente='+nombre_cliente+'&doc1='+doc1+'&tip_doc='+tip_doc+'&tel1='+tel1+'&mail='+mail+'&direccion='+direccion+'&des='+des+'&tip='+tip+'&id_mesa='+id_mesa+'&id_detalle='+id_detalle,'Factura','','1024','768','true');
                  
                        }else{
                           
                            alert('El dni o ruc es erroneo');
                            event.preventDefault();
                        }
                    
    });



    
    $( "#guardar_cliente" ).submit(function( event ) {
    $('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
    $('#guardar_datos').attr("disabled", true);
      
     var parametros = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "ajax/nuevo_cliente.php",
          data: parametros,
           beforeSend: function(objeto){
            //$("#resultados_ajax").html('<img src="./img/ajax-loader.gif"> Cargando...');
            },
          success: function(datos){
          $("#resultados_ajax").html(datos);
          $('#guardar_datos').html('Guardar datos');
          $('#guardar_datos').attr("disabled", false);
          load(1);
          }
      });
      event.preventDefault();
    })

    $( "#guardar_cliente_ruc" ).submit(function( event ) {
    $('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
    $('#guardar_datos').attr("disabled", true);
      
     var parametros = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "ajax/nuevo_cliente.php",
          data: parametros,
           beforeSend: function(objeto){
            //$("#resultados_ajax").html('<img src="./img/ajax-loader.gif"> Cargando...');
            },
          success: function(datos){
          $("#resultados_ajax").html(datos);
          $('#guardar_datos').html('Guardar datos');
          $('#guardar_datos').attr("disabled", false);
          load(1);
          }
      });
      event.preventDefault();
    })
    
    $( "#guardar_producto" ).submit(function( event ) {
    $('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
    $('#guardar_datos').attr("disabled", true);
      
     var parametros = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "ajax/nuevo_producto.php",
          data: parametros,
           beforeSend: function(objeto){
            //$("#resultados_ajax_productos").html("Mensaje: Cargando...");
            },
          success: function(datos){
          $("#resultados_ajax_productos").html(datos);
          $('#guardar_datos').html('Guardar datos');
          $('#guardar_datos').attr("disabled", false);
          load(1);
          }
      });
      event.preventDefault();
    })

    $(document).on('ready',function(){

      $('#btn-ingresar').click(function(){
        var url = "busqueda.php";                                      
        
        $.ajax({                        
           type: "POST",                 
           url: url,                    
           data: $("#datos_factura").serialize(),
           success: function(data)            
           {
             $('#doc1').html(data);
             
             porciones = data.split('|');


             document.getElementById("nombre_cliente").value = porciones[0];
             document.getElementById("direccion_cliente").value = porciones[1];
             document.getElementById("tel1").value = porciones[2];
             document.getElementById("mail").value = porciones[3];
           }
         });
         
      });
    });

  
        </script>

        <script>
    $(".select2").select2();
</script>

<script>
    $(function(){
      $('#botoncitoruc').on('click', function(){
        var ruc = $('#ruc').val();
        var url = 'consulta_sunat_forclienteruc.php';
        $('.ajaxgif').removeClass('hide');
        $('.nohidden').addClass('hide');
        $.ajax({
          type:'POST',
          url:url,
          data:'ruc='+ruc,
          success: function(datos_dni){
            $('.ajaxgif').addClass('hide');
            $('.nohidden').removeClass('hide');
            var datos = eval(datos_dni);
            var nada ='nada';
            if(datos[0]==nada){
              alert('DNI o RUC no válido o no registrado');
            }else{
              $('#numero_ruc').text(datos[0]);
              $('#nomclienteruc').val(datos[1]);
              $('#estado_del_contribuyente').val(datos[2]);
              $('#condicion_de_domicilio').val(datos[3]);
              $('#ubgclienteruc').val(datos[4]);
              $('#tipo_de_via').val(datos[5]);
              $('#nombre_de_via').val(datos[6]);
              $('#codigo_de_zona').val(datos[7]);
              $('#numero').val(datos[8]);
              $('#interior').val(datos[9]);
              $('#lote').val(datos[10]);
              $('#dpto').val(datos[11]);
              $('#manzana').val(datos[12]);
              $('#kilometro').val(datos[13]);
              $('#depclienteruc').val(datos[14]);
              $('#proclienteruc').val(datos[15]);
              $('#disclienteruc').val(datos[16]);
              $('#direccion').val(datos[17]);
              $('#direcclienteruc').val(datos[18]);
              $('#ultima_actualizacion').val(datos[19]);
            }   
          }
        });
        return false;
      });
    });
  </script>

  <script type="text/javascript">
    $(function(){
      $('#botoncito').on('click', function(){
        var cedcliente = $('#cedcliente').val();
        var url = 'consulta_reniec_forclientedni.php';
        $('.ajaxgif1').removeClass('hide');
        $('.nohidden1').addClass('hide');
        $.ajax({
          type:'POST',
          url:url,
          data:'cedcliente='+cedcliente,
          success: function(datos_dni){
            $('.ajaxgif1').addClass('hide');
            $('.nohidden1').removeClass('hide');
            porciones = datos_dni.split('|');
            document.getElementById("nomcliente").value = porciones[0];
            document.getElementById("direccion_cliente").value = porciones[1];
            document.getElementById("tel1").value = porciones[2];
            document.getElementById("mail").value = porciones[3];
          }
        });
        return false;
      });
    });
  </script>

<script type="text/javascript">
    
    //$('#usuarios1').addClass("treeview active");
    $('#precuenta').addClass("active");

</script>

</body>
</html>

