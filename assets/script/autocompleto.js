// FUNCION AUTOCOMPLETE PARA PRODUCTOS, SERVICIOS Y CLIENTES

$(function() {
    $("#busquedaproductoc").autocomplete({
        source: "class/buscaproductos.php",
        minLength: 1,
        select: function(event, ui) {
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#fabricante').val(ui.item.fabricante);
            $('#codfamilia').val(ui.item.codfamilia);
            $('#codsubfamilia').val(ui.item.codsubfamilia);
            $('#codmarca').val(ui.item.codmarca);
            $('#marcas').val(ui.item.nommarca);
            $('#codmodelo').val(ui.item.codmodelo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#codorigen').val(ui.item.codorigen);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioventa').val(ui.item.precioventa);
            $('#precioventab').val(ui.item.precioventab);
            $('#precioventac').val(ui.item.precioventac);
            $('#precioventad').val(ui.item.precioventad);
            $('#peso').val(ui.item.peso);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.preciocompra : "0.00");
            $('#existencia').val(ui.item.existencia);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto2').val(ui.item.descproducto);
            $('#codigobarra').val(ui.item.codigobarra);
            $('#codigobarrab').val(ui.item.codigobarrab);
            $("#cantidad").focus();
        }
    });
});


$(function() {
    $("#busquedaproducto").autocomplete({
        source: "class/buscaproductos.php",
        minLength: 1,
        select: function(event, ui) {
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#fabricante').val(ui.item.fabricante);
            $('#codfamilia').val(ui.item.codfamilia);
            $('#codsubfamilia').val(ui.item.codsubfamilia);
            $('#codmarca').val(ui.item.codmarca);
            $('#marcas').val(ui.item.nommarca);
            $('#codmodelo').val(ui.item.codmodelo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#codorigen').val(ui.item.codorigen);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioventa').val(ui.item.precioventa);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioventa : "0.00");
            $('#existencia').val(ui.item.existencia);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $("#cantidad").focus(); 
        }
    });
});

$(function() {
           $("#marcas").autocomplete({
           source: "class/buscamarcas.php",
       minLength: 1,
           select: function(event, ui) { 
       $('#codmarca').val(ui.item.codmarca);
           }  
        });
 });


$(function() {
           $("#lote").autocomplete({
           source: "class/buscalotes.php",
		   minLength: 1,
           select: function(event, ui) { 
		   $('#lote').val(ui.item.lote);
           }  
        });
 });

 $(function() {
           $("#servicio").autocomplete({
           source: "class/buscaservicios.php",
		   minLength: 1,
           select: function(event, ui) { 
		   $('#coditems').val(ui.item.coditems);
		   $('#precio').val(ui.item.costoitems);
           }  
        });
 });


$(function() {
           $("#busqueda").autocomplete({
           source: "class/buscacliente.php",
		       minLength: 1,
           select: function(event, ui) { 
		    $('#codcliente').val(ui.item.codcliente);
           }  
      });
 });
