<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Modulo de Producción</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
        <script src="../js/jquery-1.9.1.js"></script>
		<script src="datepickers/jquery-ui-1.10.2.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="datepickers/jquery-ui-1.10.2.custom.css" />
		
	<!--
	SCRIPT PARA LAS FECHAS
	-->       
	<script type="text/javascript">
	$(function () {		
		
		var dates = $("#fechaInicio, #fechaFin").datepicker
		(
			{
				changeMonth: true, changeYear: true,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 
				'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 
				'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
				defaultDate: "+1w",
				changeMonth: true,
				changeYear: true,
				dateFormat: "dd/mm/yy",
				//numberOfMonths: 1,

				onSelect: function (selectedDate) {
					var option = this.id == "fechaInicio" ? "minDate" : "maxDate",
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
		
        			        
    </head>    
    <body>
    	 <?php include("header.php"); ?>

        <center>
        <div id="mainDiv">
            <nav>
                <div class="button" onclick="redirect('GestionarLineas.php');">
                	<img src="../img/way.png"  alt="Icono" class="img-icon" />
                    	Gestión de Líneas
				</div>                
                <div class="button" onclick="redirect('GestionarLotes.php');">
                	<img src="../img/note.png"  alt="Icono" class="img-icon" />
                    	Gestión de Lotes
				</div>      
                <div class="button" onclick="redirect('ConsultarPedidos.php');">
                	<img src="../img/clock.png"  alt="Icono" class="img-icon"/>
                    	Gestión de Pedidos
				</div>                                                                   			          
                <div class="button" onclick="redirect('ConsultarIngredientes.php');">
                	<img src="../img/search.png" alt="Icono" class="img-icon" />
                    	Consultar Disponibilidad de Ingredientes
				</div>
                <div class="selected-button" onclick="redirect('CrearReporte.php');" style="height:30px;">
                	<img src="../img/notepad.png"  alt="Icono" class="img-icon" />
                    	Crear Reporte
				</div>
            </nav>
            <div id="all-content">
                <h2 id="titulo">Creación de Reportes de Producción</h2>
				<form id="formReporte" action="procesarReporte.php" method ="POST">
					<div id="content">
                    	<div class="box">
							<table>	
                            	<tr>
                                	<td>Seleccione la Fecha Inicial:</td>
                                    <td>
                                    	<input type="text" class="datePicker entrada" id="fechaInicio"
                                        name="fechaInicio" />
                                    </td>
                                </tr>	
                            	<tr>
                                	<td>Seleccione la Fecha Inicial:</td>
                                    <td>
                                    	<input type="text" class="datePicker entrada" id="fechaFin"
                                        name="fechaFin" />
                                    </td>
                                </tr>                 
                            	<tr>
                                	<td>Ordenar resultados por:</td>
                                    <td>
                    					<select name="ordenamientoLotes" id="criteriosLotes" class="entrada">
                                        	<option value="0">Seleccionar criterio</option>                    	
                    						<option value="fecha_elaboracion">Fecha de Producción</option>                    	
                    						<option value="linea">Línea de Producción</option>
											<option value="Nombre">Producto</option>                        
                        				</select>
                                    </td>
                                </tr>                                                                				
							</table>
                            
                    		<div class="box">
								<!--<div id="botonCrear" class="form-button" >
                                	Generar Reporte
								</div>-->
                                <input type="submit" class="form-button" id="botonCrear" value="Generar Reporte" />
                    		</div>                            
						</div><!--box-->
					</div><!--content-->
				</form>
            </div><!--allcontent-->            
<!--
            <div id="all-content">				
                <h2>Creación de Reportes de Producción</h2>                
                <form id="formReporte" action="procesarReporte.php" method="POST">                	
                    <p>
                    	Ingrese la Fecha Inicial:
                    </p>
                    <p>
                    	<input type="text" class="datePicker entrada" id="fechaInicio" 
                        name="fechaInicio" />
                    </p>
                    <p>
                    	Ingrese la Fecha Final:
                    </p>
                    <p>
                    	<input type="text" class="datePicker entrada" id="fechaFin"
                        name="fechaFin" />
                    </p>
                    <p>
                    	Ordenar resultados por:
                    </p>
                    <p>
                    	<select name="ordenamientoLotes" id="criteriosLotes" class="entrada">
                    		<option value="fechaElaboracion">Fecha de Producción</option>                    	
                    		<option value="linea">Línea de Producción</option>
							<option value="Nombre">Producto</option>                        
                        </select>
                    </p>
                    
                    <input type="submit" class="form-button" id="botonCrear" value="Generar Reporte" />
				</form>
			</div>-->
        </div><!--main-->
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>