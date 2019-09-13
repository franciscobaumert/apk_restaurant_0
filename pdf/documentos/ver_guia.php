<?php
    
    session_start();
    if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: ../../login.php");
        exit;
    }
    /* Connect To Database*/
    include("../../config/db.php");
    include("../../config/conexion.php");
    $id_guia= intval($_GET['id_guia']);
        
    $sql_count=mysqli_query($con,"select * from guia where id='".$id_guia."'");
    $count=mysqli_num_rows($sql_count);
    if ($count==0)
    {
    echo "<script>alert('Guia no encontrada')</script>";
    echo "<script>window.close();</script>";
    exit;
    }
    $sql_factura=mysqli_query($con,"select * from guia,facturas where guia.id='".$id_guia."' and guia.id_doc=facturas.id_factura");
    $rw_guia=mysqli_fetch_array($sql_factura);
    $numero_guia=$rw_guia['guia'];
    $folio=$rw_guia['serie'];
    $dir_par=$rw_guia['dir_par'];
        $dom_lleg=$rw_guia['dom_lleg'];
        $cont_lleg=$rw_guia['cont_lleg'];
        $fecha_factura=date("d/m/Y",strtotime($rw_guia['fecha_factura']));
        $fecha=date("d/m/Y",strtotime($rw_guia['fecha']));
        $vehiculo=$rw_guia['vehiculo'];
        $inscripcion=$rw_guia['inscripcion'];
        $licencia=$rw_guia['lic'];
        $RAZON_SOCIAL_TRANSPORTE=$rw_guia['RAZON_SOCIAL_TRANSPORTE'];
        $NRO_DOCUMENTO_TRANSPORTE=$rw_guia['NRO_DOCUMENTO_TRANSPORTE'];
    $id_cliente=$rw_guia['id_cliente'];
    //$id_vendedor=$rw_guia['id_vendedor'];
        $id_factura=$rw_guia['id_factura'];
        
        $tienda1=$_SESSION['tienda'];
        $tienda2=$rw_guia['tienda'];
        
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_guia_html.php');
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
        $html2pdf->Output('Factura.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
