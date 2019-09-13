<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Foto de Producto";

$disabled1="";
$disabled2="";
$disabled3="";
$disabled4="";
$consulta1 = "SELECT * FROM products ";
$result1 = mysqli_query($con, $consulta1);
$id_producto=$_SESSION['id_producto'];
while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    if ($valor1['id_producto']==$id_producto){
    $producto=$valor1['nombre_producto'];
    $codigo=$valor1['codigo_producto'];
    $foto1=$valor1['foto1'];
    $foto2=$valor1['foto2'];
    $foto3=$valor1['foto3'];
    $foto4=$valor1['foto4'];
    $pre_web=$valor1['pre_web'];
    $descripcion=$valor1['descripcion'];
    $descripcion1=$valor1['descripcion1'];
    $web=$valor1['web'];
    if($foto1<>"nuevo.jpg"){
        $disabled1="disabled";
    }
    if($foto2<>"nuevo.jpg"){
        $disabled2="disabled";
    }
    if($foto3<>"nuevo.jpg"){
        $disabled3="disabled";
    }
    if($foto4<>"nuevo.jpg"){
        $disabled4="disabled";
    }
    
    
    
    }
}
$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[2]==0){
    header("location:error.php");    
}


?>
<?php include ("header.php"); ?>
<?php

menu1();

?>

<script>
  function limpiarFormulario() {
    document.getElementById("guardar_producto").reset();
    
  }
</script>
<style type="text/css"> 
    .fijo {
  background: #333;
  color: white;
  height: 10px;
  
  width: 100%; /* hacemos que la cabecera ocupe el ancho completo de la página */
  left: 0; /* Posicionamos la cabecera al lado izquierdo */
  top: 0; /* Posicionamos la cabecera pegada arriba */
  position: fixed; /* Hacemos que la cabecera tenga una posición fija */
} 

.thumb {
            height: 180px;
            width:170px;
            border: 1px solid #000;
            margin: 10px 5px 0 0;
          }
.textfield10:hover {
                    border:3px solid black; 
}
.textfield10:focus {border:3px solid black;
                    -moz-box-shadow:inset 0 0 5px #FAFAFA;
-webkit-box-shadow:inset 0 0 5px #FAFAFA;
box-shadow:inset 0 0 5px #FAFAFA;
                  background-color:#FAFAFA;  
                  color:black;
}
.textfield10{display: block;  float:left;  background-color:white; width:600px;color:#0489B1;
          padding-left: 5px;
          padding-top: 4px; margin:1.5px; border: 3px solid #BDBDBD;
}

</style>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      FOTO
      <small>
        CAMBIAR FOTO
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
        FOTO
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
              DATOS DEL PRODUCTO
            </h3>
          </div>
          <div class="box-body">
            <?php         
print"<form class=\"form-horizontal form-label-left\" action=\"fotos2.php\" enctype=\"multipart/form-data\"  method=\"POST\">";

?>
       
                        <div class="form-group">
        <label for="codigo" class="col-sm-3 control-label">Código del producto:</label>
        <div class="col-sm-8">
                                    
                                    <input type="text"  class="form-control" id="codigo" name="codigo" value="<?php echo $codigo;?>" readonly="">
        </div>
        </div>
          
                            <div class="form-group">
        <label for="nombre" class="col-sm-3 control-label">Nombre del producto:</label>
        <div class="col-sm-8">
          <input  type="text" class="form-control"  name="nombre" value="<?php echo $producto;?>" readonly="">
          
        </div>
        </div>
                        <div class="form-group hidden">
        <label for="nombre" class="col-sm-3 control-label">Mostrar Web:</label>
        <div class="col-sm-8">
                                    <select name="web">
                                        <?php 
                                        if($web==1){
                                        ?>
                                        <option selected value="1">Si</option>
                                        <?php
                                        }else{
                                         ?>   
                                        <option value="1">Si</option>    
                                        <?php
                                        }
                                        ?>
                                        
                                         <?php 
                                        if($web==0){
                                        ?>
                                        <option selected value="0">No</option>
                                        <?php
                                        }else{
                                            
                                        ?>
                                        <option value="0">No</option>    
                                        <?php
                                        }
                                        ?>
                                        
                                    </select>
          
        </div>
        </div>  
          
                        <div class="form-group hidden">
        <label for="nombre" class="col-sm-3 control-label">Precio Web:</label>
        <div class="col-sm-8">
          <input  type="text" class="form-control"  name="pre_web" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" value="<?php echo $pre_web;?>" requrired>
          
        </div>
        </div>  
          
                            <div class="form-group hidden">
        <label for="nombre" class="col-sm-3 control-label">Breve Descripción:</label>
        <div class="col-sm-8">
          <textarea class="form-control" rows="2" name="descripcion" requrired><?php echo $descripcion;?></textarea>
          
        </div>
        </div>
                        <div class="form-group hidden">
        <label for="nombre" class="col-sm-3 control-label">Descripcion Web:</label>
        <div class="col-sm-8">
                                    <textarea  class="form-control"  rows="2" name="descripcion1"  requrired><?php echo $descripcion1;?></textarea>
          
        </div>
        </div>
          
                        <div class="form-group">
                            <label for="nombre" class="col-sm-3 control-label">Ingresar foto:<font color="red"> Medida: 340x340</font></label>
        <div class="col-sm-8">
                                    <input <?php echo $disabled1;?> accept="image/jpeg" type="file" id="files" name="files" class="form-control"/>
                                    <?php
                                    if($foto1<>"nuevo.jpg"){
          
                                        ?>
                                        <a href="fotos3.php?producto=1"><img class="thumb" src="fotos/<?php echo $foto1;?>" onmouseover="this.src='images/eliminar.png';" onmouseout="this.src='fotos/<?php echo $foto1;?>';"></a>
                                        <?php
                                    }
      
                                    ?>
                                   <output id="list"></output>
  
        
        </div>
        </div> 
          
                            <div class="form-group hidden">
        <label for="nombre" class="col-sm-3 control-label">Ingresar foto2:<font color="red"> Medida: 340x340</font></label>
        <div class="col-sm-8">
        <input <?php echo $disabled2;?> accept="image/jpeg" type="file" id="files1" name="files1" class="form-control"/>
       
                                <?php
                                if($foto2<>"nuevo.jpg"){
          
                                ?>
                                        <a href="fotos3.php?producto=2"><img class="thumb" src="fotos/<?php echo $foto2;?>" onmouseover="this.src='images/eliminar.png';" onmouseout="this.src='fotos/<?php echo $foto2;?>';"></a>
                                <?php
                                }
      
                                ?>                                
                             
                                <output id="list1"></output>
         
        </div>
        </div> 
          
          
                            <div class="form-group hidden">
        <label for="nombre" class="col-sm-3 control-label">Ingresar foto3:<font color="red"> Medida: 340x340</font></label>
        <div class="col-sm-8">
                                <input <?php echo $disabled3;?> accept="image/jpeg" type="file" id="files2" name="files2" class="form-control"/>
       
                                <?php
                                if($foto3<>"nuevo.jpg"){
          
                                ?>
                                        <a href="fotos3.php?producto=3"><img class="thumb" src="fotos/<?php echo $foto3;?>" onmouseover="this.src='images/eliminar.png';" onmouseout="this.src='fotos/<?php echo $foto3;?>';"></a>
                                <?php
                                }
                                ?>                                
                                   
                                 <output id="list2"></output>
         
        </div>
        </div> 
          
          
          
                        <div class="form-group hidden">
        <label for="nombre" class="col-sm-3 control-label">Ingresar foto4:<font color="red"> Medida: 340x340</font></label>
        <div class="col-sm-8">
        <input <?php echo $disabled4;?> accept="image/jpeg" type="file" id="files3" name="files3" class="form-control"/>
                                <?php
                                if($foto4<>"nuevo.jpg"){
          
                                ?>
                                        <a href="fotos3.php?producto=4"><img class="thumb" src="fotos/<?php echo $foto4;?>" onmouseover="this.src='images/eliminar.png';" onmouseout="this.src='fotos/<?php echo $foto4;?>';"></a>
                                <?php
                                }
      
                                ?>                                
           
                            <output id="list3"></output>
         
        </div>
        </div> 
          <script>
      function archivo(evt) {
      var files = evt.target.files; // FileList object
    
      // Obtenemos la imagen del campo "file".
      for (var i = 0, f; f = files[i]; i++) {
        //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
        continue;
        }
    
        var reader = new FileReader();
    
        reader.onload = (function(theFile) {
        return function(e) {
          // Insertamos la imagen
         document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
        };
        })(f);
    
        reader.readAsDataURL(f);
      }
      }
    
                function archivo1(evt) {
      var files1 = evt.target.files; // FileList object
    
      // Obtenemos la imagen del campo "file".
      for (var i = 0, f; f = files1[i]; i++) {
        //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
        continue;
        }
    
        var reader = new FileReader();
    
        reader.onload = (function(theFile) {
        return function(e) {
          // Insertamos la imagen
         document.getElementById("list1").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
        };
        })(f);
    
        reader.readAsDataURL(f);
      }
      }
                
                
                 function archivo2(evt) {
      var files2 = evt.target.files; // FileList object
    
      // Obtenemos la imagen del campo "file".
      for (var i = 0, f; f = files2[i]; i++) {
        //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
        continue;
        }
    
        var reader = new FileReader();
    
        reader.onload = (function(theFile) {
        return function(e) {
          // Insertamos la imagen
         document.getElementById("list2").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
        };
        })(f);
    
        reader.readAsDataURL(f);
      }
      }
                
                
                
                function archivo3(evt) {
      var files3 = evt.target.files; // FileList object
    
      // Obtenemos la imagen del campo "file".
      for (var i = 0, f; f = files3[i]; i++) {
        //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
        continue;
        }
    
        var reader = new FileReader();
    
        reader.onload = (function(theFile) {
        return function(e) {
          // Insertamos la imagen
         document.getElementById("list3").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
        };
        })(f);
    
        reader.readAsDataURL(f);
      }
      }
                
      document.getElementById('files').addEventListener('change', archivo, false);
                  document.getElementById('files1').addEventListener('change', archivo1, false);
                  document.getElementById('files2').addEventListener('change', archivo2, false);
                  document.getElementById('files3').addEventListener('change', archivo3, false);
  </script>
   
           <div class="modal-footer">
      <a href="productos.php" class="btn btn-warning">Regresar</a>
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




