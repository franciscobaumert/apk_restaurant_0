		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
                        var q1= $("#q1").val();
                        var q2= $("#q2").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_facturas.php?action=ajax&page='+page+'&q='+q+'&q1='+q1+'&q2='+q2,
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
		if (confirm("Realmente deseas eliminar la venta")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_facturas.php",
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
		
		function imprimir_factura(id_factura){
			VentanaCentrada('./pdf/documentos/ver_factura.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}
                
                function imprimir_factura1(id_factura){
			VentanaCentrada('email/index.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}

function imprimir_factura2(id_factura){
			VentanaCentrada('./pdf/documentos/ver_ticket.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}
function imprimir_facturas(id_factura){
			VentanaCentrada('./pdf/documentos/ver_factura3.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}