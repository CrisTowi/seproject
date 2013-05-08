<table id='table-content'>
	<tr class='tr-header'>
		<td>Id Producto</td>
		<td>Nombre</td>
		<td>Precio ($)</td>
		<td>Receta</td>
		<td class='opc'> </td>
		<td class='opc'> </td>
	</tr>
<?php
	include("../php/DataConnection.class.php");
	include("../php/Validations.class.php");

	$db = new DataConnection();	
	$qry = "SELECT P.idProducto,P.nombre,P.Precio, P.Receta
			from Producto P";	


	if ( isset($_GET["search"] ) ){
	$filtro = Validations::cleanString($_GET["search"]);
		if($filtro != "")
		{
			if(is_numeric($filtro))
			{
				$qry .= " Where P.idProducto = ".$filtro;
			}
			else
			{
				$qry .= " where (P.nombre LIKE '%".$filtro."%')";
			}
		}
	}
	$result = $db->executeQuery($qry);	
	
	if ( mysql_num_rows($result) < 1){
		echo ("<tr class='tr-cont'>
			<td colspan='6'>No se encontraron resultados</td>
			<td class='opc'></td>
			<td class='opc'></td>
		</tr>");
	}else{	
	
	while($fila = mysql_fetch_array($result))
	{		
		$idP = $fila['idProducto'];	
		$nombre = $fila['nombre'];
		$precio = $fila['Precio'];
		$Receta = $fila['Receta'];


		echo "<tr class='tr-cont' id='".$idP."' name='".$idP."'>
			<td>".$idP."</td>
			<td>".$nombre."</td>
			<td>".$precio."</td>
			<td>".$Receta."</td>
		</tr>";
	}
}
?>

</table>