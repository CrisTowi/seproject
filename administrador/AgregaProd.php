<?php 

	include("../php/Validations.class.php");
	include("../php/Producto.class.php");
	$id    =	Validations::cleanString($_GET['idProducto']);	
	$nombre    =	Validations::cleanString($_GET['nombreP']);
	$precio      =	Validations::cleanString($_GET['precioP']);


	if ( Validations::validaNombre($nombre) && Validations::validaFloat($precio) )
	{
			//Altas
			if ( !isset($_GET["edit"]) )
			{
				//probamos que el producto no exista
				$pruebaExiste=Producto::findByName($nombre);
				if ( strlen($nombre) < 3 ){
					echo "INPUT_PROBLEM";
					return;
				}
				if($pruebaExiste)
				{
					echo "El producto con nombre ".$nombre." ya existe";
					return;
				}
				//Validamos receta
				if($_GET['numeroFilas']==0)
				{
					echo "La receta es un atributo obligatorio";
					return;
				}
				$filas=$_GET['numeroFilas'];
				for ($i=1; $i <= $filas; $i++) 
				{			
					if (!Validations::validaFloat($_GET['cantidad'.$i]))
					{
						echo "INPUT_PROBLEM";
						return;
					}
				}	
				//Insertamos Producto
				$accept     =	Producto::Agregar($nombre,$precio);
				//Insertamos receta
				include("../php/DataConnection.class.php");
				$filas=$_GET['numeroFilas'];
				$found=Producto::findByName($nombre);
				$id=$found->getId();
				for ($i=1; $i <= $filas; $i++) 
				{
					$db = new DataConnection();
					$query="insert into receta values('".$id."','".$_GET['materiaPrima'.$i]."','".$_GET['cantidad'.$i]."')";
					$db->executeQuery($query);						
				}				
			}
			//modificaciones
			else
			{
				$accept     =	Producto::Modificar($id,$nombre,$precio);	
			}
			if(!$accept)
			{
				echo "DATABASE_PROBLEM";
			}else
			{
				echo "OK";
				return;
			}
		
	}else{
		echo "INPUT_PROBLEM";
		return;
	}
	
	

?>