<?php

session_start();
include('menu.php');
//include('funciones.php');
include('conexion.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos




$db = conectar1();
$consulta1 = "SELECT * FROM $db_clientes ";
$result1 = mysqli_query($db, $consulta1);
$producto = array();
$i=0;
while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    
    $producto[$i]=$valor1['nombre_cliente'];
    $i=$i+1;
    
}

  
   $sql1="select * from $db_users where user_id=$_SESSION[user_id]";
    $rw1=mysqli_query($db,$sql1);//recuperando el registro
    $rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo


$modulo=$rs1["accesos"];


$sql2="select * from $db_sucursal ORDER BY  `sucursal`.`tienda` DESC ";
    $rw2=mysqli_query($db,$sql2);//recuperando el registro
    $rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$tienda1=$rs2["tienda"];


$a = explode(".", $modulo); 
        //$_SESSION['user_login_status']=1;
        //$_SESSION['user_id']=1;
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

        if($a[38]==0){
        header("location:error.php");    
        }

   
$a1=recoge1('fecha1');
$a2=recoge1('fecha2');
if($a1==2 && isset($a1)){
    $a2="Anual";
}


$a3=recoge1('tienda');
$a4=recoge1('asistencia');
$a5="";
$a6="";
$delete=mysqli_query($con,"DELETE FROM consultas");
$insert=mysqli_query($con,"INSERT INTO consultas VALUES ('','43','$a1','$a2','$a3','$a4','$a5','$a6')");     
        
        
date_default_timezone_set('America/Santiago');
                $anio1=date("Y");        
        
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title> 
  Asistencia del personal
  
  </title>

 <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">
  <link href="css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">
 <link href="css/select/select2.min.css" rel="stylesheet">
  <script src="js/jquery.min.js"></script>
  <SCRIPT LANGUAGE="JavaScript" SRC="calendar.js"></SCRIPT>
  
  
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>


 <link rel="stylesheet" type="text/css" href="Buttons/css/buttons.dataTables.min.css"/>


<script type="text/javascript" src="DataTables/datatables.min.js"></script>


<script type="text/javascript" src="Buttons/js/buttons.flash.min.js"></script>


<script type="text/javascript" src="Buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="Buttons/js/buttons.print.min.js"></script>

<script type="text/javascript">
var mostrarValor = function(x){
      var x;
      var y="Anual";

      
     if(x>1) {
        document.getElementById('anio').value=y;
        document.getElementById("anio").disabled = true;
     }
     
     if(x==1) {
        document.getElementById('anio').value=<?php echo $anio1;?>;
        document.getElementById("anio").disabled = false;
     }
     
};  

</script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
<style>
    table tr:nth-child(odd) {background-color: #FBF8EF;}

table tr:nth-child(even) {background-color: #EFFBF5;}
 #valor1 {
              

border-bottom: 1px solid black;

}  

#valor1:hover {
              
background-color: white;


} 

.dt-button.red {
        color: black;
        
        background:red;
    }
 
    .dt-button.orange {
        color: black;
        background:orange;
    }
 
    .dt-button.green {
        color: black;
        background:green;
    }
    
    .dt-button.green1 {
        color: black;
        background:#01DFA5;
    }
    
    .dt-button.green2 {
        color: black;
        background:#2E9AFE;
    }
</style>
</head>

<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

        
          <div class="clearfix"></div>

          <!-- menu prile quick info -->
          <?php
          menu2();
          
          ?>
          <!-- /menu prile quick info -->

          

          <!-- sidebar menu -->
          <?php
          menu1();
          
          ?>
          <!-- /menu prile quick info -->

          <br />

          <!-- sidebar menu -->
         
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
        
          <!-- /menu footer buttons -->
        </div>
      </div>

        
        <?php
          menu3();
          
          ?>
      <!-- top navigation -->
     

        <?php
        
         
        
        
        ?>

      
      <!-- /top navigation -->


      <!-- page content -->
      <div class="right_col" role="main">
<?php 

$db_consultas = $db_db.'.consultas';
$consulta2 = "SELECT * FROM $db_consultas ";
$result2 = mysqli_query($db, $consulta2);

$d=0;
$cliente="";

$fecha1="";
$fecha2="";
$tienda=0;
$dd1="";
$dd2="";
while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
    
    
     
     if ($valor1['tipo']==43){
         
         $fecha1=$valor1['a1'];
          //$nom_pro=trim($nom_pro1);
          $fecha2=$valor1['a2'];
          $tienda=$valor1['a3'];
          $asistencia=$valor1['a4'];
          if($tienda==7){
              $tien1=1;
              $tien2=6;
          }
          if($tienda<>7){
              $tien1=$tienda;
              $tien2=$tienda;
          }
          
          
          if ($fecha1<>""){
$d1 = explode("-", $fecha1);
$dia1=$d1[0]; 
$mes1=$d1[1];
$ano1=$d1[2];
$dd1=$ano1."-".$mes1."-".$dia1;
}
 
if ($fecha2<>""){
$d2 = explode("-", $fecha2);
$dia2=$d2[0]; 
$mes2=$d2[1];
$ano2=$d2[2];
$dd2=$ano2."-".$mes2."-".$dia2;

}
          
          
     }
    
}

 



          
          
            ?>
          
           
               
               <div class="row">
                   <div class="col-md-12 col-sm-12 col-xs-12">
                       <div class="x_panel" style="background:#81F79F;">
                        <form  name="myForm" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="consulta13.php">
                      
                          <div class="panel panel-info">
		<div class="panel-heading">
		   
                    <h2> Asistencia del personal</h2>
		</div>        
        </div> 
                     
                     
                         <div class="col-md-3 col-sm-3 col-xs-12">
                           
                             <label>Fecha1:</label>
                               <input class="form-control col-md-10" value="<?php echo $fecha1; ?>" id="fecha1" name="fecha1" type="date" required="required" >
                          </div>
                            
                        
                      
                       <div class="col-md-3 col-sm-3 col-xs-12">
                            
                           <label>Fecha2:</label>
                               <input class="form-control col-md-10" value="<?php echo $fecha2; ?>" id="fecha2" name="fecha2" type="date" required="required" >
                          </div>
                     
                      <div class="col-md-3 col-sm-3 col-xs-12">
                            
                           <label>Mostrar:</label>
                           <select class="form-control col-md-10" name="asistencia" required="required" tabindex="-1">
                            <?php
                            if($asistencia==0){
                                ?>
                               <option selected value="0" >Solo asistencia</option>
                               <?php
                            }else{
                                ?>
                               <option value="0" >Solo asistencia</option>
                               <?php 
                                
                            }
                            
                            if($asistencia==1){
                                ?>
                               <option selected value="1" >Min Tardanza</option>
                               <?php
                            }else{
                                ?>
                               <option value="1" >Min Tardanza</option>
                               <?php 
                                
                            }
                            
                            ?>
                               
                               
                           </select>    
                      </div>
                            
                            
                            
                       <div class="col-md-3 col-sm-3 col-xs-12">
                        <label>Sucursal:</label>
                           <select class="form-control col-md-10" name="tienda" required="required" tabindex="-1">
                            
                               <option value="0" >Escoger</option>
                            <?php  
                               
                             for($i=1 ;$i<=$tienda1;$i++){
        
                                if($i==$tienda) {
                                    ?>
                 <option selected value="<?php echo $i;?>" >Sucursal <?php echo $i;?></option>              
                               <?php 
                                }else{
                                      ?>
                 
                 <option value="<?php echo $i;?>" >Sucursal <?php echo $i;?></option>
                 
                               <?php 
                                }
                              } 
                              
                              if($tienda==7) {
                                    ?>
                 <option selected value="7" >Todas</option>              
                               <?php 
                                }else{
                                      ?>
                 
                <option value="7" >Todas</option> 
                 
                               <?php 
                                }
                              
                            ?>
                            
                            
                                                                                       
                        </select>
                        <br>
                      <br>
                      </div>
                      
                        
                            <input type="hidden" name="d" value="1">
                        <button id="send" type="submit" name="enviar" class="btn btn-success">Buscar</button>
                      
                   
                          <div>Asistio: <font color="blue"><strong>A</strong></font> &nbsp;&nbsp;&nbsp;  
                              Tardanza: <font color="orange"><strong>T</strong></font> &nbsp;&nbsp;&nbsp;
                              Falto: <font color="red"><strong>F</strong></font> &nbsp;&nbsp;&nbsp;
                              Descanso Fisico: <font color="#5858FA"><strong>DF</strong></font></div>
                     
                    
                    </form>
                  
          
                   </div>
                   </div>
               </div>
         
          <div class="row">
        
   <div class="table-responsive">
                   
                 
 <?php   
 
 
   $fech1=strtotime($dd1);
$fech2=strtotime($dd2); 
 $f1=$fech1/(24*3600);
$f2=$fech2/(24*3600);
 $fech=array();
 $fech1=array();
 $j=0;
 $text="";
 

 
 for($i=$f1;$i<=$f2;$i++){
     $fec[$j]=date('Y-m-d', $i*24*3600);
     $fec1[$j]=date('d-m-Y', $i*24*3600);
     if($i<$f2){
          $text=$text." SUM(IF(DATE_FORMAT(fecha_entrada,'%Y-%m-%d')='$fec[$j]',If(asistencia=0,1+TIME_TO_SEC(min_tardanza)/60,10000*asistencia),0)) AS '$fec[$j]',";
     
     }else{
        $text=$text." SUM(IF(DATE_FORMAT(fecha_entrada,'%Y-%m-%d')='$fec[$j]' ,If(asistencia=0,1+TIME_TO_SEC(min_tardanza)/60,10000*asistencia),0)) AS '$fec[$j]'";
     
         
     }
     $j=$j+1;
 }
 
 
 ?>
        <table id="example" class="display" style="width:100%" border='1'>
                    <thead>
                      <tr style="background-color:#FE9A2E;color:white; ">
                       <th>Personal </th>
                       <th>Dias Asistencia</th>
                       <th>Min Tardanza</th>
                      <?php
                       for($i=0;$i<=$j-1;$i++){
                           ?>
                           <th><?php echo $fec1[$i];?></th>
                       <?php
                       }
                       ?>
                      
                      
                      </tr>
                    </thead>

                    <tbody>  
       
       
       <?php
       
 if($tienda>0){
    $sql="SELECT nombres,
$text

FROM users, asistencia WHERE users.user_id=asistencia.user_id and users.sucursal>=$tien1 and users.sucursal<=$tien2 GROUP BY nombres
";

  //echo $sql;
$rs=mysqli_query($con,$sql);

while($row=mysqli_fetch_array($rs)){
    $suma=0;
                       $cont=0;
                       for($i=0;$i<=$j-1;$i++){
                           if($row[$fec[$i]]>=1 && $row[$fec[$i]]<10000){
                           $suma=$suma+$row[$fec[$i]]-1;
                           $cont=$cont+1;
                       
                       }
                        }
    
    
    $d=$row['nombres'];
  
  
        ?>
                      
        <tr id="valor1">
                        
                       <td class=" "><?php echo $d;?> </td>
                       <td ><?php echo $cont;?> Dias</td>
                       <td ><?php echo $suma;?> min</td>
                       <?php
                       for($i=0;$i<=$j-1;$i++){
                           $a="";
                           $color="";
                           if($row[$fec[$i]]==1 ) {
                                     $color="blue";
                                     
                                     
                                     $a="A";
                                     
                                 }
                                 
                                 
                                 
                                 if($row[$fec[$i]]>=10000) {
                                     
                                     $g=$row[$fec[$i]]/10000;
                                     $sql2="select * from $db_laborales WHERE id_laboral=$g";
                                $rw2=mysqli_query($db,$sql2);//recuperando el registro
                                $rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
                                
                                $a=$rs2["cod_var"];
                                  $color=$rs2["col_var"];   
                                     
                                     
                                     
                                     
                                 }
                                 
                                 if($row[$fec[$i]]>1 && $row[$fec[$i]]<10000) {
                                     $color="orange";
                                     $a="T";
                                 }
                                if($row[$fec[$i]]==0) {
                                     $color="red";
                                     $a="F";
                                 }
                                 if($asistencia==0){
                                     $c=$a;
                                 }else{
                                     $c="";   
                                     if($row[$fec[$i]]>=1 && $row[$fec[$i]]<10000) {
                                         $c=round(($row[$fec[$i]] -1)* 100) / 100;
                                     }
                                     
                                 }
                           ?>
                       
                       
                       <td bgcolor="<?php echo $color; ?> " align="center"><font color='white'><strong><?php echo $c; ?></strong></font></td>
                               <?php  
                           
                           
                          
                       }
                       ?>
                       
                       
                       
                        
                      </tr>                
    <?php
    
}
                      
}                        ?>
                        
                       
                      
                     
                    </tbody>

                   
                  </table>
                
                     
                </div>
              
     
                      
                       
              
              
            </div>
          
          
         
               
          


          </div>
         
        <!-- /footer content -->
      </div>
      <!-- /page content -->

    </div>

  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  
  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>


  <!-- Datatables -->
  

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
  
 
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
  
  
  
<script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#example").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
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
        "processing": "Procesando...",
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
        
            dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        buttons: 
        
        
        [
                
                {
                    extend: 'pageLength',
                    text: 'Mostrar filas',
                    className: 'orange'
                },
                
                {
                    extend: 'copy',
                    text: 'COPIAR',
                    className: 'red'
                },
                
                
                
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    className: 'green'
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'green1'
                },
                {
                    extend: 'print',
                    text: 'IMPRIMIR',
                    className: 'green2'
                }
            ],
        
        
    } );
} );



</script>



</body>

</html>




