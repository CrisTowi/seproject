<?php
	
	include("../php/DataConnection.class.php");		
	$db = new DataConnection();
	$idProducto = $_POST['producto'];
/*	
	$query = "SELECT m.nombreMateriaPrima, m.idMateriaPrima, r.cantidad, m.unidad
			  FROM materiaprima m, receta r
			  WHERE m.idMateriaPrima = r.idMateriaPrima
			  AND r.idProducto = $idProducto";
*/
	$query = "SELECT m.Nombre, m.idMateriaPrima, r.Cantidad, m.Unidad
			FROM materiaprima m, receta r
			WHERE m.idMateriaPrima = r.idMateriaPrima AND r.idProducto = $idProducto";			  
	
	$result = $db->executeQuery($query);	

	if (!$result) 
		die ("Database access failed: " . mysql_error());
		
	$rows = mysql_num_rows($result);
	
	echo '<table >';
	echo '<tr class="tr-header" style="background-color: rgb(255, 222, 0);">';
	echo '<td style="width: 180px;" >Ingrediente';
	echo '</td>';
	echo '<td style="width: 130px;">Cant. Requerida';
	echo '</td>';	
	echo '<td>Lotes en almacen';
	echo '</td>';	
	echo '<td style="width: 135px;">Cant. Disponible';
	echo '</td>';
	echo '<td class="celdaInvisible">Estado';   //Columna para validar si hay suficiente materia prima
	echo '</td>';	
	echo '</tr>';
	
	/*echo "<script type='text/javascript'> 
						alert('éóí');
				</script>";
	*/
	
	
	for ($j = 0 ; $j < $rows ; ++$j)
	{
		$row = mysql_fetch_row($result);
		//echo '<p>' . $row[0] . '</p>';
		echo '<tr class="tr-cont">';
		echo '<td style="width: 180px;" >'. $row[0].'</td>';
		
		echo '<td style="text-align: center;" id="cantReq'.$j.'"><p>'. $row[2].' '.$row[3].'</p>';
		echo '<input type="hidden" id="cantReqBase'. $j.'" value="'. $row[2].'"/>';
		echo '<input type="hidden" id="cantReqFinal'. $j.'" value="'. $row[2].'" name="cantReqFinal'. $j.'" />';
		echo '</td>';
	
	/*	echo "<script type='text/javascript'> 
						alert('$row[0]');
				</script>";*/
				
		echo '</td>';
		echo '<td id="ing'.$j.'"><input type="hidden" id="ingrediente'. $j.'" value="'. $row[1].'" name="idIngrediente'. $j.'"/>';
		echo '</td>';
		echo '</td>';	
		echo '<td id="cantidad'.$j.'"></td>';
		echo '<td id="suficiente'.$j.'" class="celdaInvisible"><p class="oculto"></p><input type="hidden" id="suficienteFinal'.$j.'" class="flagSuficiente" name="sufFinal'.$j.'"/></td>';
		echo '</tr>';
		
		
	}
	echo '<input type="hidden" id="totalIngredientes" value="'. $rows.'" name="totalIngredientes"/>';
	echo '</table>';	
?> 