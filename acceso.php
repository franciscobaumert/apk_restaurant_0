<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

$title="Accesos";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo

$modulo=$rs1["accesos"];
$sql2="select * from sucursal ORDER BY  tienda DESC ";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$tienda=$rs2["tienda"];
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
if($a[26]==0){
    header("location:error.php");    
}

   
$usuario=recoge1('usuario');
$mensaje=recoge1('mensaje');
        
?>
<?php include ("header.php"); ?>

<style>
    table tr:nth-child(odd) {background-color: #FBF8EF;}

table tr:nth-child(even) {background-color: #f9f9f9;}
 #valor1 {
              

border-bottom: 2px solid #F5ECCE;

}  

#valor1:hover {
              
background-color: white;
border-bottom: 2px solid #A9E2F3;

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

<?php

menu1();

?>

<div class="content-wrapper" ng-controller="DashboardController">

<!-- Content Header Start -->
  <section class="content-header">
    
    <h1>
      ACCESOS
      <small>
        DE USUARIOS
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
        ACCESOS
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
              CAMBIAR ACCESOS
            </h3>
          </div>
          <div class="box-body">
            <label>Buscar Usuario:</label>
                            <form  name="myForm" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="acceso.php">
                               <select  class="select2_single form-control" tabindex="-1" id="usuario" name="usuario"  required="required" style="width: 100%;">
                         <option value="">-- Selecciona Usuario --</option>
      
                         
                         
                        <?php
                        
                        if($usuario<>""){
                            ?>
                         <option selected value="<?php echo $usuario;?>"><?php echo $usuario;?></option>
                         <?php
                        }
                        
                        
                        
                        
    $sql2="select * from users  ORDER BY  `users`.`nombres` ASC ";
    
$rs1=mysqli_query($con,$sql2);
while($row3=mysqli_fetch_array($rs1)){
    
    $nombres=$row3["nombres"];
$user_id=$row3["user_id"];

?>

                                        <option value="<?php  echo $nombres;?>"><?php  echo $nombres;?> </option>

<?php


 }                       
                        ?>
                               </select>
                            
                          
                      
            
                      <input type="hidden" name="d" value="1">
                        <button id="send" type="submit" name="enviar" class="btn btn-success" style="margin-top: 5px;">Buscar</button>
                      
                   
                      
                    
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
              LISTA DE ACCESOS
            </h3>
          </div>
          <div class="box-body">
            <?php 

 function checked($valor){ 
    if($valor==1){
        return "checked";
    }else{
        return "";
    }
     
 } 



   if($usuario<>"") {

$sql2="select * from users WHERE nombres='$usuario'";
    
$rs1=mysqli_query($con,$sql2);
while($row3=mysqli_fetch_array($rs1)){
    $accesos=$row3["accesos"];
    $a=explode(".",$accesos);
                                                $c1=checked($a[0]);
                                                $c2=checked($a[1]);
                                                $c3=checked($a[2]);
                                                $c4=checked($a[3]);
                                                $c5=checked($a[4]);
                                                $c6=checked($a[5]);
                                                $c7=checked($a[6]);
                                                $c8=checked($a[7]);
                                                $c9=checked($a[8]);
                                                $c10=checked($a[9]);
                                                $c11=checked($a[10]);
                                                $c12=checked($a[11]);
                                                $c13=checked($a[12]);
                                                $c14=checked($a[13]);
                                                $c15=checked($a[14]);
                                                $c16=checked($a[15]);
                                                $c17=checked($a[16]);
                                                $c18=checked($a[17]);
                                                $c19=checked($a[18]);
                                                $c20=checked($a[19]);
                                                $c21=checked($a[20]);
                                                $c22=checked($a[21]);
                                                $c23=checked($a[22]);
                                                $c24=checked($a[23]);
                                                $c25=checked($a[24]);
                                                $c26=checked($a[25]);
                                                $c27=checked($a[26]);
                                                $c28=checked($a[27]);
                                                $c29=checked($a[28]);
                                                $c30=checked($a[29]);
                                                $c31=checked($a[30]);
                                                $c32=checked($a[31]);
                                                $c33=checked($a[32]);
                                                $c34=checked($a[33]);
                                                $c35=checked($a[34]);
                                                $c36=checked($a[35]);
                                                $c37=checked($a[36]);
                                                $c38=checked($a[37]);
                                                $c39=checked($a[38]);
                                                
                                                $c40=checked($a[39]);
                                                $c41=checked($a[40]);
                                                $c42=checked($a[41]);
                                                $c43=checked($a[42]);
                                                $c44=checked($a[43]);
                                                $c45=checked($a[44]);
                                                $c46=checked($a[45]);
                                                $c47=checked($a[46]);
                                                $c48=checked($a[47]);
                                                $c49=checked($a[48]);
                                                $c50=checked($a[49]);
                                                $c51=checked($a[50]);
                                                $c52=checked($a[51]);
                                                $c53=checked($a[52]);
}
    
   ?>           
   
              <div class="table-responsive">
                  <form action="accesos1.php" method="POST" name="f1">
                     
                      <input type="hidden" name="nombres" value="<?php echo $usuario;?>">
                      <input type="hidden" name="tienda" value="<?php echo $tienda;?>">
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
                      <!--<h2><font color="red"><strong>Accesos del usuario:</strong></font></h2>-->
    
                      <a href="javascript:seleccionar_todo()" class="btn btn-info">Marcar todos</a>
                      <a href="javascript:deseleccionar_todo()" class="btn btn-warning">Marcar ninguno</a> 
                 <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="bg-gray">
                        <th></th>
                        <th class="column-title">Menu </th>
                        <th class="column-title">Submenu </th>
                        
                        <th class="bulk-actions hidden" colspan="7">
                          <a class="antoo" style="color:#fff; font-weight:500;">Accion masiva ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                        </th>
                      </tr>
                    </thead>

                    <tfoot>
                      <tr class="bg-gray">
                        <th></th>
                        <th class="column-title">Menu </th>
                        <th class="column-title">Submenu </th>
                        
                        <th class="bulk-actions hidden" colspan="7">
                          <a class="antoo" style="color:#fff; font-weight:500;">Accion masiva ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                        </th>
                      </tr>
                    </tfoot>

                    <tbody>
                      
                      <?php 
                      
                      if($tienda>=1){
                          ?>
                      
                        <tr class="success even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a44" <?php echo $c44;?> value="1">
                        </td>
                        <td class=" ">Tienda</td>
                        <td class=" ">Tienda 1 </td>
                        
                      </tr>
                      <?php
                        }
                         
                      
                      if($tienda>=2){
                          ?>
                      <tr class="success even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a45" <?php echo $c45;?> value="1">
                        </td>
                        <td class=" ">Tienda</td>
                        <td class=" ">Tienda 2 </td>
                        
                      </tr>
                        <?php
                        }
                        
                      
                      if($tienda>=3){
                          ?>
                       <tr class="success even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a46" <?php echo $c46;?> value="1">
                        </td>
                        <td class=" ">Tienda</td>
                        <td class=" ">Tienda 3 </td>
                        
                      </tr> 
                       <?php
                        }
                        
                      
                      if($tienda>=4){
                          ?>
                       <tr class="success even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a47" <?php echo $c47;?> value="1">
                        </td>
                        <td class=" ">Tienda</td>
                        <td class=" ">Tienda 4 </td>
                        <?php
                        }
                        
                      
                      if($tienda>=5){
                          ?>
                      </tr>
                       <tr class="success even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a48" <?php echo $c48;?> value="1">
                        </td>
                        <td class=" ">Tienda</td>
                        <td class=" ">Tienda 5 </td>
                        
                      </tr>
                      <?php
                        }
                        
                      
                      if($tienda>=6){
                          ?>
                       <tr class="success even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a49" <?php echo $c49;?> value="1">
                        </td>
                        <td class=" ">Tienda</td>
                        <td class=" ">Tienda 6 </td>
                        
                      </tr>
                      
                     <?php
                        }
                        
                      ?>
                    
                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a2" <?php echo $c2;?> value="1">
                        </td>
                        <td class=" ">Tablero</td>
                        <td class=" ">Resumen General</td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a21" <?php echo $c21;?> value="1">
                        </td>
                        <td class=" ">Disponibilidad</td>
                        <td class=" ">Vista de todas las mesas (Rojo: ocupado - Verde: disponible) </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a39" <?php echo $c39;?> value="1">
                        </td>
                        <td class=" ">Imprimir Precuenta</td>
                        <td class=" ">Imprimir precuenta de una mesa ocupada</td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a50" <?php echo $c50;?> value="1">
                        </td>
                        <td class=" ">Cerrar Mesas</td>
                        <td class=" ">Procesar documento electronico de una mesa ocupada </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center">
                          <input type="checkbox"  name="a28" <?php echo $c28;?> value="1">
                        </td>
                        <td class=" ">Eliminar Productos</td>
                        <td class=" ">Eliminar productos al seleccionar una mesa ocupada </td>
                        
                      </tr>


                       <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a43" <?php echo $c43;?> value="1">
                        </td>
                        <td class=" ">Editar Precio Precuenta</td>
                        <td class=" ">Editar el precio en la precuenta (en caso de descuento para los clientes)</td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a33" <?php echo $c33;?> value="1">
                        </td>
                        <td class=" ">Caja</td>
                        <td class=" ">Apertura y cierre de caja diario (solo se contabiliza las mesas cerradas) </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a18" <?php echo $c18;?> value="1">
                        </td>
                        <td class=" ">Clientes</td>
                        <td class=" ">Lista de Clientes </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a19" <?php echo $c19;?> value="1">
                        </td>
                        <td class=" ">Proveedores</td>
                        <td class=" ">Lista de Proveedores </td>
                        
                      </tr>

                      <tr class="even pointer hidden">
                        <td class="a-center ">
                          <input type="checkbox"  name="a11" <?php echo $c11;?> value="1">
                        </td>
                        <td class=" ">Productos</td>
                        <td class=" ">Ingresar Productos </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a12" <?php echo $c12;?> value="1">
                        </td>
                        <td class=" ">Productos</td>
                        <td class=" ">Lista de Productos </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a10" <?php echo $c10;?> value="1">
                        </td>
                        <td class=" ">Productos</td>
                        <td class=" ">Categorias </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a13" <?php echo $c13;?> value="1">
                        </td>
                        <td class=" ">Productos</td>
                        <td class=" ">Kardex de Productos </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a16"<?php echo $c16;?> value="1" >
                        </td>
                        <td class=" ">Productos</td>
                        <td class=" ">Consultas de Productos </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a17"<?php echo $c17;?> value="1" >
                        </td>
                        <td class=" ">Productos</td>
                        <td class=" ">Consultas de Precios </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a15"<?php echo $c15;?> value="1" >
                        </td>
                        <td class=" ">Traslados</td>
                        <td class=" ">Lista de Traslados </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a14"<?php echo $c14;?> value="1" >
                        </td>
                        <td class=" ">Traslados</td>
                        <td class=" ">Tasladar </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a34" <?php echo $c34;?> value="1">
                        </td>
                        <td class=" ">Compras</td>
                        <td class=" ">Añadir Compra </td>
                        
                      </tr>
                      
                        <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a35" <?php echo $c35;?> value="1">
                        </td>
                        <td class=" ">Compras</td>
                        <td class=" ">Lista de Compras </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a6"<?php echo $c6;?> value="1" >
                        </td>
                        <td class=" ">Informes</td>
                        <td class=" ">Productos mas Vendidos </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a36" <?php echo $c36;?> value="1">
                        </td>
                        <td class=" ">Informes</td>
                        <td class=" ">Compras por Usuario Diario/Mensual/Anual</td>
                        
                      </tr>
                      
                       <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a37" <?php echo $c37;?> value="1">
                        </td>
                        <td class=" ">Informes</td>
                        <td class=" ">Compras por Proveedor Diario/Mensual/Anual</td>
                        
                      </tr>
                      
                       <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a38" <?php echo $c38;?> value="1">
                        </td>
                        <td class=" ">Informes</td>
                        <td class=" ">Resumen de Compras </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a24" <?php echo $c24;?> value="1">
                        </td>
                        <td class=" ">Informes</td>
                        <td class=" ">Ventas por Usuario Mensual/Anual/Diario</td>
                        
                      </tr>
                      
                       <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a25" <?php echo $c25;?> value="1">
                        </td>
                        <td class=" ">Informes</td>
                        <td class=" ">Ventas por Cliente Mensual/Anual/Diario</td>
                        
                      </tr>
                        <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a26" <?php echo $c26;?> value="1">
                        </td>
                        <td class=" ">Informes</td>
                        <td class=" ">Resumen de Ventas </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a31" <?php echo $c31;?> value="1">
                        </td>
                        <td class=" ">Facturacion Electronica</td>
                        <td class=" ">Configuracion </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a8" <?php echo $c8;?> value="1">
                        </td>
                      <td class=" ">Facuracion Electronica</td>
                        <td class=" ">Documentos Electronicos </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a7" <?php echo $c7;?> value="1">
                        </td>
                      <td class=" ">Facturacion Electronica</td>
                        <td class=" ">Resumen de Boletas </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a9" <?php echo $c9;?> value="1">
                        </td>
                      <td class=" ">Facturacion Electronica</td>
                        <td class=" ">Comunicacion de Baja </td>
                        
                      </tr>
                      
                        <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a32" <?php echo $c32;?> value="1">
                        </td>
                        <td class=" ">Facturacion Electronica</td>
                        <td class=" ">Guias de Remision </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a42" <?php echo $c42;?> value="1">
                        </td>
                        <td class=" ">Contabilidad</td>
                        <td class=" ">Registro de Ventas General</td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a41" <?php echo $c41;?> value="1">
                        </td>
                        <td class=" ">Contabilidad</td>
                        <td class=" ">Calculo IVA</td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a29" <?php echo $c29;?> value="1">
                        </td>
                        <td class=" ">Ventas</td>
                        <td class=" ">Realizar Notas Credito/Debito Facturas</td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a40" <?php echo $c40;?> value="1">
                        </td>
                        <td class=" ">Ventas</td>
                        <td class=" ">Realizar Notas Credito/Debito Boletas</td>
                        
                      </tr>
                      
                       <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a23" <?php echo $c23;?> value="1">
                        </td>
                        <td class=" ">Ventas</td>
                        <td class=" ">Lista de Ventas  </td>
                        
                      </tr>
                      
                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a30" <?php echo $c30;?> value="1">
                        </td>
                        <td class=" ">Ventas</td>
                        <td class=" ">Lista de Notas Credito/Debito </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a5" <?php echo $c5;?> value="1">
                        </td>
                        <td class=" ">Usuarios</td>
                        <td class=" ">Lista de Usuarios </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center">
                          <input type="checkbox"  name="a27" <?php echo $c27;?> value="1">
                        </td>
                        <td class=" ">Usuarios</td>
                        <td class=" ">Accesos de Usuario </td>
                        
                      </tr>
                      
                      
                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a1" <?php echo $c1;?> value="1">
                        </td>
                        <td class=" ">Administracion</td>
                        <td class=" ">Empresa </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a20" <?php echo $c20;?> value="1">
                        </td>
                        <td class=" ">Administracion</td>
                        <td class=" ">Configuracion de Documentos </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a51" <?php echo $c51;?> value="1">
                        </td>
                        <td class=" ">Administracion</td>
                        <td class=" ">Salas </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a52" <?php echo $c52;?> value="1">
                        </td>
                        <td class=" ">Administracion</td>
                        <td class=" ">Mesas </td>
                        
                      </tr>
                    
                      
                       <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a3" <?php echo $c3;?> value="1">
                        </td>
                        <td class=" ">Administracion</td>
                        <td class=" ">Tiendas </td>
                        
                      </tr>

                      <tr class="even pointer">
                        <td class="a-center ">
                          <input type="checkbox"  name="a4" <?php echo $c4;?> value="1">
                        </td>
                        <td class=" ">Cambiar Tienda</td>
                        <td class=" ">Seleccionar otras tiendas </td>
                        
                      </tr>
                      
                       
                       
                      
                       
                      
                      
                      
                       
                      
                      
                </tbody>

                  </table>
                       
                   <button id="send" type="submit" name="enviar" class="btn btn-success">Cambiar</button>
                  </form>
                
                     
                
                </div>
              
      <?php 
      
   }
                      
                        ?> 
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
  
 
  <script type="text/javascript" src="js/autocomplete/countries.js"></script>
  <script src="js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->

  
  
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
  
  <script>
function seleccionar_todo(){ 
   for (i=0;i<document.f1.elements.length;i++) 
      if(document.f1.elements[i].type == "checkbox")	
         document.f1.elements[i].checked=1 
} 
function deseleccionar_todo(){ 
   for (i=0;i<document.f1.elements.length;i++) 
      if(document.f1.elements[i].type == "checkbox")	
         document.f1.elements[i].checked=0 
}

function disableOthers(field) {
disableCheck(formulario.dos, field);
disableCheck(formulario.tres, field);
}

</script>
  
<script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#example").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
});
</script>
 
 

<script type="text/javascript">
    
    $('#usuarios1').addClass("treeview active");
    $('#acceso').addClass("active");

</script>

</body>

</html>




