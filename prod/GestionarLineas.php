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
                <div class="selected-button" onclick="redirect('GestionarLineas.php');">
                	<img src="../img/way.png"  alt="Icono" class="img-icon" />
                    	Gestión de Líneas
				</div>                
                <div class="button" onclick="redirect('GestionarLotes.php');">
                	<img src="../img/note.png"  alt="Icono" class="img-icon" />
                    	Gestión de Lotes
				</div>   
                <div class="button" onclick="redirect('ConsultarPedidos.php');">
                	<img src="../img/clock.png"  alt="Icono" class="img-icon" />
                    	Gestión de Pedidos
				</div>
				<div class="button" onclick="redirect('ConsultarIngredientes.php');">
                	<img src="../img/search.png" alt="Icono" class="img-icon" />
                    	Consultar Disponibilidad de Ingredientes
				</div>				
                <div class="button" onclick="redirect('CrearReporte.php');" style="height:30px;">
                	<img src="../img/notepad.png"  alt="Icono" class="img-icon"/>
                    	Crear Reporte
				</div>			
			</nav>
            <div id="all-content">				
				<div id="content">
                	<h2>Gestión de Líneas</h2>
                    <div class="box">
                    	<div onClick="redirect('AsignarLinea.php');" class="form-button">
                        	Asignar Línea
                        </div>
                        <input type="text" id="buscar" name="buscar" 
                        placeholder="Buscar produccion por # de línea" 
                        class="searchBar" style="width:250px;" />
                        <img src="../img/busc.png" class="img-buscar" alt="Buscar" 
                        onClick="onClickBusqueda();" />
                        <img src="../img/help.png" class="clickable" alt="ayuda" 
                        onClick="ayudaBusqueda();" />                        
                    </div><!--box-->
                    <div id="tablaLinea" class="box">
                    	<?php include("TablaLineas.php"); ?>
                    </div><!--tablaLinea-->
                </div><!--content-->
			</div><!--all-content-->
        </div><!--maindiv-->
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script type="text/javascript">
	function ayudaBusqueda(){
		alert("Debes ingresar el Número de Línea.\nPara volver borra el texto del campo de busqueda!");
	}
	
	/* Genera la tabla de empleados */
	function onClickBusqueda(){
		loadTable();
	}
	/*Carga la tabla de empleado de acuerdo al filtro de busqueda*/
	function loadTable(){
		filtro = document.getElementById('buscar').value;
		sendPetitionSync("TablaLineas.php?search=" + filtro , "tablaLinea", document);
		rePaint();
	}		

	function detalleLote(nolote, producto, cantidad, elaboracion, caducidad){
		alert("Detalle del Lote\n\n" + 
		"Numero de lote: " + nolote + 
		"\nProducto Asociado: " + producto + 
		"\nCantidad de Producto: " + cantidad + " Unidades" +
		"\nFecha de Elaboración: " + elaboracion +
		"\nFecha de Caducidad: " + caducidad);
	}
	
	/*Confirma y elimina la produccion*/
	function eliminarProduccion(numprod){
		if ( confirm("¿Seguro que desea eliminar la producción PROD-" + numprod +"?") ){
			sendPetitionQuery("EliminarLinea.php?numprod=" + numprod );
			alert("Producción Eliminada");
			loadTable();
		}
	}		
	/*modificar la producción*/
	function modificarProduccion(numprod){
		redirect("AsignarLinea.php?numprod=" + numprod);
	}
</script>