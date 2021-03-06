<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title>Modulo de Producci&oacute;n</title>
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
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S�bado'],
				dayNamesShort: ['Dom','Lun','Mar','Mi�','Juv','Vie','S�b'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S�'],
				defaultDate: "+1w",
				changeMonth: true,
				changeYear: true,
				//dateFormat: "dd/mm/yy",
				dateFormat: "yy-mm-dd",
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
                <div class="button" onclick="redirect('GestionarLotes.php');">
                	<img src="../img/note.png"  alt="Icono" class="img-icon" />
                    	Gesti&oacute;n de Lotes
				</div>      
                <div class="button" onclick="redirect('ConsultarPedidos.php');">
                	<img src="../img/clock.png"  alt="Icono" class="img-icon"/>
                    	Gesti&oacute;n de Pedidos
				</div>                                                                   			          
                <div class="selected-button" onclick="redirect('CrearReporte.php');" style="height:30px;">
                	<img src="../img/notepad.png"  alt="Icono" class="img-icon" />
                    	Crear Reporte
				</div>
            </nav>
            <div id="all-content">
                <h2 id="titulo">Creaci&oacute;n de Reportes de Producci&oacute;n</h2>
				<form id="formReporte" action="procesarReporte.php" method ="POST" onSubmit="return validar();">
					<div id="content">
                    	<div class="box">
							<table>	
                            	<tr>
                                	<td>Seleccione la Fecha Inicial:</td>
                                    <td>
                                    	<input type="text" class="datePicker entrada" id="fechaInicio"
                                        name="fechaInicio" onblur="valida(this.value, 'msgInicio', 'fechaInicio');"/>
                                    </td>
                                    <td>
                                    	<span id="msgInicio"></span>
                                    </td>                                    
                                </tr>	
                            	<tr>
                                	<td>Seleccione la Fecha Final:</td>
                                    <td>
                                    	<input type="text" class="datePicker entrada" id="fechaFin"
                                        name="fechaFin" onblur="valida(this.value, 'msgFin', 'fechaFin');"/>
                                    </td>
                                    <td>
                                    	<span id="msgFin"></span>
                                    </td>                                                               
                                </tr>                    
                            	<tr>
                                	<td>Ordenar resultados por:</td>
                                    <td>
                    					<select name="ordenamientoLotes" id="criteriosLotes" class="entrada" 
                                        onblur="valida(this.value, 'msgFiltro', 'criteriosLotes');">
                                        	<option value="0">Seleccionar criterio</option>                    	
                    						<option value="fecha_elaboracion">Fecha de Producci&oacute;n</option>                    	
                    						<option value="linea">L&iacute;nea de Producci&oacute;n</option>
											<option value="Nombre">Producto</option>                        
                        				</select>
                                    </td>
                                    <td>
                                    	<span id="msgFiltro"></span>
                                    </td>                                                               
                                </tr>                                                                				
							</table>
                            
                    		<div class="box">
								
                                <input type="submit" class="form-button" id="botonCrear" value="Generar Reporte" />
                    		</div>                            
						</div><!--box-->
					</div><!--content-->
				</form>
            </div><!--allcontent-->            

        </div><!--main-->
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script>

function validar(){
	var inicio = document.getElementById('fechaInicio').value;
	var fin = document.getElementById('fechaFin').value;
	var criterio = document.getElementById('criteriosLotes').value;
	if(inicio == ''){
		alert("La fecha de inicio es un campo obligatorio.");
		return false;
	}
	else if(fin == ''){
		alert("La fecha de fin es un campo obligatorio.");
		return false;
	}
	else if(criterio == '0'){
		alert("El criterio de ordenamiento es un campo obligatorio.");
		return false;
	}
	else{
		return true;
	}
}
</script>
	<script>
	function valida( str, target, validate ){
		if ( validate == "criteriosLotes" ){
			if ( str == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"Debes elegir un filtro.";	
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
		}//criteriosLotes
		else if(validate == 'fechaInicio'){
			if(str == ''){
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
		}//fechaInicio
		else if(validate == 'fechaFin'){
			if(str == ''){
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
		}//fechafin	
	}
	</script>   