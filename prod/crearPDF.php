<?php
require('/FPDF/fpdf.php');

class PDF extends FPDF
{
   //Cabecera de p�gina
   function Header()
   {

      $this->Image('img/logo2.png',130,10,80,30);

   }
}

?> 