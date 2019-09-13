	<?php
	session_start();
	include('menu.php');
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos

	$title="Calculo de IVA";

	$consulta1 = "SELECT * FROM users ";
	$result1 = mysqli_query($con, $consulta1);
	$usuario = array();
	$i=0;
	while ($valor1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {  
		$usuario[$i]=$valor1['nombres'];
		$i=$i+1;   
	}
	$sql1="select * from users where user_id=$_SESSION[user_id]";
	$rw1=mysqli_query($con,$sql1);//recuperando el registro
	$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
	$modulo=$rs1["accesos"];
	$sql2="select * from sucursal ORDER BY  `sucursal`.`tienda` DESC ";
	$rw2=mysqli_query($con,$sql2);//recuperando el registro
	$rs2=mysqli_fetch_array($rw2);//trasformar el registro en un vector asociativo
	$tienda1=$rs2["tienda"];
	$a = explode(".", $modulo); 
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
		header("location: login.php");
		exit;
	}
	if($a[40]==0){
	   header("location:error.php");    
	}
	?>
	<?php include ("header.php"); ?>

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

	menu1();

	?>


	<?php 
	$consulta2 = "SELECT * FROM consultas ";
	$result2 = mysqli_query($con, $consulta2);
	$d=0;
	$cliente="";
	$fecha1="";
	$fecha2="";
	$tienda=0;
	$tipo="";
	while ($valor1 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
		 if ($valor1['tipo']==6){
			  $d=$valor1['id'];
			  $tipo=$valor1['a1'];
			  //$nom_pro=trim($nom_pro1);
			  $fecha1=$valor1['a2'];
			  
			  $fecha2=$valor1['a3'];
			  $tiend=$valor1['a4'];
			  if($tiend==7){
				  $tienda1=1;
				  $tienda2=$tienda1;
			  }else{
				  $tienda1=$tiend;
				  $tienda2=$tiend;
			  }
			  
			  if ($fecha1<>""){
				$d1 = explode("-", $fecha1);
				$dia1=$d1[0]; 
				$mes1=$d1[1];
				$ano1=$d1[2];
			 }
			$dd1=$ano1."-".$mes1."-".$dia1;
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

	<div class="content-wrapper" ng-controller="DashboardController">

	<!-- Content Header Start -->
	  <section class="content-header">
		
		<h1>
		  REPORTE DE IGV
		  <small>
			GENERAL
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
			REPORTE DE IGV
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
				  REALIZAR REPORTE
				</h3>
			  </div>
			  <div class="box-body">
				<form   name="myForm" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="contabilidad1.php">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group hidden">
							<label>Nombre del usuario:</label>
							<select class="form-control col-md-10" name="tipo" required="required" tabindex="-1">
									<!--<option value="<?php echo $tipo;?>"><?php echo $tipo;?></option>-->
									<option value="Clientes">Clientes</option>
									<!--<option value="Vendedores">Vendedores</option>-->
																							 
								</select>
						   
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<label>Fecha Inicial:</label>
							<input   name="fecha1"  data-validate-length-range="4" type="date"  class="form-control col-md-10" style="float: left;" id="fecha1"   value="<?php echo $fecha1;?>" required>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
								<label>Fecha Final:</label>
								<input   name="fecha2"  data-validate-length-range="4" type="date"  class="form-control col-md-10" style="float: left;" id="fecha2"   value="<?php echo $fecha2;?>" required>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<label>Tienda:</label>
								<select class="form-control col-md-10" name="tienda" required="required" tabindex="-1">
								<?php
								if($tiend>0){
									if($tiend==7){
										$t="Todas";
									}else{
										$t="Tienda $tiend";
									}
									
									?>
								   <option value="<?php echo $tiend; ?>" ><?php echo $t; ?></option>
									<?php
								}else{
									  ?>
									<option value="" >Escoger</option>
									<?php  
									}
								 
								 for($i=1 ;$i<=$tienda1;$i++){
								?>
									<option value="<?php echo $i;?>" >Tienda <?php echo $i;?></option>              
								   <?php
								}                
								?>
							<option value="7" >Todas</option>                                                              
						</select>
					</div>
					<div class="ln_solid"></div>
					<input type="hidden" name="d" value="1">
						<button id="send" type="submit" name="enviar" class="btn btn-success">Buscar</button>
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
	$total1=0;
	$total2=0;
	$total3=0;
	$total4=0;
	$total5=0;
	if($d==0){
		$sql="";
	}else{
	$host= $_SERVER["HTTP_HOST"];
	$url= $_SERVER["REQUEST_URI"];
	$aa="http://".$host.$url;
	?>
	<div class="table-responsive">
		<table id="example" class="table table-bordered table-striped table-hover">
			<thead>
				<tr class="bg-gray">
					<th>N°</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Doc Cliente</th>
					<th>Doc</th>
					<th>Tipo Doc</th>
					<th>Tipo</th>
					<th class="info">Total Venta</th>
					<th class="info">IVA</th>
					<th class="danger">Total Compra</th>
					<th class="danger">IVA</th>
					<th class="warning">Total IVA</th>
				</tr>
			</thead>

			<tfoot>
				<tr class="bg-gray">
					<th>N°</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Doc Cliente</th>
					<th>Doc</th>
					<th>Tipo Doc</th>
					<th>Tipo</th>
					<th class="info">Total Venta</th>
					<th class="info">IVA</th>
					<th class="danger">Total Compra</th>
					<th class="danger">IVA</th>
					<th class="warning">Total IVA</th>
				</tr>
			</tfoot>

		<tbody>  
	 <?php   
	$sql="select * from facturas, clientes, users where facturas.id_cliente=clientes.id_cliente and facturas.id_vendedor=users.user_id and (facturas.ven_com=1 or facturas.ven_com=2) and facturas.activo=1 and estado_factura<=2 order by fecha_factura asc"; 
	$s=1;
	$rs=mysqli_query($con,$sql);
	while($row= mysqli_fetch_array($rs)){
		$id_cliente=$row['id_cliente'];
		$id_factura=$row['id_factura'];
		$numero_factura=$row['numero_factura'];
		$folio=$row['folio'];
		$tipo_doc=$row['estado_factura'];
		$doc_mod=$row['doc_mod'];
		$ven_com=$row['ven_com'];

		$total_venta=$row['total_venta'];
		
		//$estado_factura1=$row['estado_factura'];
		$condiciones=$row['condiciones'];
		if($tipo_doc==1){
			$tipo1="Factura";
		}
		if($tipo_doc==2){
			$tipo1="Boleta";
		}
		if($tipo_doc==3){
			$tipo1="Ticket";
		}
		if($tipo_doc==6){
			$tipo1="Nota de Credito";
		}

		if($condiciones==1){
		$estado2="Efectivo";
		}
		if($condiciones==2){
		$estado2="Cheque";

		}
		if($condiciones==3){
		$estado2="Transf Bancaria";
		}
		if($condiciones==4){
		$estado2="Crédito";
		}
		if($condiciones==5){
		$estado2="Visa";
		}
		if($condiciones==6){
		$estado2="MasterCard";
		}
		if($condiciones==7){
		$estado2="American Express";
		}
		if($condiciones==8){
		$estado2="Dinners Club";
		}

		


		$fecha3=$row['fecha_factura'];
		$d3 = explode("-",$fecha3);
		$dia=date("d",strtotime($fecha3)); 
		$mes=date("m",strtotime($fecha3));  
		$ano=$d3[0];
		$dd=$ano."/".$mes."/".$dia;
		$dd5=$dia."/".$mes."/".$ano;
		$fecha=strtotime($dd);
		$fech1=strtotime($dd1);
		$fech2=strtotime($dd2);
		$id_cliente1=$row['id_cliente'];
		$nombre_cliente=$row['nombre_cliente'];
		$doc=$row['documento']; 
		$vendedor1=$row['nombres'];
		$tienda=$row['tienda'];
		$nombre_vendedor=$row['user_name'];
		$estado_factura=$row['condiciones'];
		$moneda=$row['moneda'];
	//if ($condiciones<>4){$text_estado="Al contado";$label_class='label-success';}
	//else{$text_estado="Credito";$label_class='label-warning';}
		
		if($id_cliente==$id_cliente1  && $fecha>=$fech1 && $fecha<=$fech2 && $tienda>=$tienda1 && $tienda<=$tienda2){
			if($moneda==1){
				$total1=$total1+$total_venta;
				$mon="S/.";

				if ($ven_com==1) {
				  $total4=$total4+$total_venta;
				  $texto_tipo="Venta";
				}
				if ($ven_com==2) {
				  $total5=$total5+$total_venta;
				  $texto_tipo="Compra";
				}
			}
			$basimp = $total_venta / 1.18;
			$igv = $total_venta - $basimp;


			$totalbase1 = $total4 / 1.19;
			$totaligv1 = $total4 - $totalbase1;

			$totalbase2 = $total5 / 1.19;
			$totaligv2 = $total5 - $totalbase2;

			$totaligv3 = $totaligv1 - $totaligv2;

			?>
		<tr >
			<td class=" "><?php echo $s; ?></td>
			<td class=" "><?php print"$dd5";?></td>
			<td class=" "><?php echo utf8_decode($nombre_cliente);?></td>
			<td class=""><?php echo $doc; ?></td>
			<td class=" "><?php echo $folio;?>-<?php echo $numero_factura;?></td>
			<td class=" "><?php print"$tipo1";?></td>
			<td class=" "><?php echo $texto_tipo; ?></td>
			<td class="info" style="text-align: right;">
			  <?php
			  if ($ven_com==1) {
				 echo number_format(ceil($total_venta));
			   }  ?>
				
			  </td>
			<td class="info" style="text-align: right;">
			  <?php
			  if ($ven_com==1) {
				echo number_format ($igv,2);
			  }
			   ?>
				
			  </td>
			  <td class="danger" style="text-align: right;">
			  <?php
			  if ($ven_com==2) {
				 echo number_format(ceil($total_venta));
			   }  ?>
				
			  </td>
			<td class="danger" style="text-align: right;">
			  <?php
			  if ($ven_com==2) {
				echo number_format ($igv,2);
			  }
			   ?>
				
			  </td>
			  <td class="warning"> </td>
			
			
		</tr>                
		<?php
		$s=$s+1;
		}
	}                       
	?>
		</tbody>
			<?php 
			if($_SESSION['tabla']>0)        {
				?>
				
				<td></td><td></td><td></td><td></td><td></td><td></td><td><strong>Totales</strong></td><td style="color: blue; text-align: right;"><strong><?php echo number_format (ceil($total4));?></strong></td><td style="color: blue; text-align: right;"><strong><?php echo number_format (ceil($totaligv1));?></strong></td><td style="color: red; text-align: right;"><strong><?php echo number_format (ceil($total5));?></strong></td><td style="color: red; text-align: right;"><strong><?php echo number_format (ceil($totaligv2));?></strong></td><td style="color: green; text-align: right;"><strong><?php echo number_format (ceil($totaligv3));?></strong></td>
				
				<?php
			}
					  ?>
		</table>
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

	  <script type="text/javascript">
		$(function() {
		  'use strict';
			var data =[
			<?php
			for($i = 0;$i<count($usuario);$i++){
				?>
				'<?php echo $usuario[$i];?>',
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
			 "pageLength": -1,
			
		} );

	} );
	</script>
	</body>
	</html>