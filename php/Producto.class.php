<?php
if ( !defined("__PRODUCTO__") ){
	define("__PRODUCTO__","");
	include("../php/DataConnection.class.php");
	
	class Producto{
		private $id;
		private $nombre;
		private $precio;

		
		public function __construct($id,$nombre,$precio)
		{
			$this->id = $id;
			$this->nombre = $nombre;
			$this->precio = $precio;
		}
		
		public function getId(){
			return $this->id;
		}	
		public function getNombre(){
			return $this->nombre;
		}
		public function getPrecio(){
			return $this->precio;
		}

		
		public function setId($id){
			$this->id=id;
		}	
		public function setNombre($nombre){
			$this->nombre=nombre;
		}
		public function setPrecio($precio){
			$this->precio=precio;
		}
	
		
		public static function Agregar($nombre,$precio){
			$db = new DataConnection();
			$qry = "INSERT INTO Producto (Nombre,Precio) VALUES('".$nombre."',".$precio.");";
			if($result = $db->executeQuery($qry))
			{
				return true;
			}
			return false;
		}
		
		public static function findByName($name){
			$db = new DataConnection();
			$result=$db->executeQuery("Select * from producto where Nombre='".$name."'");
			if ( $dato = mysql_fetch_assoc($result) ){
				$productoFound = new Producto($dato["idProducto"],$dato["Nombre"],$dato["Precio"]);
				return $productoFound;
			}
			return false;	
		}
		
		public static function findById($id)
		{
			$db = new DataConnection();			
			$result = $db->executeQuery("SELECT * FROM Producto WHERE idProducto='".$id."'");
			if ($dato = mysql_fetch_assoc($result)){
				$emp = new Producto($dato["idProducto"],$dato["Nombre"],$dato["Precio"]);
				return $emp;
			}	
			return false;
		}
		public static function Modificar($id,$nombre,$precio){
			$db = new DataConnection();
			$qry = "UPDATE Producto SET Nombre='".$nombre."', Precio=".$precio." WHERE idProducto='".$id."'";
			if($result = $db->executeQuery($qry))
				return true;
			return false;
		}
		
		public static function Eliminar($id){
			$db = new DataConnection();			
			return $result = $db->executeQuery("DELETE FROM Producto WHERE idProducto='".$id."'");
		}
		
		
			
	}
}
?>
