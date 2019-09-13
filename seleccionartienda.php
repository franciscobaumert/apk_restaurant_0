<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos  

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo

$modulo=$rs1["accesos"];
$sql2="select * from sucursal ORDER BY  tienda DESC ";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo

$a = explode(".", $modulo);

if($a[3]==0){
    header("location:error.php");    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>.:: Seleccionar Tienda | Casa Royales ::.</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

      <link rel="shortcut icon" href="assets/itsolution24/img/logo-favicons/nofavicon.png">

  <!-- All CSS -->


    <!-- Bootstrap CSS -->
    <link type="text/css" href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link type="text/css" href="assets/toastr/toastr.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link type="text/css" href="assets/itsolution24/css/theme.css" rel="stylesheet">

    <!-- Login CSS -->
    <link type="text/css" href="assets/itsolution24/css/login.css" rel="stylesheet">

  <!-- All JS -->

    <!-- jQuery JS  -->
    <script src="assets/jquery/jquery.min.js" type="text/javascript"></script>

    <!-- Bootstrap JS -->
    <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- Toastr JS -->
    <script src="assets/toastr/toastr.min.js" type="text/javascript"></script>

    <!-- Common JS -->
    <script src="assets/itsolution24/js/common.js"></script>

    <!-- Login JS -->
    <script src="assets/itsolution24/js/login.js"></script>

</head>
<body class="login-page">
<div class="hidden"><?php include('assets/itsolution24/img/iconmin/membership/membership.svg');?></div>

  <section class="login-box">
    <div class="login-logo">
      <div class="text">
        <p>
          <strong>
            SELECCIONE UNA TIENDA
          </strong>
        </p>
      </div>
    </div>
    <div class="login-box-body" ng-controller="StoreController">
      <ul class="list-unstyled list-group store-list">
        <?php
        $host= $_SERVER["HTTP_HOST"];
        $url= "/disponibilidad.php";
        $a="https://".$host.$url;
        ?>
        
        <?php
        basededatos();
        $db_sucursal = $db_db.'.sucursal';
        $db = conectar2();
        $consulta1 = "SELECT * FROM $db_sucursal ";
        $result1 = mysqli_query($db, $consulta1);
        while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
            $tienda=$valor1['tienda'];    

        }
        ?> 
        <?php
        for($i = 1 ;$i<=$tienda;$i++){
        ?>
          <li class="list-group-item">
            <a href="tienda.php?t=<?php echo $i;?>&a=<?php echo $a;?>">
              <div class="store-icon">
                <svg class="svg-icon"><use href="#icon-store"></svg>
              </div>
              <div class="store-name">
                TIENDA <?php echo $i;?>
                <span class="pull-right">&rarr;</span>
              </div>
            </a>
          </li>
          <?php
            }
          ?>
      </ul>
    </div>
    <div class="copyright text-center">
      <p>&copy; <a href="https://www.developer-technology.com.com">Developer Technology</a>, v3.0</p>
    </div>
  </section>

</body>
</html>