<?php
if ( !defined("__COMPRA__") ){
	define("__COMPRA__","");
	include("../php/DataConnection.class.php");
	
	class Compra{
		private $id;
		private $fecha;
		private $total;
		private $idProducto

		
		public function __construct($id,$nombre,$precio)
		{
			$this->id = $id;
			$this->fecha = $fecha;
			$this->total = $total;
		}
		
		public function getId(){
			return $this->id;
		}	
		public function getFecha(){
			return $this->fecha;
		}
		public function getTotal(){
			return $this->total;
		}

		
		public function setId($id){
			$this->id=id;
		}	
		public function setFecha($fecha){
			$this->fecha=fecha;
		}
		public function setTotal($total){
			$this->total=total;
		}
	
		
		public function Agregar(){
			$db = new DataConnection();
			$query="Insert into Compra (Nombre,Precio) values('".$this->nombre."',".$this->precio.")";
			$db->executeQuery($query);
			return $db;
		}
		
		public function findByName(){
			$db = new DataConnection();
			$result=$db->executeQuery("Select * from producto where Nombre='".$this->nombre."'");
			if ( $dato = mysql_fetch_assoc($result) ){
				$productoFound = new Producto($dato["idProducto"],$dato["Nombre"],$dato["Precio"]);
				return $productoFound;
			}
			return false;	
		}
		
		public function findById(){
			$db = new DataConnection();
			$result=$db->executeQuery("Select * from producto where idProducto='".$this->id."'");
			if ( $dato = mysql_fetch_assoc($result) ){
				$productoFound = new Producto($dato["idProducto"],$dato["Nombre"],$dato["Precio"]);
				return $productoFound;
			}
			return false;	
		}
		
		
		
			
	}
}
?>
