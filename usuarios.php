<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Usuarios";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo

$sql2="select * from sucursal ORDER BY  `sucursal`.`tienda` DESC ";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$tienda1=$rs2["tienda"];  

$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}	
if($a[4]==0){
    header("location:error.php");    
}	
?>
<?php include ("header.php"); ?>
<?php

menu1();

?>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      USUARIOS
      <small>
        LISTADO GENERAL
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
        USUARIOS
      </li>
    </ol>
  </section>
  <!-- ContentH eader End -->
<section class="content">

<div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <div class="btn-group pull-right">
              <button type='button' class="btn btn-info" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus" ></span> Nuevo Usuario</button>
            </div>
            <h3 class="box-title">
              LISTA DE USUARIOS
            </h3>
          </div>
          <div class="box-body">
            <?php
            include("modal/registro_usuarios.php");
            include("modal/editar_usuarios.php");
            include("modal/cambiar_password.php");
            ?>
            <span id="loader"></span>
            <div id="resultados"></div>
            <div class='outer_div'></div>
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


<script type="text/javascript" src="js/usuarios.js"></script>
<script>


$( "#guardar_usuario" ).submit(function( event ) {
$('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_usuario.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax").html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
      $('#guardar_datos').html('Guardar datos')
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_usuario" ).submit(function( event ) {
$('#actualizar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_usuario.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax2").html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
      $('#actualizar_datos').html('Actualizar datos');
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_password" ).submit(function( event ) {
$('#actualizar_datos3').html('<i class="fa fa-refresh"></i> Verificando...');
$('#actualizar_datos3').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_password.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax3").html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
			success: function(datos){
			$("#resultados_ajax3").html(datos);
      $('#actualizar_datos3').html('Cambiar contraseña');
			$('#actualizar_datos3').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})
	function get_user_id(id){
		$("#user_id_mod").val(id);
	}

	function obtener_datos(id){
			var nombres = $("#nombres"+id).val();
			var apellidos = $("#apellidos"+id).val();
			var usuario = $("#usuario"+id).val();
                        var email = $("#email"+id).val();
                        var dni = $("#dni"+id).val();
                        var dom = $("#dom"+id).val();
                        var tel = $("#tel"+id).val();
                        var hora = $("#hora"+id).val();
                        var sucursal = $("#sucursal"+id).val();
                	$("#mod_id").val(id);
			$("#firstname2").val(nombres);
			$("#lastname2").val(apellidos);
			$("#user_name2").val(usuario);
			$("#user_email2").val(email);
                         $("#mod_dni").val(dni);
                        $("#dom").val(dom);
                        $("#tel").val(tel);
                        $("#hora").val(hora);
                        $("#mod_sucursal").val(sucursal);
		}
</script>

</body>
</html>