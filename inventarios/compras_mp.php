<!DOCTYPE html>
<?php include("../php/AccessControl.php"); ?>
<html lang='es'>
    <head>
        <meta charset='utf-8' http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Gestionar Materia Prima</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">     
    </head>    
    <body>
        <?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
             <nav>
                <div class="selected-button" onclick="redirect('compras_mp.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Compras Pendientes</div>
                <div class="button" onclick="redirect('gestion_ma.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Materia Prima</div>
                <div class="button" onclick="redirect('ingresar_man.php');"><img src="../img/note.png"  alt="Icono" class="img-icon" />Ingresar Materia Prima</div>
                <div class="button" onclick="redirect('gestion_p.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Productos</div>
                <div class="button" onclick="redirect('reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes </div>
               
            </nav>  
            <div id="all-content">
                <h2>Gestión de Materias Primas</h2>
                <div id="content">
                    <div class="box">
                        <table>
                            <tr>
                                <td class="auxiliarB"></td>
                                <td class="auxiliarB"></td>
                                <td class="auxiliarB">
                                <input type="text" id="buscar" name="buscar" placeholder = "Buscar Materias Primas" class="searchBar" style="width:250px;"/>
                                </td>
                                <td>
                                    <img src="../img/busc.png" class="img-buscar"  alt="Buscar" onClick="onClickBusqueda();"/>
                                </td>
                            </tr>

                        </table>
                    </div>   
                    <div id="tablaCompras" class="box">
                        <?php include("TablaCompras.php"); ?>
                    </div>
                    
                    </div>                          
                </div>
            </div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script type="text/javascript" src="../js/color.js"></script>
<script type="text/javascript" src="../js/inventarios.js"></script>
<script type="text/javascript">
    window.onload = initialize;
    window.onresize = function () { resizeWindow(document) };
    function initialize() {
        resizeWindow(document);
    }


    function onClickBusqueda(){
        loadTable();
    }

    function AgregarCompra(id){
        redirect("ingresar_ma.php?id=" + id);
    }

    function eliminarEmpleado(id){
        if ( confirm("¿Seguro que desea eliminar al MA con id " + id +"?") ){
            sendPetitionQuery("EliminarMA.php?id=" + id );
            alert("Materia Prima Eliminada");
            loadTable();
        }
    }
    function loadTable(){


        filtro = document.getElementById('buscar').value;
        sendPetitionSync("TablaCompras.php?search=" + filtro ,"tablaCompras",document);
        rePaint();
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
