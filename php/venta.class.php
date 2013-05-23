<?php
if ( !defined("__VENTA__") ){
	define("__VENTA__","");
	include("DataConnection.class.php");
	
	class Venta{
		private $Folio;
		private $Fecha;
		private $Cliente;
		private $Fentrega;
		private $Estado;
		
		public function __construct($folio,$fecha,$cliente,$fentrega,$Estado)
		{
			$this->Folio = $folio;
			$this->Fecha = $fecha;
			$this->Cliente = $cliente;
			$this->Fentrega = $fentrega;
			$this->Estado= $Estado;	
		}
		public function getFolio(){
			return $this->Folio;
		}
		public function getFecha(){
			return $this->Fecha;
		}
		public function getCliente(){
			return $this->Cliente;
		}
		public function getFentrega(){
			return $this->Fentrega;
		}
		public function getEstado(){
			return $this->Estado;
		}
		public static function Agregar($Cliente){
			$db = new DataConnection();
			$aux= $db->executeQuery("Select MAX(Fentrega) as 'Fentrega' from venta");
			$aux1= $db->executeQuery("SELECT DATEDIFF(CURDATE( ),MAX( Fentrega )) as 'Fecha' FROM venta");
			$dato = mysql_fetch_assoc($aux1);
			$fech=mysql_fetch_assoc($aux);
			$row=mysql_fetch_row($aux);
			$auxx= $db->executeQuery("Select count(*) as 'cuenta' from venta where Fentrega like '%".$fech['Fentrega']."%'");
			
			if($aux!=0 and $dato["Fecha"]<0 )
			{
				$nw=mysql_fetch_assoc($auxx);
				if($nw['cuenta']>2)  
				$qry = "INSERT INTO Venta (Fecha,RFC,Fentrega,Estado) VALUES((SELECT CURDATE( )),'".$Cliente."',(SELECT DATE_ADD(MAX(v.Fentrega),INTERVAL 2 Day) FROM venta v ),'En Espera');";
				else
					$qry = "INSERT INTO Venta (Fecha,RFC,Fentrega,Estado) VALUES((SELECT CURDATE( )),'".$Cliente."',(SELECT MAX(v.Fentrega) FROM venta v where estado not like '%Cancelado%'),'En Espera');";
			}
			else
			{
				$qry = "INSERT INTO Venta (Fecha,RFC,Fentrega,Estado) VALUES((SELECT CURDATE( )),'".$Cliente."',(SELECT DATE_ADD(curdate(),INTERVAL 2 Day)),'En Espera')";
				
			} 
			if($result = $db->executeQuery($qry))
			{
				return true;
			}
			return false;
		}
		
		public static function Modificar($Fentrega,$Folio){
		    $db = new DataConnection();
			$auxi= "SELECT DATEDIFF(v.fecha,'".$Fentrega."') as 'Fecha' FROM venta v where folio=".$Folio;
			$aux1= $db->executeQuery($auxi);
			$dato = mysql_fetch_assoc($aux1);
			
			if((int)$dato['Fecha']<=0)
			{
					$qry = "UPDATE Venta SET Fentrega='".$Fentrega."',estado='En espera' where Folio=".$Folio;
					if($result = $db->executeQuery($qry))
						{
						$res= $db->executeQuery("Update articuloventa  set Estado='Aplazado' where Folio=".$Folio." and estado not like '%cancelado%'");
						return true;
						}
					return false;
			}
			else {return false;}
		}
			
		public static function findById($Folio)
		{
			$db = new DataConnection();			
			$result = $db->executeQuery("SELECT Folio, DATE_FORMAT(Fecha, '%Y-%m-%d') as 'Fecha',RFC,DATE_FORMAT(FEntrega, '%Y-%m-%d') as 'Fentrega',Estado FROM Venta WHERE Folio=".$Folio);
			if ($dato = mysql_fetch_assoc($result)){
				$emp = new Venta($dato["Folio"],$dato["Fecha"],$dato["RFC"],$dato["Fentrega"],$dato["Estado"]);
				return $emp;
			}	
			return false;
		}
		
		public static function NombreClie($RFC)
		{
			$db = new DataConnection();			
			$result = $db->executeQuery("SELECT Nombre FROM Cliente WHERE RFC='".$RFC."'");
			if ($dato = mysql_fetch_assoc($result)){
				$emp = $dato["Nombre"];
				return $emp;
			}	
			return false;
		}
				
		public static function Eliminar($Folio){
			$db = new DataConnection();			
			$result = $db->executeQuery("Update Venta set Estado='Cancelado' where Folio=".$Folio);
			$datos= $db->executeQuery("Update ArticuloVenta set Estado='Cancelado' where Folio=".$Folio);
			$qry="Select l.cantidadProducto,l.idlote from lote l, articuloventa a where a.idlote=l.idlote and folio=".$Folio;
			$result=$db->executeQuery($qry);
			while($fila = mysql_fetch_array($result))
			{
					$res=$db->executeQuery("Update lote set cantidadProducto=".(int)$fila['cantidadProducto']."+(Select cantidad from articuloventa where folio=".$Folio." and idlote='".$fila['idlote']."') Where idlote=
										'".$fila['idlote']."'");
			}
			return $result;
		}	
	}
}
?>