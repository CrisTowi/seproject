<table id='table-content'>
	<tr class='tr-headerv'>
		<th>Folio</th>
		<th>RFC</th>
		<th>Fecha de Realizaci&oacute;n</th>
		<th>Fecha de Entrega</td>
		<th colspan='3'> </th>
	</tr>
<?php
	include("../php/DataConnection.class.php");
	include("../php/validations.class.php");
	//Inpaginacion
    $RegistrosAMostrar=5;
	if(isset($_GET['pag'])){
		$RegistrosAEmpezar=($_GET['pag']-1)*$RegistrosAMostrar;
		$PagAct=$_GET['pag'];}
	else{
		$RegistrosAEmpezar=0;
		$PagAct=1;}	
    //finpaginacion
	$db = new DataConnection();	
	$qry= "SELECT * FROM Venta";
	if ( isset($_GET["search"] ) ){
		$filtro = Validations::cleanString($_GET["search"]); // Limpia la entrada
		$qry.= " WHERE Folio LIKE '%".$filtro."%' OR RFC LIKE '%".$filtro."%'";
	}
	$ry= $qry." ORDER BY Folio DESC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
	
	// A�ade parametros de b�squeda
	$result = $db->executeQuery($ry);	
	if ( mysql_num_rows($result) < 1){
		echo ("<tr class='tr-contv'>
			   <td colspan='6'><center>No se encontraron resultados</center></td></tr>");
	}else{	
		/* Agrega los resultados */
		while($fila = mysql_fetch_array($result))
		{		
			$id = $fila['Folio'];	
			$RFC = $fila['RFC'];
			$fecha = $fila['Fecha'];
			$fentrega = $fila['Fentrega'];
			$estado = $fila['Estado'];
			echo ("<tr class='tr-contv' id='".$id."' name='".$id."'>
				<td>".$id."</td>
				<td>".$RFC."</td>
				<td>".$fecha."</td>
				<td>".$fentrega."</td>
				<td><img src='../img/view.png' onclick='ViewVenta(\"".$id."\")' alt='Visualizar' title='Visualizar' class='clickable'/></td>");
				
				switch ($estado)
				{
					 case "Cancelado":
				        echo ("<td colspan='2' ><center><img src='../img/cancelar.png' alt='Cancelar' title='Cancelado'/></center></td>
						</tr>");
				        break;
				     case "Entregado":
				        echo ("<td><img src='../img/pencil.png' onclick='modificarVenta(\"".$id."\")' alt='Modificar' title='Modificar' class='clickable'/></td>
						<td ><img src='../img/entregado.png' title='Entregado'/></td>
						</tr>");
				        break;
				     default:
				        echo ("<td><img src='../img/pencil.png' onclick='modificarVenta(\"".$id."\")' alt='Modificar' title='Modificar' class='clickable'/></td>
						<td ><img src='../img/less.png'   onclick='cancelarVenta(\"".$id."\")' alt='Eliminar' title='Cancelar' class='clickable'/></td>
						</tr>");
				        break;
				}
		}
		echo '</table>';
	//inipag
		$NroRegistros=mysql_num_rows($db->executeQuery($qry));
		$PagAnt=$PagAct-1;
		$PagSig=$PagAct+1;
		$PagUlt=$NroRegistros/$RegistrosAMostrar;
		$Res=$NroRegistros%$RegistrosAMostrar;
		if($Res>0) $PagUlt=floor($PagUlt)+1;
		echo '<div id="Paginacion">';
		echo "<u><a class='click' onclick=\"PaginaV('1')\">Primero </a></u>";	
		if($PagAct>1) echo "&nbsp;<u><a class='click'  onclick=\"PaginaV('$PagAnt')\"> Anterior</a></u>";
		echo "&nbsp;<strong> Pagina ".$PagAct."/".$PagUlt."</strong>";
		if($PagAct<$PagUlt)  echo "&nbsp;<u> <a class='click'  onclick=\"PaginaV('$PagSig')\"> Siguiente </a> </u>";
		echo "&nbsp;<u><a class='click'  onclick=\"PaginaV('$PagUlt')\"> Ultimo</a></u>";
		echo "</div>";
	}
		
?>