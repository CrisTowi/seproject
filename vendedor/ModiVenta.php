<?php 
	include("../php/Validations.class.php");
	include("../php/venta.class.php");
	$id = Validations::cleanString($_GET['Folio']);	
	$Fentrega   =Validations::cleanString($_GET['Fentrega']);
	 
	$filas=Validations::cleanString($_GET['noEl']);
	include("../php/DataConnection.class.php");
	$db = new DataConnection();
	$accept=venta::Modificar($Fentrega);
	
		    
	for ($i=0; $i <= $filas-1; $i++) 
	{
		    	$query="update ArticuloVenta set Estado='Cancelado' where folio=".$id." and idlote='".$_GET['Eliminar'.$i]."'";
				$db->executeQuery($query);
				$qry="Select cantidadProducto from lote where idlote='".$_GET['Eliminar'.$i]."'";
				$result=$db->executeQuery($qry);
				$dato1=mysql_fetch_assoc($result);
				$res=$db->executeQuery("Update lote set cantidadProducto=".(int)$dato1['cantidadProducto']."+(Select cantidad from articuloventa where folio=".$id." and idlote='".$_GET['Eliminar'.$i]."') Where idlote=
										'".$_GET['Eliminar'.$i]."'");
	}
							
	if(!$accept){echo "DATABASE_PROBLEM";
	}else{echo "OK";}	
?>