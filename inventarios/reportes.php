<!DOCTYPE html>
<?php include("../php/AccessControl.php"); ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Inventarios</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="/resources/demos/style.css" />

        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

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
                <div id="content">
                    <form name="reporte" action="procesarR.php" method="post" name="frm">
    					<div class="box">
                            <h4>Selecciona el Área</h4>
                            <div class='option'><input type="radio" name="tipo" value="Materia" checked>Materia Prima</div>
                            <div class='option'><input type="radio" name="tipo" value="Producto" checked>Producto</div>
    					</div>
                        <div class="box">
                            <button name="mysubmitbutton" id="mysubmitbutton" type="submit" class="form-button">  
                                Generar Reporte
                            </button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<script type="text/javascript" src="../js/color.js"></script>
<script type="text/javascript" src="../js/inventarios.js"></script>
<script type="text/javascript">

</script> 
<script type="text/javascript" src="../js/jquery-1.5.1.js"></script>
<script type="text/javascript" src="../js/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/navigation.js"></script>    