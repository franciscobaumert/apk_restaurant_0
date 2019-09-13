<?php
$db_db='casaroyales';
$db_products = $db_db.'.products';  
$db_clientes = $db_db.'.clientes';
$db_users = $db_db.'.users';
$db_facturas = $db_db.'.facturas';
$db_categorias= $db_db.'.categorias';
$db_datosempresa = $db_db.'.datosempresa';
$db_sucursal= $db_db.'.sucursal';
$db_detalle_factura= $db_db.'.detalle_factura';
$db_documento = $db_db.'.documento';
$db_comprobante_pago= $db_db.'.comprobante_pago';
$db_sub_tipo= $db_db.'.sub_tipo';
$db_servicio= $db_db.'.servicio';
$db_consultas= $db_db.'.consultas';
$db_laborales= $db_db.'.laborales';
$db_fotos= $db_db.'.fotos';
$db_documento = $db_db.'.documento';
function conectar2()
{ 
$db = mysqli_connect('localhost', 'root', '');
    if (!$db) {
        print "<p>Imposible conectarse con la base de datos.</p>";
        exit();
    } else {
        return($db);
    }
}
function recoge1($var)
{
    $tmp = (isset($_REQUEST[$var])) ? trim(strip_tags($_REQUEST[$var])) : '';
    if (get_magic_quotes_gpc()) {
        $tmp = stripslashes($tmp);
    }
    $tmp = str_replace('&', '&amp;',  $tmp);
    $tmp = str_replace('"', '&quot;', $tmp);
    $tmp = str_replace('í', '&iacute;', $tmp);
    return $tmp;
}

function basededatos(){
  $base_de_datos='miempresaonline_restaurant00';
}

function menu1(){
    ?>    

           
             <!-- Main Sidebar Start -->
<aside class="main-sidebar">
  <section class="sidebar">

    <!--  Sidebar User Panel Start-->
    <div class="user-panel">
      <?php  
      $db_db='casaroyales';
      $db_users = $db_db.'.users';
      $db = conectar2();
      $consulta1 = "SELECT * FROM $db_users ";
      $result1 = mysqli_query($db, $consulta1);
      while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
          if($valor1['user_id']==$_SESSION['user_id']){
              $name=$valor1['user_name'];  
              $foto=$valor1['foto'];
          }    
      } 
      ?>
      <div class="pull-left image">
        <img src="images/<?php echo $foto;?>" >
      </div>
      <div class="pull-left info">
        <p class="username" title="">
          <?php echo $name; ?>
        </p>
        <a href="" onClick="return false;">
          <i class="fa fa-circle user-status-dot"></i> 
          ACTIVO 
        </a>
      </div>
    </div>  
    <!-- Sidebar User Panel End -->

    <!-- Sidebar Menu Start -->
    <?php $sql1="select * from $db_users where user_id=$_SESSION[user_id]";
          $rw1=mysqli_query($db,$sql1);//recuperando el registro
          $rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
          $modulo=$rs1["accesos"];
          $a = explode(".", $modulo); 
    ?>
    <ul class="sidebar-menu">
      <?php if($a[1]==1){ ?>
        <li class="" id="resumen">
        <a href="resumen.php">
          <svg class="svg-icon"><use href="#icon-dashboard"></svg>
          <span>
            TABLERO
          </span>
        </a>
      </li>
      <?php } ?>
      

      <?php if($a[20]==1){ ?>
        <li class="" id="disponibilidad">
          <a href="disponibilidad.php">
            <svg class="svg-icon"><use href="#icon-pos"></svg>
            <span>
              DISPONIBILIDAD
            </span>
          </a>
        </li>
      <?php } ?>
      
      <?php if($a[38]==1){ ?>
        <li class="" id="precuenta">
          <a href="precuenta.php">
            <svg class="svg-icon"><use href="#icon-invoice"></svg>
            <span>
              IMPRIMIR PRECUENTA
            </span>
          </a>
        </li>
      <?php } ?>
      
      <?php if($a[49]==1){ ?>
        <li class="" id="cerrar_mesas">
          <a href="cerrar_mesas.php">
            <svg class="svg-icon"><use href="#icon-invoice"></svg>
            <span>
              CERRAR MESAS
            </span>
          </a>
        </li>
      <?php } ?>
      
      <?php if($a[32]==1){ ?>
        <li class="" id="caja">
          <a href="caja.php">
            <svg class="svg-icon"><use href="#icon-box"></svg>
            <span>
              CAJA
            </span>
          </a>
        </li>
      <?php } ?>

      <?php if($a[17]==1){ ?>
        <li class="" id="clientes">
          <a href="clientes.php">
            <svg class="svg-icon"><use href="#icon-group"></svg>
            <span>
              CLIENTES
            </span>
          </a>
        </li>
      <?php } ?>

      <?php if($a[18]==1){ ?>
        <li class="" id="proveedores">
          <a href="proveedores.php">
            <svg class="svg-icon"><use href="#icon-supplier"></svg>
            <span>
              PROVEEDORES
            </span>
          </a>
        </li>
      <?php } ?>

      <?php if($a[11]==1 || $a[9]==1 || $a[12]==1 || $a[15]==1 || $a[16]==1){ ?>
        <li class="treeview" id="productos1">
          <a href="productos.php">
            <svg class="svg-icon"><use href="#icon-star"></svg>
            <span>
              PRODUCTOS
            </span> 
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
            <?php if($a[11]==1){ ?>
              <li class="" id="productos">
                <a href="productos.php">
                  
                  PRODUCTOS
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[9]==1){ ?>
              <li class="" id="categorias">
                <a href="categorias.php">
                  
                   CATEGORIAS
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[12]==1){ ?>
              <li class="" id="kardex">
                <a href="kardex.php">
                  
                  KARDEX
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[15]==1){ ?>
              <li class="" id="consultaproductos">
                <a href="consultaproductos.php">
                  
                  CONSULTAS
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[16]==1){ ?>
              <li class="" id="consultaprecios">
                <a href="consultaprecios.php">
                  
                  PRECIOS
                </a>
              </li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if($a[14]==1 || $a[13]==1){ ?>
        <li class="treeview" id="traslados">
          <a href="transferencia1.php">
            <svg class="svg-icon"><use href="#icon-transfer"></svg>
            <span>
              TRASLADOS
            </span> 
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
            <?php if($a[14]==1){ ?>
              <li class="" id="transferencia1">
                <a href="transferencia1.php">
                  
                  TRASLADOS
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[13]==1){ ?>
              <li class="" id="transferencia">
                <a href="transferencia">
                  
                   TRASLADAR
                </a>
              </li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>
      
      <?php if($a[33]==1 || $a[34]==1){ ?>
        <li class="treeview" id="compras1">
          
          <a href="compras.php">
            <svg class="svg-icon"><use href="#icon-money"></svg>
            <span>COMPRAS</span>
             <i class="fa fa-angle-left pull-right"></i>
           </a>
         
          <ul class="treeview-menu">
            
            <?php if($a[33]==1){ ?>
              <li class="" id="nueva_compras">
                <a href="nueva_compras.php">
                  
                  <span>
                    AÑADIR COMPRA
                  </span>
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[34]==1){ ?>
              <li class="" id="compras">
                <a href="compras.php">
                  
                  <span>
                    LISTA DE COMPRAS
                  </span>
                </a>
              </li>
            <?php } ?>

          </ul>
        </li>
      <?php } ?>

      
    <?php if($a[5]==1 || $a[35]==1 || $a[36]==1 || $a[37]==1 || $a[23]==1 || $a[24]==1 || $a[25]==1){ ?>
      <li class="" id="informes">
      
        <a href="masvendidos.php">
          <svg class="svg-icon"><use href="#icon-report"></svg>
          <span>INFORMES</span>
           <i class="fa fa-angle-left pull-right"></i>
         </a>
        

        <ul class="treeview-menu">
          
          <?php if($a[5]==1){ ?>
            <li class="" id="masvendidos">
              <a href="masvendidos.php">
                
                MAS VENDIDOS
              </a>
            </li>
          <?php } ?>

          <?php if($a[35]==1){ ?>
            <li class="" id="ventascompras">
              <a href="ventascompras.php">
                
                COMPRAS USUARIO
              </a>
            </li>
          <?php } ?>

          <?php if($a[36]==1){ ?>
            <li class="" id="ventasproveedor">
              <a href="ventasproveedor.php">
                
                COMPRAS PROVEEDOR
              </a>
            </li>
          <?php } ?>

          <?php if($a[37]==1){ ?>
            <li class="" id="resumencompras">
              <a href="resumencompras.php">
                
                RESUMEN COMPRAS
              </a>
            </li>
          <?php } ?>

          <?php if($a[23]==1){ ?>
            <li class="" id="ventasvendedor">
              <a href="ventasvendedor.php"> 
                
                VENTAS USUARIO
              </a>
            </li>
          <?php } ?>

          <?php if($a[24]==1){ ?>
            <li class="" id="ventasclientes">
              <a href="ventasclientes.php">
                
                <span>
                  VENTAS CLIENTE
                </span>
              </a>
            </li>
          <?php } ?>

          <?php if($a[25]==1){ ?>
            <li class="" id="resumenventas">
              <a href="resumenventas.php">
                
                <span>
                  RESUMEN VENTAS
                </span>
              </a>
            </li>
          <?php } ?>
          
        </ul>
      </li>
    <?php } ?>


      <?php if($a[30]==1 || $a[7]==1 || $a[6]==1 || $a[8]==1 || $a[31]==1){ ?>
        <li class="treeview">
          <a href="facturaelectronica.php">
            <svg class="svg-icon"><use href="#icon-bank"></svg>
            <span>
              FACT. ELECTRONICA
            </span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
            <?php if($a[30]==1){ ?>
              <li class="">
                <a href="conf_electronica">
                  
                  CONFIGURACION
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[7]==1){ ?>
              <li class="">
                <a href="facturaelectronica.php">
                  
                  DOC. ELECTRONICOS
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[6]==1){ ?>
              <li>
                <a href="resumen_documentos.php">
                  
                  RESUMEN DE BOLETAS
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[8]==1){ ?>
              <li class="">
                <a href="facturaseliminadas.php">
                  
                  COMUNICACION DE BAJA
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[31]==1){ ?>
              <li class="">
                <a href="listaguia.php">
                  
                  GUIA DE REMISION
                </a>
              </li>
            <?php } ?>
            
          </ul>
        </li>
      <?php } ?>

      <?php if($a[41]==1 || $a[40]==1){ ?>
        <li class="treeview">
          <a href="facturaelectronica.php">
            <svg class="svg-icon"><use href="#icon-expense"></svg>
            <span>
              CONTABILIDAD
            </span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
            <?php if($a[41]==1){ ?>
            <li class="">
              <a href="ventasgeneral.php">
                
                <span>
                  REGISTRO DE VENTAS
                </span>
              </a>
            </li>
          <?php } ?>
            
            <?php if($a[40]==1){ ?>
              <li class="">
                <a href="contabilidad.php">
                  
                  CALCULO DE IVA
                </a>
              </li>
            <?php } ?>
            
          </ul>
        </li>
      <?php } ?>

      <?php if($a[28]==1 || $a[22]==1 || $a[29]==1 || $a[39]==1){ ?>
        <li class="treeview">
          <a href="facturas.php">
            <svg class="svg-icon"><use href="#icon-money"></svg>
            <span>
              VENTAS
            </span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">

            <?php if($a[28]==1){ ?>
              <li class="">
                <a href="nueva_nota.php">
                  
                  GENERAR NOTA FACTURA
                </a>
              </li>
            <?php } ?>

            <?php if($a[39]==1){ ?>
              <li class="" id="nueva_notab">
                <a href="nueva_nota2.php">
                  
                  GENERAR NOTA BOLETA
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[22]==1){ ?>
              <li class="">
                <a href="facturas.php">
                  
                  VENTAS
                </a>
              </li>
            <?php } ?>

            <?php if($a[29]==1){ ?>
              <li class="">
                <a href="credito-debito.php">
                  
                  CREDITO - DEBITO
                </a>
              </li>
            <?php } ?>

          </ul>
        </li>
      <?php } ?>

      <?php if($a[4]==1 || $a[26]==1){ ?>
        <li class="treeview" id="usuarios1">
          <a href="usuarios.php">
            <svg class="svg-icon"><use href="#icon-user"></svg>
            <span>
              USUARIOS
            </span> 
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            
            <?php if($a[4]==1){ ?>
              <li class="" id="usuarios">
                <a href="usuarios.php">
                  
                  <span>
                    USUARIOS
                  </span>
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[26]==1){ ?>
              <li class="" id="acceso">
                <a href="acceso.php">
                  
                  <span>
                    ACCESOS
                  </span>
                </a>
              </li>
            <?php } ?>

          </ul>
        </li>
      <?php } ?>
      
      <?php if($a[0]==1 || $a[19]==1 || $a[50]==1 || $a[51]==1 || $a[2]==1){ ?>
        <li class="treeview">
          
          <a href="empresa.php">
            <svg class="svg-icon"><use href="#icon-settings"></svg>
            <span>
              ADMINISTRACION
            </span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          
          <ul class="treeview-menu">

            <?php if($a[0]==1){ ?>
              <li class="">
                <a href="empresa.php">
                  
                  <span>
                    EMPRESA
                  </span>
                </a>
              </li>
            <?php } ?>
            
            <?php if($a[19]==1){ ?>
              <li class="">
                <a href="documentos.php">
                  
                  <span>
                    DOCUMENTOS
                  </span>
                </a>
              </li>
            <?php } ?>

            <?php if($a[50]==1){ ?>
              <li class="">
                <a href="salas.php">
                  
                   SALAS
                </a>
              </li>
            <?php } ?>

            <?php if($a[51]==1){ ?>
              <li class="">
                <a href="mesas.php">
                  
                   MESAS
                </a>
              </li>
            <?php } ?>

            <?php if($a[2]==1){ ?>
              <li class="">
                <a href="sucursal.php">
                  
                  <span>
                    TIENDAS
                  </span>
                </a>
              </li>
            <?php } ?>

          </ul>
        </li>
      <?php } ?>
      
      <?php if($a[3]==1){ ?>
        <!--<li class="">
          <a href="seleccionartienda.php">
            <svg class="svg-icon"><use href="#icon-list"></svg>
            <span>
              CAMBIAR TIENDA
            </span>
          </a>
        </li>-->
      <?php } ?>
        
        <li class="">
          <a href="manual_casa_royales.pdf" target="_blank">
            <svg class="svg-icon"><use href="#icon-list"></svg>
            <span>
              MANUAL DE USUARIO
            </span>
          </a>
        </li>
      
      <li id="sidebar-bottom"></li>
    </ul>
    
  </section>
</aside>
<!-- Main Sidebar End -->
                
            


            <?php
}


?>




