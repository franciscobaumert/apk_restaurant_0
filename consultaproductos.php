<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Consultar Productos";

$consulta1 = "SELECT * FROM products ";
$result1 = mysqli_query($con, $consulta1);
$producto = array();
$i=0;
while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    if ($valor1['pro_ser']==1){
    $producto[$i]=utf8_decode($valor1['nombre_producto']);
    $i=$i+1;
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
if($a[15]==0){
    header("location:error.php");    
}

?>
<?php include ("header.php"); ?>
<?php

menu1();

?>

<style>
  /* ***** autocomplete ***** */

.autocomplete-suggestions {
    border: 1px solid #e4e4e4;
    background: #F4F4F4;
    cursor: default;
    overflow: auto;
}

.autocomplete-suggestion {
    padding: 2px 5px;
    font-size: 1.2em;
    white-space: nowrap;
    overflow: hidden;
}

.autocomplete-selected {
    background: #f0f0f0;
}

.autocomplete-suggestions strong {
    font-weight: normal;
    color: #232323;
    font-weight: bolder;
}
/* ***** /autocomplete *****/
</style>

<?php 
$consulta2 = "SELECT * FROM consultas ";
$result2 = mysqli_query($con, $consulta2);
$d=0;
while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) { 
if ($valor1['tipo']==1){
$d=$valor1['id'];
$nom_pro=$valor1['a1'];
$codigo_producto=$valor1['a2'];        
$marca=$valor1['a3'];
$modelo=$valor1['a4'];
$tipo=$valor1['a5'];
$cat=$valor1['a6'];
}

}


?>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      CONSULTAS
      <small>
        CONSULTA DE PRODUCTOS
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
        CONSULTAS
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
              CONSULTA DE PRODUCTOS
            </h3>
          </div>
          <div class="box-body">
            <form   id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="GET" action="consultaproductos1.php">
                      
                          
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="text" placeholder="Nombre del producto"  name="nom_pro" id="autocomplete-custom-append" data-validate-length-range="4" class="form-control col-md-12" style="float: left;" onKeyUp="this.value=this.value.toUpperCase();">
                        
                        
                        <div  id="autocomplete-container" style="position: relative; float: left; width: 400px; margin: 3px;">
                            
                            
                        </div>
                      </div>
                     
                      
                      
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <select class="select2_single form-control" name="cod_pro" required="required" tabindex="-1" style="width: 100%;">
                            <option value="0" > Buscar c&oacute;digo
                            <?php
                            $consulta1 = "SELECT * FROM products ";
                            $result1 = mysqli_query($con, $consulta1);

                            while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                            ?>
                                <option  value="<?php echo $valor1['codigo_producto'];?>"><?php echo $valor1['codigo_producto'];?>     
                            <?php
    
                            }                            
                            ?>
                                                                                          
                        </select>
                      </div>
                     <div class="col-md-4 col-sm-12 col-xs-12">
                        <select class="select2_single form-control" name="cat" required="required" tabindex="-1" style="width: 100%;">
                            <option value="0" > Buscar Categoria
                            <?php
                            $consulta3 = "select*from categorias  ORDER BY `categorias`.`nom_cat` ASC";
                            $result3 = mysqli_query($con,$consulta3);

                            while ($valor3 = mysqli_fetch_array($result3)) {
                            ?>
                                <option  value="<?php echo $valor3['id_categoria'];?>"><?php echo $valor3['nom_cat'];?>     
                            <?php
    
                            }                            
                            ?>
                                                                                          
                        </select>
                      </div>
                   
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <select class="select2_single form-control" name="marca" required="required" tabindex="-1" style="width: 100%;">
                            <option value="0" > Buscar Marca
                            <?php
         
                            $consulta1 = "select distinct marca from products ORDER BY `products`.`marca` ASC";
                            $result1 = mysqli_query($con,$consulta1);

                            while ($valor1 = mysqli_fetch_array($result1)) {
                            ?>
                                    <option  value="<?php echo $valor1['marca'];?>"><?php echo $valor1['marca'];?>     
                            <?php
    
                            }                            
                            ?>
                                                                                          
                        </select>
                      </div>
                  
                        <div class="col-md-4 col-sm-12 col-xs-12">
                        <select class="select2_single form-control" name="modelo" required="required" tabindex="-1" style="width: 100%;">
                            <option value="0" > Buscar Modelo
                            <?php
                            $consulta1 = "select distinct modelo from products ORDER BY `products`.`modelo` ASC";
                            $result1 = mysqli_query($con,$consulta1);

                            while ($valor1 = mysqli_fetch_array($result1)) {
                            ?>
                                <option  value="<?php echo $valor1['modelo'];?>"><?php echo $valor1['modelo'];?>     
                            <?php
    
                            }                            
                            ?>
                                                                                          
                        </select>
                      </div>   
                  
                        <div class="col-md-4 col-sm-12 col-xs-12">
                        <select class="select2_single form-control" name="tipo" tabindex="-1" style="width: 100%;">
                            <option value="" > Buscar Tipo
                           
                       <option  value="1">De venta     
                       <!--<option  value="0">De segunda--> 
                       <option  value="2">Insmo                                                                   
                        </select>
                      </div>      
                  
                      <div class="ln_solid"></div>
                    
                      <div class="col-md-4 col-sm-12 col-xs-12">
                      <input type="hidden" name="d" value="1">
                        <button id="send" type="submit" name="enviar" class="btn btn-success" style="width: 100%">Buscar</button>
                      </div>
                      
                   
                      
                    
                    </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">
              RESULTADOS
            </h3>
          </div>
          <div class="box-body">
            <?php
                       
if(isset($nom_pro)){
  $nom_pro1=utf8_encode($nom_pro);  
}
if($d==0){

    $sql="select * from products";
}else{
  
if($nom_pro1<>""){
    $sql="select * from products where nombre_producto='$nom_pro1'";
}else{
    $codigo_producto1="";
    $marca1="";
    $modelo1="";
    $tipo1="";
    $cat1="";
    if($codigo_producto<>"0"){
           $codigo_producto1="and (codigo_producto='$codigo_producto')"; 
        }
   if($marca<>"0"){
                $marca1="and (marca='$marca')";
            }
            if($modelo<>"0"){
                $modelo1="and (modelo='$modelo')";
            }
            if($tipo<>""){
                $tipo1="and (status_producto='$tipo')";
            }
            if($cat>0){
                $cat1="and (cat_pro='$cat')";
            }

    $sql="select * from products where pro_ser=1 $codigo_producto1 $marca1 $tipo1 $cat1 $modelo1"; 
}
$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
$aa="http://".$host.$url;

?>
             <form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
                 <p><a class="btn btn-primary" href="tabla.php?t=0&a=<?php echo $aa;?>">Tabla Normal</a> 
                     
                     
                     <a class="btn btn-danger" href="tabla.php?t=2&a=<?php echo $aa;?>">Editar Stock</a>
                     &nbsp;
                   
                    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
            </form> 
    
             <div class="table-responsive">
                   
                  <table id="example" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="bg-gray">
                       <th>Numero  </th>
                       <th>Categoria  </th>
                        <th>Codigo  </th>
                        
                        <th>Producto </th>
                        
                        <th>Stock </th>
                        <th>Precio  </th>
                         <!--<th>Precio2  </th>
                         <th>Precio3  </th>-->
                        <th>Marca  </th>
                       <th>Modelo  </th>
                        <th>Color  </th>
                         <th>Tipo  </th>
                      </tr>
                    </thead>

                    <tfoot>
                      <tr class="bg-gray">
                       <th>Numero  </th>
                       <th>Categoria  </th>
                        <th>Codigo  </th>
                        
                        <th>Producto </th>
                        
                        <th>Stock </th>
                        <th>Precio  </th>
                         <!--<th>Precio2  </th>
                         <th>Precio3  </th>-->
                        <th>Marca  </th>
                       <th>Modelo  </th>
                        <th>Color  </th>
                         <th>Tipo  </th>
                      </tr>
                    </tfoot>

                    <tbody>
   
   <?php
$s=1;
$rs=mysqli_query($con,$sql);
while($row= mysqli_fetch_array($rs)){
    
    $tienda=$_SESSION['tienda'];
    if($tienda==1){
        $inv=$row["b1"];
    }
    if($tienda==2){
        $inv=$row["b2"];
    }
    if($tienda==3){
        $inv=$row["b3"];
    }
    if($tienda==4){
        $inv=$row["b4"];
    }
    if($tienda==5){
        $inv=$row["b5"];
    }
    if($tienda==6){
        $inv=$row["b6"];
    }
    
    ?>
      
        <tr id="valor1">
 <?php
$consulta3 = "select*from categorias  ORDER BY `categorias`.`nom_cat` ASC";
$result3 = mysqli_query($con,$consulta3);

while ($valor3 = mysqli_fetch_array($result3)) {
   if($valor3['id_categoria']==$row["cat_pro"]){
       $cat1=$valor3['nom_cat'];
   }
    
}                            
                            ?>
     
                       <td class=" "><?php echo $s;?></td>
                       <td class=" "><?php echo $cat1;?></td>
                        <td class=" "><?php echo utf8_decode($row["codigo_producto"]);?></td>
                        
                        <td class=" "><?php 
                        $cadena=utf8_decode($row["nombre_producto"]);
                        
                        echo $cadena;?></td>
                        <?php 
                        
                        if($_SESSION['tabla']==2){
                            ?>
                    
                        <td class=" "><form id="ficha"><input size="3" text-align="center" id="<?php echo $row["id_producto"];?>" name="<?php echo $row["id_producto"];?>" type="text" value="<?php echo $inv;?>" class="form-control input-sm"></form></td>
                           <?php
                           }else{
                            
                          ?>  
                            
                        <td class=" "><?php echo $inv;?>  </td>
                          <?php
                           }
                           
                           ?>
                            
                        
                        <td class=" "><?php print"S/. $row[precio_producto]";?></td>
                        <!--<td class=" "><?php print"S/. $row[precio2]";?></td>
                        <td class=" "><?php print"S/. $row[precio3]";?></td>-->
                        <td class=" "><?php echo $row["marca"];?></td>
                        <td class=" "><?php echo $row["modelo"];?></td>
                        <td class=" "><?php echo $row["color"];?></td>
                        <?php
                        /*if($row["status_producto"]==0){
                            $tip="De Segunda";
                        }*/
                        if($row["status_producto"]==1){
                            $tip="De venta";
                        }
                        if($row["status_producto"]==2){
                            $tip="Insumo";
                        }
                        ?>
                        
                        
                        <td class=" "><?php echo $tip;?></td>
                        
                      </tr>                
    <?php
    $s=$s+1;
}
                        
                        ?>
             
                    </tbody>

                  </table>
     
                   
                     </form>
          </div>
<?php
}
?>
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
<?php $a=$_SESSION['tabla'];?>

  <!-- Datatables -->
 
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  <script type="text/javascript">
    $(function() {
      'use strict';
      
      var data =[
      <?php
                    for($i = 0;$i<count($producto);$i++){
                ?>
                '<?php echo $producto[$i];?>',
                <?php } ?>];
     
      
      
      var countriesArray = $.map(data, function(value, key) {
        return {
          value: value,
          data: key
        };
      });
      // Initialize autocomplete with custom appendTo:
      $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
      });
    });
  </script>
  
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
  
  
  <script type="text/javascript" src="../jquery.js"></script>

<script type="text/javascript">

$(document).ready(function(){



    $('input').blur(function(){

        var field = $(this);

        var parent = field.parent().attr('id');

        field.css('background-color','#fff');


        var dataString = 'value='+$(this).val()+'&field='+$(this).attr('name');

        $.ajax({

            type: "POST",

            url: "edit.php",

            data: dataString,

            success: function(data) {

                field.val(data);

                $('#'+parent+' .loader').fadeOut(function(){

                    $('#'+parent).append('<img src="descargar.png"/>').fadeIn('slow');

                });



            }

        });

    });

});

</script>  
 
<script>
 
$(document).ready(function() {
    
    
        $('#example').DataTable( {
        language: {
        "url": "/dataTables/i18n/de_de.lang",
                "decimal": "",
        "show": "Mostrar",
        "emptyTable": "No hay informacion",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "<img src='./assets/itsolution24/img/loading2.gif'>",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        buttons: {
                copyTitle: 'Copiar filas al portapapeles',
                
                copySuccess: {
                    _: 'Copiado %d fias ',
                    1: 'Copiado 1 fila'
                },
                
                pageLength: {
                _: "Mostrar %d filas",
                '-1': "Mostrar Todo"
            }
            },
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }

    },

         bDestroy: true,
            dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        buttons: 

         [
                
             {
                    extend: 'colvis',
                    text: 'Columnas',
                    className: 'green2',
                    exportOptions: {
                    columns: ':visible'
                }
                
                },   
                          
{
                    extend: 'pageLength',
                    text: 'Filas',
                    className: 'orange',
                    exportOptions: {
                    columns: ':visible'
                }
                
                },
                
                {
                    extend: 'copy',
                    text: '<i class="fa fa-copy"></i>',
                    className: 'red',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    className: 'green',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    className: 'green',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file"></i>',
                    className: 'green1',
                    exportOptions: {
                    columns: ':visible'
                }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    className: 'green2',
                    exportOptions: {
                    columns: ':visible'
                }
                },
            ],
         "pageLength": 10,
        
    } );

} );



</script>

<script type="text/javascript">
    
    $('#productos1').addClass("treeview active");
    $('#consultaproductos').addClass("active");

</script>
  
</body>

</html>




