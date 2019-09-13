<?php
    
    session_start();
    //if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        //header("location: ../../login.php");
        //exit;
   // }
    /* Connect To Database*/
    include("../../config/db.php");
    include("../../config/conexion.php");
    $id_factura= intval($_GET['id_factura']);
        
    $sql_count=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
    $count=mysqli_num_rows($sql_count);
    if ($count==0)
    {
    echo "<script>alert('Factura no encontrada')</script>";
    echo "<script>window.close();</script>";
    exit;
    }
    $sql_factura=mysqli_query($con,"select * from facturas where id_factura='".$id_factura."'");
    $rw_factura=mysqli_fetch_array($sql_factura);
    $numero_factura=$rw_factura['numero_factura'];
    $numero_factura2=str_pad($numero_factura, 8, "0", STR_PAD_LEFT);
    $folio=$rw_factura['folio'];
    $id_cliente=$rw_factura['id_cliente'];
    $id_vendedor=$rw_factura['id_vendedor'];
    $fecha_factura=$rw_factura['fecha_factura'];
    $condiciones=$rw_factura['condiciones'];
        $moneda=$rw_factura['moneda'];
        $folio=$rw_factura['folio'];
        $estado=$rw_factura['estado_factura'];
        $total=$rw_factura['total_venta'];
        $deuda=$rw_factura['deuda_total'];
        $acuenta=$total-$deuda;
        //$tienda1=$_SESSION['tienda'];
        $tienda1=$rw_factura['tienda'];

        $tip=0;
        $estado_factura1=$rw_factura['estado_factura'];
        if($estado_factura1==1){
        $tip="01";
        }
        if($estado==2){
        $tip="03";
        }            
        if($estado==5){  
        $tip="08";
        }
        if($estado==6){  
        $tip="07";
        }
        if($estado==9){  
        $tip="08";
        }
        if($estado==10){  
        $tip="07";
        }
        
        if($condiciones==1){
            $condiciones1="Efectivo";
        }
        if($condiciones==2){
            $condiciones1="Cheque";
        }
        if($condiciones==3){
            $condiciones1="Transferencia Bancaria";
        }
        if($condiciones==4){
            $condiciones1="Credito";
        }

    $sql_factura3=mysqli_query($con,"select * from sucursal where id_sucursal=1");
    $rw_factura3=mysqli_fetch_array($sql_factura3);
    $rucsuc=$rw_factura3['ruc'];


    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_factura_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        $html2pdf->Output($folio.'-'.$numero_factura2.'.pdf');
        $html2pdf->Output("pdf/".$rucsuc.'-'.$tip.'-'.$folio.'-'.$numero_factura2.".pdf","F");
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }