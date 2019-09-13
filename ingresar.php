<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
$id=recoge1('id');
$costo1=recoge1("costo");
$mensaje=recoge1("mensaje");
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
if($costo1>0){
    $dml="update detalle_factura set precio_compra='".$costo1."' where id_detalle=$id";
    if(!mysqli_query($con,$dml)){
        die("No se pudo actualizar..");
    }else{
        header("location:ingresar.php?id=$id&mensaje=Costo Enviado");
    }  
}
$sql2="select * from detalle_factura where id_detalle=$id";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo   
$costo=$rs2["precio_compra"];
$id1=$rs2["id_detalle"];   
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($_SESSION['user_id']!=1){
    header("location:error.php");    
}


?>
<script>
$(document).ready(function() {
  $("#enviar").click() {
    var ok = confirm("Seguro que quieres enviar los datos?");
   if (ok) { $("#myform").submit(); }
  }
});

</script>
<h1>Ingresar Costo</h1>
<form id="myform" action="ingresar.php" method="POST">
    Costo:<input type="text" value="<?php echo $costo;?>"  name="costo" required>
    <input type="hidden" value="<?php echo $id1;?>" name="id">
    <input type="submit" id="enviar" name="enviar">
    
</form>
<?php
 if($mensaje<>""){
    print"Costo enviado";
}
?>