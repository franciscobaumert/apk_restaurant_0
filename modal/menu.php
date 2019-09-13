<?php
//$db_db='simple_invoice';

$db_db='akadeg3r_sistema';
function conectar2()
{

    //$db = mysqli_connect('localhost','akadeg3r_usuario','jocelyn2016');
 $db = mysqli_connect('localhost', 'akadeg3r_usuario', 'jocelyn2016');
    if (!$db) {
        //cabecera('Error grave', 'menu_principal');
        print "<p>Imposible conectarse con la base de datos.</p>";
     
        exit();
    } else {
        return($db);
    }

}


$db_products = $db_db.'.products';


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


function menu1(){
    ?>
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                
                
                <li><a><i class="fa fa-lock"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      <li><a href="usuarios.php">Usuarios</a>
                    </li>
                   
                    
                  </ul>
                </li>
                
                <li><a><i class="fa fa-barcode"></i> Productos <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      <li><a href="categorias.php">Categorias</a>
                    </li>
                    <li><a href="productos.php">Productos</a>
                    </li>
                    
                     <li><a href="servicios.php">Servicios</a>
                    </li>
                    
                    
                    <li><a href="consultaproductos.php">Consultas</a>
                    </li>
                    
                  </ul>
                </li>
                
                <li><a><i class="fa fa-truck"></i> Proveedores <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      <li><a href="proveedores.php">Proveedores</a>
                    </li>
                    
                    
                  </ul>
                </li>
                
                
                
                
                <li><a><i class="fa fa-user"></i> Clientes <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                      <li><a href="clientes.php">Clientes</a>
                    </li>
                   
                    
                  </ul>
                </li>
                
                <li><a><i class="fa fa-list-alt"></i> Ventas <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    
                      <li><a href="nueva_factura.php">Factura/Boleta</a>
                          
                    </li>
                    
                    
                    
                    <li><a href="facturas.php">Consultas</a>
                          
                    </li>
                    
                    <li><a href="ventasvendedor.php">Ventas por vendedor</a>
                          
                    </li>
                    
                     <li><a href="ventasclientes.php">Ventas por cliente</a>
                    </li>
                    <li><a href="resumenventas.php">Resumen Ventas</a>
                     <li><a href="cobros.php">Ventas por Cobrar</a></li>
                       <li><a href="cobrosclientes.php">Consulta de cobro de Ventas</a></li>   
                     
                    </li>
                  </ul>
                </li>
                
                <li><a><i class="fa fa-shopping-cart"></i> Compras <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    
                      <li><a href="nueva_compras.php">Factura/Boleta</a></li>
                          
                    
                    <li><a href="compras.php">Consultas</a></li>
                    <li><a href="ventascompras.php">Compras por Vendedor</a></li>
                    <li><a href="ventasproveedor.php">Compras por Proveedor</a></li>
                     <li><a href="resumencompras.php">Resumen Compras</a>
                    <li><a href="pagos.php">Compras por Pagar</a></li>
                      <li><a href="pagosproveedores.php">Consulta de pago de compras</a></li> 
                    
                    
                    
                    </li>
                  </ul>
                </li>
              <!--  
                
                 <li><a><i class="fa fa-building"></i> Cuentas por pagar<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    
                          <li><a href="otrospagos.php">Otros Pagos</a></li>  
                    
                    
                    </li>
                  </ul>
                </li>
                
                
                 <li><a><i class="fa fa-calculator"></i>Cuentas por cobrar <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    <li><a href="otroscobros.php">Cobros</a></li>
                     
                    
                    
                    </li>
                  </ul>
                </li>
                -->
                
                
              <li><a><i class="fa fa-laptop"></i> Balance <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    
                    
                      <li><a href="balance.php">Balance</a></li>
                          
                    
                   
                    </li>
                  </ul>
                </li>
                
                
                
                
              </ul>
            </div>
            

          </div>
            <?php
}



function menu2(){
    ?>
     <div class="profile">
            <div class="profile_pic">
              <img src="images/user.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Bienvenido</span>
              <?php
              $db_db='simple_invoice';
              $db_users = $db_db.'.users';
$db = conectar2();
$consulta1 = "SELECT * FROM $db_users ";
$result1 = mysqli_query($db, $consulta1);

while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    
    if($valor1['user_id']==$_SESSION['user_login_status']){
    $name=$valor1['firstname']." ".$valor1['lastname'];    
    }
    
    
    
}
              
              ?>
              
              
              <h2><?php echo $name;   ?></h2>
            </div>
          </div>
            <?php
}


function menu3(){
    ?>
    <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <img src="images/tienda.jpg" alt="">Tienda<?php echo $_SESSION['tienda']; ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                  <li><a href="javascript:;">  Tienda 1</a>
                  </li>
                  
                  <li>
                    <a href="javascript:;">Tienda 2</a>
                  </li>
                  <li><a href="login.html"> Tienda 3</a>
                  </li>
                </ul>
              </li>

              

            </ul>
          </nav>
        </div>

      </div>
            <?php
}




function footer(){
    ?>
<footer>
          <div class="copyright-info">
            <p class="pull-right">Sistemas Velazco.
            </p>
          </div>
          <div class="clearfix"></div>
        </footer>

<?php } ?>




