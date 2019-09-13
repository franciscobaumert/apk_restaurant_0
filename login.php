<?php


// include the configs / constants for the database connection
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
   
   
   include('menu.php');
  
   $sql1="select * from users where user_id=$_SESSION[user_id]";
    $rw1= mysqli_query($con, $sql1);//recuperando el registro
    $rs1= mysqli_fetch_array($rw1);
    $modulo=$rs1["accesos"];
    $b = explode(".", $modulo);
   $c=0;
  if($b[48]==1){
        $_SESSION['tienda']=6; 
        $c=1;
        } 
  if($b[47]==1){
        $_SESSION['tienda']=5; 
        $c=1;
        } 
  if($b[46]==1){
        $_SESSION['tienda']=4; 
        $c=1;
        }
        
  if($b[45]==1){
        $_SESSION['tienda']=3; 
        $c=1;
        }
  if($b[44]==1){
        $_SESSION['tienda']=2;
        $c=1;
        }
        
   if($b[43]==1){
        $_SESSION['tienda']=1;  
        $c=1;
        }
        
       
   if($c>0){
     $_SESSION['doc_ventas']=1;
     
     
     $_SESSION['tipo']=0;
     $_SESSION['tabla']=1;
     $_SESSION['servicio1']="0";
       header("location: disponibilidad.php");   
   }else{
     header("location: login.php");   
   }
   
    
    

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>.:: Acceder | Apk Restaurant ::.</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!--Set Favicon-->
      <link rel="shortcut icon" href="assets/itsolution24/img/logo-favicons/nofavicon.png">

  <!-- All CSS -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link type="text/css" href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Toastr CSS-->
    <link type="text/css" href="assets/toastr/toastr.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link type="text/css" href="assets/itsolution24/css/theme.css" rel="stylesheet">

    <!-- Login CSS -->
    <link type="text/css" href="assets/itsolution24/css/login.css" rel="stylesheet">

  <!-- JS -->

    <!-- jQuery JS -->
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
        <p><strong> - Apk Restaurant - </strong></p>
      </div>
    </div>
    <div id="error">
    <?php
    // show potential errors / feedback (from login object)
    if (isset($login)) {
      if ($login->errors) {
        ?>
        <script>
          toastr.options = {
          "closeButton":false,
          "progressBar": false
        };
        toastr.warning("<?php 
        foreach ($login->errors as $error) {
          echo $error;
        }
        ?>","Precaucion");
        </script>
        <?php
      }
      if ($login->messages) {
        ?>
        <script>
          toastr.options = {
          "closeButton":false,
          "progressBar": false
        };
        toastr.warning("<?php
        foreach ($login->messages as $message) {
          echo $message;
        }
        ?>","Precaucion");
        </script>
        <?php 
      }
    }
    ?>
          <!-- error will be shown here ! -->
    </div>
    <div class="login-box-body" ng-controller="LoginController">
      <p class="login-box-msg">
        <strong>LOGIN DE ACCESO</strong>
      </p>
      <form id="loginform" method="post" action="" name="loginform" accept-charset="utf-8" autocomplete="off" role="form">       

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon input-sm">
              <svg class="svg-icon"><use href="#icon-avatar"></svg>
            </div>
            <input type="text" class="form-control" placeholder="USUARIO" name="user_name" onKeyUp="this.value=this.value.toUpperCase();" required="" aria-required="true" value="ADMIN">
          </div>
        </div>

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon input-sm">
              <svg class="svg-icon"><use href="#icon-password"></svg>
            </div>
            <input type="password" class="form-control" placeholder="CLAVE" name="user_password" onKeyUp="this.value=this.value.toUpperCase();" required="" aria-required="true" value="PASSWORD">
          </div>
        </div>

        <button name="login" type="submit" id="login" class="btn btn-success btn-block btn-flat" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión">
          <i class="fa fa-fw fa-sign-in"></i> 
          ACCEDER
        </button>
      </form>

    </div>
    <div class="copyright text-center">
      <p>&copy; <a href="https://www.miempresaonline.cl" target="_blank">Miempresaonline</a></p>
    </div>
  </section>

<script type="text/javascript" src="assets/script/validation.min.js"></script>

<script>

$('document').ready(function() {

    /*set_salas_mesas($('#salas-mesas'));
    setTimeout(function run() {
        set_salas_mesas($('#salas-mesas'));
        setTimeout(run, 2000);
    }, 2000);*/
               
   $("#loginform").validate({
      rules:
    {
      user_name: { required: true, },
      user_password: { required: true, },
     },
       messages:
     {
        user_name:{  required: "Por favor ingrese su Usuario de Acceso" },
      user_password:{  required: "Por favor ingrese su Clave de Acceso" },
       },
     submitHandler: submitForm  
       });  
     /* validation */
     
     /* login submit */
     function submitForm()
     {  
      var data = $("#loginform").serialize();
        
      $.ajax({
        
      type : 'POST',
      url  : 'login.php',
      data : data,
      beforeSend: function()
      { 
        //$("#error").fadeOut();
        $("#login").html('<i class="fa fa-refresh"></i> Verificando...');
        $('#login').attr("disabled", true);
      },
      success :  function(response)
         {
                  
            $("#login").html('ACCEDER');
            $('#login').attr("disabled", true);
            setTimeout(' window.location.href = "disponibilidad.php"; ',2000);
          
        }
      });
        //return false;
        event.preventDefault();
    }
     /* login submit */
});

</script>

</body>
</html>
<?php } ?>