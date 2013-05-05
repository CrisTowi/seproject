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
        <?php include("crearepo.php"); ?>
        	
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
              	<object data="reporte.pdf" type="application/pdf" width="780" height="400">	</object>
			  </div></div>    
            </div>
		</center>
    </body>   
</html>
<?php include('scripts.php'); ?> 