$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_categorias.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
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
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
	function obtener_datos(id){
			var nom_cat = $("#nom_cat"+id).val();
                        var des_cat = $("#des_cat"+id).val(); 
                        $("#mod_cat").val(nom_cat);
                        $("#mod_des").val(des_cat);
                        $("#mod_id").val(id);
		
		}	
		
		

