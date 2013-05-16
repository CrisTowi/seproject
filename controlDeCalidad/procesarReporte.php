<?php include("../php/AccessControl.php"); 
include("../php/DataConnection.class.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Reportes</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
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
			
			$pdf=new PDF();
			$pdf->AddPage();
			$pdf->SetFont('Arial','bi',14);
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->Cell(80,6,'Cookies & System S.A. De C.V.',0,1,'L');
			$pdf->Cell(80,6,utf8_decode('México, D.F.'),0,1,'L');
			$pdf->Cell(80,6,$fechaActual,0,1,'L');
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->SetFont('Arial','b',14);
			$pdf->Cell(80,6,'Reporte de problemas',0,1,'L');
			$pdf->SetFont('Arial','',13);
			$pdf->Cell(40,4,'',0,1); //Linea vacia
			$pdf->Cell(120,6,'Periodo:    De    '.$fechaInicio.'    A    '.$fechaFin,0,1,'L');
			$pdf->Cell(40,6,'',0,1); //Linea vacia						
			$db = new DataConnection();				
			$mask = $_POST["mask"];			
			$qry = "SELECT * FROM Mensajes,Empleado,Area WHERE Mensajes.remitente = Empleado.CURP and Empleado.Area = Area.id and Mensajes.problema = 1";
			$qry .= " and fecha >= '".$_POST["from"]."' and fecha <= '".$_POST["to"]."'";
			$qry .= " and ( ";
			$area = 0;
			if ( ($mask & 16) == 16 ){
				$qry.= " destinatario=1 ";
				$area = 1;
			}
			if ( ($mask & 8) == 8 ){
				if(  $area == 1 ) $qry.= " or ";
				$qry.= " destinatario=6 ";
				$area = 1;
			}
			if ( ($mask & 4) == 4 ){
				if(  $area == 1 ) $qry.= " or ";
				$qry.= " destinatario=4 ";
				$area = 1;
			}
			if ( ($mask & 2) == 2 ){
				if(  $area == 1 ) $qry.= " or ";
				$qry.= " destinatario=2 ";
				$area = 1;
			}
			if ( ($mask & 1) == 1 ){
				if(  $area == 1 ) $qry.= " or ";
				$qry.= " destinatario=3 ";
			}
			$qry .= " ) ORDER BY ";
			if ( $_POST["order"] == 1 ){
				$qry .= " destinatario ";
			}else{
				$qry .= " fecha ";
			}
			
			$result = $db->executeQuery($qry);	
			$rows = mysql_num_rows($result);	
				
			$pdf->SetFont('Arial','b',11);
			$pdf->Cell(40,5,'Area',1,0,'L',0);
			$pdf->Cell(40,5,'Fecha',1,0,'L',0);
			$pdf->Cell(100,5,'Estatus',1,1,'L',0);					
			$cont = 1;
			while( $dato = mysql_fetch_row($result) ){
				$pdf->SetFont('Arial','b',11);
				$pdf->Cell(180,5,"Mensaje ".$cont,1,1,'L',0);
				$pdf->SetFont('Arial','',11);
				$pdf->Cell(40,5,$dato[15],1,0,'L',0);
				$pdf->Cell(40,5,$dato[3],1,0,'L',0);
				$pdf->Cell(100,5,$dato[8] == 1 ? "Solucionado" : "Pendiente" ,1,1,'L',0);
				$pdf->Cell(180,5,utf8_decode($dato[2]),1,1,'L',0);
				$cont++;				
			}
			$pdf->Output("reporte.pdf","F");			
		?>			
			
	</head>    
    <body>
    	<?php include("../php/header.php"); ?>
        <center>
        <div id="mainDiv">
			<!-- Aquí se coloca el menú -->
            <nav>
                <div class="button" onclick="redirect('visualizaProblemas.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Visualizar problemas</div>
                <div class="button" onclick="redirect('seguimiento.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Seguimiento de producto</div>
                <div class="selected-button" onclick="redirect('crearReporte.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reporte general</div>
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
        <?php include("../php/footer.php"); ?>
    </body>   
</html>
<?php include("scripts.php"); ?>