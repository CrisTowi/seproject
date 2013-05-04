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
		//private $productos;
		//private $precios;
		
		public function __construct($RFC, $nombre, $direccion, $telefono, $email, $status, $noReportes)//, $productos, $precios)
		{
			$this->RFC = $RFC;
			$this->nombre = $nombre;
			$this->direccion = $direccion;
			$this->telefono = $telefono;
			$this->email = $email;
			$this->status = $status;
			$this->noReportes = $noReportes;
			//$this->$productos = $productos;
			//$this->$precios = $precios;
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
		/*public function getProductos(){
			return $this->productos;
		}
		public function getPrecios(){
			return $this->precios;
		}*/
		
		public static function Agregar($RFC, $nombre, $direccion, $telefono, $email){//, $productos, $precios){
			$db = new DataConnection();
			$qry = "INSERT INTO Proveedor (RFC, Nombre, Direccion, Telefono, Email, Status, No_reportes) VALUES('".$RFC."','".$nombre."','".$direccion."',".$telefono.",'".$email."', 0, 0);";
			if($result = $db->executeQuery($qry))
			{
				return true;
			}
			return false;
		}
		
		public static function Modificar($RFC, $nombre, $direccion, $telefono, $email){
			$db = new DataConnection();
			$qry = "UPDATE Proveedor SET Nombre='".$nombre."', Direccion='".$direccion."' ,Telefono=".$telefono.", Email='".$email."' WHERE RFC='".$RFC."'";
			if($result = $db->executeQuery($qry))
				return true;
			return false;
		}
		
		public static function findById($id)
		{
			$db = new DataConnection();			
			//$result = $db->executeQuery("SELECT pv.RFC, pv.Nombre, Direccion, Telefono, Email, Status, No_reportes, PrecioActual, mp.nombre FROM proveedor pv JOIN suministro s ON pv.RFC = s.RFC JOIN materiaprima mp ON s.idmateriaprima = mp.idmateriaprima WHERE pv.RFC='".$id."'");
			$result = $db->executeQuery("SELECT * FROM proveedor WHERE RFC='".$id."'");
			if ($dato = mysql_fetch_assoc($result)){
				$pvr = new Proveedor($dato["RFC"], $dato["Nombre"], $dato["Direccion"], $dato["Telefono"], $dato["Email"], $dato["Status"], $dato["No_reportes"]);
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
