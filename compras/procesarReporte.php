<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>M&oacute;dulo Compras</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
		<script src="js/jquery.ui.datepicker-es.js"></script>
	<?php
			include('crearPDF.php');
					
			$arrayMeses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio","Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			$dia = date("d");
			$mes = (int)date("m");
			$anio = date("Y");			
			$fechaActual ="Hoy";  //Inicializar (Prevencion de errores)									
			$fechaActual = $dia." de ".$arrayMeses[$mes-1]." de ".$anio;			
			
			$fechaInicio=$_POST["from"];
			$fechaFin = $_POST["to"];
			
			///Cambiar formato de fechas a SQL
			//$valoresPrimera = explode ("/", $fechaInicio);   
			//$valoresSegunda = explode ("/", $fechaFin); 
	
			//$diaPrimera    = $valoresPrimera[0];  
			//$mesPrimera  = $valoresPrimera[1];  
			//$anyoPrimera   = $valoresPrimera[2]; 
			//$diaSegunda   = $valoresSegunda[0];  
			//$mesSegunda = $valoresSegunda[1];  
			//$anyoSegunda  = $valoresSegunda[2];
			//$fechaInicioSQL=$anyoPrimera."-".$mesPrimera."-".$diaPrimera;
			//$fechaFinSQL=$anyoSegunda."-".$mesSegunda."-".$diaSegunda;
			//echo $fechaInicioSQL;
			//echo $fechaFinSQL;
			////
			
			//$tipoReporte = $_POST["tipoReporte"];
			
			if($tipoReporte=="lotes")
				$criterio = $_POST["ordenamientoLotes"];
			else if($tipoReporte=="matPrima")
				$criterio = $_POST["ordenamientoMatPrima"];
					
			$pdf=new PDF();
			$pdf->AddPage();
			$pdf->SetFont('Arial','bi',14);
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->Cell(80,6,'Cookies & System S.A. De C.V.',0,1,'L');
			$pdf->Cell(80,6,'México, D.F.',0,1,'L');
			$pdf->Cell(80,6,$fechaActual,0,1,'L');
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->SetFont('Arial','b',14);
			$pdf->Cell(80,6,'Reporte de Compras',0,1,'L');
			$pdf->SetFont('Arial','',13);
			$pdf->Cell(40,4,'',0,1); //Linea vacia
			$pdf->Cell(120,6,'Periodo:    De    '.$fechaInicio.'    A    '.$fechaFin,0,1,'L');
			$pdf->Cell(40,6,'',0,1); //Linea vacia
			
			/////// Tabla (Reportes Genéricos)
			$pdf->SetFont('Arial','b',11);
			$pdf->Cell(18,5,'No. Lote',1,0,'L',0);
			$pdf->Cell(60,5,'Producto',1,0,'L',0);
			$pdf->Cell(15,5,'Cant.',1,0,'L',0);
			$pdf->Cell(15,5,'Línea',1,0,'L',0);
			$pdf->Cell(35,5,'Encargado',1,0,'L',0);						
			$pdf->Cell(25,5,'Fecha Elab.',1,0,'L',0);			
			$pdf->Cell(25,5,'Fecha Cad.',1,1,'L',0);
			
			$pdf->SetFont('Arial','',11);
			
			require_once 'conexion.php';
			//echo $criterio;
			//$query = "SELECT * FROM reportesLotes order by $criterio, fechaElaboracion";
			$query = "SELECT * FROM reportesLotes where fechaElaboracion between '$fechaInicioSQL' and '$fechaFinSQL' order by $criterio, fechaElaboracion";
			$result = mysql_query($query);

			if (!$result) 
				die ("Database access failed: " . mysql_error());
		
			$rows = mysql_num_rows($result);	
			
			if($rows==0)				
				echo "<script type='text/javascript'> 
						$(document).ready(function() {
					
					$.Zebra_Dialog('No se encontraron registros de la información que solicitó. Vuelva a intentarlo con nuevos valores de búsqueda.', {
							'type':     'warning',
							'title':    'Operación Incompleta',
							'onClose':  function(caption) {
								window.location = 'crearReporte.html';
							}
						});
					});
				</script>";
			else
				echo "<script type='text/javascript'> 
						$(document).ready(function() {
					
					$.Zebra_Dialog('Se ha producido su reporte satisfactoriamente.', {
							'type':     'confirmation',
							'title':    'Operación Exitosa'
						});
					});
				</script>";
			
			for ($j = 0 ; $j < $rows ; ++$j)
			{
				$row = mysql_fetch_row($result);
				$pdf->Cell(18,5,$row[0],1,0,'L',0);
				$pdf->Cell(60,5,$row[1],1,0,'L',0);
				$pdf->Cell(15,5,$row[4],1,0,'L',0);
				$pdf->Cell(15,5,$row[2],1,0,'L',0);
				$pdf->Cell(35,5,$row[3],1,0,'L',0);							
				$pdf->Cell(25,5,$row[5],1,0,'L',0);			
				$pdf->Cell(25,5,$row[6],1,1,'L',0);								
		
			}			
			
			$pdf->Output("reporte.pdf","F");
			
		?>			
			
	</head>    
    <body>
    	<?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
		<!-- Aquí se coloca el menú -->
            <nav>
				<div class="button" onclick="redirect('gestionProveedores.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gesti&oacute;n de Proveedores</div>
                <div class="button" onclick="redirect('IngresarMP.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Gesti&oacute;n de Materia Prima</div>
                <div class="button" onclick="redirect('Compras_Reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes</div>
            </nav>
			<!-- Divisor del contenido de la pagina -->
            <div id="all-content">
				<h2>Visualización de Reportes</h2>      
                <div style="border-style:solid; height:400px; width:700px; float: left; margin-left:50px;">
			
				<object data="reporte.pdf" type="application/pdf" width="700" height="400">	</object>
			
				</div>	
            </div>
			
        </div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>