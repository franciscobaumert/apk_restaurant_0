		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
                        var q1= $("#q1").val();
                        var q2= $("#q2").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_facturaseliminadas.php?action=ajax&page='+page+'&q='+q+'&q1='+q1+'&q2='+q2,
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

	
		
			
		
		function imprimir_factura(id_factura){
			VentanaCentrada('./pdf/documentos/ver_factura.php?id_factura='+id_factura,'Factura','','1024','768','true');
		}
                 function imprimir_facturas1(id_factura){
			VentanaCentrada('./pdf/documentos/bajaDocumento1.php?id_factura='+id_factura,'Factura','','300','300','true');
                        location.reload(true);
                 }

                
                function xml(id_factura){
			VentanaCentrada('./pdf/documentos/documentos/'+id_factura,'Factura','','1024','768','true');
		}
                
                function cdrxml(id_factura){
			VentanaCentrada('./pdf/documentos/cdrdocumentos/'+id_factura,'Documento de baja','','1024','768','true');
		}
               