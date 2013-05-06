<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Modulo de Producción</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
		<script src="datepickers/jquery-1.9.1.js"></script>		
        <script src="datepickers/jquery-ui-1.10.2.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="datepickers/jquery-ui-1.10.2.custom.css" />
		
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
                	<img src="../img/clock.png"  alt="Icono" class="img-icon" />
                    	Gestión de Pedidos
				</div>                                    
                <div class="selected-button" onclick="redirect('ConsultarIngredientes.php');">
                	<img src="../img/search.png" alt="Icono" class="img-icon" />
                    	Consultar Disponibilidad de Ingredientes
				</div>
				<div class="button" onclick="redirect('CrearReporte.php');" style="height:30px;">
                	<img src="../img/notepad.png"  alt="Icono" class="img-icon" />
                    	Crear Reporte
				</div>
            </nav>
            <div id="all-content">				
				<div id="content">
                	<h2>Consulta de Disponibilidad de Ingredientes</h2>
					
					<table style="float: left; margin-left: 10px; width:750px" >						
						<tr>
							<td style="width: 150px;">
								<p class="textoForm">Seleccionar producto: </p>
							</td>
							<td style="width: 400px; ">
								<input type="text" id="producto" name="producto" size="40"/>												
							</td>
						</tr>
						<tr id="filaCantidad">
							<td style="width: 150px;">
								<p class="textoForm">Seleccionar cantidad: </p>
							</td>
							<td>
								<select name="cantidad" id="selectCantidad" onchange="javascript:actualizarCeldas( $('#selectCantidad').val() );">                    
									<option value="1000">1000</option>
									<option value="2000">2000</option>
									<option value="3000">3000</option>
									<option value="4000">4000</option>
									<option value="5000">5000</option>							
								</select>	
							</td>
						</tr>
						<tr>				 
							<td colspan="4">				 
								<div id="resultado" style="border-style:solid; padding:10px;"  class="box">				 				 				 				
								</div>
							</td>				 								 				
						</tr>
					</table>
					
                </div><!--content-->
			</div><!--all-content-->
        </div><!--maindiv-->
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>