
<style type="text/css">
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
  background:#2c3e50;
  padding: 4px 4px 4px;
  color:white;
  font-weight:bold;
  font-size:12px;
}
.silver{
  background:white;
  padding: 3px 4px 3px;
}
.clouds{
  background:#ecf0f1;
  padding: 3px 4px 3px;
}
.border-top{
  border-top: solid 1px #bdc3c7;
  
}
.border-left{
  border-left: solid 1px #bdc3c7;
}
.border-right{
  border-right: solid 1px #bdc3c7;
}
.border-bottom{
  border-bottom: solid 1px #bdc3c7;
}
tr.border_bottom td {
  border:1px solid black;
  color:black; 
}
#border_bottom2 {
  border:1px solid black;
  color:black;
  
}
#border_bottom3 {
  border:1px solid black;
  color:black;  
}
tr.border_bottom1 td {
  border-left:1px solid black;
}
tr.border_bottom4 td {
  border-left:1px solid black;
 border-bottom: 1px solid black;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
</style>
<?php       
     
      
$sql_factura2=mysqli_query($con,"select * from sucursal where tienda='".$tienda1."'");
$rw_factura2=mysqli_fetch_array($sql_factura2);
$logo=$rw_factura2['foto'];
$dir=$rw_factura2['direccion'];
$ruc=$rw_factura2['ruc'];
$correo=$rw_factura2['correo'];
$nombre=$rw_factura2['nombre'];
$color="#FAAC58";

$igv=18;
if($tienda1==$tienda2){
    ?>   
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 100%; text-align: left">
                    
                </td>
               
            </tr>
        </table>
    </page_footer>
    
    <br>
    <?php 
  $sql_cliente=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente'");
  $rw_cliente=mysqli_fetch_array($sql_cliente);
        $sql_cliente1=mysqli_query($con,"select * from facturas where id_factura='$id_factura'");
        $rw_cliente1=mysqli_fetch_array($sql_cliente1);
        $tipo1="GUIA DE REMISION";
        ?>
    <table cellspacing="0" style="width: 100%;" >
      <tr>
           <td style="width: 30%; " height="10" >     
    <img style="width: 250px; height: auto;" src="<?php echo $logo;?>">    
           </td>
           <td style="width: 35%; " align="right">    
               <strong><?php echo $nombre;?></strong> 
               <br><font style="font-size: 8pt;"><?php echo $dir;?></font>     
           </td>
           <td style="width: 40%; " height="10" align="center">
               <table border="1" cellspacing="0" style="width: 100%; text-align:center; font-size: 12pt; ">  
                    <tr><td align="center"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#04B4AE" size="7"><strong>R.U.C.<?php echo $ruc;?>
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                               <br><?php echo $tipo1;?><br>REMITENTE</strong></font>
                            <br><font color="black" size="4"><strong></strong></font><font color="red" size="5"><strong><?php print"$folio-";echo str_pad($numero_guia, 8, "0", STR_PAD_LEFT);?></strong></font>
                        <br><br>
                        </td>
                    </tr>
               </table>
           </td>                 
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%;font-size: 8pt;" border="1">    
        
        <tr>
           <td colspan="1" style="width: 50%; "> 
               <font color="black"><strong>Fecha de Emisión:</strong></font>
    <?php
                echo $fecha_factura;
                
                ?>  
           </td>
           <td colspan="2" style="width: 50%; "> 
               <font color="black"><strong>Fecha de Inicio de Traslado:</strong></font>
    <?php
                echo $fecha;
                
                ?>  
           </td>
                 
        </tr>
        <tr>
           <td height="10" bgcolor="<?php echo $color;?>" style="width: 50%; ">
               <font color="black"><strong>Punto de Partida:</strong></font>      
            </td>
            <td colspan="2" bgcolor="<?php echo $color;?>" style="width: 50%; "> 
               <font color="black"><strong>Punto de Llegada</strong></font> 
           </td>
        </tr>
        
        <tr>
            <td style="width: 50%; "><?php echo $dir_par; ?></td>            
            <td colspan="2" style="width: 50%;"><?php echo $dom_lleg;?></td>   
        </tr>
        <tr>
           <td height="10" bgcolor="<?php echo $color;?>">
               <font color="black"><strong>Razón Social del Destinatario</strong></font>    
            </td>
            <td colspan="2" bgcolor="<?php echo $color;?>"> 
               <font color="black"><strong>Ruc del destinatario</strong></font> 
           </td>
        </tr>
        <tr>
           <td style="width: 50%;"><?php echo $rw_cliente['nombre_cliente'];?></td>   
           <td colspan="2" style="width: 50%;"><?php echo $rw_cliente['doc'];?></td> 
        </tr>
         <tr>
           <td height="10" bgcolor="<?php echo $color;?>">
               <font color="black"><strong>Razón Social de Transporte</strong></font>   
            </td>
            <td colspan="2" bgcolor="<?php echo $color;?>"> 
               <font color="black"><strong>Ruc de Transporte</strong></font>  
           </td>
        </tr>
        <tr>
           <td style="width: 50%;"><?php echo $RAZON_SOCIAL_TRANSPORTE;?></td>   
           <td colspan="2" style="width: 50%;"><?php echo $NRO_DOCUMENTO_TRANSPORTE;?></td> 
        </tr>
         <tr>
           <td height="10" bgcolor="<?php echo $color;?>">
               <font color="black"><strong>Unidad de Transporte y Conductor</strong></font>   
            </td>
            <td bgcolor="<?php echo $color;?>"> 
               <font color="black"><strong>Certificado de <br>Inscripción</strong></font> 
           </td>
           <td bgcolor="<?php echo $color;?>"> 
               <font color="black"><strong>Nro Licencia de <br>Conducir</strong></font> 
           </td>
        </tr>
        <tr>
           <td style="width: 50%;"><?php echo $vehiculo;?></td>   
           <td style="width: 25%;"><?php echo $inscripcion;?></td> 
           <td style="width: 25%;"><?php echo $licencia;?></td>
        </tr>
    </table>
    <br>

<table cellspacing="0" style="width: 100%; text-align: left;border: 1px solid black;font-size: 10pt; " >       
<tr class="border_bottom">
    <td style="width: 10%; " align="center" bgcolor="<?php echo $color;?>"><strong>ITEM</strong></td>
    <td style="width: 10%; " align="center" bgcolor="<?php echo $color;?>"><strong>CANT.</strong></td>
    <td style="width: 10%; " align="center" bgcolor="<?php echo $color;?>"><strong>CODIGO</strong></td>
    <td style="width: 70%; " align="center" bgcolor="<?php echo $color;?>"><strong>DESCRIPCION</strong></td>
   
         
</tr>
<?php
$nums=1;
$sumador_total=0;
$sql1=mysqli_query($con, "select * from facturas where id_factura='".$id_factura."'");
$row1=mysqli_fetch_array($sql1);
$servicio=$row1["servicio"];
$tipo1=$row1["estado_factura"];
$id_cliente=$row1["id_cliente"];
$numero_factura1=$row1["numero_factura"];
if($servicio==0){
$sql=mysqli_query($con, "select * from products, detalle_factura, facturas where products.id_producto=detalle_factura.id_producto and detalle_factura.precio_venta>0 and detalle_factura.numero_factura=facturas.numero_factura and detalle_factura.numero_factura=$numero_factura1 and detalle_factura.tienda=$tienda1 and facturas.ven_com=detalle_factura.ven_com and detalle_factura.tipo_doc='".$tipo1."' and facturas.id_factura='".$id_factura."' and detalle_factura.id_cliente='".$id_cliente."'" );
}else{
 $sql=mysqli_query($con, "select * from detalle_factura, facturas where detalle_factura.numero_factura=facturas.numero_factura and detalle_factura.precio_venta>0 and detalle_factura.numero_factura=$numero_factura1 and detalle_factura.tienda=$tienda1 and facturas.id_factura='".$id_factura."' and detalle_factura.tipo_doc='".$tipo1."' and detalle_factura.id_cliente='".$id_cliente."'" );   
}
$suma=0;
$codigo_producto="";
$r=1;
while ($row=mysqli_fetch_array($sql))
  {
  $id_producto=$row["id_producto"];
  if($servicio==0){
        $codigo_producto=$row['codigo_producto'];
  $cantidad=$row['cantidad'];
  $nombre_producto=$row['nombre_producto'];  
        }else{  
  $cantidad=$row['cantidad'];
        //$codigo_producto=$row['codigo_producto'];
        $id_producto1=$row['id_producto'];  
        $inv_ini=$row['inv_ini'];
        if($inv_ini>0){
            $sql2=mysqli_query($con, "select * from products where id_producto='".$id_producto1."'");
            $row2=mysqli_fetch_array($sql2);
            $nombre_producto=$row2["nombre_producto"];
            $codigo_producto=$row2['codigo_producto'];
        }
            else{
            $nombre_producto=$row['id_producto'];  
        }     
        }
  $precio_venta=$row['precio_venta'];
        
  
   
        if($suma<=29){
        ?>
        <tr class="border_bottom1">
            <td  height="10" align="center"><?php echo $r; ?></td>
            <td  height="10" align="center"><?php echo $cantidad; ?></td>
            <td  height="10" align="center"><?php echo $codigo_producto; ?></td>
            <td><?php echo $nombre_producto;?> <?php echo $codigo_producto;?></td>
        </tr>
  <?php 
        $suma=$suma+1;
        }
        
       
        $r=$r+1;
     //fin 
  }
        
        
        for($i=$suma;$i<=29;$i++){
        $r1=1;
            if($i==29){
            $r1=4;
        }
        ?>
        <tr class="border_bottom<?php echo $r1;?>">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
           
        </tr>
  <?php 
        }
        
  
        
        ?>
    
    </table>
    <br>
     <table cellspacing="0" style="width: 100%;font-size: 6pt;border:1px solid;" >    
         <tr>
             <td colspan="3" align="center"><strong>MOTIVO DE TRASLADO</strong></td>
         </tr>
         <tr>
           <td style="width:33%; ">
               <input type="checkbox">1.-Venta<br><input type="checkbox">2.-Venta sujeta a confirmación del comprador<br><input type="checkbox">3.-Compra</td>
               
           <td style="width:33%; ">                             
               <input type="checkbox">4.-Traslado entre establecimientos de la misma empresa<br><input type="checkbox">5.-Traslado emisor itinerante cp<br><input type="checkbox">6.-Imprtación
           </td>
           <td style="width:34%; ">                             
               <input type="checkbox">7.-Exportación<br><input type="checkbox">8.-Traslado a zona primaria.<br><input type="checkbox">9.-Otros 
           </td>                                                              
        </tr>
        
    </table>
    <BR>
    <table cellspacing="0" style="width: 100%;font-size: 6pt;" >
    <tr>
            <td align="center" style="width: 100%;">______________________________________</td>
        </tr>
         <tr>
            <td align="center" >RECIBÍ CONFORME</td>
        </tr>
     </table>   
<br>
    
</page>
<?php
}
function unidad($numuero){
switch ($numuero)
{
case 9:
{
$numu = "NUEVE";
break;
}
case 8:
{
$numu = "OCHO";
break;
}
case 7:
{
$numu = "SIETE";
break;
} 
case 6:
{
$numu = "SEIS";
break;
} 
case 5:
{
$numu = "CINCO";
break;
} 
case 4:
{
$numu = "CUATRO";
break;
} 
case 3:
{
$numu = "TRES";
break;
} 
case 2:
{
$numu = "DOS";
break;
} 
case 1:
{
$numu = "UN";
break;
} 
case 0:
{
$numu = "";
break;
} 
}
return $numu; 
}

function decena($numdero){

if ($numdero >= 90 && $numdero <= 99)
{
$numd = "NOVENTA ";
if ($numdero > 90)
$numd = $numd."Y ".(unidad($numdero - 90));
}
else if ($numdero >= 80 && $numdero <= 89)
{
$numd = "OCHENTA ";
if ($numdero > 80)
$numd = $numd."Y ".(unidad($numdero - 80));
}
else if ($numdero >= 70 && $numdero <= 79)
{
$numd = "SETENTA ";
if ($numdero > 70)
$numd = $numd."Y ".(unidad($numdero - 70));
}
else if ($numdero >= 60 && $numdero <= 69)
{
$numd = "SESENTA ";
if ($numdero > 60)
$numd = $numd."Y ".(unidad($numdero - 60));
}
else if ($numdero >= 50 && $numdero <= 59)
{
$numd = "CINCUENTA ";
if ($numdero > 50)
$numd = $numd."Y ".(unidad($numdero - 50));
}
else if ($numdero >= 40 && $numdero <= 49)
{
$numd = "CUARENTA ";
if ($numdero > 40)
$numd = $numd."Y ".(unidad($numdero - 40));
}
else if ($numdero >= 30 && $numdero <= 39)
{
$numd = "TREINTA ";
if ($numdero > 30)
$numd = $numd."Y ".(unidad($numdero - 30));
}
else if ($numdero >= 20 && $numdero <= 29)
{
if ($numdero == 20)
$numd = "VEINTE ";
else
$numd = "VEINTI".(unidad($numdero - 20));
}
else if ($numdero >= 10 && $numdero <= 19)
{
switch ($numdero){
case 10:
{
$numd = "DIEZ ";
break;
}
case 11:
{ 
$numd = "ONCE ";
break;
}
case 12:
{
$numd = "DOCE ";
break;
}
case 13:
{
$numd = "TRECE ";
break;
}
case 14:
{
$numd = "CATORCE ";
break;
}
case 15:
{
$numd = "QUINCE ";
break;
}
case 16:
{
$numd = "DIECISEIS ";
break;
}
case 17:
{
$numd = "DIECISIETE ";
break;
}
case 18:
{
$numd = "DIECIOCHO ";
break;
}
case 19:
{
$numd = "DIECINUEVE ";
break;
}
} 
}
else
$numd = unidad($numdero);
return $numd;
}

function centena($numc){
if ($numc >= 100)
{
if ($numc >= 900 && $numc <= 999)
{
$numce = "NOVECIENTOS ";
if ($numc > 900)
$numce = $numce.(decena($numc - 900));
}
else if ($numc >= 800 && $numc <= 899)
{
$numce = "OCHOCIENTOS ";
if ($numc > 800)
$numce = $numce.(decena($numc - 800));
}
else if ($numc >= 700 && $numc <= 799)
{
$numce = "SETECIENTOS ";
if ($numc > 700)
$numce = $numce.(decena($numc - 700));
}
else if ($numc >= 600 && $numc <= 699)
{
$numce = "SEISCIENTOS ";
if ($numc > 600)
$numce = $numce.(decena($numc - 600));
}
else if ($numc >= 500 && $numc <= 599)
{
$numce = "QUINIENTOS ";
if ($numc > 500)
$numce = $numce.(decena($numc - 500));
}
else if ($numc >= 400 && $numc <= 499)
{
$numce = "CUATROCIENTOS ";
if ($numc > 400)
$numce = $numce.(decena($numc - 400));
}
else if ($numc >= 300 && $numc <= 399)
{
$numce = "TRESCIENTOS ";
if ($numc > 300)
$numce = $numce.(decena($numc - 300));
}
else if ($numc >= 200 && $numc <= 299)
{
$numce = "DOSCIENTOS ";
if ($numc > 200)
$numce = $numce.(decena($numc - 200));
}
else if ($numc >= 100 && $numc <= 199)
{
if ($numc == 100)
$numce = "CIEN ";
else
$numce = "CIENTO ".(decena($numc - 100));
}
}
else
$numce = decena($numc);

return $numce; 
}

function miles($nummero){
if ($nummero >= 1000 && $nummero < 2000){
$numm = "MIL ".(centena($nummero%1000));
}
if ($nummero >= 2000 && $nummero <10000){
$numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
}
if ($nummero < 1000)
$numm = centena($nummero);

return $numm;
}

function decmiles($numdmero){
if ($numdmero == 10000)
$numde = "DIEZ MIL";
if ($numdmero > 10000 && $numdmero <20000){
$numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000)); 
}
if ($numdmero >= 20000 && $numdmero <100000){
$numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000)); 
} 
if ($numdmero < 10000)
$numde = miles($numdmero);

return $numde;
} 

function cienmiles($numcmero){
if ($numcmero == 100000)
$num_letracm = "CIEN MIL";
if ($numcmero >= 100000 && $numcmero <1000000){
$num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000)); 
}
if ($numcmero < 100000)
$num_letracm = decmiles($numcmero);
return $num_letracm;
} 

function millon($nummiero){
if ($nummiero >= 1000000 && $nummiero <2000000){
$num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
}
if ($nummiero >= 2000000 && $nummiero <10000000){
$num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
}
if ($nummiero < 1000000)
$num_letramm = cienmiles($nummiero);

return $num_letramm;
} 

function decmillon($numerodm){
if ($numerodm == 10000000)
$num_letradmm = "DIEZ MILLONES";
if ($numerodm > 10000000 && $numerodm <20000000){
$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000)); 
}
if ($numerodm >= 20000000 && $numerodm <100000000){
$num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000)); 
}
if ($numerodm < 10000000)
$num_letradmm = millon($numerodm);

return $num_letradmm;
}

function cienmillon($numcmeros){
if ($numcmeros == 100000000)
$num_letracms = "CIEN MILLONES";
if ($numcmeros >= 100000000 && $numcmeros <1000000000){
$num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000)); 
}
if ($numcmeros < 100000000)
$num_letracms = decmillon($numcmeros);
return $num_letracms;
} 

function milmillon($nummierod){
if ($nummierod >= 1000000000 && $nummierod <2000000000){
$num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod >= 2000000000 && $nummierod <10000000000){
$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod < 1000000000)
$num_letrammd = cienmillon($nummierod);

return $num_letrammd;
} 


function convertir($numero){
$numf = milmillon($numero);
return $numf;
}

function mes1($texto)
{
  if($texto=='01') {
    
    return "enero";
}elseif($texto=='02'){
    return "febrero";
}elseif($texto=='03'){
    return "marzo";
}elseif($texto=='04'){
    return "abril";
}elseif($texto=='05'){
    return "mayo";
}elseif($texto=='06'){
    return "junio";
}elseif($texto=='07'){
    return "julio";
}elseif($texto=='08'){
    return "agosto";
}elseif($texto=='09'){
    return "setiembre";
}elseif($texto=='10'){
    return "octubre";
}elseif($texto=='11'){
    return "noviembre";
}elseif($texto=='12'){
    return "diciembre";
}  
    
    
}

?>
