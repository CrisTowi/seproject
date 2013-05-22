<?php
if ( !defined("__MATERIA__") ){
	define("__MATERIA__","");
	include("DataConnection.class.php");
	
	class MateriaPrima{

		
		private $idMateria;
		private $idproveedor;
		private $precio;
		private $cantidad;
		private $Fecha_Ca;
		private $Fecha_Ll;
		private $unidad;
		private $idCompra;
		

		public function __construct($idm,$idp,$pr,$c,$idc,$Fecha_c,$Fecha_l,$idc)
		{
			
			$this->idMateria = $idm;
			$this->idproveedor = $idp;
			$this->precio = $pr;
			$this->cantidad = $c;
			$this->unidad = $unit;
			$this->Fecha_Ca = $Fecha_c;
			$this->Fecha_Ll = $Fecha_l;
			$this->idCompra = $idc;
				
		}

		public function getIdCompra(){
			return $this->idCompra;
		}
		public function getIdMateria(){
			return $this->idMateria;
		}
		public function getIdProveedor(){
			return $this->idproveedor;
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



		public static function Agregar($idMateria,$idProveedor,$cantidad,$precio,$fecha_c,$fecha_l)
		{
			$connection = new DataConnection();

			$idlote = $idMateria . $idProveedor;
			$qry = "INSERT into inventario_mp(idLote,idMateriaPrima,RFC,Cantidad,Fecha_Llegada,Fecha_Caducidad) VALUES('".$idlote."',".$idMateria.",'".$idProveedor."',".$cantidad.", '".$fecha_l."', '".$fecha_c."');";

			if($result = $connection->executeQuery($qry))
				return true;
			return false;


		}
		public static function Modificar($idMateria,$idProveedor,$cantidad,$precio,$fecha_c,$fecha_l,$idc)
		{
			$connection = new DataConnection();

			$qry = "DELETE from compra_mp where idCompra = ".$idc." AND idMateriaPrima = ".$idMateria;		
			$result = $connection->executeQuery($qry);	


			$qry = "SELECT * from compra_mp where idCompra = ".$idc;
			$result = $connection->executeQuery($qry);	

			if ( mysql_num_rows($result) < 1)
			{
				$qry = "DELETE from compra where idCompra = ".$idc;		
				$result = $connection->executeQuery($qry);	
			}

			$idlote = $idMateria . $idProveedor . $idc;
			$qry = "INSERT into inventario_mp(idLote,idMateriaPrima,RFC,Cantidad,Fecha_Llegada,Fecha_Caducidad) VALUES('".$idlote."',".$idMateria.",'".$idProveedor."',".$cantidad.", '".$fecha_l."', '".$fecha_c."');";
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
				$cantidad = $dato["cantidad"];
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

				$emp = new MateriaPrima($idm,$idp,"5",$cantidad,"","","",$idc);


				return $emp;
			}	
			return false;
		}
				
		public static function Eliminar($id){
			$db = new DataConnection();	
			
			$result = $db->executeQuery("DELETE FROM inventario_mp WHERE idLote ='".$id."'");	
			return $result;
		}	
	}
}
?>