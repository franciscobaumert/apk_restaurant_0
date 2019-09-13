<!-- Modal Cerrar Sesi&oacute;n -->
  <div class="modal fade bs-example-modal-lg" id="salir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Cerrar Sesi&oacute;n</h4>
        </div>
        <form method="post" id="addcategory" action="salir.php" role="form">
          <div class="modal-body">
            <div class="box-body">            
              <div class="form-group">
                <div class="input-group">
                  <p>¿Seguro que desea salir del sistema?</p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">S&iacute;, salir</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Fin Modal Cerrar Sesi&oacute;n -->

  <!-- Modal cambiar tienda -->
  <div class="modal fade bs-example-modal-lg" id="cambiar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Cambiar Local</h4>
        </div>
          <div class="modal-body">
            <div class="box-body">
              Desde aquí puedes cambiar locales o puntos de emisión.
              <br><br>
              <?php
              $host= $_SERVER["HTTP_HOST"];
              $url= $_SERVER["REQUEST_URI"];
              $a="http://".$host.$url;
              ?>
              <?php
              basededatos();
              $db_sucursal = $db_db.'.sucursal';
              $db = conectar2();
              $consulta1 = "SELECT * FROM $db_sucursal ";
              $result1 = mysqli_query($db, $consulta1);
              while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                  $tienda=$valor1['tienda'];
                  $nombre=$valor1['nombre'];
                  $dis_suc=$valor1['dis_suc'];

              
              ?>
              <li class="list-group-item">
                <a href="tienda.php?t=<?php echo $tienda;?>&a=<?php echo $a;?>">
              <div class="store-name">
                <?php if ($tienda==1) {
                  echo "Local Principal<br>(".$dis_suc.")";
                } else {
                  echo $nombre." <br>(".$dis_suc.")";
                } ?>
                <span class="pull-right">&rarr;</span>
              </div>
            </a>
          </li>
          <?php
             }
          ?>
            </div>
          </div>
      </div>
    </div>
  </div>
  <!-- Fin Modal cambiar tienda -->

<!-- Main Header Start -->  
<header class="main-header">
  <a href="resumen.php" class="logo">
    <span class="logo-mini">
      <b>
        C.
      </b>
        R.
    </span>
    <span class="logo-lg">
      <b>
        CASA ROYALES
      </b>
    </span>
  </a>
  <nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">#</span>
    </a>
    
    <!-- navbar custome menu start -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        
          
          <?php
          $id_sucursal=$_SESSION['tienda'];

          $sql_factura2=mysqli_query($con,"select * from sucursal where id_sucursal=".$id_sucursal."");
          $rw_factura2=mysqli_fetch_array($sql_factura2);
          $nombre=$rw_factura2['nombre'];
          $dis_suc=$rw_factura2['dis_suc'];
          ?>
          <li class="user user-menu sell-btn">
            <a data-toggle="modal" href="#cambiar" style="cursor: pointer;" title="TIENDA ACTUAL">
              <?php echo $nombre; ?> (<?php echo $dis_suc; ?>)
            </a>
          </li>

          
          <li class="user user-menu sell-btn">
            <a href="disponibilidad.php" title="PUNTO DE VENTA"> 
              <svg class="svg-icon"><use href="#icon-pos-black"></svg>
              <span class="text">
                DISPONIBILIDAD
              </span>
            </a>
          </li>
        
             
          
        
          <li class="user user-menu">
            <a href="facturaelectronica.php" title="LISTA DE VENTAS">
              <svg class="svg-icon"><use href="#icon-invoice-black"></svg>
              <span class="text">
                SUNAT
              </span>
            </a>
          </li>
        
      
        
        <li>
          <a id="togglingfullscreen" onClick="toggleFullScreenMode(); return false;" href="#" title="PANTALLA COMPLETA">
            <span class="fa fa-fw fa-expand"></span>
          </a>
        </li>
        <li class="user user-menu">
          <a data-toggle="modal" href="#salir" title="SALIR DEL SISTEMA">
            <i class="fa fa-sign-out"></i>
          </a>
        </li> 
      </ul>
    </div>
  </nav>
</header>
<!-- Main Header End --> 