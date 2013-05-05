<table id='table-content'>
	<tr class='tr-headerv'>
		<th>RFC</th>
		<th>Nombre</th>
		<th>Tel&eacute;fono</th>
		<th>E-mail</td>
		<th>Direcci&oacute;n</th>
		<th colspan='2'> </th>
	</tr>
<?php
	include("../php/DataConnection.class.php");
	include("../php/validations.class.php");
	//Inpaginacion
    $RegistrosAMostrar=4;
	if(isset($_GET['pag'])){
		$RegistrosAEmpezar=($_GET['pag']-1)*$RegistrosAMostrar;
		$PagAct=$_GET['pag'];}
	else{
		$RegistrosAEmpezar=0;
		$PagAct=1;}	
    //finpaginacion
	$db = new DataConnection();	
	$qry= "SELECT * FROM Cliente";
	if ( isset($_GET["search"] ) ){
		$filtro = Validations::cleanString($_GET["search"]); // Limpia la entrada
		$qry.= " WHERE RFC LIKE '%".$filtro."%' OR Nombre LIKE '%".$filtro."%'";
	}
	$ry= $qry." ORDER BY RFC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
	
	// A�ade parametros de b�squeda
	$result = $db->executeQuery($ry);	
	if ( mysql_num_rows($result) < 1){
		echo ("<tr class='tr-contv'>
			   <td colspan='7'><center>No se encontraron resultados</center></td></tr>");
	}else{	
		/* Agrega los resultados */
		while($fila = mysql_fetch_array($result))
		{		
			$id = $fila['RFC'];	
			$nombre = $fila['Nombre'];
			$telefono = $fila['Telefono'];
			$email = $fila['Email'];
			$direccion = $fila['Direccion'];
			$estado= $fila['Estado'];
			if($estado!="Eliminado")
			{
			echo ("<tr class='tr-contv' id='".$id."' name='".$id."'>
				<td>".$id."</td>
				<td>".$nombre."</td>
				<td>".$telefono."</td>
				<td>".$email."</td>
				<td>".$direccion."</td>
				<td><img src='../img/pencil.png' onclick='modificarCliente(\"".$id."\")' alt='Modificar' title='Modificar' class='clickable'/></td>
				<td><img src='../img/less.png'   onclick='eliminarCliente(\"".$id."\")' alt='Eliminar' title='Eliminar' class='clickable'/></td>
			</tr>");}
			else{echo ("<tr class='tr-contv' id='".$id."' name='".$id."'>
				<td>".$id."</td>
				<td>".$nombre."</td>
				<td>".$telefono."</td>
				<td>".$email."</td>
				<td>".$direccion."</td>
				<td colspan='2'><center><img src='../img/ok2.png' onclick='recuperarCliente(\"".$id."\")' alt='Eliminado' title='Recuperar' class='clickable'/></center></td>
			</tr>");}
		}echo '</table>';
		$NroRegistros=mysql_num_rows($db->executeQuery($qry));
		$PagAnt=$PagAct-1;
		$PagSig=$PagAct+1;
		$PagUlt=$NroRegistros/$RegistrosAMostrar;
		$Res=$NroRegistros%$RegistrosAMostrar;
		if($Res>0) $PagUlt=floor($PagUlt)+1;
		echo '<div id="Paginacion">';
		echo "<u><a class='click' onclick=\"Pagina('1')\">Primero </a></u>";	
		if($PagAct>1) echo "&nbsp;<u><a class='click'  onclick=\"Pagina('$PagAnt')\"> Anterior</a></u>";
		echo "&nbsp;<strong> Pagina ".$PagAct."/".$PagUlt."</strong>";
		if($PagAct<$PagUlt)  echo "&nbsp;<u> <a class='click'  onclick=\"Pagina('$PagSig')\"> Siguiente </a> </u>";
		echo "&nbsp;<u><a class='click'  onclick=\"Pagina('$PagUlt')\"> Ultimo</a></u>";
		echo "</div>";
	}
	
	//inipag
			
?>