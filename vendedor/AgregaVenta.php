<?php 
	/*
		cliente
	*/
	include("../php/Validations.class.php");
	include("../php/venta.class.php");
	$id = Validations::cleanString($_GET['idVenta']);	
	$Cliente   =Validations::cleanString($_GET['Cliente']);
	//$accept     =	venta::Agregar($Cliente);
	
	if($_GET['numeroFilas']==0)
	{
					echo "La venta no puede estar vacia";
					return;
	}
	$filas=$_GET['numeroFilas'];
	for ($i=1; $i <= $filas; $i++) 
	{
		$cant=$_GET['cantidad'.$i]%100;
		if (!Validations::validaInt($_GET['cantidad'.$i])||$cant<>0)
		{
			echo "INPUT_PROBLEM";
			return;
		}
	}
	
	$accept=venta::Agregar($Cliente);	
	
	if(!$accept){
	 
				echo "DATABASE_PROBLEM";
	}else{
		    include("../php/DataConnection.class.php");
			$db = new DataConnection();
			$query="Select MAX(Folio) as 'Folio' from Venta";
			$result=$db->executeQuery($query);
			$dato=mysql_fetch_assoc($result);
			$Fol=$dato["Folio"];
			//agregan articulos
			$filas=$_GET['numeroFilas'];
						for ($i=1; $i <= $filas; $i++) 
						{
							if( stripos($_GET['Articulo'.$i],'Pedido') !== FALSE)
							{
								echo "hola";
							}else{
							//$db = new DataConnection();
							$query="insert into articuloventa values(".$Fol.",'".$_GET['Articulo'.$i]."',".$_GET['cantidad'.$i].",'En Espera')";
							$db->executeQuery($query);
							$res=$db->executeQuery("Select cantidadProducto from lote where idlote='".$_GET['Articulo'.$i]."'");
							$datos=mysql_fetch_assoc($res);
							$res2=$datos["cantidadProducto"]-(int)$_GET['cantidad'.$i];
							$query2="Update lote set cantidadProducto=".(int)$res2." where idlote='".$_GET['Articulo'.$i]."'";
							$db->executeQuery($query2);}
						}
					if(!$accept){
					 
								echo "DATABASE_PROBLEM";
					}else{
								echo "OK";}
		}
?>