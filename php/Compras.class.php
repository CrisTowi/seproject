<?php
if ( !defined("__COMPRA__") ){
	define("__COMPRA__","");
	include("../php/DataConnection.class.php");
	
	class Compras{
		private $id;
		private $fecha;
		private $total;
		private $idProducto;
/*
status 0 en espera
status 1 finalizada
status 2 cancelada
*/
		
		public function __construct($idProducto,$total,$fecha)
		{
			$this->idProducto = $idProducto;
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
	
		
		public static function Agregar($ids,$cantidades,$total,$proveedor){
			$db = new DataConnection();
			
			$qry = "INSERT INTO compra (idCompra,Fecha,Total,status,RFC) VALUES(null,curdate(),".$total.",0,'".$proveedor."');";
			if($result = $db->executeQuery($qry))
			{
				$query="select max(idCompra) as id from compra";
				$resultado =$db->executeQuery($query);
				$rows = mysql_fetch_array($resultado);
				$row=$rows[0];
				
				for($i=1;$i<= count($ids) ;$i++){	
					$qry2 = "INSERT INTO compra_mp VALUES(".$row.",".$ids[$i].",".$cantidades[$i].");";
					$db->executeQuery($qry2);
				}
				return true;
			}
			return false;
			
		}
		public static function Finalizar($id){
			$db = new DataConnection();
			return $result = $db->executeQuery("update compra set status=1 where  idCompra=".$id." ");
		}	
		public static function Cancelar($id){
			$db = new DataConnection();
			return $result = $db->executeQuery("update compra set status=2 where  idCompra=".$id." ");
		}	
	}
}
?>
