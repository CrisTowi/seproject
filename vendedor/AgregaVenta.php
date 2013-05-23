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

	include("../php/DataConnection.class.php");
	$db = new DataConnection();
	for ($i=1; $i <= $filas; $i++) 
	{
		$cant=$_GET['cantidad'.$i]%100;
		if (!Validations::validaInt($_GET['cantidad'.$i])||$cant<>0 )
		{
			echo "INPUT_PROBLEM";
			return;
		}
			if(!(stripos($_GET['Articulo'.$i],'Pedido')!== FALSE))
			{
			$canto=(int)Validations::cleanString($_GET['cantidad'.$i]);
			$qry="Select cantidadProducto from lote where idlote='".$_GET['Articulo'.$i]."'";
			$result=$db->executeQuery($qry);
			$dato=mysql_fetch_assoc($result);
			$cantp=(int)$dato['cantidadProducto'];
			if($canto > $cantp)
			{
				echo "INPUT_DESB";
				return;
			}}
	}
	
	$accept=venta::Agregar($Cliente);
	if(!$accept){
	 
				echo "DATABASE_PROBLEM";
	}else{
		    
			
			$query="Select MAX(Folio) as 'Folio' from Venta";
			$result=$db->executeQuery($query);
			$dato=mysql_fetch_assoc($result);
			$Fol=$dato["Folio"];
			//agregan articulos
			$filas=$_GET['numeroFilas'];
						for ($i=1; $i <= $filas; $i++) 
						{
							if(stripos($_GET['Articulo'.$i],'Pedido') !== FALSE)
							{
								$query = "SELECT clave FROM producto
											WHERE idProducto =".$_GET['Producto'.$i];	
								$result = $db->executeQuery($query);											
								$row = mysql_fetch_row($result);
								$claveLote = $row[0];	
								$query = "SELECT COUNT(*)+1 FROM lote;";	
								$result = $db->executeQuery($query);	
								$row = mysql_fetch_row($result);
								$num = $row[0];
								$noLote = $claveLote.$num;
								$query="INSERT INTO lote (idlote,idProducto,cantidadProducto ,estado)VALUES ('".$noLote."',".$_GET['Producto'.$i].",1000, 'En Espera')";
								$db->executeQuery($query);
								$query="insert into articuloventa values(".$Fol.",'".$noLote."',".$_GET['cantidad'.$i].",'En Espera')";
								$db->executeQuery($query);
								/*$res=$db->executeQuery("Select cantidadProducto from lote where idlote='".$noLote."'");
								$datos=mysql_fetch_assoc($res);
								$res2=$datos["cantidadProducto"]-(int)$_GET['cantidad'.$i];
								$query2="Update lote set cantidadProducto=".(int)$res2." where idlote='".$noLote."'";
								$db->executeQuery($query2);*/
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
						
								echo "OK";
					}
		}
?>
