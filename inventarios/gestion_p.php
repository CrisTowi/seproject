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
                <div class="button" onclick="redirect('compras_mp.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Compras Pendientes</div>
                <div class="button" onclick="redirect('gestion_ma.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Materia Prima</div>
                <div class="button" onclick="redirect('ingresar_ma.php');"><img src="../img/note.png"  alt="Icono" class="img-icon" />Ingresar Materia Prima</div>
                <div class="selected-button" onclick="redirect('gestion_p.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión de Productos</div>
                <div class="button" onclick="redirect('reportes_ma.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes de Materia Prima</div>
                <div class="button" onclick="redirect('reportes_p.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes de Productos</div>
            </nav>  
  <!-- Divisor del contenido de la pagina -->
            <div id="all-content">
                <h2>Gestión de Productos</h2>
                <div id="content">
                    <div class="box">
                        <table>
                            <tr>
                                <td class="auxiliarB">
                                    <div onclick="redirect('ingresar_prod.php');" class="form-button">Agregar Producto</div>
                                </td>
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
    

    function modificarProducto(id){
            redirect("ingresar_prod.php?id=" + id);
    }

    function eliminarProducto(id){
        if( confirm("¿Seguro que desea eliminar el producto con id" + id +"?")){
            sendPetitionQuery("EliminarProducto.php?id=" + id);
            alert("Producto eliminado");
            loadTable();
        }
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
