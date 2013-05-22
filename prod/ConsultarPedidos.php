<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title>Modulo de Producci&oacute;n</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
        <script src="../js/jquery-1.9.1.js"></script>
		<!--
        HIDE Y SHOW
     	-->
		<script>
		$(function(){
			$('#fventap').hide();
			$('#FormSubmit').hide();
			$('#resultados1').hide();
			$('#resultados').hide();			
			$("#tipopedido").change(function(){
				if($("#tipopedido").val() == 0 || $("#tipopedido").val() == 1){
					$('#resultados1').hide();
					$('#resultados').hide();					
					$('#FormSubmit1').show(800);					
					$('#FormSubmit').hide();					
					$('#fventap').hide();
				}
				if($("#tipopedido").val() == 2){
					$('#resultados1').hide();
					$('#fventap').show(800);					
					$('#resultados').show(800);
					$('#FormSubmit1').hide();					
					$('#FormSubmit').show(800);
					
				}				
			});
		});
        </script> 
		<!--
        ESTABLECER FECHA DE CALENDARIO
		-->
		<script type="text/javascript">
		$(function () {
    		var now = new Date();
    		var month = (now.getMonth() + 1);               
    		var day = (now.getDate() - 1);
    		if(month < 10) 
        		month = "0" + month;
    		if(day < 10) 
        		day = "0" + day;
    		var today = now.getFullYear() + '-' + month + '-' + day;			
			
			$('#fechaVenta').datepicker({changeMonth: true, changeYear: false,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 
				'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 
				'Oct','Nov','Dic'],
      			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      			dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			});
			$('#fechaVenta').datepicker("option", "dateFormat", "yy-mm-dd");
			$('#fechaVenta').datepicker("option", "maxDate", today);
		});
		</script>          
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
                    	Gesti&oacute;n de Lotes
				</div>   
                <div class="selected-button" onclick="redirect('ConsultarPedidos.php');">
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
                	<h2>Gestionar Pedidos</h2>
                    <div class="box">
                        <input type="text" id="buscar" name="buscar" placeholder="Ingresa el número de folio del pedido" 
                        class="searchBar" style="width:250px;" />
                        <img src="../img/busc.png" class="img-buscar" alt="Buscar" 
                        onClick="onClickBusqueda();" />
                        <img src="../img/help.png" class="clickable" alt="ayuda" onClick="ayudaBusqueda();" />
                    </div><!--box-->
                    <div id="tablaPedido" class="box">
                    	<?php include("TablaPedidos.php"); ?>
                    </div><!--tablaLinea-->                    
                </div><!--content-->
            </div><!--all-content-->		

        </div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script type="text/javascript">
	/*Alert para la ayuda en la busqueda*/
	function ayudaBusqueda(){
		alert("Debes ingresar el número de Folio del pedido.\nPara volver borra el texto del campo de busqueda!");
	}
	
	/* Genera la tabla de pedidos */
	function onClickBusqueda(){
		loadTable();
	}
	/*Carga la tabla de pedido de acuerdo al filtro de busqueda*/
	function loadTable(){
		filtro = document.getElementById('buscar').value;
		sendPetitionSync("TablaPedidos.php?search=" + filtro , "tablaPedido", document);
		rePaint();
	}		
	
	/*modificar la producción*/
	function enviarProduccion(folio){
		redirect("AsignarLinea.php?folio=" + folio);
		//alert("Se enviara a producción");
	}
	
	/*Muestra el detalle del Lote asociado*/
	function detalleLote(nolote, producto, cantidad, elaboracion, caducidad){
		alert("Detalle del Lote\n\n" + 
		"Numero de lote: " + nolote + 
		"\nProducto Asociado: " + producto + 
		"\nCantidad de Producto: " + cantidad + " Unidades" +
		"\nFecha de Elaboración: " + elaboracion +
		"\nFecha de Caducidad: " + caducidad);
	}	
</script>
