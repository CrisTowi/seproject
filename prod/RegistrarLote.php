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
		<script src="datepickers/jquery.validate.min.js"></script>
		<script src="datepickers/validaciones.js"></script>
        <link rel="stylesheet" type="text/css" href="datepickers/jquery-ui-1.10.2.custom.css" />
		<link rel="stylesheet" type="text/css" href="datepickers/estiloValidacion.css" />
		
		<!--
        	Autocompletar producto
		-->                
        <script>
			$(function(){
			$('#producto').autocomplete({				
				source: 'ajaxProducto.php',
				select: function(event, ui){
					
					//alert(ui.item.idProductoElegido);					
					var parametros = {
						"producto" : ui.item.idProductoElegido
					};
					
					$('#producto').html('<input type="hidden" value="'+ui.item.idProductoElegido+'" name="idProducto">');
					
					$.ajax({
						data:  parametros,
						url:   'cargarReceta.php',
						type:  'post',						
						beforeSend: function () {							
							//$('#resultado').hide(1000);
							$('#resultado').slideUp(1000);
						},
						success:  function (response) {
							$('#selectCantidad').val('1000');
							$('#filaCantidad').show(2000);		
							$('#filaEncargado').show(2000);	
							$('#filaSubmit').show(2000);	
							$('#filaFechaElab').show(2000);	
							$('#filaFechaCad').show(2000);	
							
							$("#resultado").html('<p class="textoForm">Ingredientes requeridos para la producción: </p>');
							$("#resultado").append(response);
														
							var ingredientesProducto = $('#totalIngredientes').val();
							
							for (var counter=0; counter<=ingredientesProducto; counter++) {
							
								var selector1="#ingrediente";	//Campo hidden
								selector1+=counter;
								
								var selector2="#ing";  //Celda ingrediente
								selector2+=counter;	
								
								$.ajax({
									async: false,    ////Evitar necesidad de alert()
									data:  { "valor" : $(selector1).val(),   //ingredienteX = contador de Ingredientes, val = id del Ingrediente en la BD
										 "contador": counter
										},   
									url:   'cargarLotesMP.php',
									type:  'post',
									
									success:  function (response) {
										$(selector2).append(response);    //ingX = celda	
										
										var celdaIng = "#cantidad"+counter;   //Celda donde se mostrará la cantidad
										
										if($("#lotesIng"+counter).val()!=null)  //Si response devolvio un combobox, llamar a ajax										
										{
											$.ajax({
												async: false,    ////Evitar necesidad de alert()
												data:  { "valor" : $("#lotesIng"+counter).val() },   
												url:   'cargarCantidadLoteMP.php',
												type:  'post',
									
												success:  function (response) {									
												
												$(celdaIng).html(response);    //ingX = celda	
										
												}																			
								
											});
										} //Fin de if
										
									}  //Fin de success
								
								}); //Fin de ajax
																
								actualizarCeldasSuficiente(counter);								
																						
							} //Fin de for
							
							//$("#resultado").show(2000);
							$("#resultado").slideDown(2000);
							
							$('.loteMP').change(function() {
									
								var aux= $(this).attr('id');
								var celdaIng = '#'+aux.replace("lotesIng","cantidad"); 
								var filaIng = aux.substring(8,9);
								
								$.ajax({
									async: false,    ////Evitar necesidad de alert()
									data:  { "valor" : $(this).val() },   
									url:   'cargarCantidadLoteMP.php',
									type:  'post',
									
									success:  function (response) {																				
										$(celdaIng).html(response);    //ingX = celda	
										actualizarCeldasSuficiente(filaIng);
									}																			
								
								});		//Fin de ajax
									
									
									
									
							});  //Fin de change
							
						}
					});	
					
				}
			});  //fin autocomplete								
			
		});
		</script>
		
		<!--
        	Script tareas iniciales
		-->                
        <script>
		$(document).ready(function() {
			$('#resultado').hide();
			$('#filaCantidad').hide();
			$('#filaEncargado').hide();	
			$('#filaSubmit').hide();	
			$('#filaFechaElab').hide();
			$('#filaFechaCad').hide();
		});
		</script>
		
		<!--
        	SCRIPT PARA ACTUALIZAR CANTIDADES
		-->                
        <script>
		
		function actualizarCeldasSuficiente(contador)
		{
			var selectorCant="#cantReqFinal";  //Hidden cantidad Necesaria
			selectorCant+=contador;
			var selectorSuf="#suficiente";  //Celda suficiente
			selectorSuf+=contador;
			var selectorDisp="#cantidad";  //Celda cantidad necesaria
			selectorDisp+=contador;
			var selectorFinal="#suficienteFinal";  //Celda cantidad necesaria
			selectorFinal+=contador;
			var temp = $(selectorDisp + ' p').html();
										
			if(temp!=null)
			{
				var partes = temp.split(' ');
				var aux = partes[0] - $(selectorCant).val();
				var nuevoValor= Math.round(aux * 100) / 100;  //Redondear
				
				//$(selectorSuf+ ' p').html( nuevoValor );
				if(nuevoValor>0)
					//$(selectorSuf+ ' p').html( 'Bien' );
					$(selectorSuf+ ' p').html( '<img src="img/ok.png">' );
				else
					$(selectorSuf+ ' p').html( '<img src="img/no.png">' );
					
				$(selectorFinal).val( nuevoValor );
				
			}								
		}

		function actualizarCeldas(cantidad){						
			
			var selector="#cantReqBase";
			var contador=0;
			var selectorDestino="#cantReq";
			var selectorFinal="#cantReqFinal";
			var ingredientesProducto = $('#totalIngredientes').val();   //Obtener numero total de ingredientes
						
			for(contador=0;contador<ingredientesProducto;contador++){
				var temp =$(selector+contador).val();  //Obtener el valor base (cantidad necesaria para 1000 galletas)
				var temp2=$(selectorDestino+contador+' p').html();
				var partes = temp2.split(' ');
				var nuevoValor = temp*(cantidad/1000);
				var aux= Math.round(nuevoValor * 100) / 100;  //Redondear
								
				$(selectorDestino+contador+' p').text(
					aux + ' ' + partes[1]
					);
					
				$(selectorFinal+contador).val( aux );			
				
				actualizarCeldasSuficiente(contador);

			} //Fin de for
			
		}
        </script>
		<!--
        	Autocompletar encargado
		-->                
        <script>
			$(function(){
			$('#encargado').autocomplete({
				source: 'ajaxEncargado.php',
				select: function(event, ui){
					
					$('#encargado').html('<input type="hidden" value="'+ui.item.curpEmpleado+'" name="curpEmpleado">');
				}
			});
		});
		</script>
		
		<!--
	SCRIPT PARA LAS FECHAS

	<script type="text/javascript">
	$(function () {		
		
		var dates = $("#fechaElab, #fechaCad").datepicker
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
				dateFormat: "yy-mm-dd",
				//dateFormat: "dd/mm/yy",				

				onSelect: function (selectedDate) {
					var option = this.id == "fechaElab" ? "minDate" : "maxDate",
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
-->
<!--
	SCRIPT PARA LAS FECHAS
-->       
<script type="text/javascript">
	$(function () {		
		$('#fechaElab').datepicker({
			changeMonth: true, 
			changeYear: false,
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 
			'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 
			'Oct','Nov','Dic'],
      		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      		dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: "yy-mm-dd",
			minDate: "-7",
			maxDate: "+0"
		});
		
		$('#fechaCad').datepicker({
			changeMonth: true, 
			changeYear: true,
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 
			'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 
			'Oct','Nov','Dic'],
      		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      		dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: "yy-mm-dd",
			minDate: "+3M",
			maxDate: "+1y"			
		});
	});
</script>      
	<script>    
	function valida( str, target, validate ){
		if ( validate == "producto" ){
			str = str.trim();
			if ( str == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"Este campo es obligatorio.";	
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
		}//producto		
		else if ( validate == "cantidad") {
			str = str.trim();
			//alert("Valor del str: " + str);
			if ( str < 1000 || str > 5000){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"La cantidad de producto no es valida!";	
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}		
		}//linea
		else if ( validate == "lineaProduccion") {
			if ( str == 0){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"La Línea de producción no es valida!";	
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}		
		}//linea		
		else if(validate == 'encargado'){
			if(str == ''){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"El encargado seleccionado no es valido!";					
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
		}//elaboracion	
		else if(validate == 'elaboracion'){
			if(str == ''){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"La fecha de elaboración no puede estar vacia!";					
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
		}//elaboracion
		else if(validate == 'caducidad'){
			if(str == ''){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"La fecha de caducidad no puede estar vacia!";					
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
		}//elaboracion		
	}    
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
                <div class="selected-button" onclick="redirect('GestionarLotes.php');">
                	<img src="../img/note.png"  alt="Icono" class="img-icon" />
                    	Gestión de Lotes
				</div>            
                <div class="button" onclick="redirect('ConsultarPedidos.php');">
                	<img src="../img/clock.png"  alt="Icono" class="img-icon" />
                    	Gestión de Pedidos
				</div>     
<!--                                               
                <div class="selected-button" onclick="redirect('ConsultarIngredientes.php');" style="height:30px;">
                	<img src="../img/search.png" alt="Icono" class="img-icon" />
                    	Registrar lote
				</div>
-->                
				<div class="button" onclick="redirect('CrearReporte.php');" style="height:30px;">
                	<img src="../img/notepad.png"  alt="Icono" class="img-icon" />
                    	Crear Reporte
				</div>
            </nav>
            <div id="all-content">				
				<div id="content">
                	<h2>Registrar Lote</h2>
					<form id="formRegistrar" action="procesarLote.php" method="POST" >
					<table style="float: left; margin-left: 10px; width:750px" >	
						<tr>
							<td style="width: 220px; text-align:right;">
								Seleccionar línea de producción:
							</td>
							<td>
								<select name="lineaProduccion" id="lineaProduccion"
								onblur="valida(this.value,'msgLinea','lineaProduccion');" >                                
                                	<option value="0">Seleccionar línea. . .</option>
									<option value="1">Línea 1</option>
									<option value="2">Línea 2</option>
									<option value="3">Línea 3</option>													
								</select>
							</td>
							<td><span id="msgLinea"></span></td>                            
						</tr>
						<tr>
							<td style="width: 150px; text-align:right;">
								Seleccionar producto:
							</td>
							<td style="width: 400px; ">
								<input type="text" id="producto" name="producto" size="30"
                                onblur="valida(this.value,'msgProducto','producto');" />												
							</td>
							<td><span id="msgProducto"></span></td>                             
                            <td>
								<img src="../img/help.png" class="clickable" alt="ayuda" onClick="ayudaAutocompletado();" />
							</td>
						</tr>
						<tr id="filaCantidad">
							<td style="width: 150px; text-align:right;">
								Seleccionar cantidad:
							</td>
							<td>
								<select name="cantidad" id="selectCantidad" 
                                onchange="javascript:actualizarCeldas( $('#selectCantidad').val() );"
                                onblur="valida(this.value,'msgCantidad','cantidad');" >
									<option value="1000">1000</option>
									<option value="2000">2000</option>
									<option value="3000">3000</option>
									<option value="4000">4000</option>
									<option value="5000">5000</option>							
								</select>	
							</td>
                            <td><span id="msgCantidad"></span></td>
						</tr>
						<tr>				 
							<td colspan="4">				 
								<div id="resultado" style="border-style:solid; padding:10px;"  class="box">				 				 				 				
								</div>
							</td>				 								 				
						</tr>
						<tr id="filaEncargado">
							<td style="width: 150px; text-align:right;">
								Seleccionar encargado:
							</td>
							<td style="width: 150px; ">
								<input type="text" id="encargado" name="encargado" size="30"
                                onblur="valida(this.value,'msgEncargado','encargado');" />
							</td>
                            <td><span id="msgEncargado"></span></td>
						</tr>
						<tr id="filaFechaElab">
                            <td  style="width: 150px; text-align:right;">
                            	Seleccionar la Fecha de Elaboración:</td>
                            <td>
                                <input type="text" class="datePicker entrada" id="fechaElab" name="fechaElab" size="30"
                                onblur="valida(this.value,'msgElaboracion','elaboracion');" />
                            </td>
                            <td><span id="msgElaboracion"></span></td>
                        </tr>	
                        <tr id="filaFechaCad">                            
                            <td  style="width: 150px; text-align:right;">
                            	Seleccionar la Fecha de Caducidad:
							</td>
                            <td>
                                <input type="text" class="datePicker entrada" id="fechaCad" name="fechaCad" size="30"
                                onblur="valida(this.value,'msgCaducidad','caducidad');" />
                            </td> 
                            <td><span id="msgCaducidad"></span></td>                           
                        </tr>
						<tr id="filaSubmit">							
                            <td>
                            </td>                        
							<td>
								<input type="submit" value="Registrar Lote" class="form-button" style="background-color: rgb(255, 222, 0);"/>
                            	<a href="GestionarLotes.php" class="form-button" style="text-decoration:none">
                        			Cancelar
								</a>                                
							</td>
						</tr>
					</table>
					</form>
                </div><!--content-->
			</div><!--all-content-->
        </div><!--maindiv-->
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>

<script>
	function ayudaAutocompletado(){
		alert("Este campo cuenta con autocompletado, \nsolo debes ingresar uno o más caracteres y el sistema hará el resto.");
	}
</script>