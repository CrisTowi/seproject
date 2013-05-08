<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Gestionar Producto</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">     
    </head>    
    <body>
        <?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
        <!-- Aquí se colorca el menú -->
             <nav>
                <div class="selected-button"><img src="../img/archive.png"  alt="Icono" class="img-icon"/>Gestión de Materia Prima
                    <ul class="sub-level" type="none">
                        <li onclick="redirect('gestion_ma.php');">Gestión de Materia Prima</li>
                        <li onclick="redirect('ingresar_ma.php');">Ingresar Materia Prima</li>

                    </ul>
                </div>
                <div class="button" onclick="redirect('gestion_p.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Productos</div>
                <div class="button"><img src="../img/notepad.png"  alt="Icono" class="img-icon"/>Reportes
                        <ul class="sub-level" type="none">
                            <li onclick="redirect('reportes_ma.php');">Generar Reporte Materias Primas</li>
                            <li onclick="redirect('reportes_p.php');">Generar Reporte de Productos</li>
                        </ul>
                </div>
            </nav>  
  <!-- Divisor del contenido de la pagina -->
            <div id="all-content">
                <h2>Productos</h2>
                <div id="content">
                    <div class="box">
                        <table>
                            <tr>
                                <td class="auxiliarB"></td>
                                <td class="auxiliarB"></td>
                                <td class="auxiliarB">
                                <input type="text" id="buscar" name="buscar" placeholder = "Buscar Producto" class="searchBar" style="width:250px;"/>
                                </td>
                                <td>
                                    <img src="../img/busc.png" class="img-buscar"  alt="Buscar" onClick="onClickBusqueda();"/>
                                </td>
                            </tr>

                        </table>
                    </div>   
                    <div id="tablaProducto" class="box">
                        <?php include("TablaProducto.php"); ?>
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
    

    function loadTable(){

        filtro = document.getElementById('buscar').value;
        sendPetitionSync("TablaProducto.php?search=" + filtro ,"tablaProducto",document);
        rePaint();
    }   

 
</script> 
<script type="text/javascript" src="../js/jquery-1.5.1.js"></script>
<script type="text/javascript" src="../js/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/navigation.js"></script>        
