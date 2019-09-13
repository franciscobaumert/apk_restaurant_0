<?php
session_start();
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{
	
	$fetch = mysqli_query($con,"SELECT * FROM products where nombre_producto like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,50"); 
	
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_producto=$row['id_producto'];
		$row_array['value'] = $row['nombre_producto'];
		$row_array['id_producto']=$id_producto;
		$row_array['nombre_producto']=$row['nombre_producto'];
		$row_array['precio_producto']=$row['precio_producto'];
                $tienda=$_SESSION['tienda'];
    if($tienda==1){
        $inv=$row['b1'];
    }
    if($tienda==2){
        $inv=$row['b2'];        
    }
    if($tienda==3){
        $inv=$row['b3'];        
    }
		$row_array['inv_producto']=$inv;
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>