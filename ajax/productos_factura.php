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
         $id_categoria =intval($_REQUEST['id_categoria']);
         $aColumns = array('codigo_producto', 'nombre_producto');
         $sTable = "products";
         $sWhere = " ";
        
            $sWhere = "WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
        
        if ($id_categoria>0){
            $sWhere .=" and cat_pro='$id_categoria'";
        }

        $sWhere.=" and status_producto='1' order by id_producto asc";

        include 'pagination.php';
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
        $per_page = 999999; 
        $adjacents  = 4; 
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
        $row= mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows/$per_page);
        $reload = './index.php';
        //main query to fetch the data
        $sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($con, $sql);
        //loop through fetched data
        if ($numrows>0){
            ?>
            <div class="table-responsive">
    <table class="table" style="width: 100%;" width="100%" cellspacing="0">
    <tbody>
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

        <?php if ($b>0) {?>
           <tr>
                
                <div class="btn btn-flat item">
                    <div class="item-inner">
                        <div class="item-img">
                            <span class="badge badge-default stock-counter ng-binding"><input type="text" class="form-control input-sm" style="width: 30px; height: 20px; background-color: #777777; color: white; border: none;" id="cantidad_<?php echo $id_producto; ?>"  value="1" ></span>
                            <img src="fotos/<?php echo $foto;?>" onclick="agregar('<?php echo $id_producto ?>')">
                        </div>
                        <span class="item-info" onclick="agregar('<?php echo $id_producto ?>')">
                            <span>
                                <?php echo $nombre_producto; ?>
                            </span>
                        </span>
                        <span class="item-mask" title="Stock (<?php echo $b;?>)" onclick="agregar('<?php echo $id_producto ?>')">
                            <svg class="svg-icon"><use href="#icon-money"></svg>
                            <span>S/. <?php echo $precio_venta;?></span>
                            <input type="search" class="form-control input-sm hidden" style="text-align:center" id="precio_venta_<?php echo $id_producto; ?>"  value="<?php echo $precio_venta;?>">
                            
                            <input type="hidden" class="form-control input-sm" style="text-align:right" disabled id="stock_<?php echo $id_producto; ?>" value="<?php echo $b;?>">
                        </span>
                    </div>
                </div>

            </tr>
        <?php } else {
            
        } ?>
        
    <?php } ?>
    </tbody>
    </table>
</div>
            <?php
        }
    }
?>