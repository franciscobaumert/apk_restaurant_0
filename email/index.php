<?php
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");


$id_factura= intval($_GET['id_factura']);

$sql_factura=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
$rw_factura=mysqli_fetch_array($sql_factura);
$id_cliente=$rw_factura['id_cliente'];

$tip=0;
$estado_factura1=$rw_factura['estado_factura'];
if($estado_factura1==1){
$tip="01";
}
if($estado_factura1==2){
$tip="03";
}
if($estado_factura1==6){
$tip="07";
}
if($estado_factura1==5){
$tip="08";
}
if($estado_factura1==10){
$tip="07";
}
if($estado_factura1==9){
$tip="08";
}
if($estado_factura1==3){
$tip="98";
}
if($estado_factura1==8){
$tip="97";
}

if($estado_factura1==1){
$estado1="Factura Electronica";

}
if($estado_factura1==2){
$estado1="Boleta Electronica";    
}
if($estado_factura1==3){
$estado1="Documento Interno";   
}
if($estado_factura1==5){
$estado1="Nota de Debito"; 
}
if($estado_factura1==6){
$estado1="Nota de Credito";    
}
if($estado_factura1==9){
$estado1="Nota de Debito"; 
}
if($estado_factura1==10){
$estado1="Nota de Credito";    
}
if($estado_factura1==8){
$estado1="Cotizacion";    
}

$folio=$rw_factura['folio'];
$numero_factura=$rw_factura['numero_factura'];
$total_venta=$rw_factura['total_venta'];
$fecha_factura=$rw_factura['fecha_factura'];
$numero_factura1=str_pad($numero_factura, 8, "0", STR_PAD_LEFT);


$sql_factura1=mysqli_query($con,"select * from clientes where id_cliente='".$id_cliente."'");
$rw_factura1=mysqli_fetch_array($sql_factura1);
$email=$rw_factura1['email_cliente'];
$nombre_cliente=$rw_factura1['nombre_cliente'];
$telefono_cliente=$rw_factura1['telefono_cliente'];

$sql_factura2=mysqli_query($con,"select * from datosempresa where id_emp=1");
$rw_factura2=mysqli_fetch_array($sql_factura2);
$nom_emp=$rw_factura2['nom_emp'];

$sql_factura3=mysqli_query($con,"select * from sucursal where id_sucursal=1");
$rw_factura3=mysqli_fetch_array($sql_factura3);
$rucsuc=$rw_factura3['ruc'];

$datospdf="$rucsuc-$tip-$folio-$numero_factura1.pdf";

$doc1="$rucsuc-$tip-$folio-$numero_factura1.XML";

$link="https://demo.developer-technology.com/facturacion/pdf/documentos/ver_factura.php?id_factura=$id_factura";
$xml="https://demo.developer-technology.com/facturacion/pdf/documentos/factura-firmada/$doc1";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>.:: Enviar Correo | Developer Technology ::.</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/noui/nouislider.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<form method="post" class="contact100-form validate-form" autocomplete="off">

				<span class="contact100-form-title">
					<?php echo $folio; ?>-<?php echo $numero_factura1; ?>
				</span>

				<?php
					if (isset($_POST['send'])){
						include("sendemail.php");//Mando a llamar la funcion que se encarga de enviar el correo electronico
						
						/*Configuracion de variables para enviar el correo*/
						$mail_username="info@developer-technology.com";//Correo electronico saliente ejemplo: tucorreo@gmail.com
						$mail_userpassword="2Q85Oqxy4y";//Tu contrase単a de gmail
						$mail_addAddress=$_POST['customer_email'];//correo electronico que recibira el mensaje
						$template="email_template.html";//Ruta de la plantilla HTML para enviar nuestro mensaje
						
						/*Inicio captura de datos enviados por $_POST para enviar el correo */
						$mail_setFromEmail="info@developer-technology.com";//tu correo de gmail
						$mail_setFromName=$nom_emp;//nombre
						$txt_message="Sres.: ".$nombre_cliente.".<br><br>

						".$nom_emp." le envía su ".$estado1.":<br><br>
						
						- Tipo: ".$estado1."<br>
						- Serie: ".$folio."<br>
						- Número: ".$numero_factura1."<br>
						- Fecha de emision: ".$fecha_factura."<br>
						- Total: S/.".$total_venta." <br><br>

						Se adjuntan el archivo PDF y la firma XML en este correo.<br><br>";//mensaje
						$mail_subject=$estado1." | ".$folio."-".$numero_factura." | ".$nom_emp;

						$doc1;
						$datospdf;
						
						sendemail($mail_username,$mail_userpassword,$mail_setFromEmail,$mail_setFromName,$mail_addAddress,$txt_message,$mail_subject,$doc1,$datospdf,$template);//Enviar el mensaje
					}
				?>

				<div class="wrap-input100 validate-input bg1" data-validate = "Ingrese un correo valido (e@a.x)">
					<span class="label-input100">Correo *</span>
					<input class="input100" type="text" name="customer_email" placeholder="Correo donde se enviara la factura" value="<?php echo $email;?>" onKeyUp="this.value=this.value.toUpperCase();">
				</div>		

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn" type="submit" name="send">
						<span>
							Enviar Documento
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
				</div>
			</form>
		</div>
	</div>



<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});


			$(".js-select2").each(function(){
				$(this).on('select2:close', function (e){
					if($(this).val() == "Please chooses") {
						$('.js-show-service').slideUp();
					}
					else {
						$('.js-show-service').slideUp();
						$('.js-show-service').slideDown();
					}
				});
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="vendor/noui/nouislider.min.js"></script>
	<script>
	    var filterBar = document.getElementById('filter-bar');

	    noUiSlider.create(filterBar, {
	        start: [ 1500, 3900 ],
	        connect: true,
	        range: {
	            'min': 1500,
	            'max': 7500
	        }
	    });

	    var skipValues = [
	    document.getElementById('value-lower'),
	    document.getElementById('value-upper')
	    ];

	    filterBar.noUiSlider.on('update', function( values, handle ) {
	        skipValues[handle].innerHTML = Math.round(values[handle]);
	        $('.contact100-form-range-value input[name="from-value"]').val($('#value-lower').html());
	        $('.contact100-form-range-value input[name="to-value"]').val($('#value-upper').html());
	    });
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

</body>
</html>