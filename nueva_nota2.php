<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");

$title="Generar Nota Boleta";

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
        if (isset($_GET['id_factura']))
  {
    $id_factura=intval($_GET['id_factura']);
    $campos="clientes.direccion_cliente,clientes.id_cliente, clientes.nombre_cliente, clientes.documento, clientes.dni, clientes.ce, clientes.telefono_cliente, clientes.email_cliente, facturas.id_vendedor, facturas.fecha_factura, facturas.folio, facturas.condiciones, facturas.estado_factura, facturas.numero_factura";
    $sql_factura=mysqli_query($con,"select $campos from facturas, clientes where facturas.estado_factura=2 and facturas.id_cliente=clientes.id_cliente and id_factura='".$id_factura."'");
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
        $email_cliente=$rw_factura['email_cliente'];
        $dni=$rw_factura['dni'];
        $ce=$rw_factura['ce'];
        $id_vendedor_db=$rw_factura['id_vendedor'];
        $estado_factura=$rw_factura['estado_factura'];
                                $session_id=session_id();
                                $delete2=mysqli_query($con, "delete from tmp where session_id='".$session_id."'");
        $sql2=mysqli_query($con, "select * from  detalle_factura where numero_factura='".$numero_factura."' and folio='".$folio."' and tienda=$tienda and tipo_doc=2");
                                //$sql4="select * from  detalle_factura where numero_factura='".$numero_factura."' and folio='".$folio."' and tienda=$tienda and tipo_doc=1";
                                while ($row2=mysqli_fetch_array($sql2))
                                {
                                    $precio_venta=$row2['precio_venta'];
                                    $cantidad=$row2['cantidad'];
                                    $id=$row2['id_producto'];
                                    $insert_tmp=mysqli_query($con, "INSERT INTO tmp (id_producto,cantidad_tmp,precio_tmp,session_id,tienda) VALUES ('$id','$cantidad','$precio_venta','$session_id','1000')");
                                }
        $_SESSION['id_factura']=$id_factura;
        $_SESSION['numero_factura']=$numero_factura;
                                
                                
                                
                                if($a[42]==0){
                                    header("location:error.php");    
   
                                }
                                
    } 
    else
    {
      header("location: facturas.php");
      exit; 
    }
  } 

  
?>

<?php include ("header.php"); ?>
<?php

menu1();

?>

<?php
$read="";  
$required="";
$color="";
$form="facturas.php";
$select1="";
$select2="";
$doc="Nota";
if ($_SESSION['doc_ventas']==9) {
$doc="Nota de Debito";
$form="credito-debito.php";
$select1="selected";
}
if ($_SESSION['doc_ventas']==10) {
$doc="Nota de Credito";
$form="credito-debito.php";
$select2="selected";
}
//print"$sql4";

?>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      NOTA CREDITO - DEBITO
      <small>
        GENERAR NOTA
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
        NOTA CREDITO - DEBITO
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
              DATOS DEL COMPROBANTE
            </h3>
          </div>
          <div class="box-body">
            <form class="form-horizontal" role="form" action="nueva_nota3.php" method="get">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        Tipo de Nota:
                        <select class='form-control' id="nota" name="nota" required>
                            <option value="10" <?php echo $select2;?>>Nota de Credito</option>
                            <option value="9"  <?php echo $select1;?>>Nota de Debito</option>
                        </select>
                    </div> 
                    <div class="col-md-2 col-sm-2 col-xs-12">
                    N° Doc. Modificado:<select  class="select2_single form-control" tabindex="-1" id="doc_mod" name="doc_mod" required>
                    <?php
                                                                $consulta4 = "SELECT * FROM facturas WHERE estado_factura=2 and ven_com=1 and activo=1";
                                                                $result4 = mysqli_query($con, $consulta4);
                                                                while ($valor4 = mysqli_fetch_array($result4, MYSQLI_ASSOC)) {
                                                                    if($valor4["id_factura"]==$_GET['id_factura']){
                                                                    ?>     
                                                     
                                                                    <option  value="<?php print"$valor4[id_factura]";?>" selected><?php print"$valor4[folio]-$valor4[numero_factura]";?></option>      
                                                                    <?php      
                                                                    }else{
                                                                    ?>     
                                                      
                                                                    <option  value="<?php print"$valor4[id_factura]";?>"><?php print"$valor4[folio]-$valor4[numero_factura]";?></option>      
                                                                    <?php 
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                             
                     </div><br>
                     <div class="col-md-2 col-sm-2 col-xs-12">   
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-search"></span> Buscar
      </button>
                    </div>     
                    </form>
    <?php 
      include("modal/buscar_productos.php");
      include("modal/buscar_servicio.php");
      //include("modal/registro_clientes.php");
      if ($count==1)
    {
                            
                       
    ?>
    <br><br><br>
                    <form class="form-horizontal" role="form" id="datos_factura" action="credito-debito.php" method="get">
       <font color="black">LLenar los campos <span class="symbol required"></span></font>
                          
                        <div class="form-group row" >
          
          <div class="col-md-8 col-sm-8 col-xs-12">
                                      Cliente <span class="symbol required"></span>
                                      <input type="search" class="form-control" id="nombre_cliente" value="<?php echo $nombre_cliente;?>" placeholder="Buscar un cliente o ingresar cliente nuevo" readonly>
            <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>"> 
          </div>
                            
                                  <div class="col-md-2 col-sm-2 col-xs-12">
                                                            Documento del cliente <span class="symbol required"></span>
                                                                         
                <input type="text" autocomplete="off" class="form-control" name="doc1" id="doc1" value="<?php echo $doc1;?>" placeholder="RUC/DNI" readonly>
              </div>
                            
                                    <div  class="col-md-2 col-sm-2 col-xs-12">
                                                           Tipo Doc
                <select  class='form-control' id="tip_doc" name="tip_doc">
                                                                   <?php         
                                                                   if ($_SESSION['doc_ventas']==5 or $_SESSION['doc_ventas']==6) {
                                                                     ?>
                                                                    
                                                                    <option value="2" selected>RUC</option>
                                                                     <?php
                                                                   }         
                                                                   if ($_SESSION['doc_ventas']==9 or $_SESSION['doc_ventas']==10) {
                                                                     ?>
                                                                    <option value="1" <?php if ($dni<>0){ echo "selected"; }?> >DNI</option>
                                                                    <option value="3" <?php if ($ce<>0){ echo "selected"; }?> >Carnet Extranjería</option>

                                                                    <?php
                                                                   }         
                                                                            
                                                                    ?>
                  
                  
                </select>
              </div>                     
                            
                                  <div class="col-md-2 col-sm-2 col-xs-12">
                                      
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
        }
        if($_SESSION['tienda']==4){
            $doc=$valor3['tienda4']+1;
        }
        if($_SESSION['tienda']==5){
            $doc=$valor3['tienda5']+1;
        }
        if($_SESSION['tienda']==6){
            $doc=$valor3['tienda6']+1;
        } 
    
    }
}
                                  ?>
                                     </div>
                                     <div class="form-group row" >
                                          <div class="col-md-8 col-sm-8 col-xs-12">
                                                            Dirección del cliente
                <input type="text" autocomplete="off" value="<?php echo $direccion_cliente;?>" class="form-control" id="direccion_cliente" placeholder="Dirección del cliente" readonly>
              </div>
                                         <div class="col-md-2 col-sm-2 col-xs-12">
                                                            Teléfono
                <input type="text" autocomplete="off" class="form-control" id="tel1" value="<?php echo $telefono_cliente;?>" placeholder="Teléfono" readonly>
              </div>
                                                        <input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>">
              <div class="col-md-2 col-sm-2 col-xs-12">
                                                            Email
                <input type="text" autocomplete="off" class="form-control" id="mail" placeholder="Email" value="<?php echo $email_cliente;?>" readonly>
              </div>
                                     </div>
                         
                         
            <div class="form-group row">
              <div class="col-md-2 col-sm-2 col-xs-12">
                                                            
                Folio<input type="text" value="<?php echo $doc11;?>" class="form-control" id="folio" placeholder="Folio" readonly required>
              </div>
                                                        
                                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                                            
                Nro Doc<input type="text" value="<?php echo $doc;?>" class="form-control" id="factura" placeholder="Número de doc" readonly required>
              </div>
                                  
                                                         <div class="col-md-2 col-sm-2 col-xs-12">
                                                             N° Doc. Modificado:<input type="text" value="<?php print"$folio-$numero_factura";?>" class="form-control" id="nro_doc" placeholder="Número de doc" readonly required>
                                                           
                                                                
                                                         </div>
                                                    
                                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                            <?php
                                                            if ($_SESSION['doc_ventas']<>9 and $_SESSION['doc_ventas']<>10 ) {
                                                                
                                                            ?>
                                                            Motivo (Nota de crédito y débito) <span class="symbol required"></span> <input autocomplete="off" type="text"  class="form-control" id="motivo" placeholder="Motivo" <?php echo $read;?>>
                                                            <?php
                                                            }
                                                            if ($_SESSION['doc_ventas']==10) {
                                                            ?>
                                                             Motivo <span class="symbol required"></span>
                                                            <select class='form-control' id="motivo" required>
                                              <option value="">SELECCIONA MOTIVO</option>        
                                                                <option value="01">ANULACION DE LA OPERACION</option>
                                                                <option value="02">ANULACION POR ERROR EN EL RUC</option>
                            <option value="03">CORRECION POR ERROR EN LA DESCRIPCION</option>
                            <option value="04">DESCUENTO GLOBAL</option>
                            <option value="05">DESCUENTO POR ITEM</option>
                            <option value="06">DEVOLUCION TOTAL</option>
                            <option value="07">DEVOLUCION POR ITEM</option>
                            <option value="08">BONIFICACION</option>
                            <option value="09">DISMINUCION EN EL VALOR</option>
                                          </select>
                                                            
                                                            <?php
                                                            }
                                                            
                                                            ?>
                                                             
                                                            <?php
                                                            if ($_SESSION['doc_ventas']==9) {
                                                            ?>
                                                             Motivo <span class="symbol required"></span>
                                                            <select class='form-control' id="motivo" required>
                                              
                                                                <option value="">SELECCIONA MOTIVO</option>
                            <option value="01">INTERES POR MORA</option>
                                              <option value="02">AUMENTO EN EL VALOR</option>
                                              <option value="03">PENALIDADES</option>
                                          </select>
                                                            
                                                            <?php
                                                            }
                                                            
                                                            ?> 
                
              </div>
                                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                                         Stock de productos <span class="symbol required"></span>
                                                        <select class='form-control' id="des" required>
                                              
                                                                
                                                                <?php
                                                            if($_SESSION['doc_ventas']>=9) {
                                                                print"<option value=0>NO MOVER STOCK</option>";
                                                            }    
                                                            if($_SESSION['doc_ventas']<=3 or $_SESSION['doc_ventas']==10) {
                                                                print"<option value=1>DESCONTAR STOCK(-)</option>";
                                                            }    
                                                            if($_SESSION['doc_ventas']==10) {
                                                                print"<option value=2>REPONER STOCK(+)</option>";
                                                            }
                                                            
                                                            ?>
                            
                                              
                                          </select>
                                                    </div>
                                                    
                              </div>
            <div class="form-group row">
              
              <?php date_default_timezone_set('America/Santiago');?>
              
              <div class="col-md-4 col-sm-4 col-xs-12">
                                                            Fecha <span class="symbol required"></span>
                <input type="date" class="form-control" id="fecha" value="<?php echo date("Y-m-d");?>" required>
              </div>
              
                                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                            Hora <span class="symbol required"></span>
                <input type="time" class="form-control" id="hora" value="<?php echo date("H:i:s");?>" required>
              </div>
                                                    
                                                   
                                                    <input type="hidden" class="form-control" value="1" name="moneda" id="moneda"  required>
            
                                                    <input type="hidden" class="form-control" value="<?php echo $dolar;?>" name="tcp" id="tcp"  required>
              
                                                    <div  class="col-md-4 col-sm-4 col-xs-12">
                                                            Pago <span class="symbol required"></span>
                <select class='form-control' id="condiciones">
                  <option value="1">Efectivo</option>
                  <option value="2">Cheque</option>
                  <option value="5">Visa</option>
                  <option value="6">MasterCard</option>
                  <option value="7">American Express</option>
                  <option value="8">Dinners Club</option>
                  <option value="3">Deposito | Transferencia</option>
                   <?php
                                                                        if ($_SESSION['doc_ventas']<5) {
                                                                        ?>
                                                                            <!--<option value="4">Crédito</option>-->
                                                                        <?php            
                                                                        }
                                                                        ?>
                                                                        
                                                                        
                </select>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12 hidden">
                                                            Nro Dias
                <input style="background-color: #F5D0A9;" autocomplete="off" type="text" value="0" class="form-control" id="dias" name="dias" placeholder="Número de días de crédito">
              </div>
                                                        
            </div>
        
        
        <div class="col-md-12">
          <div class="pull-right">
            
            
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
             <span class="glyphicon glyphicon-search"></span> Productos
            </button>
                                            
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal1">
             <span class="glyphicon glyphicon-search"></span> Servicio o descripcion
            </button>
                                            
            <button type="submit" class="btn btn-primary">
              <span class="glyphicon glyphicon-print"></span>
            </button>
          </div>  
        </div>
      </form> 
      
    <br><br><br>                
    <div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
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

  
  <script type="text/javascript" src="js/VentanaCentrada.js"></script>
  
  
    <script type="text/javascript" src="js/editar_factura2.js"></script>
  <script>
    $(function() {
            $("#nombre_cliente").autocomplete({
              source: "./ajax/autocomplete/clientes.php",
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
          
  $("#nombre_cliente" ).on( "keydown", function( event ) {
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
      $( "#resultados" ).load( "./ajax/editar_facturacion.php" );
    });

    function load(page){
      var q= $("#q").val();
      $("#loader").fadeIn('slow');
      $.ajax({
        url:'./ajax/productos_factura1.php?action=ajax&page='+page+'&q='+q,
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
        url: "./ajax/editar_facturacion.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&stock="+stock,
     beforeSend: function(objeto){
      //$("#resultados").html('<img src="./img/ajax-loader.gif"> Cargando...');
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
        url: "./ajax/editar_facturacion.php",
        data: "id="+id+"&precio_venta="+precio_venta+"&cantidad="+cantidad+"&stock="+stock,
     beforeSend: function(objeto){
      //$("#resultados").html('<img src="./img/ajax-loader.gif"> Cargando...');
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
        url: "./ajax/editar_facturacion.php",
        data: "id="+id,
     beforeSend: function(objeto){
      //$("#resultados").html('<img src="./img/ajax-loader.gif"> Cargando...');
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
                       
                            VentanaCentrada('./pdf/documentos/factura_pdf.php?id_cliente='+id_cliente+'&id_vendedor='+id_vendedor+'&factura='+factura+'&dias='+dias+'&condiciones='+condiciones+'&fecha='+fecha+'&hora='+hora+'&moneda='+moneda+'&tcp='+tcp+'&folio='+folio+'&nro_doc='+nro_doc+'&motivo='+motivo+'&nombre_cliente='+nombre_cliente+'&doc1='+doc1+'&tip_doc='+tip_doc+'&tel1='+tel1+'&mail='+mail+'&direccion='+direccion+'&des='+des,'Factura','','1024','768','true');
         
    });
    
    $( "#guardar_cliente" ).submit(function( event ) {
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
          $('#guardar_datos').attr("disabled", false);
          load(1);
          }
      });
      event.preventDefault();
    })
    
    $( "#guardar_producto" ).submit(function( event ) {
      $('#guardar_datos').attr("disabled", true);
      
     var parametros = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "ajax/nuevo_producto.php",
          data: parametros,
           beforeSend: function(objeto){
            //$("#resultados_ajax_productos").html('<img src="./img/ajax-loader.gif"> Cargando...');
            },
          success: function(datos){
          $("#resultados_ajax_productos").html(datos);
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
           }
         });
         
      });
    });
    function rucValido(ruc) {
    //11 dígitos y empieza en 10,15,16,17 o 20
    if (!(ruc >= 1e10 && ruc < 11e9
       || ruc >= 15e9 && ruc < 18e9
       || ruc >= 2e10 && ruc < 21e9))
        return false;
    
    for (var suma = -(ruc%10<2), i = 0; i<11; i++, ruc = ruc/10|0)
        suma += (ruc % 10) * (i % 7 + (i/7|0) + 1);
    return suma % 11 === 0;
    
}
  
        </script>
  
<script type="text/javascript">
    
    $('#ventas').addClass("treeview active");
    $('#nueva_notab').addClass("active");

</script>
 
</body>

</html>















