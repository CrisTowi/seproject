<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />		
        <title>Modulo de Producci&oacute;n</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
		<script src="../js/jquery-1.9.1.js"></script>		
		<link rel="stylesheet" type="text/css" href="datepickers/zebra_dialog.css">
		<script src="datepickers/zebra_dialog.js"></script>
    </head>    
    <body>
    	 <?php include("header.php"); ?>

        <center>
        <div id="mainDiv">
            <nav>
<!--            
                <div class="button" onclick="redirect('GestionarLineas.php');">
                	<img src="../img/way.png"  alt="Icono" class="img-icon" />
                    	Gesti�n de L�neas
				</div>                
-->                
                <div class="selected-button" onclick="redirect('GestionarLotes.php');">
                	<img src="../img/note.png"  alt="Icono" class="img-icon" />
                    	Gesti&oacute;n de Lotes
				</div>   
                <div class="button" onclick="redirect('ConsultarPedidos.php');">
                	<img src="../img/clock.png"  alt="Icono" class="img-icon" />
                    	Gesti&oacute;n de Pedidos
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
				<div id="content">
                	<h2>Gesti&oacute;n de Lotes</h2>
                    <div class="box">
                    	<div onClick="redirect('RegistrarLote.php');" class="form-button">
                        	Registrar Lote
                        </div>                    
                        <input type="text" id="buscar" name="buscar" placeholder="Ingresa el # del lote" 
                        class="searchBar" style="width:250px;" />
                        <img src="../img/busc.png" class="img-buscar" alt="Buscar" 
                        onClick="onClickBusqueda();" />
                        <img src="../img/help.png" class="clickable" alt="ayuda" onClick="ayudaBusqueda();" />
                    </div><!--box-->
                    <div id="tablaLote" class="box">
                    	<div id="results">
                    		<?php include("TablaLotes.php"); ?>
						</div>
                    </div><!--tablaLinea-->
                </div><!--content-->              
			</div>
        </div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script type="text/javascript">
	
	function ayudaBusqueda(){
		alert("Debes ingresar el N�mero de Lote.\n" + 
		"Para volver debes borrar el texto ingresado en el campo de busqueda!");
	}
	
	/* Genera la tabla de empleados */
	function onClickBusqueda(){
		loadTable();
	}
	
	/*Confirma y elimina el empleado*/
	function eliminarLote(nolote){
		if ( confirm("�Desea eliminar el lote #" + nolote +"?") ){
			sendPetitionQuery("EliminarLote.php?nolote=" + nolote );
			alert("Lote eliminado");
			loadTable();
		}
	}	
	
	/*Redirige a la pagina de modificar empleado*/
	function modificarLote(nolote){
		redirect("ModificarLote.php?nolote=" + nolote);
	}

	/*Carga la tabla de empleado de acuerdo al filtro de busqueda*/
	function loadTable(){
		filtro = document.getElementById('buscar').value;
		sendPetitionSync("TablaLotes.php?search=" + filtro , "tablaLote", document);
		rePaint();
	}	
	
	function detalleLote(nolote, producto, cantidad, linea, encargado, elaboracion, caducidad){
			
			var parametros = {
				"noLote" : nolote
			};
			
			new $.Zebra_Dialog('', {   // El primer argumento es c�digo html extra que se quiera agregar
			'source':  {'ajax': {
			'url': 'ajaxConsultarLote.php',
			'data': parametros,
			'type': 'post'
			}},
			width: 550,
			position: ['center', 'top + 20'],
			max_height: 400,
			'title': 'Detalles del Lote'
		});
		/*alert("DESCRIPCI�N DEL LOTE\n\n" + 
		"Numero de lote:\t\t\t\t\t\t\t" + "LOTE No. " + nolote + 
		"\nProducto Asociado:\t\t\t\t\t\t" + producto + 
		"\nCantidad de Producto:\t\t\t\t\t" + cantidad + " Unidades" +
		"\nL�nea de Producci�n:\t\t\t\t\t\t" + "L�nea " + linea + 
		"\nEncargado de Producci�n:\t\t\t\t" + encargado + 
		"\nFecha de Elaboraci�n [AAAA/MM/DD]:\t\t" + elaboracion +
		"\nFecha de Caducidad[AAAA/MM/DD]:\t\t" + caducidad);*/
	}	
</script>