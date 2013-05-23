<?php 
	include("../php/Validations.class.php");
	include("../php/venta.class.php");
	$id = Validations::cleanString($_GET['Folio']);	
	$Fentrega   =Validations::cleanString($_GET['Fentrega']);
	 
	$filas=Validations::cleanString($_GET['noEl']);
	include("../php/DataConnection.class.php");
	$db = new DataConnection();
	$accept=venta::Modificar($Fentrega,$id);
	
		    
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
					
	$q=("select count(*) as 'cuenta' from articuloventa where estado not like '%cancelado%' and Folio=".$id);
	$resulta=$db->executeQuery($q);
	$dato=mysql_fetch_assoc($resulta);
	$cuenta=(int)$dato['cuenta'];
	if($cuenta==0)
	{
		$query="update Venta set Estado='Cancelado' where folio=".$id;
		$accept=$db->executeQuery($query);
	}		
	if($accept){
		include("actua.php");
			echo "OK";
	}else {
		echo "DATABASE_PROBLEM";
	}	
?>