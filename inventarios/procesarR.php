<?php include("../php/AccessControl.php"); 
include("../php/DataConnection.class.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Inventarios</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="/resources/demos/style.css" />

	<?php
			include('crearPDF.php');
			$arrayMeses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio","Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			$dia = date("d");
			$mes = (int)date("m");
			$anio = date("Y");			
			$fechaActual ="Hoy";  //Inicializar (Prevencion de errores)									
			$fechaActual = $dia." de ".$arrayMeses[$mes-1]." de ".$anio;			
			
					
			$pdf=new PDF();
			$pdf->AddPage();
			$pdf->SetFont('Arial','bi',14);
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->Cell(80,6,'Cookies & System S.A. De C.V.',0,1,'L');
			$pdf->Cell(80,6,'Mexico, D.F.',0,1,'L');
			$pdf->Cell(80,6,$fechaActual,0,1,'L');
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->SetFont('Arial','b',14);
			$pdf->Cell(80,6,'Reporte de Inventario',0,1,'L');
			$pdf->SetFont('Arial','',13);
			$pdf->Cell(40,4,'',0,1); //Linea vacia
			$pdf->Cell(40,6,'',0,1); //Linea vacia
			$tipoReporte = $_POST["tipo"];

			if($tipoReporte=="Producto"){
				$db = new DataConnection();

				$qry = "SELECT P.idProducto,P.Nombre, P.precio,P.Clave FROM Producto P";	
				$result = $db-> executeQuery($qry);

				$pdf->SetFont('Arial','b',11);
					$pdf->Cell(50,5,'Nombre',1,0,'L',0);
					$pdf->Cell(40,5,'Precio',1,0,'L',0);
					$pdf->Cell(20,5,'Clave',1,1,'L',0);
					
					$pdf->SetFont('Arial','',11);

				if(!$result)
					die("Database access failed".mysql_error());

				$rows = mysql_num_rows($result);	

				for($j=0; $j < $rows; ++$j){
					$row = mysql_fetch_row($result);
							$pdf->Cell(50,5,$row[1],1,0,'L',0);	
							$pdf->Cell(40,5,$row[2],1,0,'L',0);
							$pdf->Cell(20,5,$row[3],1,1,'L',0);
				}
					
			}
			else if($tipoReporte="Materia"){
				$db = new DataConnection();
				$qry = "SELECT M.idMateriaPrima as IDM,MP.Nombre, M.Fecha_Caducidad, M.RFC as proveedor 
						from inventario_mp M, materiaprima MP where M.idMateriaPrima=MP.idMateriaPrima group by M.idMateriaPrima";
				$result= $db-> executeQuery($qry);

				$pdf->Setfont('Arial','b',11);
					$pdf->Cell(50,5,'Materia Prima',1,0,'L',0);
					$pdf->Cell(40,5,'Caducidad',1,0,'L',0);
					$pdf->Cell(40,5,'Proveedor',1,1,'L',0);


					$pdf->SetFont('Arial','',11);

				if(!$result)
					die("Database access failed".mysql_error());

				$rows = mysql_num_rows($result);

				for($j=0; $j<$rows; ++$j){
					$row = mysql_fetch_row($result);
							$query2 = "Select Nombre from materiaprima where idMateriaPrima='".$row[0]."'";
							$result2=$db->executeQuery($query2);	
							$nombreM=mysql_fetch_row($result2);	
							$pdf->Cell(50,5,$nombreM[0],1,0,'L',0);
							$pdf->Cell(40,5,$row[2],1,0,'L',0);
							$pdf->Cell(40,5,$row[3],1,1,'L',0);
				}
			}
			
			$pdf->Output("reporte.pdf","F");	
	?>			
			
	</head>    
        <body>
    <!-- El header es el mismo para todas las paginas-->
        <?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
        <!-- Aquí se coloca el menú -->
             <nav>
                <div class="button" onclick="redirect('compras_mp.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Compras Pendientes</div>
                <div class="button" onclick="redirect('gestion_ma.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Materia Prima</div>
                <div class="button" onclick="redirect('ingresar_ma.php');"><img src="../img/note.png"  alt="Icono" class="img-icon" />Ingresar Materia Prima</div>
                <div class="button" onclick="redirect('gestion_p.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Productos</div>
                <div class="selected-button" onclick="redirect('reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes</div>
            </nav>  
 
           <!-- Divisor del contenido de la pagina -->
            <div id="all-content">
				
                <h2>Creación de Reportes</h2>
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