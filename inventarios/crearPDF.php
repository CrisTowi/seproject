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

?> 