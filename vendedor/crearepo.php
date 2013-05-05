<?php
			include("crear.php");
			include("../php/DataConnection.class.php");
					
			$arrayMeses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio","Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
			$dia = date("d");
			$mes = (int)date("m");
			$anio = date("Y");			
			$fechaActual ="Hoy";  //Inicializar (Prevencion de errores)									
			$fechaActual = $dia." de ".$arrayMeses[$mes-1]." de ".$anio;			
			
			$fechaInicio=$_POST["from"];
			$fechaFin = $_POST["to"];
			
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
			$Cliente = $_POST["cliente"];
			//echo $Cliente;
			$Producto = $_POST["producto"];
			//echo $Producto;
			$pdf=new PDF();
			$pdf->AddPage();
			$pdf->SetFont('Arial','bi',14);
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->Cell(80,6,'Cookies & System S.A. De C.V.',0,1,'L');
			$pdf->Cell(80,6,'Mexico, D.F.',0,1,'L');
			$pdf->Cell(80,6,$fechaActual,0,1,'L');
			$pdf->Cell(40,10,'',0,1); //Linea vacia
			$pdf->SetFont('Arial','b',14);
			$pdf->Cell(80,6,'Reporte de Ventas',0,1,'L');
			$pdf->SetFont('Arial','',13);
			$pdf->Cell(40,4,'',0,1); //Linea vacia
			$pdf->Cell(120,6,'Periodo:    De    '.$fechaInicio.'    A    '.$fechaFin,0,1,'L');
			$pdf->Cell(40,6,'',0,1); //Linea vacia
			
			/////// Tabla (Reportes Gen�ricos)
			$pdf->SetFont('Arial','b',11);
			$pdf->Cell(20,5,'Folio',1,0,'L',0);
			$pdf->Cell(50,5,'RFC',1,0,'L',0);					
			$pdf->Cell(30,5,'Fecha Elab.',1,0,'L',0);			
			$pdf->Cell(30,5,'Fecha Ent.',1,0,'L',0);
			$pdf->Cell(30,5,'Estado.',1,1,'L',0);
			
			
			$pdf->SetFont('Arial','',11);
			$db = new DataConnection();	
			
			if($Cliente!='0' && $Producto=='0'){
			
				$qry = "SELECT * FROM Venta V, Cliente C WHERE C.RFC='$Cliente' and V.RFC='$Cliente' and V.Fecha between '$fechaInicioSQL' and '$fechaFinSQL'";
				//echo ("cliente");
					
				}
            if($Cliente=='0' && $Producto!='0'){
			
				$qry = "SELECT distinct(V.folio),V.RFC,V.Fecha,V.Fentrega,V.estado FROM Venta V, Producto P, lote L, articuloventa A WHERE P.idProducto=".$Producto." and L.idproducto=".$Producto." and A.idlote=L.numlote and A.folio=V.folio and  V.Fecha between '".$fechaInicioSQL."' and '".$fechaFinSQL."' Group By V.Folio";
				//echo ("producto");
				//aqui esta el error xq como el lote tiene 2 diferentes lotes de un mismo tipo de producto me jala 2 tuplas y no solo 1
					
				}
            if($Cliente=='0' && $Producto=='0'){
			    $qry = "SELECT * FROM Venta where Fecha between '$fechaInicioSQL' and '$fechaFinSQL'";
				//echo ("todos");
			}
			if($Cliente!='0' && $Producto!='0'){
			   $qry = "SELECT distinct(V.folio),V.RFC,V.Fecha,V.Fentrega,V.estado FROM Venta V, Cliente C, Producto P, lote L, articuloventa A WHERE C.RFC='$Cliente' and V.RFC='$Cliente' and P.idProducto='$Producto' and L.idproducto='$Producto' and A.idlote=L.numlote and A.folio=V.folio and  V.Fecha between '$fechaInicioSQL' and '$fechaFinSQL' Group By V.Folio";
				
				//echo ("cliente y prod");
			}
			
			
			//$qry= "SELECT * FROM Venta where Fecha between '$fechaInicio' and '$fechaFin'";
	
			$result = $db->executeQuery($qry);
			
			

			if (!$result) 
				die ("Database access failed: " . mysql_error());
		 
		
			$rows = mysql_num_rows($result);
				
						
			for ($j = 0 ; $j < $rows ; ++$j)
			{
				$row = mysql_fetch_row($result);
				$pdf->Cell(20,5,$row[0],1,0,'L',0);
				$pdf->Cell(50,5,$row[1],1,0,'L',0);
				$pdf->Cell(30,5,$row[2],1,0,'L',0);
				$pdf->Cell(30,5,$row[3],1,0,'L',0);	
				$pdf->Cell(30,5,$row[4],1,0,'L',0);	
				$pdf->Ln();	
				//$qry1 = "SELECT numlote,idProducto FROM Lote WHERE idProducto='$row[0]'";
				
				$qry1 = "SELECT P.Nombre, L.numlote, P.Precio,A.Estado FROM articuloventa A, producto P, lote L, venta V WHERE V.Folio='$row[0]' and A.Folio='$row[0]' and A.idlote=L.numlote and L.idProducto=P.idProducto";
				
				$result1 = $db->executeQuery($qry1);
				if (!$result1) 
				die ("Database access failed: " . mysql_error());
				$rows1 = mysql_num_rows($result1);
				for ($i = 0 ; $i < $rows1 ; ++$i){
					$row1 = mysql_fetch_row($result1);
					$pdf->Cell(90,5,'Producto:'.$row1[0],1,0,'L',0);
					$pdf->Cell(30,5,'NumLote:'.$row1[1],1,0,'L',0);
					$pdf->Cell(40,5,'Precio Unitario:'.$row1[2],1,0,'L',0);	
					//$pdf->Cell(30,5,$row1[3],1,0,'L',0);		
					$pdf->Ln();	
					
				}						
		
			}			
			
			$pdf->Output("reporte.pdf","F");
			
		?>		