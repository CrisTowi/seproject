<?php
require('/FPDF/fpdf.php');

class PDF extends FPDF
{
   //Cabecera de página
   function Header()
   {

      $this->Image('img/logo2.png',130,10,80,30);

   }
}

?> 