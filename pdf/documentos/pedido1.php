<?php
session_start();
//http://contenido.app.sunat.gob.pe/insc/ComprobantesDePago/GuiasManualesJul_2012/Manual+de+autorizacion.pdf
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
include("../../config/db.php");
include("../../config/conexion.php");
include("funciones.php");
require "phpqrcode/qrlib.php";
//$session_id= session_id();
$id_factura= $_SESSION['id_factura'];
$tienda2=$_SESSION['tienda'];
$doc1=$_GET['doc1'];
$tip_doc=intval($_GET['tip_doc']);
$tip=intval($_GET['tip']);
$sql_count=mysqli_query($con,"select * from products, facturas, detalle_factura where facturas.numero_factura=detalle_factura.numero_factura and facturas.id_factura='$id_factura' and products.id_producto=detalle_factura.id_producto");
$count=mysqli_num_rows($sql_count);
if ($count==0)
{
    echo "<script>alert('No hay productos agregados a la factura');event.preventDefault();</script>";
    echo "<script>event.preventDefault();</script>";
    exit;
}

require_once(dirname(__FILE__).'/../html2pdf.class.php');
$nombre_cliente1=mysqli_real_escape_string($con,(strip_tags($_GET["nombre_cliente"],ENT_QUOTES)));;
$direccion=$_GET['direccion'];        
if($tip_doc==1){
    $dni=str_pad($doc1, 8, "0", STR_PAD_LEFT);
    $doc=0;
    $ce=0;
    $documento=$dni;
}elseif ($tip_doc==6){
    $dni=0;
    $ce=0;
    $doc=$doc1;
    $documento=$doc;
}elseif ($tip_doc==4) {
    $dni=0;
    $doc=0;
    $ce=$doc1;
    $documento=$ce;
}
$tienda1=$_SESSION['tienda'];

$sql_empresa=mysqli_query($con,"select * from datosempresa where id_emp=1");
$rw_empresa=mysqli_fetch_array($sql_empresa);
$fac_ele=$rw_empresa['fac_ele'];
$clave=$rw_empresa['clave'];
$tel1=$_GET['tel1'];
$mail=$_GET['mail'];
$des=$_GET['des'];
//CREAR CLIENTE NUEVO O EDITAR CLIENTE SI EXISTE  

    $accion3=mysqli_query($con, "select * from clientes where (doc='$doc1' or dni='$doc1') ");
    $row3=mysqli_fetch_array($accion3);
    $id_cliente=$row3["id_cliente"];
    if($id_cliente>0){
        $cambio1=mysqli_query($con, "UPDATE clientes SET email_cliente='$mail',direccion_cliente='$direccion',telefono_cliente='$tel1',nombre_cliente='$nombre_cliente1' WHERE id_cliente=$id_cliente");
    }
    if($id_cliente==""){
        $sql="INSERT INTO clientes (nombre_cliente, telefono_cliente, email_cliente, direccion_cliente, status_cliente, date_added,doc,dni,vendedor,pais,departamento,provincia,distrito,cuenta,tipo1,tienda,users,deuda,debe,documento) VALUES ('$nombre_cliente1','$tel1','$mail','$direccion','1','','$doc','$dni','$ce','','Peru','','','','','1','$tienda1','0','0','0','$documento')";
        $query_new_insert = mysqli_query($con,$sql);
    if ($query_new_insert){
            echo "Cliente ha sido ingresado satisfactoriamente.";
        }else{
            echo "Error.";
        }
        $accion2=mysqli_query($con, "select * from clientes where tipo1=1 ORDER BY  `clientes`.`id_cliente` DESC LIMIT 0 , 1");
        $row1=mysqli_fetch_array($accion2);
        $id_cliente=$row1["id_cliente"];
    }


//}
$id_vendedor=$_SESSION['user_id'];
$fecha=$_GET['fecha'];
$dolar=$_GET['tcp'];
$folio=$_GET['folio'];
$motivo=$_GET['motivo'];
$observaciones=$_GET['observaciones'];
$nro_doc=$_GET['nro_doc'];
$id_mesa=$_GET['id_mesa'];
$id_detalle=$_GET['id_detalle'];
$razon_comercial="Computadoras";
$hora=$_GET['hora'];
$moneda=intval($_GET['moneda']);
$moneda1=1;
$dias=intval($_GET['dias']);
$condiciones=mysqli_real_escape_string($con,(strip_tags($_REQUEST['condiciones'], ENT_QUOTES)));
$sql=mysqli_query($con, "select LAST_INSERT_ID(numero_factura) as last from facturas order by id_factura desc limit 0,1 ");
$rw=mysqli_fetch_array($sql);
$numero_factura=intval($_GET['factura']);
date_default_timezone_set('America/Santiago');
$sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
$rw_cliente=mysqli_fetch_array($sql_cliente);
$ruc=$rw_cliente["doc"];
$dni=$rw_cliente["dni"];
$ce=$rw_cliente["ce"];
$nombre_cliente=$rw_cliente["nombre_cliente"];                     
$nums=1;
$sumador_total=0;
$servicio=0;
$suma=0;
$tipo=$_SESSION['doc_ventas'];
$ddd=1;
if($tipo==8){
  $ddd=0;  
}

$producto1="";
$cantidad1=array();
$und_pro=array();
$tipo_cantidad=array();
$precio_unitario=array();
$valor_unitario=array();
$total_producto=array();
$total_igv=array();
$producto=array();
$codigo=array();
$sql=mysqli_query($con, "select * from products, facturas, detalle_factura where facturas.numero_factura=detalle_factura.numero_factura and facturas.id_factura='$id_factura' and products.id_producto=detalle_factura.id_producto");
//COPIAR LOS PRODUCTOS
while ($row=mysqli_fetch_array($sql))
    {
    $id_tmp=$row["id_tmp"];
    $id_producto=$row["id_producto"];
    $cantidad=$row['cantidad_tmp'];
        $codigo_producto="SER";
    $nombre_producto=$row['id_producto'];   
    $precio_venta=$row['precio_tmp'];
        $servicio=1;
    $precio_venta_f=number_format($precio_venta,2);//Formateo variables
    $precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
    $precio_total=$precio_venta_r*$cantidad;
    $precio_total_f=number_format($precio_total,2);//Precio total formateado
    $precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
    $sumador_total+=$precio_total_r;//Sumador
        $suma=$suma+1;
        $fecha1=date("Y-m-d", strtotime($fecha) );
        $medida="NIU";//medida del producto en unidades
        $date_added=$fecha1." ".$hora;
        $tienda2=$_SESSION['tienda'];
        $c=$tienda2;
        $d=0;
        $und_pro1="ZZ";
        $costo=0;
        if($id_producto>0){
            $sql3=mysqli_query($con, "select * from products,und where products.und_pro=und.id_und and products.id_producto='".$id_producto."'");
            $row3=mysqli_fetch_array($sql3);
            $b="b$tienda2";
            $d=$row3["b$tienda2"];
            $codigo_producto=$row3['codigo_producto'];
            $nombre_producto=$row3['nombre_producto'];
            $und_pro1=$row3['xml_und'];
            $costo=$row3["costo_producto"];
        } 
        $igv=0.18;
        $cantidad1[$nums]=$cantidad;
        $und_pro[$nums]=$und_pro1;
        $tipo_cantidad[$nums]=$medida;
        $precio_unitario[$nums]=$precio_venta;
        $a=1.18;
        $valor_unitario[$nums]=round($precio_venta/$a,2);
        $total_producto[$nums]=round($valor_unitario[$nums]*$cantidad,2);
        $total_igv[$nums]=round($igv*$total_producto[$nums],2);
        $producto[$nums]=$nombre_producto;
        $codigo[$nums]=$codigo_producto;
        
       

       


        //ACTUALIZAR STOCK PARA FACTURAS/BOLETA/NOTA DE CREDITO       
        if($id_producto>0){
            if($des==1){
                $productos1=mysqli_query($con, "UPDATE products SET $b=$b-$cantidad,precio_producto=$precio_venta_r WHERE id_producto=$id_producto and pro_ser=1");
            }
            if($des==2){
                $productos1=mysqli_query($con, "UPDATE products SET $b=$b+$cantidad,precio_producto=$precio_venta_r WHERE id_producto=$id_producto and pro_ser=1");
            }
        }
        $nums++;
    //fin
        }
$subtotal=number_format($sumador_total,2,'.','');
$total_iva=($subtotal * 18 )/100;
$total_iva=number_format($total_iva,2,'.','');
$total_factura=$subtotal-$total_iva;

if($condiciones==4){
    $deuda=$sumador_total;
}else{
    $deuda=0;
}
$fecha1=date("Y-m-d", strtotime($fecha) );
$date=$fecha1." ".$hora;
$condiciones1="";

$t1=$_SESSION['tienda'];
$cuenta="";
$tienda="tienda".$c;
$status_mesa=1;

$id_factura=$_SESSION['id_factura'];

$mesa1=mysqli_query($con, "UPDATE mesas SET status_mesa=$status_mesa WHERE id_mesa=$id_mesa");
//$documento=mysqli_query($con, "UPDATE documento SET $tienda=$tienda+1 WHERE id_documento=$tipo");
$dolar1=mysqli_query($con, "UPDATE datosempresa SET dolar=$dolar WHERE id_emp=1");
$deuda1=mysqli_query($con, "UPDATE clientes SET deuda=deuda+$deuda WHERE id_cliente=$id_cliente");
$insert=mysqli_query($con,"UPDATE facturas SET numero_factura='$numero_factura',fecha_factura='$date',cod_hash='0',doc_mod='$nro_doc',id_cliente='$id_cliente',baja='0',id_vendedor='$id_vendedor',condiciones='$condiciones',total_venta='$sumador_total',deuda_total='$deuda',estado_factura='$tipo',tienda='$c',ven_com='1',activo='$ddd',servicio='1',moneda='$moneda1',nombre='$des',obs='',cuenta1='0',fec_eli='2018-11-11',dias='$dias',folio='$folio',des='$des',aceptado='',resumen='0',motivo='$motivo',tipo='$tip',id_mesa='$id_mesa',is_applied='0',observaciones='$observaciones' WHERE id_factura='".$id_factura."'");
//$delete=mysqli_query($con,"DELETE FROM tmp WHERE session_id='".$session_id."'");


$accion1=mysqli_query($con, "select * from facturas where numero_factura='".$numero_factura."' and folio='".$folio."' and estado_factura='".$tipo."' and tienda=$t1");
$row1=mysqli_fetch_array($accion1);
$id_factura=$row1["id_factura"];



//FIN DE CREACION DE DOCUMENTO XML FACTURAS Y BOLETAS
//DIRECCION DE PDF
header("location:ver_comanda.php?id_factura=$id_factura");
?>