/*$(document).ready(function (){
          $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
        });*/



// FUNCION PARA DARLE TITULO A TODOS LOS ARCHIVOS
$(document).ready(function() {

document.title = '.:: Sistema de Facturacion Electronica | Developer Technology ::.';		
$(".current-year").text((new Date).getFullYear() + ' CopyRight. Todos los derechos reservados. Developer Technology.');
$(".logo").text('FACTURACION');
$(".logout").text('Salir');
		
});    
	  
	  
// FUNCION PARA PERMITIR CAMPOS NUMEROS
function NumberFormat(num, numDec, decSep, thousandSep){
    var arg;
    var Dec;
    Dec = Math.pow(10, numDec); 
    if (typeof(num) == 'undefined') return; 
    if (typeof(decSep) == 'undefined') decSep = ',';
    if (typeof(thousandSep) == 'undefined') thousandSep = '.';
    if (thousandSep == '.')
     arg=/./g;
    else
     if (thousandSep == ',') arg=/,/g;
    if (typeof(arg) != 'undefined') num = num.toString().replace(arg,'');
    num = num.toString().replace(/,/g, '.'); 
    if (isNaN(num)) num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * Dec + 0.50000000001);
    cents = num % Dec;
    num = Math.floor(num/Dec).toString(); 
    if (cents < (Dec / 10)) cents = "0" + cents; 
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
     num = num.substring(0, num.length - (4 * i + 3)) + thousandSep + num.substring(num.length - (4 * i + 3));
    if (Dec == 1)
     return (((sign)? '': '-') + num);
    else
     return (((sign)? '': '-') + num + decSep + cents);
   } 

   function EvaluateText(cadena, obj){
    opc = false; 
    if (cadena == "%d")
     if (event.keyCode > 47 && event.keyCode < 58)
      opc = true;
    if (cadena == "%f"){ 
     if (event.keyCode > 47 && event.keyCode < 58)
      opc = true;
     if (obj.value.search("[.*]") == -1 && obj.value.length != 0)
      if (event.keyCode == 46)
       opc = true;
    }
    if(opc == false)
     event.returnValue = false; 
   }
   
   $(document).ready(function(){ 
$(".number").keydown(function(event) {
   if(event.shiftKey)
   {
        event.preventDefault();
   }
 
   if (event.keyCode == 46 || event.keyCode == 8)    {
   }
   else {
        if (event.keyCode < 95) {
          if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
          }
        } 
        else {
              if (event.keyCode < 96 || event.keyCode > 105) {
                  event.preventDefault();
              }
        }
      }
   });
});
   
  
function getTime()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            var num = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
      var mt = "AM";

         // Pongo el formato 12 horas
      if (h> 12) {
      mt = "PM";
      h = h - 12;
      }
      if (h == 0) h = 12;
      // Pongo minutos y segundos con dos digitos
      //if (m <= 9) m = "0" + m;
      //if (s <= 9) s = "0" + s;
      
            // add a zero in front of numbers<10
            m=checkTime(m);
            s=checkTime(s);
document.getElementById('fecharegistro').value= today.getDate() + "-" + num[today.getMonth()] + "-" + today.getFullYear() + " " + h+":"+m+":"+s;
$('#result3').html(today.getDate() + "-" + num[today.getMonth()] + "-" + today.getFullYear() + " " + h+":"+m+":"+s);
            t=setTimeout(function(){getTime()},500);
        }

        function checkTime(i)
        {
            if (i<10)
            {
                i="0" + i;
            }
            return i;
        }

function muestraReloj()
{
// Compruebo si se puede ejecutar el script en el navegador del usuario
if (!document.layers && !document.all && !document.getElementById) return;
// Obtengo la hora actual y la divido en sus partes
var fechacompleta = new Date();
var horas = fechacompleta.getHours();
var minutos = fechacompleta.getMinutes();
var segundos = fechacompleta.getSeconds();
var mt = "AM";
// Pongo el formato 12 horas
if (horas> 12) {
mt = "PM";
horas = horas - 12;
}
if (horas == 0) horas = 12;
// Pongo minutos y segundos con dos digitos
if (minutos <= 9) minutos = "0" + minutos;
if (segundos <= 9) segundos = "0" + segundos;
// En la variable 'cadenareloj' puedes cambiar los colores y el tipo de fuente
//cadenareloj = "<font size='-1' face='verdana'>" + horas + ":" + minutos + ":" + segundos + " " + mt + "</font>";
cadenareloj =horas + ":" + minutos + ":" + segundos + " " + mt;
// Escribo el reloj de una manera u otra, segun el navegador del usuario
if (document.layers) {
document.layers.spanreloj.document.write(cadenareloj);
document.layers.spanreloj.document.close();
}
else if (document.all) spanreloj.innerHTML = cadenareloj;
else if (document.getElementById) document.getElementById("spanreloj").innerHTML = cadenareloj;
// Ejecuto la funcion con un intervalo de un segundo
setTimeout("muestraReloj()", 1000);
}

//////// FUNCIONES PARA MOSTRAR MENSAJES DE ALERTA DE ACTUALIZAR, ELIMINAR Y PAGAR REGISTROS
function ajustarstock(url)
{
  if(confirm('ESTA SEGURO DE AJUSTAR EL STOCK DE ESTE PRODUCTO?'))
  {
    window.location=url;
  }
}

function actualizar(url)
{
	if(confirm('ESTA SEGURO DE ACTUALIZAR ESTE REGISTRO ?'))
	{
		window.location=url;
	}
}

function eliminar(url)
{
	if(confirm('ESTA SEGURO DE ELIMINAR ESTE REGISTRO ?'))
	{
		window.location=url;
	}
}

function pagar(url)
{
	if(confirm('ESTA SEGURO DE PROCESAR EL PAGO DE ESTA FACTURA DE COMPRA ?'))
	{
		window.location=url;
	}
}



function actualizarp(url)
{
  if(confirm('ESTA SEGURO DE ACTUALIZAR ESTE PEDIDO ?'))
  {
    window.location=url;
  }
}

function eliminarp(url)
{
  if(confirm('ESTA SEGURO DE ELIMINAR ESTE PEDIDO ?'))
  {
    window.location=url;
  }
}

function actualizardp(url)
{
  if(confirm('ESTA SEGURO DE ACTUALIZAR ESTE DETALLE DE PEDIDO ?'))
  {
    window.location=url;
  }
}

function eliminardp(url)
{
  if(confirm('ESTA SEGURO DE ELIMINAR ESTE DETALLE DE PEDIDO ?'))
  {
    window.location=url;
  }
}



function actualizarc(url)
{
  if(confirm('ESTA SEGURO DE ACTUALIZAR ESTE DETALLE DE COMPRA ?'))
  {
    window.location=url;
  }
}

function eliminarc(url)
{
  if(confirm('ESTA SEGURO DE ELIMINAR ESTE DETALLE DE COMPRA ?'))
  {
    window.location=url;
  }
}

function cerrarcaja(url)
{
  if(confirm('ESTA SEGURO DE REALIZAR EL CIERRE DE ESTA CAJA ?'))
  {
    window.location=url;
  }
}


function actualizarv(url)
{
  if(confirm('ESTA SEGURO DE ACTUALIZAR ESTE DETALLE DE VENTA ?'))
  {
    window.location=url;
  }
}

function eliminarv(url)
{
  if(confirm('ESTA SEGURO DE ELIMINAR ESTE DETALLE DE VENTA ?'))
  {
    window.location=url;
  }
}

function verificaeliminar()
{
  alert('ESTE DETALLE DE VENTA NO PUEDE ELIMINARSE,\nLA FECHA DE VENTA ES DIFERENTE A LA ACTUAL ');
}





////FUNCION MUESTRA CAMPO PARA NUEVOS PRODUCTOS
function mostrar(){

     var botonAccion =  document.getElementById('boton');
     var div = document.getElementById('nuevoproducto');


     if(div.style.display==='block'){

       div.style.display = "none";

       //Actualizamos el nombre del botón

       botonAccion.value = "SI";

     } else {

       div.style.display = "block";

       //Actualizamos el nombre del botón

       botonAccion.value= "NO";

         }
  }




$(document).ready(function(){
        $("tr").each(function(){
            $(this).children("td").each(function(){
                switch ($(this).html()) {
                    case 'A':
                        $(this).css("background-color", "#F00");
                    break;
                    case 'B':
                        $(this).css("background-color", "#0F0");
                    break;
                    case 'C':
                        $(this).css("background-color", "#00F");
                    break;
                }
            })
        })
    });




//////////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR REGISTROS //////////////////////////////////////////////////////////////////

// FUNCION PARA MOSTRAR EMPRESA EN VENTANA MODAL
function VerEmpresa(id){

$('#muestraempresamodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaEmpresaModal=si&id='+btoa(id);

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraempresamodal').empty();
                $('#muestraempresamodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

// FUNCION PARA MOSTRAR USUARIOS EN VENTANA MODAL
function VerUsuario(codigo){

$('#muestrausuariomodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								
var dataString = 'BuscaUsuarioModal=si&codigo='+btoa(codigo);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrausuariomodal').empty();
                $('#muestrausuariomodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

// FUNCION PARA MOSTRAR PRODUCTOS EN VENTANA MODAL
function VerProducto(codproducto){

$('#muestraproductomodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								
var dataString = 'BuscaProductoModal=si&codproducto='+codproducto;

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraproductomodal').empty();
                $('#muestraproductomodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


// FUNCION PARA MOSTRAR FOTO DE PRODUCTOS EN VENTANA MODAL
function VerImagen(codproducto){

$('#muestrafotoproductomodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaFotoProductoModal=si&codproducto='+codproducto;

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrafotoproductomodal').empty();
                $('#muestrafotoproductomodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

// FUNCION PARA MOSTRAR ITEMS DE SERVICIOS EN VENTANA MODAL
function VerItems(iditems){

$('#muestraitemmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								
var dataString = 'BuscaItemModal=si&iditems='+btoa(iditems);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraitemmodal').empty();
                $('#muestraitemmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
          }
      });
}



// FUNCION PARA MOSTRAR CLIENTES EN VENTANA MODAL
function VerCliente(codcliente){

$('#muestraclientemodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								
var dataString = 'BuscaClienteModal=si&codcliente='+btoa(codcliente);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraclientemodal').empty();
                $('#muestraclientemodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


// FUNCION PARA MOSTRAR PROVEEDOR EN VENTANA MODAL
function VerProveedor(codproveedor){

$('#muestraproveedormodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								
var dataString = 'BuscaProveedorModal=si&codproveedor='+btoa(codproveedor);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraproveedormodal').empty();
                $('#muestraproveedormodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


// FUNCION PARA MOSTRAR ARQUEO DE CAJA EN VENTANA MODAL
function VerArqueo(codarqueo){

$('#muestraarqueomodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaArqueoCajaModal=si&codarqueo='+codarqueo;

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraarqueomodal').empty();
                $('#muestraarqueomodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

// FUNCION PARA MOSTRAR MOVIMIENTO DE CAJA EN VENTANA MODAL
function VerMovimientoCaja(codmovimientocaja){

$('#muestramovimientocajamodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaMovimientoCajaModal=si&codmovimientocaja='+codmovimientocaja;

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestramovimientocajamodal').empty();
                $('#muestramovimientocajamodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}



// FUNCION PARA MOSTRAR PROVINCIAS POR DEPARTAMENTOS
function CargaProvincias(iddepartamento){

$('#idprovincia').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaProvincias=si&iddepartamento='+iddepartamento;

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#idprovincia').empty();
                $('#idprovincia').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


// FUNCION PARA MOSTRAR DISTRITOS POR PROVINCIAS
function CargaDistritos(idprovincia){

$('#iddistrito').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaDistritos=si&idprovincia='+idprovincia;

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#iddistrito').empty();
                $('#iddistrito').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

//FUNCIONES PARA ACTIVAR-DESACTIVAR CAMPOS PARA CLIENTES
$(document).ready(function() {

            $("#tipocliente").on("change", function() {
                            
               var valor = $("#tipocliente").val();

               if (valor === "NATURAL" || valor === true) {

                  $("#nomcliente").attr('disabled', false);
                  $("#apecliente").attr('disabled', false);
                  $("#razonsocial").attr('disabled', true);

               } else if (valor === "JURIDICA" || valor === true) {

                  // deshabilitamos
                  $("#nomcliente").attr('disabled', true);
                  $("#apecliente").attr('disabled', true);
                  $("#razonsocial").attr('disabled', false);
             }
       });
 });



// FUNCION PARA MOSTRAR SUBFAMILIAS POR FAMILIAS
function CargaSubfamilias(codfamilia){

$('#codsubfamilia').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaSubfamilias=si&codfamilia='+codfamilia;

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codsubfamilia').empty();
                $('#codsubfamilia').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


// FUNCION PARA MOSTRAR MODELOS POR MARCAS
function CargaModelos(codmarca){

$('#codmodelo').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaModelos=si&codmarca='+codmarca;

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codmodelo').empty();
                $('#codmodelo').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

//FUNCION PARA CALCULAR LA DIFERENCIA EN CIERRE DE CAJA
$(document).ready(function (){
          $('.cierrecaja').keyup(function (){
      
      var efectivo = $('input#dineroefectivo').val();
      var estimado = $('input#estimado').val();
            
      //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
      total=efectivo - estimado;
      var original=parseFloat(total.toFixed(2));
      $("#diferencia").val(original.toFixed(2));/**/
      
          });
});


//FUNCION PARA CARGAR CODIGO DE PRODUCTO EN CODIGO DE BARRA
/*$(document).ready(function (){
          $('#codproducto').keyup(function (){
			var codproducto = $('input#codproducto').val();						
			$("#codigobarra").val(codproducto); 
         });
 });*/

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE CLIENTES
function CargaDivClientes(){

$('#divcliente').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaDivCliente=si';

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divcliente').empty();
                $('#divcliente').append(''+response+'').fadeIn("slow");
                $('#divproveedor').html("");
                $('#divproducto').html("");
                $('#'+parent).remove();
           }
      });
}

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PROVEEDORES
function CargaDivProveedores(){

$('#divproveedor').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaDivProveedor=si';

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divproveedor').empty();
                $('#divproveedor').append(''+response+'').fadeIn("slow");
                $('#divcliente').html("");
                $('#divproducto').html("");
                $('#'+parent).remove();
           }
      });
}

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PRODUCTOS
function CargaDivProductos(){

$('#divproducto').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaDivProducto=si';

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divproducto').empty();
                $('#divproducto').append(''+response+'').fadeIn("slow");
                $('#divcliente').html("");
                $('#divproveedor').html("");
                $('#'+parent).remove();
           }
      });
}

























//////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR PEDIDOS DE PRODUCTOS /////////////////////////////////////////////////////////////

// FUNCION PARA MOSTRAR COMPRAS DE PRODUCTOS EN VENTANA MODAL
function VerPedido(codpedido){

$('#muestrapedidosmodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
var dataString = 'BuscaPedidosModal=si&codpedido='+codpedido;
$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrapedidosmodal').empty();
                $('#muestrapedidosmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


// FUNCION PARA MOSTRAR DETALLES DE PEDIDOS DE PRODUCTOS EN VENTANA MODAL
function VerDetallePedido(coddetallepedido){
  
$('#muestradetallepedidomodal').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
var dataString = 'BuscaDetallePedidoModal=si&coddetallepedido='+coddetallepedido;
$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestradetallepedidomodal').empty();
                $('#muestradetallepedidomodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}



 //FUNCION PARA BUSQUEDA DE ORDEN DE COMPRAS DE PRODUCTOS POR PROVEDORES
function BuscaPedidosProveedor(){
    
$('#muestracompraproveedor').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
var codproveedor = $("#codproveedor").val();
var dataString = $("#buscacomprasproveedor").serialize();
var url = 'funciones.php?BuscaComprasPoveedor=si';

        $.ajax({
            type: "GET",
      url: url,
            data: dataString,
            success: function(response) {
                $('#muestracompraproveedor').empty();
                $('#muestracompraproveedor').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      }); 
}



 //FUNCION PARA BUSQUEDA DE ORDEN DE PEDIDOS DE PRODUCTOS POR PROVEDORES
function BuscaPedidosProductos(){
    
$('#muestrapedidos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codproveedor = $("#codproveedor").val();
var dataString = $("#buscapedidosreportes").serialize();
var url = 'funciones.php?BuscaPedidos=si';

        $.ajax({
            type: "GET",
      url: url,
            data: dataString,
            success: function(response) {
                $('#muestrapedidos').empty();
                $('#muestrapedidos').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      }); 
}





























//////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR COMPRAS DE PRODUCTOS /////////////////////////////////////////////////////////////

//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE COMPRA DE PRODUCTOS
$(document).ready(function (){
          $('.calculocompra').keyup(function (){
            var precio = $('input#preciocompra').val();
            var cantidad = $('input#cantcompra').val();
            var descfactura = $('input#descfactura').val();
            var importe = $('input#importecompra').val();
            
            //REALIZO EL PRIMER CALCULO
            var descsiniva = precio * descfactura / 100;
            var Operac= parseFloat(precio) - parseFloat(descsiniva);
            var Operacion= parseFloat(Operac) * parseFloat(cantidad);
            $("#importecompra").val(Operacion.toFixed(2));
         });
 });



// FUNCION PARA MOSTRAR FORMA DE PAGO
function BuscaFormaPagosCompras(){
	
//$('#muestraformapagocompras').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var tipocompra = $("#tipocompra").val();
var dataString = $("#compras").serialize();
var url = 'funciones.php?BuscaFormaPagoCompras=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraformapagocompras').empty();
                $('#muestraformapagocompras').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}

// FUNCION PARA MOSTRAR COMPRAS DE PRODUCTOS EN VENTANA MODAL
function VerCompra(codcompra){

$('#muestracomprasmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var dataString = 'BuscaComprasModal=si&codcompra='+btoa(codcompra);
$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracomprasmodal').empty();
                $('#muestracomprasmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


// FUNCION PARA MOSTRAR DETALLES DE COMPRAS DE PRODUCTOS EN VENTANA MODAL
function VerDetalleCompra(coddetallecompra){

$('#muestradetallecompramodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var dataString = 'BuscaDetallesComprasModal=si&coddetallecompra='+btoa(coddetallecompra);
$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestradetallecompramodal').empty();
                $('#muestradetallecompramodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

 //FUNCION PARA BUSQUEDA DE ORDEN DE COMPRAS DE PRODUCTOS POR PROVEDORES
function BuscaComprasProveedor(){
		
$('#muestracomprasp').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codproveedor = $("#codproveedor").val();
var dataString = $("#buscacomprasproveedor").serialize();
var url = 'funciones.php?BuscaComprasProveedor=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestracomprasp').empty();
                $('#muestracomprasp').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}

 //FUNCION PARA BUSQUEDA DE ORDEN DE COMPRAS DE PRODUCTOS POR RUC
function BuscaComprasFechas(){
    
$('#muestracomprasfechas').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#buscacomprasfecha").serialize();
var url = 'funciones.php?BuscaComprasFechas=si';

        $.ajax({
            type: "GET",
      url: url,
            data: dataString,
            success: function(response) {
                $('#muestracomprasfechas').empty();
                $('#muestracomprasfechas').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      }); 
}































///////////////////////////////////////// FUNCIONES PARA PROCESAR VENTAS DE PRODUCTOS /////////////////////////////////////////////////////////////

// FUNCION PARA BUSQUEDA DE CLIENTES  
function BusquedaClientes(){
                                     
$('#resultado').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var buscacliente = $("#buscacliente").val();
var dataString = $("#buscaclientes").serialize();
var url = 'listarclientes.php?BuscaClientes=si';

if(buscacliente=="" || buscacliente==" "){ 

  $("#resultado").html('<br><center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR INGRESE CRITERIO PARA TU B&Uacute;SQUEDA !</div></center>'); 

return false;
   
    } else {

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#resultado').empty();
                $('#resultado').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      }); 
       
             }                                                                    
 }



//FUNCIONES PARA ACTIVAR-DESACTIVAR TIPO DE PAGO EN VENTAS
$(document).ready(function() {

            $("#tipopagove").on("change", function() {

            var dias = $('input#dias').val();
            var vence = $('input#vence').val();
                            
               var valor = $("#tipopagove").val();

               if (valor === "" || valor === true) {

                  $("#mediopagove").attr('disabled', true);
                  $("#montopagado").attr('disabled', true);
                  $("#montodevuelto").attr('disabled', true);
                  $("#nombrebanco").attr('disabled', true);
                  $("#nrodocumento").attr('disabled', true);
                  $("#montoabono").attr('disabled', true);
                  $("#diasvence").attr('disabled', true);
                  $('#diasvence').val("");
                  $("#fechavencecredito").attr('disabled', true);
                  $('#fechavencecredito').val("");

               } else if (valor === "CONTADO" || valor === true) {

                  $("#mediopagove").attr('disabled', false);
                  $("#montopagado").attr('disabled', true);
                  $("#montodevuelto").attr('disabled', true);
                  $("#nombrebanco").attr('disabled', true);
                  $("#nrodocumento").attr('disabled', true);
                  $("#montoabono").attr('disabled', true);
                  $("#diasvence").attr('disabled', true);
                  $('#diasvence').val("");
                  $("#fechavencecredito").attr('disabled', true);
                  $('#fechavencecredito').val("");

               } else if (valor === "CREDITO" || valor === true) {

                  // deshabilitamos
                  $("#mediopagove").attr('disabled', true);
                  $("#montopagado").attr('disabled', true);
                  $("#montodevuelto").attr('disabled', true);
                  $("#nombrebanco").attr('disabled', true);
                  $("#nrodocumento").attr('disabled', true);
                  $("#montoabono").attr('disabled', false);
                  $("#diasvence").attr('disabled', false);
                  $('#diasvence').val(dias);
                  $("#fechavencecredito").attr('disabled', false);
                  $('#fechavencecredito').val(vence);
             }
       });
 });


//FUNCIONES PARA ACTIVAR-DESACTIVAR TIPO DE PAGO EN VENTAS
$(document).ready(function() {

            $("#mediopagove").on("change", function() {
                            
               var valor = $("#mediopagove").val();

              if (valor === "" || valor === true) {

                  $("#montopagado").attr('disabled', true);
                  $("#montodevuelto").attr('disabled', true);
                  $("#nombrebanco").attr('disabled', true);
                  $("#nrodocumento").attr('disabled', true);

                } else if (valor === "EFECTIVO" || valor === true) {

                  $("#montopagado").attr('disabled', false);
                  $("#montodevuelto").attr('disabled', false);
                  $("#nombrebanco").attr('disabled', true);
                  $("#nrodocumento").attr('disabled', true);

                } else {

                  // deshabilitamos
                  $("#montopagado").attr('disabled', true);
                  $("#montodevuelto").attr('disabled', true);
                  $("#nombrebanco").attr('disabled', false);
                  $("#nrodocumento").attr('disabled', false);
             }
       });
 });


// FUNCION PARA MOSTRAR FORMA DE PAGO
function ProcesaCreditos(codventa){

  //alert(codventa);

var dataString = 'ProcesaVentas=si&codventa='+btoa(codventa);

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#procesaventas').empty();
                $('#procesaventas').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}



//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE VENTA DE PRODUCTOS
$(document).ready(function (){
          $('.calculodevolucion').keyup(function (){
      
      var montototal = $('input#totalfactura').val();
      var montopagado = $('input#montopagado').val();
      var montodevuelto = $('input#montodevuelto').val();
            
      //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
      total=montopagado - montototal;
      var original=parseFloat(total.toFixed(2));
      $("#montodevuelto").val(original.toFixed(2));/**/
      
          });
     });

//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE VENTA DE PRODUCTOS
$(document).ready(function (){
          $('.calculoventa').keyup(function (){
            var precio = $('input#precioventa').val();
            var precio2 = $('input#preciocompra').val();
            var cantidad = $('input#cantventa').val();
            var descproducto = $('input#descproducto').val();
            var importe = $('input#importe').val();
            
            //REALIZO EL PRIMER CALCULO
            var descsiniva = precio * descproducto / 100;
            var Operac= parseFloat(precio) - parseFloat(descsiniva);
            var Operacion= parseFloat(Operac) * parseFloat(cantidad);
            var Operacion2= parseFloat(precio2) * parseFloat(cantidad);
            $("#importe").val(Operacion.toFixed(2));
            $("#importe2").val(Operacion2.toFixed(2));
         });
 });


// FUNCION PARA MOSTRAR VENTAS DE PRODUCTOS EN VENTANA MODAL
function VerVentas(codventa){
									
$('#muestraventasmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								  
var dataString = 'BuscaVentasModal=si&codventa='+btoa(codventa);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraventasmodal').empty();
                $('#muestraventasmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

// FUNCION PARA MOSTRAR DETALLES DE VENTA DE PRODUCTOS EN VENTANA MODAL
function VerDetalleVentas(coddetalleventa){
									
$('#muestradetalleventamodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								  
var dataString = 'BuscaDetallesVentasModal=si&coddetalleventa='+btoa(coddetalleventa);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestradetalleventamodal').empty();
                $('#muestradetalleventamodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


//FUNCION PARA BUSQUEDA DE VENTAS POR FECHAS PARA REPORTES

function BuscaVentasFechas(){
									
$('#muestraventasfechas').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#buscaventafecha").serialize();
var url = 'funciones.php?BuscaVentasFechas=si';

$.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasfechas').empty();
                $('#muestraventasfechas').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
 }

//FUNCION PARA BUSQUEDA DE VENTAS POR FECHAS Y CAJAS DE VENTAS PARA REPORTES
function BuscaVentasCajas(){
									
$('#muestraventascajas').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var desde = $("#desde").val();
var hasta = $("#hasta").val();
var codcaja = $("select[name='codcaja']").val();
var dataString = $("#buscaventacaja").serialize();
var url = 'funciones.php?BuscaVentasCajas=si';

$.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventascajas').empty();
                $('#muestraventascajas').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
 }


//FUNCION PARA BUSQUEDA DE PRODUCTOS FACTURADOS POR FECHAS PARA REPORTES
function BuscaVentasProductos(){
									
$('#muestraventasproductos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#buscaventaproducto").serialize();
var url = 'funciones.php?BuscaVentasProductos=si';

$.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasproductos').empty();
                $('#muestraventasproductos').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
             }
         });
 }


// FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS
function BuscaKardexProductos(){
		
$('#muestrakardexproducto').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codproducto = $("#codproducto").val();
var dataString = $("#buscakardex").serialize();
var url = 'funciones.php?BuscaKardexProducto=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexproducto').empty();
                $('#muestrakardexproducto').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}
































///////////////////////////////////////////////// FUNCIONES PARA PROCESAR ABONOS A CREDITOS DE PRODUCTOS /////////////////////////////////////////////////////

// FUNCION PARA BUSQUEDA DE ABONOS DE CLIENTES
function BuscaClientesAbonos(){
		
$('#muestraclientesabonos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codcliente = $("#codcliente").val();
var dataString = $("#abonoscreditos").serialize();
var url = 'funciones.php?BuscaAbonosClientes=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestraformularioabonos').html("");            
                $('#muestraclientesabonos').empty();
                $('#muestraclientesabonos').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}

// FUNCION PARA MOSTRAR FOMRULARIO DE NUEVOS ABONOS
function NuevoAbono(cedcliente,codventa){
	
$('#muestraformularioabonos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var dataString = 'MuestraFormularioAbonos=si&cedcliente='+btoa(cedcliente)+'&codventa='+btoa(codventa);

 $.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
				$('#muestraformularioabonos').empty();
                $('#muestraformularioabonos').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

// FUNCION PARA MOSTRAR CREDITOS DE VENTAS DE PRODUCTOS EN VENTANA MODAL
function VerCreditos(codventa){
		
$('#muestracreditosmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var dataString = 'BuscaCreditosModal=si&codventa='+btoa(codventa);

 $.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
				$('#muestracreditosmodal').empty();
                $('#muestracreditosmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

// FUNCION PARA BUSQUEDA DE ABONOS DE CLIENTES PARA REPORTES
function BuscaCreditosClientesReportes(){
		
$('#muestracreditosclientesreportes').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codcliente = $("#codcliente").val();
var dataString = $("#creditosclientesreportes").serialize();
var url = 'funciones.php?BuscaCreditosClientesReportes=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestracreditosclientesreportes').empty();
                $('#muestracreditosclientesreportes').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}


// FUNCION PARA BUSQUEDA DE ABONOS DE CLIENTES PARA REPORTES
function BuscaCreditosFechasReportes(){
		
$('#muestracreditosfechasreportes').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var cedcliente = $("#cedcliente").val();
var dataString = $("#creditosfechasreportes").serialize();
var url = 'funciones.php?BuscaCreditosFechasReportes=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestracreditosfechasreportes').empty();
                $('#muestracreditosfechasreportes').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}






























































//////////////////////////////////////// FUNCIONES PARA PROCESAR VENTAS DE PRODUCTOS /////////////////////////////////////////////////////////////

//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE VENTA DE PRODUCTOS
$(document).ready(function (){
          $('.calculocotizacion').keyup(function (){
            var precio = $('input#precioventaco').val();
            var precio2 = $('input#preciocompraco').val();
            var cantidad = $('input#cantcotizacion').val();
            var descproducto = $('input#descproductoco').val();
            var importe = $('input#importe').val();
            
            //REALIZO EL PRIMER CALCULO
            var descsiniva = precio * descproducto / 100;
            var Operac= parseFloat(precio) - parseFloat(descsiniva);
            var Operacion= parseFloat(Operac) * parseFloat(cantidad);
            var Operacion2= parseFloat(precio2) * parseFloat(cantidad);
            $("#importe").val(Operacion.toFixed(2));
            $("#importe2").val(Operacion2.toFixed(2));
         });
 });


//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE VENTA DE PRODUCTOS
$(document).ready(function () {
       $(".txtmulti input").keyup(multInputs);

       function multInputs() {
           var mult = 0;
           var subivasi = 0;
           var subivano = 0;
           // para cada fila:
           $("tr.txtmulti").each(function () {
               // get the values from this row:
               var $val1 = $('.val1', this).val();
               var $val2 = $('.val2', this).val();
               var $val3 = $('.val3', this).val();
               var $val4 = $('.val4', this).val();

       /* if ($val3 == "" || $val3 == "0") {
                $("#cantcotizacion").focus();
                $("#cantcotizacion").css('border-color', '#f0ad4e');
                alert("Por Favor ingrese una Cantidad valida para Venta");
                return false;

            } else {*/


              var $descsiniva = $val2 * $val1 / 100;
              var $Operac= parseFloat($val2) - parseFloat($descsiniva);

              var $total = ($Operac * 1) * ($val3 * 1);

              $('#lblimporte',this).text($total.toFixed(2));
              $('.multTotal',this).val($total.toFixed(2));
              
              mult += $total;

              
     // }
           });




           $("#lbltotal").text(mult.toFixed(2));
           $("#txtTotal").val(mult.toFixed(2));
        }
  });


// FUNCION PARA MOSTRAR FORMA DE PAGO
function BuscaFormaPagosVentasCot(){
  
//$('#muestraformapagoventas').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var tipopagove = $("#tipopagove").val();
var dataString = $("#procesarcotizaciones").serialize();
var url = 'funciones.php?BuscaFormaPagoVentasCot=si';

        $.ajax({
            type: "GET",
      url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraformapagoventas').empty(); 
                $('#muestraformapagoventas').append(''+response+'').fadeIn("slow");  
                $('#muestracambiospagos').html("");
                $('#'+parent).remove();
            }
      }); 
}

// FUNCION PARA MOSTRAR FORMA DE PAGO PARA VENTAS
function MuestraCambiosVentasCot(){
    
//$('#muestracambiospagos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var tipopagove = $("#tipopagove").val();
var codmediopago = $("#codmediopago").val();
var dataString = $("#procesarcotizaciones").serialize();
var url = 'funciones.php?MuestraCambiosVentasCot=si';

        $.ajax({
            type: "GET",
      url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracambiospagos').empty();
                $('#muestracambiospagos').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

// FUNCION PARA MOSTRAR VENTAS DE PRODUCTOS EN VENTANA MODAL
function VerCotizacion(codcotizacion){
                  
$('#muestracotizacionmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
                  
var dataString = 'BuscaCotizacionModal=si&codcotizacion='+btoa(codcotizacion);

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracotizacionmodal').empty();
                $('#muestracotizacionmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


// FUNCION PARA MOSTRAR DETALLES DE VENTA DE PRODUCTOS EN VENTANA MODAL
function VerDetalleCotizacion(coddetallecotizacion){
                  
$('#muestradetallecotizacionmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
                  
var dataString = 'BuscaDetallesCotizacionModal=si&coddetallecotizacion='+btoa(coddetallecotizacion);

$.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestradetallecotizacionmodal').empty();
                $('#muestradetallecotizacionmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

// FUNCION PARA BUSQUEDA DE COTIZACIONES DE CLIENTES
function BuscaCotizacionClientes(){
    
$('#muestracotizacionclientes').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codcliente = $("#codcliente").val();
var dataString = $("#procesarcotizaciones").serialize();
var url = 'funciones.php?BuscaCotizacionClientes=si';

        $.ajax({
            type: "GET",
      url: url,
            data: dataString,
            success: function(response) {
                $('#muestraformulariocotizacion').html("");            
                $('#muestracotizacionclientes').empty();
                $('#muestracotizacionclientes').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      }); 
}

// FUNCION PARA MOSTRAR PROCESO DE COTIZACIONES
function ProcesarCotizacion(codcliente,codcotizacion){
  
$('#muestraformularioabonos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var dataString = 'MuestraProcesarCotizacion=si&codcliente='+btoa(codcliente)+'&codcotizacion='+btoa(codcotizacion);

 $.ajax({
            type: "GET",
      url: "funciones.php",
            data: dataString,
            success: function(response) {            
        $('#muestraformulariocotizacion').empty();
        $('#muestraformulariocotizacion').append(''+response+'').fadeIn("slow");
        $('#'+parent).remove();
            }
      });
}


//FUNCION PARA BUSQUEDA DE COTIZACIONES POR RUC PARA REPORTES
function BuscaCotizacionRuc(){
                  
$('#muestracotizacionesruc').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var id = $("#id").val();
var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#buscacotizacionruc").serialize();
var url = 'funciones.php?BuscaCotizacionesRuc=si';

$.ajax({
            type: "GET",
      url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracotizacionesruc').empty();
                $('#muestracotizacionesruc').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
 } 









































///////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR DEVOLUCION DE PRODUCTOS /////////////////////////////////////////////////////////







































