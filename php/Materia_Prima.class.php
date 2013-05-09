<?php
if ( !defined("__MATERIA__") ){
	define("__MATERIA__","");
	include("DataConnection.class.php");
	
	class MateriaPrima{

		
		private $idMateria;
		private $nombre;
		private $proveedor;
		private $precio;
		private $cantidad;
		private $Fecha_Ca;
		private $Fecha_Ll;
		private $unidad;
		private $idCompra;
		

		public function __construct($idm,$n,$p,$pr,$c,$idc,$Fecha_c,$Fecha_l,$idc)
		{
			
			$this->idMateria = $idm;
			$this->nombre = $n;
			$this->proveedor = $p;
			$this->precio = $pr;
			$this->cantidad = $c;
			$this->unidad = $unit;
			$this->Fecha_Ca = $Fecha_c;
			$this->Fecha_Ll = $Fecha_l;
			$this->idCompra = $idc;
				
		}
		
		public function getNombre(){
			return $this->nombre;
		}
		public function getIdCompra(){
			return $this->idCompra;
		}
		public function getIdMateria(){
			return $this->idMateria;
		}
		public function getIdm(){
			return $this->idMateria;
		}
		public function getProveedor(){

			$db = new DataConnection();
			$qry = "SELECT * from proveedor where RFC = '".$this->proveedor."'";			
			$result = $db->executeQuery($qry);

			if ($dato = mysql_fetch_assoc($result)){
				return $dato["Nombre"];
			}	
		}

		public function getUniad(){
			return $this->unidad;
		}
		public function getPrecio(){
			return $this->precio;
		}
		public function getCantidad(){
			return $this->cantidad;
		}
		public function getFechaC(){
			return $this->Fecha_Ca;
		}
		public function getFechaL(){
			return $this->Fecha_Ll;
		}



		public static function Agregar($nombre,$proveedor,$cantidad,$precio,$fecha_c,$fecha_l)
		{
			$connection = new DataConnection();

			$registro1 = $connection->executeQuery("SELECT * from proveedor where Nombre = '".$proveedor."'");


			while($reg1 = mysql_fetch_array($registro1))
			{
				
				$idProveedor = $reg1['RFC'];
				
			}

			$registro2 = $connection->executeQuery("SELECT m.idMateriaPrima from materiaprima m where m.Nombre = '".$nombre."'");

			while($reg2 = mysql_fetch_array($registro2))
			{
				
				$idMateria = $reg2['idMateriaPrima'];
				$unidad = $reg2['Unidad'];
				
			}

			$qry = "INSERT into suministro(PrecioActual,RFC,idMateriaPrima,Cantidad,Fecha_Llegada,Fecha_Caducidad) VALUES('".$precio."','".$idProveedor."','".$idMateria."', '".$cantidad."', '".$fecha_l."', '".$fecha_c."');";

			if($result = $connection->executeQuery($qry))
				return true;
			return false;
		}
		public static function Modificar($nombre,$proveedor,$cantidad,$precio,$fecha_c,$fecha_l,$idc)
		{
			$connection = new DataConnection();

			$registro1 = $connection->executeQuery("SELECT * from proveedor where Nombre = '".$proveedor."'");


			while($reg1 = mysql_fetch_array($registro1))
			{
				
				$idProveedor = $reg1['RFC'];
				
			}

			$registro2 = $connection->executeQuery("SELECT m.idMateriaPrima from materiaprima m where m.Nombre = '".$nombre."'");

			while($reg2 = mysql_fetch_array($registro2))
			{
				
				$idMateria = $reg2['idMateriaPrima'];
				$unidad = $reg2['Unidad'];
				
			}


			$qry = "DELETE from compra_mp where idCompra = ".$idc." AND idMateriaPrima = ".$idMateria;		
			$result = $connection->executeQuery($qry);	

			echo $qry;

			$qry = "SELECT * from compra_mp where idCompra = ".$idc;

			$result = $connection->executeQuery($qry);	

			if ( mysql_num_rows($result) < 1)
			{
				$qry = "DELETE from compra where idCompra = ".$idc;		
				$result = $connection->executeQuery($qry);	
			}

			$qry = "INSERT into suministro(PrecioActual,RFC,idMateriaPrima,Cantidad,Fecha_Llegada,Fecha_Caducidad) VALUES('".$precio."','".$idProveedor."','".$idMateria."', '".$cantidad."', '".$fecha_l."', '".$fecha_c."');";


			if($result = $connection->executeQuery($qry))
				return true;
			return false;
		}
	
		 
		public static function findById($id)
		{
			$db = new DataConnection();
			$qry = "SELECT * from compra_mp where idCompra = ".$id.";";			
			$result = $db->executeQuery($qry);

			while($dato = mysql_fetch_array($result)){

				$idm = $dato["idMateriaPrima"];
				$cantidad = $dato["Cantidad"];
				$idc = $dato["idCompra"];
			}	

			$qry = "SELECT * from compra where idCompra = ".$id.";";			
			$result = $db->executeQuery($qry);

			while($dato = mysql_fetch_array($result)){

				$idp = $dato["RFC"];
			}


			$qry = "SELECT * from materiaprima where idMateriaPrima = ".$idm.";";			
			$result = $db->executeQuery($qry);		

			if ($dato = mysql_fetch_assoc($result)){

				$emp = new MateriaPrima($idm,$dato["Nombre"],$idp,"5",$cantidad,"","","",$idc);


				return $emp;
			}	
			return false;
		}
				
		public static function Eliminar($id){
			$db = new DataConnection();	
			
			$result = $db->executeQuery("DELETE FROM suministro WHERE idSuministro ='".$id."'");	
			return $result;
		}	
	}
}
?>