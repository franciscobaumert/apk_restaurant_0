		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_usuarios.php?action=ajax&page='+page+'&q='+q,
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
		if (confirm("Realmente deseas eliminar el usuario")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_usuarios.php",
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
		
		
		
		

