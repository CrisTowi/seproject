<?php

//Es para importar los elementos de otro archivo .php

include("DataConnection.class.php");


$nombre = $_POST['name'];
$lote = $_POST['lote'];
$presentacion = $_POST['presentacion'];
$precio = $_POST['precio'];




$connection = new DataConnection();

$registro1 = $connection->executeQuery("SELECT * from Lote where idLote = '$lote';");

$connection = new DataConnection();

$registro1 = $connection->executeQuery("SELECT * from Lote L where idLote = '$lote'");

while($reg1 = mysql_fetch_array($registro1))
{
	
	$idLote = $reg1['idLote'];
	
}

//Crea la consulta a realizar

$connection->executeQuery("INSERT into Producto(Nombre, idLote, Presentacion, precio) VALUES('$nombre',$idLote,'$presentacion', $precio);");



$registro2 = $connection->executeQuery("SELECT p.idProducto from Producto p where p.Nombre = '$nombre';");
$connection->executeQuery("INSERT into Producto(Nombre,idLote,Presentacion, precio) VALUES('$nombre',$idLote, $presentacion, '$precio');");



$registro2 = $connection->executeQuery("SELECT p.idProducto from Producto p where p.Nombre = '$nombre'");

while($reg2 = mysql_fetch_array($registro2))
{
	
	$idProducto = $reg2['idProducto'];
	
}


header("Location: ../inventarios/ingresar_prod.php");


exit;

?>

