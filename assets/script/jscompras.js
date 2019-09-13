/*function DoAction(codproducto, producto, principioactivo, descripcion, presentacion, codcategoria) {
    addItem(codproducto, 1, producto, principioactivo, descripcion, presentacion, codcategoria, '+=');
}*/

function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

    /* $("#busquedaproducto").keypress(function(e) {
        if (e.charCode == 13 || e.keyCode == 13) { //ENTER*/
            
        $("#AgregaC").click(function(){
            var code = $('input#codproducto').val();
            var prod = $('input#producto').val();
            var fam = $('select#codfamilia').val();
            var medida = $('select#codcategoria').val();
            var cantp = $('input#cantidad').val();
            var prec = $('input#preciocompra').val();
            var prec2 = $('input#precioventa').val();
            var descuen = $('input#descproducto').val();
            var marc = $('select#codmarca').val();
            var ivgprod = $('select#ivaproducto').val();
            var peso = $('input#peso').val();
            var er_num = /^([0-9])*[.]?[0-9]*$/;
            cantp = parseInt(cantp);
            //exist = parseInt(exist);
            cantp = cantp;

            if (code == "") {
                $("#codproducto").focus();
                $("#codproducto").css('border-color', '#f0ad4e');
                alert("Ingrese Codigo de Producto");
                return false;

            } else if (prod == "") {
                $("#producto").focus();
                $("#producto").css('border-color', '#f0ad4e');
                alert("Ingrese Nombre de Producto");
                return false;

            } else if (fam == "") {
                $("#codfamilia").focus();
                $("#codfamilia").css('border-color', '#f0ad4e');
                alert("Seleccione Familia de Producto");
                return false;

            } else if (fam == "") {
                $("#codcategoria").focus();
                $("#codcategoria").css('border-color', '#f0ad4e');
                alert("Seleccione Unidad de Medida de Producto");
                return false;

            } else if (marc == "") {
                $("#codmarca").focus();
                $("#codmarca").css('border-color', '#f0ad4e');
                alert("Seleccione Marca de Producto");
                return false;
                
            } else if(prec=="" || prec=="0.00"){
                $("#preciocompra").focus();
                $('#preciocompra').css('border-color','#f0ad4e');
                alert("Ingrese Precio de Compra de Producto valido");
                return false;
                
            } else if(!er_num.test($('#preciocompra').val())){
                $("#preciocompra").focus();
                $('#preciocompra').css('border-color','#f0ad4e');
                $("#preciocompra").val("");
                alert("Ingrese solo Numeros Positivos en Precio de Compra");
                return false;
                
            } else if(prec2=="" || prec2=="0.00"){
                $("#precioventa").focus();
                $('#precioventa').css('border-color','#f0ad4e');
                alert("Ingrese Precio de Venta de Producto valido");
                return false;
                
            } else if(!er_num.test($('#precioventa').val())){
                $("#precioventa").focus();
                $('#precioventa').css('border-color','#f0ad4e');
                $("#precioventa").val("");
                alert("Ingrese solo Numeros Positivos en Precio de Venta");
                return false;

            } else if (parseFloat(prec) > parseFloat(prec2)) {
                
                $("#precioventa").focus();
                $("#preciocompra").focus();
                $('#precioventa').css('border-color','#f0ad4e');
                $('#preciocompra').css('border-color','#f0ad4e');
                alert('El Precio de Compra no puede ser mayor al Precio de Venta del Producto');
                return false;

            } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#f0ad4e');
                alert("Ingrese una Cantidad valida para Compra");
                return false;

            } else if (isNaN($('#cantidad').val())) {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#f0ad4e');
                alert("Ingrese solo Numeros en Cantidad");
                return false;
                
            } else if(descuen==""){
                $("#descproducto").focus();
                $('#descproducto').css('border-color','#f0ad4e');
                alert("Ingrese Descuento de Producto");
                return false;
                
            } else if(!er_num.test($('#descproducto').val())){
                $("#descproducto").focus();
                $('#descproducto').css('border-color','#f0ad4e');
                $("#descproducto").val("");
                alert("Ingrese solo Numeros Positivos en Descuento");
                return false;
                
            } else if(ivgprod==""){
                $("#ivaproducto").focus();
                $('#ivaproducto').css('border-color','#f0ad4e');
                alert("Seleccione Si tiene Iva el Producto");
                return false;
                
            } else if(peso==""){
                $("#peso").focus();
                $('#peso').css('border-color','#f0ad4e');
                alert("Ingrese Peso de Producto");
                return false;

            } else {

                var Carrito = new Object();
                Carrito.Codigo = $('input#codproducto').val();
                Carrito.Producto = $('input#producto').val();
                Carrito.Fabricante = $('input#fabricante').val();
                Carrito.Familia = $('select#codfamilia').val();
                Carrito.Subfamilia = $('select#codsubfamilia').val();
                Carrito.Marca = $('select#codmarca').val();
                Carrito.Modelo = $('select#codmodelo').val();
                Carrito.Presentacion = $('select#codpresentacion').val();
                Carrito.Origen = $('select#codorigen').val();
                Carrito.Precio      = $('input#preciocompra').val();
                Carrito.Precio2      = $('input#precioventa').val();
                Carrito.Precio3      = $('input#precioventab').val();
                Carrito.Precio4      = $('input#precioventac').val();
                Carrito.Precio5      = $('input#precioventad').val();
                Carrito.Peso      = $('input#peso').val();
                Carrito.Descfactura      = $('input#descfactura').val();
                Carrito.Descproducto      = $('input#descproducto').val();
                Carrito.Ivaproducto = $('select#ivaproducto').val();
                Carrito.Barra = $('input#codigobarra').val();
                Carrito.Barra2 = $('input#codigobarrab').val();
                Carrito.Fechaelaboracion = $('input#fechaelaboracion').val();
                Carrito.Fechaexpiracion = $('input#fechaexpiracion').val();
                Carrito.Precioconiva = $('input#precioconiva').val();
                Carrito.Cantidad = $('input#cantidad').val();
                Carrito.opCantidad = '+=';
                var DatosJson = JSON.stringify(Carrito);
                $.post('carritocompras.php', {
                        MiCarrito: DatosJson
                    },
                    function(data, textStatus) {
                        $("#carrito tbody").html("");
                        var SubtotalFact = 0;
                        var BaseImpIva1 = 0;
                        var contador = 0;
                        var iva = 0;
                        var total = 0;
                        var TotalCompra = 0;

                        $.each(data, function(i, item) {
                            var cantsincero = item.cantidad;
                            cantsincero = parseInt(cantsincero);
                            if (cantsincero != 0) {
                                contador = contador + 1;

                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio * item.descfactura / 100;
                var descconiva = item.precioconiva * item.descfactura / 100;

                //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
                var Operac= parseFloat(item.precio) - parseFloat(descsiniva);
                var Operacion= parseFloat(Operac) * parseFloat(item.cantidad);
                var Subtotal = Operacion.toFixed(2);

                //CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
                var Operac3 = parseFloat(item.precioconiva) - parseFloat(descconiva);
                var Operacion3 = parseFloat(Operac3) * parseFloat(item.cantidad);
                var Subbaseimponiva = Operacion3.toFixed(2);

                //BASE IMPONIBLE IVA CON PORCENTAJE
                BaseImpIva1 = parseFloat(BaseImpIva1) + parseFloat(Subbaseimponiva);
                
                //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                var ivg = $('input#iva').val();
                ivg2  = ivg/100;
                TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
                
                //SUBTOTAL GENERAL DE FACTURA
                SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);
                //BASE IMPONIBLE IVA SIN PORCENTAJE
                BaseImpIva2 = parseFloat(SubtotalFact) - parseFloat(BaseImpIva1);
                
                //CALCULAMOS DESCUENTO POR PRODUCTO
                var desc = $('input#descuento').val();
                desc2  = desc/100;
                
                //CALCULO DEL TOTAL DE FACTURA
                Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
                TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
                TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));



                var nuevaFila =
                    "<tr>" +
                        "<td><div align='center'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'-1'," +
                        "'" + item.producto + "'," +
                        "'" + item.fabricante + "'," +
                        "'" + item.familia + "'," +
                        "'" + item.subfamilia + "'," +
                        "'" + item.marca + "', " +
                        "'" + item.modelo + "', " +
                        "'" + item.presentacion + "', " +
                        "'" + item.origen + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.precio4 + "', " +
                        "'" + item.precio5 + "', " +
                        "'" + item.peso + "', " +
                        "'" + item.descfactura + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.barra + "', " +
                        "'" + item.barra2 + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.precioconiva + "', " +
                        "'-'" +
                        ')"' +
                        " type='button'><span class='fa fa-minus'></span></button>" +
                        "<input type='text' id='" + item.cantidad + "' style='width:25px;height:24px;border:#FF0000;' value='" + item.cantidad + "'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'+1'," +
                        "'" + item.producto + "'," +
                        "'" + item.fabricante + "'," +
                        "'" + item.familia + "'," +
                        "'" + item.subfamilia + "'," +
                        "'" + item.marca + "', " +
                        "'" + item.modelo + "', " +
                        "'" + item.presentacion + "', " +
                        "'" + item.origen + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.precio4 + "', " +
                        "'" + item.precio5 + "', " +
                        "'" + item.peso + "', " +
                        "'" + item.descfactura + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.barra + "', " +
                        "'" + item.barra2 + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.precioconiva + "', " +
                        "'+'" +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></div></td>" +
                        "<td><div align='center'>" + item.txtCodigo + "<input type='hidden' value='" + item.marca + "'><input type='hidden' value='" + item.modelo + "'><input type='hidden' value='" + item.descproducto + "'></div></td>" +
                        "<td><div align='center'>" + item.producto + "<input type='hidden' value='" + item.fabricante + "'><input type='hidden' value='" + item.presentacion + "'><input type='hidden' value='" + item.precio3 + "'></div></td>" +
                        "<td><div align='center'>" + item.precio + "<input type='hidden' value='" + item.precio2 + "'><input type='hidden' value='" + item.origen + "'><input type='hidden' value='" + item.precio4 + "'></div></td>" +
                        "<td><div align='center'>" + item.descfactura + "<input type='hidden' value='" + item.fechaelaboracion + "'><input type='hidden' value='" + item.fechaexpiracion + "'><input type='hidden' value='" + item.precio5 + "'></div></td>" +
                        "<td><div align='center'>" + item.ivaproducto + "<input type='hidden' value='" + item.precioconiva + "'><input type='hidden' value='" + item.familia + "'><input type='hidden' value='" + item.barra + "'></div></td>" +
                        "<td><div align='center'>" + Operacion.toFixed(2) + "<input type='hidden' value='" + item.subfamilia + "'><input type='hidden' value='" + item.peso + "'><input type='hidden' value='" + item.barra2 + "'></div></td>" +
                        "<td><div align='center'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;color:#fff;" ' +
                        'onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'0'," +
                        "'" + item.producto + "'," +
                        "'" + item.fabricante + "'," +
                        "'" + item.familia + "'," +
                        "'" + item.subfamilia + "'," +
                        "'" + item.marca + "', " +
                        "'" + item.modelo + "', " +
                        "'" + item.presentacion + "', " +
                        "'" + item.origen + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.precio4 + "', " +
                        "'" + item.precio5 + "', " +
                        "'" + item.peso + "', " +
                        "'" + item.descfactura + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.barra + "', " +
                        "'" + item.barra2 + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.precioconiva + "', " +
                        "'='" +
                        ')"' +
                        ' type="button"><span class="fa fa-trash-o"></span></button>' +
                                    "</div></td>" +
                                    "</tr>";
                                $(nuevaFila).appendTo("#carrito tbody");
                                    
                            $("#lblsubtotal").text(BaseImpIva1.toFixed(2));
                            $("#lblsubtotal2").text(BaseImpIva2.toFixed(2));
                            $("#lbliva").text(TotalIvaGeneral.toFixed(2));
                            $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
                            $("#lbltotal").text(TotalFactura.toFixed(2));
                            
                            $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
                            $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
                            $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                            $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                            $("#txtTotal").val(TotalFactura.toFixed(2));

                            }

                        });

                        $("#busquedaproductoc").focus();
                        LimpiarTexto();
                    },
                    "json"
                );
                return false;
            //}
        }
    });

$("#vaciarc").click(function() {
        var Carrito = new Object();
        Carrito.Codigo = "vaciar";
        Carrito.Producto = "vaciar";
        Carrito.Fabricante = "vaciar";
        Carrito.Familia= "vaciar";
        Carrito.Subfamilia = "vaciar";
        Carrito.Marca = "vaciar";
        Carrito.Modelo = "vaciar";
        Carrito.Presentacion = "vaciar";
        Carrito.Origen = "vaciar";
        Carrito.Precio      = "0";
        Carrito.Precio2      = "0";
        Carrito.Precio3      = "0";
        Carrito.Precio4      = "0";
        Carrito.Precio5      = "0";
        Carrito.Peso      = "0";
        Carrito.Descfactura      = "0";
        Carrito.Descproducto      = "0";
        Carrito.Ivaproducto = "vaciar";
        Carrito.Barra = "vaciar";
        Carrito.Barra2 = "vaciar";
        Carrito.Fechaelaboracion = "vaciar";
        Carrito.Fechaexpiracion = "vaciar";
        Carrito.Precioconiva      = "0";
        Carrito.Cantidad = "0";
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritocompras.php', {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
         "<tr>"+"<td colspan=8><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                LimpiarTexto();
            },
            "json"
        );
        return false;
    });

$(document).ready(function() {
    $('#vaciarc').click(function() {
    $("#compras")[0].reset();
    $("#carrito tbody").html("");
    var nuevaFila =
    "<tr>"+"<td colspan=8><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
    $(nuevaFila).appendTo("#carrito tbody");
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
   });
});

//FUNCION PARA CARGAR PRECIO CON IVA
$(document).ready(function() {
        $('#ivaproducto').on('change', function() {
        var valor = $("#ivaproducto").val();
        var precio = $("#preciocompra").val();
        var precioiva = $("#precioconiva").val();

       if (valor === "SI" || valor === true) {

           $("#precioconiva").val(precio); 
} else {
           $("#precioconiva").val("0.00"); 
             } 
       });
});


//FUNCION PARA CARGAR PRECIO CON IVA
$(document).ready(function (){
        $('#preciocompra').keyup(function (){
        var precio = $('input#preciocompra').val();
        var precioconiva = $("input#precioconiva").val();
     $("#precioconiva").val(precio); 
     });
 });


//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON DESCUENTO
$(document).ready(function (){
          $('#descuento').keyup(function (){
        
            var txtsubtotal = $('input#txtsubtotal').val();
            var txtsubtotal2 = $('input#txtsubtotal2').val();
            var txtIva = $('input#txtIva').val();
            var desc = $('input#descuento').val();
            descuento  = desc/100;
                        
            //REALIZO EL CALCULO CON EL DESCUENTO INDICADO
            Subtotal = parseFloat(txtsubtotal) + parseFloat(txtsubtotal2) + parseFloat(txtIva); 
            TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
            TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));        
        
            $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
            $("#lbltotal").text(TotalFactura.toFixed(2));
            $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
            $("#txtTotal").val(TotalFactura.toFixed(2));
         });
 });



    $("#carrito tbody").on('keydown', 'input', function(e) {
        var element = $(this);
        var pvalue = element.val();
        var code = e.charCode || e.keyCode;
        var avalue = String.fromCharCode(code);
        var action = element.siblings('button').first().attr('onclick');
        var params;
        if (code !== 23 && /[^\d]/ig.test(avalue)) {
            e.preventDefault();
            return;
        }
        if (element.attr('data-proc') == '1') {
            return true;
        }
        element.attr('data-proc', '1');
        params = action.match(/\'([^\']+)\'/g).map(function(v) {
            return v.replace(/\'/g, '');
        });
        setTimeout(function() {
            if (element.attr('data-proc') == '1') {
                var value = element.val() || 0;
                addItem(
                    params[0],
                    value,
                    params[2],
                    params[3],
                    params[4],
                    params[5],
                    params[6],
                    params[7],
                    params[8],
                    params[9],
                    params[10],
                    params[11],
                    params[12],
                    params[13],
                    params[14],
                    params[15],
                    params[16],
                    params[17],
                    params[18],
                    params[19],
                    params[20],
                    params[21],
                    params[22],
                    params[23],
                    '='
                );
                element.attr('data-proc', '0');
            }
        }, 500);
    });
});

function LimpiarTexto() {
    $("#busquedaproductoc").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#fabricante").val("");
    $("#codfamilia").val("");
    $("#codsubfamilia").val("0");
    $("#codmarca").val("");
    $("#codmodelo").val("0");
    $("#codpresentacion").val("");
    $("#codorigen").val("");
    $("#preciocompra").val("");
    $("#precioventa").val("");
    $("#precioventab").val("");
    $("#precioventac").val("");
    $("#precioventad").val("");
    $("#peso").val("");
    $("#descfactura").val("0.00");
    $("#descproducto").val("0.00");
    $("#ivaproducto").val("");
    $("#codigobarra").val("");
    $("#codigobarrab").val("");
    $("#fechaelaboracion").val("");
    $("#fechaexpiracion").val("");
    $("#precioconiva").val("");
    $("#cantidad").val("");
}

function addItem(codigo, cantidad, producto, fabricante, familia, subfamilia, marca, modelo, presentacion, origen, precio, precio2, precio3, precio4, precio5, peso, descfactura, descproducto, ivaproducto, barra, barra2, fechaelaboracion, fechaexpiracion, precioconiva, opCantidad) {
    var Carrito = new Object();
    Carrito.Codigo = codigo;
    Carrito.Producto = producto;
    Carrito.Fabricante = fabricante;
    Carrito.Familia = familia;
    Carrito.Subfamilia = subfamilia;
    Carrito.Marca = marca;
    Carrito.Modelo = modelo;
    Carrito.Presentacion = presentacion;
    Carrito.Origen = origen;
    Carrito.Precio = precio;
    Carrito.Precio2 = precio2;
    Carrito.Precio3 = precio3;
    Carrito.Precio4 = precio4;
    Carrito.Precio5 = precio5;
    Carrito.Peso = peso;
    Carrito.Descfactura = descfactura;
    Carrito.Descproducto = descproducto;
    Carrito.Ivaproducto = ivaproducto;
    Carrito.Barra = barra;
    Carrito.Barra2 = barra2;
    Carrito.Fechaelaboracion = fechaelaboracion;
    Carrito.Fechaexpiracion = fechaexpiracion;
    Carrito.Precioconiva      = precioconiva;
    Carrito.Cantidad = cantidad;
    Carrito.opCantidad = opCantidad;
    var DatosJson = JSON.stringify(Carrito);
    $.post('carritocompras.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var SubtotalFact = 0;
            var BaseImpIva1 = 0;
            var contador = 0;
            var iva = 0;
            var total = 0;
            var TotalCompra = 0;

            $.each(data, function(i, item) {
                var cantsincero = item.cantidad;
                cantsincero = parseInt(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;

                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio * item.descfactura / 100;
                var descconiva = item.precioconiva * item.descfactura / 100;

                //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
                var Operac= parseFloat(item.precio) - parseFloat(descsiniva);
                var Operacion= parseFloat(Operac) * parseFloat(item.cantidad);
                var Subtotal = Operacion.toFixed(2);

                //CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
                var Operac3 = parseFloat(item.precioconiva) - parseFloat(descconiva);
                var Operacion3 = parseFloat(Operac3) * parseFloat(item.cantidad);
                var Subbaseimponiva = Operacion3.toFixed(2);

                //BASE IMPONIBLE IVA CON PORCENTAJE
                BaseImpIva1 = parseFloat(BaseImpIva1) + parseFloat(Subbaseimponiva);
                
                //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                var ivg = $('input#iva').val();
                ivg2  = ivg/100;
                TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
                
                //SUBTOTAL GENERAL DE FACTURA
                SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);
                //BASE IMPONIBLE IVA SIN PORCENTAJE
                BaseImpIva2 = parseFloat(SubtotalFact) - parseFloat(BaseImpIva1);
                
                //CALCULAMOS DESCUENTO POR PRODUCTO
                var desc = $('input#descuento').val();
                desc2  = desc/100;
                
                //CALCULO DEL TOTAL DE FACTURA
                Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
                TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
                TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));



                   var nuevaFila =
                    "<tr>" +
                        "<td><div align='center'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'-1'," +
                        "'" + item.producto + "'," +
                        "'" + item.fabricante + "'," +
                        "'" + item.familia + "'," +
                        "'" + item.subfamilia + "'," +
                        "'" + item.marca + "', " +
                        "'" + item.modelo + "', " +
                        "'" + item.presentacion + "', " +
                        "'" + item.origen + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.precio4 + "', " +
                        "'" + item.precio5 + "', " +
                        "'" + item.peso + "', " +
                        "'" + item.descfactura + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.barra + "', " +
                        "'" + item.barra2 + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.precioconiva + "', " +
                        "'-'" +
                        ')"' +
                        " type='button'><span class='fa fa-minus'></span></button>" +
                        "<input type='text' id='" + item.cantidad + "' style='width:25px;height:24px;border:#FF0000;' value='" + item.cantidad + "'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'+1'," +
                        "'" + item.producto + "'," +
                        "'" + item.fabricante + "'," +
                        "'" + item.familia + "'," +
                        "'" + item.subfamilia + "'," +
                        "'" + item.marca + "', " +
                        "'" + item.modelo + "', " +
                        "'" + item.presentacion + "', " +
                        "'" + item.origen + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.precio4 + "', " +
                        "'" + item.precio5 + "', " +
                        "'" + item.peso + "', " +
                        "'" + item.descfactura + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.barra + "', " +
                        "'" + item.barra2 + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.precioconiva + "', " +
                        "'+'" +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></div></td>" +
                        "<td><div align='center'>" + item.txtCodigo + "<input type='hidden' value='" + item.marca + "'><input type='hidden' value='" + item.modelo + "'><input type='hidden' value='" + item.descproducto + "'></div></td>" +
                        "<td><div align='center'>" + item.producto + "<input type='hidden' value='" + item.fabricante + "'><input type='hidden' value='" + item.presentacion + "'><input type='hidden' value='" + item.precio3 + "'></div></td>" +
                        "<td><div align='center'>" + item.precio + "<input type='hidden' value='" + item.precio2 + "'><input type='hidden' value='" + item.origen + "'><input type='hidden' value='" + item.precio4 + "'></div></td>" +
                        "<td><div align='center'>" + item.descfactura + "<input type='hidden' value='" + item.fechaelaboracion + "'><input type='hidden' value='" + item.fechaexpiracion + "'><input type='hidden' value='" + item.precio5 + "'></div></td>" +
                        "<td><div align='center'>" + item.ivaproducto + "<input type='hidden' value='" + item.precioconiva + "'><input type='hidden' value='" + item.familia + "'><input type='hidden' value='" + item.barra + "'></div></td>" +
                        "<td><div align='center'>" + Operacion.toFixed(2) + "<input type='hidden' value='" + item.subfamilia + "'><input type='hidden' value='" + item.peso + "'><input type='hidden' value='" + item.barra2 + "'></div></td>" +
                        "<td><div align='center'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;color:#fff;" ' +
                        'onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'0'," +
                        "'" + item.producto + "'," +
                        "'" + item.fabricante + "'," +
                        "'" + item.familia + "'," +
                        "'" + item.subfamilia + "'," +
                        "'" + item.marca + "', " +
                        "'" + item.modelo + "', " +
                        "'" + item.presentacion + "', " +
                        "'" + item.origen + "', " +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.precio3 + "', " +
                        "'" + item.precio4 + "', " +
                        "'" + item.precio5 + "', " +
                        "'" + item.peso + "', " +
                        "'" + item.descfactura + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.barra + "', " +
                        "'" + item.barra2 + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'" + item.precioconiva + "', " +
                        "'='" +
                        ')"' +
                        ' type="button"><span class="fa fa-trash-o"></span></button>' +
                                    "</div></td>" +
                                    "</tr>";
                    $(nuevaFila).appendTo("#carrito tbody");
                                    
                $("#lblsubtotal").text(BaseImpIva1.toFixed(2));
                $("#lblsubtotal2").text(BaseImpIva2.toFixed(2));
                $("#lbliva").text(TotalIvaGeneral.toFixed(2));
                $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
                $("#lbltotal").text(TotalFactura.toFixed(2));
                
                $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
                $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
                $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                $("#txtTotal").val(TotalFactura.toFixed(2));

                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila =
            "<tr>"+"<td colspan=8><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#compras")[0].reset();
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

            }
            LimpiarTexto();
        },
        "json"
    );
    return false;
}