<style type="text/css">
   .thumbnail1{
position: relative;
z-index: 0;
}
.thumbnail1:hover{
background-color: transparent;
z-index: 50;
}
.thumbnail1 span{ /*Estilos del borde y texto*/
position: absolute;
background-color: white;
padding: 5px;
left: -100px;

visibility: hidden;
color: #FFFF00;
text-decoration: none;
}
.thumbnail1 span img{ /*CSS for enlarged image*/
border-width: 0;
padding: 2px;
}
.thumbnail1:hover span{ /*CSS for enlarged image on hover*/
visibility: visible;
top: 17px;
left: 60px; /*position where enlarged image should offset horizontally */
} 
img.imagen2{
padding:4px;
border:3px #0489B1 solid;
margin-left: 2px;
margin-right:5px;
margin-top: 5px;
float:left;

}
</style>
<?php
    include('is_logged.php');
    require_once ("../config/db.php");
    require_once ("../config/conexion.php");
    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    if($action == 'ajax'){
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $aColumns = array('codigo_producto', 'nombre_producto');
         $sTable = "products";
         $sWhere = "";
        if ( $_GET['q'] != "" )
        {
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        }
        include 'pagination.php';
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 999999; 
        $adjacents  = 5; 
        $offset = ($page - 1) * $per_page;
        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
        $row= mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows/$per_page);
        $reload = './index.php';
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);
        if ($numrows>0){
            ?>
            <div class="table-responsive">
    <table class="table" style="width: 100%;" width="100%" cellspacing="0">
    <?php
    while ($row=mysqli_fetch_array($query)){
        $id_producto=$row['id_producto'];
        $codigo_producto=$row['codigo_producto'];
        $nombre_producto=$row['nombre_producto'];
        $foto=$row['foto1'];
        $tienda=$_SESSION['tienda'];
        $b=$row["b$tienda"];
        $precio_venta=$row["precio_producto"];
        $precio_venta=number_format($precio_venta,2);
        ?>
        <tr>
            <div class="col-md-2 mb" style="width:144.5px;cursor:pointer;" ng-click="afterClick()" ng-repeat="product in ::getFavouriteProducts()" >
                <a href="#" onclick="agregar('<?php echo $id_producto ?>')">
                    <div class="darkblue-panel pn" title="Stock (<?php echo $b;?>)">
                        <div class="darkblue-header"><h5><?php echo $nombre_producto; ?></h5></div>
                        <p><img src="fotos/<?php echo $foto;?>" class="img-circle" style="width:60px;height:60px;"></p>
                        <h5>S/. <?php echo $precio_venta;?><input type="search" class="form-control input-sm hidden" style="text-align:center" id="precio_venta_<?php echo $id_producto; ?>"  value="<?php echo $precio_venta;?>"></h5>
                        <div class="pull-right">
                            <input type="hidden" class="form-control input-sm" style="text-align:right" id="cantidad_<?php echo $id_producto; ?>"  value="1" >
                        </div>
                        <div class="pull-right"><input type="hidden" class="form-control input-sm" style="text-align:right" disabled id="stock_<?php echo $id_producto; ?>" value="<?php echo $b;?>"></div>
                        
                    </div>
                </a>
                <br>
            </div>
        </tr>
    <?php } ?>
    </table>
</div>
            <?php
        }
    }
?>