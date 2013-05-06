﻿<?php include("../php/AccessControl.php"); ?>
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
						
						$qry = "SELECT lote.*,lineaproduccion.*,empleado.Nombre as NombreEmpleado,empleado.CURP,producto.* FROM 
								lote,lineaproduccion,empleado,producto WHERE 
								lote.idProducto=producto.idProducto and
								lineaproduccion.nolote = lote.idLote and
								lineaproduccion.encargadoLinea = empleado.CURP and
								lote.idLote= ".$_GET["numero"];
								
						$result = $db->executeQuery($qry);
						
						if($fila = mysql_fetch_array($result)){
							echo "<h2>Detalles de la producción</h2>";
							echo "<table style='margin-left:50px;'>";
							echo "<tr><td style='width: 150px; background-color:#BBBBBB;'>No. de lote</td><td style='width: 300px;'>".$fila['idLote']."</td></tr>";
							echo "<tr><td style='background-color:#BBBBBB;'>Producto</td><td style='width: 300px;'>".$fila['Nombre']."</td></tr>";
							echo "<tr><td style='background-color:#BBBBBB;'>Empleado</td><td style='width: 300px;'>".$fila["CURP"]." - ".$fila["NombreEmpleado"]."</td></tr>";
							echo "<tr><td style='background-color:#BBBBBB;'>Fecha de producción</td><td style='width: 300px;'>".$fila['fecha_elaboracion']."</td></tr>";
							echo "<tr><td style='background-color:#BBBBBB;'>Fecha de caducidad</td><td style='width: 300px;'>".$fila['fecha_caducidad']."</td></tr>";
							echo "<tr><td style='background-color:#BBBBBB;'>Estado</td><td style='width: 300px;'>".$fila['estado']."</td></tr>";
							echo "<tr><td style='background-color:#BBBBBB;'>Cantidad</td><td style='width: 300px;'>".$fila['cantidadProducto']."</td></tr>";
							echo "</table>";
						}
						
						$qry = "SELECT * FROM venta,articuloventa,cliente WHERE
								venta.Folio = articuloventa.folio and
								cliente.RFC = venta.RFC and
								articuloventa.idLote='".$_GET["numero"]."'";
						$result = $db->executeQuery($qry);
						
						if($fila = mysql_fetch_array($result)){
							echo "<h2>Cliente</h2>";
							echo "<table style='margin-left:50px;margin-bottom:30px;'>";
							echo "<tr><td style='width: 150px; background-color:#BBBBBB;'>Cliente</td><td style='width: 300px;'>".$fila['RFC']." - ".$fila['Nombre']."</td></tr>";
							echo "<tr><td style='background-color:#BBBBBB;'>Dirección</td><td style='width: 300px;'>".$fila['Direccion']."</td></tr>";
							echo "<tr><td style='background-color:#BBBBBB;'>Fecha de compra</td><td style='width: 300px;'>".$fila['Fecha']."</td></tr>";
							echo "<tr><td style='background-color:#BBBBBB;'>Fecha de entrega</td><td style='width: 300px;'>".$fila['Fentrega']."</td></tr>";
							echo "</table>";
						}
						
						
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