<?php
require('/FPDF/fpdf.php');

class PDF extends FPDF
{
   //Cabecera de página
   function Header()
   {

      $this->Image('logo2.png',130,10,80,30);

      //$this->SetFont('Arial','B',12);

      //$this->Cell(80,30,'Reporte de Producción',0,0,'L');

   }
}
/*
//Creación del objeto de la clase heredada
$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
//Aquí escribimos lo que deseamos mostrar...
//$pdf->Output();
$pdf->Output("reporte.pdf","F");
*/
?> 