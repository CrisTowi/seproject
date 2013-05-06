<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Seguimiento</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">        
    </head>    
    <body>
    	<?php include("../php/header.php"); ?>
        <center>
        <div id="mainDiv">
            <nav>
                <div class="button" onclick="redirect('visualizaProblemas.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Visualizar problemas</div>
                <div class="selected-button" onclick="redirect('seguimiento.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Seguimiento de producto</div>
                <div class="button" onclick="redirect('crearReporte.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reporte general</div>
            </nav>
            <div id="all-content">				
                <h2>Seguimiento del producto</h2>
                <div id="content">                    
				<?php
					include("../php/DataConnection.class.php");					
					$db = new DataConnection();
					
					if ( $_GET["tipo"] == 1 ){
						
						$qry = "SELECT * FROM produccion,Empleado,Producto WHERE Producto.idProducto=produccion.idProducto and Empleado.CURP=idEmpleado and lote='".$_GET["numero"]."'";
						$result = $db->executeQuery($qry);
						
						if($fila = mysql_fetch_array($result)){
							echo "<table style='margin:50px;'>";
							echo "<tr><td style='width: 100px; background-color:#BBBBBB;'>Producto</td><td style='width: 300px;'>".$fila['Nombre']."</td></tr>";
							echo "<tr><td style='width: 100px; background-color:#BBBBBB;'>Empleado</td><td style='width: 300px;'>".$fila[7]."</td></tr>";
							echo "<tr><td style='width: 100px; background-color:#BBBBBB;'>Fecha de producción</td><td style='width: 300px;'>".$fila['fechaProduccion']."</td></tr>";
							echo "<tr><td style='width: 100px; background-color:#BBBBBB;'>Fecha de caducidad</td><td style='width: 300px;'>".$fila['fechaCaducidad']."</td></tr>";
							echo "</table>";
						}
						/*
						$qry = "SELECT * FROM produccion,Proveedor,IngredientesUsados,CompraMateriaPrima WHERE LoteProducto=produccion.idProducto and IngredientesUsados.LoteMateriaPrima=CompraMateriaPrima.LoteMateriaPrima and CompraMateriaPrima.idProveedor=Proveedor.idProveedor and CompraMateriaPrima.idMateriaPrima=MateriaPrima.idMateriaPrima and lote='".$_GET["numero"]."'";
						$result = $db->executeQuery($qry);
						
						if($fila = mysql_fetch_array($result)){
							echo "<table style='margin:50px;'>";
							echo "<tr><td style='width: 100px; background-color:#BBBBBB;'>Producto</td><td style='width: 300px;'>".$fila['Nombre']."</td></tr>";
							echo "<tr><td style='width: 100px; background-color:#BBBBBB;'>Empleado</td><td style='width: 300px;'>".$fila[7]."</td></tr>";
							echo "<tr><td style='width: 100px; background-color:#BBBBBB;'>Fecha de producción</td><td style='width: 300px;'>".$fila['fechaProduccion']."</td></tr>";
							echo "<tr><td style='width: 100px; background-color:#BBBBBB;'>Fecha de caducidad</td><td style='width: 300px;'>".$fila['fechaCaducidad']."</td></tr>";
							echo "</table>";
						}
						*/
						
					}
				
				?>
                </div>
            </div>
			
        </div>
        </center>
        <?php include("../php/footer.php"); ?>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script>
	function track(){
		redirect('tracking.php');
	}
</script>	