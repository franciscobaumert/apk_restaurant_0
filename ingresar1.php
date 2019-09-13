<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
$id=recoge1('id');
$sql2="select * from servicio where id_servicio=$id";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo   
$des_ser=$rs2["des_ser"];
$pre_ser=$rs2["pre_ser"];
$id1=$rs2["id_servicio"];
$detalle=$rs2["detalle"];
$aceptar_guia=$rs2["aceptar_guia"];
$r1="";
if($aceptar_guia==2){
    $r1="readonly";
}
$diagnostico=recoge1("diagnostico");
$mensaje=recoge1("mensaje");
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
if($diagnostico<>""){
    $dml="update servicio set des_ser='".$diagnostico."' where id_servicio=$id";
    if(!mysqli_query($con,$dml)){
       die("No se pudo actualizar..");
    }else{
       header("location:ingresar1.php?id=$id&mensaje=Diagnostico enviado");
    }  
    $dml="update detalle_factura set id_producto='".$diagnostico."' where id_detalle=$detalle";
       if(!mysqli_query($con,$dml)){
            die("No se pudo actualizar..");
        }else{
            header("location:ingresar1.php?id=$id&mensaje=Diagnostico enviado");
        }  
 }
   


    
    
 
  
    
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 

if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

        if($a[18]==0){
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
<h1>Editar diagnostico</h1>
<form id="myform" action="ingresar1.php" method="POST">
    Diagnostico:<textarea  rows="3" name="diagnostico" required><?php echo $des_ser;?></textarea>
    
    <input type="hidden" value="<?php echo $id1;?>" name="id">
    <input type="submit" id="enviar" name="enviar">
    
</form>
<?php
 if($mensaje<>""){
    print"Diagnostico cambiado";
}
?>