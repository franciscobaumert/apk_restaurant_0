<?php
session_start();
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
include('menu.php');
$producto=$_POST['producto'];
$consulta1 = "SELECT * FROM products ";
$result1 = mysqli_query($con, $consulta1);
while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    if($valor1['nombre_producto']==$producto){
        $a1=$valor1['id_producto'];
    
    }
}
$a2=recoge1('fecha1');
$a3=recoge1('fecha2');
$a4=recoge1('tienda');
$a5="";
$a6=$producto;
$delete=mysqli_query($con,"DELETE FROM consultas");
$insert=mysqli_query($con,"INSERT INTO consultas VALUES ('','20','$a1','$a2','$a3','$a4','$a5','$a6')");
header("location:kardex.php");
?>