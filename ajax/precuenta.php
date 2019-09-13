<!DOCTYPE html>
<html>
<head>
    <style>
    .monto {text-align:center;}
    .monto1 {text-align:center;}
    .monto2 {text-align:center;}
    .monto4 {text-align:center;}
    .monto5 {text-align:center;}
    .totales {font-weight:bold;}
    




#invoice-item-list {
    position: relative;
    min-height: 130px;
    overflow: hidden;
    overflow-y: scroll;
}
#invoice-item-list .invoice-item {
    background-color: #f7fffb;
}
#invoice-item-list table tbody td {
    
}
#invoice-item-list table tbody td.product-quantity {
    width:40px;
    text-align:center;
}
#invoice-item-list .product-quantity button {
    width: 100%;
    line-height: 0;
    padding: 0;
    margin: 0;
}
#invoice-item-list .product-quantity button.btn-up {
    position: relative;
    color: #ffffff;
    background-color: #bef1d9;
}
#invoice-item-list .product-quantity button.btn-down {
    color: #ffffff;
    background-color: #fddeda;
    margin-bottom: 4px;
}
#invoice-item-list .invoice-item .delete-icon {
    height: 14px;
    width: 14px;
    cursor: pointer;
}
#invoice-item-list .invoice-item .product-name {
    width:500px;
}
#invoice-item-list .invoice-item .product-name span {
    display: block;
    color: #fff;
    font-size: 1.4rem;
    text-align: center;
    font-weight: 700;
    padding: 5px 10px;
    background-color: #026c3c;
    border: 2px solid #e7fff4;
    border-radius: 20px;
    box-shadow: 0 0 1px rgba(0,0,0,0.3);
}
#invoice-item-list .invoice-item .product-price {
    width: 50px;
    text-align: right;
}
#invoice-item-list .invoice-item .product-subtotal {
    width: 70px;
    text-align: right;
}
#invoice-item-list .invoice-item .product-delete {
    width: 50px;
    text-align:center;
}
/* End Invoice Item Area */

/*

----------------------------------------------
   3.03. start invoice calculation area
----------------------------------------------
*/

#invoice-calculation {
    
}
#invoice-calculation .table tbody tr.row1 {
    
}
#invoice-calculation .table tbody tr.row2 {
    
}
.pay-top td input {
    
}
/* End Invoice Calculation Area */

/*
-----------------------------------------------
    3.04. start pay button
----------------------------------------------
*/

    </style>
</head>
<?php
    
include('is_logged.php');
$session_id= session_id();
$id_factura= $_SESSION['id_factura'];
$numero_factura= $_SESSION['numero_factura'];
$id_cliente=1;
$id_vendedor=$_SESSION['user_id'];
$des=1;
$c=$_SESSION['tienda'];
$ddd=1;
$tipo=$_SESSION['doc_ventas'];
if($tipo==8){
  $ddd=0;  
}
$fecha=date('Y-m-d');
$fecha1=date("Y-m-d", strtotime($fecha) );
$hora=date('H:m:s');
$date_added=$fecha1." ".$hora;
$costo=1;
$d=1;
$moneda1=1;

if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=intval($_POST['cantidad']);}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}
if (isset($_POST['stock'])){$stock=$_POST['stock'];}
require_once ("../config/db.php");
require_once ("../config/conexion.php");   
if (!empty($id) and !empty($cantidad) and !empty($precio_venta) and ($cantidad>0) and ($precio_venta>0) and ($cantidad<=$stock))
{

$sql1=mysqli_query($con, "select * from facturas where id_factura='".$id_factura."'");
$row1=mysqli_fetch_array($sql1);
$folio=$row1["folio"];

$insert_tmp=mysqli_query($con, "INSERT INTO detalle_factura VALUES (NULL,'$id_cliente','$id_vendedor','$numero_factura','$des','$id','$cantidad','$precio_venta','$c','$ddd','1','$date_added','$costo','$tipo','$d','$moneda1','$folio')");
}
if (isset($_GET['id']))
{
$id_detalle=intval($_GET['id']);    
$delete=mysqli_query($con, "DELETE FROM detalle_factura WHERE id_detalle='".$id_detalle."'");
}
?>

<table class="table table-hovered" style="position: relative;
    vertical-align: middle;
    padding: 0 3px;">

<?php
    $sumador_total=0;
    $sql=mysqli_query($con, "select * from products, facturas, detalle_factura where facturas.numero_factura=detalle_factura.numero_factura and facturas.id_factura='$id_factura' and products.id_producto=detalle_factura.id_producto");
    while ($row=mysqli_fetch_array($sql))
    {
    $id_detalle=$row["id_detalle"];
    $codigo_producto=$row['codigo_producto'];
    $cantidad=$row['cantidad'];
    $nombre_producto=$row['nombre_producto'];
    
    $precio_venta=$row['precio_venta'];
    $precio_venta_f=number_format($precio_venta,2);//Formateo variables
    $precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
    $precio_total=$precio_venta_r*$cantidad;
    $precio_total_f=number_format($precio_total,2);//Precio total formateado
    $precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
    $sumador_total+=$precio_total_r;//Sumador
    
        ?>

        <tr class="invoice-item">
            <td class='text-center hidden' style="background:white;"><?php echo $codigo_producto;?></td>
            <td class='product-quantity'>
                <button type="button" class="btn btn-xs btn-up" ng-click="addItemToInvoice(items.id)" title="Increase">
                    
                </button>
                <input readonly id="cantidad-<?php echo $id_detalle;?>" name="cantidad-<?php echo $id_detalle;?>" class="monto input item_quantity text-center" type="text"  value="<?php echo $cantidad;?>" style="max-width:40px;border-radius: 20px;border:2px solid #ddd;">
                <button type="button" class="btn btn-xs btn-down increasebtn{{ items.id }}" ng-click="DecreaseItemFromInvoice(items.id)" title="Decrease">
                    
                </button>
            </td>
            <td class="product-name"><span><?php echo $nombre_producto;?></span></td>
            <?php $sql1="select * from users where user_id=$_SESSION[user_id]";
                  $rw1=mysqli_query($con,$sql1);//recuperando el registro
                  $rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
                  $modulo=$rs1["accesos"];
                  $a = explode(".", $modulo); 
            ?>
            <td class='product-price'><input <?php if($a[42]==0){ ?> readonly <?php } ?> id="precio_venta-<?php echo $id_detalle;?>" name="precio_venta-<?php echo $id_detalle;?>" class="monto input text-center item_price" type="text" value="<?php echo $precio_venta_f;?>" style="max-width:80px;border-radius: 20px;border:2px solid #ddd;"></td>
                        <td class='product-subtotal'><input class="monto total" type="text" readonly value="<?php echo $precio_total_f;?>" style="max-width:80px;border-radius: 20px;border:2px solid #ddd;"></td>
            <td class='product-delete text-red'></td>
        </tr>     
        <?php }

    $subtotal=number_format($sumador_total,2,'.','');

    ?>
    
       <div id="invoice-calculation " class="clearfix" >
    
        <tbody style="position: relative;
    font-weight: 700;
    text-align: right;
    text-transform: uppercase;
    border-top: 2px solid #00A65B;">
            <?php
    
    
    
    
    $total_factura=$subtotal/1.19;
        $total_iva=$total_factura*0.19;

        if ($_SESSION['doc_ventas']==1) {   
?>  
            <tr class="row1" style="background-color: #f4f4f4;">
                <td width="30%">
                    OP-GRAV
                </td>
                <td class="text-right" width="20%">
                    <input readonly type="text" class="monto4" value="<?php echo number_format(ceil($total_factura));?>" style="max-width:80px;border-radius: 20px;border:2px solid #ddd;">
                </td>
                <td width="30%">
                    IVA (<?php echo 19?>)%
                </td>
                <td class="text-right" width="20%">
                    <input readonly type="text" class="monto5" value="<?php echo number_format(ceil($total_iva));?>" style="max-width:80px;border-radius: 20px;border:2px solid #ddd;">
                </td>
            </tr>
            <tr class="row2 pay-top" style="background-color: #ffeed2;">
                <td colspan="3">
                    EXCENTA
                </td>
                <td>
                    <input readonly type="text" class="monto1" value="<?php echo number_format(0,2);?>" style="max-width:80px;border-radius: 20px;border:2px solid #ddd; width: 100%;
    text-align: center;
    font-size: 16px;">
                </td>
            </tr>
            
            <?php
        }
?>

            <tr class="row3">
                <td colspan="3">
                    Importe a pagar
                </td>
                <td class="text-right">
                    <input readonly class="monto totales" type="text" value="<?php echo number_format($subtotal,2);?>" style="max-width:80px;border-radius: 20px;border:2px solid #ddd;">
                </td>
            </tr>


        </tbody>
    
</div>
</table>
</body>
</html>
<script>
// generamos un evento click y keyup para cada elemento input con la clase .input
var input=document.querySelectorAll(".input");
input.forEach(function(e) {
    e.addEventListener("click",multiplica);
    e.addEventListener("keyup",multiplica);
});
 
// funcion que genera la multiplicacion
function multiplica() {
 
    // nos posicionamos en el tr del producto
    var tr=this.closest("tr");
 
    var total=1;
 
    // recorremos todos los elementos del tr que tienen la clase .input
    var inputs=tr.querySelectorAll(".input");
    inputs.forEach(function(e) {
        total*=e.value;
        
    });
 
    // mostramos el total con dos decimales
    tr.querySelector(".total").value=total.toFixed(2);
 
    // indicamos que calcule el total
    calcularTotal(this.closest("table"));
}
 
// funcion que calcula la suma total de los productos
function calcularTotal(e) {
    var total=0;
    var total1=0;
    var total2=0;
    // obtenemos todos los totales y los sumamos
    var totales=e.querySelectorAll(".total");
    totales.forEach(function(e) {
        total+=parseFloat(e.value);
    });
    total1=total/1.18;
    total2=total1*0.18;
    // mostramos la suma total con dos decimales
    e.getElementsByClassName("totales")[0].value=total.toFixed(2);
    e.getElementsByClassName("monto1")[0].value=total1.toFixed(2);
     e.getElementsByClassName("monto2")[0].value=total2.toFixed(2);
}
</script>


<script type="text/javascript">

$(document).ready(function(){

    $('input').blur(function(){

        var field = $(this);

        //field.css('background-color','#D0F5A9');

        var dataString = 'value='+$(this).val()+'&field='+$(this).attr('name');

        $.ajax({

            type: "POST",

            url: "ajax/edit2.php",

            data: dataString,

        });

    });

});

</script>
