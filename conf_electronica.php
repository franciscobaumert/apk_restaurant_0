<?php
session_start();

require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Configuracion Electronica";

include('menu.php');
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$tienda=$_SESSION['tienda'];
$sql2="select * from sucursal where tienda=$tienda";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$ruc=$rs2["ruc"];

$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[30]==0){
    header("location:error.php");    
}

$mensaje=recoge1('mensaje');


?>
<?php include ("header.php"); ?>
<?php

menu1();

?>

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

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      CONFIGURACION
      <small>
        FACTURACION ELECTRONICA
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
        CONFIGURACION
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
              ACTUALIZAR DATOS
            </h3>
          </div>
          <div class="box-body">

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

<form class="form-horizontal form-label-left" method="post" id="perfil" enctype="multipart/form-data" action="conf_electronica1.php">

                          


    
                        <div class="form-group">
        <label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de fase</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select  class='form-control' id="fac_ele" name="fac_ele">
                                                                   <?php         
                                                                   if ($fac_ele==3) {
                                                                     ?>
                                                                    
                                                                    <option value="3" selected>Beta</option>
                                                                    <option value="1" >Produccion</option>
                                                                     <?php
                                                                   }         
                                                                   if ($fac_ele==1) {
                                                                     ?>
                                                                    <option value="1" selected>Produccion</option>
                                                                    <option value="3">Beta</option>
                                                                    <?php
                                                                   }         
                                                                            
                                                                    ?>
                  
                  
                </select> 
        </div>
        </div>  
                          
                           <div class="form-group">
        <label for="youtube_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Usuario Sol</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input  type="text"  class="form-control" id="usuariosol" name="usuariosol" placeholder="usuariosol" value="<?php echo $usuariosol;?>" autocomplete="off">
        </div>
        </div> 
          
                            <div class="form-group">
        <label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Clave Sol</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text"  class="form-control" id="clavesol" name="clavesol" placeholder="clavesol" value="<?php echo $clavesol;?>" autocomplete="off">
        </div>
        </div>
              
                                <input type="hidden" id="ruc" class="form-control"  name="ruc"  value="<?php echo $ruc;?>">

        <div class="form-group">
                  <label class="control-label col-md-3">Ingresar certificado digital (.pfx):</label>
                  <div class="controls col-md-9">
                    <input type="file" id="files" name="files" class="default" />
                  </div>
                </div>
                          <div class="form-group">
        <label for="linkedin_emp" class="control-label col-md-3 col-sm-3 col-xs-12">Password Certificado Digital</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input  type="text" id="valor1" class="form-control" id="clave" name="clave" placeholder="Password Certificado Digital" value="<?php echo $clave;?>" autocomplete="off">
        </div>
        </div>
              
              
                        
              <div class='col-md-12' id="resultados_ajax"></div><!-- Carga los datos ajax -->
                        
                    <div class="modal-footer">
                    
      <button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
      
                    </div>
            </div>
    
      </form>
          
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


<script>
$( "#perfil" ).submit(function( event ) {
$('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
   $.ajax({
      //type: "POST",
      //url: "conf_electronica1.php",
      //data: parametros,
       //beforeSend: function(objeto){
        //$("#resultados_ajax").html("Mensaje: Cargando...");
        //},
      //success: function(datos){
      //$("#resultados_ajax").html(datos);
      //$('#guardar_datos').html('Guardar datos');
      //$('#guardar_datos').attr("disabled", false);

      //}
  });
  //event.preventDefault();
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




