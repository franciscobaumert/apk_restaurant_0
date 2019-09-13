<style>
    table tr:nth-child(odd) {background-color: #FBF8EF;}
table tr:nth-child(even) {background-color: #EFFBF5;}
 #valor1 {          
border-bottom: 2px solid #F5ECCE;
}  
#valor1:hover {            
background-color: white;
border-bottom: 2px solid #A9E2F3;
} 
</style>
<?php
	include('is_logged.php');
	require_once ("../config/db.php");
	require_once ("../config/conexion.php");
	$tienda1=$_SESSION['tienda'];
        $dato="";
        if(isset($_SESSION['asistencia1'])&& isset($_SESSION['asistencia2']) ){
            $aa=$_SESSION['asistencia1'];
            $bb=$_SESSION['asistencia2'];
            $dato=" and fecha_entrada>='$aa' and fecha_entrada<='$bb'";
        }
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){	
	}
	if($action == 'ajax'){
                $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$sTable = "asistencia,users";
		$sWhere = "";
                $sWhere.=" WHERE users.sucursal=$tienda1 and asistencia.asistencia=0 and asistencia.user_id=users.user_id $dato";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (users.nombres like '%$q%')";	
		}
		$sWhere.=" order by id_asistencia desc ";
		include 'pagination.php';
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10;
		$adjacents  = 4; 
		$offset = ($page - 1) * $per_page;
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './asistencia.php';
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
                $hora=0;
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  style="background-color:#ffd777;color:white; ">
					<th>Foto</th>
                                    <th>Nombre</th>
					<th>Hora Ingreso</th>
                                        <th>Hora Entrada</th>
                                        <th>Tardanza en minutos</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Hora Salida</th>
                                        <th>Fecha Salida</th>	
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_asistencia=$row['id_asistencia'];
                                                $nombre=$row['nombres'];
                                                $foto=$row['foto'];
						$hora_entrada=$row['hora_entrada'];
                                                $hora_base=$row['hora_base'];
						$fecha_entrada=$row['fecha_entrada'];
						$hora_salida=$row['hora_salida'];
						$fecha_salida=$row['fecha_salida'];
                                                $min_tardanza=$row['min_tardanza'];
                                                list($horas, $minutos, $segundos) = explode(':', $min_tardanza);
                                                $hora_en_minutos = ($horas * 60 ) + ($minutos  );

					?>
                                        <tr id="valor1">
						<td><img src="images/<?php echo $foto;?>" alt="Avatar" style="width: 30px;"> </td>
						<td><?php echo $nombre; ?></td>
						<td ><font color="green"><strong><?php echo $hora_entrada; ?></strong></font></td>
                                                <td ><?php echo $hora_base; ?></td>
                                                <td ><font color="red"><strong><?php echo $hora_en_minutos;$hora=$hora+$hora_en_minutos; ?> Min</strong></font></td>
                                                <td ><?php echo $fecha_entrada; ?></td>
                                                <td ><?php echo $hora_salida; ?></td>
                                                <td ><?php echo $fecha_salida; ?></td>
                                    	
					</tr>
					<?php
				}
				?>
				<tr style="background:white;">
					<td colspan=8><span class="pull-right"><?PHP
					 echo paginate($reload, $page, $total_pages, $adjacents); 
					?></span></td>
				</tr>
                                <tr style="background:white;">
                                    <td colspan=6></td><td><font color="red"><strong>TOTAL MIN <BR>TARDANZA:</strong></font></td>
                                        <td>
                                            <strong> <?PHP
					 echo $hora; 
					?> 
                                            
                                          Min  </strong>
                                        </td>
				</tr>
			  </table>
			</div>
		<?php
	}
}
?>