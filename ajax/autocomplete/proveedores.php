<?php
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{
	
	$fetch = mysqli_query($con,"SELECT * FROM clientes where nombre_cliente like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,50"); 
	
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_proveedores=$row['id_cliente'];
		$row_array['value'] = $row['nombre_cliente'];
		$row_array['id_proveedores']=$id_proveedores;
		$row_array['nombre_proveedores']=$row['nombre_cliente'];
		$row_array['telefono_proveedores']=$row['telefono_cliente'];
		$row_array['email_proveedores']=$row['email_cliente'];
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>