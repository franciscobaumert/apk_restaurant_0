<?php
###### DORAINEGRETE - 29111988
ini_set('memory_limit', '-1'); //evita el error Fatal error: Allowed memory size of X bytes exhausted (tried to allocate Y bytes)...
ini_set('max_execution_time', 800); // es lo mismo que set_time_limit(300) ;
require_once("classconexion.php");
//session_start();
include_once('funciones_basicas.php');

####################################### CLASE LOGIN #######################################

class Login extends Db
{
	
	public function __construct()
	{
		parent::__construct();
	} 	
	


	


































#################################### CLASE SALAS ####################################

################################# FUNCION PARA REGISTRAR SALAS ################################
public function RegistrarSalas()
{
	self::SetNames();
	if(empty($_POST["nombresala"]))
	{
		echo "1";
		exit;
	}
	$sql = " select nombresala from salas where nombresala = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["nombresala"]) );
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " insert into salas values (null, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $nombresala);
		$stmt->bindParam(2, $salacreada);

		$nombresala = strip_tags($_POST["nombresala"]);
		$salacreada = strip_tags(date("Y-m-d h:i:s"));
		$stmt->execute(); ?>
		
		<script type="text/javascript">
	        toastr.options = {
	          "closeButton":true,
	          "progressBar": true
	        };
	        toastr.success("Sala registrada con exito","Datos registrados");
      	</script>
	<?php }
	else
	{
		echo "2";
		exit;
	}
}
################################# FUNCION PARA REGISTRAR SALAS ################################

################################# FUNCION PARA LISTAR SALAS ################################
public function ListarSalas()
{
	self::SetNames();
	$tienda1=$_SESSION['tienda'];
	$sql = " select * from salas where tienda=$tienda1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
################################# FUNCION PARA LISTAR SALAS ################################


################################# FUNCION ID DE SALAS ################################
public function SalasPorId()
{
	self::SetNames();
	$sql = " select salas.codsala, salas.nombresala, salas.salacreada, mesas.codmesa, mesas.nombremesa, mesas.mesacreada, mesas.statusmesa FROM salas LEFT JOIN mesas ON salas.codsala = mesas.codsala where salas.codsala = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codsala"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################# FUNCION ID DE SALAS ################################

############################# FUNCION PARA LISTAR MESAS POR SALAS ################################
public function ListasMesasSalas() 
{
self::SetNames();
$sql = " select mesas.codmesa, mesas.nombremesa, mesas.mesacreada, mesas.statusmesa FROM mesas LEFT JOIN salas ON mesas.codsala = salas.codsala where mesas.codsala = ? ";
$stmt = $this->dbh->prepare($sql);
$stmt->execute( array(base64_decode($_GET["codsala"])) );
$num = $stmt->rowCount();
if($num==0)
{ ?>

	<script type="text/javascript">
	    toastr.options = {
	      "closeButton":true,
	      "progressBar": true
	    };
	    toastr.info("No existen mesas asociadas","No hay datos");
  	</script>

<?php	
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN MESAS ASOCIADAS ACTUALMENTE</center>";
	echo "</div>";
	exit;
 }
else
{
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}  
############################# FUNCION PARA LISTAR MESAS POR SALAS ################################

################################# FUNCION PARA ACTUALIZAR SALAS ################################
public function ActualizarSalas()
{

	self::SetNames();
	if(empty($_POST["codsala"]) or empty($_POST["nombresala"]))
	{
		echo "1";
		exit;
	}
	$sql = " select nombresala from salas where codsala != ? and nombresala = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["codsala"], $_POST["nombresala"]) );
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " update salas set "
		." nombresala = ? "
		." where "
		." codsala = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $nombresala);
		$stmt->bindParam(2, $codsala);

		$codsala = strip_tags($_POST["codsala"]);
		$nombresala = strip_tags($_POST["nombresala"]);
		$stmt->execute(); ?>
		
		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.success("Sala actualizada con exito","Datos actualizados");
  		</script>

		
	<?php }
	else
	{
		echo "2";
		exit;
	}
}
################################# FUNCION PARA ACTUALIZAR SALAS ################################

################################# FUNCION PARA ELIMINAR SALAS ################################

public function EliminarSalas()
{

	$sql = " select codsala from mesas where codsala = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codsala"])) );
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = " delete from salas where codsala = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codsala);
		$codsala = base64_decode($_GET["codsala"]);
		$stmt->execute();

		header("Location: salas?mesage=1");
		exit;

	}else {

		header("Location: salas?mesage=2");
		exit;
	}

}
################################# FUNCION PARA ELIMINAR SALAS ################################

################################### FIN DE CLASE SALAS #########################################




















































######################################## CLASE MESAS ############################################

############################ FUNCION PARA REGISTRAR MESAS ###########################
public function RegistrarMesas()
{
	self::SetNames();
	if(empty($_POST["codsala"]) or empty($_POST["nombremesa"]))
	{
		echo "1";
		exit;
	}
	$sql = " select codsala, nombremesa from mesas where codsala = ? and nombremesa = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["codsala"], $_POST["nombremesa"]) );
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " insert into mesas values (null, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codsala);
		$stmt->bindParam(2, $nombremesa);
		$stmt->bindParam(3, $mesacreada);
		$stmt->bindParam(4, $statusmesa);

		$codsala = strip_tags($_POST["codsala"]);
		$nombremesa = strip_tags($_POST["nombremesa"]);
		$mesacreada = strip_tags(date("Y-m-d h:i:s"));
		$statusmesa = strip_tags("0");
		$stmt->execute(); ?>

		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.success("Mesa registrada con exito","Datos registrados");
  		</script>
	<?php }
	else
	{
		echo "2";
		exit;
	}
}
############################ FUNCION PARA REGISTRAR MESAS ###########################

############################ FUNCION PARA LISTAR MESAS ###########################
public function ListarMesas()
{
	self::SetNames();
	$tienda1=$_SESSION['tienda'];
	$sql = " select salas.id_sala, salas.nombre_sala, salas.sala_creada, mesas.id_mesa, mesas.nombre_mesa, mesas.mesa_creada, mesas.status_mesa FROM mesas LEFT JOIN salas ON mesas.id_sala = salas.id_sala where mesas.tienda=$tienda1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION PARA LISTAR MESAS ###########################


############################ FUNCION PARA LISTAR MESAS ###########################
public function ListarMesas1()
{
	self::SetNames();
	$tienda1=$_SESSION['tienda'];
	$sql = " select salas.id_sala, salas.nombre_sala, salas.sala_creada, mesas.id_mesa, mesas.nombre_mesa, mesas.mesa_creada, mesas.status_mesa FROM mesas LEFT JOIN salas ON mesas.id_sala = salas.id_sala where mesas.status_mesa=1 and mesas.tienda=$tienda1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION PARA LISTAR MESAS ###########################


############################ FUNCION PARA LISTAR MESAS ###########################
public function ListarVentasMesas()
{
	self::SetNames();
	$tienda1=$_SESSION['tienda'];
	$sql = " select salas.id_sala, salas.nombre_sala, salas.sala_creada, mesas.id_mesa, mesas.nombre_mesa, mesas.mesa_creada, mesas.status_mesa FROM mesas LEFT JOIN salas ON mesas.id_sala = salas.id_sala where mesas.tienda=$tienda1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION PARA LISTAR MESAS ###########################


############################ FUNCION ID DE MESAS ###########################
public function MesasPorId()
{
	self::SetNames();
	$sql = " select salas.id_sala, salas.nombre_sala, salas.sala_creada, mesas.id_mesa, mesas.nombre_mesa, mesas.mesa_creada, mesas.status_mesa FROM mesas INNER JOIN salas ON salas.id_sala = mesas.id_sala where mesas.id_mesa = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["id_mesa"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################ FUNCION ID DE MESAS ###########################

############################ FUNCION PARA ACTUALIZAR MESAS ###########################
	public function ActualizarMesas()
	{

		self::SetNames();
		if(empty($_POST["codmesa"]) or empty($_POST["codsala"]) or empty($_POST["nombremesa"]))
		{
			echo "1";
			exit;
		}
		$sql = " select codsala, nombremesa from mesas where codmesa != ? and codsala = ? and nombremesa = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codmesa"], $_POST["codsala"], $_POST["nombremesa"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = " update mesas set "
			." codsala = ?, "
			." nombremesa = ?, "
			." statusmesa = ? "
			." where "
			." codmesa = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $codsala);
			$stmt->bindParam(2, $nombremesa);
		    $stmt->bindParam(3, $statusmesa);
			$stmt->bindParam(4, $codmesa);

			$codmesa = strip_tags($_POST["codmesa"]);
			$codsala = strip_tags($_POST["codsala"]);
			$nombremesa = strip_tags($_POST["nombremesa"]);
			$statusmesa = strip_tags($_POST["statusmesa"]);
			$stmt->execute(); ?>
		
		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.success("Mesa actualizada con exito","Datos actualizados");
  		</script>

		<?php }
		else
		{
			echo "2";
			exit;
		}
	}
############################ FUNCION PARA ACTUALIZAR MESAS ###########################

############################ FUNCION PARA ELIMINAR MESAS ###########################
	public function EliminarMesas()
	{

		$sql = " select codmesa from ventas where codmesa = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codmesa"])) );
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = " delete from mesas where codmesa = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codmesa);
			$codmesa = base64_decode($_GET["codmesa"]);
			$stmt->execute();

			header("Location: mesas?mesage=1");
			exit;

		}else {

			header("Location: mesas?mesage=2");
			exit;
		}

	}
############################ FUNCION PARA ELIMINAR MESAS ###########################

############################### FIN DE CLASE MESAS EN SALAS ################################









































################################### CLASE MEDIOS DE PAGO #######################################

############################### FUNCION PARA REGISTRAR MEDIOS DE PAGO ############################
public function RegistrarMediosPagos()
{
	self::SetNames();
	if(empty($_POST["mediopago"]))
	{
		echo "1";
		exit;
	}
	$sql = " select mediopago from mediospagos where mediopago = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["mediopago"]) );
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " insert into mediospagos values (null, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $mediopago);

		$mediopago = strip_tags(strtoupper($_POST["mediopago"]));
		$stmt->execute(); ?>

		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.success("Medio de pago registrado con exito","Datos registrados");
  		</script>

	<?php }
	else
	{
		echo "2";
		exit;
	}
}
############################### FUNCION PARA REGISTRAR MEDIOS DE PAGO ############################

############################### FUNCION PARA LISTAR MEDIOS DE PAGO ############################
public function ListarMediosPagos()
{
	self::SetNames();
	$sql = " select * from mediospagos";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
############################### FUNCION PARA LISTAR MEDIOS DE PAGO ############################


############################### FUNCION ID MEDIOS DE PAGO ############################
public function MediosPagosPorId()
{
	self::SetNames();
	$sql = " select * from mediospagos where codmediopago = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codmediopago"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################### FUNCION ID MEDIOS DE PAGO ############################

############################### FUNCION ID MEDIOS DE PAGO #2 ###########################
	public function MediosPagosId()
	{
		self::SetNames();
		$sql = " select * from mediospagos where codmediopago = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["formapagove"]) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$this->p[] = $row;
				}
				return $this->p;
				$this->dbh=null;
			}
		}
############################### FUNCION ID MEDIOS DE PAGO #2 ###########################


############################### FUNCION PARA ACTUALIZAR MEDIOS DE PAGO ############################
		public function ActualizarMediosPagos()
		{

			self::SetNames();
			if(empty($_POST["codmediopago"]) or empty($_POST["mediopago"]))
			{
				echo "1";
				exit;
			}
			$sql = " select mediopago from mediospagos where codmediopago != ? and mediopago = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute( array($_POST["codmediopago"], $_POST["mediopago"]) );
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " update mediospagos set "
				." mediopago = ? "
				." where "
				." codmediopago = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $mediopago);
				$stmt->bindParam(2, $codmediopago);

				$mediopago = strip_tags(strtoupper($_POST["mediopago"]));
				$codmediopago = strip_tags(strtoupper($_POST["codmediopago"]));
				$stmt->execute(); ?>
				
				<script type="text/javascript">
				    toastr.options = {
				      "closeButton":true,
				      "progressBar": true
				    };
				    toastr.success("Medio de pago actualizado con exito","Datos actualizados");
		  		</script>
			<?php }
			else
			{
				echo "2";
				exit;
			}
		}
############################### FUNCION PARA ACTUALIZAR MEDIOS DE PAGO ############################

############################### FUNCION PARA ELIMINAR MEDIOS DE PAGO ############################
		public function EliminarMediosPagos()
		{

			$sql = " select codmediopago from ventas where codmediopago = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute( array(base64_decode($_GET["codmediopago"])) );
			$num = $stmt->rowCount();
			if($num == 0)
			{

				$sql = " delete from mediospagos where codmediopago = ? ";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1,$codmediopago);
				$codmediopago = base64_decode($_GET["codmediopago"]);
				$stmt->execute();

				header("Location: mediospagos?mesage=1");
				exit;

			}else {

				header("Location: mediospagos?mesage=2");
				exit;
			}

		}
############################### FUNCION PARA ELIMINAR MEDIOS DE PAGO ############################

############################### FIN DE CLASE MEDIOS DE PAGO ####################################












































################################# CLASE CATEGORIAS DE PRODUCTOS ###############################

############################## FUNCION PARA REGISTRAR CATEGORIAS ##############################
public function RegistrarCategorias()
{
	self::SetNames();
	if(empty($_POST["nomcategoria"]))
	{
		echo "1";
		exit;
	}
	$sql = " select nomcategoria from categorias where nomcategoria = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["nomcategoria"]) );
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " insert into categorias values (null, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $nomcategoria);

		$nomcategoria = strip_tags(strtoupper($_POST["nomcategoria"]));
		$stmt->execute(); ?>

		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.success("Categoria registrada con exito","Datos registrados");
  		</script>
	<?php }
	else
	{
		echo "2";
		exit;
	}
}
############################## FUNCION PARA REGISTRAR CATEGORIAS ##############################

############################## FUNCION PARA LISTAR CATEGORIAS ##############################
public function ListarCategorias()
{
	self::SetNames();
	$sql = " select * from categorias";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
############################## FUNCION PARA LISTAR CATEGORIAS ##############################


############################## FUNCION ID CATEGORIAS ##############################
public function CategoriasPorId()
{
	self::SetNames();
	$sql = " select * from categorias where codcategoria = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codcategoria"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################## FUNCION ID CATEGORIAS ##############################

############################## FUNCION PARA ACTUALIZAR CATEGORIAS ##############################
	public function ActualizarCategorias()
	{

		self::SetNames();
		if(empty($_POST["codcategoria"]) or empty($_POST["nomcategoria"]))
		{
			echo "1";
			exit;
		}
		$sql = " select nomcategoria from categorias where codcategoria != ? and nomcategoria = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codcategoria"], $_POST["nomcategoria"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = " update categorias set "
			." nomcategoria = ? "
			." where "
			." codcategoria = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $nomcategoria);
			$stmt->bindParam(2, $codcategoria);

			$codcategoria = strip_tags(strtoupper($_POST["codcategoria"]));
			$nomcategoria = strip_tags(strtoupper($_POST["nomcategoria"]));
			$stmt->execute(); ?>

			<script type="text/javascript">
			    toastr.options = {
			      "closeButton":true,
			      "progressBar": true
			    };
			    toastr.success("Categoria actualizada con exito","Datos actualizados");
	  		</script>
		<?php }
		else
		{
			echo "2";
			exit;
		}
	}
############################## FUNCION PARA ACTUALIZAR CATEGORIAS ##############################

############################## FUNCION PARA ELIMINAR CATEGORIAS ##############################
	public function EliminarCategorias()
	{

		$sql = " select codcategoria from productos where codcategoria = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codcategoria"])) );
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = " delete from categorias where codcategoria = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codcategoria);
			$codcategoria = base64_decode($_GET["codcategoria"]);
			$stmt->execute();

			header("Location: categorias?mesage=1");
			exit;

		}else {

			header("Location: categorias?mesage=2");
			exit;
		}

	}
############################## FUNCION PARA ELIMINAR CATEGORIAS ##############################

############################ FIN DE CLASE CATEGORIAS DE PRODUCTOS ##############################







































#################################### CLASE CAJAS DE VENTAS #####################################

################################# FUNCION PARA REGISTRAR CAJAS #################################
public function RegistrarCajas()
{
	self::SetNames();
	if(empty($_POST["nrocaja"]) or empty($_POST["nombrecaja"]))
	{
		echo "1";
		exit;
	}
	$sql = " select nombrecaja from cajas where nombrecaja = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["nombrecaja"]) );
	$num = $stmt->rowCount();
	if($num > 0)
	{
		echo "2";
		exit;
	}
	else
	{
		$sql = " select codigo from cajas where codigo = ? and codigo != ''";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codigo"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " insert into cajas values (null, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nrocaja);
			$stmt->bindParam(2, $nombrecaja);
			$stmt->bindParam(3, $codigo);

			$nrocaja = strip_tags($_POST["nrocaja"]);
			$nombrecaja = strip_tags($_POST["nombrecaja"]);
			$codigo = strip_tags($_POST["codigo"]);
			$stmt->execute(); ?>

			<script type="text/javascript">
			    toastr.options = {
			      "closeButton":true,
			      "progressBar": true
			    };
			    toastr.success("Caja registrada con exito","Datos registrados");
	  		</script>
		<?php }
		else
		{
			echo "3";
			exit;
		}
	}
} 
################################# FUNCION PARA REGISTRAR CAJAS #################################

################################# FUNCION PARA LISTAR CAJAS #################################
public function ListarCajas()
{
	self::SetNames();
	$sql = " select * from cajas LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
################################# FUNCION PARA LISTAR CAJAS #################################

############################ FUNCION PARA LISTAR CAJAS ABIERTAS ##############################
public function ListarCajasAbiertas()
{
	self::SetNames();
	$sql = " select * from cajas INNER JOIN arqueocaja ON cajas.codcaja = arqueocaja.codcaja LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE arqueocaja.statusarqueo = '1'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION PARA LISTAR CAJAS ABIERTAS ##############################


################################# FUNCION ID CAJAS #################################
public function CajaPorId()
{
	self::SetNames();
	$sql = " select * from cajas LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE cajas.codcaja = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codcaja"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################# FUNCION ID CAJAS #################################

################################# FUNCION ID CAJEROS #################################
	public function CajerosPorId()
	{
		self::SetNames();
		$sql = " select * from cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE cajas.codcaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codcaja"]) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$this->p[] = $row;
				}
				return $this->p;
				$this->dbh=null;
			}
		}
################################# FUNCION PARA REGISTRAR CAJAS #################################

################################# FUNCION PARA ACTUALIZAR CAJAS #################################
		public function ActualizarCaja()
		{
			self::SetNames();
			if(empty($_POST["codcaja"]))
			{
				echo "1";
				exit;
			}
			$sql = " select nombrecaja from cajas where codcaja != ? and nombrecaja = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute( array($_POST["codcaja"], $_POST["nombrecaja"]) );
			$num = $stmt->rowCount();
			if($num > 0)
			{
				echo "2";
				exit;
			}
			else
			{
				$sql = " select codigo from cajas where codcaja != ? and codigo = ? and codigo != 0";
				$stmt = $this->dbh->prepare($sql);
				$stmt->execute( array($_POST["codcaja"], $_POST["codigo"]) );
				$num = $stmt->rowCount();
				if($num == 0)
				{
					$sql = " update cajas set "
					." nrocaja = ?, "
					." nombrecaja = ?, "
					." codigo = ? "
					." where "
					." codcaja = ?;
					";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindParam(1, $nrocaja);
					$stmt->bindParam(2, $nombrecaja);
					$stmt->bindParam(3, $codigo);
					$stmt->bindParam(4, $codcaja);

					$nrocaja = strip_tags($_POST["nrocaja"]);
					$nombrecaja = strip_tags($_POST["nombrecaja"]);
					$codigo = strip_tags($_POST["codigo"]);
					$codcaja = strip_tags($_POST["codcaja"]);
					$stmt->execute(); ?>

					<script type="text/javascript">
					    toastr.options = {
					      "closeButton":true,
					      "progressBar": true
					    };
					    toastr.success("Caja actualizada con exito","Datos actualizados");
			  		</script>
				<?php }
				else
				{
					echo "3";
					exit;
				}
			}
		} 
################################# FUNCION PARA ACTUALIZAR CAJAS #################################

################################# FUNCION PARA ELIMINAR CAJAS #################################
		public function EliminarCaja()
		{

			$sql = " select codcaja from ventas where codcaja = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute( array(base64_decode($_GET["codcaja"])) );
			$num = $stmt->rowCount();
			if($num == 0)
			{

				$sql = " delete from cajas where codcaja = ? ";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1,$codcaja);
				$codcaja = base64_decode($_GET["codcaja"]);
				$stmt->execute();

				header("Location: cajas?mesage=1");
				exit;

			}else {

				header("Location: cajas?mesage=2");
				exit;
			}

		} 
################################# FUNCION PARA ELIMINAR CAJAS #################################

############################# FIN DE CLASE CAJAS DE VENTAS  ##############################






















































#################################### CLASE CLIENTES ####################################

################################## FUNCION PARA REGISTRAR CLIENTES #############################
public function RegistrarClientes()
{
	self::SetNames();
	if(empty($_POST["cedcliente"]) or empty($_POST["nomcliente"]))
	{
		echo "1";
		exit;
	}

	$sql = " select cedcliente from clientes where cedcliente = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["cedcliente"]) );
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " insert into clientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cedcliente);
		$stmt->bindParam(2, $nomcliente);
		$stmt->bindParam(3, $direccliente);
		$stmt->bindParam(4, $depcliente);
		$stmt->bindParam(5, $procliente);
		$stmt->bindParam(6, $discliente);
		$stmt->bindParam(7, $ubgcliente);
		$stmt->bindParam(8, $tlfcliente);
		$stmt->bindParam(9, $emailcliente);
		$stmt->bindParam(10, $tipocliente);

		$cedcliente = strip_tags($_POST["cedcliente"]);
		$nomcliente = strip_tags($_POST["nomcliente"]);
		$direccliente = strip_tags($_POST["direccliente"]);
		$depcliente = strip_tags($_POST["depcliente"]);
		$procliente = strip_tags($_POST["procliente"]);
		$discliente = strip_tags($_POST["discliente"]);
		$ubgcliente = strip_tags($_POST["ubgcliente"]);
		$tlfcliente = strip_tags($_POST["tlfcliente"]);
		$emailcliente = strip_tags($_POST["emailcliente"]);
		$tipocliente = strip_tags($_POST["tipocliente"]);
		$stmt->execute(); ?>

		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.success("Cliente registrado con exito","Datos registrados");
  		</script>
	<?php }
	else
	{
		echo "2";
		exit;
	}
}
################################## FUNCION PARA REGISTRAR CLIENTES #############################

################################## FUNCION PARA LISTAR CLIENTES #############################
public function ListarClientes()
{
	self::SetNames();
	$sql = " select * from clientes ";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
################################## FUNCION PARA LISTAR CLIENTES #############################

################################## FUNCION ID CLIENTES #############################
public function ClientesPorId()
{
	self::SetNames();
	$sql = " select * from clientes where codcliente = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codcliente"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################## FUNCION ID CLIENTES #############################

################################## FUNCION PARA ACUALIZAR CLIENTES #############################
	public function ActualizarClientes()
	{
		self::SetNames();
		if(empty($_POST["cedcliente"]) or empty($_POST["nomcliente"]))
		{
			echo "1";
			exit;
		}

		$sql = " select cedcliente from clientes where codcliente != ? and cedcliente = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codcliente"], $_POST["cedcliente"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = " update clientes set "
			." cedcliente = ?, "
			." nomcliente = ?, "
			." direccliente = ?, "
			." depcliente = ?, "
			." procliente = ?, "
			." discliente = ?, "
			." ubgcliente = ?, "
			." tlfcliente = ?, "
			." emailcliente = ? "
			." where "
			." codcliente = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $cedcliente);
			$stmt->bindParam(2, $nomcliente);
			$stmt->bindParam(3, $direccliente);
			$stmt->bindParam(4, $depcliente);
			$stmt->bindParam(5, $procliente);
			$stmt->bindParam(6, $discliente);
			$stmt->bindParam(7, $ubgcliente);
			$stmt->bindParam(8, $tlfcliente);
			$stmt->bindParam(9, $emailcliente);
			$stmt->bindParam(10, $codcliente);

			$cedcliente = strip_tags($_POST["cedcliente"]);
			$nomcliente = strip_tags($_POST["nomcliente"]);
			$direccliente = strip_tags($_POST["direccliente"]);
			$tlfcliente = strip_tags($_POST["tlfcliente"]);
			$depcliente = strip_tags($_POST["depcliente"]);
			$procliente = strip_tags($_POST["procliente"]);
			$discliente = strip_tags($_POST["discliente"]);
			$ubgcliente = strip_tags($_POST["ubgcliente"]);
			$emailcliente = strip_tags($_POST["emailcliente"]);
			$codcliente = strip_tags($_POST["codcliente"]);
			$stmt->execute(); ?>

			<script type="text/javascript">
			    toastr.options = {
			      "closeButton":true,
			      "progressBar": true
			    };
			    toastr.success("cliente actualizado con exito","Datos actualizados");
	  		</script>
		<?php }
		else
		{
			echo "3";
			exit;
		}
	}
################################## FUNCION PARA ACTUALIZAR CLIENTES #############################

################################## FUNCION PARA ELIMINAR CLIENTES #############################
	public function EliminarClientes()
	{
		if($_SESSION['acceso'] == "administrador") {

			$sql = " select codcliente from ventas where codcliente = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute( array(base64_decode($_GET["codcliente"])) );
			$num = $stmt->rowCount();
			if($num == 0)
			{

				$sql = " delete from clientes where codcliente = ? ";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1,$codcliente);
				$codcliente = base64_decode($_GET["codcliente"]);
				$stmt->execute();

				header("Location: clientes?mesage=1");
				exit;

			}else {

				header("Location: clientes?mesage=2");
				exit;
			} 

		} else {

			header("Location: clientes?mesage=3");
			exit;
		}	
	}
################################## FUNCION PARA ELIMINAR CLIENTES #############################

################################# FIN DE CLASE CLIENTES #####################################























##################################### CLASE PROVEEDORES ################################

################################ FUNCION PARA REGISTRAR PROVEEDORES ############################
public function RegistrarProveedores()
{
	self::SetNames();
	if(empty($_POST["ritproveedor"]) or empty($_POST["nomproveedor"]) or empty($_POST["direcproveedor"]) or empty($_POST["tlfproveedor"]))
	{
		echo "1";
		exit;
	}
	$sql = " select ritproveedor from proveedores where ritproveedor = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["ritproveedor"]) );
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " insert into proveedores values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $ritproveedor);
		$stmt->bindParam(2, $nomproveedor);
		$stmt->bindParam(3, $direcproveedor);
		$stmt->bindParam(4, $depproveedor);
		$stmt->bindParam(5, $disproveedor);
		$stmt->bindParam(6, $proproveedor);
		$stmt->bindParam(7, $ubgproveedor);
		$stmt->bindParam(8, $tlfproveedor);
		$stmt->bindParam(9, $emailproveedor);
		$stmt->bindParam(10, $contactoproveedor);
		$stmt->bindParam(11, $tipoproveedor);

		$ritproveedor = strip_tags($_POST["ritproveedor"]);
		$nomproveedor = strip_tags($_POST["nomproveedor"]);
		$direcproveedor = strip_tags($_POST["direcproveedor"]);
		$depproveedor = strip_tags($_POST["depproveedor"]);
		$proproveedor = strip_tags($_POST["proproveedor"]);
		$disproveedor = strip_tags($_POST["disproveedor"]);
		$ubgproveedor = strip_tags($_POST["ubgproveedor"]);
		$tlfproveedor = strip_tags($_POST["tlfproveedor"]);
		$emailproveedor = strip_tags($_POST["emailproveedor"]);
		$contactoproveedor = strip_tags($_POST["contactoproveedor"]);
		$tipoproveedor = strip_tags($_POST["tipoproveedor"]);
		$stmt->execute(); ?>

		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.success("Proveedor registrado con exito","Datos registrados");
  		</script>
	<?php }
	else
	{
		echo "3";
		exit;
	}
}
################################ FUNCION PARA REGISTRAR PROVEEDORES ############################

################################ FUNCION PARA LISTAR PROVEEDORES ############################
public function ListarProveedores()
{
	self::SetNames();
	$sql = " select * from proveedores ";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
################################ FUNCION PARA LISTAR PROVEEDORES ############################

################################ FUNCION ID PROVEEDORES ############################
public function ProveedoresPorId()
{
	self::SetNames();
	$sql = " select * from proveedores where codproveedor = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codproveedor"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################ FUNCION ID PROVEEDORES ############################

################################ FUNCION ID PROVEEDORES #2 ###########################
	public function ProveedorPorId()
	{
		self::SetNames();
		$sql = " select * from proveedores where codproveedor = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codproveedor"]) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$this->p[] = $row;
				}
				return $this->p;
				$this->dbh=null;
			}
		}
################################ FUNCION ID PROVEEDORES #2 ###########################


################################ FUNCION PARA ACTUALIZAR PROVEEDORES ############################
		public function ActualizarProveedores()
		{
			self::SetNames();
			if(empty($_POST["ritproveedor"]) or empty($_POST["nomproveedor"]) or empty($_POST["direcproveedor"]) or empty($_POST["tlfproveedor"]))
			{
				echo "1";
				exit;
			}

			$sql = " select * from proveedores where codproveedor != ? and ritproveedor = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute( array($_POST["codproveedor"], $_POST["ritproveedor"]) );
			$num = $stmt->rowCount();
			if($num == 0)
			{

				$sql = " update proveedores set "
				." ritproveedor = ?, "
				." nomproveedor = ?, "
				." direcproveedor = ?, "
				." depproveedor = ?, "
				." disproveedor = ?, "
				." proproveedor = ?, "
				." ubgproveedor = ?, "
				." tlfproveedor = ?, "
				." emailproveedor = ?, "
				." contactoproveedor = ? "
				." where "
				." codproveedor = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $ritproveedor);
				$stmt->bindParam(2, $nomproveedor);
				$stmt->bindParam(3, $direcproveedor);
				$stmt->bindParam(4, $depproveedor);
				$stmt->bindParam(5, $disproveedor);
				$stmt->bindParam(6, $proproveedor);
				$stmt->bindParam(7, $ubgproveedor);
				$stmt->bindParam(8, $tlfproveedor);
				$stmt->bindParam(9, $emailproveedor);
				$stmt->bindParam(10, $contactoproveedor);
				$stmt->bindParam(11, $codproveedor);

				$ritproveedor = strip_tags($_POST["ritproveedor"]);
				$nomproveedor = strip_tags($_POST["nomproveedor"]);
				$direcproveedor = strip_tags($_POST["direcproveedor"]);
				$depproveedor = strip_tags($_POST["depproveedor"]);
				$proproveedor = strip_tags($_POST["proproveedor"]);
				$disproveedor = strip_tags($_POST["disproveedor"]);
				$ubgproveedor = strip_tags($_POST["ubgproveedor"]);
				$tlfproveedor = strip_tags($_POST["tlfproveedor"]);
				$emailproveedor = strip_tags($_POST["emailproveedor"]);
				$contactoproveedor = strip_tags($_POST["contactoproveedor"]);
				$codproveedor = strip_tags($_POST["codproveedor"]);
				$stmt->execute(); ?>

				<script type="text/javascript">
				    toastr.options = {
				      "closeButton":true,
				      "progressBar": true
				    };
				    toastr.success("Proveedor actualizado con exito","Datos actualizados");
		  		</script>
			<?php }
			else
			{
				echo "3";
				exit;
			}
		}
################################ FUNCION PARA ACTUALIZAR PROVEEDORES ############################

################################ FUNCION PARA ELIMINAR PROVEEDORES ############################
		public function EliminarProveedores()
		{
			if($_SESSION['acceso'] == "administrador") {

				$sql = " select codproveedor from compras where codproveedor = ? ";
				$stmt = $this->dbh->prepare($sql);
				$stmt->execute( array(base64_decode($_GET["codproveedor"])) );
				$num = $stmt->rowCount();
				if($num == 0)
				{

					$sql = " delete from proveedores where codproveedor = ? ";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindParam(1,$codproveedor);
					$codproveedor = base64_decode($_GET["codproveedor"]);
					$stmt->execute();

					header("Location: proveedores?mesage=1");
					exit;

				}else {

					header("Location: proveedores?mesage=2");
					exit;
				} 

			} else {

				header("Location: proveedores?mesage=3");
				exit;
			}	
		}
################################ FUNCION PARA ELIMINAR PROVEEDORES ############################

################################## FIN DE CLASE PROVEEDORES #####################################









































###################################### CLASE INGREDIENTES #######################################

############################### FUNCION PARA CODIGO INGREDIENTES #############################
public function CodigoIngrediente()
{
	self::SetNames();

	$sql = " select codingrediente from ingredientes order by codingrediente desc limit 1";
	foreach ($this->dbh->query($sql) as $row){

		$codingrediente["codingrediente"]=$row["codingrediente"];

	}
	if(empty($codingrediente["codingrediente"]))
	{
		echo $nroventa = '00001';

	} else
	{
		$resto = substr($codingrediente["codingrediente"], 0, -0);
		$coun = strlen($resto);
		$num     = substr($codingrediente["codingrediente"] , $coun);
		$dig     = $num + 1;
		$codigo = str_pad($dig, 5, "0", STR_PAD_LEFT);
		echo $nroventa = $codigo;
	}
}
############################### FUNCION PARA CODIGO INGREDIENTES #############################

############################### FUNCION PARA REGISTRAR INGREDIENTES #############################
public function RegistrarIngredientes()
{
	self::SetNames();
	if(empty($_POST["codingrediente"]) or empty($_POST["nomingrediente"]) or empty($_POST["cantingrediente"]))
	{
		echo "1";
		exit;
	}
	$sql = " select nomingrediente from ingredientes where nomingrediente = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["nomingrediente"]) );
	$num = $stmt->rowCount();
	if($num > 0)
	{
		echo "2";
		exit;
	}
	else
	{
		$sql = " select codingrediente from ingredientes where codingrediente = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codingrediente"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " insert into ingredientes values (null, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codingrediente);
			$stmt->bindParam(2, $nomingrediente);
			$stmt->bindParam(3, $cantingrediente);
			$stmt->bindParam(4, $costoingrediente);
			$stmt->bindParam(5, $unidadingrediente);
			$stmt->bindParam(6, $codproveedor);
			$stmt->bindParam(7, $stockminimoingrediente);

			$codingrediente = strip_tags($_POST["codingrediente"]);
			$nomingrediente = strip_tags($_POST["nomingrediente"]);
			$cantingrediente = strip_tags($_POST["cantingrediente"]);
			$costoingrediente = strip_tags($_POST["costoingrediente"]);
			$unidadingrediente = strip_tags($_POST["unidadingrediente"]);
			$codproveedor = strip_tags($_POST["codproveedor"]);
			$stockminimoingrediente = strip_tags($_POST["stockminimoingrediente"]);
			$stmt->execute();

			$query = " insert into kardexingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codproceso);
			$stmt->bindParam(2, $codresponsable);
			$stmt->bindParam(3, $codigoproducto);
			$stmt->bindParam(4, $codingrediente);
			$stmt->bindParam(5, $movimiento);
			$stmt->bindParam(6, $entradas);
			$stmt->bindParam(7, $salidas);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $preciounit);
			$stmt->bindParam(10, $costototal);
			$stmt->bindParam(11, $documento);
			$stmt->bindParam(12, $fechakardex);

			$codproceso = strip_tags($_POST['codprocesoing']);
			$codresponsable = strip_tags("0");
			$codigoproducto = strip_tags('0');
			$codingrediente = strip_tags($_POST['codingrediente']);
			$movimiento = strip_tags("ENTRADAS");
			$entradas = strip_tags($_POST['cantingrediente']);
			$salidas = strip_tags("0");
			$stockactual = strip_tags($_POST['cantingrediente']);
			$preciounit = strip_tags($_POST['costoingrediente']);
			$costototal = strip_tags($_POST['costoingrediente'] * $_POST['cantingrediente']);
			$documento = strip_tags("INVENTARIO INICIAL");
			$fechakardex = strip_tags(date("Y-m-d"));
			$stmt->execute(); ?>

			<script type="text/javascript">
			    toastr.options = {
			      "closeButton":true,
			      "progressBar": true
			    };
			    toastr.success("Ingrediente registrado con exito","Datos registrados");
	  		</script>
		<?php }
		else
		{
			echo "3";
			exit;
		}
	}
}
############################### FUNCION PARA REGISTRAR INGREDIENTES #############################

############################### FUNCION PARA LISTAR INGREDIENTES #############################
public function ListarIngredientes()
{
	self::SetNames();
	$sql = " SELECT * FROM ingredientes LEFT JOIN proveedores ON ingredientes.codproveedor = proveedores.codproveedor";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
############################### FUNCION PARA LISTAR INGREDIENTES #############################

############################### FUNCION ID INGREDIENTES #############################
public function IngredientesPorId()
{
	self::SetNames();
	$sql = " SELECT * FROM ingredientes LEFT JOIN proveedores ON ingredientes.codproveedor = proveedores.codproveedor WHERE ingredientes.codingrediente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codingrediente"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################### FUNCION ID INGREDIENTES #############################

############################### FUNCION PARA VER KARDEX INGREDIENTES #############################
public function VerDetallesKardexIngrediente()
{
self::SetNames();
$sql ="SELECT kardexingredientes.codingrediente, kardexingredientes.codresponsableing, kardexingredientes.movimientoing, kardexingredientes.entradasing, kardexingredientes.salidasing, kardexingredientes.stockactualing, kardexingredientes.preciouniting, kardexingredientes.costototaling, kardexingredientes.documentoing, kardexingredientes.fechakardexing, proveedores.nomproveedor as proveedor, clientes.nomcliente as clientes FROM (ingredientes LEFT JOIN kardexingredientes ON ingredientes.codingrediente=kardexingredientes.codingrediente) LEFT JOIN proveedores ON proveedores.codproveedor=kardexingredientes.codresponsableing LEFT JOIN clientes ON clientes.codcliente=kardexingredientes.codresponsableing WHERE kardexingredientes.codingrediente = ?";
$stmt = $this->dbh->prepare($sql);
$stmt->execute( array(base64_decode($_GET["codingrediente"])) );
$num = $stmt->rowCount();

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	$this->p[]=$row;
}
return $this->p;
$this->dbh=null;
}
############################### FUNCION PARA VER KARDEX INGREDIENTES #############################

############################### FUNCION PARA ACTUALIZAR INGREDIENTES #############################
public function ActualizarIngredientes()
{
	self::SetNames();
	if(empty($_POST["codingrediente"]) or empty($_POST["nomingrediente"]) or empty($_POST["cantingrediente"]))
	{
		echo "1";
		exit;
	}
	$sql = " select nomingrediente from ingredientes where codingrediente != ? and nomingrediente = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["codingrediente"], $_POST["nomingrediente"]) );
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " update ingredientes set "
		." nomingrediente = ?, "
		." cantingrediente = ?, "
		." costoingrediente = ?, "
		." unidadingrediente = ?, "
		." codproveedor = ?, "
		." stockminimoingrediente = ? "
		." where "
		." codingrediente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $nomingrediente);
		$stmt->bindParam(2, $cantingrediente);
		$stmt->bindParam(3, $costoingrediente);
		$stmt->bindParam(4, $unidadingrediente);
		$stmt->bindParam(5, $codproveedor);
		$stmt->bindParam(6, $stockminimoingrediente);
		$stmt->bindParam(7, $codingrediente);

		$nomingrediente = strip_tags($_POST["nomingrediente"]);
		$cantingrediente = strip_tags($_POST["cantingrediente"]);
		$costoingrediente = strip_tags($_POST["costoingrediente"]);
		$unidadingrediente = strip_tags($_POST["unidadingrediente"]);
		$codproveedor = strip_tags($_POST["codproveedor"]);
		$stockminimoingrediente = strip_tags($_POST["stockminimoingrediente"]);
		$codingrediente = strip_tags($_POST["codingrediente"]);
		$stmt->execute(); ?>

		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.success("Ingrediente actualizado con exito","Datos actualizados");
  		</script>
	<?php }
	else
	{
		echo "2";
		exit;
	}
}
############################### FUNCION PARA ACTUALIZAR INGREDIENTES #############################

############################### FUNCION PARA ELIMINAR INGREDIENTES #############################
public function EliminarIngredientes()
{
if($_SESSION['acceso'] == "administrador") {

	$sql = " select codingrediente from productosvsingredientes where codingrediente = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codingrediente"])) );
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " delete from ingredientes where codingrediente = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codingrediente);
		$codingrediente = base64_decode($_GET["codingrediente"]);
		$stmt->execute();

		header("Location: ingredientes?mesage=1");
		exit;

	} else {

		header("Location: ingredientes?mesage=2");
		exit;
	} 

} else {

	header("Location: ingredientes?mesage=3");
	exit;
}	
}
############################### FUNCION PARA ELIMINAR INGREDIENTES #############################

############################ FUNCION PARA LISTAR INGREDIENTES VENIDOS #############################
public function ListarIngredientesVendidos() 
{
	self::SetNames();
	$sql ="SELECT 
	productos.codproducto, productos.producto, productos.codcategoria, productos.precioventa, productos.existencia, productos.stockminimo, categorias.nomcategoria, SUM(detalleventas.cantventa) as cantidad 
	FROM
	(productos LEFT OUTER JOIN detalleventas ON productos.codproducto=detalleventas.codproducto) LEFT OUTER JOIN categorias ON 
	categorias.codcategoria=productos.codcategoria WHERE detalleventas.codproducto is not null GROUP BY productos.codproducto";

	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION PARA LISTAR INGREDIENTES VENIDOS #############################


############################ FUNCION PARA LISTAR STOCK MINIMO #############################
public function ListarIngredientesStockMinimo()
{
	self::SetNames();
	$sql = " select * from ingredientes WHERE CAST(cantingrediente AS DECIMAL(10,5)) <= CAST(stockminimoingrediente AS DECIMAL(10,5))";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION PARA LISTAR STOCK MINIMO #############################

############################ FUNCION PARA BUSCA KARDEX DE INGREDIENTES ##########################
public function BuscarKardexIngrediente() 
{
	self::SetNames();
	$sql ="SELECT ingredientes.nomingrediente, ingredientes.unidadingrediente, ingredientes.cantingrediente , ingredientes.costoingrediente, kardexingredientes.codingrediente, kardexingredientes.codresponsableing, kardexingredientes.movimientoing, kardexingredientes.entradasing, kardexingredientes.salidasing, kardexingredientes.stockactualing, kardexingredientes.preciouniting, kardexingredientes.costototaling, kardexingredientes.documentoing, kardexingredientes.fechakardexing, proveedores.nomproveedor as proveedor, clientes.nomcliente as clientes FROM (ingredientes LEFT JOIN kardexingredientes ON ingredientes.codingrediente=kardexingredientes.codingrediente) LEFT JOIN proveedores ON proveedores.codproveedor=kardexingredientes.codresponsableing LEFT JOIN clientes ON clientes.codcliente=kardexingredientes.codresponsableing WHERE kardexingredientes.codingrediente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_GET["codingrediente"]) );
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{ ?>

		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.info("No existen movimientos","No hay datos");
  		</script>

		<?php
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN MOVIMIENTOS EN KARDEX PARA EL INGREDIENTE INGRESADO</div></center>";
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################ FUNCION PARA BUSCA KARDEX DE INGREDIENTES ##########################

################################ FIN DE CLASE INGREDIENTES #################################






























################################# CLASE PRODUCTOS EN ALMACEN #############################

############################### FUNCION PARA CODIGO PRODUCTO #################################
	public function CodigoProducto()
	{
		self::SetNames();

		$sql = " select codproducto from productos order by codproducto desc limit 1";
		foreach ($this->dbh->query($sql) as $row){

			$codproducto["codproducto"]=$row["codproducto"];

		}
		if(empty($codproducto["codproducto"]))
		{
			echo $nro = '00001';

		} else
		{
			$resto = substr($codproducto["codproducto"], 0, -0);
			$coun = strlen($resto);
			$num     = substr($codproducto["codproducto"] , $coun);
			$dig     = $num + 1;
			$codigo = str_pad($dig, 5, "0", STR_PAD_LEFT);
			echo $nro = $codigo;
		}
	}
############################### FUNCION PARA CODIGO PRODUCTO #################################

########################## FUNCION PARA CARGA MASIVA DE PRODUCTOS ###########################
	public function CargarProductos()
	{
		self::SetNames();
		if(empty($_FILES["sel_file"]))
		{
			echo "1";
			exit;
		}
//Aquí es donde seleccionamos nuestro csv
		$fname = $_FILES['sel_file']['name'];
//echo 'Cargando nombre del archivo: '.$fname.' ';
		$chk_ext = explode(".",$fname);

		if(strtolower(end($chk_ext)) == "csv")
		{
//si es correcto, entonces damos permisos de lectura para subir
			$filename = $_FILES['sel_file']['tmp_name'];
			$handle = fopen($filename, "r");

			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
			{
//Insertamos los datos con los valores...

				$query = " insert into productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?; ";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $data[1]);
				$stmt->bindParam(2, $data[2]);
				$stmt->bindParam(3, $data[3]);
				$stmt->bindParam(4, $data[4]);
				$stmt->bindParam(5, $data[5]);
				$stmt->bindParam(6, $data[6]);
				$stmt->bindParam(7, $data[7]);
				$stmt->bindParam(8, $data[8]);
				$stmt->bindParam(9, $data[9]);
				$stmt->bindParam(10, $data[10]);
				$stmt->execute();

			}
//cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
			fclose($handle); ?>

			<script type="text/javascript">
			    toastr.options = {
			      "closeButton":true,
			      "progressBar": true
			    };
			    toastr.success("Carga de productos con exito","Datos cargados");
	  		</script>

		<?php }
		else
		{
//si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
			echo "2";
			exit;
		}  
	}
########################## FUNCION PARA CARGA MASIVA DE PRODUCTOS ###########################

########################### FUNCION PARA REGISTRAR PRODUCTOS #################################
	public function RegistrarProductos()
	{
		self::SetNames();
		if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codcategoria"]))
		{
			echo "1";
			exit;
		}

		$ingrediente = $_POST['codingrediente'];
		$repeated = array_filter(array_count_values($ingrediente), function($count) {
			return $count > 1;
		});
		foreach ($repeated as $key => $value) {
			echo "2";
			exit;
		}

		$sql = " select codproducto from productos where codproducto = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codproducto"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
##################### REGISTRAMOS LOS NUEVOS PRODUCTOS ####################################
			$query = " insert into productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codproducto);
			$stmt->bindParam(2, $producto);
			$stmt->bindParam(3, $codcategoria);
			$stmt->bindParam(4, $preciocompra);
			$stmt->bindParam(5, $precioventa);
			$stmt->bindParam(6, $existencia);
			$stmt->bindParam(7, $stockminimo);
			$stmt->bindParam(8, $ivaproducto);
			$stmt->bindParam(9, $descproducto);
			$stmt->bindParam(10, $codproveedor);
			$stmt->bindParam(11, $codigobarra);
			$stmt->bindParam(12, $favorito);
			$stmt->bindParam(13, $statusproducto);

			$codproducto = strip_tags($_POST["codproducto"]);
			$producto = strip_tags($_POST["producto"]);
			$codcategoria = strip_tags($_POST["codcategoria"]);
			$preciocompra = strip_tags($_POST["preciocompra"]);
			$precioventa = strip_tags($_POST["precioventa"]);
			$existencia = strip_tags($_POST["existencia"]);
			$stockminimo = strip_tags($_POST["stockminimo"]);
			$ivaproducto = strip_tags($_POST["ivaproducto"]);
			$descproducto = strip_tags($_POST["descproducto"]);
			$codproveedor = strip_tags($_POST["codproveedor"]);
			if (strip_tags($_POST['codigobarra']!="")) { $codigobarra = strip_tags($_POST['codigobarra']); } else { $codigobarra ='00000000000'; }
			$favorito = strip_tags($_POST["favorito"]);
			$statusproducto = strip_tags($_POST["statusproducto"]);
			$stmt->execute();

			$query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codproceso);
			$stmt->bindParam(2, $codresponsable);
			$stmt->bindParam(3, $codproducto);
			$stmt->bindParam(4, $movimiento);
			$stmt->bindParam(5, $entradas);
			$stmt->bindParam(6, $salidas);
			$stmt->bindParam(7, $devolucion);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $preciom);
			$stmt->bindParam(10, $costototal);
			$stmt->bindParam(11, $documento);
			$stmt->bindParam(12, $fechakardex);

			$codproceso = strip_tags($_POST['codproceso']);
			$codresponsable = strip_tags("0");
			$codproducto = strip_tags($_POST['codproducto']);
			$movimiento = strip_tags("ENTRADAS");
			$entradas = strip_tags($_POST['existencia']);
			$salidas = strip_tags("0");
			$devolucion = strip_tags("0");
			$stockactual = strip_tags($_POST['existencia']);
			$preciom = strip_tags($_POST['precioventa']);
			$costototal = strip_tags($_POST['precioventa'] * $_POST['existencia']);
			$documento = strip_tags("INVENTARIO INICIAL");
			$fechakardex = strip_tags(date("Y-m-d"));
			$stmt->execute();

##################  SUBIR FOTO DE PRODUCTO ######################################
//datos del arhivo  
			if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
			if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
			if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; } 
//compruebo si las características del archivo son las que deseo  
			if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
			{  
				if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$codproducto.".jpg"))
				{ 
## se puede dar un aviso
				} 
## se puede dar otro aviso 
			}
##################  FINALIZA SUBIR FOTO DE PRODUCTO ######################################


###################### PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ###########################
for($i=0;$i<count($_POST['codingrediente']);$i++){  //recorro el array
	if (!empty($_POST['codingrediente'][$i])) {

		$query = " insert into productosvsingredientes values (null, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $codingrediente);
		$stmt->bindParam(3, $cantidad);

		$codproducto = strip_tags($_POST["codproducto"]);
		$codingrediente = strip_tags($_POST['codingrediente'][$i]);
		$cantidad = strip_tags($_POST['cantidad'][$i]);
		$stmt->execute();
	}
}
################### PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ##################
?>

<script type="text/javascript">
	toastr.options = {
	  "closeButton":true,
	  "progressBar": true
	};
	toastr.success("Producto registrado con exito","Datos registrados");
</script>
<?php }
else
{
	echo "3";
	exit;
}
}
########################### FUNCION PARA REGISTRAR PRODUCTOS #################################

########################### FUNCION PARA AGREGA INGREDIENTES A PRODUCTOS #######################
public function AgregarIngredientes()
{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["codingrediente"]) or empty($_POST["cantidad"]))
	{
		echo "1";
		exit;
	}

	$ingrediente = $_POST['codingrediente'];
	$repeated = array_filter(array_count_values($ingrediente), function($count) {
		return $count > 1;
	});
	foreach ($repeated as $key => $value) {
		echo "2";
		exit;
	}

############## AQUI VALIDO SI LOS NUEVOS INGREDIENTES YA EXISTEN EN LA BASE DE DATOS ############
for($i=0;$i<count($_POST['codingrediente']);$i++){  //recorro el array
	if (!empty($_POST['codingrediente'][$i])) {

		$sql = " select * from productosvsingredientes where codproducto = ? and codingrediente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codproducto"], $_POST["codingrediente"][$i]) );
		$num = $stmt->rowCount();
		if($num > 0)
		{
			echo "3";
			exit;
		}
	}
}

###################### PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ###########################
for($i=0;$i<count($_POST['codingrediente']);$i++){  //recorro el array
	if (!empty($_POST['codingrediente'][$i])) {

		$query = " insert into productosvsingredientes values (null, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $codingrediente);
		$stmt->bindParam(3, $cantidad);

		$codproducto = strip_tags($_POST["codproducto"]);
		$codingrediente = strip_tags($_POST['codingrediente'][$i]);
		$cantidad = strip_tags($_POST['cantidad'][$i]);
		$stmt->execute();
	}
}
##################### PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ####################
?>

<script type="text/javascript">
toastr.options = {
"closeButton":true,
"progressBar": true
};
toastr.success("Ingredientes agregados con exito","Datos registrados");
</script>
<?php }
########################### FUNCION PARA AGREGAR INGREDIENTES A PRODUCTOS ########################

########################### FUNCION PARA LISTAR PRODUCTOS #################################
public function ListarProductos()
{
	self::SetNames();
	$sql = " SELECT * FROM productos INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################### FUNCION PARA LISTAR PRODUCTOS #################################

########################### FUNCION PARA LISTAR PRODUCTOS FAVORITOS #########################
public function ListarProductosFavoritos()
{
	self::SetNames();
	$sql = " SELECT * FROM productos INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor WHERE productos.favorito = 'SI' and productos.existencia > '0'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################### FUNCION PARA LISTAR PRODUCTOS FAVORITOS ##########################

########################### FUNCION ID PRODUCTOS #################################
public function ProductosPorId()
{
	self::SetNames();
	$sql = " SELECT * FROM productos INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor WHERE productos.codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codproducto"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
########################### FUNCION ID PRODUCTOS #################################

########################### FUNCION PARA DETALLES PRODUCTOS #################################
	public function DetalleProductosPorId()
	{
		self::SetNames();
		$sql = " SELECT * FROM productos INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor WHERE productos.codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codproducto"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$this->p[] = $row;
				}
				return $this->p;
				$this->dbh=null;
			}
		}
########################### FUNCION PARA DETALLES PRODUCTOS #################################

########################### FUNCION PARA VER KARDEX PRODUCTOS #################################
		public function VerDetallesKardexProducto()
		{
			self::SetNames();
			$sql ="SELECT kardexproductos.codproducto, kardexproductos.codresponsable, kardexproductos.movimiento, kardexproductos.entradas, kardexproductos.salidas, kardexproductos.stockactual, kardexproductos.preciom, kardexproductos.costototal, kardexproductos.documento, kardexproductos.fechakardex, proveedores.nomproveedor as proveedor, clientes.nomcliente as clientes FROM (productos LEFT JOIN kardexproductos ON productos.codproducto=kardexproductos.codproducto) LEFT JOIN proveedores ON proveedores.codproveedor=kardexproductos.codresponsable LEFT JOIN clientes ON clientes.codcliente=kardexproductos.codresponsable WHERE kardexproductos.codproducto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute( array(base64_decode($_GET["codproducto"])) );
			$num = $stmt->rowCount();

			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$this->p[]=$row;
				}
				return $this->p;
				$this->dbh=null;
			}
########################### FUNCION PARA VER KARDEX PRODUCTOS #################################

########################### FUNCION PARA VER INGREDIENTES EN PRODUCTOS ##########################
public function VerDetallesIngredientesProductos()
{
	self::SetNames();
	$sql ="SELECT productosvsingredientes.codproducto, productosvsingredientes.cantracion, ingredientes.codingrediente, ingredientes.nomingrediente, ingredientes.costoingrediente, ingredientes.cantingrediente, ingredientes.unidadingrediente FROM (productos LEFT JOIN productosvsingredientes ON productos.codproducto=productosvsingredientes.codproducto) LEFT JOIN ingredientes ON ingredientes.codingrediente=productosvsingredientes.codingrediente WHERE productosvsingredientes.codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codproducto"])) );
	$num = $stmt->rowCount();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
########################### FUNCION PARA VER INGREDIENTES EN PRODUCTOS ########################

########################### FUNCION PARA ACTUALIZAR PRODUCTOS #################################
	public function ActualizarProductos()
	{
		if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codcategoria"]))
		{
			echo "1";
			exit;
		}

		if (isset($_POST['codingrediente'])) {

			$ingrediente = $_POST['codingrediente'];
			$repeated = array_filter(array_count_values($ingrediente), function($count) {
				return $count > 1;
			});
			foreach ($repeated as $key => $value) {
				echo "2";
				exit;
			}
		}

		self::SetNames();
		$sql = " update productos set "
		." codproducto = ?, "
		." producto = ?, "
		." codcategoria = ?, "
		." preciocompra = ?, "
		." precioventa = ?, "
		." existencia = ?, "
		." stockminimo = ?, "
		." ivaproducto = ?, "
		." descproducto = ?, "
		." codproveedor = ?, "
		." codigobarra = ?, "
		." favorito = ?, "
		." statusproducto = ? "
		." where "
		." codalmacen = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $producto);
		$stmt->bindParam(3, $codcategoria);
		$stmt->bindParam(4, $preciocompra);
		$stmt->bindParam(5, $precioventa);
		$stmt->bindParam(6, $existencia);
		$stmt->bindParam(7, $stockminimo);
		$stmt->bindParam(8, $ivaproducto);
		$stmt->bindParam(9, $descproducto);
		$stmt->bindParam(10, $codproveedor);
		$stmt->bindParam(11, $codigobarra);
		$stmt->bindParam(12, $favorito);
		$stmt->bindParam(13, $statusproducto);
		$stmt->bindParam(14, $codalmacen);

		$codproducto = strip_tags($_POST["codproducto"]);
		$producto = strip_tags($_POST["producto"]);
		$codcategoria = strip_tags($_POST["codcategoria"]);
		$preciocompra = strip_tags($_POST["preciocompra"]);
		$precioventa = strip_tags($_POST["precioventa"]);
		$existencia = strip_tags($_POST["existencia"]);
		$stockminimo = strip_tags($_POST["stockminimo"]);
		$ivaproducto = strip_tags($_POST["ivaproducto"]);
		$descproducto = strip_tags($_POST["descproducto"]);
		$codproveedor = strip_tags($_POST["codproveedor"]);
		if (strip_tags($_POST['codigobarra']!="")) { $codigobarra = strip_tags($_POST['codigobarra']); } else { $codigobarra ='00000000000'; }
		$favorito = strip_tags($_POST["favorito"]);
		$statusproducto = strip_tags($_POST["statusproducto"]);
		$codalmacen = strip_tags($_POST["codalmacen"]);
		$stmt->execute();

##################  SUBIR FOTO DE PRODUCTO ######################################
//datos del arhivo  
		if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
		if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
		if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; } 
//compruebo si las características del archivo son las que deseo  
		if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
		{  
			if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$codproducto.".jpg"))
			{ 
## se puede dar un aviso
			} 
## se puede dar otro aviso 
		}
##################  FINALIZA SUBIR FOTO DE PRODUCTO ######################################


################## PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS #################
		if (isset($_POST['codingrediente'])) {

for($i=0;$i<count($_POST['codingrediente']);$i++){  //recorro el array
	if (!empty($_POST['codingrediente'][$i])) {

		$query = " update productosvsingredientes set "
		." cantracion = ? "
		." where "
		." codproducto = ? and codingrediente = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantidad);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codingrediente);

		$codproducto = strip_tags($_POST["codproducto"]);
		$codingrediente = strip_tags($_POST['codingrediente'][$i]);
		$cantidad = strip_tags($_POST['cantidad'][$i]);
		$stmt->execute();
	}
}
}
#################### PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ########################
?>

<script type="text/javascript">
toastr.options = {
"closeButton":true,
"progressBar": true
};
toastr.success("Producto actualizado con exito","Datos actualizados");
</script>
<?php }
########################### FUNCION PARA ACTUALIZAR PRODUCTOS #################################

########################### FUNCION PARA ELIMINAR INGREDIENTE A PRODUCTOS #########################
public function EliminarIngredientesProductos()
{
	if($_SESSION['acceso'] == "administrador") {

		$sql = " delete from productosvsingredientes where codproducto = ? and codingrediente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproducto);
		$stmt->bindParam(2,$codingrediente);
		$codproducto = base64_decode($_GET["codproducto"]);
		$codingrediente = base64_decode($_GET["codingrediente"]);
		$stmt->execute(); ?>

		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.success("Ingrediente eliminado con exito","Datos eliminados");
  		</script>

	<?php } else { ?>

		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.error("No tiene permisos para eliminar","Sin permisos");
  		</script>
	<?php }

}
######################## FUNCION PARA ELIMINAR INGREDIENTES A PRODUCTOS ########################

########################### FUNCION PARA ELIMINAR PRODUCTOS #################################
public function EliminarProductos()
{
	if($_SESSION['acceso'] == "administrador") {

		$sql = " select codproducto from detalleventas where codproducto = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codproducto"])) );
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = " delete from productos where codproducto = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codproducto);
			$codproducto = base64_decode($_GET["codproducto"]);
			$stmt->execute();

			$sql = " delete from kardexproductos where codproducto = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codproducto);
			$codproducto = base64_decode($_GET["codproducto"]);
			$stmt->execute();

			header("Location: productos?mesage=1");
			exit;

		}else {

			header("Location: productos?mesage=2");
			exit;
		}

	} else {

		header("Location: productos?mesage=3");
		exit;
	}	
}
########################### FUNCION PARA ELIMINAR PRODUCTOS #################################

########################### FUNCION PARA LISTAR PRODUCTOS VENDIDOS #################################
public function ListarProductosVendidos() 
	{
		self::SetNames();
		$sql ="SELECT 
	productos.codproducto, productos.producto, productos.codcategoria, productos.precioventa, productos.existencia, productos.stockminimo, categorias.nomcategoria, SUM(detalleventas.cantventa) as cantidad 
	FROM
	(productos LEFT OUTER JOIN detalleventas ON productos.codproducto=detalleventas.codproducto) LEFT OUTER JOIN categorias ON 
	categorias.codcategoria=productos.codcategoria WHERE DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') <= ? AND detalleventas.codproducto is not null GROUP BY productos.codproducto";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{ ?>

			<script type="text/javascript">
			    toastr.options = {
			      "closeButton":true,
			      "progressBar": true
			    };
			    toastr.info("No existen datos en el rango de fechas","No hay datos");
	  		</script>


			<?php 

			echo "<div class='alert alert-danger'>";
			echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
			echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS VENDIDOS PARA EL RANGO DE FECHAS SELECCIONADAS</center>";
			echo "</div>";
			exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$this->p[]=$row;
				}
				return $this->p;
				$this->dbh=null;
			}
		}
########################### FUNCION PARA LISTAR PRODUCTOS VENDIDOS #################################

########################### FUNCION PARA LISTAR PRODUCTOS STOCK MINIMO ##########################
public function ListarProductosStockMinimo()
{
	self::SetNames();
	$sql = " select * from productos INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria WHERE productos.existencia <= productos.stockminimo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################### FUNCION PARA LISTAR PRODUCTOS STOCK MINIMO ##########################

######################## FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS #########################
public function BuscarKardexProducto() 
{
	self::SetNames();
	$sql ="SELECT productos.producto, productos.preciocompra, productos.precioventa, productos.existencia, categorias.nomcategoria, kardexproductos.codproducto, kardexproductos.codresponsable, kardexproductos.movimiento, kardexproductos.entradas, kardexproductos.salidas, kardexproductos.devolucion, kardexproductos.stockactual, kardexproductos.preciom, kardexproductos.costototal, kardexproductos.documento, kardexproductos.fechakardex, proveedores.nomproveedor as proveedor, clientes.nomcliente as clientes FROM (productos LEFT JOIN kardexproductos ON productos.codproducto=kardexproductos.codproducto) LEFT JOIN categorias ON categorias.codcategoria=productos.codcategoria LEFT JOIN proveedores ON proveedores.codproveedor=kardexproductos.codresponsable LEFT JOIN clientes ON clientes.codcliente=kardexproductos.codresponsable WHERE kardexproductos.codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_GET["codproducto"]) );
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{ ?>

		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.info("No existen movimientos del producto","No hay datos");
  		</script>


		<?php 
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN MOVIMIENTOS EN KARDEX PARA EL PRODUCTO INGRESADO</div></center>";
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
######################## FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS #########################

################################# FIN DE CLASE PRODUCTOS EN ALMACEN #######################################


































################################## CLASE COMPRAS DE PRODUCTOS ###############################

############################## FUNCION PARA REGISTRAR COMPRAS ################################
public function RegistrarCompras()
{
	self::SetNames();
	if(empty($_POST["codcompra"]) or empty($_POST["codseriec"]) or empty($_POST["codproveedor"]))
	{
		echo "1";
		exit;
	}

	if(empty($_SESSION["CarritoC"]))
	{
		echo "2";
		exit;

	} 

    $sql = " select codcompra from compras where codcompra = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_POST["codcompra"]) );
	$num = $stmt->rowCount();
	if($num > 0)
	{

		echo "3";
		exit;
	}
	else
	{
		$sql = " select codseriec from compras where codseriec = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codseriec"]) );
		$num = $stmt->rowCount();
		if($num > 0)
		{

			echo "4";
			exit;
		}
		else
		{


		$query = " insert into compras values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codseriec);
		$stmt->bindParam(3, $codproveedor);
		$stmt->bindParam(4, $subtotalivasic);
		$stmt->bindParam(5, $subtotalivanoc);
		$stmt->bindParam(6, $ivac);
		$stmt->bindParam(7, $totalivac);
		$stmt->bindParam(8, $descuentoc);
		$stmt->bindParam(9, $totaldescuentoc);
		$stmt->bindParam(10, $totalc);
		$stmt->bindParam(11, $tipocompra);
		$stmt->bindParam(12, $formacompra);
		$stmt->bindParam(13, $fechavencecredito);
		$stmt->bindParam(14, $statuscompra);
		$stmt->bindParam(15, $fechacompra);
		$stmt->bindParam(16, $codigo);
		$stmt->bindParam(17, $fecharegistro);

		$codcompra = strip_tags($_POST["codcompra"]);
		$codseriec = strip_tags($_POST["codseriec"]);
		$codproveedor = strip_tags($_POST["codproveedor"]);
		$subtotalivasic = strip_tags($_POST["txtsubtotal"]);
		$subtotalivanoc = strip_tags($_POST["txtsubtotal2"]);
		$ivac = strip_tags($_POST["iva"]);
		$totalivac = strip_tags($_POST["txtIva"]);
		$descuentoc = strip_tags($_POST["descuento"]);
		$totaldescuentoc = strip_tags($_POST["txtDescuento"]);
		$totalc = strip_tags($_POST["txtTotal"]);
		$tipocompra = strip_tags($_POST["tipocompra"]);
		if (strip_tags($_POST["tipocompra"]=="CONTADO")) { $formacompra = strip_tags($_POST["formacompra"]); } else { $formacompra = "CREDITO"; }
		if (strip_tags($_POST["tipocompra"]=="CREDITO")) { $fechavencecredito = strip_tags(date("Y-m-d",strtotime($_POST['fechavencecredito']))); } else { $fechavencecredito = "0000-00-00"; }
		if (strip_tags($_POST["tipocompra"]=="CONTADO")) { $statuscompra = strip_tags("PAGADA"); } else { $statuscompra = "PENDIENTE"; }
		$fechacompra = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION["codigo"]);
		$fecharegistro = strip_tags(date("Y-m-d"));
		$stmt->execute();

		$compra = $_SESSION["CarritoC"];
		for($i=0;$i<count($compra);$i++){

			$query = " insert into detallecompras values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codcompra);
			$stmt->bindParam(2, $codproducto);
			$stmt->bindParam(3, $producto);
			$stmt->bindParam(4, $codcategoria);
			$stmt->bindParam(5, $cantidad);
			$stmt->bindParam(6, $precio);
			$stmt->bindParam(7, $precio2);
			$stmt->bindParam(8, $ivaproductoc);
			$stmt->bindParam(9, $importe);
			$stmt->bindParam(10, $tipoentrada);
			$stmt->bindParam(11, $fechadetallecompra);
			$stmt->bindParam(12, $codigo);

			$codcompra = strip_tags($_POST['codcompra']);
			$codproducto = strip_tags($compra[$i]['txtCodigo']);
			$producto = strip_tags($compra[$i]['producto']);
			$codcategoria = strip_tags($compra[$i]['presentacion']);
			$cantidad = strip_tags($compra[$i]['cantidad']);
			$precio = strip_tags($compra[$i]['precio']);
			$precio2 = strip_tags($compra[$i]['precio2']);
			$ivaproductoc = strip_tags($compra[$i]['ivaproducto']);
			$importe = strip_tags($compra[$i]['cantidad'] * $compra[$i]['precio']);
			$tipoentrada = strip_tags($compra[$i]['tipoentrada']);
			$fechadetallecompra = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
			$codigo = strip_tags($_SESSION['codigo']);
			$stmt->execute();


	################ REALIZAMOS EL PROCESO DE REGISTRO DE INGREDIENTES ###################
			if($compra[$i]['tipoentrada']=="INGREDIENTE"){

				$sql = " select codingrediente from ingredientes where codingrediente = ? ";
				$stmt = $this->dbh->prepare($sql);
				$stmt->execute( array($compra[$i]['txtCodigo']) );
				$num = $stmt->rowCount();
				if($num == 0)
				{
	##################### REGISTRAMOS LOS NUEVOS INGREDIENTES COMPRADOS ##################
					$query = " insert into ingredientes values (null, ?, ?, ?, ?, ?, ?, ?); ";
					$stmt = $this->dbh->prepare($query);
					$stmt->bindParam(1, $codingrediente);
					$stmt->bindParam(2, $nomingrediente);
					$stmt->bindParam(3, $cantingrediente);
					$stmt->bindParam(4, $costoingrediente);
					$stmt->bindParam(5, $codcategoria);
					$stmt->bindParam(6, $codproveedor);
					$stmt->bindParam(7, $stockminimoingrediente);

					$codingrediente = strip_tags($compra[$i]['txtCodigo']);
					$nomingrediente = strip_tags($compra[$i]['producto']);
					$cantingrediente = strip_tags($compra[$i]['cantidad']);
					$costoingrediente = strip_tags($compra[$i]['precio']);
					$codcategoria = strip_tags($compra[$i]['presentacion']);
		            $codproveedor = strip_tags($_POST["codproveedor"]);
					$stockminimoingrediente = strip_tags('0');
					$stmt->execute();
	##################### REGISTRAMOS LOS NUEVOS INGREDIENTES COMPRADOS ###################

	##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ####################
					$query = " insert into kardexingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
					$stmt = $this->dbh->prepare($query);
					$stmt->bindParam(1, $codcompra);
					$stmt->bindParam(2, $codproveedor);
					$stmt->bindParam(3, $codigoproducto);
					$stmt->bindParam(4, $codingrediente);
					$stmt->bindParam(5, $movimientoing);
					$stmt->bindParam(6, $entradasing);
					$stmt->bindParam(7, $salidasing);
					$stmt->bindParam(8, $stockactualing);
					$stmt->bindParam(9, $preciouniting);
					$stmt->bindParam(10, $costototaling);
					$stmt->bindParam(11, $documentoing);
					$stmt->bindParam(12, $fechakardexing);

					$codcompra = strip_tags($_POST['codcompra']);
					$codproveedor = strip_tags($_POST["codproveedor"]);
					$codigoproducto = strip_tags('0');
					$codingrediente = strip_tags($compra[$i]['txtCodigo']);
					$movimientoing = strip_tags("ENTRADAS");
					$entradasing = rount($compra[$i]['cantidad'],2);
					$salidasing = strip_tags("0");
					$stockactualing = strip_tags($compra[$i]['cantidad']);
					$preciouniting = strip_tags($compra[$i]['precio']);
					$costototaling = strip_tags($compra[$i]['precio'] * $compra[$i]['cantidad']);
					$documentoing = strip_tags("COMPRA - ".$_POST["tipocompra"]." - FACTURA: ".$_POST['codcompra']);
					$fechakardexing = strip_tags(date("Y-m-d",strtotime($_POST['fecharegistro'])));
					$stmt->execute();
	##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ###################

				} else {

					//$sql = " select * from ingredientes WHERE CAST(cantingrediente AS DECIMAL(10,5)) <= CAST(stockminimoingrediente AS DECIMAL(10,5))";

					$sql = "select cantingrediente from ingredientes where codingrediente = '".$compra[$i]['txtCodigo']."'";
					foreach ($this->dbh->query($sql) as $row)
					{
						$this->p[] = $row;
					}
					$cantidanterior = $row['cantingrediente'];

	################## ACTUALIZAMOS LA EXISTENCIA DE INGREDIENTES COMPRADOS ###################
					$sql = " update ingredientes set "
					." costoingrediente = ?, "
					." cantingrediente = ? "
					." where "
					." codingrediente = ?;
					";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindParam(1, $costoingrediente);
					$stmt->bindParam(2, $existencia);
					$stmt->bindParam(3, $codigo);

					$costoingrediente = strip_tags($compra[$i]['precio']);
					$cantidad = strip_tags($compra[$i]['cantidad']);
					$existencia= rount($cantidad + $cantidanterior,2);
					$codigo = strip_tags($compra[$i]['txtCodigo']);
					$stmt->execute();
	##################### ACTUALIZAMOS LA EXISTENCIA DE INGREDIENTES COMPRADOS ##################	


	##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ####################
					$query = " insert into kardexingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
					$stmt = $this->dbh->prepare($query);
					$stmt->bindParam(1, $codcompra);
					$stmt->bindParam(2, $codproveedor);
					$stmt->bindParam(3, $codigoproducto);
					$stmt->bindParam(4, $codingrediente);
					$stmt->bindParam(5, $movimientoing);
					$stmt->bindParam(6, $entradasing);
					$stmt->bindParam(7, $salidasing);
					$stmt->bindParam(8, $stockactualing);
					$stmt->bindParam(9, $preciouniting);
					$stmt->bindParam(10, $costototaling);
					$stmt->bindParam(11, $documentoing);
					$stmt->bindParam(12, $fechakardexing);

					$codcompra = strip_tags($_POST['codcompra']);
					$codproveedor = strip_tags($_POST["codproveedor"]);
					$codigoproducto = strip_tags('0');
					$codingrediente = strip_tags($compra[$i]['txtCodigo']);
					$movimientoing = strip_tags("ENTRADAS");
					$entradasing = strip_tags($compra[$i]['cantidad']);
					$salidasing = strip_tags("0");
					$stockactualing = strip_tags($cantidanterior+$compra[$i]['cantidad']);
					$preciouniting = strip_tags($compra[$i]['precio']);
					$costototaling = strip_tags($compra[$i]['precio'] * $compra[$i]['cantidad']);
					$documentoing = strip_tags("COMPRA - ".$_POST["tipocompra"]." - FACTURA: ".$_POST['codcompra']);
					$fechakardexing = strip_tags(date("Y-m-d",strtotime($_POST['fecharegistro'])));
					$stmt->execute();
	################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX #################		
				}

	################ REALIZAMOS EL PROCESO DE REGISTRO DE PRODUCTOS ###################
			} else {

				$sql = " select codproducto from productos where codproducto = ? ";
				$stmt = $this->dbh->prepare($sql);
				$stmt->execute( array($compra[$i]['txtCodigo']) );
				$num = $stmt->rowCount();
				if($num == 0)
				{
	##################### REGISTRAMOS LOS NUEVOS PRODUCTOS COMPRADOS ####################
					$query = " insert into productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
					$stmt = $this->dbh->prepare($query);
					$stmt->bindParam(1, $codproducto);
					$stmt->bindParam(2, $producto);
					$stmt->bindParam(3, $codcategoria);
					$stmt->bindParam(4, $preciocompra);
					$stmt->bindParam(5, $precioventa);
					$stmt->bindParam(6, $existencia);
					$stmt->bindParam(7, $stockminimo);
					$stmt->bindParam(8, $ivaproducto);
					$stmt->bindParam(9, $descproducto);
					$stmt->bindParam(10, $codproveedor);
					$stmt->bindParam(11, $codigobarra);
					$stmt->bindParam(12, $favorito);
					$stmt->bindParam(13, $statusproducto);

					$codproducto = strip_tags($compra[$i]['txtCodigo']);
					$producto = strip_tags($compra[$i]['producto']);
					$codcategoria = strip_tags($compra[$i]['presentacion']);
					$existencia = strip_tags($compra[$i]['cantidad']);
					$preciocompra = strip_tags($compra[$i]['precio']);
					$precioventa = strip_tags($compra[$i]['precio2']);
					$stockminimo = strip_tags('0');
					$ivaproducto = strip_tags($compra[$i]['ivaproducto']);
					$descproducto = strip_tags('0.00');
					$codproveedor = strip_tags($_POST["codproveedor"]);
					$codigobarra = strip_tags("00000000000");
					$favorito = strip_tags('NO');
					$statusproducto = strip_tags('ACTIVO');
					$stmt->execute();
	##################### REGISTRAMOS LOS NUEVOS PRODUCTOS COMPRADOS ####################

	##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################
					$query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
					$stmt = $this->dbh->prepare($query);
					$stmt->bindParam(1, $codcompra);
					$stmt->bindParam(2, $codproveedor);
					$stmt->bindParam(3, $codproducto);
					$stmt->bindParam(4, $movimiento);
					$stmt->bindParam(5, $entradas);
					$stmt->bindParam(6, $salidas);
		            $stmt->bindParam(7, $devolucion);
					$stmt->bindParam(8, $stockactual);
					$stmt->bindParam(9, $preciom);
					$stmt->bindParam(10, $costototal);
					$stmt->bindParam(11, $documento);
					$stmt->bindParam(12, $fechakardex);

					$codcompra = strip_tags($_POST['codcompra']);
					$codproveedor = strip_tags($_POST["codproveedor"]);
					$codproducto = strip_tags($compra[$i]['txtCodigo']);
					$movimiento = strip_tags("ENTRADAS");
					$entradas = strip_tags($compra[$i]['cantidad']);
					$salidas = strip_tags("0");
					$devolucion = strip_tags("0");
					$stockactual = strip_tags($compra[$i]['cantidad']);
					$preciom = strip_tags($compra[$i]['precio']);
					$costototal = strip_tags($compra[$i]['precio'] * $compra[$i]['cantidad']);
					$documento = strip_tags("COMPRA - ".$_POST["tipocompra"]." - FACTURA: ".$_POST['codcompra']);
					$fechakardex = strip_tags(date("Y-m-d",strtotime($_POST['fecharegistro'])));
					$stmt->execute();
	##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################

				} else {

					$sql = "select existencia from productos where codproducto = '".$compra[$i]['txtCodigo']."'";
					foreach ($this->dbh->query($sql) as $row)
					{
						$this->p[] = $row;
					}
					$cantidanterior = $row['existencia'];

	##################### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS ####################
					$sql = " update productos set "
					." preciocompra = ?, "
					." precioventa = ?, "
					." existencia = ?, "
					." ivaproducto = ? "
					." where "
					." codproducto = ?;
					";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindParam(1, $preciocompra);
					$stmt->bindParam(2, $precioventa);
					$stmt->bindParam(3, $existencia);
					$stmt->bindParam(4, $ivaproducto);
					$stmt->bindParam(5, $codigo);

					$preciocompra = strip_tags($compra[$i]['precio']);
					$precioventa = strip_tags($compra[$i]['precio2']);
					$cantidad = strip_tags($compra[$i]['cantidad']);
					$existencia = $cantidad + $cantidanterior;
					$ivaproducto = strip_tags($compra[$i]['ivaproducto']);
					$codigo = strip_tags($compra[$i]['txtCodigo']);
					$stmt->execute();
	##################### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS #####################		

	##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################
					$query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
					$stmt = $this->dbh->prepare($query);
					$stmt->bindParam(1, $codcompra);
					$stmt->bindParam(2, $codproveedor);
					$stmt->bindParam(3, $codproducto);
					$stmt->bindParam(4, $movimiento);
					$stmt->bindParam(5, $entradas);
					$stmt->bindParam(6, $salidas);
		            $stmt->bindParam(7, $devolucion);
					$stmt->bindParam(8, $stockactual);
					$stmt->bindParam(9, $preciounit);
					$stmt->bindParam(10, $costototal);
					$stmt->bindParam(11, $documento);
					$stmt->bindParam(12, $fechakardex);

					$codcompra = strip_tags($_POST['codcompra']);
					$codproveedor = strip_tags($_POST["codproveedor"]);
					$codproducto = strip_tags($compra[$i]['txtCodigo']);
					$movimiento = strip_tags("ENTRADAS");
					$entradas = strip_tags($compra[$i]['cantidad']);
					$salidas = strip_tags("0");
		            $devolucion = strip_tags("0");
					$stockactual = strip_tags($cantidanterior+$compra[$i]['cantidad']);
					$preciounit = strip_tags($compra[$i]['precio']);
					$costototal = strip_tags($compra[$i]['precio'] * $compra[$i]['cantidad']);
					$documento = strip_tags("COMPRA - ".$_POST["tipocompra"]." - FACTURA: ".$_POST['codcompra']);
					$fechakardex = strip_tags(date("Y-m-d",strtotime($_POST['fecharegistro'])));
					$stmt->execute();
	##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################		
				}	
			}
		}
	###### AQUI DESTRUIMOS TODAS LAS VARIABLES DE SESSION QUE RECIBIMOS EN CARRITO DE COMPRA ######
		unset($_SESSION["CarritoC"]); ?>
		
		<script type="text/javascript">
		    toastr.options = {
		      "closeButton":true,
		      "progressBar": true
		    };
		    toastr.success("Compra registrada con exito","Datos registrados");
  		</script>

		<?php 

		echo "<div class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<a href='reportepdf?codcompra=".base64_encode($codcompra)."&tipo=".base64_encode("FACTURACOMPRAS")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black'><strong>IMPRIMIR FACTURA DE COMPRA</strong></a>";
		echo "</div>";
		exit;
	    }
	}
}
############################## FUNCION PARA REGISTRAR COMPRAS ################################

############################## FUNCION PARA LISTAR COMPRAS ################################
public function ListarCompras()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administrador") {

		$sql = " SELECT compras.codcompra, compras.subtotalivasic, compras.subtotalivanoc, compras.ivac, compras.totalivac, compras.descuentoc, compras.totaldescuentoc, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fechacompra, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN usuarios ON compras.codigo = usuarios.codigo LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra GROUP BY compras.codcompra";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
	else {

		$sql = " SELECT compras.codcompra, compras.subtotalivasic, compras.subtotalivanoc, compras.ivac, compras.totalivac, compras.descuentoc, compras.totaldescuentoc, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fechacompra, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN usuarios ON compras.codigo = usuarios.codigo LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.codigo = ".$_SESSION["codigo"]." GROUP BY compras.codcompra";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################## FUNCION PARA LISTAR COMPRAS ################################

############################## FUNCION PARA PAGAR COMPRAS ################################
public function PagarCompras()
{
	if($_SESSION['acceso'] == "administrador") {

		self::SetNames();
		$sql = " update compras set "
		." fechavencecredito = '0000-00-00', "
		." statuscompra = ? "
		." where "
		." codcompra = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $statuscompra);
		$stmt->bindParam(2, $codcompra);
		$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
		$statuscompra = strip_tags("PAGADA");
		$stmt->execute();

		header("Location: compras?mesage=1");
		exit;

	}else {

		header("Location: compras?mesage=2");
		exit;
	}

}
############################## FUNCION PARA PAGAR COMPRAS ################################

############################## FUNCION PARA LISTAR DETALLE COMPRAS ################################
public function ListarDetallesCompras()
{
	self::SetNames();

	if($_SESSION['acceso'] == "administrador") {

		$sql = " SELECT * FROM detallecompras LEFT JOIN categorias ON detallecompras.categoria = categorias.codcategoria";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
	else {

		$sql = " SELECT * FROM detallecompras LEFT JOIN categorias ON detallecompras.categoria = categorias.codcategoria WHERE detallecompras.codigo = ".$_SESSION["codigo"]."";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################## FUNCION PARA LISTAR DETALLES COMPRAS ################################


############################## FUNCION ID COMPRAS ################################
public function ComprasPorId()
{
	self::SetNames();
	$sql = " SELECT * FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN usuarios ON compras.codigo = usuarios.codigo LEFT JOIN mediospagos ON compras.formacompra = mediospagos.codmediopago WHERE compras.codcompra = ?";	
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codcompra"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################## FUNCION ID COMPRAS ################################

############################## FUNCION PARA VER DETALLES COMPRAS ################################
	public function VerDetallesCompras()
	{
		self::SetNames();
		$sql = " SELECT * FROM detallecompras LEFT JOIN categorias ON detallecompras.categoria = categorias.codcategoria WHERE detallecompras.codcompra = ?";	
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(base64_decode($_GET["codcompra"])));
		$stmt->execute();
		$num = $stmt->rowCount();

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
############################## FUNCION PARA VER DETALLES COMPRAS ################################

############################## FUNCION ID DETALLE COMPRAS ################################
		public function DetallesComprasPorId()
		{
			if(base64_decode($_GET['tipoentrada'])=="PRODUCTO"){

				self::SetNames();
				$sql = " SELECT * FROM detallecompras LEFT JOIN categorias ON detallecompras.categoria = categorias.codcategoria LEFT JOIN productos ON detallecompras.codproducto = productos.codproducto WHERE detallecompras.coddetallecompra = ?";
				$stmt = $this->dbh->prepare($sql);
				$stmt->execute( array(base64_decode($_GET["coddetallecompra"])) );
				$num = $stmt->rowCount();
				if($num==0)
				{
					echo "";
				}
				else
				{
					if($row = $stmt->fetch(PDO::FETCH_ASSOC))
						{
							$this->p[] = $row;
						}
						return $this->p;
						$this->dbh=null;
					}
				} else {

					$sql = " SELECT * FROM detallecompras LEFT JOIN ingredientes ON detallecompras.codproducto = ingredientes.codingrediente WHERE detallecompras.coddetallecompra = ?";
					$stmt = $this->dbh->prepare($sql);
					$stmt->execute( array(base64_decode($_GET["coddetallecompra"])) );
					$num = $stmt->rowCount();
					if($num==0)
					{
						echo "";
					}
					else
					{
						if($row = $stmt->fetch(PDO::FETCH_ASSOC))
							{
								$this->p[] = $row;
							}
							return $this->p;
							$this->dbh=null;
						}

					}
				}
############################## FUNCION ID DETALLE COMPRAS ################################


############################## FUNCION PARA ACTUALIZAR COMPRAS ################################
public function ActualizarDetallesCompras()
{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["cantcompra"]))
	{
		echo "1";
		exit;
	}

	$sql6 = " select codcompra from compras order by idcompra desc limit 1";
	foreach ($this->dbh->query($sql6) as $row6){
		$codc["codcompra"]=$row6["codcompra"];
	}

	if($codc["codcompra"] != $_POST["codcompra"])
	{ 
		echo "2";
		exit;
	}

	$sql2 = " SELECT * from detallecompras where coddetallecompra = ? and codcompra = ? ";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->execute( array($_POST["coddetallecompra"], $_POST["codcompra"]) );
	$num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$pa[] = $row;
		}
		$cantidadcompradb = $pa[0]["cantcompra"];

		$sql = " update detallecompras set "
		." codcompra = ?, "
		." codproducto = ?, "
		." producto = ?, "
		." categoria = ?, "
		." cantcompra = ?, "
		." precio1 = ?, "
		." ivaproductoc = ?, "
		." precio2 = ?, "
		." importecompra = ? "
		." where "
		." coddetallecompra = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $producto);
		$stmt->bindParam(4, $codcategoria);
		$stmt->bindParam(5, $cantcompra);
		$stmt->bindParam(6, $precio1);
		$stmt->bindParam(7, $ivaproductoc);
		$stmt->bindParam(8, $precio2);
		$stmt->bindParam(9, $importecompra);
		$stmt->bindParam(10, $coddetallecompra);

		$codcompra = strip_tags($_POST["codcompra"]);
		$codproducto = strip_tags($_POST["codproducto"]);
		$producto = strip_tags($_POST["producto"]);
		$codcategoria = strip_tags($_POST["codcategoria"]);
		$cantcompra = strip_tags($_POST["cantcompra"]);
		$precio1 = strip_tags($_POST["precio1"]);
		$ivaproductoc = strip_tags($_POST["ivaproductoc"]);
		$precio2 = strip_tags($_POST["precio2"]);
		$importecompra = strip_tags($_POST["importecompra"]);
		$coddetallecompra = strip_tags($_POST["coddetallecompra"]);
		$stmt->execute();

################ VERIFICAMOS SI EL TIPO DE ENTRADA ES UN INGREDINTE ###################
		if($_POST['tipoentrada']=="INGREDIENTE"){

################### ACTUALIZAMOS LOS DATOS DEL INGREDIENTE EN ALMACEN ##################
			$sql2 = " update ingredientes set "
			." nomingrediente = ?, "
			." unidadingrediente = ?, "
			." cantingrediente = ?, "
			." costoingrediente = ? "
			." where "
			." codingrediente = ?;
			";
			$stmt = $this->dbh->prepare($sql2);
			$stmt->bindParam(1, $nomingrediente);
			$stmt->bindParam(2, $unidadingrediente);
			$stmt->bindParam(3, $existencia);
			$stmt->bindParam(4, $costoingrediente);
			$stmt->bindParam(5, $codingrediente);

			$nomingrediente = strip_tags($_POST["producto"]);
			$unidadingrediente = strip_tags($_POST["codcategoria"]);
			$costoingrediente = strip_tags(rount($_POST["precio1"],2));
			$codingrediente = strip_tags($_POST["codproducto"]);
			$cantidad = strip_tags(rount($_POST["cantcompra"],2));
			$existenciadb = strip_tags($_POST["existencia"]);
			$calculoproducto=rount($cantidad - $cantidadcompradb,2);
			$existencia = rount($existenciadb + $calculoproducto,2);
			$stmt->execute();

###################### ACTUALIZAMOS LOS DATOS DEL INGREDIENTE EN KARDEX ############################		
			$sql2 = " update kardexingredientes set "
			." entradasing = ?, "
			." stockactualing = ?, "
			." preciouniting = ?, "
			." costototaling = ? "
			." where "
			." codprocesoing = ? and codingrediente = ?;
			";
			$stmt = $this->dbh->prepare($sql2);
			$stmt->bindParam(1, $entradasing);
			$stmt->bindParam(2, $stockactualing);
			$stmt->bindParam(3, $preciouniting);
			$stmt->bindParam(4, $costototaling);
			$stmt->bindParam(5, $codcompra);
			$stmt->bindParam(6, $codproducto);

			$entradasing = strip_tags($_POST["cantcompra"]);
			$preciouniting = strip_tags($_POST["precio1"]);
			$codcompra = strip_tags($_POST["codcompra"]);
			$codproducto = strip_tags($_POST["codproducto"]);
			$costototaling = strip_tags($_POST["cantcompra"] * $_POST["precio1"]);
			$calculoproducto=rount($cantidad - $cantidadcompradb,2);
			$stockactualing = rount($existenciadb + $calculoproducto,2);
			$stmt->execute();

################ VERIFICAMOS SI EL TIPO DE ENTRADA ES UN PRODUCTO ###################
		} else {

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
			$sql2 = " update productos set "
			." producto = ?, "
			." codcategoria = ?, "
			." existencia = ?, "
			." precioventa = ?, "
			." ivaproducto = ? "
			." where "
			." codproducto = ?;
			";
			$stmt = $this->dbh->prepare($sql2);
			$stmt->bindParam(1, $producto);
			$stmt->bindParam(2, $codcategoria);
			$stmt->bindParam(3, $existencia);
			$stmt->bindParam(4, $precioventa);
			$stmt->bindParam(5, $ivaproducto);
			$stmt->bindParam(6, $codproducto);

			$producto = strip_tags($_POST["producto"]);
			$codcategoria = strip_tags($_POST["codcategoria"]);
			$precioventa = strip_tags($_POST["precio2"]);
			$codproducto = strip_tags($_POST["codproducto"]);
			$cantidad = strip_tags($_POST["cantcompra"]);
			$existenciadb = strip_tags($_POST["existencia"]);
			$ivaproducto = strip_tags($_POST["ivaproducto"]);
			$calculoproducto=$cantidad - $cantidadcompradb;
			$existencia = $existenciadb + $calculoproducto;
			$stmt->execute();


###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ############################		
			$sql2 = " update kardexproductos set "
			." entradas = ?, "
			." stockactual = ?, "
			." preciounit = ?, "
			." costototal = ? "
			." where "
			." codproceso = ? and codproducto = ?;
			";
			$stmt = $this->dbh->prepare($sql2);
			$stmt->bindParam(1, $entradas);
			$stmt->bindParam(2, $stockactual);
			$stmt->bindParam(3, $preciounit);
			$stmt->bindParam(4, $costototal);
			$stmt->bindParam(5, $codcompra);
			$stmt->bindParam(6, $codproducto);

			$entradas = strip_tags($_POST["cantcompra"]);
			$preciounit = strip_tags($_POST["precio1"]);
			$codcompra = strip_tags($_POST["codcompra"]);
			$codproducto = strip_tags($_POST["codproducto"]);
			$costototal = strip_tags($_POST["cantcompra"] * $_POST["precio1"]);
			$calculoproducto=$cantidad - $cantidadcompradb;
			$stockactual = $existenciadb + $calculoproducto;
			$stmt->execute();

		}

###################### REALIZAMOS EL CALCULO DE FACTURA EN COMPRA ############################
		$sql4 = "select * from compras where codcompra = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array($_POST["codcompra"]) );
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$paea[] = $row;
			}
			$subtotalivasic = $paea[0]["subtotalivasic"];
			$subtotalivanoc = $paea[0]["subtotalivanoc"];
			$iva = $paea[0]["ivac"]/100;
			$descuento = $paea[0]["descuentoc"]/100;
			$totalivac = $paea[0]["totalivac"];
			$totaldescuentoc = $paea[0]["totaldescuentoc"];

###################### VERIFICAMOS LOS PRODUCTOS QUE TIENEN IVA ############################
			if($_POST["ivaproductoc"]=="SI"){	

				$sql3 = "select sum(importecompra) as importe from detallecompras where codcompra = ? and ivaproductoc = 'SI'";
				$stmt = $this->dbh->prepare($sql3);
				$stmt->execute( array($_POST["codcompra"]));
				$num = $stmt->rowCount();

				if($row = $stmt->fetch())
				{
					$pae[] = $row;
				}
				$importe = $pae[0]["importe"];

				$sql = " update compras set "
				." subtotalivasic = ?, "
				." totalivac = ?, "
				." totaldescuentoc = ?, "
				." totalc= ? "
				." where "
				." codcompra = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $subtotal);
				$stmt->bindParam(2, $totaliva);
				$stmt->bindParam(3, $totaldescuentoc);
				$stmt->bindParam(4, $total);
				$stmt->bindParam(5, $codcompra);

				$subtotal= rount($importe,2);
				$totaliva= rount($subtotal*$iva,2);
				$tot= rount($subtotal+$subtotalivanoc+$totaliva,2);
				$totaldescuentoc= rount($tot*$descuento,2);
				$total= rount($tot-$totaldescuentoc,2);
				$codcompra = strip_tags($_POST["codcompra"]);
				$stmt->execute();

###################### VERIFICAMOS LOS PRODUCTOS QUE NO TIENEN IVA ############################
			} else {

				$sql3 = "select sum(importecompra) as importe from detallecompras where codcompra = ? and ivaproductoc = 'NO'";
				$stmt = $this->dbh->prepare($sql3);
				$stmt->execute( array($_POST["codcompra"]));
				$num = $stmt->rowCount();

				if($row = $stmt->fetch(PDO::FETCH_ASSOC))
					{
						$pae[] = $row;
					}
					$importe = $pae[0]["importe"];

					$sql = " update compras set "
					." subtotalivanoc = ?, "
					." totaldescuentoc = ?, "
					." totalc= ? "
					." where "
					." codcompra = ?;
					";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindParam(1, $subtotal);
					$stmt->bindParam(2, $totaldescuentoc);
					$stmt->bindParam(3, $total);
					$stmt->bindParam(4, $codcompra);

					$subtotal= rount($importe,2);
					$tot= rount($subtotal+$subtotalivasic+$totalivac,2);
					$totaldescuentoc= rount($tot*$descuento,2);
					$total= rount($tot-$totaldescuentoc,2);
					$codcompra = strip_tags($_POST["codcompra"]);
					$stmt->execute();		

				} ?>

				<script type="text/javascript">
				    toastr.options = {
				      "closeButton":true,
				      "progressBar": true
				    };
				    toastr.success("Compra ".$_POST["tipoentrada"]." actualizada con exito","Datos actualizados");
		  		</script>
			<?php }
############################## FUNCION PARA ACTUALIZAR COMPRAS ################################

############################## FUNCION PARA ELIMINAR DETALLE COMPRAS #############################
public function EliminarDetallesCompras()
{
	if($_SESSION['acceso'] == "administrador") {

		$sql = " select codcompra from compras order by codcompra desc limit 1";
		foreach ($this->dbh->query($sql) as $row){
			$codcompra["codcompra"]=$row["codcompra"];
		}

		if($codcompra["codcompra"] != base64_decode($_GET["codcompra"]))
		{
			header("Location: detallescompras?mesage=1");
			exit;
		}

		self::SetNames();
		$sql = " select * from detallecompras where codcompra = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codcompra"])) );
		$num = $stmt->rowCount();
		if($num > 1)
		{

			$sql = " delete from detallecompras where coddetallecompra = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$coddetallecompra);
			$coddetallecompra = base64_decode($_GET["coddetallecompra"]);
			$stmt->execute();

################ VERIFICAMOS SI EL TIPO DE ENTRADA ES UN INGREDINTE ###################
			if($_POST['tipoentrada']=="INGREDIENTE"){

				$sql2 = "select cantingrediente from ingredientes where cantingrediente = ?";
				$stmt = $this->dbh->prepare($sql2);
				$stmt->execute( array(base64_decode($_GET["codproducto"])));
				$num = $stmt->rowCount();

				if($row = $stmt->fetch(PDO::FETCH_ASSOC))
					{
						$p[] = $row;
					}
					$existenciadb = $p[0]["cantingrediente"];

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
					$sql = " update ingredientes set "
					." cantingrediente = ? "
					." where "
					." codingrediente = ?;
					";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindParam(1, $existencia);
					$stmt->bindParam(2, $codproducto);
					$cantcompra = strip_tags(base64_decode($_GET["cantcompra"]));
					$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
					$existencia = $existenciadb - $cantcompra;
					$stmt->execute();

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
					$sql = " delete from kardexingredientes where codprocesoing = ? and codingrediente = ?";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindParam(1,$codcompra);
					$stmt->bindParam(2,$codproducto);
					$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
					$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
					$stmt->execute();

################ VERIFICAMOS SI EL TIPO DE ENTRADA ES UN PRODUCTO ###################
				} else {

					$sql2 = "select existencia from productos where codproducto = ?";
					$stmt = $this->dbh->prepare($sql2);
					$stmt->execute( array(base64_decode($_GET["codproducto"])));
					$num = $stmt->rowCount();

					if($row = $stmt->fetch(PDO::FETCH_ASSOC))
						{
							$p[] = $row;
						}
						$existenciadb = $p[0]["existencia"];

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
						$sql = " update productos set "
						." existencia = ? "
						." where "
						." codproducto = ?;
						";
						$stmt = $this->dbh->prepare($sql);
						$stmt->bindParam(1, $existencia);
						$stmt->bindParam(2, $codproducto);
						$cantcompra = strip_tags(base64_decode($_GET["cantcompra"]));
						$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
						$existencia = $existenciadb - $cantcompra;
						$stmt->execute();

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
						$sql = " delete from kardexproductos where codproceso = ? and codproducto = ?";
						$stmt = $this->dbh->prepare($sql);
						$stmt->bindParam(1,$codcompra);
						$stmt->bindParam(2,$codproducto);
						$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
						$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
						$stmt->execute();

					}

					$sql4 = "select * from compras where codcompra = ? ";
					$stmt = $this->dbh->prepare($sql4);
					$stmt->execute( array(base64_decode($_GET["codcompra"])));
					$num = $stmt->rowCount();

					if($row = $stmt->fetch(PDO::FETCH_ASSOC))
						{
							$paea[] = $row;
						}
						$subtotalivasic = $paea[0]["subtotalivasic"];
						$subtotalivanoc = $paea[0]["subtotalivanoc"];
						$iva = $paea[0]["ivac"]/100;
						$descuento = $paea[0]["descuentoc"]/100;
						$totalivac = $paea[0]["totalivac"];
						$totaldescuentoc = $paea[0]["totaldescuentoc"];

						if(base64_decode($_GET["ivaproductoc"])=="SI"){	

							$sql3 = "select sum(importecompra) as importe from detallecompras where codcompra = ? and ivaproductoc = 'SI'";
							$stmt = $this->dbh->prepare($sql3);
							$stmt->execute( array(base64_decode($_GET["codcompra"])));
							$num = $stmt->rowCount();

							if($row = $stmt->fetch(PDO::FETCH_ASSOC))
								{
									$pae[] = $row;
								}
								$importe = $pae[0]["importe"];	

								$sql = " update compras set "
								." subtotalivasic = ?, "
								." totalivac = ?, "
								." totaldescuentoc = ?, "
								." totalc= ? "
								." where "
								." codcompra = ?;
								";
								$stmt = $this->dbh->prepare($sql);
								$stmt->bindParam(1, $subtotal);
								$stmt->bindParam(2, $totaliva);
								$stmt->bindParam(3, $totaldescuentoc);
								$stmt->bindParam(4, $total);
								$stmt->bindParam(5, $codcompra);

								$subtotal= rount($importe,2);
								$totaliva= rount($subtotal*$iva,2);
								$tot= rount($subtotal+$subtotalivanoc+$totaliva,2);
								$totaldescuentoc= rount($tot*$descuento,2);
								$total= rount($tot-$totaldescuentoc,2);
								$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
								$stmt->execute();

							} else {

								$sql3 = "select sum(importecompra) as importe from detallecompras where codcompra = ? and ivaproductoc = 'NO'";
								$stmt = $this->dbh->prepare($sql3);
								$stmt->execute( array(base64_decode($_GET["codcompra"])));
								$num = $stmt->rowCount();

								if($row = $stmt->fetch(PDO::FETCH_ASSOC))
									{
										$pae[] = $row;
									}
									$importe = $pae[0]["importe"];

									$sql = " update compras set "
									." subtotalivanoc = ?, "
									." totaldescuentoc = ?, "
									." totalc= ? "
									." where "
									." codcompra = ?;
									";
									$stmt = $this->dbh->prepare($sql);
									$stmt->bindParam(1, $subtotal);
									$stmt->bindParam(2, $totaldescuentoc);
									$stmt->bindParam(3, $total);
									$stmt->bindParam(4, $codcompra);

									$subtotal= rount($importe,2);
									$tot= rount($subtotal+$subtotalivasic+$totalivac,2);
									$totaldescuentoc= rount($tot*$descuento,2);
									$total= rount($tot-$totaldescuentoc,2);
									$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
									$stmt->execute();		
								}					

								header("Location: detallescompras?mesage=2");
								exit;

							}
							else
							{

################ VERIFICAMOS SI EL TIPO DE ENTRADA ES UN INGREDINTE ###################
								if($_POST['tipoentrada']=="INGREDIENTE"){

									$sql2 = "select cantingrediente from ingredientes where cantingrediente = ?";
									$stmt = $this->dbh->prepare($sql2);
									$stmt->execute( array(base64_decode($_GET["codproducto"])));
									$num = $stmt->rowCount();

									if($row = $stmt->fetch(PDO::FETCH_ASSOC))
										{
											$p[] = $row;
										}
										$existenciadb = $p[0]["cantingrediente"];

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
										$sql = " update ingredientes set "
										." cantingrediente = ? "
										." where "
										." codingrediente = ?;
										";
										$stmt = $this->dbh->prepare($sql);
										$stmt->bindParam(1, $existencia);
										$stmt->bindParam(2, $codproducto);
										$cantcompra = strip_tags(base64_decode($_GET["cantcompra"]));
										$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
										$existencia = $existenciadb - $cantcompra;
										$stmt->execute();

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
										$sql = " delete from kardexingredientes where codprocesoing = ? and codingrediente = ?";
										$stmt = $this->dbh->prepare($sql);
										$stmt->bindParam(1,$codcompra);
										$stmt->bindParam(2,$codproducto);
										$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
										$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
										$stmt->execute();

################ VERIFICAMOS SI EL TIPO DE ENTRADA ES UN PRODUCTO ###################
									} else {

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
										$sql2 = "select existencia from productos where codproducto = ?";
										$stmt = $this->dbh->prepare($sql2);
										$stmt->execute( array(base64_decode($_GET["codproducto"])));
										$num = $stmt->rowCount();

										if($row = $stmt->fetch(PDO::FETCH_ASSOC))
											{
												$p[] = $row;
											}
											$existenciadb = $p[0]["existencia"];

											$sql = " update productos set "
											." existencia = ? "
											." where "
											." codproducto = ?;
											";
											$stmt = $this->dbh->prepare($sql);
											$stmt->bindParam(1, $existencia);
											$stmt->bindParam(2, $codproducto);
											$cantcompra = strip_tags(base64_decode($_GET["cantcompra"]));
											$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
											$existencia = $existenciadb - $cantcompra;
											$stmt->execute();

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
											$sql = " delete from kardexproductos where codproceso = ? and codproducto = ?";
											$stmt = $this->dbh->prepare($sql);
											$stmt->bindParam(1,$codcompra);
											$stmt->bindParam(2,$codproducto);
											$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
											$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
											$stmt->execute();

											$sql = " delete from compras where codcompra = ?";
											$stmt = $this->dbh->prepare($sql);
											$stmt->bindParam(1,$codcompra);
											$codcompra = base64_decode($_GET["codcompra"]);
											$stmt->execute();

											$sql = " delete from detallecompras where coddetallecompra = ? ";
											$stmt = $this->dbh->prepare($sql);
											$stmt->bindParam(1,$coddetallecompra);
											$coddetallecompra = base64_decode($_GET["coddetallecompra"]);
											$stmt->execute();

										}

										header("Location: detallescompras?mesage=2");
										exit;
									}
								}
								else
								{
									header("Location: detallescompras?mesage=3");
									exit;
								}
							}
############################## FUNCION PARA ELIMINAR DETALLE COMPRAS ##############################


########################## FUNCION PARA BUSCAR COMPRAS POR PROVEEDORES ###########################
public function BuscarComprasProveedor() 
{
	self::SetNames();		
	$sql = " SELECT compras.codcompra, compras.subtotalivasic, compras.subtotalivanoc, compras.ivac, compras.totalivac, compras.descuentoc, compras.totaldescuentoc, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fechacompra, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN usuarios ON compras.codigo = usuarios.codigo LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE proveedores.codproveedor = ? GROUP BY compras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_GET["codproveedor"]) );
	$num = $stmt->rowCount();
	if($num==0)
	{

		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN COMPRAS DE PRODUCTOS PARA EL PROVEEDOR SELECCIONADO</center>";
		echo "</div>";
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
########################## FUNCION PARA BUSCAR COMPRAS POR PROVEEDORES ###########################


########################## FUNCION PARA BUSCAR COMPRAS POR FECHAS ###########################
	public function BuscarComprasFechas() 
	{
		self::SetNames();
		$sql = " SELECT compras.codcompra, compras.subtotalivasic, compras.subtotalivanoc, compras.ivac, compras.totalivac, compras.descuentoc, compras.totaldescuentoc, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fechacompra, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN usuarios ON compras.codigo = usuarios.codigo LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE DATE_FORMAT(compras.fechacompra,'%Y-%m-%d') >= ? AND DATE_FORMAT(compras.fechacompra,'%Y-%m-%d') <= ? GROUP BY compras.codcompra";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{ ?>

			<script type="text/javascript">
			    toastr.options = {
			      "closeButton":true,
			      "progressBar": true
			    };
			    toastr.success("No existen compras en el rango de fechas","No hay datos");
	  		</script>

		
			<?
			echo "<div class='alert alert-danger'>";
			echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
			echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN COMPRAS DE PRODUCTOS PARA EL RANGO DE FECHA INGRESADO</center>";
			echo "</div>";
			exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$this->p[]=$row;
				}
				return $this->p;
				$this->dbh=null;
			}
		}
########################## FUNCION PARA BUSCAR COMPRAS POR FECHAS ###########################

############################## FIN DE CLASE COMPRAS DE PRODUCTOS ##############################






































################################### CLASE ARQUEO DE CAJA ###################################

########################## FUNCION PARA REGISTRAR ARQUEO DE CAJA #############################
		public function RegistrarArqueoCaja()
		{
			self::SetNames();
			if(empty($_POST["codcaja"]) or empty($_POST["montoinicial"]) or empty($_POST["fecharegistro"]))
			{
				echo "1";
				exit;
			}
			$sql = " select codcaja from arqueocaja where codcaja = ? and statusarqueo = '1'";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute( array($_POST["codcaja"]) );
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " insert into arqueocaja values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $codcaja);
				$stmt->bindParam(2, $montoinicial);
				$stmt->bindParam(3, $ingresos);
				$stmt->bindParam(4, $egresos);
				$stmt->bindParam(5, $dineroefectivo);
				$stmt->bindParam(6, $diferencia);
				$stmt->bindParam(7, $comentarios);
				$stmt->bindParam(8, $fechaapertura);
				$stmt->bindParam(9, $fechacierre);
				$stmt->bindParam(10, $statusarqueo);
				$stmt->bindParam(11, $codigo);

				$codcaja = strip_tags($_POST["codcaja"]);
				$montoinicial = strip_tags($_POST["montoinicial"]);
				if (strip_tags(isset($_POST['ingresos']))) { $ingresos = strip_tags($_POST['ingresos']); } else { $ingresos =''; }
				if (strip_tags(isset($_POST['egresos']))) { $egresos = strip_tags($_POST['egresos']); } else { $egresos =''; }
				if (strip_tags(isset($_POST['dineroefectivo']))) { $dineroefectivo = strip_tags($_POST['dineroefectivo']); } else { $dineroefectivo =''; }
				if (strip_tags(isset($_POST['diferencia']))) { $diferencia = strip_tags($_POST['diferencia']); } else { $diferencia =''; }
				if (strip_tags(isset($_POST['comentarios']))) { $comentarios = strip_tags($_POST['comentarios']); } else { $comentarios =''; }
				$fechaapertura = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
				$fechacierre = strip_tags(date("0000-00-00 00:00:00"));
				$statusarqueo = strip_tags("1");
				$codigo = strip_tags($_SESSION["codigo"]);
				$stmt->execute(); ?>

				<script type="text/javascript">
				    toastr.options = {
				      "closeButton":true,
				      "progressBar": true
				    };
				    toastr.success("Arqueo de caja registroado con exito","Datos registrados");
		  		</script>
			<?php }
			else
			{
				echo "2";
				exit;
			}
		}
########################## FUNCION PARA REGISTRAR ARQUEO DE CAJA #############################

########################## FUNCION PARA LISTAR ARQUEO DE CAJA #############################
		public function ListarArqueoCaja()
		{
			self::SetNames();
			
			if($_SESSION["acceso"] == "cajero") {


            $sql = " select * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja WHERE cajas.codigo = '".$_SESSION["codigo"]."'";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;


			} else {

			$sql = " select * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;

			}
		}
########################## FUNCION PARA LISTAR ARQUEO DE CAJA #############################

########################## FUNCION ID ARQUEO DE CAJA #############################
		public function ArqueoCajaPorId()
		{
			self::SetNames();
			$sql = " select * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo where arqueocaja.codarqueo = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute( array(base64_decode($_GET["codarqueo"])) );
			$num = $stmt->rowCount();
			if($num==0)
			{
				echo "";
			}
			else
			{
				if($row = $stmt->fetch(PDO::FETCH_ASSOC))
					{
						$this->p[] = $row;
					}
					return $this->p;
					$this->dbh=null;
				}
			}
########################## FUNCION ID ARQUEO DE CAJA #############################

########################## FUNCION PARA ACTUALIZAR ARQUEO DE CAJA #############################
			public function ActualizarArqueoCaja()
			{

				self::SetNames();
				if(empty($_POST["codarqueo"]) or empty($_POST["codcaja"]) or empty($_POST["montoinicial"]) or empty($_POST["fechaapertura"]))
				{
					echo "1";
					exit;
				}
				$sql = " select codcaja from arqueocaja where codarqueo != ? and codcaja = ? and statusarqueo = '1' ";
				$stmt = $this->dbh->prepare($sql);
				$stmt->execute( array($_POST["codarqueo"], $_POST["codcaja"]) );
				$num = $stmt->rowCount();
				if($num == 0)
				{
					$sql = " update arqueocaja set "
					." montoinicial = ? "
					." where "
					." codarqueo = ?;
					";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindParam(1, $montoinicial);
					$stmt->bindParam(2, $codarqueo);

					$montoinicial = strip_tags($_POST["montoinicial"]);
					$codarqueo = strip_tags($_POST["codarqueo"]);
					$stmt->execute(); ?>

					<script type="text/javascript">
					    toastr.options = {
					      "closeButton":true,
					      "progressBar": true
					    };
					    toastr.success("Arqueo de caja actualizado con exito","Datos actualizados");
			  		</script>
				<?php }
				else
				{
					echo "2";
					exit;
				}
			}
########################## FUNCION PARA ACTUALIZAR ARQUEO DE CAJA #############################

########################## FUNCION PARA CERRAR ARQUEO DE CAJA #############################
			public function CerrarArqueoCaja()
			{

				self::SetNames();
if(empty($_POST["codarqueo"]) or empty($_POST["codcaja"]) or empty($_POST["montoinicial"]) or empty($_POST["dineroefectivo"]))
				{
					echo "1";
					exit;
				}

				$sql = " select * from ventas WHERE statuspago = '1'";
				$stmt = $this->dbh->prepare($sql);
				$stmt->execute();
				$num = $stmt->rowCount();
				if($num==0)
				{

				$sql = " update arqueocaja set "
				." dineroefectivo = ?, "
				." diferencia = ?, "
				." comentarios = ?, "
				." fechacierre = ?, "
				." statusarqueo = ? "
				." where "
				." codarqueo = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $dineroefectivo);
				$stmt->bindParam(2, $diferencia);
				$stmt->bindParam(3, $comentarios);
				$stmt->bindParam(4, $fechacierre);
				$stmt->bindParam(5, $statusarqueo);
				$stmt->bindParam(6, $codarqueo);

				$dineroefectivo = strip_tags($_POST["dineroefectivo"]);
				$diferencia = strip_tags($_POST["diferencia"]);
				$comentarios = strip_tags($_POST['comentarios']);
				$fechacierre = strip_tags(date("Y-m-d h:i:s"));
				$statusarqueo = strip_tags("0");
				$codarqueo = strip_tags($_POST["codarqueo"]);
				$stmt->execute(); ?>

				<script type="text/javascript">
				    toastr.options = {
				      "closeButton":true,
				      "progressBar": true
				    };
				    toastr.success("Arqueo de caja cerrado con exito","Caja cerrada");
		  		</script>
				<?php }
				else
				{
					echo "2";
					exit;
				}
			}
########################## FUNCION PARA CERRAR ARQUEO DE CAJA #############################

########################## FUNCION PARA ELIMINAR ARQUEO DE CAJA #############################
			public function EliminarArqueoCaja()
			{

				if($_SESSION['acceso'] == "administrador") {

					$sql = " delete from arqueocaja where codarqueo = ? ";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindParam(1,$codarqueo);
					$codarqueo = base64_decode($_GET["codarqueo"]);
					$stmt->execute();

					header("Location: arqueoscajas?mesage=1");
					exit;

				} else {

					header("Location: arqueoscajas?mesage=2");
					exit;
				}

			}
########################## FUNCION PARA ELIMINAR ARQUEO DE CAJA #############################

########################## FUNCION PARA VERIFICAR CAJA ASIGNADA #############################
			public function VerificaArqueosCaja()
			{
				self::SetNames();
				$sql = " select * from arqueocaja where statusarqueo = ? ";
				$stmt = $this->dbh->prepare($sql);
				$stmt->execute( array('1') );
				$num = $stmt->rowCount();
				if($num==0)
				{ ?>

				<script type="text/javascript">
				    toastr.options = {
				      "closeButton":true,
				      "progressBar": true
				    };
				    toastr.success("no existen arqueos para procesar ventas","No hay arqueos");
		  		</script>
				<?php }
				else
				{
					if($row = $stmt->fetch(PDO::FETCH_ASSOC))
						{
							$this->p[] = $row;
						}
						return $this->p;
						$this->dbh=null;
					}
				}
########################## FUNCION PARA VERIFICAR CAJA ASIGNADA #############################

################################# FIN DE CLASE ARQUEO DE CAJA ######################################












































################################## CLASE MOVIMIENTOS DE CAJAS #################################

######################### FUNCION PARA REGISTRAR MOVIMIENTOS DE CAJAS #######################
public function RegistrarMovimientoCajas()
{
self::SetNames();
if(empty($_POST["tipomovimientocaja"]) or empty($_POST["montomovimientocaja"]) or empty($_POST["mediopagomovimientocaja"]) or empty($_POST["codcaja"]))
{
	echo "1";
	exit;
}

$sql = " SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja WHERE arqueocaja.codcaja = ".$_POST["codcaja"]." AND statusarqueo = '1'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "2";
		exit;

	}  
	else if($_POST["montomovimientocaja"]>0)
{
	

#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
	$sql = "select montoinicial, ingresos, egresos from arqueocaja where codcaja = '".$_POST["codcaja"]."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$inicial = $row['montoinicial'];
	$ingreso = $row['ingresos'];
	$egresos = $row['egresos'];
	$total = $inicial+$ingreso-$egresos;

	if($_POST["tipomovimientocaja"]=="INGRESO"){

		$sql = " update arqueocaja set "
		." ingresos = ? "
		." where "
		." codcaja = ? and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $ingresos);
		$stmt->bindParam(2, $codcaja);

		$ingresos = rount($_POST["montomovimientocaja"]+$ingreso,2);
		$codcaja = strip_tags($_POST["codcaja"]);
		$stmt->execute();

		$query = " insert into movimientoscajas values (null, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $tipomovimientocaja);
		$stmt->bindParam(2, $montomovimientocaja);
		$stmt->bindParam(3, $mediopagomovimientocaja);
		$stmt->bindParam(4, $codcaja);
		$stmt->bindParam(5, $descripcionmovimientocaja);
		$stmt->bindParam(6, $fechamovimientocaja);
		$stmt->bindParam(7, $codigo);

		$tipomovimientocaja = strip_tags($_POST["tipomovimientocaja"]);
		$montomovimientocaja = strip_tags($_POST["montomovimientocaja"]);
		$mediopagomovimientocaja = strip_tags($_POST["mediopagomovimientocaja"]);
		$codcaja = strip_tags($_POST["codcaja"]);
		$descripcionmovimientocaja = strip_tags($_POST["descripcionmovimientocaja"]);
		$fechamovimientocaja = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION["codigo"]);
		$stmt->execute();

	} else {

		if($_POST["montomovimientocaja"]>$total){
		
		echo "3";
		exit;

	} else {

		$sql = " update arqueocaja set "
		." egresos = ? "
		." where "
		." codcaja = ? and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $egresos);
		$stmt->bindParam(2, $codcaja);

		$egresos = rount($_POST["montomovimientocaja"]+$egresos,2);
		$codcaja = strip_tags($_POST["codcaja"]);
		$stmt->execute();

		$query = " insert into movimientoscajas values (null, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $tipomovimientocaja);
		$stmt->bindParam(2, $montomovimientocaja);
		$stmt->bindParam(3, $mediopagomovimientocaja);
		$stmt->bindParam(4, $codcaja);
		$stmt->bindParam(5, $descripcionmovimientocaja);
		$stmt->bindParam(6, $fechamovimientocaja);
		$stmt->bindParam(7, $codigo);

		$tipomovimientocaja = strip_tags($_POST["tipomovimientocaja"]);
		$montomovimientocaja = strip_tags($_POST["montomovimientocaja"]);
		$mediopagomovimientocaja = strip_tags($_POST["mediopagomovimientocaja"]);
		$codcaja = strip_tags($_POST["codcaja"]);
		$descripcionmovimientocaja = strip_tags($_POST["descripcionmovimientocaja"]);
		$fechamovimientocaja = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION["codigo"]);
		$stmt->execute();

	      }

	} ?>

	<script type="text/javascript">
    toastr.options = {
      "closeButton":true,
      "progressBar": true
    };
    toastr.success("Movimiento de caja registrado con exito","Datos registrados");
	</script>
                <?php }
           else
                {
	echo "4";
	exit;
    }
}
######################### FUNCION PARA REGISTRAR MOVIMIENTOS DE CAJAS #######################

######################### FUNCION PARA LISTAR MOVIMIENTOS DE CAJAS #######################
public function ListarMovimientoCajas()
{
            self::SetNames();
     
     if($_SESSION["acceso"] == "cajero") {


            $sql = " select * from movimientoscajas WHERE codigo = '".$_SESSION["codigo"]."'";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;


			} else {

			$sql = " select * from movimientoscajas ";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
}
######################### FUNCION PARA LISTAR MOVIMIENTOS DE CAJAS #######################

######################### FUNCION ID MOVIMIENTOS DE CAJAS #######################
public function MovimientoCajasPorId()
{
self::SetNames();
$sql = " SELECT * from movimientoscajas INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja LEFT JOIN mediospagos ON movimientoscajas.mediopagomovimientocaja = mediospagos.codmediopago LEFT JOIN usuarios ON movimientoscajas.codigo = usuarios.codigo WHERE movimientoscajas.codmovimientocaja = ?";
$stmt = $this->dbh->prepare($sql);
$stmt->execute( array(base64_decode($_GET["codmovimientocaja"])) );
$num = $stmt->rowCount();
if($num==0)
{
	echo "";
}
else
{
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION ID MOVIMIENTOS DE CAJAS #######################


######################### FUNCION PARA ACTUALIZAR MOVIMIENTOS DE CAJAS #######################
public function ActualizarMovimientoCajas()
{
	self::SetNames();
if(empty($_POST["tipomovimientocaja"]) or empty($_POST["montomovimientocaja"]) or empty($_POST["mediopagomovimientocaja"]) or empty($_POST["codcaja"]))
	{
		echo "1";
		exit;
	}

	if($_POST["montomovimientocaja"]>0)
	{

	#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
	$sql = "select montoinicial, ingresos, egresos from arqueocaja where codcaja = '".$_POST["codcaja"]."' and statusarqueo = '1'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$inicial = $row['montoinicial'];
	$ingreso = $row['ingresos'];
	$egreso = $row['egresos'];
	$total = $inicial+$ingreso-$egreso;
	$montomovimientocaja = strip_tags($_POST["montomovimientocaja"]);
	$movimientodb = strip_tags($_POST["montomovimientocajadb"]);
	$totalmovimiento = rount($montomovimientocaja-$movimientodb,2);

	if($_POST["tipomovimientocaja"]=="INGRESO"){

	$sql = " update arqueocaja set "
		." ingresos = ? "
		." where "
		." codcaja = ? and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $ingresos);
		$stmt->bindParam(2, $codcaja);

		$ingresos = rount($totalmovimiento+$ingreso,2);
		$codcaja = strip_tags($_POST["codcaja"]);
		$stmt->execute();

	$sql = " update movimientoscajas set "
		." tipomovimientocaja = ?, "
		." montomovimientocaja = ?, "
		." mediopagomovimientocaja = ?, "
		." codcaja = ?, "
		." descripcionmovimientocaja = ? "
		." where "
		." codmovimientocaja = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $tipomovimientocaja);
		$stmt->bindParam(2, $montomovimientocaja);
		$stmt->bindParam(3, $mediopagomovimientocaja);
		$stmt->bindParam(4, $codcaja);
		$stmt->bindParam(5, $descripcionmovimientocaja);
		$stmt->bindParam(6, $codmovimientocaja);

		$tipomovimientocaja = strip_tags($_POST["tipomovimientocaja"]);
		$montomovimientocaja = strip_tags($_POST["montomovimientocaja"]);
		$mediopagomovimientocaja = strip_tags($_POST["mediopagomovimientocaja"]);
		$codcaja = strip_tags($_POST["codcaja"]);
		$descripcionmovimientocaja = strip_tags($_POST["descripcionmovimientocaja"]);
		$codmovimientocaja = strip_tags($_POST["codmovimientocaja"]);
		$stmt->execute();

	} else {

		   if($totalmovimiento>$total){
		
		echo "2";
		exit;

	         } else {

	$sql = " update arqueocaja set "
		." egresos = ? "
		." where "
		." codcaja = ? and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $egresos);
		$stmt->bindParam(2, $codcaja);

		$egresos = rount($totalmovimiento+$egreso,2);
		$codcaja = strip_tags($_POST["codcaja"]);
		$stmt->execute();

	$sql = " update movimientoscajas set "
		." tipomovimientocaja = ?, "
		." montomovimientocaja = ?, "
		." mediopagomovimientocaja = ?, "
		." codcaja = ?, "
		." descripcionmovimientocaja = ? "
		." where "
		." codmovimientocaja = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $tipomovimientocaja);
		$stmt->bindParam(2, $montomovimientocaja);
		$stmt->bindParam(3, $mediopagomovimientocaja);
		$stmt->bindParam(4, $codcaja);
		$stmt->bindParam(5, $descripcionmovimientocaja);
		$stmt->bindParam(6, $codmovimientocaja);

		$tipomovimientocaja = strip_tags($_POST["tipomovimientocaja"]);
		$montomovimientocaja = strip_tags($_POST["montomovimientocaja"]);
		$mediopagomovimientocaja = strip_tags($_POST["mediopagomovimientocaja"]);
		$codcaja = strip_tags($_POST["codcaja"]);
		$descripcionmovimientocaja = strip_tags($_POST["descripcionmovimientocaja"]);
		$codmovimientocaja = strip_tags($_POST["codmovimientocaja"]);
		$stmt->execute();

	        }
	} ?>

	<script type="text/javascript">
    toastr.options = {
      "closeButton":true,
      "progressBar": true
    };
    toastr.success("Movimiento de caja actualizado con exito","Datos actualizados");
	</script>
	<?php }
	else
	{
		echo "2";
		exit;
	}
}
######################### FUNCION PARA ACTUALIZAR MOVIMIENTOS DE CAJAS #######################

######################### FUNCION PARA ELIMINAR MOVIMIENTOS DE CAJAS #######################
public function EliminarMovimientoCajas()
{
	if($_SESSION['acceso'] == "administrador") {

#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
	$sql = "select montoinicial, ingresos, egresos from arqueocaja where codcaja = '".base64_decode($_GET["codcaja"])."' and statusarqueo = '1'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$inicial = $row['montoinicial'];
	$ingreso = $row['ingresos'];
	$egreso = $row['egresos'];

if(base64_decode($_GET["tipomovimientocaja"])=="INGRESO"){

		$sql = " update arqueocaja set "
		." ingresos = ? "
		." where "
		." codcaja = ? and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $ingresos);
		$stmt->bindParam(2, $codcaja);

		$entro = base64_decode($_GET["montomovimientocaja"]);
		$ingresos = rount($ingreso-$entro,2);
		$codcaja = base64_decode($_GET["codcaja"]);
		$stmt->execute();

} else {

		$sql = " update arqueocaja set "
		." egresos = ? "
		." where "
		." codcaja = ? and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $egresos);
		$stmt->bindParam(2, $codcaja);

		$salio = base64_decode($_GET["montomovimientocaja"]);
		$egresos = rount($egreso-$salio,2);
		$codcaja = base64_decode($_GET["codcaja"]);
		$stmt->execute();
       }

		$sql = " delete from movimientoscajas where codmovimientocaja = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codmovimientocaja);
		$codmovimientocaja = base64_decode($_GET["codmovimientocaja"]);
		$stmt->execute();

		header("Location: movimientoscajas?mesage=1");
		exit;

	} else {

		header("Location: movimientoscajas?mesage=2");
		exit;
	} 
}
######################### FUNCION PARA ELIMINAR MOVIMIENTOS DE CAJAS #######################

############################## FIN DE CLASE MOVIMIENTOS DE CAJAS ##############################






































############################### CLASE VENTAS DE PRODUCTOS   ##############################

###################################### FUNCION VERIFICA CAJAS ######################################
	public function VerificaArqueo()
	{
		self::SetNames();
if($_SESSION["acceso"] == "administrador" || $_SESSION["acceso"] == "cajero"){

$sql = " select * from arqueocaja where codigo = '".$_SESSION["codigo"]."' and statusarqueo = '1'";

	} else {

$sql = " select * from arqueocaja WHERE statusarqueo = '1'";

	}
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_SESSION["codigo"]) );
		$num = $stmt->rowCount();
		if($num==0)
		{
		?>
		<script type='text/javascript' language='javascript'>
	    alert('DISCULPE, NO EXISTE ARQUEO DE CAJA PARA VENTA, \nDEBERA DE INICIAR UN ARQUEO PARA PROCESAR VENTAS')  
		document.location.href='forarqueo'	 
        </script> 
		<?php 
			exit;
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FUNCION VERIFICA CAJAS ######################################


############################ FUNCION PARA VERIFICAR MESAS PARA VENTAS #######################
public function VerificaVentas()
{
	self::SetNames();
	
		


$sql = " SELECT clientes.id_cliente, clientes.documento, clientes.nombre_cliente, clientes.telefono_cliente, clientes.direccion_cliente, clientes.email_cliente, facturas.id_factura, facturas.id_cliente as cliente, facturas.total_venta, facturas.id_vendedor, detalle_factura.id_detalle, detalle_factura.id_producto, detalle_factura.cantidad, detalle_factura.precio_venta, mesas.id_mesa, mesas.nombre_mesa, users.nombres FROM mesas INNER JOIN facturas ON mesas.id_mesa = facturas.id_mesa INNER JOIN detalle_factura ON detalle_factura.numero_factura = facturas.id_factura LEFT JOIN clientes ON facturas.id_cliente = clientes.id_cliente LEFT JOIN users ON facturas.id_vendedor = users.user_id WHERE mesas.id_mesa = ? and mesas.status_mesa = '0'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["id_mesa"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			?>
<br>
<div class="col-sm-8">
            <h3 class="panel-title"><i class="fa fa-cutlery"></i> Detalles de Productos</h3>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="box-body">

				


<div class="row"> 
				<div class="col-md-12"> 
<label class="control-label">B&uacute;squeda de Productos:<span class="symbol required"></span></label>
<input class="form-control" type="text" name="busquedaproducto" id="busquedaproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la B&uacute;squeda de Producto">
				</div>
			</div>


				<div class="row"> 
					<div class="col-md-12"> 
						<div class="table-responsive" data-pattern="priority-columns">
							<table  id="carrito" class="table table-small-font table-striped">
								<thead>
										<th>
<input type="hidden" name="codproducto" id="codproducto" placeholder="Codigo">
<input type="hidden" name="codcategoria" id="codcategoria" placeholder="Categoria">
<input type="hidden" name="precioconiva" id="precioconiva" placeholder="Precio con Iva">
<input type="hidden" name="precio" id="precio" placeholder="Precio de Compra">
<input type="hidden" name="precio2" id="precio2" placeholder="Precio de Venta">
<input type="hidden" name="ivaproducto" id="ivaproducto" placeholder="Iva Producto">
<input type="hidden" name="existencia" id="existencia" placeholder="Existencia">
<input type="hidden" name="cantidad" id="cantidad" value="1" placeholder="Cantidad">
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
<td style="background:#232323;color:#FFFFFF;font-size:12px;" colspan=4><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>
									</tr>
								</tbody>
							</table>
							<table width="250" id="carritototal">
								<tr>
<td colspan=3><span class="Estilo9"><label>Total a Confirmar:</label></span></td>
<td><div align="right" class="Estilo9">S/.<label id="lbltotal" name="lbltotal">0.00</label>
<input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>
<input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>
<input type="hidden" name="iva" id="iva" value=""/>
<input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
<input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>
<input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
<input type="hidden" name="txtTotall" id="txtTotall" value="0.00"/>
<input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/></div></td>
									</tr>
								</table>
							</div>
						</div>
					</div>

<hr>

<div class="row">
                    <div class="col-md-12"> 
 <label id="boton" onClick="mostrar();" style="cursor: pointer;">Agregar Observaciones: </label>
<div id="observaciones" style="display: none;">
   <div class="form-group has-feedback"> 
<textarea name="observaciones" class="form-control" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" required="" aria-required="true"></textarea>

                        <i class="fa fa-comments form-control-feedback"></i>
   </div>
</div> 
                    </div> 
           </div><br>

					<div class="modal-footer"> 
<button type="submit" name="btn-venta" id="btn-venta" class="btn btn-primary"><span class="fa fa-save"></span> Confirmar Pedido</button> 
<button type="button" id="vaciarv" class="btn btn-danger" title="Vaciar Carrito"><span class="fa fa-trash-o"></span> Limpiar</button>    
					</div>


                                                    </div>
                                                </div>
                                          </div>
                                     </div>
                            </div>



                            <div class="col-sm-4">
               <h3 class="panel-title"><i class="fa fa-file-pdf-o"></i> Detalles de Factura</h3>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="box-body">


<div class="row"> 
				<div class="col-md-12"> 
					<div class="form-group has-feedback"> 
						<strong style="color:#990000; font-size:17px;">RESERVA DE 
							<?php
							$mesa = new Login();
							$mesa = $mesa->MesasPorId();
							echo $mesa[0]['nombre_mesa']; ?> 
						</strong>
<input type="hidden" name="codmesa" id="codmesa" value="<?php echo $mesa[0]['id_mesa'] ?>">
<input type="hidden" name="nombremesa" id="nombremesa" value="<?php echo $mesa[0]['nombre_mesa'] ?>">
					</div> 
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label class="control-label">B&uacute;squeda de Cliente:&nbsp;&nbsp; 

<img src="asset/img/nuevo.png" style="cursor:pointer;" width="20" height="20" title="Nuevo Cliente DNI" data-toggle="modal" data-target="#myModaldni" data-backdrop="static" data-keyboard="false">
<img src="asset/img/nuevo.png" style="cursor:pointer;" width="20" height="20" title="Nuevo Cliente RUC" data-toggle="modal" data-target="#myModalruc" data-backdrop="static" data-keyboard="false"> 
					</label>
<input type="hidden" name="codcliente" id="codcliente">
<input class="form-control" type="text" name="busquedacliente" id="busquedacliente" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="B&uacute;squeda de Cliente">
				</div>
			</div>
			<div class="row"> 
				<div class="col-md-12"> 
			<label class="control-label">Mesero:<span class="symbol required"></span></label>
<input class="form-control" type="text" name="mesero" id="mesero" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Compra" value="<?php echo $_SESSION["nombres"] ?>" readonly="readonly">
				</div>
			</div>


<input type="hidden" name="descuento" id="descuento" value="0.00">

     <div class="modal-footer"> 
<button type="button" id="mostrar-mesa" class="btn btn-warning"><span class="fa fa-cutlery"></span> Mostrar Mesas</button>   
					</div>

					                                           </div>
                                                <!-- /.box-body -->
                                            </div>
                                        </div>
                                    </div>
                            </div>

					<?php  
					exit;
				} else {
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	   }
}
############################ FUNCION PARA VERIFICAR MESAS PARA VENTAS #######################

########################### FUNCION PARA REGISTRAR VENTAS DE PRODUCTOS #############################
			public function RegistrarVentas()
			{
				self::SetNames();
				if(empty($_POST["txtTotal"]) or empty($_POST["txtTotalCompra"]))
				{
					echo "1";
					exit;
				}

				if($_POST["txtTotal"]=="")
				{
					echo "2";
					exit;

				} else if(empty($_SESSION["CarritoVentas"]))
				{
					echo "3";
					exit;

				} 

				$ver = $_SESSION["CarritoVentas"];
				for($i=0;$i<count($ver);$i++){ 

					$sql = "select existencia from productos where codproducto = '".$ver[$i]['txtCodigo']."'";
					foreach ($this->dbh->query($sql) as $row)
					{
						$this->p[] = $row;
					}
					$existencia = $row['existencia'];

					if($ver[$i]['cantidad'] > $existencia) {

						echo "4";
						exit;                           }
					}


	$sql = " select codventa from ventas order by codventa desc limit 1";
					foreach ($this->dbh->query($sql) as $row){

						$codventa["codventa"]=$row["codventa"];

					}
					if(empty($codventa["codventa"])){
						$codventa = date("Y").'-V00001';

					} else {
						$resto = substr($codventa["codventa"], 0, -5);
						$coun = strlen($resto);
						$num     = substr($codventa["codventa"] , $coun);
						$dig     = $num + 1;
						$cod = str_pad($dig, 5, "0", STR_PAD_LEFT);
						$codventa = date("Y").'-V'.$cod;
					}

					$query = " insert into ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
					$stmt = $this->dbh->prepare($query);
					$stmt->bindParam(1, $codventa);
					$stmt->bindParam(2, $codcaja);
					$stmt->bindParam(3, $codcliente);
					$stmt->bindParam(4, $codmesa);
					$stmt->bindParam(5, $subtotalivasive);
					$stmt->bindParam(6, $subtotalivanove);
					$stmt->bindParam(7, $ivave);
					$stmt->bindParam(8, $totalivave);
					$stmt->bindParam(9, $descuentove);
					$stmt->bindParam(10, $totaldescuentove);
					$stmt->bindParam(11, $totalpago);
					$stmt->bindParam(12, $totalpago2);
					$stmt->bindParam(13, $tipopagove);
					$stmt->bindParam(14, $formapagove);
					$stmt->bindParam(15, $montopagado);
					$stmt->bindParam(16, $montodevuelto);
					$stmt->bindParam(17, $fechavencecredito);
					$stmt->bindParam(18, $statusventa);
					$stmt->bindParam(19, $statuspago);
					$stmt->bindParam(20, $fechaventa);
					$stmt->bindParam(21, $codigo);
					$stmt->bindParam(22, $cocinero);
					$stmt->bindParam(23, $observaciones);
					$stmt->bindParam(24, $fecharegistro);

					$codcaja = strip_tags('0');
					$codcliente = strip_tags($_POST["codcliente"]);
					$codmesa = strip_tags($_POST["codmesa"]);
					$subtotalivasive = strip_tags($_POST["txtsubtotal"]);
					$subtotalivanove = strip_tags($_POST["txtsubtotal2"]);
					$ivave = strip_tags($_POST["iva"]);
					$totalivave = strip_tags($_POST["txtIva"]);
if (strip_tags(isset($_POST['descuento']))) { $descuentove = strip_tags($_POST['descuento']); } else { $descuentove ='0.00'; }
if (strip_tags(isset($_POST['txtDescuento']))) { $totaldescuentove = strip_tags($_POST['txtDescuento']); } else { $totaldescuentove ='0.00'; }
					$totalpago = strip_tags($_POST["txtTotal"]);
					$totalpago2 = strip_tags($_POST["txtTotalCompra"]);
if (strip_tags(isset($_POST['tipopagove']))) { $tipopagove = strip_tags($_POST['tipopagove']); } else { $tipopagove =''; }
if (strip_tags(isset($_POST['formapagove']))) { $formapagove = strip_tags($_POST['formapagove']); } else { $formapagove =''; }
if (strip_tags(isset($_POST['montopagado']))) { $montopagado = strip_tags($_POST['montopagado']); } else { $montopagado =''; }
if (strip_tags(isset($_POST['montodevuelto']))) { $montodevuelto = strip_tags($_POST['montodevuelto']); } else { $montodevuelto =''; }
if (strip_tags(isset($_POST['fechavencecredito']))) { $fechavencecredito = strip_tags(date("Y-m-d",strtotime($_POST['fechavencecredito']))); } else { $fechavencecredito =''; }
					$statusventa = "PENDIENTE";
					$statuspago = "1";
					$fechaventa = strip_tags(date("Y-m-d h:i:s"));
					$codigo = strip_tags($_SESSION["codigo"]);
					$cocinero = strip_tags('1');
if (strip_tags(isset($_POST['observaciones']))) { $observaciones = strip_tags($_POST['observaciones']); } else { $observaciones =''; }
					$fecharegistro = strip_tags(date("Y-m-d"));
					$stmt->execute();

#################### AQUI ACTUALIZAMOS EL STATUS DE MESA ####################
					$sql = " update mesas set "
					." statusmesa = ? "
					." where "
					." codmesa = ?;
					";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindParam(1, $statusmesa);
					$stmt->bindParam(2, $codmesa);

					$statusmesa = strip_tags('1');
					$codmesa = strip_tags($_POST["codmesa"]);
					$stmt->execute();
#################### AQUI ACTUALIZAMOS EL STATUS DE MESA ####################

					$venta = $_SESSION["CarritoVentas"];
					for($i=0;$i<count($venta);$i++){

		$query = " insert into detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
						$stmt = $this->dbh->prepare($query);
						$stmt->bindParam(1, $codventa);
						$stmt->bindParam(2, $codcliente);
						$stmt->bindParam(3, $codproducto);
						$stmt->bindParam(4, $producto);
						$stmt->bindParam(5, $codcategoria);
						$stmt->bindParam(6, $cantidad);
						$stmt->bindParam(7, $preciocompra);
						$stmt->bindParam(8, $precioventa);
						$stmt->bindParam(9, $ivaproducto);
						$stmt->bindParam(10, $importe);
						$stmt->bindParam(11, $importe2);
						$stmt->bindParam(12, $fechadetalleventa);
						$stmt->bindParam(13, $statusdetalle);
						$stmt->bindParam(14, $codigo);

						$codcliente = strip_tags($_POST["codcliente"]);
						$codproducto = strip_tags($venta[$i]['txtCodigo']);
						$producto = strip_tags($venta[$i]['descripcion']);
						$codcategoria = strip_tags($venta[$i]['tipo']);
						$cantidad = strip_tags($venta[$i]['cantidad']);
						$preciocompra = strip_tags($venta[$i]['precio']);
						$precioventa = strip_tags($venta[$i]['precio2']);
						$ivaproducto = strip_tags($venta[$i]['ivaproducto']);
						$importe = strip_tags($venta[$i]['cantidad'] * $venta[$i]['precio2']);
						$importe2 = strip_tags($venta[$i]['cantidad'] * $venta[$i]['precio']);
						$fechadetalleventa = strip_tags(date("Y-m-d h:i:s"));
						$statusdetalle = "1";
						$codigo = strip_tags($_SESSION['codigo']);
						$stmt->execute();

						$sql = " update productos set "
						." existencia = ? "
						." where "
						." codproducto = '".$venta[$i]['txtCodigo']."';
						";
						$stmt = $this->dbh->prepare($sql);
						$stmt->bindParam(1, $existencia);
						$existencia = $venta[$i]['existencia' ] - $venta[$i]['cantidad'];
						$stmt->execute();

						$sql = " update productos set "
						." statusproducto = ? "
						." where "
						." codproducto = '".$venta[$i]['txtCodigo']."' and existencia = '0';
						";
						$stmt = $this->dbh->prepare($sql);
						$stmt->bindParam(1, $statusproducto);
						$statusproducto = "INACTIVO";
						$stmt->execute();


##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################
						$query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
						$stmt = $this->dbh->prepare($query);
						$stmt->bindParam(1, $codventa);
						$stmt->bindParam(2, $codcliente);
						$stmt->bindParam(3, $codproducto);
						$stmt->bindParam(4, $movimiento);
						$stmt->bindParam(5, $entradas);
						$stmt->bindParam(6, $salidas);
						$stmt->bindParam(7, $devolucion);
						$stmt->bindParam(8, $stockactual);
						$stmt->bindParam(9, $preciounit);
						$stmt->bindParam(10, $costototal);
						$stmt->bindParam(11, $documento);
						$stmt->bindParam(12, $fechakardex);

						$codcliente = strip_tags($_POST["codcliente"]);
						$codproducto = strip_tags($venta[$i]['txtCodigo']);
						$movimiento = strip_tags("SALIDAS");
						$entradas = strip_tags("0");
						$salidas =strip_tags($venta[$i]['cantidad']);
						$devolucion = strip_tags("0");
						$stockactual = strip_tags($venta[$i]['existencia' ] - $venta[$i]['cantidad']); 
						$preciounit = strip_tags($venta[$i]['precio2']);
						$costototal = strip_tags($venta[$i]['precio2'] * $venta[$i]['cantidad']);
						$documento = strip_tags("VENTA - FACTURA: ".$codventa);
						$fechakardex = strip_tags(date("Y-m-d h:i:s"));
						$stmt->execute();	


################### CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS REGISTRADOS ##############
$sql = "select * from productosvsingredientes where codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array( $venta[$i]['txtCodigo'] ) );
		$num = $stmt->rowCount();
if($num>0) {


	$sql = "select * from productosvsingredientes LEFT JOIN ingredientes ON productosvsingredientes.codingrediente = ingredientes.codingrediente where productosvsingredientes.codproducto IN ('".$venta[$i]['txtCodigo']."')";

	    $array=array();

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;

			$codproducto = $row['codproducto'];
			$codingrediente = $row['codingrediente'];
			$cantracion = $row['cantracion'];
			$cantingrediente = $row['cantingrediente'];
			$costoingrediente = $row['costoingrediente'];


			$update = " update ingredientes set "
			." cantingrediente = ? "
			." where "
			." codingrediente = ?;
			";
			$stmt = $this->dbh->prepare($update);
			$stmt->bindParam(1, $cantidadracion);
			$stmt->bindParam(2, $codingrediente);

			$racion = rount($cantracion*$cantidad,2);
			$cantidadracion = rount($cantingrediente-$racion,2);
			$stmt->execute();


################# REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX #################
					$query = " insert into kardexingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
					$stmt = $this->dbh->prepare($query);
					$stmt->bindParam(1, $codventa);
					$stmt->bindParam(2, $codcliente);
					$stmt->bindParam(3, $codproducto);
					$stmt->bindParam(4, $codingrediente);
					$stmt->bindParam(5, $movimientoing);
					$stmt->bindParam(6, $entradasing);
					$stmt->bindParam(7, $salidasing);
					$stmt->bindParam(8, $stockactualing);
					$stmt->bindParam(9, $preciouniting);
					$stmt->bindParam(10, $costototaling);
					$stmt->bindParam(11, $documentoing);
					$stmt->bindParam(12, $fechakardexing);

					$codcliente = strip_tags($_POST["codcliente"]);
					$codproducto = strip_tags($codproducto);
					$codingrediente = strip_tags($codingrediente);
					$movimientoing = strip_tags("SALIDAS");

					$entradasing = strip_tags("0");
					$salidasing = rount($cantracion*$cantidad,2);
					$stockactualing = rount($cantingrediente-$racion,2);
					$preciouniting = strip_tags($costoingrediente);
					$costototaling = strip_tags($costoingrediente * $cantidad);

					$documentoing = strip_tags("VENTA - FACTURA: ".$codventa);
					$fechakardexing = strip_tags(date("Y-m-d h:i:s"));
					$stmt->execute();
	################# REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ####################

		          }

}
########## FIN DE CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS REGISTRADOS #############

         }

###### AQUI DESTRUIMOS TODAS LAS VARIABLES DE SESSION QUE RECIBIMOS EN CARRITO DE VENTAS ######
					unset($_SESSION["CarritoVentas"]);

echo "<div class='alert alert-success'>";
echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
echo "<span class='fa fa-check-square-o'></span> EL PEDIDO DE LA ".$_POST["nombremesa"].", FUE CONFIRMADO EXITOSAMENTE <a href='reportepdf?codventa=".base64_encode($codventa)."&tipo=".base64_encode("TICKETCOMANDA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Comanda' target='_black'><strong>IMPRIMIR COMANDA</strong></a>";
echo "</div>";

echo "<script>window.open('reportepdf?codventa=".base64_encode($codventa)."&tipo=".base64_encode("TICKETCOMANDA")."', '_blank');</script>";
					exit;
				}
########################### FUNCION PARA REGISTRAR VENTAS DE PRODUCTOS #############################

###################### FUNCION PARA AGREGAR NUEVOS PRODUCTOS PARA VENTAS ######################
public function AgregaPedidos()
{

	if(empty($_SESSION["CarritoVentas"]))
				{
					echo "3";
					exit;

				} 

	$ven = $_SESSION["CarritoVentas"];
	for($i=0;$i<count($ven);$i++){


		$sql = "select * from detalleventas where codventa = ? and codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array( $_POST["codventa"], $ven[$i]['txtCodigo'] ) );
		$num = $stmt->rowCount();
		if($num>0)
		{

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pae[] = $row;
			}
			$codproducto = $pae[0]['codproducto'];
			$cantven = $pae[0]['cantventa'];
			$import = $pae[0]['importe'];
			$import2 = $pae[0]['importe2'];

			$sql = " update detalleventas set "
			." cantventa = ?, "
			." importe = ?, "
			." importe2 = ? "
			." where "
			." codventa = '".$_POST["codventa"]."' and codproducto = '".$ven[$i]['txtCodigo']."';
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $cantidad);
			$stmt->bindParam(2, $importe);
			$stmt->bindParam(3, $importe2);

			$cantidad = strip_tags($ven[$i]['cantidad']+$cantven);
			$importe = strip_tags($ven[$i]['cantidad'] * $ven[$i]['precio2']+$import);
			$importe2 = strip_tags($ven[$i]['cantidad'] * $ven[$i]['precio']+$import2);
			$stmt->execute();

			$sql = " update productos set "
			." existencia = ? "
			." where "
			." codproducto = '".$ven[$i]['txtCodigo']."';
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$existencia = $ven[$i]['existencia' ] - $ven[$i]['cantidad'];
			$stmt->execute();

			$sql = " update productos set "
			." statusproducto = ? "
			." where "
			." codproducto = '".$ven[$i]['txtCodigo']."' and existencia = '0';
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $statusproducto);
			$statusproducto = "INACTIVO";
			$stmt->execute();

################## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #################
			$query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codventa);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codproducto);
			$stmt->bindParam(4, $movimiento);
			$stmt->bindParam(5, $entradas);
			$stmt->bindParam(6, $salidas);
			$stmt->bindParam(7, $devolucion);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $preciounit);
			$stmt->bindParam(10, $costototal);
			$stmt->bindParam(11, $documento);
			$stmt->bindParam(12, $fechakardex);

			$codventa = strip_tags($_POST["codventa"]);
			$codcliente = strip_tags($_POST["codcliente"]);
			$codproducto = strip_tags($ven[$i]['txtCodigo']);
			$movimiento = strip_tags("SALIDAS");
			$entradas = strip_tags("0");
			$salidas =strip_tags($ven[$i]['cantidad']);
			$devolucion = strip_tags("0");
			$stockactual = strip_tags($ven[$i]['existencia' ] - $ven[$i]['cantidad']); 
			$preciounit = strip_tags($ven[$i]['precio2']);
			$costototal = strip_tags($ven[$i]['precio2'] * $ven[$i]['cantidad']);
			$documento = strip_tags("VENTA - FACTURA: ".$codventa);
			$fechakardex = strip_tags(date("Y-m-d h:i:s"));
			$stmt->execute();


############## CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS REGISTRADOS ###############
$sql = "select * from productosvsingredientes where codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array( $ven[$i]['txtCodigo'] ) );
		$num = $stmt->rowCount();
if($num>0) {


	$sql = "select * from productosvsingredientes LEFT JOIN ingredientes ON productosvsingredientes.codingrediente = ingredientes.codingrediente where productosvsingredientes.codproducto IN ('".$ven[$i]['txtCodigo']."')";

	    $array=array();

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;

			$codproducto = $row['codproducto'];
			$codingrediente = $row['codingrediente'];
			$cantracion = $row['cantracion'];
			$cantingrediente = $row['cantingrediente'];
			$costoingrediente = $row['costoingrediente'];


			$update = " update ingredientes set "
			." cantingrediente = ? "
			." where "
			." codingrediente = ?;
			";
			$stmt = $this->dbh->prepare($update);
			$stmt->bindParam(1, $cantidadracion);
			$stmt->bindParam(2, $codingrediente);

			$racion = rount($cantracion*$cantidad,2);
			$cantidadracion = rount($cantingrediente-$racion,2);
			$stmt->execute();


##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX #####################
					$query = " insert into kardexingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
					$stmt = $this->dbh->prepare($query);
					$stmt->bindParam(1, $codventa);
					$stmt->bindParam(2, $codcliente);
					$stmt->bindParam(3, $codproducto);
					$stmt->bindParam(4, $codingrediente);
					$stmt->bindParam(5, $movimientoing);
					$stmt->bindParam(6, $entradasing);
					$stmt->bindParam(7, $salidasing);
					$stmt->bindParam(8, $stockactualing);
					$stmt->bindParam(9, $preciouniting);
					$stmt->bindParam(10, $costototaling);
					$stmt->bindParam(11, $documentoing);
					$stmt->bindParam(12, $fechakardexing);

					$codcliente = strip_tags($_POST["codcliente"]);
					$codproducto = strip_tags($codproducto);
					$codingrediente = strip_tags($codingrediente);
					$movimientoing = strip_tags("SALIDAS");

					$entradasing = strip_tags("0");
					$salidasing = rount($cantracion*$cantidad,2);
					$stockactualing = rount($cantingrediente-$racion,2);
					$preciouniting = strip_tags($costoingrediente);
					$costototaling = strip_tags($costoingrediente * $cantidad);

					$documentoing = strip_tags("VENTA - FACTURA: ".$codventa);
					$fechakardexing = strip_tags(date("Y-m-d h:i:s"));
					$stmt->execute();
	##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ###################

		          }

}
############## FIN DE CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS REGISTRADOS ###########	


		}
		else
		{


			$query = " insert into detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codventa);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codproducto);
			$stmt->bindParam(4, $producto);
			$stmt->bindParam(5, $codcategoria);
			$stmt->bindParam(6, $cantidad);
			$stmt->bindParam(7, $preciocompra);
			$stmt->bindParam(8, $precioventa);
			$stmt->bindParam(9, $ivaproducto);
			$stmt->bindParam(10, $importe);
			$stmt->bindParam(11, $importe2);
			$stmt->bindParam(12, $fechadetalleventa);
			$stmt->bindParam(13, $statusdetalle);
			$stmt->bindParam(14, $codigo);

			$codventa = strip_tags($_POST["codventa"]);
			$codcliente = strip_tags($_POST["codcliente"]);
			$codproducto = strip_tags($ven[$i]['txtCodigo']);
			$producto = strip_tags($ven[$i]['descripcion']);
			$codcategoria = strip_tags($ven[$i]['tipo']);
			$cantidad = strip_tags($ven[$i]['cantidad']);
			$preciocompra = strip_tags($ven[$i]['precio']);
			$precioventa = strip_tags($ven[$i]['precio2']);
			$ivaproducto = strip_tags($ven[$i]['ivaproducto']);
			$importe = strip_tags($ven[$i]['cantidad'] * $ven[$i]['precio2']);
			$importe2 = strip_tags($ven[$i]['cantidad'] * $ven[$i]['precio']);
			$fechadetalleventa = strip_tags(date("Y-m-d h:i:s"));
			$statusdetalle = "1";
			$codigo = strip_tags($_SESSION['codigo']);
			$stmt->execute();

			$sql = " update productos set "
			." existencia = ? "
			." where "
			." codproducto = '".$ven[$i]['txtCodigo']."';
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$existencia = $ven[$i]['existencia' ] - $ven[$i]['cantidad'];
			$stmt->execute();

			$sql = " update productos set "
			." statusproducto = ? "
			." where "
			." codproducto = '".$ven[$i]['txtCodigo']."' and existencia = '0';
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $statusproducto);
			$statusproducto = "INACTIVO";
			$stmt->execute();

##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
			$query = " insert into kardexproductos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codventa);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codproducto);
			$stmt->bindParam(4, $movimiento);
			$stmt->bindParam(5, $entradas);
			$stmt->bindParam(6, $salidas);
			$stmt->bindParam(7, $devolucion);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $preciounit);
			$stmt->bindParam(10, $costototal);
			$stmt->bindParam(11, $documento);
			$stmt->bindParam(12, $fechakardex);

			$codcliente = strip_tags($_POST["codcliente"]);
			$codproducto = strip_tags($ven[$i]['txtCodigo']);
			$movimiento = strip_tags("SALIDAS");
			$entradas = strip_tags("0");
			$salidas =strip_tags($ven[$i]['cantidad']);
			$devolucion = strip_tags("0");
			$stockactual = strip_tags($ven[$i]['existencia' ] - $ven[$i]['cantidad']); 
			$preciounit = strip_tags($ven[$i]['precio2']);
			$costototal = strip_tags($ven[$i]['precio2'] * $ven[$i]['cantidad']);
			$documento = strip_tags("VENTA - FACTURA: ".$codventa);
			$fechakardex = strip_tags(date("Y-m-d h:i:s"));
			$stmt->execute();	


############### CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS REGISTRADOS ################
$sql = "select * from productosvsingredientes where codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array( $ven[$i]['txtCodigo'] ) );
		$num = $stmt->rowCount();
if($num>0) {


	$sql = "select * from productosvsingredientes LEFT JOIN ingredientes ON productosvsingredientes.codingrediente = ingredientes.codingrediente where productosvsingredientes.codproducto IN ('".$ven[$i]['txtCodigo']."')";

	    $array=array();

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;

			$codproducto = $row['codproducto'];
			$codingrediente = $row['codingrediente'];
			$cantracion = $row['cantracion'];
			$cantingrediente = $row['cantingrediente'];
			$costoingrediente = $row['costoingrediente'];


			$update = " update ingredientes set "
			." cantingrediente = ? "
			." where "
			." codingrediente = ?;
			";
			$stmt = $this->dbh->prepare($update);
			$stmt->bindParam(1, $cantidadracion);
			$stmt->bindParam(2, $codingrediente);

			$racion = rount($cantracion*$cantidad,2);
			$cantidadracion = rount($cantingrediente-$racion,2);
			$stmt->execute();


##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX #####################
$query = " insert into kardexingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
					$stmt = $this->dbh->prepare($query);
					$stmt->bindParam(1, $codventa);
					$stmt->bindParam(2, $codcliente);
					$stmt->bindParam(3, $codproducto);
					$stmt->bindParam(4, $codingrediente);
					$stmt->bindParam(5, $movimientoing);
					$stmt->bindParam(6, $entradasing);
					$stmt->bindParam(7, $salidasing);
					$stmt->bindParam(8, $stockactualing);
					$stmt->bindParam(9, $preciouniting);
					$stmt->bindParam(10, $costototaling);
					$stmt->bindParam(11, $documentoing);
					$stmt->bindParam(12, $fechakardexing);

					$codcliente = strip_tags($_POST["codcliente"]);
					$codproducto = strip_tags($codproducto);
					$codingrediente = strip_tags($codingrediente);
					$movimientoing = strip_tags("SALIDAS");

					$entradasing = strip_tags("0");
					$salidasing = rount($cantracion*$cantidad,2);
					$stockactualing = rount($cantingrediente-$racion,2);
					$preciouniting = strip_tags($costoingrediente);
					$costototaling = strip_tags($costoingrediente * $cantidad);

					$documentoing = strip_tags("VENTA - FACTURA: ".$codventa);
					$fechakardexing = strip_tags(date("Y-m-d h:i:s"));
					$stmt->execute();
##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ###################

		          }

}
############# FIN DE CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS REGISTRADOS #############	

		}
	}

	$sql4 = "select * from ventas where codventa = ? ";
	$stmt = $this->dbh->prepare($sql4);
	$stmt->execute( array($_POST["codventa"]) );
	$num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$subtotalivasive = $paea[0]["subtotalivasive"];
		$subtotalivanove = $paea[0]["subtotalivanove"];
		$iva = $paea[0]["ivave"]/100;
		$descuento = $paea[0]["descuentove"]/100;
		$totalivave = $paea[0]["totalivave"];
		$totaldescuentove = $paea[0]["totaldescuentove"];


		$sql3 = "select sum(importe) as importe, sum(importe2) as importe2, sum(preciocompra) as preciocompra from detalleventas where codventa = ? and ivaproducto = 'SI'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array($_POST["codventa"]));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$preciocompraiva = $p[0]["preciocompra"];
		$importeiva = $p[0]["importe"];
		$importe2iva = $p[0]["importe2"];

		$sql5 = "select sum(importe) as importe, sum(importe2) as importe2, sum(preciocompra) as preciocompra from detalleventas where codventa = ?  and ivaproducto = 'NO'";
		$stmt = $this->dbh->prepare($sql5);
		$stmt->execute( array($_POST["codventa"]));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pae[] = $row;
			}
			$preciocompra = $row["preciocompra"];
			$importe = $row["importe"];
			$importe2 = $row["importe2"];		

			$sql = " update ventas set "
			." subtotalivasive = ?, "
			." subtotalivanove = ?, "
			." totalivave = ?, "
			." totaldescuentove = ?, "
			." totalpago= ?, "
			." totalpago2= ?, "
			." observaciones= ? "
			." where "
			." codventa = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $subtotalivasive);
			$stmt->bindParam(2, $subtotalivanove);
			$stmt->bindParam(3, $totaliva);
			$stmt->bindParam(4, $totaldescuentove);
			$stmt->bindParam(5, $total);
			$stmt->bindParam(6, $total2);
			$stmt->bindParam(7, $observaciones);
			$stmt->bindParam(8, $codventa);

			$subtotalivasive= rount($importeiva,2);
			$subtotalivanove= rount($importe,2);
			$totaliva= rount($subtotalivasive*$iva,2);
			$tot= rount($subtotalivasive+$subtotalivanove+$totaliva,2);
			$totaldescuentove= rount($tot*$descuento,2);
			$total= rount($tot-$totaldescuentove,2);
			$total2= rount($preciocompra,2);
if (strip_tags(isset($_POST['observaciones']))) { $observaciones = strip_tags($_POST['observaciones']); } else { $observaciones =''; }
			$codventa = strip_tags($_POST["codventa"]);
			$stmt->execute();

###### AQUI DESTRUIMOS TODAS LAS VARIABLES DE SESSION QUE RECIBIMOS EN CARRITO DE VENTAS ######
			unset($_SESSION["CarritoVentas"]);


echo "<div class='alert alert-success'>";
echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
echo "<span class='fa fa-check-square-o'></span> LOS PRODUCTOS FUERON AGREGADOS AL PEDIDO EXITOSAMENTE <a href='reportepdf?codventa=".base64_encode($codventa)."&tipo=".base64_encode("TICKETCOMANDA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Comanda' target='_black'><strong>IMPRIMIR COMANDA</strong></a>";
echo "</div>";

echo "<script>window.open('reportepdf?codventa=".base64_encode($codventa)."&tipo=".base64_encode("TICKETCOMANDA")."', '_blank');</script>";
exit;

		}
###################### FUNCION PARA AGREGAR NUEVOS PRODUCTOS PARA VENTAS ######################


############################## FUNCION PARA CERRAR MESAS EN VENTAS ###########################
public function CerrarMesa()
{
	self::SetNames();	
	if(empty($_POST["codventa"]) or empty($_POST["codmesa"]))
	{
		echo "1";
		exit;
	}

	if($_POST["codcaja"]=="")
	{
		echo "5";
		exit;
	}

	if ($_POST["tipopagove"] == "CREDITO" && $_POST["codcliente"] == '0') { 

		echo "6";
		exit;
	}
	if (strip_tags(isset($_POST['fechavencecredito']))) { $fechavencecredito = strip_tags(date("Y-m-d",strtotime($_POST['fechavencecredito']))); } else { $fechavencecredito =''; }
	$f1 = new DateTime($fechavencecredito);
	$f2 = new DateTime("now");

	if($_POST["tipopagove"] == "CREDITO" && $f2 > $f1) { 

		echo "7";
		exit;
	}

	$sql = " update ventas set "
	." codcaja = ?, "
	." codcliente = ?, "
	." subtotalivasive = ?, "
	." subtotalivanove = ?, "
	." ivave = ?, "
	." totalivave = ?, "
	." descuentove = ?, "
	." totaldescuentove = ?, "
	." totalpago = ?, "
	." totalpago2 = ?, "
	." tipopagove = ?, "
	." formapagove = ?, "
	." montopagado = ?, "
	." montodevuelto = ?, "
	." fechavencecredito = ?, "
	." statusventa = ?, "
	." statuspago = ?, "
	." codigo = ?, "
	." cocinero = ? "
	." where "
	." codventa = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $codcaja);
	$stmt->bindParam(2, $codcliente);
	$stmt->bindParam(3, $subtotalivasive);
	$stmt->bindParam(4, $subtotalivanove);
	$stmt->bindParam(5, $ivave);
	$stmt->bindParam(6, $totalivave);
	$stmt->bindParam(7, $descuentove);
	$stmt->bindParam(8, $totaldescuentove);
	$stmt->bindParam(9, $totalpago);
	$stmt->bindParam(10, $totalpago2);
	$stmt->bindParam(11, $tipopagove);
	$stmt->bindParam(12, $formapagove);
	$stmt->bindParam(13, $montopagado);
	$stmt->bindParam(14, $montodevuelto);
	$stmt->bindParam(15, $fechavencecredito);
	$stmt->bindParam(16, $statusventa);
	$stmt->bindParam(17, $statuspago);
	$stmt->bindParam(18, $codigo);
	$stmt->bindParam(19, $cocinero);
	$stmt->bindParam(20, $codventa);

	$codmesa = strip_tags($_POST["codmesa"]);
	$codcaja = strip_tags($_POST["codcaja"]);
	$codcliente = strip_tags($_POST["codcliente"]);
	$subtotalivasive = strip_tags($_POST["txtsubtotall"]);
	$subtotalivanove = strip_tags($_POST["txtsubtotall2"]);
	$ivave = strip_tags($_POST["iva"]);
	$totalivave = strip_tags($_POST["txtIvaa"]);
	$descuentove = strip_tags($_POST['descuento']);
	$totaldescuentove = strip_tags($_POST['txtDescuentoo']);
	$totalpago = strip_tags($_POST["txtTotall"]);
	$totalpago2 = strip_tags($_POST["txtTotalCompraa"]);
	$tipopagove = strip_tags($_POST['tipopagove']); 

	if (strip_tags($_POST["tipopagove"]=="CONTADO")) { $formapagove = strip_tags($_POST["formapagove"]); } else { $formapagove = "CREDITO"; }

	if (strip_tags(isset($_POST['montopagado']))) { $montopagado = strip_tags($_POST['montopagado']); } else { $montopagado =''; }
	if (strip_tags(isset($_POST['montodevuelto']))) { $montodevuelto = strip_tags($_POST['montodevuelto']); } else { $montodevuelto =''; }
	if (strip_tags(isset($_POST['fechavencecredito']))) { $fechavencecredito = strip_tags(date("Y-m-d",strtotime($_POST['fechavencecredito']))); } else { $fechavencecredito =''; }
	if (strip_tags($_POST["tipopagove"]=="CONTADO")) { $statusventa = strip_tags("PAGADA"); } else { $statusventa = "PENDIENTE"; }
	$statuspago = "0";
	$codigo = strip_tags($_SESSION["codigo"]);
	$cocinero = "0";
	$codventa = strip_tags($_POST["codventa"]);
	$stmt->execute();	

#################### AQUI ACTUALIZAMOS EL STATUS DE MESA ####################
	$sql = " update mesas set "
	." statusmesa = ? "
	." where "
	." codmesa = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $statusmesa);
	$stmt->bindParam(2, $codmesa);

	$statusmesa = strip_tags('0');
	$codmesa = strip_tags($_POST["codmesa"]);
	$stmt->execute();
#################### AQUI ACTUALIZAMOS EL STATUS DE MESA ####################

#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
	if ($_POST["tipopagove"]=="CONTADO"){

		$sql = "select ingresos from arqueocaja where codcaja = '".$_POST["codcaja"]."' and statusarqueo = '1'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$ingreso = $row['ingresos'];

		$sql = " update arqueocaja set "
		." ingresos = ? "
		." where "
		." codcaja = ? and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codcaja);

		$txtTotal = strip_tags($_POST["txtTotall"]+$ingreso);
		$codcaja = strip_tags($_POST["codcaja"]);
//$txtTotal= rount($_POST["txtTotal"]+$ingreso,2);
		$stmt->execute();
	}
#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################

############## REGISTRO DE ABONOS EN VENTAS ##################
	if (strip_tags($_POST["tipopagove"]=="CREDITO" && $_POST["montoabono"]!="0.00")) { 

		$query = " insert into abonoscreditos values (null, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $montoabono);
		$stmt->bindParam(4, $fechaabono);
		$stmt->bindParam(5, $codigo);
		$stmt->bindParam(6, $codcaja);

		$codventa = strip_tags($_POST["codventa"]);
		$codcliente = strip_tags($_POST["codcliente"]);
		$montoabono = strip_tags($_POST["montoabono"]);
		$fechaabono = strip_tags(date("Y-m-d h:i:s"));
		$codigo = strip_tags($_SESSION["codigo"]);
		$codcaja = strip_tags($_POST["codcaja"]);
		$stmt->execute();
	}
############## REGISTRO DE ABONOS EN VENTAS ##################

	$sql = " update detalleventas set "
	." statusdetalle = ? "
	." where "
	." codventa = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $statusdetalle);
	$stmt->bindParam(2, $codventa);

	$statusdetalle = strip_tags('0');
	$codventa = strip_tags($_POST["codventa"]);
	$stmt->execute();

	unset($_SESSION["CarritoVentas"]);

echo "<div class='alert alert-success'>";
echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
echo "<span class='fa fa-check-square-o'></span> EL CIERRE DE MESA FUE REALIZADO EXITOSAMENTE <a href='reportepdf.php?codventa=".base64_encode($codventa)."&tipo=".base64_encode("TICKET")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black'><strong>IMPRIMIR TICKET</strong></a>";
echo "</div>";

echo "<script>window.open('reportepdf?codventa=".base64_encode($codventa)."&tipo=".base64_encode("TICKET")."', '_blank');</script>";
exit;
}
############################## FUNCION PARA CERRAR MESAS EN VENTAS ###########################

	
/*$sql = " SELECT ventas.idventa, ventas.codventa, ventas.codcaja, ventas.codcliente, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, cajas.nrocaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();

	$clientes = array(); //creamos un array
		
while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		
			 $id=$row['codventa'];
             $nombre=$row['codcliente'];
             $edad=$row['totalpago'];
    

    $clientes[] = array('id'=> $id, 'nombre'=> $nombre, 'edad'=> $edad);
		}*/
		
################################# FUNCION BUSQUEDA DE VENTAS ################################## 
	public function BusquedaVentas()
	{

      self::SetNames();

 if ($_SESSION['acceso'] == "administrador") {


	if ($_GET['tipobusqueda'] == "1") {

$sql = " SELECT ventas.idventa, ventas.codventa, ventas.codcaja, ventas.codcliente, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, cajas.nrocaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE ventas.codcliente = ? GROUP BY ventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET['codcliente']));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS PARA EL CLIENTE INGRESADO !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }

		} else if ($_GET['tipobusqueda'] == "2") {

$sql = " SELECT ventas.idventa, ventas.codventa, ventas.codcaja, ventas.codcliente, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, cajas.nrocaja, cajas.nombrecaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE ventas.codcaja = ? GROUP BY ventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET['codcaja']));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA CAJA SELECCIONADA !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }

		} else if ($_GET['tipobusqueda'] == "3") {

$sql = " SELECT ventas.idventa, ventas.codventa, ventas.codcaja, ventas.codcliente, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, cajas.nrocaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = ? GROUP BY ventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(date("Y-m-d",strtotime($_GET['fecha']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{ ?>

			<script type="text/javascript">
				toastr.options = {
					"closeButton":true,
					"progressBar": true
				};
				toastr.info("No existen ventas en la fecha ingresada","No hay datos");
			</script>
<?php		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA FECHA INGRESADA !</div></center>";
	exit;
		        } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }
		     } 

 ################# AQUI BUSCAMOS POR CAJEROS Y DISTRIBUIDOR ################

	       }   else   {


		  	if ($_GET['tipobusqueda'] == "1") {

$sql = " SELECT ventas.idventa, ventas.codventa, ventas.codcaja, ventas.codcliente, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, cajas.nrocaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE ventas.codcliente = ? AND ventas.codigo = '".$_SESSION["codigo"]."' GROUP BY ventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET['codcliente']));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{ ?>
	
	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.info("No existen ventas para el cliente ingresado","No hay datos");
	</script>

	<?php 
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS PARA EL CLIENTE INGRESADO !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }

		} else if ($_GET['tipobusqueda'] == "2") {

$sql = " SELECT ventas.idventa, ventas.codventa, ventas.codcaja, ventas.codcliente, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, cajas.nrocaja, cajas.nombrecaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE ventas.codcaja = ? AND ventas.codigo = '".$_SESSION["codigo"]."' GROUP BY ventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET['codcaja']));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{ ?>
	
	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.info("No existen ventas en la caja seleccionada","No hay datos");
	</script>

	<?php
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA CAJA SELECCIONADA !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }

		} else if ($_GET['tipobusqueda'] == "3") {

$sql = " SELECT ventas.idventa, ventas.codventa, ventas.codcaja, ventas.codcliente, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, cajas.nrocaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente) LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = ? AND ventas.codigo = '".$_SESSION["codigo"]."' GROUP BY ventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(date("Y-m-d",strtotime($_GET['fecha']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{ ?>
	
	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.info("No existen ventas en la fecha ingresada","No hay datos");
	</script>

	<?php
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA FECHA INGRESADA !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }
		   }
	 }
}
################################# FUNCION BUSQUEDA DE VENTAS ################################## 


############################## FUNCION LISTAR VENTAS EN MOSTRADOR ##################################
	public function ListarMostrador()
	{
		self::SetNames();
	$sql = "SELECT ventas.idventa, ventas.codventa, ventas.codcliente as cliente, ventas.totalpago, ventas.cocinero, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, salas.nombresala, mesas.nombremesa, usuarios.nombres, GROUP_CONCAT(cantventa, ' | ', producto SEPARATOR '<br>') AS detalles FROM ventas INNER JOIN detalleventas ON detalleventas.codventa = ventas.codventa LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente INNER JOIN mesas ON mesas.codmesa = ventas.codmesa LEFT JOIN salas ON mesas.codsala = salas.codsala WHERE ventas.cocinero = '1' GROUP BY detalleventas.codventa";
        foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
############################## FUNCION LISTAR VENTAS EN MOSTRADOR ##################################

################################# FUNCION PARA ID VENTAS ##################################
public function VentasPorId()
{
	self::SetNames();
	$sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.direccliente, clientes.emailcliente, ventas.idventa, ventas.codventa, ventas.codcaja, ventas.codcliente, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.tipopagove, ventas.formapagove, ventas.montopagado, ventas.montodevuelto, ventas.fechaventa, ventas.fechavencecredito, ventas.statusventa, ventas.observaciones, mediospagos.mediopago, mesas.codmesa, mesas.nombremesa, usuarios.nombres, cajas.nrocaja, abonoscreditos.codventa as cod, abonoscreditos.fechaabono, SUM(montoabono) AS abonototal FROM (ventas LEFT JOIN clientes ON clientes.codcliente = ventas.codcliente) LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa LEFT JOIN mediospagos ON ventas.formapagove = mediospagos.codmediopago LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo WHERE ventas.codventa =? GROUP BY cod";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codventa"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################# FUNCION PARA ID VENTAS ##################################

################################# FUNCION BUSQUEDA DETALLES DE VENTAS ##################################
	public function BusquedaDetallesVentas()
	{
         self::SetNames();

 if ($_SESSION['acceso'] == "administrador") {

	if ($_GET['tipobusquedad'] == "1") {

$sql = "SELECT ventas.idventa, ventas.codventa, ventas.codcliente, ventas.codmesa, ventas.codcaja, ventas.tipopagove, detalleventas.coddetalleventa, detalleventas.codventa, detalleventas.codproducto, detalleventas.producto, detalleventas.cantventa, detalleventas.preciocompra, detalleventas.precioventa, detalleventas.ivaproducto, detalleventas.importe, detalleventas.importe2, detalleventas.fechadetalleventa, categorias.nomcategoria FROM detalleventas LEFT JOIN ventas ON ventas.codventa = detalleventas.codventa LEFT JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria WHERE ventas.idventa = ? ORDER BY detalleventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codventa"]));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{ ?>

	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.info("No existen ventas con este numero de factura","No hay datos");
	</script>


	<?php 
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS CON ESTE N&deg; DE FACTURA !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }

		} else if ($_GET['tipobusquedad'] == "2") {

$sql = "SELECT ventas.idventa, ventas.codventa, ventas.codcliente, ventas.codmesa, ventas.codcaja, ventas.tipopagove, detalleventas.coddetalleventa, detalleventas.codventa, detalleventas.codproducto, detalleventas.producto, detalleventas.cantventa, detalleventas.preciocompra, detalleventas.precioventa, detalleventas.ivaproducto, detalleventas.importe, detalleventas.importe2, detalleventas.fechadetalleventa, categorias.nomcategoria, cajas.nrocaja, cajas.nombrecaja FROM detalleventas LEFT JOIN ventas ON ventas.codventa = detalleventas.codventa LEFT JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE ventas.codcaja = ? ORDER BY detalleventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET['codcaja']));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{ ?>

	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.info("No existen ventas en la caja seleccionada","No hay datos");
	</script>

	<?php
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA CAJA SELECCIONADA !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }

		} else if ($_GET['tipobusquedad'] == "3") {

$sql = "SELECT ventas.idventa, ventas.codventa, ventas.codcliente, ventas.codmesa, ventas.codcaja, ventas.tipopagove, detalleventas.coddetalleventa, detalleventas.codventa, detalleventas.codproducto, detalleventas.producto, detalleventas.cantventa, detalleventas.preciocompra, detalleventas.precioventa, detalleventas.ivaproducto, detalleventas.importe, detalleventas.importe2, detalleventas.fechadetalleventa, categorias.nomcategoria, cajas.nrocaja, cajas.nombrecaja FROM detalleventas LEFT JOIN ventas ON ventas.codventa = detalleventas.codventa LEFT JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = ? ORDER BY detalleventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(date("Y-m-d",strtotime($_GET['fecha']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{ ?>

	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.info("No existen ventas en la fecha ingresada","No hay datos");
	</script>

	<?php
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA FECHA INGRESADA !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }
		     } 

 ################# AQUI BUSCAMOS POR CAJEROS Y DISTRIBUIDOR ################

	       }   else   {


		  	if ($_GET['tipobusquedad'] == "1") {

$sql = "SELECT ventas.idventa, ventas.codventa, ventas.codcliente, ventas.codmesa, ventas.codcaja, ventas.tipopagove, detalleventas.coddetalleventa, detalleventas.codventa, detalleventas.codproducto, detalleventas.producto, detalleventas.cantventa, detalleventas.preciocompra, detalleventas.precioventa, detalleventas.ivaproducto, detalleventas.importe, detalleventas.importe2, detalleventas.fechadetalleventa, categorias.nomcategoria FROM detalleventas LEFT JOIN ventas ON ventas.codventa = detalleventas.codventa LEFT JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria WHERE ventas.idventa = ? AND ventas.codigo = '".$_SESSION["codigo"]."' ORDER BY detalleventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codventa"]));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{ ?>

	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.info("No existen ventas con este numero de factura","No hay datos");
	</script>

	<?php
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS CON ESTE N&deg; DE FACTURA !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }

		} else if ($_GET['tipobusquedad'] == "2") {

$sql = "SELECT ventas.idventa, ventas.codventa, ventas.codcliente, ventas.codmesa, ventas.codcaja, ventas.tipopagove, detalleventas.coddetalleventa, detalleventas.codventa, detalleventas.codproducto, detalleventas.producto, detalleventas.cantventa, detalleventas.preciocompra, detalleventas.precioventa, detalleventas.ivaproducto, detalleventas.importe, detalleventas.importe2, detalleventas.fechadetalleventa, categorias.nomcategoria, cajas.nrocaja, cajas.nombrecaja FROM detalleventas LEFT JOIN ventas ON ventas.codventa = detalleventas.codventa LEFT JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE ventas.codcaja = ? AND ventas.codigo = '".$_SESSION["codigo"]."' ORDER BY detalleventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET['codcaja']));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{ ?>

	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.info("No existen ventas en la caja seleccionada","No hay datos");
	</script>

	<?php
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA CAJA SELECCIONADA !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }

		} else if ($_GET['tipobusquedad'] == "3") {

$sql = "SELECT ventas.idventa, ventas.codventa, ventas.codcliente, ventas.codmesa, ventas.codcaja, ventas.tipopagove, detalleventas.coddetalleventa, detalleventas.codventa, detalleventas.codproducto, detalleventas.producto, detalleventas.cantventa, detalleventas.preciocompra, detalleventas.precioventa, detalleventas.ivaproducto, detalleventas.importe, detalleventas.importe2, detalleventas.fechadetalleventa, categorias.nomcategoria, cajas.nrocaja, cajas.nombrecaja FROM detalleventas LEFT JOIN ventas ON ventas.codventa = detalleventas.codventa LEFT JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = ? AND ventas.codigo = '".$_SESSION["codigo"]."' ORDER BY detalleventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(date("Y-m-d",strtotime($_GET['fecha']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)	
		{ ?>

	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.info("No existen ventas en la fecha ingresada","No hay datos");
	</script>

	<?php
		
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS EN LA FECHA INGRESADA !</div></center>";
	exit;
		       } else {

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;

		         }
		  }
	 }
}
################################# FUNCION BUSQUEDA DETALLES DE VENTAS ##################################

############################ FUNCION PARA VER DETALLES DE VENTAS ############################
public function VerDetallesVentas()
{
	self::SetNames();
	$sql = " SELECT * FROM detalleventas INNER JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria WHERE detalleventas.codventa = ?";	
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(base64_decode($_GET["codventa"])));
	$stmt->execute();
	$num = $stmt->rowCount();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
############################ FUNCION PARA VER DETALLES DE VENTAS ############################

############################ FUNCION PARA ID DETALLES DE VENTAS ############################
public function DetallesVentasPorId()
{
	self::SetNames();
	$sql = " SELECT detalleventas.coddetalleventa, detalleventas.codventa, detalleventas.codcliente as cliente, detalleventas.codproducto, detalleventas.producto, detalleventas.codcategoria, detalleventas.cantventa, detalleventas.precioventa, detalleventas.preciocompra, detalleventas.importe, detalleventas.importe2, detalleventas.fechadetalleventa, categorias.nomcategoria, productos.ivaproducto, productos.existencia, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, usuarios.nombres FROM detalleventas INNER JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria LEFT JOIN clientes ON detalleventas.codcliente = clientes.codcliente LEFT JOIN productos ON detalleventas.codproducto = productos.codproducto LEFT JOIN usuarios ON detalleventas.codigo = usuarios.codigo WHERE detalleventas.coddetalleventa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["coddetalleventa"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################ FUNCION PARA ID DETALLES DE VENTAS ############################

############################ FUNCION PARA ACTUALIZAR VENTAS ############################
public function ActualizarDetallesVentas()
{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["cantventa"]))
	{
		echo "1";
		exit;
	}

	$sql = "select existencia from productos where codproducto = '".$_POST["codproducto"]."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		
		$existenciadb = $row['existencia'];
		$cantventa = $_POST["cantventa"];
		$cantidadventadb = $_POST["cantidadventadb"];

		$total = $_POST["cantventa"]-$_POST["cantidadventadb"];

		if ($total > $existenciadb) 
		{ 
			echo "2";
			exit;
		}



	/*$sql2 = " SELECT * from detalleventas where coddetalleventa = ? and codventa = ?";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->execute( array($_POST["coddetalleventa"], $_POST["codventa"]) );
	$num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$pa[] = $row;
		}
		$cantidadventadb = $pa[0]["cantventa"];*/

###################### ACTUALIZAMOS EL DETALLE DEL PRODUCTO ############################
		$sql = " UPDATE detalleventas set "
		." cantventa = ?, "
		." precioventa = ?, "
		." importe = ?, "
		." importe2 = ? "
		." where "
		." coddetalleventa = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $cantventa);
		$stmt->bindParam(2, $precioventa);
		$stmt->bindParam(3, $importeventa);
		$stmt->bindParam(4, $importecompra);
		$stmt->bindParam(5, $coddetalleventa);

		$cantventa = strip_tags($_POST["cantventa"]);
		$precioventa = strip_tags($_POST["precioventa"]);
		$importeventa = strip_tags($_POST["importe"]);
		$importecompra = strip_tags($_POST["importe2"]);
		$coddetalleventa = strip_tags($_POST["coddetalleventa"]);
		$stmt->execute();

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
		$sql2 = " update productos set "
		." existencia = ? "
		." where "
		." codproducto = ?;
		";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $stocktotal);
		$stmt->bindParam(2, $codproducto);

		$codproducto = strip_tags($_POST["codproducto"]);
		$cantidad = strip_tags($_POST["cantventa"]);
		//$existenciadb = strip_tags($_POST["existencia"]);
		$calculoventa=$cantventa - $_POST["cantidadventadb"];
		$stocktotal = $existenciadb - $calculoventa;
		$stmt->execute();

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ############################		
		$sql2 = " update kardexproductos set "
		." salidas = ?, "
		." preciom = ?, "
		." costototal = ? "
		." where "
		." codproceso = ? and codproducto = ?;
		";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $salidas);
		$stmt->bindParam(2, $preciounit);
		$stmt->bindParam(3, $costototal);
		$stmt->bindParam(4, $codventa);
		$stmt->bindParam(5, $codproducto);

		$salidas = strip_tags($_POST["cantventa"]);
		$preciounit = strip_tags($_POST["precioventa"]);
		$codventa = strip_tags($_POST["codigoventa"]);
		$codproducto = strip_tags($_POST["codproducto"]);
		$costototal = strip_tags($_POST["cantventa"] * $_POST["precioventa"]);
		$stmt->execute();

################### CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS REGISTRADOS #######################
$sql = "select * from productosvsingredientes where codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codproducto"]));
		$num = $stmt->rowCount();
if($num>0) {


	$sql = "select * from productosvsingredientes LEFT JOIN ingredientes ON productosvsingredientes.codingrediente = ingredientes.codingrediente where productosvsingredientes.codproducto = '".$_POST["codproducto"]."'";

	    $array=array();

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;

			$codproducto = $row['codproducto'];
			$codingrediente = $row['codingrediente'];
			$cantracion = $row['cantracion'];
			$cantingrediente = $row['cantingrediente'];
			$costoingrediente = $row['costoingrediente'];


			$update = " update ingredientes set "
			." cantingrediente = ? "
			." where "
			." codingrediente = ?;
			";
			$stmt = $this->dbh->prepare($update);
			$stmt->bindParam(1, $cantidadracion);
			$stmt->bindParam(2, $codingrediente);

			$racion = rount($cantracion*$_POST["cantventa"],2);
			$cantidadracion = rount($cantingrediente-$racion,2);
			$stmt->execute();


if($_POST["cantventa"]!=$_POST["cantidadventadb"]) { 

##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ##################			
					$sql2 = " update kardexingredientes set "
					." salidasing = ?, "
					." stockactualing = ?, "
					." preciouniting = ?, "
					." costototaling = ? "
					." where "
					." codprocesoing = ? and codproducto = ? and codingrediente = ?;
					";
		            $stmt = $this->dbh->prepare($sql2);
					$stmt->bindParam(1, $salidasing);
					$stmt->bindParam(2, $stockactualing);
					$stmt->bindParam(3, $preciouniting);
					$stmt->bindParam(4, $costototaling);
					$stmt->bindParam(5, $codventa);
					$stmt->bindParam(6, $codproducto);
					$stmt->bindParam(7, $codingrediente);

					$salidasing = rount($cantracion*$_POST["cantventa"],2);
					$stockactualing = rount($cantingrediente-$racion,2);
					$preciouniting = strip_tags($costoingrediente);
					$costototaling = strip_tags($costoingrediente * $_POST["cantventa"]);
		            $codventa = strip_tags($_POST["codigoventa"]);
					$codproducto = strip_tags($codproducto);
					$codingrediente = strip_tags($codingrediente);
					$stmt->execute();
	##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX #####################
				}

		 }

}
############ FIN DE CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS ###############


		$sql4 = "select * from ventas where idventa = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array($_POST["codigoventa"]) );
		$num = $stmt->rowCount();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$paea[] = $row;
			}
		$subtotalivasive = $paea[0]["subtotalivasive"];
		$subtotalivanove = $paea[0]["subtotalivanove"];
		$iva = $paea[0]["ivave"]/100;
		$descuento = $paea[0]["descuentove"]/100;
		$totalivave = $paea[0]["totalivave"];
		$totaldescuentove = $paea[0]["totaldescuentove"];
		$tipopagove = $paea[0]["tipopagove"];
		$codcaja = $paea[0]["codcaja"];
		$totalpago = $paea[0]["totalpago"];
		$montopagado = $paea[0]["montopagado"];
			
	   
$sql3 = "select sum(importe) as importe, sum(importe2) as importe2 from detalleventas where codventa = ? and ivaproducto = 'SI'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array($_POST["idventa"]));
		$num = $stmt->rowCount();
		 
		if($row = $stmt->fetch())
			{
				$pae[] = $row;
			}
		$importeivasi = ($pae[0]["importe"]== "" ? "0" : $pae[0]["importe"]);
		$importe2 = ($pae[0]["importe2"]== "" ? "0" : $pae[0]["importe2"]);

			
$sql5 = "select sum(importe) as importe, sum(importe2) as importe2 from detalleventas where codventa = ?  and ivaproducto = 'NO'";
		$stmt = $this->dbh->prepare($sql5);
		$stmt->execute( array($_POST["idventa"]));
		$num = $stmt->rowCount();
		 
		 if($roww = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $roww;
			}
		$importeivano = ($roww["importe"]== "" ? "0" : $roww["importe"]);
		$importe2 = ($roww["importe2"]== "" ? "0" : $roww["importe2"]);

				
		$sql = " update ventas set "
			  ." subtotalivasive = ?, "
			  ." subtotalivanove = ?, "
			  ." totalivave = ?, "
			  ." totaldescuentove = ?, "
			  ." totalpago= ?, "
			  ." montodevuelto= ? "
			  ." where "
			  ." idventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $subtotalivasive);
        $stmt->bindParam(2, $subtotalivanove);
        $stmt->bindParam(3, $totalivave);
		$stmt->bindParam(4, $totaldescuentove);
		$stmt->bindParam(5, $total);
		$stmt->bindParam(6, $devuelto);
		$stmt->bindParam(7, $codventa);
		
		$subtotalivasive= strip_tags($importeivasi);
        $subtotalivanove= strip_tags($importeivano);
        $totalivave= rount($subtotalivasive*$iva,2);
        $tot= rount($subtotalivasive+$subtotalivanove+$totalivave,2);
		$totaldescuentove= rount($tot*$descuento,2);
		$total= rount($tot-$totaldescuentove,2);
		$devuelto= ($montopagado== "0.00" ? "0" : rount($montopagado-$total,2));
		$codventa = strip_tags($_POST["codigoventa"]);
		$stmt->execute();

#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
	if ($tipopagove=="CONTADO"){

		$sql = "select ingresos from arqueocaja where codcaja = '".$codcaja."' and statusarqueo = '1'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		//if (isset($row['ingresos'])) { $ingreso = $row['ingresos']; } else { $ingreso ='0.00'; }
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);

		$sql = " update arqueocaja set "
		." ingresos = ? "
		." where "
		." codcaja = '".$codcaja."' and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);

		$monto = rount($totalpago-$total,2);
		$txtTotal = rount($ingreso-$monto,2);
		$stmt->execute();
	}
#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
		

echo "<div class='alert alert-success'>";
echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
echo "<span class='fa fa-check-square-o'></span> EL DETALLE DE VENTA FUE ACTUALIZADO EXITOSAMENTE <a href='reportepdf?codventa=".base64_encode($_POST["idventa"])."&tipo=".base64_encode("TICKET")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black' rel='noopener noreferrer'><strong>IMPRIMIR TICKET</strong></a></div>";
		exit;

			}
############################ FUNCION PARA ACTUALIZAR VENTAS ############################


############################ FUNCION PARA ELIMINAR DETALLES DE VENTAS  ########################
public function EliminarDetallesVentas()
{
	if($_SESSION['acceso'] == "administrador") {

		self::SetNames();

		$sql = " select * from detalleventas where codventa = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(strip_tags($_GET["codventa"])) );
		$num = $stmt->rowCount();
		if($num > 1)
		{

	$sql2 = "select existencia from productos where codproducto = ?";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->execute( array(base64_decode($_GET["codproducto"])));
	$num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
	$existenciadb = $p[0]["existencia"];

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
	$sql = " update productos set "
	." existencia = ? "
	." where "
	." codproducto = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$stmt->bindParam(2, $codproducto);
	$cantventa = strip_tags(base64_decode($_GET["cantventa"]));
	$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
	$existencia = $existenciadb + $cantventa;
	$stmt->execute();

	$sql = " delete from detalleventas where coddetalleventa = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$coddetalleventa);
	$coddetalleventa = base64_decode($_GET["coddetalleventa"]);
	$stmt->execute();

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
	$sql = " delete from kardexproductos where codproceso = ? and codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codventa);
	$stmt->bindParam(2,$codproducto);
	$codventa = strip_tags(strip_tags($_GET["codventa"]));
	$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
	$stmt->execute();

################## CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS #################
$sql = "select * from productosvsingredientes where codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($codproducto));
		$num = $stmt->rowCount();
        if($num>0) {

$sql = "select * from productosvsingredientes LEFT JOIN ingredientes ON productosvsingredientes.codingrediente = ingredientes.codingrediente where productosvsingredientes.codproducto = '".$codproducto."'";

	$array=array();

		foreach ($this->dbh->query($sql) as $row)
		{
		$this->p[] = $row;

		$codproducto = $row['codproducto'];
		$codingrediente = $row['codingrediente'];
		$cantracion = $row['cantracion'];
		$cantingrediente = $row['cantingrediente'];
		$costoingrediente = $row['costoingrediente'];

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
		$sql = " delete from kardexingredientes where codprocesoing = ? and codproducto = ? and codingrediente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$stmt->bindParam(2,$codproducto);
		$stmt->bindParam(3,$codingrediente);
		$codventa = strip_tags(strip_tags($_GET["codventa"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$codingrediente = strip_tags($codingrediente);
		$stmt->execute();

		$update = " update ingredientes set "
		." cantingrediente = ? "
		." where "
		." codingrediente = ?;
		";
		$stmt = $this->dbh->prepare($update);
		$stmt->bindParam(1, $cantidadracion);
		$stmt->bindParam(2, $codingrediente);

		$cantventa = strip_tags(base64_decode($_GET["cantventa"]));
		$racion = rount($cantracion*$cantventa,2);
		$cantidadracion = rount($cantingrediente+$racion,2);
		$stmt->execute();

		 }
}
############ FIN DE CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS REGISTRADOS ##############

	$sql4 = "select * from ventas where codventa = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array(strip_tags($_GET["codventa"])) );
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$subtotalivasive = $paea[0]["subtotalivasive"];
		$subtotalivanove = $paea[0]["subtotalivanove"];
		$iva = $paea[0]["ivave"]/100;
		$descuento = $paea[0]["descuentove"]/100;
		$totalivave = $paea[0]["totalivave"];
		$totaldescuentove = $paea[0]["totaldescuentove"];
		$totaldb = $paea[0]["totalpago"];
		$montopagado = $paea[0]["montopagado"];
			
		
$sql3 = "select sum(importe) as importe, sum(importe2) as importe2, sum(preciocompra) as preciocompra from detalleventas where codventa = ? and ivaproducto = 'SI'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array(strip_tags($_GET["codventa"])));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pae[] = $row;
			}
		$preciocompraiva = ($pae[0]["preciocompra"]== "" ? "0" : $pae[0]["preciocompra"]);
		$importeivasi = ($pae[0]["importe"]== "" ? "0" : $pae[0]["importe"]);
		$importe2si = ($pae[0]["importe2"]== "" ? "0" : $pae[0]["importe2"]);
	
$sql5 = "select sum(importe) as importe, sum(importe2) as importe2, sum(preciocompra) as preciocompra from detalleventas where codventa = ?  and ivaproducto = 'NO'";
		$stmt = $this->dbh->prepare($sql5);
		$stmt->execute( array(strip_tags($_GET["codventa"])));
		$num = $stmt->rowCount();
		 
		 if($roww = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $roww;
			}
		$preciocompra = ($roww["preciocompra"]== "" ? "0" : $roww["preciocompra"]);
		$importeivano = ($roww["importe"]== "" ? "0" : $roww["importe"]);
		$importe2 = ($roww["importe2"]== "" ? "0" : $roww["importe2"]);
		
if(base64_decode($_GET["ivaproducto"])=="SI"){	

		$sql = " update ventas set "
			  ." subtotalivasive = ?, "
			  ." totalivave = ?, "
			  ." totaldescuentove = ?, "
			  ." totalpago= ?, "
			  ." montodevuelto= ? "
			  ." where "
			  ." codventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaliva);
		$stmt->bindParam(3, $totaldescuentove);
		$stmt->bindParam(4, $totalpago);
		$stmt->bindParam(5, $devuelto);
		$stmt->bindParam(6, $codventa);
		
		$subtotal= strip_tags($importeivasi);
        $totaliva= rount($subtotal*$iva,2);
		$tot= rount($subtotal+$subtotalivanove+$totaliva,2);
		$totaldescuentove= rount($tot*$descuento,2);
		$totalpago= rount($tot-$totaldescuentove,2);
		$devuelto= ($montopagado== "0.00" ? "0" : rount($montopagado-$totalpago,2));
		$codventa = strip_tags($_GET["codventa"]);
		$stmt->execute();

#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
if (base64_decode($_GET["tipopagove"])=="CONTADO"){

$sql = "select ingresos from arqueocaja where codcaja = '".strip_tags($_GET["codcaja"])."' and statusarqueo = '1'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);

		$sql = " update arqueocaja set "
		." ingresos = ? "
		." where "
		." codcaja = ? and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codcaja);

		$calculo=rount($totaldb-$totalpago,2);
		$txtTotal = rount($ingreso-$calculo,2);
		$codcaja = strip_tags($_GET["codcaja"]);
		$stmt->execute();
	}
#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
		
		                            } else {

    $sql = " update ventas set "
			  ." subtotalivanove = ?, "
			  ." totaldescuentove = ?, "
			  ." totalpago= ?, "
			  ." montodevuelto= ? "
			  ." where "
			  ." codventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaldescuentove);
		$stmt->bindParam(3, $totalpago);
		$stmt->bindParam(4, $devuelto);
		$stmt->bindParam(5, $codventa);
		
		$subtotal= strip_tags($importeivano);
		$tot= rount($subtotal+$subtotalivasive+$totalivave,2);
		$totaldescuentove= rount($tot*$descuento,2);
		$totalpago= rount($tot-$totaldescuentove,2);
		$devuelto= ($montopagado== "0.00" ? "0" : rount($montopagado-$totalpago,2));
		$codventa = strip_tags($_GET["codventa"]);
		$stmt->execute();

#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
if (base64_decode($_GET["tipopagove"])=="CONTADO"){

$sql = "select ingresos from arqueocaja where codcaja = '".strip_tags($_GET["codcaja"])."' and statusarqueo = '1'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$ingreso = ($row['ingresos']== "" ? "0.00" : $row['ingresos']);

		$sql = " update arqueocaja set "
		." ingresos = ? "
		." where "
		." codcaja = ? and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codcaja);

		$calculo=rount($totaldb-$totalpago,2);
		$txtTotal = rount($ingreso-$calculo,2);
		$codcaja = strip_tags($_GET["codcaja"]);
		$stmt->execute();
	}
#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
		
	 } ?>

	 <script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.success("Detalle de venta eliminado con exito","Datos eliminados");
	</script>
		<?php }
		else
		{

			$sql2 = "select existencia from productos where codproducto = ?";
			$stmt = $this->dbh->prepare($sql2);
			$stmt->execute( array(base64_decode($_GET["codproducto"])));
			$num = $stmt->rowCount();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $row;
			}
			$existenciadb = $p[0]["existencia"];

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
			$sql = " update productos set "
			." existencia = ? "
			." where "
			." codproducto = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$stmt->bindParam(2, $codproducto);
			$cantventa = strip_tags(base64_decode($_GET["cantventa"]));
			$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
			$existencia = $existenciadb + $cantventa;
			$stmt->execute();

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
			$sql = " delete from kardexproductos where codproceso = ? and codproducto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codventa);
			$stmt->bindParam(2,$codproducto);
			$codventa = strip_tags(strip_tags($_GET["codventa"]));
			$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
			$stmt->execute();


################## CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS #######################
$sql = "select * from productosvsingredientes where codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($codproducto));
		$num = $stmt->rowCount();
if($num>0) {


	$sql = "select * from productosvsingredientes LEFT JOIN ingredientes ON productosvsingredientes.codingrediente = ingredientes.codingrediente where productosvsingredientes.codproducto = '".$codproducto."'";

	$array=array();

	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;

		$codproducto = $row['codproducto'];
		$codingrediente = $row['codingrediente'];
		$cantracion = $row['cantracion'];
		$cantingrediente = $row['cantingrediente'];
		$costoingrediente = $row['costoingrediente'];

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
		$sql = " delete from kardexingredientes where codprocesoing = ? and codproducto = ? and codingrediente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$stmt->bindParam(2,$codproducto);
		$stmt->bindParam(3,$codingrediente);
		$codventa = strip_tags(strip_tags($_GET["codventa"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$codingrediente = strip_tags($codingrediente);
		$stmt->execute();


		$update = " update ingredientes set "
		." cantingrediente = ? "
		." where "
		." codingrediente = ?;
		";
		$stmt = $this->dbh->prepare($update);
		$stmt->bindParam(1, $cantidadracion);
		$stmt->bindParam(2, $codingrediente);

		$cantventa = strip_tags(base64_decode($_GET["cantventa"]));
		$racion = rount($cantracion*$cantventa,2);
		$cantidadracion = rount($cantingrediente+$racion,2);
		$stmt->execute();


		 }

}
################### FIN DE CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS ###################

		$sql = " delete from ventas where codventa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$codventa = strip_tags($_GET["codventa"]);
		$stmt->execute();

		$sql = " delete from detalleventas where coddetalleventa = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetalleventa);
		$coddetalleventa = base64_decode($_GET["coddetalleventa"]);
		$stmt->execute();

					#################### AQUI ACTUALIZAMOS EL STATUS DE MESA ####################
		$sql = " update mesas set "
		." statusmesa = ? "
		." where "
		." codmesa = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $statusmesa);
		$stmt->bindParam(2, $codmesa);

		$statusmesa = strip_tags('0');
		$codmesa = base64_decode($_GET["codmesa"]);
		$stmt->execute();
#################### AQUI ACTUALIZAMOS EL STATUS DE MESA ####################

#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA ####################
	if (base64_decode($_GET["tipopagove"])=="CONTADO"){

		$sql = "select ingresos from arqueocaja where codcaja = '".$codcaja."' and statusarqueo = '1'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		if (isset($row['ingresos'])) { $ingreso = $row['ingresos']; } else { $ingreso ='0.00'; }
		//$ingreso = $row['ingresos'];

		$sql = " update arqueocaja set "
		." ingresos = ? "
		." where "
		." codcaja = '".$codcaja."' and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);

		$monto = strip_tags($totalpago-$total);
		$txtTotal = strip_tags($ingreso-$monto);
		$stmt->execute();
	}
#################### AQUI AGREGAMOS EL INGRESO A ARQUEO DE CAJA #################### ?>

	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.success("Detalle de venta eliminado con exito","Datos eliminados");
	</script>
			<?php }
		}
		else
		{ ?>

	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.error("No tiene permiso para eliminar","Sin permisos");
	</script>
		<?php }
	}
############################ FUNCION PARA ELIMINAR DETALLES DE VENTAS  ########################


###################### FUNCION PARA ELIMINAR DETALLES DE VENTAS EN PEDIDOS  ######################
public function EliminarDetallesVentasPedidosProductos()
{		
	self::SetNames();
	$sql = " select * from detalleventas where codventa = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codventa"])) );
	$num = $stmt->rowCount();
	if($num > 1)
	{

		$sql2 = "select existencia from productos where codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array(base64_decode($_GET["codproducto"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $row;
			}
			$existenciadb = $p[0]["existencia"];

			$sql = " delete from detalleventas where coddetalleventa = ? ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$coddetalleventa);
			$coddetalleventa = base64_decode($_GET["coddetalleventa"]);
			$stmt->execute();

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
			$sql = " update productos set "
			." existencia = ? "
			." where "
			." codproducto = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$stmt->bindParam(2, $codproducto);
			$cantventa = strip_tags(base64_decode($_GET["cantventa"]));
			$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
			$existencia = $existenciadb + $cantventa;
			$stmt->execute();

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
			$sql = " delete from kardexproductos where codproceso = ? and codproducto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codventa);
			$stmt->bindParam(2,$codproducto);
			$codventa = strip_tags(base64_decode($_GET["codventa"]));
			$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
			$stmt->execute();

################## CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS #######################
$sql = "select * from productosvsingredientes where codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($codproducto));
		$num = $stmt->rowCount();
if($num>0) {


	$sql = "select * from productosvsingredientes LEFT JOIN ingredientes ON productosvsingredientes.codingrediente = ingredientes.codingrediente where productosvsingredientes.codproducto = '".$codproducto."'";

	    $array=array();

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;

			$codproducto = $row['codproducto'];
			$codingrediente = $row['codingrediente'];
			$cantracion = $row['cantracion'];
			$cantingrediente = $row['cantingrediente'];
			$costoingrediente = $row['costoingrediente'];

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
		$sql = " delete from kardexingredientes where codprocesoing = ? and codproducto = ? and codingrediente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$stmt->bindParam(2,$codproducto);
		$stmt->bindParam(3,$codingrediente);
		$codventa = strip_tags(base64_decode($_GET["codventa"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$codingrediente = strip_tags($codingrediente);
		$stmt->execute();


			$update = " update ingredientes set "
			." cantingrediente = ? "
			." where "
			." codingrediente = ?;
			";
			$stmt = $this->dbh->prepare($update);
			$stmt->bindParam(1, $cantidadracion);
			$stmt->bindParam(2, $codingrediente);

			$cantventa = strip_tags(base64_decode($_GET["cantventa"]));
			$racion = rount($cantracion*$cantventa,2);
			$cantidadracion = rount($cantingrediente+$racion,2);
			$stmt->execute();


		 }

}
################### FIN DE CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS #################


			$sql4 = "select * from ventas where codventa = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array(base64_decode($_GET["codventa"])) );
		$num = $stmt->rowCount();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$paea[] = $row;
			}
			$subtotalivasive = $paea[0]["subtotalivasive"];
			$subtotalivanove = $paea[0]["subtotalivanove"];
			$iva = $paea[0]["ivave"]/100;
			$descuento = $paea[0]["descuentove"]/100;
			$totalivave = $paea[0]["totalivave"];
			$totaldescuentove = $paea[0]["totaldescuentove"];
			
		
$sql3 = "select sum(importe) as importe, sum(importe2) as importe2, sum(preciocompra) as preciocompra from detalleventas where codventa = ? and ivaproducto = 'SI'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array(base64_decode($_GET["codventa"])));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $row;
			}
		$preciocompraiva = $row["preciocompra"];
		$importeiva = $row["importe"];
		$importe2iva = $row["importe2"];
	
$sql5 = "select sum(importe) as importe, sum(importe2) as importe2, sum(preciocompra) as preciocompra from detalleventas where codventa = ?  and ivaproducto = 'NO'";
		$stmt = $this->dbh->prepare($sql5);
		$stmt->execute( array(base64_decode($_GET["codventa"])));
		$num = $stmt->rowCount();
		 
		 if($rov = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pae[] = $rov;
			}
		$preciocompra = $rov["preciocompra"];
		$importe = $rov["importe"];
		$importe2 = $rov["importe2"];
		
		$sql = " update ventas set "
			  ." subtotalivasive = ?, "
			  ." subtotalivanove = ?, "
			  ." totalivave = ?, "
			  ." totaldescuentove = ?, "
			  ." totalpago= ?, "
			  ." totalpago2= ? "
			  ." where "
			  ." codventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasive);
		$stmt->bindParam(2, $subtotalivanove);
		$stmt->bindParam(3, $totaliva);
		$stmt->bindParam(4, $totaldescuentove);
		$stmt->bindParam(5, $total);
		$stmt->bindParam(6, $total2);
		$stmt->bindParam(7, $codventa);
		
		$subtotalivasive= rount($importeiva,2);
		$subtotalivanove= rount($importe,2);
        $totaliva= rount($subtotalivasive*$iva,2);
		$tot= rount($subtotalivasive+$subtotalivanove+$totaliva,2);
		$totaldescuentove= rount($tot*$descuento,2);
		$total= rount($tot-$totaldescuentove,2);
		$total2= rount($preciocompra,2);
		$codventa = strip_tags(base64_decode($_GET["codventa"]));
		$stmt->execute();

						unset($_SESSION["CarritoVentas"]);

	?>	
		<script type="text/javascript">
			toastr.options = {
				"closeButton":true,
				"progressBar": true
			};
			toastr.success("El pedido de productos fue eliminado","Datos eliminados");
		</script>

		<!--<script type='text/javascript' language='javascript'>
	    alert('EL PEDIDO DE PRODUCTOS FUE ELIMINADOS, \nDE LA MESA EXITOSAMENTE')  
        </script> -->
		<?php 
			exit;

						/*echo "<div class='alert alert-info'>";
						echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
						echo "<center><span class='fa fa-check-square-o'></span> EL PEDIDO FUE ELIMINADO EXITOSAMENTE </center>";
						echo "</div>"; 
						exit;*/
					}
					else
					{

						$sql2 = "select existencia from productos where codproducto = ?";
						$stmt = $this->dbh->prepare($sql2);
						$stmt->execute( array(base64_decode($_GET["codproducto"])));
						$num = $stmt->rowCount();

						if($row = $stmt->fetch(PDO::FETCH_ASSOC))
							{
								$p[] = $row;
							}
							$existenciadb = $p[0]["existencia"];

###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
							$sql = " update productos set "
							." existencia = ? "
							." where "
							." codproducto = ?;
							";
							$stmt = $this->dbh->prepare($sql);
							$stmt->bindParam(1, $existencia);
							$stmt->bindParam(2, $codproducto);
							$cantventa = strip_tags(base64_decode($_GET["cantventa"]));
							$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
							$existencia = $existenciadb + $cantventa;
							$stmt->execute();

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
							$sql = " delete from kardexproductos where codproceso = ? and codproducto = ?";
							$stmt = $this->dbh->prepare($sql);
							$stmt->bindParam(1,$codventa);
							$stmt->bindParam(2,$codproducto);
							$codventa = strip_tags(base64_decode($_GET["codventa"]));
							$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
							$stmt->execute();


################## CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS #######################
$sql = "select * from productosvsingredientes where codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($codproducto));
		$num = $stmt->rowCount();
if($num>0) {


	$sql = "select * from productosvsingredientes LEFT JOIN ingredientes ON productosvsingredientes.codingrediente = ingredientes.codingrediente where productosvsingredientes.codproducto = '".$codproducto."'";

	    $array=array();

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;

			$codproducto = $row['codproducto'];
			$codingrediente = $row['codingrediente'];
			$cantracion = $row['cantracion'];
			$cantingrediente = $row['cantingrediente'];
			$costoingrediente = $row['costoingrediente'];

###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
		$sql = " delete from kardexingredientes where codprocesoing = ? and codproducto = ? and codingrediente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$stmt->bindParam(2,$codproducto);
		$stmt->bindParam(3,$codingrediente);
		$codventa = strip_tags(base64_decode($_GET["codventa"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$codingrediente = strip_tags($codingrediente);
		$stmt->execute();


			$update = " update ingredientes set "
			." cantingrediente = ? "
			." where "
			." codingrediente = ?;
			";
			$stmt = $this->dbh->prepare($update);
			$stmt->bindParam(1, $cantidadracion);
			$stmt->bindParam(2, $codingrediente);

			$cantventa = strip_tags(base64_decode($_GET["cantventa"]));
			$racion = rount($cantracion*$cantventa,2);
			$cantidadracion = rount($cantingrediente+$racion,2);
			$stmt->execute();


		 }

}
################### FIN DE CONSULTO LA TABLA PARA VERIFICAR SI EXISTEN PRODUCTOS ###################


							$sql = " delete from ventas where codventa = ?";
							$stmt = $this->dbh->prepare($sql);
							$stmt->bindParam(1,$codventa);
							$codventa = base64_decode($_GET["codventa"]);
							$stmt->execute();

							$sql = " delete from detalleventas where coddetalleventa = ? ";
							$stmt = $this->dbh->prepare($sql);
							$stmt->bindParam(1,$coddetalleventa);
							$coddetalleventa = base64_decode($_GET["coddetalleventa"]);
							$stmt->execute();

#################### AQUI ACTUALIZAMOS EL STATUS DE MESA ####################
							$sql = " update mesas set "
							." statusmesa = ? "
							." where "
							." codmesa = ?;
							";
							$stmt = $this->dbh->prepare($sql);
							$stmt->bindParam(1, $statusmesa);
							$stmt->bindParam(2, $codmesa);

							$statusmesa = strip_tags('0');
							$codmesa = base64_decode($_GET["codmesa"]);
							$stmt->execute();
#################### AQUI ACTUALIZAMOS EL STATUS DE MESA ####################

?>

	<script type="text/javascript">
		toastr.options = {
			"closeButton":true,
			"progressBar": true
		};
		toastr.success("Los pedidos de productos han sido eliminados","Datos eliminados");
	</script>
		<!--<script type='text/javascript' language='javascript'>
	    alert('LOS PEDIDOS DE PRODUCTOS HAN SIDO ELIMINADOS, \nDE LA MESA EXITOSAMENTE')  
        </script> -->
		<?php 
			exit;

 /*echo "<div class='alert alert-info'>";
 echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
 echo "<center><span class='fa fa-check-square-o'></span> LOS PEDIDOS HAN SIDO ELIMINADOS DE LA MESA EXITOSAMENTE </center>";
 echo "</div>"; 
 exit;*/
						}
					}
###################### FUNCION PARA ELIMINAR DETALLES DE VENTAS EN PEDIDOS  ######################


################# FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS POR FECHAS Y CAJAS #################
public function BuscarVentasCajas() 
{
	self::SetNames();
	$sql ="SELECT detalleventas.codventa, cajas.nrocaja, ventas.idventa, ventas.codcliente, ventas.codcaja, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave,  ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, SUM(detalleventas.cantventa) as articulos FROM (detalleventas LEFT JOIN ventas ON detalleventas.fechadetalleventa=ventas.fechaventa) 
	LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE ventas.codcaja = ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codcaja']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{ ?>

		<script type="text/javascript">
			toastr.options = {
				"closeButton":true,
				"progressBar": true
			};
			toastr.info("No existen ventas con los criterios indicados","No hay datos");
		</script>

		<?php
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN VENTAS DE PRODUCTOS PARA LA CAJA Y EL RANGO DE FECHAS SELECCIONADAS</center>";
		echo "</div>";
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################# FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS POR FECHAS Y CAJAS #################

################ FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS POR FECHAS ####################
	public function BuscarVentasFechas() 
	{
		self::SetNames();
		$sql ="SELECT detalleventas.codventa, cajas.nrocaja, ventas.idventa, ventas.codcaja, ventas.codcliente, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave,  ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, SUM(detalleventas.cantventa) as articulos FROM (detalleventas LEFT JOIN ventas ON detalleventas.fechadetalleventa=ventas.fechaventa) 
		LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? GROUP BY detalleventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{ ?>

			<script type="text/javascript">
				toastr.options = {
					"closeButton":true,
					"progressBar": true
				};
				toastr.info("No existen ventas con el rango de fechas","no hay datos");
			</script>

			<?php

			echo "<div class='alert alert-danger'>";
			echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
			echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN VENTAS DE PRODUCTOS PARA EL RANGO DE FECHAS SELECCIONADAS</center>";
			echo "</div>";
			exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$this->p[]=$row;
				}
				return $this->p;
				$this->dbh=null;
			}
		}
################ FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS POR FECHAS ####################

################## FUNCION PARA BUSQUEDA DE PRODUCTOS FACTURADOS POR FECHAS ###################
public function BuscarProductosVendidos() 
{
	self::SetNames();
	$sql ="SELECT productos.codproducto, productos.producto, productos.codcategoria, productos.precioventa, productos.existencia, categorias.nomcategoria, SUM(detalleventas.cantventa) as cantidad FROM (productos LEFT JOIN detalleventas ON productos.codproducto=detalleventas.codproducto) 
	LEFT JOIN categorias ON categorias.codcategoria=productos.codcategoria WHERE DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') <= ? GROUP BY detalleventas.codproducto, detalleventas.precioventa ORDER BY productos.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{ ?>

		<script type="text/javascript">
			toastr.options = {
				"closeButton":true,
				"progressBar": true
			};
			toastr.info("No exiten productos facturados","No hay datos");
		</script>

		<?php 
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS FACTURADOS PARA EL RANGO DE FECHAS SELECCIONADAS</center>";
		echo "</div>";
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################## FUNCION PARA BUSQUEDA DE PRODUCTOS FACTURADOS POR FECHAS ###################


#################### FUNCION PARA BUSQUEDA DE INGREDIENTES FACTURADOS POR FECHAS #################
public function BuscarIngredientesVendidos() 
{
	self::SetNames();
	$sql = "SELECT productos.codproducto, productos.producto, productos.codcategoria, productos.precioventa, productos.existencia, ingredientes.costoingrediente, ingredientes.codingrediente, ingredientes.nomingrediente, ingredientes.cantingrediente, productosvsingredientes.cantracion, detalleventas.cantventa, SUM(productosvsingredientes.cantracion*detalleventas.cantventa) as cantidades FROM productos INNER JOIN detalleventas ON productos.codproducto=detalleventas.codproducto INNER JOIN productosvsingredientes ON productos.codproducto=productosvsingredientes.codproducto LEFT JOIN ingredientes ON productosvsingredientes.codingrediente = ingredientes.codingrediente WHERE DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') <= ? GROUP BY ingredientes.codingrediente";

	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{ ?>

		<script type="text/javascript">
			toastr.options = {
				"closeButton":true,
				"progressBar": true
			};
			toastr.info("no existen ingredientes facturados","No hay datos");
		</script>

		<?php 
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN INGREDIENTES FACTURADOS PARA EL RANGO DE FECHAS SELECCIONADAS</center>";
		echo "</div>";
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
#################### FUNCION PARA BUSQUEDA DE INGREDIENTES FACTURADOS POR FECHAS #################




##################### FUNCION PARA BUSQUEDA DE ARQUEOS DE CAJAS POR FECHAS #####################
	public function BuscarArqueosCajasFechas() 
	{
		self::SetNames();
		$sql = " select * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja WHERE DATE_FORMAT(arqueocaja.fechaapertura,'%Y-%m-%d') >= ? AND DATE_FORMAT(arqueocaja.fechaapertura,'%Y-%m-%d') <= ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{ ?>

			<script type="text/javascript">
				toastr.options = {
					"closeButton":true,
					"progressBar": true
				};
				toastr.info("No existen arqueos con el rango de fechas","No hay datos");
			</script>

			<?php

			echo "<div class='alert alert-danger'>";
			echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
			echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN ARQUEOS DE CAJAS PARA EL RANGO DE FECHA SELECCIONADO</center>";
			echo "</div>";
			exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$this->p[]=$row;
				}
				return $this->p;
				$this->dbh=null;
			}
		}
##################### FUNCION PARA BUSQUEDA DE ARQUEOS DE CAJAS POR FECHAS #####################

################### FUNCION PARA BUSQUEDA DE MOVIMIENTOS DE CAJAS POR FECHAS ####################
	public function BuscarMovimientosCajasFechas() 
	{
		self::SetNames();
	$sql = " SELECT * FROM movimientoscajas INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja WHERE movimientoscajas.codcaja = ? AND DATE_FORMAT(movimientoscajas.fechamovimientocaja,'%Y-%m-%d') >= ? AND DATE_FORMAT(movimientoscajas.fechamovimientocaja,'%Y-%m-%d') <= ?";
		$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codcaja']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{ ?>

			<script type="text/javascript">
				toastr.options = {
					"closeButton":true,
					"progressBar": true
				};
				toastr.info("No existen movimientos con el rango de fechas","No hay datos");
			</script>

			<?php 

			echo "<div class='alert alert-danger'>";
			echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
			echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN MOVIMIENTOS DE ESTA CAJA PARA EL RANGO DE FECHA SELECCIONADO</center>";
			echo "</div>";
			exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$this->p[]=$row;
				}
				return $this->p;
				$this->dbh=null;
			}
		}
################### FUNCION PARA BUSQUEDA DE MOVIMIENTOS DE CAJAS POR FECHAS ####################

################################# FUNCION PARA SUMAR VENTAS #################################
public function SumarVentas() 
{
	self::SetNames();
	$sql = "select sum(totalivave) as totaliva, sum(totalpago) as totalventa, sum(totalpago2) as totalcompra from ventas WHERE DATE_FORMAT(fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(fechaventa,'%Y-%m-%d') <= ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################# FUNCION PARA SUMAR VENTAS #################################

################################# FUNCION PARA SUMAR COMPRAS #################################
public function SumarCompras() 
{
	self::SetNames();
	$sql = "select sum(totalc) as totalcomprageneral from compras WHERE DATE_FORMAT(fechacompra,'%Y-%m-%d') >= ? AND DATE_FORMAT(fechacompra,'%Y-%m-%d') <= ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################# FUNCION PARA SUMAR COMPRAS #################################

###################### FUNCION PARA SUMAR INGRESOS EN VENTAS ##########################
public function SumarIngresos() 
{
	self::SetNames();
	$sql = "select sum(montomovimientocaja) as totalingresos from movimientoscajas where tipomovimientocaja = 'INGRESO' AND DATE_FORMAT(fechamovimientocaja,'%Y-%m-%d') >= ? AND DATE_FORMAT(fechamovimientocaja,'%Y-%m-%d') <= ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################### FUNCION PARA SUMAR INGRESOS EN VENTAS ##########################

######################### FUNCION PARA SUMAR EGRESOS EN VENTAS #################################
public function SumarEgresos() 
{
	self::SetNames();
	$sql = "select sum(montomovimientocaja) as totalegresos from movimientoscajas where tipomovimientocaja = 'EGRESO' AND DATE_FORMAT(fechamovimientocaja,'%Y-%m-%d') >= ? AND DATE_FORMAT(fechamovimientocaja,'%Y-%m-%d') <= ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
######################### FUNCION PARA SUMAR EGRESOS EN VENTAS #################################

####################### FUNCION PARA SUMAR ABONOS A CREDITOS ###############################
public function SumarAbonos() 
{
	self::SetNames();
	$sql = "select sum(montoabono) as totalabonos from abonoscreditos where DATE_FORMAT(fechaabono,'%Y-%m-%d') >= ? AND DATE_FORMAT(fechaabono,'%Y-%m-%d') <= ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
####################### FUNCION PARA SUMAR ABONOS A CREDITOS ###############################

####################### FUNCION PARA SUMAR CARTERA DE CREDITOS ###############################
public function SumarCarteraCreditos() 
{
	self::SetNames();
	$sql = "select
(select SUM(totalpago) from ventas WHERE tipopagove = 'CREDITO') as totaldebe,
(select SUM(montoabono) from abonoscreditos) as totalabono";
//$sql ="SELECT SUM(ventas.totalpago) as totaldebe, SUM(abonoscreditos.montoabono) FROM ventas, abonoscreditos WHERE ventas.tipopagove = 'CREDITO'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
####################### FUNCION PARA SUMAR CARTERA DE CREDITOS ###############################


########################## FUNCION PARA SUMAR VENTAS POR CAJAS #################################
public function SumarVentasCajas() 
{
	self::SetNames();
	$sql = "select sum(totalivave) as totaliva, sum(totalpago) as totalventa, sum(totalpago2) as totalcompra from ventas WHERE codcaja = ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codcaja']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
########################## FUNCION PARA SUMAR VENTAS POR CAJAS #################################


######################## FUNCION PARA SUMAR INGRESOS POR CAJAS #################################
public function SumarIngresosCajas() 
{
	self::SetNames();
	$sql = "select sum(montomovimientocaja) as totalingresos from movimientoscajas where tipomovimientocaja = 'INGRESO' AND codcaja = ?  AND DATE_FORMAT(fechamovimientocaja,'%Y-%m-%d') >= ? AND DATE_FORMAT(fechamovimientocaja,'%Y-%m-%d') <= ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codcaja']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
######################## FUNCION PARA SUMAR INGRESOS POR CAJAS #################################

######################## FUNCION PARA SUMAR EGRESOS POR CAJAS ##############################
public function SumarEgresosCajas() 
{
	self::SetNames();
	$sql = "select sum(montomovimientocaja) as totalegresos from movimientoscajas where tipomovimientocaja = 'EGRESO' AND codcaja = ? AND DATE_FORMAT(fechamovimientocaja,'%Y-%m-%d') >= ? AND DATE_FORMAT(fechamovimientocaja,'%Y-%m-%d') <= ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codcaja']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
######################## FUNCION PARA SUMAR EGRESOS POR CAJAS ##############################

####################### FUNCION PARA SUMAR ABONOS A CREDITOS ################################
public function SumarAbonosCajas() 
{
	self::SetNames();
	$sql = "select sum(montoabono) as totalabonos from abonoscreditos where codcaja = ? AND DATE_FORMAT(fechaabono,'%Y-%m-%d') >= ? AND DATE_FORMAT(fechaabono,'%Y-%m-%d') <= ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codcaja']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
####################### FUNCION PARA SUMAR ABONOS A CREDITOS ################################

############################# FUNCION PARA ENTREGA DE PEDIDOS #################################
	public function EntregarPedidos()
	{
		self::SetNames();
		
		$sql = " update ventas set "
			  ." cocinero = ? "
			  ." where "
			  ." codventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $cocinero);
		$stmt->bindParam(2, $codventa);
		
		$cocinero = strip_tags("0");
		$codventa = strip_tags(base64_decode($_GET["codventa"]));
		$sala = strip_tags(base64_decode($_GET["nombresala"]));
		$mesa = strip_tags(base64_decode($_GET["nombremesa"]));
		$stmt->execute();
		
        echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-check-square-o'></span> EL PEDIDO DE LA ".$sala." Y ".$mesa." FUE ENTREGADO EXITOSAMENTE </center>";
		echo "</div>"; 
		exit;
	
  }
############################# FUNCION PARA ENTREGA DE PEDIDOS #################################

############################### FIN DE CLASE VENTAS DE PRODUCTOS ##############################

















################################### CLASE ABONOS DE CREDITOS #####################################

######################## FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS #########################
public function BuscarClientesAbonos() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, ventas.codventa, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, abonoscreditos.fechaabono, SUM(abonoscreditos.montoabono) as abonototal, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.emailcliente, cajas.nrocaja
	FROM
	(ventas LEFT JOIN abonoscreditos ON ventas.codventa=abonoscreditos.codventa) LEFT JOIN clientes ON 
	clientes.codcliente=ventas.codcliente LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE ventas.codcliente = ? AND ventas.tipopagove ='CREDITO' GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array($_GET["codcliente"]) );
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{ ?>

		<script type="text/javascript">
			toastr.options = {
				"closeButton":true,
				"progressBar": true
			};
			toastr.info("No hay creditos para el cliente","No hay datos");
		</script>

		<?php
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN CREDITOS DE VENTAS PARA EL CLIENTE INGRESADO</center>";
		echo "</div>";
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
######################## FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS #########################

####################### FUNCION PARA BUSQUEDA PARA ABONOS DE CREDITOS #######################
public function BuscaAbonosCreditos() 
{
	self::SetNames();
	$sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, ventas.idventa, ventas.codventa, ventas.totalpago, ventas.statusventa, abonoscreditos.codventa as codigo, abonoscreditos.fechaabono, SUM(montoabono) AS abonototal FROM (clientes INNER JOIN ventas ON clientes.codcliente = ventas.codcliente) LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa WHERE clientes.cedcliente = ? AND ventas.codventa = ? AND ventas.tipopagove ='CREDITO'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(base64_decode($_GET['cedcliente'])));
	$stmt->bindValue(2, trim(base64_decode($_GET['codventa'])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
####################### FUNCION PARA BUSQUEDA PARA ABONOS DE CREDITOS #######################

######################## FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS POR ID #######################
public function AbonosCreditosId() 
{
	self::SetNames();
	$sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, ventas.idventa, ventas.codventa, ventas.totalpago, ventas.statusventa, abonoscreditos.codventa as codigo, abonoscreditos.fechaabono, SUM(montoabono) AS abonototal FROM (clientes INNER JOIN ventas ON clientes.codcliente = ventas.codcliente) LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa WHERE abonoscreditos.codabono = ? AND clientes.cedcliente = ? AND ventas.codventa = ? AND ventas.tipopagove ='CREDITO'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(base64_decode($_GET['codabono'])));
	$stmt->bindValue(2, trim(base64_decode($_GET['cedcliente'])));
	$stmt->bindValue(3, trim(base64_decode($_GET['codventa'])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
######################## FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS POR ID #######################

######################## FUNCION PARA REGISTRAR ABONOS DE PRODUCTOS ##########################
public function RegistrarAbonos()
{
	self::SetNames();
	if(empty($_POST["codcliente"]) or empty($_POST["codventa"]) or empty($_POST["montoabono"]))
	{
		echo "1";
		exit;
	}

	if($_POST["montoabono"] > $_POST["totaldebe"])
	{
		echo "2";
		exit;

	} else {

		$query = " insert into abonoscreditos values (null, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $montoabono);
		$stmt->bindParam(4, $fechaabono);
		$stmt->bindParam(5, $codigo);
		$stmt->bindParam(6, $codcaja);

		$codventa = strip_tags($_POST["codventa"]);
		$codcliente = strip_tags($_POST["codcliente"]);
		$montoabono = strip_tags($_POST["montoabono"]);
		$fechaabono = strip_tags(date("Y-m-d h:i:s"));
		$codigo = strip_tags($_SESSION["codigo"]);
		$codcaja = strip_tags($_SESSION["codcaja"]);
		$stmt->execute();


$sql = "select ingresos from arqueocaja where codcaja = '".$_SESSION["codcaja"]."' and statusarqueo = '1'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$ingreso = $row['ingresos'];

		$sql = " update arqueocaja set "
		." ingresos = ? "
		." where "
		." codcaja = ? and statusarqueo = '1';
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $codcaja);

		$txtTotal = strip_tags($_POST["montoabono"]+$ingreso);
		$codcaja = strip_tags($_SESSION["codcaja"]);
		$stmt->execute();


############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
		if($_POST["montoabono"] == $_POST["totaldebe"]) {

			$sql = " update ventas set "
			." statusventa = ? "
			." where "
			." codventa = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $statusventa);
			$stmt->bindParam(2, $codventa);

			$codventa = strip_tags($_POST["codventa"]);
			$statusventa = strip_tags("PAGADA");
			$stmt->execute();
		}

		echo "<div class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL ABONO AL CR&Eacute;DITO DE FACTURA FUE REGISTRADO EXITOSAMENTE <a href='reportepdf.php?codventa=".base64_encode($codventa)."&tipo=".base64_encode("TICKETCREDITOS")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Ticket' target='_black'><strong>IMPRIMIR TICKET</strong></a>";
		echo "</div>";
		exit;
	}
}
######################## FUNCION PARA REGISTRAR ABONOS DE PRODUCTOS ##########################

####################### FUNCION PARA LISTAR CREDITOS DE VENTAS  ########################## 
public function ListarCreditos()
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, ventas.codventa, ventas.totalpago, ventas.statusventa, abonoscreditos.fechaabono, SUM(abonoscreditos.montoabono) as abonototal, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.emailcliente, cajas.nrocaja
	FROM
	(ventas LEFT JOIN abonoscreditos ON ventas.codventa=abonoscreditos.codventa) LEFT JOIN clientes ON 
	clientes.codcliente=ventas.codcliente LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE ventas.tipopagove ='CREDITO' GROUP BY ventas.codventa";

	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
####################### FUNCION PARA LISTAR CREDITOS DE VENTAS  ########################## 

###################### FUNCION PARA MOSTRAR CREDITOS DE VENTAS POR CODIGO #####################
public function CreditosPorId()
{
	self::SetNames();
	$sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.direccliente, clientes.emailcliente, ventas.idventa, ventas.codventa, ventas.codcaja, ventas.codcliente, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.tipopagove, ventas.formapagove, ventas.fechaventa, ventas.fechavencecredito, ventas.statusventa, usuarios.nombres, cajas.nrocaja, abonoscreditos.codventa as cod, abonoscreditos.fechaabono, SUM(montoabono) AS abonototal FROM (ventas LEFT JOIN clientes ON clientes.codcliente = ventas.codcliente) LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo WHERE ventas.codventa =? GROUP BY cod";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute( array(base64_decode($_GET["codventa"])) );
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################### FUNCION PARA MOSTRAR CREDITOS DE VENTAS POR CODIGO #####################

############################# FUNCION PARA MOSTRAR DETALLES DE CREDITOS ##########################
public function VerDetallesCreditos()
{
	self::SetNames();
	$sql = " select * FROM abonoscreditos INNER JOIN ventas ON abonoscreditos.codventa = ventas.codventa WHERE abonoscreditos.codventa = ?";	
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(base64_decode($_GET["codventa"])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{ ?>

		<script type="text/javascript">
			toastr.options = {
				"closeButton":true,
				"progressBar": true
			};
			toastr.info("No existen abonos actualmente","No hay datos");
		</script>

		<?php 
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN ABONOS PARA CR&Eacute;DITOS ACTUALMENTE</center>";
		echo "</div>";
		exit;
	}
	else
	{

		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################# FUNCION PARA MOSTRAR DETALLES DE CREDITOS ##########################

########################## FUNCION PARA BUSQUEDA DE CREDITOS POR FECHAS #########################
public function BuscarCreditosFechas() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, ventas.codventa, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, abonoscreditos.fechaabono, SUM(abonoscreditos.montoabono) as abonototal, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.emailcliente, cajas.nrocaja
	FROM
	(ventas LEFT JOIN abonoscreditos ON ventas.codventa=abonoscreditos.codventa) LEFT JOIN clientes ON 
	clientes.codcliente=ventas.codcliente LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? AND ventas.tipopagove ='CREDITO' GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{ ?>

		<script type="text/javascript">
			toastr.options = {
				"closeButton":true,
				"progressBar": true
			};
			toastr.info("No existen creditos para el rango de fechas","No hay datos");
		</script>

		<?php
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN CREDITOS DE VENTAS PARA EL RANGO DE FECHA INGRESADO</center>";
		echo "</div>";
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
########################## FUNCION PARA BUSQUEDA DE CREDITOS POR FECHAS #########################

#################################### FIN DE CLASE ABONOS DE CREDITOS  ##############################





############################## FUNCION PARA CONTAR REGISTROS ############################
public function ContarRegistros()
	{
$sql = "select
(select count(*) from clientes where tipo1=1 and tienda='".$_SESSION['tienda']."' ) as contarclientes,
(select count(*) from clientes where tipo1=2 and tienda='".$_SESSION['tienda']."' ) as contarproveedores,
(select count(*) from products ) as contarproductos,
(select count(*) from facturas where estado_factura<=2 and tienda='".$_SESSION['tienda']."' ) as contarfacturas";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
############################## FUNCION PARA CONTAR REGISTROS ############################




}
############################## AQUI TERMINA LA CLASE LOGIN ##############################
?>