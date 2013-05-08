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
        <?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
             <nav>
                <div class="button" onclick="redirect('compras_mp.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Compras Pendientes</div>
                <div class="button" onclick="redirect('gestion_ma.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Materia Prima</div>
                <div class="button" onclick="redirect('ingresar_ma.php');"><img src="../img/note.png"  alt="Icono" class="img-icon" />Ingresar Materia Prima</div>
                <div class="button" onclick="redirect('gestion_p.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Productos</div>
                <div class="button" onclick="redirect('reportes_ma.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes de Materia Prima</div>
                <div class="selected-button" onclick="redirect('reportes_p.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes de Productos</div>
            </nav>  
            <!-- Divisor del contenido de la pagina -->
            <div id="all-content">
                
                <h2>Creación de reporte de Productos</h2>
                <div id="content">
                    <form action="../php/procesar.php" method="post" name="frm">
                        <div class="box">
                            <table>

                            <tr>
                               <td style="color: white;">Nombre: </td>
                               <td><input type="text" style="width:150px;" id="name" name="name" placeholder="Escriba su nombre"/></td>
                            </tr>

                            <tr>
                               <td style="color: white;">Comprador: </td>
                               <td><input type="text" style="width:150px;" id="provider" name="provider" placeholder="Escriba el comprador"/></td>
                            </tr>

                            <tr>
                                <td style="color: white;">Cantidad: </td>
                                <td>
                                    <input type="text" style="width:150px;" id="cantidad" name="cantidad" min="0" max="10000" placeholder="La cantidad comprada">
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white;">Precio:</td>
                                <td>
                                    <input type="text" style="width:150px;" id="precio" name="precio" min="0" max="10000" placeholder="El precio de la compra"> 
                                </td>
                            </tr>

                            <tr>
                               <td style="color: white;">Fecha del Reporte: </td>
                               <td><input type="date" style="width:160px;" id="from" name="from" placeholder="yyyy-mm-dd"/></td>
                            </tr>
                            </table>
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
    window.onload = initialize;
    window.onresize = function () { resizeWindow(document) };
    function initialize() {
        resizeWindow(document);
    }
    $(function () {
        var dates = $("#from, #to").datepicker
		(
			{
			    defaultDate: "+1w",
			    changeMonth: true,
			    changeYear: true,
			    numberOfMonths: 1,

			    onSelect: function (selectedDate) {
			        var option = this.id == "from" ? "minDate" : "maxDate",
						instance = $(this).data("datepicker"),
						date = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings);
			        dates.not(this).datepicker("option", option, date);
			    }
			}
		);
    });
</script> 
<script type="text/javascript" src="../js/jquery-1.5.1.js"></script>
<script type="text/javascript" src="../js/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../js/navigation.js"></script>    