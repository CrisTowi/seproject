<?php
if ( !defined("__PROVEEDOR__") ){
	define("__PROVEEDOR__","");
	include("DataConnection.class.php");
	
	class Proveedor{
		private $RFC;
		private $nombre;
		private $direccion;
		private $telefono;
		private $email;
		private $status;
		private $noReportes;
		private $productos;
		private $precios;
		
		public function __construct($RFC, $nombre, $direccion, $telefono, $email, $status, $noReportes, $productos, $precios)
		{
			$this->RFC = $RFC;
			$this->nombre = $nombre;
			$this->direccion = $direccion;
			$this->telefono = $telefono;
			$this->email = $email;
			$this->status = $status;
			$this->noReportes = $noReportes;
			$this->productos = $productos;
			$this->precios = $precios;
		}
		
		public function getRFC(){
			return $this->RFC;
		}
		public function getNombre(){
			return $this->nombre;
		}
		public function getCurp(){
			return $this->CURP;
		}
		public function getDireccion(){
			return $this->direccion;
		}
		public function getTelefono(){
			return $this->telefono;
		}
		public function getEmail(){
			return $this->email;
		}
		public function getStatus(){
			return $this->status;
		}
		public function getNoReportes(){
			return $this->noReportes;
		}
		public function getProductos(){
			return $this->productos;
		}
		public function getPrecios(){
			return $this->precios;
		}
		
		public static function Agregar($RFC, $nombre, $direccion, $telefono, $email, $productos, $precios){
			$db = new DataConnection();
			$qry = "INSERT INTO Proveedor (RFC, Nombre, Direccion, Telefono, Email, Status, No_reportes) VALUES('".$RFC."','".$nombre."','".$direccion."','".$telefono."','".$email."', 0, 0);";
			if($result = $db->executeQuery($qry))
			{
				for($i = 1; $i <= count($productos); $i++)
				{
					$qry = "INSERT INTO Suministro (PrecioActual, RFC, idMateriaPrima) VALUES (".$precios[$i].", '".$RFC."', ".$productos[$i].");";
					if(!($result = $db->executeQuery($qry)))	//Si ocurre algun error
						return false;
				}
				return true;
			}
			return false;
		}
		
		public static function Modificar($RFC, $nombre, $direccion, $telefono, $email, $productos, $precios){
			$db = new DataConnection();
			$qry = "UPDATE Proveedor SET Nombre='".$nombre."', Direccion='".$direccion."' ,Telefono='".$telefono."', Email='".$email."' WHERE RFC='".$RFC."'";
			if($db->executeQuery($qry))
			{			
				//Guardamos el IdSuministro de los productos registrados antes de empezar a modificar
				$qry = "SELECT IdSuministro FROM Suministro WHERE RFC = '".$RFC."'";
				$result = $db->executeQuery($qry);				
				for($i = 0; $dato = mysql_fetch_assoc($result); $i++){
					$productosBD[$i] = $dato["IdSuministro"];
				}
				
				//Comenzamos a recorrer el nuevo arreglo de productos
				for($i = 1; $i <= count($productos); $i++)
				{
					$qry = "SELECT IdSuministro FROM Suministro WHERE idMateriaPrima = ".$productos[$i]." AND RFC ='".$RFC."'";
					$result = $db->executeQuery($qry);
					
					//Si es un producto que ya existe se actualiza
					if($dato = mysql_fetch_assoc($result))
					{
						$id = $dato["IdSuministro"];
						$qry = "UPDATE Suministro SET PrecioActual = ".$precios[$i]." WHERE IdSuministro = ".$id;
						if(!($db->executeQuery($qry)))	//Si ocurre algun error
							return false;
						
						//Se marca como editado el producto en el arreglo
						for($j = 0; $j < count($productosBD); $j++)
						{
							if($productosBD[$j] == $id)
								$productosBD[$j] = -1;
						}						
					}
					//Si no existe se agrega
					else
					{
						$qry = "INSERT INTO Suministro (PrecioActual, RFC, idMateriaPrima) VALUES (".$precios[$i].", '".$RFC."', ".$productos[$i].");";
						if(!($result = $db->executeQuery($qry)))	//Si ocurre algun error
							return false;
					}
				}
				
				//Los que quedan en el arreglo se deben eliminar
				for($i = 0; $i < count($productosBD); $i++)
				{
					$qry = "DELETE FROM Suministro WHERE IdSuministro = ".$productosBD[$i];
					if(!($db->executeQuery($qry)))	//Si ocurre algun error
						return false;
				}
				
				return true;
			}
			return false;
		}
		
		public static function findById($id)
		{
			$db = new DataConnection();			
			$result = $db->executeQuery("SELECT pv.RFC, pv.Nombre as Nombre, Direccion, Telefono, Email, Status, No_reportes, mp.idMateriaPrima as Producto, PrecioActual FROM proveedor pv JOIN suministro s ON pv.RFC = s.RFC JOIN materiaprima mp ON s.idmateriaprima = mp.idmateriaprima WHERE pv.RFC='".$id."'");
			if ($dato = mysql_fetch_assoc($result)){
				$RFCBD = $dato["RFC"];
				$nombreBD = $dato["Nombre"];
				$direccionBD = $dato["Direccion"];
				$telefonoBD = $dato["Telefono"];
				$emailBD = $dato["Email"];
				$statusBD = $dato["Status"];
				$noReportesBD = $dato["No_reportes"];
				$productosBD[0] = $dato["Producto"];
				$preciosBD[0] = $dato["PrecioActual"];
				for($i = 1; $dato = mysql_fetch_assoc($result); $i++)
				{
					$productosBD[$i] = $dato["Producto"];
					$preciosBD[$i] = $dato["PrecioActual"];
				}
				$pvr = new Proveedor($RFCBD, $nombreBD, $direccionBD, $telefonoBD, $emailBD, $statusBD, $noReportesBD, $productosBD, $preciosBD);
				return $pvr;
			}
			return false;
		}
				
		public static function Eliminar($id){
			$db = new DataConnection();			
			return $result = $db->executeQuery("UPDATE Proveedor SET Status = 2 WHERE RFC='".$id."'");
		}
		
		public static function Desbloquear($id){
			$db = new DataConnection();			
			return $result = $db->executeQuery("UPDATE Proveedor SET Status = 0 WHERE RFC='".$id."'");
		}	
	}
}
?>
