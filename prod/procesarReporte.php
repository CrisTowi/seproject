<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title>Crear Reporte de Producción</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
		<script src="datepickers/jquery-1.9.1.js"></script>		
        <script src="datepickers/jquery-ui-1.10.2.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="datepickers/jquery-ui-1.10.2.custom.css" />

		<script type="text/javascript">
		    window.onload = resizeWindow;
		    window.onresize = resizeWindow;
			<!-- Funcion para redimensionar la ventana-->
		    function resizeWindow() {
                var w = window.innerWidth;
                if (w < 1060) {
                    var newSize = w - 260;
                    var windowSize = w - 60;
                    document.getElementById("all-content").style.width = new String(newSize) + "px";
                    document.getElementById("mainDiv").style.width = new String(windowSize) + "px";
                    console.log(newSize);
                    console.log(document.getElementById("all-content").style.width);
                } else {
                    document.getElementById("all-content").style.width = "800px";
                    document.getElementById("mainDiv").style.width = "1000px";
                }
		    }					
				   				   
		</script> 
		
		<?php
			include('crearPDF.php');
					
			$arrayMeses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio","Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			$dia = date("d");
			//echo $dia;
			$mes = (int)date("m");
			$anio = date("Y");			
			$fechaActual ="Hoy";  //Inicializar (Prevencion de errores)									
			$fechaActual = $dia." de ".$arrayMeses[$mes-1]." de ".$anio;			
			
			$fechaInicio=$_POST["fechaInicio"];
			$fechaFin = $_POST["fechaFin"];
			
			///Cambiar formato de fechas a SQL
			$valoresPrimera = explode ("/", $fechaInicio);   
			$valoresSegunda = explode ("/", $fechaFin); 
	
			$diaPrimera    = $valoresPrimera[0];  
			$mesPrimera  = $valoresPrimera[1];  
			$anyoPrimera   = $valoresPrimera[2]; 
			$diaSegunda   = $valoresSegunda[0];  
			$mesSegunda = $valoresSegunda[1];  
			$anyoSegunda  = $valoresSegunda[2];
			$fechaInicioSQL=$anyoPrimera."-".$mesPrimera."-".$diaPrimera;
			$fechaFinSQL=$anyoSegunda."-".$mesSegunda."-".$diaSegunda;
			//echo $fechaInicioSQL;
			//echo $fechaFinSQL;
			////
			
			//$tipoReporte = $_POST["tipoReporte"];
			
			//if($tipoReporte=="lotes")
				//$criterio = $_POST["ordenamientoLotes"];
			//else if($tipoReporte=="matPrima")
//				$criterio = $_POST["ordenamientoMatPrima"];

			if($_POST["ordenamientoLotes"] == "Nombre"){
				$criterio = "c.".$_POST["ordenamientoLotes"];
			}
			else if($_POST["ordenamientoLotes"] == "linea"){
				$criterio = "lp.no".$_POST["ordenamientoLotes"];				
			}
			else{
				$criterio = $_POST["ordenamientoLotes"];
			}
					
			$pdf=new PDF();
			$pdf->AddPage();
			$pdf->SetFont('Arial','bi',14);
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->Cell(80,6,'Cookies & System S.A. De C.V.',0,1,'L');
			$pdf->Cell(80,6,'México, D.F.',0,1,'L');
			$pdf->Cell(80,6,$fechaActual,0,1,'L');
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->SetFont('Arial','b',14);
			$pdf->Cell(80,6,'Reporte de Producción',0,1,'L');
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
			
			include("../php/DataConnection.class.php");		
			$db = new DataConnection();
			
			//$query = "SELECT * FROM reportesLotes where fechaElaboracion between '$fechaInicioSQL' and '$fechaFinSQL' order by $criterio, fechaElaboracion";
			$query = "select lp.noLote, c.Nombre, l.cantidadProducto, lp.nolinea, e.Nombre, l.fecha_elaboracion, l.fecha_caducidad   
					from lineaproduccion lp, lote l, producto c, empleado e
					where lp.noLote = l.idLote
					and l.idProducto = c.idProducto
					and e.CURP = lp.encargadoLinea
					and l.fecha_elaboracion between '$fechaInicioSQL' AND '$fechaFinSQL' order by $criterio, fecha_elaboracion";
					//echo "QUERY".$query."<br />";
			$result = $db->executeQuery($query);	
			

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
				$pdf->Cell(15,5,$row[2],1,0,'L',0);
				$pdf->Cell(15,5,$row[3],1,0,'L',0);
				$pdf->Cell(35,5,$row[4],1,0,'L',0);							
				$pdf->Cell(25,5,$row[5],1,0,'L',0);			
				$pdf->Cell(25,5,$row[6],1,1,'L',0);								
		
			}			
			
			$pdf->Output("reporte.pdf","F");
			
		?>			
		
    </head>    
    <body >
	<?php include("header.php"); ?>

        <center>
        <div id="mainDiv">
            <nav>
                <div class="button" onclick="redirect('GestionarLineas.php');">
                	<img src="../img/way.png"  alt="Icono" class="img-icon" />
                    	Gestión de Líneas
				</div>                
                <div class="button" onclick="redirect('GestionarLotes.php');">
                	<img src="../img/note.png"  alt="Icono" class="img-icon" />
                    	Gestión de Lotes
				</div>      
                <div class="button" onclick="redirect('ConsultarPedidos.php');">
                	<img src="../img/clock.png"  alt="Icono" class="img-icon"/>
                    	Gestión de Pedidos
				</div>                                                                   			          
                <div class="button" onclick="redirect('ConsultarIngredientes.php');">
                	<img src="../img/search.png" alt="Icono" class="img-icon" />
                    	Consultar Disponibilidad de Ingredientes
				</div>
                <div class="selected-button" onclick="redirect('CrearReporte.php');" style="height:30px;">
                	<img src="../img/notepad.png"  alt="Icono" class="img-icon" />
                    	Crear Reporte
				</div>
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