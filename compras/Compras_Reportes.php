<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>M&oacute;dulo Compras</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
		<script src="js/jquery.ui.datepicker-es.js"></script>
		
	</head>    
    <body>
    	<?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
		<!-- Aquí se coloca el menú -->
            <nav>
				<div class="button" onclick="redirect('gestionProveedores.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gesti&oacute;n de Proveedores</div>
                <div class="button" onclick="redirect('IngresarMP.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Gesti&oacute;n de Materia Prima</div>
                <div class="button" onclick="redirect('Compras_Reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes</div>
            </nav>
			<!-- Divisor del contenido de la pagina -->
            <div id="all-content">
				<h2>Creaci&oacute;n de reporte</h2>
                <div id="content">
                    <div class="box">
                       Fecha inicial: <input type="text" id="from" name="from" placeholder="Fecha de inicio"/>*
                    </div>
                    <div class="box">
                       Fecha final: <input type="text" id="to" name="to" placeholder="Fecha de fin"/> *
                    </div>
                    <div class="box">
                        <h4>&Aacute;reas que abarcar&aacute; el reporte</h4>
                        <div class="option"><input type="radio" name="tipo" value="tipo" checked > Mejores Proveedores</div>
                        <div class="option"><input type="radio" name="tipo" value="tipo"> Materia Prima mas Usada</div>
                        </div>            
                    <div class="box">
                       Producto: <select><option>Producto1</option><option>Producto2</option></select>
                    </div> 
					*Obligatorio	
                    <div class="box">
                        <div class="form-button">Crear reporte</div>
                    </div>
                </div>
            </div>
			
        </div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>