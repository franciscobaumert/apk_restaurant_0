<?php
session_start();

require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Empresa";

include('menu.php');
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[0]==0){
    header("location:error.php");    
}

$mensaje=recoge1('mensaje');

?>


<?php include ("header.php"); ?>
<?php

menu1();

?>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      EMPRESA
      <small>
        CONFIGURACION GENERAL
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
        EMPRESA
      </li>
    </ol>
  </section>
  <!-- ContentH eader End -->
<section class="content">

<?php
    if($mensaje<>"")
    {
    ?>
<script>
  toastr.options = {
  "closeButton":false,
  "progressBar": false
};
toastr.success("<?php echo $mensaje;?>","Exito");
</script>
   <?php 
}
?>

<div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">
              DATOS DE LA EMPRESA
            </h3>
          </div>
          <div class="box-body">
<?php
$sql1="SELECT * FROM datosempresa WHERE id_emp=1";
$rw1=mysqli_query($con,$sql1);
while ($valor1 = mysqli_fetch_array($rw1)) {

    $nom_emp=$valor1['nom_emp'];
    $des_emp=$valor1['des_emp'];
    $mis_emp=$valor1['mis_emp'];
    $vis_emp=$valor1['vis_emp'];
    $dir_emp=$valor1['dir_emp'];
    $tel_emp=$valor1['tel_emp'];
    $email_emp=$valor1['email_emp'];
    $face_emp=$valor1['face_emp'];
    $tiwter_emp=$valor1['tiwter_emp'];
    $youtube_emp=$valor1['youtube_emp'];
    $linkedin_emp=$valor1['linkedin_emp'];
    $comentario1=$valor1['comentario1'];
    $comentario2=$valor1['comentario2'];
    $comentario3=$valor1['comentario3'];
    $comentario4=$valor1['comentario4'];
    $comentario5=$valor1['comentario5'];
    $fac_ele=$valor1['fac_ele'];
    $usuariosol=$valor1['usuariosol'];
    $clavesol=$valor1['clavesol'];
    $clave=$valor1['clave'];
}
?>

<!--<?php
//print"<form class=\"form-horizontal form-label-left\" id=\"guardar_producto\"  action=\"empresa1.php\" method=\"POST\">";

?>-->

<form class="form-horizontal form-label-left" method="post" id="perfil">
                        <!--<div class="panel panel-info">
                            <div class="panel-heading">
       
                                <h2>Cambiar datos de la empresa:</h2>
                            </div>        
                            </div>-->
 
                                
                           <div class="form-group">
        <label for="nom_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre de la empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12" >
                                    <input type="text" class="form-control" id="nom_emp" name="nom_emp" placeholder="Nombre de la empresa" required value="<?php echo $nom_emp;?>" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off">
        </div>
        </div>     
                                
                              <div class="form-group">
        <label for="des_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Descripcion de la empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" class="form-control" id="des_emp" name="des_emp" placeholder="Descripcion de la empresa" value="<?php echo $des_emp;?>" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off">
        </div>
        </div> 
                    
                         <div class="form-group hidden">
        <label for="mis_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Mision de la Empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text"  onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="mis_emp" name="mis_emp" placeholder="Mision de la Empresa" value="<?php echo $mis_emp;?>">
        </div>
        </div> 
                  
                        
                       <div class="form-group hidden">
        <label for="vis_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Visión de la Empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="vis_emp" name="vis_emp" placeholder="Visión de la Empresa" value="<?php echo $vis_emp;?>">
        </div>
        </div> 
          
          
                        <div class="form-group">
        <label for="dir_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Dirección de la Empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="dir_emp" name="dir_emp" placeholder="Dirección de la Empresa" value="<?php echo $dir_emp;?>">
        </div>
        </div> 
          
                        <div class="form-group">
        <label for="tel_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Telefonos de la Empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="tel_emp" name="tel_emp" placeholder="Dirección de la Empresa" value="<?php echo $tel_emp;?>">
        </div>
        </div> 
   
          
                        <div class="form-group">
        <label for="email_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Email de la Empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="email_emp" name="email_emp" placeholder="Email de la Empresa" value="<?php echo $email_emp;?>">
        </div>
        </div> 
          
                          <div class="form-group hidden">
        <label for="face_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Facebook de la Empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="face_emp" name="face_emp" placeholder="Facebook de la Empresa" value="<?php echo $face_emp;?>">
        </div>
        </div> 
          
                            <div class="form-group hidden">
        <label for="tiwter_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Twitter de la Empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="tiwter_emp" name="tiwter_emp" placeholder="Twitter de la Empresa" value="<?php echo $tiwter_emp;?>">
        </div>
        </div> 
                          <div class="form-group hidden">
        <label for="youtube_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Youtube de la Empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="youtube_emp" name="youtube_emp" placeholder="Youtube de la Empresa" value="<?php echo $youtube_emp;?>">
        </div>
        </div> 
          
                            <div class="form-group hidden">
        <label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Linkedin de la Empresa</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="linkedin_emp" name="linkedin_emp" placeholder="Linkedin de la Empresa" value="<?php echo $linkedin_emp;?>">
        </div>
        </div> 
                        
              
                        <!--<div class="panel panel-info">
                            <div class="panel-heading">
       
                            <h2>Otros datos de la web:</h2>
                            </div>        
                        </div>-->
              <div class="hidden">
                        <div class="form-group">
        <label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Comentario Slider1</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="comentario1" name="comentario1" placeholder="Comentario Slider1"><?php echo $comentario1;?></textarea>
        </div>
        </div>   
                        <div class="form-group">
        <label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Comentario Slider2</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="comentario2" name="comentario2" placeholder="Comentario Slider2"><?php echo $comentario2;?></textarea>
        </div>
        </div> 
              
                         <div class="form-group">
        <label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Comentario Slider3</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="comentario3" name="comentario3" placeholder="Comentario Slider3"><?php echo $comentario3;?></textarea>
        </div>
        </div>
              
                         <div class="form-group">
        <label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Comentario Slider4</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="comentario4" name="comentario4" placeholder="Comentario Slider4"><?php echo $comentario4;?></textarea>
        </div>
      </div>
                        <div class="form-group">
        <label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Comentario Slider5</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" class="form-control" id="comentario5" name="comentario5" placeholder="Comentario Slider5"><?php echo $comentario5;?></textarea>
        </div>
      </div>

      <div class='col-md-12' id="resultados_ajax"></div><!-- Carga los datos ajax -->
    </div>
      
      <div class="modal-footer">
                    
                     
                            <button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
      
                       
                    </div>
                    
      
                    
            
    
      </form>
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

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>

<script>
$( "#perfil" ).submit(function( event ) {
$('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/editar_perfil.php",
      data: parametros,
       beforeSend: function(objeto){
        //$("#resultados_ajax").html("Mensaje: Cargando...");
        },
      success: function(datos){
      $("#resultados_ajax").html(datos);
      $('#guardar_datos').html('Guardar datos');
      $('#guardar_datos').attr("disabled", false);

      }
  });
  event.preventDefault();
})





    
</script>

  <script>
    $(document).ready(function() {
      $('input.tableflat').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
      });
    });

    var asInitVals = new Array();
    $(document).ready(function() {
      var oTable = $('#example').dataTable({
        "oLanguage": {
          "sSearch": "Search all columns:"
        },
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
          } //disables sorting for column one
        ],
        'iDisplayLength': 12,
        "sPaginationType": "full_numbers",
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
          "sSwfPath": "js/datatables/tools/swf/copy_csv_xls_pdf.swf"
        }
      });
      $("tfoot input").keyup(function() {
        /* Filter on the column based on the index of this element's parent <th> */
        oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
      });
      $("tfoot input").each(function(i) {
        asInitVals[i] = this.value;
      });
      $("tfoot input").focus(function() {
        if (this.className == "search_init") {
          this.className = "";
          this.value = "";
        }
      });
      $("tfoot input").blur(function(i) {
        if (this.value == "") {
          this.className = "search_init";
          this.value = asInitVals[$("tfoot input").index(this)];
        }
      });
    });
  </script>
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  
  
  <script src="js/select/select2.full.js"></script>
  <!-- form validation -->
  
  <script>
    $(document).ready(function() {
      $(".select2_single").select2({
        placeholder: "Seleccionar",
        allowClear: true
      });
      $(".select2_group").select2({});
      $(".select2_multiple").select2({
        maximumSelectionLength: 4,
        placeholder: "Con Max Selección límite de 4",
        allowClear: true
      });
    });
  </script>
  
  
  
</body>

</html>




