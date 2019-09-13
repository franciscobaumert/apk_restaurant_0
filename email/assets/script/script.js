/*
Author: Ing. Ruben D. Chirinos R.
URL: http://asesoramientopc.hol.es/
*/

/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/
$('document').ready(function()
{ 
						   
	 $("#loginform").validate({
      rules:
	  {
			usuario: { required: true, },
			password: { required: true, },
	   },
       messages:
	   {
		    usuario:{  required: "Por favor ingrese su Usuario" },
			password:{  required: "Por favor ingrese su Clave de Acceso" },
       },
	   errorElement: "span",
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm()
	   {		
			var data = $("#loginform").serialize();
				
			$.ajax({
				
			type : 'POST',
			url  : 'index.php',
			data : data,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-login").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(response)
			   {						
					if(response=="ok"){
									
						$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
						setTimeout(' window.location.href = "panel.php"; ',4000);
					}
					else{
				
				$("#error").fadeIn(1000, function(){	
				$("#error").html('<center><strong> '+response+' </strong></center>');
				setTimeout(function() { $("#error").html(""); }, 5000);
				$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
									});
					}
			  }
			});
				return false;
		}
	   /* login submit */
});




/* FUNCION JQUERY PARA VALIDAR DESBLOQUEAR CUENTA DE ACCESO*/
$('document').ready(function()
{ 
						   
	 $("#desbloquear").validate({
      rules:
	  {
			usuario: { required: true, },
			password: { required: true, },
	   },
       messages:
	   {
		    usuario:{  required: "Por favor ingrese su Usuario" },
			password:{  required: "Por favor ingrese su Clave de Acceso" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm()
	   {		
			var data = $("#desbloquear").serialize();
				
			$.ajax({
				
			type : 'POST',
			url  : 'login.php',
			data : data,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-login").html(' Verificando...');
			},
			success :  function(response)
			   {						
					if(response=="ok"){
									
						$("#btn-login").html('<i class="fa"></i> Acceder');
						setTimeout(' window.location.href = "panel.php"; ',4000);
					}
					else{
				
				$("#error").fadeIn(1000, function(){	
				$("#error").html('<center><strong> '+response+' </strong></center>');
				setTimeout(function() { $("#error").html(""); }, 5000);
				$("#btn-login").html('<i class="fa"></i> Acceder');
									});
					}
			  }
			});
				return false;
		}
	   /* login submit */
});















/* FUNCION JQUERY PARA RECUPERAR CONTRASEÑA DE USUARIOS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	$("#recuperarpassword").validate({
      rules:
	  {
			email: { required: true,  email: true  },
	   },
       messages:
 	   {
			email:{  required: "Ingrese su Correo Electronico", email: "Ingrese un Correo Electronico Valido" },
       },
	   errorElement: "span",
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	    /* form submit */
	  function submitForm()
	   {		
				var data = $("#recuperarpassword").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'index.php',
				data : data,
				beforeSend: function()
				{	
					$("#errorr").fadeOut();
					$("#btn-recuperar").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error2").fadeIn(1000, function(){
											
											
	$("#errorr").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
											$("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Clave');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#errorr").fadeIn(1000, function(){
											
											
	$("#errorr").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> EL CORREO INGRESADO NO FUE ENCONTRADO ACTUALMENTE !</div></center>');
												
					$("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Clave');
										
									});
								}
								else{
										
									$("#errorr").fadeIn(1000, function(){
											
						$("#errorr").html('<center> &nbsp; '+data+' </center>');
						$("#recuperarpassword")[0].reset();
						setTimeout(function() { $("#errorr").html(""); }, 5000);	
						$("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Clave');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
   
	   
});

/*  FIN DE FUNCION PARA RECUPERAR CONTRASEÑA DE USUARIOS */




/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASEÑA */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updatepassword").validate({
      rules:
	  {
			password: {required: true, minlength: 8},  
            password2:   {required: true, minlength: 8, equalTo: "#password"}, 
	   },
       messages:
	   {
            password:{ required: "Ingrese su Nuevo Password", minlength: "Ingrese 8 caracteres como minimo" },
		    password2:{ required: "Repita su Nuevo Password", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
           
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatepassword").serialize();
				var id= $("#updatepassword").attr("data-id");
		        var codigo = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'password.php?codigo='+codigo,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
											$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#updatepassword")[0].reset();
						setTimeout(function() { $("#error").html(""); }, 5000);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
});

 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASEÑA */
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 












 
 
 




/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CLIENTES */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#configuracion").validate({
      rules:
	  {
			rifempresa: { required: true, digits : true, maxlength: 11 },
			nomempresa: { required: true, lettersonly: true },
			direcempresa: { required: true},
			tlfempresa: { required: true },
			cedresponsable: { required: true, digits : true, maxlength: 8 },
			nomresponsable: { required: true, lettersonly: true},
			correoresponsable: { required: true,  email : true },
			tlfresponsable: { required: true },
			ivac: { required: true, number: true },
			ivav: { required: true,  number : true },
	   },
       messages:
	   {
            rifempresa:{ required: "Ingrese RUC de Empresa", digits: "Ingrese solo digitos para RUC", maxlength: "Ingrese 11 digitos como m&aacute;ximo"},
			nomempresa:{ required: "Ingrese Nombre de Empresa", lettersonly: "Ingrese solo letras" },
			direcempresa:{ required: "Ingrese Direcci&oacute;n de Empresa" },
			tlfempresa: { required: "Ingrese N&deg; de Telefono de Empresa" },
			cedresponsable:{ required: "Ingrese DNI de Responsable", digits: "Ingrese solo digitos para DNI", maxlength: "Ingrese 8 digitos como m&aacute;ximo"},
			nomresponsable:{ required: "Ingrese Nombre de Responsable", lettersonly: "Ingrese solo letras para Nombre" },
			correoresponsable: { required: "Ingrese Correo de Responsable", email: "Ingrese un correo valido" },
			tlfresponsable: { required: "Ingrese N&deg; de Telefono de Responsable" },
			ivac: { required: "Ingrese Iva para Compras", number: "Ingrese solo numeros con dos decimales para Iva" },
			ivav:{ required: "Ingrese Iva para Ventas", number: "Ingrese solo numeros con dos decimales para Iva" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#configuracion").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forconfiguracion.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UNA EMPRESA REGISTRADA COMO RUC PRINCIPAL, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE RUC YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#configuracion")[0].reset();
					            	setTimeout(function() { $("#error").html(""); }, 5000); 					
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CLIENTES */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION GENERAL */	 	 
$('document').ready(function()
{ 					
     /* validation */
	 $("#updateconfiguracion").validate({
      rules:
	  {
			rifempresa: { required: true, digits : true, maxlength: 11 },
			nomempresa: { required: true, lettersonly: true },
			direcempresa: { required: true},
			tlfempresa: { required: true },
			cedresponsable: { required: true, digits : true, maxlength: 8 },
			nomresponsable: { required: true, lettersonly: true},
			correoresponsable: { required: true,  email : true },
			tlfresponsable: { required: true },
			ivac: { required: true, number: true },
			ivav: { required: true,  number : true },
	   },
       messages:
	   {
            rifempresa:{ required: "Ingrese RUC de Empresa", digits: "Ingrese solo digitos para RUC", maxlength: "Ingrese 11 digitos como m&aacute;ximo"},
			nomempresa:{ required: "Ingrese Nombre de Empresa", lettersonly: "Ingrese solo letras" },
			direcempresa:{ required: "Ingrese Direcci&oacute;n de Empresa" },
			tlfempresa: { required: "Ingrese N&deg; de Telefono de Empresa" },
			cedresponsable:{ required: "Ingrese DNI de Responsable", digits: "Ingrese solo digitos para DNI", maxlength: "Ingrese 8 digitos como m&aacute;ximo"},
			nomresponsable:{ required: "Ingrese Nombre de Responsable", lettersonly: "Ingrese solo letras para Nombre" },
			correoresponsable: { required: "Ingrese Correo de Responsable", email: "Ingrese un correo valido" },
			tlfresponsable: { required: "Ingrese N&deg; de Telefono de Responsable" },
			ivac: { required: "Ingrese Iva para Compras", number: "Ingrese solo numeros con dos decimales para Iva" },
			ivav:{ required: "Ingrese Iva para Ventas", number: "Ingrese solo numeros con dos decimales para Iva" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateconfiguracion").serialize();
				var id= $("#updateconfiguracion").attr("data-id");
		        var id = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'configuracion.php?id='+id,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
											$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UNA EMPRESA REGISTRADA COMO RUC PRINCIPAL, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==3){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE RUC YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{	
											
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						setTimeout(function() { $("#error").html(""); }, 5000);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
						
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
	   
});

 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION GENERAL */
 
 






















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE USUARIOS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#usuario").validate({
      rules:
	  {
			cedula: { required: true,  digits : true, minlength: 7 },
			nombres: { required: true, lettersonly: true },
			sexo: { required: true, },
			cargo: { required: true, },
			email: { required: true, email: true },
			telefono: { required: false, digits : false  },
			usuario: { required: true, },
			password: {required: true, minlength: 8},  
            password2:   {required: true, minlength: 8, equalTo: "#password"}, 
			nivel: { required: true, },
			status: { required: true, },
	   },
       messages:
	   {
           cedula:{ required: "Ingrese C&eacute;dula de Usuario", digits: "Ingrese solo digitos para C&eacute;dula", minlength: "Ingrese 7 digitos como minimo" },
			nombres:{ required: "Ingrese Nombre Completo de Usuario" },
            sexo:{ required: "Seleccione Sexo de Usuario" },
			cargo: { required: "Ingrese Cargo de Usuario" },
			email:{  required: "Ingrese Email de Usuario", email: "Ingrese un Email Valido" },
			telefono: { required: "Ingrese N&deg; de Telefono de Usuario", digits: "Ingrese solo digitos" },
			usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Password de Acceso", minlength: "Ingrese 8 caracteres como minimo" },
		    password2:{ required: "Repita Password de Acceso", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
			nivel:{ required: "Seleccione Nivel de Acceso" },
			status:{ required: "Seleccione Status" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#usuario").serialize();
				var formData = new FormData($("#usuario")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'forusuario.php',
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}  
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN USUARIO CON ESTE NUMERO DE C&Eacute;DULA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==3){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CORREO ELECTRONICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#usuario")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
   
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE USUARIOS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE USUARIOS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updateusuario").validate({
      rules:
	  {
			cedula: { required: true,  digits : true, minlength: 7 },
			nombres: { required: true, lettersonly: true },
			sexo: { required: true, },
			cargo: { required: true, },
			email: { required: true, email: true },
			telefono: { required: true, digits : false  },
			usuario: { required: true, },
			password: {required: true, minlength: 8},  
            password2:   {required: true, minlength: 8, equalTo: "#password"}, 
			nivel: { required: true, },
			status: { required: true, },
	   },
       messages:
	   {
           cedula:{ required: "Ingrese C&eacute;dula de Usuario", digits: "Ingrese solo digitos para C&eacute;dula", minlength: "Ingrese 7 digitos como minimo" },
			nombres:{ required: "Ingrese Nombre Completo de Usuario" },
            sexo:{ required: "Seleccione Sexo de Usuario" },
			cargo: { required: "Ingrese Cargo de Usuario" },
			email:{  required: "Ingrese Email de Usuario", email: "Ingrese un Email Valido" },
			telefono: { required: "Ingrese N&deg; de Telefono de Usuario", digits: "Ingrese solo digitos" },
			usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Password de Acceso", minlength: "Ingrese 8 caracteres como minimo" },
		    password2:{ required: "Repita Password de Acceso", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
			nivel:{ required: "Seleccione Nivel de Acceso" },
			status:{ required: "Seleccione Status" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateusuario").serialize();
				var id= $("#updateusuario").attr("data-id");
		        var codcatalogo = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forusuario.php?codigo='+codigo,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}  
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN USUARIO CON ESTE NUMERO DE C&Eacute;DULA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==3){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CORREO ELECTRONICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='usuarios'", 5000);
				
						
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});

 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE USUARIOS */








































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE FAMILIAS */	 	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#familias").validate({
      rules:
	  {
			nomfamilia: { required: true, },
	   },
       messages:
	   {
			nomfamilia:{ required: "Ingrese Nombre de Familia" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#familias").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forfamilia.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE FAMILIA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#familias")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE FAMILIAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE FAMILIAS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updatefamilia").validate({
      rules:
	  {
			codfamilia: { required: true, },
			nomfamilia: { required: true, },
	   },
       messages:
	   {
            codfamilia:{ required: "Ingrese C&oacute;digo de Familia" },
			nomfamilia:{ required: "Ingrese Nombre de Familia" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatefamilia").serialize();
				var id= $("#updatefamilia").attr("data-id");
		        var codfamilia = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forfamilia.php?codfamilia='+codfamilia,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE FAMILIA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='familias'", 5000);
				
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE FAMILIAS */









































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE SUBFAMILIAS */	 	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#subfamilia").validate({
      rules:
	  {
			nomsubfamilia: { required: true, },
			codfamilia: { required: true, },
	   },
       messages:
	   {
			nomsubfamilia:{ required: "Ingrese Nombre de Subfamilia" },
			codfamilia:{ required: "Seleccione Nombre de Familia" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#subfamilia").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forsubfamilia.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE SUBFAMILIA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#subfamilia")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE SUBFAMILIAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE SUBFAMILIAS */	 	 
$('document').ready(function()
{ 						
     /* validation */
	 $("#updatefamilia").validate({
      rules:
	  {
			nomsubfamilia: { required: true, },
			codfamilia: { required: true, },
	   },
       messages:
	   {
			nomsubfamilia:{ required: "Ingrese Nombre de Subfamilia" },
			codfamilia:{ required: "Seleccione Nombre de Familia" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatesubfamilia").serialize();
				var id= $("#updatesubfamilia").attr("data-id");
		        var codsubfamilia = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forsubfamilia.php?codsubfamilia='+codsubfamilia,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE SUBFAMILIA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='subfamilias'", 5000);
				
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE SUBFAMILIAS */






































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MARCAS */	 	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#marcas").validate({
      rules:
	  {
			nommarca: { required: true, },
	   },
       messages:
	   {
			nommarca:{ required: "Ingrese Nombre de Marca" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#marcas").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'formarca.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE MARCA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#marcas")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE MARCAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE MARCAS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updatemarca").validate({
      rules:
	  {
			codmarca: { required: true, },
			nommarca: { required: true, },
	   },
       messages:
	   {
            codmarca:{ required: "Ingrese C&oacute;digo de Marca" },
			nommarca:{ required: "Ingrese Nombre de Marca" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatemarca").serialize();
				var id= $("#updatemarca").attr("data-id");
		        var codmarca = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'formarca.php?codmarca='+codmarca,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE MARCA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='marcas'", 5000);
				
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE MARCAS */









































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MODELOS */	 	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#modelos").validate({
      rules:
	  {
			nommodelo: { required: true, },
			codmarca: { required: true, },
	   },
       messages:
	   {
			nommodelo:{ required: "Ingrese Nombre de Modelo" },
			codmarca:{ required: "Seleccione Nombre de Marca" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#modelos").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'formodelo.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE MODELO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#modelos")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE MODELOS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE MODELOS */	 	 
$('document').ready(function()
{ 						
     /* validation */
	 $("#updatemodelo").validate({
      rules:
	  {
			nommodelo: { required: true, },
			codmarca: { required: true, },
	   },
       messages:
	   {
			nommodelo:{ required: "Ingrese Nombre de Modelo" },
			codmarca:{ required: "Seleccione Nombre de Marca" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatemodelo").serialize();
				var id= $("#updatemodelo").attr("data-id");
		        var codmodelo = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'formodelo.php?codmodelo='+codmodelo,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE MODELO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='modelos'", 5000);
				
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE MODELOS */






































 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRESENTACIONES */	 
 
$('document').ready(function()
{ 						
     /* validation */
	 $("#presentacion").validate({
      rules:
	  {
			nompresentacion: { required: true, },
	   },
       messages:
	   {
			nompresentacion:{ required: "Ingrese Nombre de Presentaci&oacute;n" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#presentacion").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forpresentacion.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE PRESENTACI&Oacute;N YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#presentacion")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PRESENTACIONES */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRESENTACIONES */	 	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updatepresentacion").validate({
      rules:
	  {
			codpresentacion: { required: true, },
			nompresentacion: { required: true, },
	   },
       messages:
	   {
            codpresentacion:{ required: "Ingrese C&oacute;digo de Presentaci&oacute;n" },
			nompresentacion:{ required: "Ingrese Nombre de Presentaci&oacute;n" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatepresentacion").serialize();
				var id= $("#updatepresentacion").attr("data-id");
		        var codpresentacion = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forpresentacion.php?codpresentacion='+codpresentacion,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE PRESENTACI&Oacute;N YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='presentaciones'", 5000);
						
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */  
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRESENTACIONES */
 







































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ORIGENES */	 	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#origenes").validate({
      rules:
	  {
			nomorigen: { required: true, },
	   },
       messages:
	   {
			nomorigen:{ required: "Ingrese Nombre de Origen" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#origenes").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'fororigen.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE ORIGEN YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#origenes")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ORIGENES */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ORIGENES */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updateorigen").validate({
      rules:
	  {
			codorigen: { required: true, },
			nomorigen: { required: true, },
	   },
       messages:
	   {
            codorigen:{ required: "Ingrese C&oacute;digo de Origen" },
			nomorigen:{ required: "Ingrese Nombre de Origen" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateorigen").serialize();
				var id= $("#updateorigen").attr("data-id");
		        var codorigen = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'fororigen.php?codorigen='+codorigen,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE ORIGEN YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='origenes'", 5000);
				
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ORIGENES */







































 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE ZONAS */	 
 
$('document').ready(function()
{ 						
     /* validation */
	 $("#zona").validate({
      rules:
	  {
			nomzona: { required: true, },
	   },
       messages:
	   {
			nomzona:{ required: "Ingrese Nombre de Zona" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#zona").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forzona.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE ZONA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#zona")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ZONAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ZONAS */	 	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updatezona").validate({
      rules:
	  {
			codzona: { required: true, },
			nomzona: { required: true, },
	   },
       messages:
	   {
            codzona:{ required: "Ingrese C&oacute;digo de Zona" },
			nomzona:{ required: "Ingrese Nombre de Zona" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatezona").serialize();
				var id= $("#updatezona").attr("data-id");
		        var codzona = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forzona.php?codzona='+codzona,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE ZONA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='zonas'", 5000);
						
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */  
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ZONAS */
 















































 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE GRUPOS DE CLIENTES */	 
 
$('document').ready(function()
{ 						
     /* validation */
	 $("#grupo").validate({
      rules:
	  {
			nomgrupo: { required: true, },
	   },
       messages:
	   {
			nomgrupo:{ required: "Ingrese Nombre de Grupo de Cliente" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#grupo").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forgrupocliente.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE GRUPO DE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#grupo")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE GRUPOS DE CLIENTES */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE GRUPOS DE CLIENTES */	 	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updategrupo").validate({
      rules:
	  {
			codgrupo: { required: true, },
			nomgrupo: { required: true, },
	   },
       messages:
	   {
            codgrupo:{ required: "Ingrese C&oacute;digo de Grupo de Cliente" },
			nomgrupo:{ required: "Ingrese Nombre de Grupo de Cliente" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updategrupo").serialize();
				var id= $("#updategrupo").attr("data-id");
		        var codgrupo = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forgrupocliente.php?codgrupo='+codgrupo,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE GRUPO DE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='grupoclientes'", 5000);
						
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */  
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE GRUPOS DE CLIENTES */











































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE FORMAS DE PAGO SRI */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#formasri").validate({
      rules:
	  {
			codformapago: { required: true, },
			nomformapago: { required: true, },
	   },
       messages:
	   {
            codformapago:{  required: "Ingrese C&oacute;digo de Pago SRI" },
            nomformapago:{  required: "Ingrese Nombre de Forma de Pago SRI" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#formasri").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forpagosri.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CODIGO DE FORMA DE PAGO SRI YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA NOMBE DE FORMA DE PAGO SRI YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#formasri")[0].reset();
						            setTimeout(function() { $("#error").html(""); }, 5000);
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});

								}
						   }
				});
				return false;
		}
	   /* form submit */ 
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE FORMAS DE PAGO SRI */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE FORMAS DE PAGO SRI */	 	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateformasri").validate({
       rules:
	  {
			codformapago: { required: true, },
			nomformapago: { required: true, },
	   },
       messages:
	   {
            codformapago:{  required: "Ingrese C&oacute;digo de Pago SRI" },
            nomformapago:{  required: "Ingrese Nombre de Forma de Pago SRI" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateformasri").serialize();
				var id= $("#updateformasri").attr("data-id");
		        var idformapago = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forpagosri.php?idformapago='+idformapago,
				data : data,

				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CODIGO DE FORMA DE PAGO SRI YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE FORMA DE PAGO SRI YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					   setTimeout("location.href='pagossri'", 5000);
				
				});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE FORMAS DE PAGO SRI */
  








































 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE RETENCION FTE */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#retencionfte").validate({
      rules:
	  {
			codretencionfte: { required: true, },
			nomretencionfte: { required: true, },
			porcentajefte: { required: true, },
	   },
       messages:
	   {
            codretencionfte:{  required: "Ingrese C&oacute;digo de Retenci&oacute;n de FTE" },
            nomretencionfte:{  required: "Ingrese Nombre Retenci&oacute;n de FTE" },
			porcentajefte:{ required: "Ingrese Porcentaje Retenci&oacute;n de FTE" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#retencionfte").serialize();
			
				$.ajax({
				
				type : 'POST',
				url  : 'foretencionfte.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CODIGO RETENCION DE FTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE RETENCION DE FTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#retencionfte")[0].reset();
						            setTimeout(function() { $("#error").html(""); }, 5000);
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});

								}
						   }
				});
				return false;
		}
	   /* form submit */ 
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE RETENCION FTE */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE RETENCION FTE */	 	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateretencionfte").validate({
       rules:
	  {
			codretencionfte: { required: true, },
			nomretencionfte: { required: true, },
			porcentajefte: { required: true, },
	   },
       messages:
	   {
            codretencionfte:{  required: "Ingrese C&oacute;digo de Retenci&oacute;n de FTE" },
            nomretencionfte:{  required: "Ingrese Nombre Retenci&oacute;n de FTE" },
			porcentajefte:{ required: "Ingrese Porcentaje Retenci&oacute;n de FTE" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateretencionfte").serialize();
				var id= $("#updateretencionfte").attr("data-id");
		        var idretencionfte = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'foretencionfte.php?idretencionfte='+idretencionfte,
				data : data,

				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CODIGO RETENCION DE FTE YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE RETENCION DE FTE YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					   setTimeout("location.href='retencionfte'", 5000);
				
				});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE RETENCION FTE */
  
 

































 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE RETENCION IVA */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#retencioniva").validate({
      rules:
	  {
			codretencioniva: { required: true, },
			nomretencioniva: { required: true, },
			porcentajeiva: { required: true, },
	   },
       messages:
	   {
            codretencioniva:{  required: "Ingrese C&oacute;digo de Retenci&oacute;n de IVA" },
            nomretencioniva:{  required: "Ingrese Nombre Retenci&oacute;n de IVA" },
			porcentajeiva:{ required: "Ingrese Porcentaje Retenci&oacute;n de IVA" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#retencioniva").serialize();
			
				$.ajax({
				
				type : 'POST',
				url  : 'foretencioniva.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CODIGO RETENCION DE IVA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE RETENCION DE IVA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#retencioniva")[0].reset();
						            setTimeout(function() { $("#error").html(""); }, 5000);
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});

								}
						   }
				});
				return false;
		}
	   /* form submit */ 
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE RETENCION IVA */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE RETENCION IVA */	 	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateretencioniva").validate({
       rules:
	  {
			codretencioniva: { required: true, },
			nomretencioniva: { required: true, },
			porcentajeiva: { required: true, },
	   },
       messages:
	   {
            codretencioniva:{  required: "Ingrese C&oacute;digo de Retenci&oacute;n de IVA" },
            nomretencioniva:{  required: "Ingrese Nombre Retenci&oacute;n de IVA" },
			porcentajeiva:{ required: "Ingrese Porcentaje Retenci&oacute;n de IVA" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateretencioniva").serialize();
				var id= $("#updateretencioniva").attr("data-id");
		        var idretencioniva = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'foretencioniva.php?idretencioniva='+idretencioniva,
				data : data,

				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CODIGO RETENCION DE IVA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE RETENCION DE IVA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					   setTimeout("location.href='retencioniva'", 5000);
				
				});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE RETENCION IVA */
  








 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 



 
 
 
 
  
 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE CAJAS DE VENTAS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#cajas").validate({
      rules:
	  {
			nrocaja: { required: true, },
			iniciofactura: { required: true, digits : true, maxlength: 9 },
			finfactura: { required: true, digits : true, maxlength: 9 },
			serie: { required: true, digits : true, maxlength: 6 },
			autorizacion: { required: true, digits : true, maxlength: 10 },
			nombrecaja: { required: true, },
			codigo: { required: true, },
	   },
       messages:
	   {
            nrocaja:{  required: "Ingrese Numero de Caja" },
			iniciofactura:{ required: "Ingrese Secuencia Inicio de Factura", digits: "Ingrese solo digitos", maxlength: "Ingrese 9 digitos como m&aacute;ximo" },
			finfactura:{ required: "Ingrese Secuencia Fin de Factura", digits: "Ingrese solo digitos", maxlength: "Ingrese 9 digitos como m&aacute;ximo" },
			serie:{ required: "Ingrese Secuencia de Serie", digits: "Ingrese solo digitos", maxlength: "Ingrese 6 digitos como m&aacute;ximo" },
			autorizacion:{ required: "Ingrese Secuencia de Autorizaci&oacute;n", digits: "Ingrese solo digitos", maxlength: "Ingrese 10 digitos como m&aacute;ximo" },
			nombrecaja:{ required: "Ingrese Nombre de Caja" },
			codigo:{ required: "Seleccione Responsable de Caja" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#cajas").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forcaja.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE N&deg DE SERIE YA SE ENCUENTRA ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE N&deg DE AUTORIZACI&Oacute;n YA SE ENCUENTRA ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE CAJA YA SE ENCUENTRA ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==5)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA TIENE UNA CAJA DE VENTAS ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#cajas")[0].reset();
						            $("#codigocaja").load("funciones.php?muestracodigocaja=si");			
						            setTimeout(function() { $("#error").html(""); }, 5000);
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});

								}
						   }
				});
				return false;
		}
	   /* form submit */ 
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CAJAS DE VENTAS */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CAJA DE VENTAS */	 	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatecajas").validate({
       rules:
	  {
			nrocaja: { required: true, },
			iniciofactura: { required: true, digits : true, maxlength: 9 },
			finfactura: { required: true, digits : true, maxlength: 9 },
			serie: { required: true, digits : true, maxlength: 6 },
			autorizacion: { required: true, digits : true, maxlength: 10 },
			nombrecaja: { required: true, },
			codigo: { required: true, },
	   },
       messages:
	   {
            nrocaja:{  required: "Ingrese Numero de Caja" },
			iniciofactura:{ required: "Ingrese Secuencia Inicio de Factura", digits: "Ingrese solo digitos", maxlength: "Ingrese 9 digitos como m&aacute;ximo" },
			finfactura:{ required: "Ingrese Secuencia Fin de Factura", digits: "Ingrese solo digitos", maxlength: "Ingrese 9 digitos como m&aacute;ximo" },
			serie:{ required: "Ingrese Secuencia de Serie", digits: "Ingrese solo digitos", maxlength: "Ingrese 6 digitos como m&aacute;ximo" },
			autorizacion:{ required: "Ingrese Secuencia de Autorizaci&oacute;n", digits: "Ingrese solo digitos", maxlength: "Ingrese 10 digitos como m&aacute;ximo" },
			nombrecaja:{ required: "Ingrese Nombre de Caja" },
			codigo:{ required: "Seleccione Responsable de Caja" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatecajas").serialize();
				var id= $("#updatecajas").attr("data-id");
		        var codcaja = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forcaja.php?codcaja='+codcaja,
				data : data,

				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE N&deg DE SERIE YA SE ENCUENTRA ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE N&deg DE AUTORIZACI&Oacute;n YA SE ENCUENTRA ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE CAJA YA SE ENCUENTRA ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==5)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA TIENE UNA CAJA DE VENTAS ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					   setTimeout("location.href='cajas'", 5000);
				
				});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CAJAS DE VENTAS */
 
 
 
 


 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

 


 
 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE CLIENTES */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#clientes").validate({
      rules:
	  {
			cedcliente: { required: true, digits : true },
			nomcliente: { lettersonly: true, },
			direccliente: { required: true, },
			emailcliente: { required: false, email: true },
			tlfcliente: { required: true, digits : false  },
			codzona: { required: true, },
			codgrupo: { required: true, },
			cupocredito: { required: true, },
			provincia: { required: true, },
			canton: { required: true, },
			parroquia: { required: true, },
			diascredito: { required: true, },
	   },
       messages:
	   {
            cedcliente:{ required: "Ingrese C&eacute;dula de Cliente", digits: "Ingrese solo digitos para C&eacute;dula"},
			nomcliente:{ required: "Ingrese Nombre de Cliente" },
            direccliente:{ required: "Ingrese Direcci&oacute;n de Cliente" },
			emailcliente:{  required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },
			tlfcliente: { required: "Ingrese N&deg; de Telefono de Cliente", digits: "Ingrese solo digitos" },
			codzona:{ required: "Seleccione Zona" },
            codgrupo:{ required: "Seleccione Grupo de Cliente" },
			cupocredito:{ required: "Ingrese Cupo de Cr&eacute;dito" },
            provincia:{ required: "Ingrese Provincia" },
			canton: { required: "Ingrese Cant&oacute;n" },
			parroquia:{ required: "Ingrese Parroquia" },
			diascredito:{ required: "Ingrese Dias Pago de Cr&eacute;dito" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#clientes").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forcliente.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#clientes")[0].reset();
					            	setTimeout(function() { $("#error").html(""); }, 5000); 					
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CLIENTES */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CLIENTES */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateclientes").validate({
       rules:
	  {
			cedcliente: { required: true, digits : true },
			nomcliente: { lettersonly: true, },
			direccliente: { required: true, },
			emailcliente: { required: false, email: true },
			tlfcliente: { required: true, digits : false  },
			codzona: { required: true, },
			codgrupo: { required: true, },
			cupocredito: { required: true, },
			provincia: { required: true, },
			canton: { required: true, },
			parroquia: { required: true, },
			diascredito: { required: true, },
	   },
       messages:
	   {
            cedcliente:{ required: "Ingrese C&eacute;dula de Cliente", digits: "Ingrese solo digitos para C&eacute;dula"},
			nomcliente:{ required: "Ingrese Nombre de Cliente" },
            direccliente:{ required: "Ingrese Direcci&oacute;n de Cliente" },
			emailcliente:{  required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },
			tlfcliente: { required: "Ingrese N&deg; de Telefono de Cliente", digits: "Ingrese solo digitos" },
			codzona:{ required: "Seleccione Zona" },
            codgrupo:{ required: "Seleccione Grupo de Cliente" },
			cupocredito:{ required: "Ingrese Cupo de Cr&eacute;dito" },
            provincia:{ required: "Ingrese Provincia" },
			canton: { required: "Ingrese Cant&oacute;n" },
			parroquia:{ required: "Ingrese Parroquia" },
			diascredito:{ required: "Ingrese Dias Pago de Cr&eacute;dito" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateclientes").serialize();
				var id= $("#updateclientes").attr("data-id");
		        var codcliente = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forcliente.php?codcliente='+codcliente,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
							 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
 					   setTimeout("location.href='clientes'", 5000);
				
				});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CLIENTES */
 
 /* FUNCION JQUERY PARA CARGA MASIVA DE CLIENTES */	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#cargaclientes").validate({
      rules:
	  {
			sel_file: { required: true, },
	   },
       messages:
	   {
            sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#cargaclientes").serialize();
				var formData = new FormData($("#cargaclientes")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'cargamasiva.php',
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#errorcliente").fadeOut();
					$("#btn-cliente").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#errorcliente").fadeIn(1000, function(){
											
	$("#errorcliente").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR !</div></center>');
											
									$("#btn-cliente").html('<span class="fa fa-cloud-upload"></span> Cargar Clientes');
										
									});
																				
								}  
								else if(data==2){
									
									$("#errorcliente").fadeIn(1000, function(){
											
	$("#errorcliente").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE CLIENTES</div></center>');
											
									$("#btn-cliente").html('<span class="fa fa-cloud-upload"></span> Cargar Clientes');
										
									});
								}
								else{
																					
						$("#errorcliente").fadeIn(1000, function(){
											
						            $("#errorcliente").html('<center> &nbsp; '+data+' </center>');
						            $("#cargaclientes")[0].reset();
					            	//setTimeout(function() { $("#errorcliente").html(""); }, 5000); 					
								    $("#btn-cliente").html('<span class="fa fa-cloud-upload"></span> Cargar Clientes');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
});
/*  FIN DE FUNCION PARA CARGA MASIVA DE CLIENTES */
 
 
 
 
 
 
 
 
 
 
 



 
 
 
 
 
 





 





 
 
 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE PROVEEDORES */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#proveedores").validate({
      rules:
	  {
			tipoidentifproveedor: { required: true, },
			identifproveedor: { required: true, digits : true, minlength: 8, maxlength: 11 },
			nomproveedor: { required: true, },
			nomcomercial: { required: true, },
			emailproveedor: { required: false, email: true },
			tlfproveedor: { required: true, digits : false  },
			statusproveedor: { required: true, },
			codzona: { required: true, },
			limiteproveedor: { required: true, number : true  },
			diasproveedor: { required: true, digits : true },
			tipoproveedor: { required: true, },
	   },
       messages:
	   {
			tipoidentifproveedor:{ required: "Seleccione Tipo Identificaci&oacute;n" },
			identifproveedor:{ required: "Ingrese N&deg; de Identificaci&oacute;n", digits: "Ingrese solo digitos para RUC", minlength: "Ingrese 8 digitos como minimo", maxlength: "Ingrese 11 digitos como m&aacute;ximo"},
            nomproveedor:{ required: "Ingrese Nombre de Proveedor" },
            nomcomercial:{ required: "Ingrese Nombre Comercial" },
			emailproveedor:{  required: "Ingrese Email de Proveedor", email: "Ingrese un Email Valido" },
			tlfproveedor: { required: "Ingrese N&deg; de Telefono de Proveedor", digits: "Ingrese solo digitos" },
            statusproveedor:{ required: "Seleccione Estado de Proveedor" },
            codzona:{ required: "Seleccione Zona de Proveedor" },
			limiteproveedor: { required: "Ingrese Limie de Cr&eacute;dito", number: "Ingrese solo digitos con dos decimales" },
            diasproveedor:{ required: "Ingrese Dias de Pago a Cr&eacute;dito", digits: "Ingrese solo digitos" },
			tipoproveedor:{ required: "Seleccione Tipo de Proveedor" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#proveedores").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forproveedor.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE PROVEEDOR YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#proveedores")[0].reset();
						            setTimeout(function() { $("#error").html(""); }, 5000);				
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PROVEEDORES */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PROVEEDORES */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateproveedores").validate({
      rules:
	  {
			tipoidentifproveedor: { required: true, },
			identifproveedor: { required: true, digits : true, minlength: 8, maxlength: 11 },
			nomproveedor: { required: true, },
			nomcomercial: { required: true, },
			emailproveedor: { required: false, email: true },
			tlfproveedor: { required: true, digits : false  },
			statusproveedor: { required: true, },
			codzona: { required: true, },
			limiteproveedor: { required: true, number : true  },
			diasproveedor: { required: true, digits : true },
			tipoproveedor: { required: true, },
	   },
       messages:
	   {
			tipoidentifproveedor:{ required: "Seleccione Tipo Identificaci&oacute;n" },
			identifproveedor:{ required: "Ingrese N&deg; de Identificaci&oacute;n", digits: "Ingrese solo digitos para RUC", minlength: "Ingrese 8 digitos como minimo", maxlength: "Ingrese 11 digitos como m&aacute;ximo"},
            nomproveedor:{ required: "Ingrese Nombre de Proveedor" },
            nomcomercial:{ required: "Ingrese Nombre Comercial" },
			emailproveedor:{  required: "Ingrese Email de Proveedor", email: "Ingrese un Email Valido" },
			tlfproveedor: { required: "Ingrese N&deg; de Telefono de Proveedor", digits: "Ingrese solo digitos" },
            statusproveedor:{ required: "Seleccione Estado de Proveedor" },
            codzona:{ required: "Seleccione Zona de Proveedor" },
			limiteproveedor: { required: "Ingrese Limie de Cr&eacute;dito", number: "Ingrese solo digitos con dos decimales" },
            diasproveedor:{ required: "Ingrese Dias de Pago a Cr&eacute;dito", digits: "Ingrese solo digitos" },
			tipoproveedor:{ required: "Seleccione Tipo de Proveedor" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateproveedores").serialize();
				var id= $("#updateproveedores").attr("data-id");
		        var codproveedor = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forproveedor.php?codproveedor='+codproveedor,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
							 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE PROVEEDOR YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
							 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
   					   setTimeout("location.href='proveedores'", 5000);
				
				});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PROVEEDORES */
 
 /* FUNCION JQUERY PARA CARGA MASIVA DE PROVEEDORES */	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#cargaproveedores").validate({
      rules:
	  {
			sel_file: { required: true, },
	   },
       messages:
	   {
            sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#cargaproveedores").serialize();
				var formData = new FormData($("#cargaproveedores")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'cargamasiva.php',
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#errorprov").fadeOut();
					$("#btn-proveedor").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#errorprov").fadeIn(1000, function(){
											
	$("#errorprov").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR !</div></center>');
											
									$("#btn-proveedor").html('<span class="fa fa-cloud-upload"></span> Cargar Proveedores');
										
									});
																				
								}  
								else if(data==2){
									
									$("#errorprov").fadeIn(1000, function(){
											
	$("#errorprov").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE CLIENTES</div></center>');
											
									$("#btn-proveedor").html('<span class="fa fa-cloud-upload"></span> Cargar Proveedores');
										
									});
								}
								else{
																					
						$("#errorprov").fadeIn(1000, function(){
											
						            $("#errorprov").html('<center> &nbsp; '+data+' </center>');
						            $("#cargaproveedores")[0].reset();
					            	setTimeout(function() { $("#errorprov").html(""); }, 5000); 					
								    $("#btn-proveedor").html('<span class="fa fa-cloud-upload"></span> Cargar Proveedores');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
});
/*  FIN DE FUNCION PARA CARGA MASIVA DE PROVEEDORES */
 






































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRODUCTOS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#productos").validate({
      rules:
	  {
			codproducto: { required: true, },
			producto: { required: true,},
			fabricante: { required: false, },
			codfamilia: { required: true, },
			codsubfamilia: { required: false, },
			codmarca: { required: true, },
			codmodelo: { required: false, },
			codpresentacion: { required: true, },
			codorigen: { required: false, },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			precioventab: { required: true, number : false},
			precioventac: { required: true, number : false},
			precioventad: { required: true, number : false},
			peso: { required: true, },
			existencia: { required: true, digits : true },
			stockminimo: { required: true, digits : true },
			stockmaximo: { required: true, digits : true },
			ivaproducto: { required: true, },
			descproducto: { required: true, number : true },
			codigobarra: { required: false, },
			codigobarrab: { required: false, },
			codproveedor: { required: true, },
	   },
       messages:
	   {
			codproducto: { required: "Ingrese C&oacute;digo de Producto" },
			producto:{  required: "Ingrese Nombre de Producto" },
			fabricante:{ required: "Ingrese Fabricante de Producto" },
			codfamilia:{ required: "Seleccione Familia de Producto" },
			codsubfamilia:{ required: "Seleccione Subfamilia de Producto" },
			codmarca:{ required: "Seleccione Marca de Producto" },
			codmodelo:{ required: "Seleccione Modelo de Producto" },
			codpresentacion:{ required: "Seleccione Presentaci&oacute;n" },
			codorigen:{ required: "Seleccione Origen de Producto" },
			preciocompra:{ required: "Ingrese Precio de Compra de Producto", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta de Producto A", number: "Ingrese solo digitos con 2 decimales" },
			precioventab:{ required: "Ingrese Precio de Venta de Producto B", number: "Ingrese solo digitos con 2 decimales" },
			precioventac:{ required: "Ingrese Precio de Venta de Producto C", number: "Ingrese solo digitos con 2 decimales" },
			precioventad:{ required: "Ingrese Precio de Venta de Producto D", number: "Ingrese solo digitos con 2 decimales" },
			peso: { required: "Ingrese Peso de Producto" },
			existencia:{ required: "Ingrese Cantidad o Existencia de Producto", digits: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", digits: "Ingrese solo digitos" },
            stockmaximo:{ required: "Ingrese Stock Maximo", digits: "Ingrese solo digitos" },
			ivaproducto:{ required: "Seleccione IVA de Producto" },
			descproducto:{ required: "Ingrese Descuento de Producto", number: "Ingrese solo digitos con 2 decimales" },
			codigobarra: { required: "Ingrese C&oacute;digo de Barra A" },
			codigobarrab: { required: "Ingrese C&oacute;digo de Barra B" },
			codproveedor: { required: "Seleccione Proveedor" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#productos").serialize();
				var formData = new FormData($("#productos")[0]);
				var cant = $('#existencia').val();
				var compra = $('#preciocompra').val();
				var venta = $('#precioventa').val();
				cant    = parseInt(cant);
	
	       if (compra==0.00 || compra==0) {
	            
				$("#preciocompra").focus();
				$('#preciocompra').val("");
				$('#preciocompra').css('border-color','#f0ad4e');
				alert('Por favor ingrese un costo valido para Precio de Compra de Producto');
         
              return false;
		
		   } else if (venta==0.00 || venta==0) {
	            
				$("#precioventa").focus();
				$('#precioventa').val("");
				$('#precioventa').css('border-color','#f0ad4e');
				alert('Por favor ingrese un costo valido para Precio de Venta de Producto');
         
             return false;

        } else if (parseFloat(compra) > parseFloat(venta)) {
	            
				$("#precioventa").focus();
				$("#preciocompra").focus();
				$('#precioventa').css('border-color','#f0ad4e');
				$('#preciocompra').css('border-color','#f0ad4e');
				alert('El Precio de Compra no puede ser mayor al Precio de Venta del Producto');
         
             return false;
		
			} else  if (cant=="" || cant==0) {
	            
				$("#existencia").focus();
				$('#existencia').val("");
				$('#existencia').css('border-color','#f0ad4e');
				alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA PRODUCTOS');
         
        return false;
	 
	  } else {
				$.ajax({
				type : 'POST',
				url  : 'forproducto.php',
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}  
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN PRODUCTO CON ESTE C&Oacute;DIGO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#productos")[0].reset();	
						$("#nroproducto").load("funciones.php?muestranroproducto=si");
						$("#codigoproducto").load("funciones.php?muestracodigoproducto=si");	
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
	        }
		}
	   /* form submit */	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PRODUCTOS */
 
 
 /* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRODUCTOS */
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateproducto").validate({
        rules:
	  {
			codproducto: { required: true, },
			producto: { required: true,},
			fabricante: { required: false, },
			codfamilia: { required: true, },
			codsubfamilia: { required: false, },
			codmarca: { required: true, },
			codmodelo: { required: false, },
			codpresentacion: { required: true, },
			codorigen: { required: false, },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			precioventab: { required: true, number : false},
			precioventac: { required: true, number : false},
			precioventad: { required: true, number : false},
			peso: { required: true, },
			existencia: { required: true, digits : true },
			stockminimo: { required: true, digits : true },
			stockmaximo: { required: true, digits : true },
			ivaproducto: { required: true, },
			descproducto: { required: true, number : true },
			codigobarra: { required: false, },
			codigobarrab: { required: false, },
			codproveedor: { required: true, },
	   },
       messages:
	   {
			codproducto: { required: "Ingrese C&oacute;digo de Producto" },
			producto:{  required: "Ingrese Nombre de Producto" },
			fabricante:{ required: "Ingrese Fabricante de Producto" },
			codfamilia:{ required: "Seleccione Familia de Producto" },
			codsubfamilia:{ required: "Seleccione Subfamilia de Producto" },
			codmarca:{ required: "Seleccione Marca de Producto" },
			codmodelo:{ required: "Seleccione Modelo de Producto" },
			codpresentacion:{ required: "Seleccione Presentaci&oacute;n" },
			codorigen:{ required: "Seleccione Origen de Producto" },
			preciocompra:{ required: "Ingrese Precio de Compra de Producto", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta de Producto A", number: "Ingrese solo digitos con 2 decimales" },
			precioventab:{ required: "Ingrese Precio de Venta de Producto B", number: "Ingrese solo digitos con 2 decimales" },
			precioventac:{ required: "Ingrese Precio de Venta de Producto C", number: "Ingrese solo digitos con 2 decimales" },
			precioventad:{ required: "Ingrese Precio de Venta de Producto D", number: "Ingrese solo digitos con 2 decimales" },
			peso: { required: "Ingrese Peso de Producto" },
			existencia:{ required: "Ingrese Cantidad o Existencia de Producto", digits: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", digits: "Ingrese solo digitos" },
            stockmaximo:{ required: "Ingrese Stock Maximo", digits: "Ingrese solo digitos" },
			ivaproducto:{ required: "Seleccione IVA de Producto" },
			descproducto:{ required: "Ingrese Descuento de Producto", number: "Ingrese solo digitos con 2 decimales" },
			codigobarra: { required: "Ingrese C&oacute;digo de Barra A" },
			codigobarrab: { required: "Ingrese C&oacute;digo de Barra B" },
			codproveedor: { required: "Seleccione Proveedor" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateproducto").serialize();
				var formData = new FormData($("#updateproducto")[0]);
				var id= $("#updateproducto").attr("data-id");
		        var codproducto = id;
				
	            var cant = $('#existencia').val();
			    var compra = $('#preciocompra').val();
				var venta = $('#precioventa').val();
				cant    = parseInt(cant);
	
	       if (compra==0.00 || compra==0) {
	            
				$("#preciocompra").focus();
				$('#preciocompra').val("");
				$('#preciocompra').css('border-color','#f0ad4e');
				alert('Por favor ingrese un costo valido para Precio de Compra de Producto');
         
              return false;
		
		   } else if (venta==0.00 || venta==0) {
	            
				$("#precioventa").focus();
				$('#precioventa').val("");
				$('#precioventa').css('border-color','#f0ad4e');
				alert('Por favor ingrese un costo valido para Precio de Venta de Producto');
         
             return false;

        } else if (parseFloat(compra) > parseFloat(venta)) {
	            
				$("#precioventa").focus();
				$("#preciocompra").focus();
				$('#precioventa').css('border-color','#f0ad4e');
				$('#preciocompra').css('border-color','#f0ad4e');
				alert('El Precio de Compra no puede ser mayor al Precio de Venta del Producto');
         
             return false;
		
			} else  if (cant=="" || cant==0) {
	            
				$("#existencia").focus();
				$('#existencia').val("");
				$('#existencia').css('border-color','#f0ad4e');
				alert('Por favor ingrese una Cantidad valida para Stock Actual de Productos');
         
        return false;
	 
	  } else {
				$.ajax({
				type : 'POST',
				url  : 'forproducto.php?codproducto='+codproducto,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
     					setTimeout("location.href='productos'", 5000);
				
				});
											
								}
						   }
				});
				return false;
	        }
		}
	   /* form submit */	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRODUCTOS */
 
 /* FUNCION JQUERY PARA CARGA MASIVA DE PRODUCTOS */	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#cargaproductos").validate({
      rules:
	  {
			sel_file: { required: true, },
	   },
       messages:
	   {
            sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#cargaproductos").serialize();
				var formData = new FormData($("#cargaproductos")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'cargamasiva.php',
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#errorproduc").fadeOut();
					$("#btn-producto").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#errorproduc").fadeIn(1000, function(){
											
	$("#errorproduc").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR !</div></center>');
											
									$("#btn-producto").html('<span class="fa fa-cloud-upload"></span> Cargar Productos');
										
									});
																				
								}  
								else if(data==2){
									
									$("#errorproduc").fadeIn(1000, function(){
											
	$("#errorproduc").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE CLIENTES</div></center>');
											
									$("#btn-producto").html('<span class="fa fa-cloud-upload"></span> Cargar Productos');
										
									});
								}
								else{
																					
						$("#errorproduc").fadeIn(1000, function(){
											
						            $("#errorproduc").html('<center> &nbsp; '+data+' </center>');
						            $("#cargaproductos")[0].reset();
					            	setTimeout(function() { $("#errorproduc").html(""); }, 5000); 					
								    $("#btn-producto").html('<span class="fa fa-cloud-upload"></span> Cargar Productos');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
});
/*  FIN DE FUNCION PARA CARGA MASIVA DE PRODUCTOS */
 
/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DE AJUSTE DE STOCK */	 	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateajustestock").validate({
       rules:
	  {
			codproducto: { required: true, },
			producto: { required: true,},
			stockteorico: { required: true, digits : true },
			motivoajuste: { required: true, },
	   },
       messages:
	   {
			codproducto: { required: "Ingrese C&oacute;digo de Producto" },
			producto:{  required: "Ingrese Nombre de Producto" },
			stockteorico:{ required: "Ingrese Stock Te&oacute;rico de Producto", digits: "Ingrese solo digitos" },
			motivoajuste:{ required: "Ingrese Motivo de Ajuste" },
            
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateajustestock").serialize();
				var id= $("#updateajustestock").attr("data-id");
		        var codproducto = id;

		        var cant = $('#stockteorico').val();
				cant    = parseInt(cant);
	
	       if (cant=="" || cant==0) {
	            
				$("#stockteorico").focus();
				$('#stockteorico').val("");
				$('#stockteorico').css('border-color','#f0ad4e');
				alert('Por favor ingrese una Cantidad valida para Stock Teorico de Producto');
         
        return false;
	 
	  } else {
				
				$.ajax({
				
				type : 'POST',
				url  : 'forajuste.php?codproducto='+codproducto,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
							 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
   					   setTimeout("location.href='ajusteinventario'", 5000);
				
				});
											
								}
						   }
				});
				return false;
			  }
		}
	   /* form submit */
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE AJUSTE DE STOCK */
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 











 
/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PEDIDOS DE PRODUCTOS */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#pedidos").validate({
      rules:
	  {
			codpedido: { required: true, },
			codproveedor: { required: true, },
			fechapedido: { required: true, },
	   },
       messages:
	   {
            codpedido:{  required: "Ingrese C&oacute;digo de Pedido" },
			codproveedor:{  required: "	Seleccione Proveedor" },
			fechapedido:{  required: "Ingrese Fecha de Pedido" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#pedidos").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=5><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
		  
		        $.ajax({
				
				type : 'POST',
				url  : 'forpedidos.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO PRODUCTOS PARA PEDIDOS, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#pedidos")[0].reset();	
					    $("#carrito tbody").html("");
						$(nuevaFila).appendTo("#carrito tbody");
					    $("#codigopedido").load("funciones.php?muestracodigopedido=si");
						setTimeout(function() { $("#error").html(""); }, 25000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PEDIDOS DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PEDIDOS DE PRODUCTOS */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatepedidos").validate({
        rules:
	  {
			codpedido: { required: true, },
			codproveedor: { required: true, },
			fecharegistro: { required: true, },
	   },
       messages:
	   {
            codpedido:{  required: "Ingrese N&deg; de Pedido" },
			codproveedor:{  required: "Seleccione Proveedor" },
			fecharegistro:{  required: "Ingrese Fecha de Compra" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatepedidos").serialize();
				var id= $("#updatepedidos").attr("data-id");
		        var codpedido = id;
								
			    var cant = $('#cantpedido').val();
				cant    = parseInt(cant);
	
	       if (cant==0) {
	            
				$("#cantpedido").focus();
				$('#cantpedido').val("");
				$('#cantpedido').css('border-color','#f0ad4e');
				alert('Por favor ingresa una Cantidad valida para Pedidos de Productos');
         
        return false;
	 
	  } else {
		        $.ajax({
				type : 'POST',
				url  : 'editpedidos.php?codpedido='+codpedido,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS PRODUCTOS ASOCIADOS AL PEDIDO NO PUEDEN REPETIRSE, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
    					setTimeout("location.href='pedidos'", 5000);
				});
								}
						   }
				});
				return false;
	           }
		}
	   /* form submit */	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PEDIDOS DE PRODUCTOS */
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COMPRAS DE PRODUCTOS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#compras").validate({
      rules:
	  {
			codcompra: { required: true, },
			codseriec: { required: true, },
			codautorizacionc: { required: true, },
			lote: { required: true, },
			codproveedor: { required: true, },
			tipocompra: { required: true, },
			formapago: { required: true, },
			fechavencecredito: { required: true, },
			fechacompra: { required: true, },
			descuento: { required: true, number : true },
			iva: { required: true, number : true },
			id: { required: true, },
	   },
       messages:
	   {
            codcompra:{  required: "Ingrese N&deg; de Compra" },
			codseriec:{  required: "Ingrese N&deg; de Serie" },
			codautorizacionc:{  required: "Ingrese N&deg; de Autorizaci&oacute;n" },
			lote:{  required: "Ingrese N&deg; de Lote" },
			codproveedor:{  required: "	Seleccione Proveedor" },
			tipocompra:{  required: "	Seleccione Tipo de Pago" },
			formapago:{  required: "Seleccione Forma de Pago" },
			fechavencecredito:{  required: "Ingrese Fecha de Vencimiento de Cr&eacute;dito" },
			fechacompra:{  required: "Ingrese Fecha de Compra" },
			descuento:{ required: "Ingrese Descuento de Compra", number: "Ingrese solo digitos con 2 decimales" },
			iva:{ required: "Ingrese Iva de Compra", number: "Ingrese solo digitos con 2 decimales" },
			id:{  required: "Seleccione RUC" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#compras").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=7><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
				var total = $('#txtTotal').val();
	
	        if (total==0.00) {
	            
				$("#producto").focus();
				$('#producto').css('border-color','#f0ad4e');
				alert('Por favor debe de agregar Productos al carrito para continuar con la Compra');
         
        return false;
	 
	  } else {
				$.ajax({
				
				type : 'POST',
				url  : 'forcompras.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE PROVEEDOR NO ACEPTA COMPRAS A CREDITO, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> SE HA EXCEDIDO DEL LIMITE EN EL MONTO DE COMPRAS A CREDITO A ESTE PROVEEDOR, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO PRODUCTOS PARA ENTRADA EN ALMACEN, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==5)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA ESTE CODIGO DE COMPRA SE ENCUENTRA REGISTRADO, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#compras")[0].reset();
					    $("#carrito tbody").html("");
						$("#lblsubtotal").text("0.00");
						$("#lblsubtotal2").text("0.00");
						$("#lbliva").text("0.00");
						$("#lbldescuento").text("0.00");
						$("#lbltotal").text("0.00");
						$("#txtsubtotal").val("0.00");
						$("#txtsubtotal2").val("0.00");
						$("#txtIva").val("0.00");
						$("#txtDescuento").val("0.00");
						$("#txtTotal").val("0.00");
						$(nuevaFila).appendTo("#carrito tbody");
						setTimeout(function() { $("#error").html(""); }, 25000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		         }
		}
	   /* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE COMPRAS DE PRODUCTOS */

 
/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COMPRAS DE PRODUCTOS */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatedetallescompras").validate({
        rules:
	  {
			codcompra: { required: true, },
			codproducto : { required: true, },
			producto: { required: true, },
			cantcompra: { required: true, digits : true  },
			precio1: { required: true, number : true },
			lote: { required: true, },
	   },
       messages:
	   {
            codcompra:{ required: "Ingrese C&oacute;digo de Compra" },
			codproducto : { required : "Ingrese C&oacute;digo Producto"  },
			producto:{  required: "Ingrese Descripci&oacute;n Producto"  },
			cantcompra:{  required: "Ingrese Cantidad de Compra", digits: "Ingrese solo digitos"  },
			precio1:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			lote:{  required: "Ingrese N&deg; de Lote"  },

       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatedetallescompras").serialize();
				var id= $("#updatedetallescompras").attr("data-id");
		        var coddetallecompra = id;
				
			    var cant = $('#cantcompra').val();
				var compra = $('#preciocompra').val();
				var venta = $('#precioventa').val();
				cant    = parseInt(cant);
	
	       if (compra==0.00 || compra==0) {
	            
				$("#preciocompra").focus();
				$('#preciocompra').val("");
				$('#preciocompra').css('border-color','#f0ad4e');
				alert('Por favor ingrese un costo valido para Precio de Compra');
         
              return false;
		
		   } else if (venta==0.00 || venta==0) {
	            
				$("#precioventa").focus();
				$('#precioventa').val("");
				$('#precioventa').css('border-color','#f0ad4e');
				alert('Por favor ingrese un costo valido para Precio de Venta');
         
             return false;

        } else if (parseFloat(compra) > parseFloat(venta)) {
	            
				$("#precioventa").focus();
				$("#preciocompra").focus();
				$('#precioventa').css('border-color','#f0ad4e');
				$('#preciocompra').css('border-color','#f0ad4e');
				alert('El Precio de Compra no puede ser mayor al Precio de Venta del Producto');
         
             return false;
		
			} else  if (cant==0) {
	            
				$("#cantcompra").focus();
				$('#cantcompra').val("");
				$('#cantcompra').css('border-color','#f0ad4e');
				alert('Por favor ingrese una Cantidad valida para Compra');
         
        return false;
	 
	  } else {
		        $.ajax({
				
				type : 'POST',
				url  : 'editdetallecompras.php?coddetallecompra='+coddetallecompra,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE DETALLE DE COMPRA NO PUEDE SER ACTUALIZADO, SE ENCUENTRA INACTIVO PARA ACTUALIZAR !</div></center>');
											
										$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
$("#cargacomprainput").load("funciones.php?muestracantcompradb=si&coddetallecompra="+btoa(coddetallecompra));
    					setTimeout("location.href='detallescompras'", 5000);
				
				});
								}
						   }
				});
				return false;
	           }
		}
	   /* form submit */	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DETALLE DE COMPRAS DE PRODUCTOS */
 








































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ARQUEO DE CAJA */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#arqueocaja").validate({
      rules:
	  {
			codcaja: { required: true, },
			montoinicial: { required: true, number : true},
			dineroefectivo: { required: true, number : true},
			comentarios: { required: true,},
	   },
       messages:
	   {
			codcaja: { required: "Seleccione Caja para Arqueo" },
			montoinicial:{ required: "Ingrese Monto Inicial", number: "Ingrese solo digitos con 2 decimales" },
			dineroefectivo:{ required: "Ingrese Monto en Efectivo", number: "Ingrese solo digitos con 2 decimales" },
			comentarios:{  required: "Ingrese Comentario de Cierre" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#arqueocaja").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forarqueo.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN ARQUEO ABIERTO DE ESTA CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#arqueocaja")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ARQUEO DE CAJA */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ARQUEO DE CAJA */	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updatearqueocaja").validate({
      rules:
	  {
			codcaja: { required: true, },
			montoinicial: { required: true, number : true},
			dineroefectivo: { required: true, number : true},
			comentarios: { required: true,},
	   },
       messages:
	   {
			codcaja: { required: "Seleccione Caja para Arqueo" },
			montoinicial:{ required: "Ingrese Monto Inicial", number: "Ingrese solo digitos con 2 decimales" },
			dineroefectivo:{ required: "Ingrese Monto en Efectivo", number: "Ingrese solo digitos con 2 decimales" },
			comentarios:{  required: "Ingrese Comentario de Cierre" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatearqueocaja").serialize();
				var id= $("#updatearqueocaja").attr("data-id");
		        var codarqueo = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'forarqueo.php?codarqueo='+codarqueo,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN ARQUEO ABIERTO DE ESTA CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='arqueoscajas'", 5000);
				
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ARQUEO DE CAJA */



/* FUNCION JQUERY PARA VALIDAR CIERRE DE CAJA */	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#cierrecaja").validate({
      rules:
	  {
			codcaja: { required: true, },
			montoinicial: { required: true, number : true},
			dineroefectivo: { required: true, number : true},
			comentarios: { required: false,},
	   },
       messages:
	   {
			codcaja: { required: "Seleccione Caja para Arqueo" },
			montoinicial:{ required: "Ingrese Monto Inicial", number: "Ingrese solo digitos con 2 decimales" },
			dineroefectivo:{ required: "Ingrese Monto en Efectivo", number: "Ingrese solo digitos con 2 decimales" },
			comentarios:{  required: "Ingrese Comentario de Cierre" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#cierrecaja").serialize();
				var id= $("#cierrecaja").attr("data-id");
				var dineroefectivo = $('#dineroefectivo').val();
		        var codarqueo = id;
	
	       if (dineroefectivo==0.00 || dineroefectivo==0) {
	            
				$("#dineroefectivo").focus();
				$('#dineroefectivo').val("");
				$('#dineroefectivo').css('border-color','#f0ad4e');
				alert('Por favor ingrese un Monto valido para Efectivo disponible');
         
        return false;
	 
	  } else {
				
				$.ajax({
				
				type : 'POST',
				url  : 'forcierrearqueo.php?codarqueo='+codarqueo,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Cerrar Caja');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO PUEDE CERRAR CAJA CON VENTAS SIN CANCELAR, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Cerrar Caja');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Cerrar Caja');
					    setTimeout("location.href='arqueoscajas'", 5000);
				
									});
											
								}
						   }
				});
				return false;
	  }
		}
	   /* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR CIERRE DE CAJA */

















































 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE MOVIMIENTOS EN CAJA */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#movimientocaja").validate({
      rules:
	  {
			tipomovimientocaja: { required: true, },
			montomovimientocaja: { required: true, number : true },
			mediopagomovimientocaja: { required: true, },
			codcaja: { required: true, },
			descripcionmovimientocaja: { required: true, },
	   },
       messages:
	   {
            tipomovimientocaja:{  required: "Seleccione Tipo de Movimiento" },
			montomovimientocaja:{ required: "Ingrese Monto de Movimiento", number: "Ingrese solo digitos con 2 decimales" },
			mediopagomovimientocaja:{ required: "Seleccione Medio de Pago" },
			codcaja:{ required: "Seleccione Caja" },
			descripcionmovimientocaja:{ required: "Ingrese descripci&oacute;n de Movimiento" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#movimientocaja").serialize();
				var cant = $('#montomovimientocaja').val();
	
	        if (cant==0.00 || cant==0) {
	            
				$("#montomovimientocaja").focus();
				$('#montomovimientocaja').val("");
				$('#montomovimientocaja').css('border-color','#f0ad4e');
				alert('POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO EN CAJA');
         
        return false;
	 
	  } else {
		  
				$.ajax({
				
				type : 'POST',
				url  : 'formovimientocaja.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> DEBE DE REALIZAR EL ARQUEO DE CAJA PARA REGISTRAR MOVIMIENTOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> EL MONTO A RETIRAR NO EXISTE EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}

								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO DE CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#movimientocaja")[0].reset();
					                setTimeout(function() { $("#error").html(""); }, 5000);
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
									});
								}
						   }
				});
				return false;
	         }
		}
	   /* form submit */
});
/* FIN DE FUNCION PARA VALIDAR REGISTRO DE MOVIMIENTOS EN CAJA */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE MOVIMIENTOS EN CAJA */	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatemovimientocaja").validate({
       rules:
	  {
			tipomovimientocaja: { required: true, },
			montomovimientocaja: { required: true, number : true },
			mediopagomovimientocaja: { required: true, },
			codcaja: { required: true, },
			descripcionmovimientocaja: { required: true, },
	   },
       messages:
	   {
            tipomovimientocaja:{  required: "Seleccione Tipo de Movimiento" },
			montomovimientocaja:{ required: "Ingrese Monto de Movimiento", number: "Ingrese solo digitos con 2 decimales" },
			mediopagomovimientocaja:{ required: "Seleccione Medio de Pago" },
			codcaja:{ required: "Seleccione Caja" },
			descripcionmovimientocaja:{ required: "Ingrese descripci&oacute;n de Movimiento" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatemovimientocaja").serialize();
				var id= $("#updatemovimientocaja").attr("data-id");
		        var codmovimientocaja = id;
				var cant = $('#montomovimientocaja').val();
	
	        if (cant==0.00 || cant==0) {
	            
				$("#montomovimientocaja").focus();
				$('#montomovimientocaja').val("");
				$('#montomovimientocaja').css('border-color','#f0ad4e');
				alert('POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO EN CAJA');
         
        return false;
	 
	  } else {
				$.ajax({
				
				type : 'POST',
				url  : 'formovimientocaja.php?codmovimientocaja='+codmovimientocaja,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> EL MONTO A RETIRAR NO EXISTE EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}

								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO DE CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
$("#cargamovimientoinput").load("funciones.php?muestramovimientodb=si&codmovimientocaja="+btoa(codmovimientocaja));
					    setTimeout("location.href='movimientoscajas'", 5000);
				});
								}
						   }
				});
				return false;
	         }
		}
	   /* form submit */
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE MOVIMIENTOS EN CAJA */
 
 
 
 









































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CLIENTES */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#ventaclientes").validate({
      rules:
	  {
			cedcliente: { required: true, digits : true },
			nomcliente: { lettersonly: true, },
			direccliente: { required: true, },
			emailcliente: { required: false, email: true },
			tlfcliente: { required: true, digits : false  },
			codzona: { required: true, },
			codgrupo: { required: true, },
			cupocredito: { required: true, },
			provincia: { required: true, },
			canton: { required: true, },
			parroquia: { required: true, },
			diascredito: { required: true, },
	   },
       messages:
	   {
            cedcliente:{ required: "Ingrese C&eacute;dula de Cliente", digits: "Ingrese solo digitos para C&eacute;dula"},
			nomcliente:{ required: "Ingrese Nombre de Cliente" },
            direccliente:{ required: "Ingrese Direcci&oacute;n de Cliente" },
			emailcliente:{  required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },
			tlfcliente: { required: "Ingrese N&deg; de Telefono de Cliente", digits: "Ingrese solo digitos" },
			codzona:{ required: "Seleccione Zona" },
            codgrupo:{ required: "Seleccione Grupo de Cliente" },
			cupocredito:{ required: "Ingrese Cupo de Cr&eacute;dito" },
            provincia:{ required: "Ingrese Provincia" },
			canton: { required: "Ingrese Cant&oacute;n" },
			parroquia:{ required: "Ingrese Parroquia" },
			diascredito:{ required: "Ingrese Dias Pago de Cr&eacute;dito" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#ventaclientes").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forventas.php',
				data : data,
				beforeSend: function()
				{	
					$("#errores").fadeOut();
					$("#btn-cliente").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#errores").fadeIn(1000, function(){
											
											
	$("#errores").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-cliente").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#errores").fadeIn(1000, function(){
											
											
	$("#errores").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-cliente").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#errores").fadeIn(1000, function(){
											
						            $("#errores").html('<center> &nbsp; '+data+' </center>');
						            $("#ventaclientes")[0].reset();
					            	setTimeout(function() { $("#errores").html(""); }, 5000); 					
								    $("#btn-cliente").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CLIENTES */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE VENTAS DE PRODUCTOS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#ventas").validate({
     rules:
	  {
			tipodocumento: { required: true, },
			tipopagove: { required: true, },
			mediopagove: { required: true, },
			montopagado: { required: false, },
			montodevuelto: { required: true, },
			nombrebanco: { required: false, },
			nrodocumento: { required: false, },
			idformapago: { required: true, },
			montoabono: { required: true, },

	   },
       messages:
	   {
			tipodocumento:{  required: "Seleccione Tipo Documento" },
            tipopagove:{  required: "Seleccione Forma de Pago" },
			mediopagove:{  required: "Seleccione Medio de Pago" },
			montopagado:{  required: "Ingrese Monto Pagado" },
			montodevuelto:{  required: "Ingrese Monto Devuelto" },
			nombrebanco:{  required: "Ingrese Nombre de Banco" },
			nrodocumento:{  required: "Ingrese N&deg de Documento" },
			idformapago:{  required: "Seleccione Forma Pago SRI" },
			montoabono:{  required: "Ingrese Monto de Abono" },
			
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#ventas").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=8><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
				var total = $('#txtTotal').val();
				var cliente = $('#codcliente').val();

				var venta = $('#codventa').val();
				var serie = $('#codserieve').val();
				var codventa = serie+'-'+venta;
				
		if (total==0.00) {
	            
				$("#busquedaproducto").focus();
				$('#busquedaproducto').css('border-color','#f0ad4e');
				alert('POR FAVOR DEBE DE AGREGAR PRODUCTOS AL CARRITO PARA PROCESAR VENTAS');
         
        return false;
	 
	  } else if (cliente==0 || cliente=="") {
	            
				$("#busqueda").focus();
				$("#busqueda").val("");
				$('#busqueda').css('border-color','#f0ad4e');
				alert('POR FAVOR REALICE LA BUSQUEDA DEL CLIENTE CORRECTAMENTE');
         
        return false;
	 
	  } else {
				$.ajax({
				
				type : 'POST',
				url  : 'forventas.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-nueva-venta").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-nueva-venta").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO PRODUCTOS PARA VENTAS, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
						$("#btn-nueva-venta").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE POR FAVOR!</div></center>');
											
										$("#btn-nueva-venta").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center> &nbsp; '+data+' </center>');
	$('#descuento').attr("disabled", true);
	$('#btn-submit').attr("disabled", true);
	$('#cancelarv').attr("disabled", true);
	$('#vaciarv').attr("disabled", true);
	$('#img1').prop("disabled", true);
	$('#img2').prop("disabled", true);
	$("#buscaclientes")[0].reset();	
	$("#resultado").html("");
	$("#procesaventas").load("funciones.php?ProcesaVentas=si&codventa="+btoa(codventa));
	$("#btn-nueva-venta").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		         }
		}
	   /* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE VENTAS DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE VENTAS DE PRODUCTOS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#cerrarventas").validate({
     rules:
	  {
			tipodocumento: { required: true, },
			tipopagove: { required: true, },
			mediopagove: { required: true, },
			montopagado: { required: false, },
			montodevuelto: { required: true, },
			nombrebanco: { required: false, },
			nrodocumento: { required: false, },
			idformapago: { required: true, },
			montoabono: { required: true, },

	   },
       messages:
	   {
			tipodocumento:{  required: "Seleccione Tipo Documento" },
            tipopagove:{  required: "Seleccione Forma de Pago" },
			mediopagove:{  required: "Seleccione Medio de Pago" },
			montopagado:{  required: "Ingrese Monto Pagado" },
			montodevuelto:{  required: "Ingrese Monto Devuelto" },
			nombrebanco:{  required: "Ingrese Nombre de Banco" },
			nrodocumento:{  required: "Ingrese N&deg de Documento" },
			idformapago:{  required: "Seleccione Forma Pago SRI" },
			montoabono:{  required: "Ingrese Monto de Abono" },
			
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#cerrarventas").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=8><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
				

				$.ajax({
				
				type : 'POST',
				url  : 'forventas.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-cierra-venta").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-cierra-venta").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE NO TIENE CREDITO PARA VENTAS, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
						$("#btn-cierra-venta").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE SE HA EXCEDIDO DEL LIMITE EN EL MONTO DE VENTAS A CREDITO, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
						$("#btn-cierra-venta").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> SI EL ABONO DE CREDITO ES MAYOR O IGUAL AL TOTAL DE PAGO DE VENTA, POR FAVOR MODIFIQUE EL TIPO DE PAGO A CONTADO!</div></center>');
											
										$("#btn-cierra-venta").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#buscaclientes")[0].reset();	
						$("#resultado").html("");
						$("#procesaventas").load("funciones.php?nuevasventas=si");
						setTimeout(function() { $("#error").html(""); }, 10000);
						$("#btn-cierra-venta").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE VENTAS DE PRODUCTOS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE VENTAS DE PRODUCTOS */	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatedetallesventas").validate({
        rules:
	  {
			codventa: { required: true, },
			codproducto : { required: true, },
			producto: { required: true, },
			cantventa: { required: true, digits : true  },
			precioventa: { required: true, number : true },
	   },
       messages:
	   {
            codventa:{ required: "Ingrese C&oacute;digo de Venta" },
			codproducto : { required : "Ingrese C&oacute;digo Producto"  },
			producto:{  required: "Ingrese Descripci&oacute;n Producto"  },
			cantventa:{  required: "Ingrese Cantidad", digits: "Ingrese solo digitos"  },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },

       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatedetallesventas").serialize();
				var id= $("#updatedetallesventas").attr("data-id");
		        var coddetalleventa = id;
				
	            var exist = $('#existencia').val();
	            var producto = $('#producto').val();
				var cant = $('#cantventa').val();
				var cant2 = $('#cantidadventadb').val();
				cant    = parseInt(cant);
			    exist    = parseInt(exist);
	            total = parseInt(cant)-parseInt(cant2);
	            total2 = parseInt(cant2)-parseInt(cant);

	 
	          if (cant==0) {
	            
				$("#cantventa").focus();
				$('#cantventa').val("");
				$('#cantventa').css('border-color','#2b4049');
				alert('Por favor ingrese una Cantidad valida para Venta de Producto');
         
        return false;
		
		} else  { 

				$.ajax({
				
				type : 'POST',
				url  : 'editdetalleventas.php?coddetalleventa='+coddetalleventa,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LA CANTIDAD DE VENTA, NO PUEDE SER MAYOR QUE LA EXISTENCIA EN ALMACEN, VERIFIQUE EL MONTO POR FAVOR !</div></center>');
											
                       $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');										
									
									});

								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$('#btn-update').attr("disabled", true);
	$("#cargainput").load("funciones.php?muestracantventadb=si&coddetalleventa="+btoa(coddetalleventa));
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
    					setTimeout("location.href='detallesventas'", 5000);
				
				});
								}
						   }
				});
				return false;
	         }
		}
	   /* form submit */	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DETALLE DE VENTAS DE PRODUCTOS */ 
 




































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ABONOS DE CREDITOS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#abonoscreditos").validate({
     rules:
	  {
			montoabono: { required: true, },
	   },
       messages:
	   {
            montoabono:{  required: "Ingrese Monto de Abono" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#abonoscreditos").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=6><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
				var totaldebe = $('#totaldebe').val();
				var montoabono = $('#montoabono').val();
				totaldebe1    = parseFloat(totaldebe);
			    montoabono1    = parseFloat(montoabono);
	
	        if (montoabono==0.00 || montoabono=="") {
	            
				$("#montoabono").focus();
				$('#montoabono').css('border-color','#2b4049');
				alert('Por favor debe de ingresar un Monto valido para Abonar a Credito');
         
        return false;
	 
	  } else if (montoabono1 > totaldebe) {
	            
				$("#montoabono").focus();
				$("#montoabono").val("");
				$('#montoabono').css('border-color','#2b4049');
				alert('Por favor el Monto Abonado es Mayor al que Debe \n en esta Factura de Credito, verifique el Monto por favor');
         
        return false;
	 
	  } else {
				$.ajax({
				
				type : 'POST',
				url  : 'forcartera.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Abono');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR EL MONTO ABONADO ES MAYOR AL QUE DEBE EN ESTA FACTURA DE CREDITO, VERIFIQUE EL MONTO POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Abono');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#abonoscreditos")[0].reset();	
					    $("#muestraclientesabonos").html("");
						$("#muestraformularioabonos").html("");
						setTimeout(function() { $("#error").html(""); }, 80000);
						$("#btn-submit").html('<span class="fa fa-search"></span> Realizar Busqueda');
										
									});
								}
						   }
				});
				return false;
		         }
		}
	   /* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ABONOS DE CREDITOS */


