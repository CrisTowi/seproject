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
		

		public function __construct($idm,$n,$p,$pr,$c,$unit,$Fecha_c,$Fecha_l)
		{
			
			$this->idMateria = $idm;
			$this->nombre = $n;
			$this->proveedor = $p;
			$this->precio = $pr;
			$this->cantidad = $c;
			$this->unidad = $unit;
			$this->Fecha_Ca = $Fecha_c;
			$this->Fecha_Ll = $Fecha_l;
				
		}
		
		public function getNombre(){
			return $this->nombre;
		}
		public function getIdm(){
			return $this->idMateria;
		}
		public function getProveedor(){

			$db = new DataConnection();
			$qry = "SELECT * from proveedor where RFC = '".$this->proveedor."'";			
			$result = $db->executeQuery($qry);

			if ($dato = mysql_fetch_assoc($result)){
				//echo $dato["idMateria"].$dato["nombre"].$dato["proveedor"].$dato["precio_lote"].$dato["cantidad"].$dato["unidad"].$dato["fecha_caducidad"];
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
		public static function Modificar($nombre,$proveedor,$cantidad,$precio,$fecha_c,$fecha_l)
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
	
		 
		public static function findById($id)
		{
			$db = new DataConnection();
			$qry = "SELECT * from materiaprima where idMateriaPrima = ".$id.";";			
			$result = $db->executeQuery($qry);

			//echo "SELECT * from materiaprima where idMateriaPrima =".$id
			if ($dato = mysql_fetch_assoc($result)){

				$emp = new MateriaPrima($dato["idMateriaPrima"],$dato["Nombre"],"QWER123456","5","","","","");
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