<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos  
require_once ("class/class.php");//Contiene funcion que conecta a la base de datos

$title="Disponibilidad";

$sql1="select * from users where user_id=$_SESSION[user_id]";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$modulo=$rs1["accesos"];
$sql2="select * from datosempresa where id_emp=1";
$rw2=mysqli_query($con,$sql2);//recuperando el registro
$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
$dolar=$rs2["dolar"];

$tienda1=$_SESSION['tienda'];
$sql3="select * from sucursal where tienda=$tienda1";
$rw3=mysqli_query($con,$sql3);//recuperando el registro
$rs3=mysqli_fetch_array($rw3);//trasformar el registro en un vector asociativo
$caja=$rs3["caja"];

$session_id=session_id();
$delete2=mysqli_query($con, "delete from tmp where session_id='".$session_id."'");
$a = explode(".", $modulo); 
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
   header("location: login.php");
    exit;
}
if($a[20]==0){
   header("location:error.php");    
   
}
if($caja==0){
    header("location:error1.php");    
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
      DISPONIBILIDAD
      <small>
        MESAS PARA VENTA
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
        DISPONIBILIDAD
      </li>
    </ol>
  </section>
  <!-- ContentH eader End -->
<section class="content">

<div class="row">

<div class="col-md-12">

	<div class="panel">
              <div class="panel-body">

<div id="cargaform">


                            <div class="col-sm-12">





<!-- Aquí todo el código para mesas y sillas -->                                         

                                                    <div class="row" id="salas-mesas">
                                                    
                        <ul class="nav nav-tabs tabs">
    <?php
    $sala = new Login();
    $sala = $sala->ListarSalas();
    if($sala==""){ echo "";      
    } else {
    for ($i = 0; $i < sizeof($sala); $i++) {
    ?>
    <?php if ($i === 0): ?>
    <li class="tab active">
    <?php else: ?>
    <li class="tab">
    <?php endif; ?>
        <a href="#<?php echo $sala[$i]['id_sala'];?>" data-toggle="tab" aria-expanded="true" role="tab" title="<?php echo $sala[$i]['nombre_sala'];?>">
            <span class="visible-xs"><i class="fa fa-building"></i></span>
            <span class="hidden-xs"><?php echo $sala[$i]['nombre_sala'];?></span>
        </a>
    </li>
    <?php
        }
    }
        ?>
</ul>
<div class="tab-content">
    <?php
        $sala = new Login();
        $sala = $sala->ListarSalas();
        if($sala==""){ echo "";      
        } else {
        for ($i = 0; $i < sizeof($sala); $i++) {
        ?>
    <?php if ($i === 0): ?>
    <div class="tab-pane active" id="<?php echo $sala[$i]['id_sala'];?>">
    <?php else: ?>
    <div class="tab-pane" id="<?php echo $sala[$i]['id_sala'];?>">
    <?php endif; ?>
        <?php
            $codigo_sala = $sala[$i]['id_sala'];
            ?>
        <p>
            <!--AQUI LISTO LAS MESAS -->
        <ul class="users-list clearfix" id="listMesas">
            <?php
                $mesa = new Login();
                $mesa = $mesa->ListarMesas();
                for ($ii = 0; $ii < sizeof($mesa); $ii++) {
                ?>
            <?php
                $id_mesa=$mesa[$ii]['id_mesa'];
                $nombre_mesa=$mesa[$ii]['nombre_mesa'];
                $status_mesa=$mesa[$ii]['status_mesa'];

                if ($mesa[$ii]['id_sala'] == $codigo_sala) {
                ?>
            <li style="display:inline;float: left; width: 125px;">
                
                

<a class="users-list-name codMesa" title="<?php echo $nombre_mesa; ?>" style="cursor:pointer;" href="<?php if ($status_mesa == '0'){ ?> nueva_factura.php?&id_mesa=<?php echo $id_mesa; ?> <?php } else { ?> 

<?php 
                
                $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM facturas WHERE is_applied=0 AND id_mesa=$id_mesa ORDER BY fecha_factura DESC");
                $row= mysqli_fetch_array($count_query);
                $numrows = $row['numrows'];

                $sql="SELECT * FROM  facturas WHERE is_applied=0 AND id_mesa=$id_mesa ORDER BY fecha_factura DESC";
                $query = mysqli_query($con, $sql);
                //loop through fetched data
                if ($numrows>0){

                while ($row=mysqli_fetch_array($query)){
                        $id_factura=$row['id_factura'];
                        $id_mesa=$row['id_mesa'];
                    ?>

    editar_factura.php?id_factura=<?php echo $id_factura; ?>&id_mesa=<?php echo $id_mesa; ?> 
    
    <?php } } ?>

    <?php } ?>">
                    <div id="<?php
                        echo $nombre_mesa;
                        ?>" style="width: 110px;height: 110px;background:<?php
                        if ($status_mesa == '0') {
                        ?>#00a65a;<?php
                        }
                        ?>#dd4b39;" class="miMesa"><?php if ($status_mesa == '0'){ ?><img src="assets/img/table.svg" style="padding:12px;margin:11px;float:left;width:90px;border-radius: 0px;"><?php } else { ?><img src="assets/img/tableB1.svg" style="padding:12px;margin:11px;float:left;width:90px;border-radius: 0px;"><?php } ?></div>
                    <center><strong><?php
                        echo $nombre_mesa;
                        ?></strong></center>
                </a>
            
            </li>
            <?php
                }
                ?>
            <?php
                }
                ?>
        </ul>
        <!--AQUI LISTO LAS MESAS FIN -->
        </p>
    </div>
    <?php
        }
    }
        ?>
</div>
</div>
<!-- Fin de todo el código para mesas y sillas -->


                                                    </div>

<br>
                                               
                    
                    </div>


	
	
<!-- Fin de todo el código para mesas y sillas -->


        
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
        $(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_categorias.php?action=ajax',
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="assets/itsolution24/img/loading2.gif">');
				 $('#loader').addClass('ajax-loader');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('#loader').removeClass('ajax-loader');
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar la categoria")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_categorias.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html('<img src="assets/itsolution24/img/loading2.gif">');
			$('#resultados').addClass('ajax-loader');
		  },
        success: function(datos){
		$("#resultados").html(datos);
		$('#resultados').removeClass('ajax-loader');
		load(1);
		}
			});
		}
		}
		

$( "#guardar_categoria" ).submit(function( event ) {
$('#guardar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_categoria.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax").html('<img src="assets/itsolution24/img/loading2.gif">');
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
      		$('#guardar_datos').html('Guardar datos');
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_categoria" ).submit(function( event ) {
$('#actualizar_datos').html('<i class="fa fa-refresh"></i> Verificando...');
$('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_categoria.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax2").html('<img src="assets/itsolution24/img/loading2.gif">');
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

	
	function obtener_datos(id){
			var nom_cat = $("#nom_cat"+id).val();
                        var des_cat = $("#des_cat"+id).val(); 
                        $("#mod_cat").val(nom_cat);
                        $("#mod_des").val(des_cat);
                        $("#mod_id").val(id);
		
		}
        
        
        
        
        </script>

<script type="text/javascript">
    
    //$('#usuarios1').addClass("treeview active");
    $('#disponibilidad').addClass("active");

</script>

</body>

</html>