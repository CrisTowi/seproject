<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Modulo de Producción</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
    </head>    
    <body>
    	 <?php include("header.php"); ?>

        <center>
        <div id="mainDiv">
            <nav>
<!--            
                <div class="button" onclick="redirect('GestionarLineas.php');">
                	<img src="../img/way.png"  alt="Icono" class="img-icon" />
                    	Gestión de Líneas
				</div>                
-->                
                <div class="button" onclick="redirect('GestionarLotes.php');">
                	<img src="../img/note.png"  alt="Icono" class="img-icon" />
                    	Gestión de Lotes
				</div>   
                <div class="button" onclick="redirect('ConsultarPedidos.php');">
                	<img src="../img/clock.png"  alt="Icono" class="img-icon" />
                    	Gestión de Pedidos
				</div>
<!--                
				<div class="button" onclick="redirect('ConsultarIngredientes.php');">
                	<img src="../img/search.png" alt="Icono" class="img-icon" />
                    	Consultar Disponibilidad de Ingredientes
				</div>				
-->                
                <div class="button" onclick="redirect('CrearReporte.php');" style="height:30px;">
                	<img src="../img/notepad.png"  alt="Icono" class="img-icon"/>
                    	Crear Reporte
				</div>			
            </nav>
            <div id="all-content">				
                <h2>Modulo de producción</h2>                
			</div>
        </div>
        </center>
        <!--<footer>Elaborado por nosotros(C) 2013</footer>-->
        <?php include("../php/footer.php"); ?>
    </body>   
</html>
<?php include("scripts.php"); ?>
