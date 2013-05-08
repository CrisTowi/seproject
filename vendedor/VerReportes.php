<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="author" content="Ventas"/>
        <title>Ver Reporte</title>
          <link rel="stylesheet" type="text/css" href="../css/ventas.css" />
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />		       	
          <?php
			require('/FPDF/fpdf.php');
			class PDF extends FPDF{};
			include("../php/DataConnection.class.php");
					
			$arrayMeses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio","Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			$dia = date("d");
			$mes = (int)date("m");
			$anio = date("Y");			
			$fechaActual ="Hoy";  //Inicializar (Prevencion de errores)									
			$fechaActual = $dia." de ".$arrayMeses[$mes-1]." de ".$anio;			
			
			$fechaInicioSQL=$_POST["from"];
			$fechaFinSQL=$_POST["to"];
			
			$Cliente = $_POST["cliente"];
			//echo $Cliente;
			$Producto = $_POST["producto"];
			//echo $Producto;
			$Estado = $_POST["estados"];
			//echo $Estado;
			
			
			$db = new DataConnection();	
			//Para las consultas segun el criterio
			if($Cliente=='0' && $Producto=='0' && $Estado=='0'){//Todos
			    $qry = "SELECT * FROM Venta where Fecha between '$fechaInicioSQL' and '$fechaFinSQL'";
			}
			
			else if($Cliente!='0' && $Producto=='0'){
			    if($Estado!='0'){
			    	$qry = "SELECT * FROM Venta V, Cliente C WHERE C.RFC='$Cliente' and V.RFC='$Cliente' and V.Estado='$Estado' and V.Fecha between '$fechaInicioSQL' and '$fechaFinSQL'";
			    }
				
				else{//Por Cliente
				$qry = "SELECT * FROM Venta V, Cliente C WHERE C.RFC='$Cliente' and V.RFC='$Cliente' and V.Fecha between '$fechaInicioSQL' and '$fechaFinSQL'";
				}
					
			}
			else if($Cliente=='0' && $Producto!='0'){
                if($Estado!='0'){
                	$qry = "SELECT distinct(V.folio),V.RFC,V.Fecha,V.Fentrega,V.estado FROM Venta V, Producto P, lote L, articuloventa A WHERE P.idProducto=".$Producto." and L.idproducto=".$Producto." and A.idlote=L.idlote and A.folio=V.folio and V.Estado='$Estado' and  V.Fecha between '".$fechaInicioSQL."' and '".$fechaFinSQL."' Group By V.Folio";
                }
				
				else{//Por Producto
					$qry = "SELECT distinct(V.folio),V.RFC,V.Fecha,V.Fentrega,V.estado FROM Venta V, Producto P, lote L, articuloventa A WHERE P.idProducto=".$Producto." and L.idproducto=".$Producto." and A.idlote=L.idlote and A.folio=V.folio and  V.Fecha between '".$fechaInicioSQL."' and '".$fechaFinSQL."' Group By V.Folio";
					}
			
			}
           
            else if($Cliente!='0' && $Producto!='0'){
			  if($Estado!='0'){
			  	$qry = "SELECT distinct(V.folio),V.RFC,V.Fecha,V.Fentrega,V.estado FROM Venta V, Cliente C, Producto P, lote L, articuloventa A WHERE C.RFC='$Cliente' and V.RFC='$Cliente' and P.idProducto='$Producto' and L.idproducto='$Producto' and A.idlote=L.idlote and A.folio=V.folio and V.Estado='$Estado' and  V.Fecha between '$fechaInicioSQL' and '$fechaFinSQL' Group By V.Folio";
			  }
			  else{//Por Cliente y producto
			   $qry = "SELECT distinct(V.folio),V.RFC,V.Fecha,V.Fentrega,V.estado FROM Venta V, Cliente C, Producto P, lote L, articuloventa A WHERE C.RFC='$Cliente' and V.RFC='$Cliente' and P.idProducto='$Producto' and L.idproducto='$Producto' and A.idlote=L.idlote and A.folio=V.folio and  V.Fecha between '$fechaInicioSQL' and '$fechaFinSQL' Group By V.Folio";
			  }
			}
           else if($Cliente=='0' && $Producto=='0' && $Estado!='0'){//Solo estados
			    $qry = "SELECT * FROM Venta where Estado='$Estado' and Fecha between '$fechaInicioSQL' and '$fechaFinSQL'";
				
			}
			
			
	
			$result = $db->executeQuery($qry);
			if (!$result) 
				die ("Database access failed: " . mysql_error());
		    $rows = mysql_num_rows($result);
			                
			               
							
			//Creacion del PDF
			$pdf=new PDF();
			$pdf->AddPage();
			$pdf->Image('logo2.png',130,10,80,30);
			$pdf->SetFont('Arial','bi',14);
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->Cell(80,6,'Cookies & System S.A. De C.V.',0,1,'L');
			$pdf->Cell(80,6,'Mexico, D.F.',0,1,'L');
			$pdf->Cell(80,6,$fechaActual,0,1,'L');
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			//Condicion si encuentra Resultados o no
			if($rows=='0'){$pdf->SetFont('Arial','bi',14);
			$pdf->Cell(80,6,'Las ventas del     '.$fechaInicioSQL.'    al    '.$fechaFinSQL.'    no muestran ningun resultado',0,0,'L',0);}
			
			
			//inicia creacion de tuplas
            else{
			$pdf->SetFont('Arial','b',14);
			if($Producto=='0' && $Cliente=='0'){//Todas
				if($Estado!='0'){
						$qryc = "SELECT Estado FROM Venta WHERE Estado='$Estado'";
						$resultc = $db->executeQuery($qryc);
						if (!$resultc) 
							die ("Database access failed: " . mysql_error());
						$rowc = mysql_fetch_row($resultc);
					   $pdf->Cell(80,6,'Reporte de todas las ventas con estado: ' .$rowc[0],0,1,'L');
				}
	            else{$pdf->Cell(80,6,'Reporte de todas las Ventas',0,1,'L');}
				}
			else{
				if($Cliente!='0' && $Producto=='0')//Para solo cliente
				{
				 if($Estado!='0'){
				 	$qryc = "SELECT C.Nombre,E.Estado FROM Cliente C, Venta E WHERE C.RFC='$Cliente' and E.Estado='$Estado'";
					$resultc = $db->executeQuery($qryc);
					if (!$resultc) 
						die ("Database access failed: " . mysql_error());
					$rowc = mysql_fetch_row($resultc);
					//
					$pdf->Cell(80,6,'Reporte de Ventas Del Cliente: ' .$rowc[0],0,1,'L');
					$pdf->Cell(80,6,'Con Estado: ' .$rowc[1],0,1,'L');
				 }
				 else{
				 //obtener el nomnbre del cliente
					$qryc = "SELECT Nombre FROM Cliente WHERE RFC='$Cliente'";
					$resultc = $db->executeQuery($qryc);
					if (!$resultc) 
						die ("Database access failed: " . mysql_error());
					$rowc = mysql_fetch_row($resultc);
					$pdf->Cell(80,6,'Reporte de Ventas Del Cliente: ' .$rowc[0],0,1,'L');}
				}
				if($Cliente=='0' && $Producto!='0')//Para solo producto
				{
					if($Estado!='0'){
					$qryc = "SELECT P.Nombre,E.Estado FROM Producto P, Venta E WHERE P.idProducto='$Producto' and E.Estado='$Estado'";
					$resultc = $db->executeQuery($qryc);
					if (!$resultc) 
						die ("Database access failed: " . mysql_error());
					$rowc = mysql_fetch_row($resultc);
					$pdf->Cell(80,6,'Reporte de Ventas Del Producto: ' .$rowc[0],0,1,'L');
					$pdf->Cell(80,6,'Con Estado: ' .$rowc[1],0,1,'L');
					}
					else{
						$qryc = "SELECT Nombre FROM producto WHERE idProducto='$Producto'";
					$resultc = $db->executeQuery($qryc);
					if (!$resultc) 
						die ("Database access failed: " . mysql_error());
					$rowc = mysql_fetch_row($resultc);
					$pdf->Cell(80,6,'Reporte de Ventas Del Producto: ' .$rowc[0],0,1,'L');
					
					}
					
				}
                if($Cliente!='0' && $Producto!='0')//Cliente y Productos
                {
                	
                	if($Estado!='0'){
					$qryc = "SELECT P.Nombre, C.Nombre, E.Estado FROM producto P, Cliente C, Venta E WHERE P.idProducto='$Producto' and C.RFC='$Cliente' and E.Estado='$Estado'";
					$resultc = $db->executeQuery($qryc);
					if (!$resultc) 
						die ("Database access failed: " . mysql_error());
					$rowc = mysql_fetch_row($resultc);
					$pdf->Cell(80,6,'Reporte de Ventas Del Cliente: ' .$rowc[1],0,1,'L');
					$pdf->Cell(80,6,'Del Producto: ' .$rowc[0],0,1,'L');
					$pdf->Cell(80,6,'Y Estado: ' .$rowc[2],0,1,'L');
                	}
					else{
					$qryc = "SELECT P.Nombre, C.Nombre FROM producto P, Cliente C WHERE P.idProducto='$Producto' and C.RFC='$Cliente'";
					$resultc = $db->executeQuery($qryc);
					if (!$resultc) 
						die ("Database access failed: " . mysql_error());
					$rowc = mysql_fetch_row($resultc);
					$pdf->Cell(80,6,'Reporte de Ventas Del Cliente: ' .$rowc[1],0,1,'L');
					$pdf->Cell(80,6,'Y Producto: ' .$rowc[0],0,1,'L');}
                	
                }
				
			}
			$pdf->SetFont('Arial','',13);
			$pdf->Cell(40,4,'',0,1); //Linea vacia
			$pdf->Cell(120,6,'Periodo:    De    '.$fechaInicioSQL.'    A    '.$fechaFinSQL,0,1,'L');
			$pdf->Cell(40,6,'',0,1); //Linea vacia
				$Total=0.0;
			
			//Lenado de las tablas		
			for ($j = 0 ; $j < $rows ; ++$j)//Para la venta
			{
				$row = mysql_fetch_row($result);
				//Cabeceras Principales
				$pdf->SetFont('Arial','b',11);
				$pdf->Cell(20,5,'Folio',1,0,'L',0);
				$pdf->Cell(50,5,'RFC',1,0,'L',0);					
				$pdf->Cell(30,5,'Fecha Elab.',1,0,'L',0);			
				$pdf->Cell(30,5,'Fecha Ent.',1,0,'L',0);
				$pdf->Cell(30,5,'Estado.',1,1,'L',0);
				$pdf->SetFont('Arial','',11);
				//Tuplas
				$pdf->Cell(20,5,$row[0],1,0,'L',0);
				$pdf->Cell(50,5,$row[1],1,0,'L',0);
				$pdf->Cell(30,5,$row[2],1,0,'L',0);
				$pdf->Cell(30,5,$row[3],1,0,'L',0);	
				$pdf->Cell(30,5,$row[4],1,0,'L',0);	
				$pdf->Ln();	
				//Cabeceras de Articulos
				$pdf->SetFont('Arial','b',11);
				$pdf->Cell(90,5,'Producto',1,0,'L',0);
				$pdf->Cell(30,5,'NumLote',1,0,'L',0);					
				$pdf->Cell(40,5,'Precio Unitario.',1,0,'L',0);
				$pdf->SetFont('Arial','',11);
				$pdf->Ln();	
				
				$qry1 = "SELECT P.Nombre, L.idlote, P.Precio,A.Estado FROM articuloventa A, producto P, lote L, venta V WHERE V.Folio='$row[0]' and A.Folio='$row[0]' and A.idlote=L.idlote and L.idProducto=P.idProducto";
				$qry2= "SELECT SUM( P.precio ) as 'T' FROM producto P, venta V, ArticuloVenta A, lote l WHERE v.folio = a.folio AND a.idlote = l.idlote AND l.idproducto = p.idproducto AND v.folio ='$row[0]' and A.folio='$row[0]'";
				
				$result1 = $db->executeQuery($qry1);
				$resulta = $db->executeQuery($qry2);
				$fila = mysql_fetch_array($resulta);
				if (!$result1) 
				die ("Database access failed: " . mysql_error());
				$rows1 = mysql_num_rows($result1);
				for ($i = 0 ; $i < $rows1 ; ++$i){//Para los articulos de venta
					$row1 = mysql_fetch_row($result1);
					//Tuplas
					$pdf->Cell(90,5,$row1[0],1,0,'L',0);
					$pdf->Cell(30,5,$row1[1],1,0,'L',0);
					$pdf->Cell(40,5,$row1[2],1,0,'L',0);			
					$pdf->Ln();	
				}
				$pdf->Cell(90,5,"",0,0,'L',0);
			    $pdf->Cell(30,5,"Total de Venta:",1,0,'L',0);
				$pdf->Cell(40,5,"$".$fila['T'],1,0,'L',0);
				$Total+=$fila['T'];
				$pdf->Cell(40,10,'',0,1);//linea en blanco	
								
			}			
			$pdf->SetFont('Arial','bi',14);
			$pdf->Cell(80,6,'Total de Ventas: $'.$Total,0,1,0,0);}	
			$pdf->Output("reporte.pdf","F");
			
		?>				
        	
    </head>    
    <body>
    	 
	<!-- El header es el mismo para todas las paginas-->
    	
       <?php include('header.php');?> 
       <center>
        <div id="mainDiv">
		<!-- Aquí se coloca el menú -->
          <nav>
			      <div id="GV" class="button" onClick="window.location ='GestionV.php'"><img src="../img/archive.png"  alt="Icono" class="img-icon"/>Gestión de Ventas</div>     
				  <div id="GC" class="button" onClick="window.location ='GestionC.php'"><img src="../img/card.png"  alt="Icono" class="img-icon"/>Gestión de Clientes</div>
				  <div id="rep" class="selected-button" onClick="window.location ='Reportes.php'"><img src="../img/notepad.png"  alt="Icono" class="img-icon"/>Crear Reportes</div>
			</nav>
			<!-- Divisor del contenido de la pagina -->
            <div id="all-content">
              <div id="VR">
              	<object data="reporte.pdf" type="application/pdf" width="780" height="450">	</object>
			  </div>	
                </div>				
                
            </div>
			</center>
    </body>   
</html>
<?php include('scripts.php'); ?> 