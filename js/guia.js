		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
                        var q1= $("#q1").val();
                        var q2= $("#q2").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_guia.php?action=ajax&page='+page+'&q='+q+'&q1='+q1+'&q2='+q2,
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

	
		
			
		
		
                
                function imprimir_cdrguia(guia){
			VentanaCentrada('./pdf/documentos/cdrguia/'+guia,'Factura','','1024','768','true');
		}
                function imprimir_xmlguia(guia){
			VentanaCentrada('./pdf/documentos/guia/'+guia,'Factura','','1024','768','true');
		}
                function imprimir_guia(guia){
			VentanaCentrada('./pdf/documentos/ver_guia.php?id_guia='+guia,'Factura','','1024','768','true');
		}

