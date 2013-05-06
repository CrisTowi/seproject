<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Registrar Lote</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
        <script src="datepickers/jquery-1.9.1.js"></script>
        <script src="datepickers/jquery-ui-1.10.2.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="datepickers/jquery-ui-1.10.2.custom.css" />
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
                <div class="selected-button" onclick="redirect('GestionarLotes.php');">
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
                <h2 id="titulo">Registrar Lote</h2>
				<form id="altaLote" action="AgregaLote1.php" name="altaLote" method ="POST">
					<div id="content">
                    	<div class="box">
							<table>						
								<tr>
						   			<td>Producto Asociado: </td>
						   			<td>
                                    	<select name="producto" id="producto"
                                        onblur="valida(this.value,'msgProducto','producto');" >
                                        	<option value="0">Selecciona un producto</option>
                                            <?php echo getCatalogoProductos(); ?>
                                        </select>
									</td>
						   			<td><span id="msgProducto"></span></td>
								</tr>      
<!--                                
								<tr>
									<td>Cantidad de Producto: </td>
									<td>
                                    <input type="text" name="cantidad" id="cantidad" 
                                    placeholder="# de Unidades" 
                                    onBlur="valida(this.value, 'msgCantidad', 'cantidad');" />
                                    </td>
									<td>
                                    	<span id="msgCantidad"></span>
									</td>
								</tr>                  
-->                                
								<tr>
									<td>Cantidad de Producto: </td>
									<td>
                                    	<select id="cantidad" val="cantidad"
                                    	onblur="valida(this.value, 'msgCantidad', 'cantidad');">
                                    		<option value="0">Seleccionar cantidad</option>
                                    		<option value="1000">1000</option>
                                    		<option value="2000">2000</option>
                                    		<option value="3000">3000</option>
                                    		<option value="4000">4000</option>
                                        	<option value="5000">5000</option> 
										</select>
                                    </td>
									<td>
                                    	<span id="msgCantidad"></span>
									</td>
								</tr>                               
								<tr>
									<td>Fecha de Elaboración: </td>
									<td>
                                    <input id="elaboracion" name="elaboracion" type="text" 
                                    placeholder="AAAA-MM-DD"
                                    onblur="valida(this.value,'msgElaboracion','elaboracion');"/> 
									<!--<img class="ui-datepicker-trigger" 
                                    src="img/calendar.gif" alt="..." title="...">-->
                                    </td>
									<td>
                                    	<span id="msgElaboracion"></span>
									</td>
								</tr>
								<tr>
									<td>Fecha de Caducidad: </td>
									<td>
                                    <input id="caducidad" name="caducidad" type="text" 
                                    placeholder="AAAA-MM-DD" 
                                    onblur="valida(this.value,'msgCaducidad','caducidad');"/> 
                                    </td>
									<td>
                                    	<span id="msgCaducidad"></span>
									</td>
								</tr> 
<!--                                          
								<tr>
									<td>Estado: </td>
									<td>
                                    	<select id="estado" name="estado"
                                        onBlur="valida(this.value, 'msgEstado', 'estado');">
                                        	<option value="0">Seleccionar estado</option>
                                        	<option value="pendiente">Pendiente</option>
                                        	<option value="produccion">En Producción</option>
                                        	<option value="terminado">Terminado</option
										></select>
                                    </td>
									<td>
                                    	<span id="msgEstado"></span>
									</td>
-->                                   
								</tr>                                                                                   
							</table>
                            <input type="hidden" name="numlote" id="numlote" 
                            value="<?php echo $_GET["nolote"]?>" />
                    		<div class="box">
								<div id="buttonOK" class="form-button" onclick="agregarLote();">
                                	Registrar
								</div>
                        		<div class="form-button" onclick="redirect('GestionarLotes.php')">
                                	Cancelar
								</div>	
                    		</div>                            
						</div><!--box-->
					</div><!--content-->
				</form>
            </div><!--allcontent-->
        </div><!--mainDiv-->
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<script type="text/javascript">
	var modify = false;
</script>
<?php include("scripts.php"); ?>
<?php
	/*
		Verifica si es la opcion de modificar un lote, si lo es, 
		agrega los scripts y carga los datos correspondientes
	*/
	include("clases/Lote.class.php");	
	if ( isset($_GET["nolote"]) ){
		$lote = $_GET["nolote"];
		$encontrado = Lote::findById($lote);
?>
<script type="text/javascript">
	
	function selectItem(val, sel){
		for(var i, j = 0; i = sel.options[j]; j++) {
			if(i.value == val) {
				sel.selectedIndex = j;
				break;
			}
		}
	}
	document.getElementById('producto').value = "<?php echo $encontrado->getProducto(); ?>";
	document.getElementById('cantidad').value = "<?php echo $encontrado->getCantidad(); ?>";
	document.getElementById('elaboracion').value = "<?php echo $encontrado->getElaboracion(); ?>";
	document.getElementById('caducidad').value = "<?php echo $encontrado->getCaducidad(); ?>";
	document.getElementById('titulo').innerHTML = "Modificar Lote";
	document.getElementById('buttonOK').innerHTML = "Modificar";
	modify = true;
</script>
<?php
	}
?>
<!-- Agrega los scripts de la pantalla y el modulo -->
<script type="text/javascript">
	/* Agrega el lote a la base de datos */
	function agregarLote(){

		parametros = "nolote=" + document.getElementById('numlote').value + "&";	
		parametros += "producto=" + document.getElementById('producto').value + "&";
		parametros += "cantidad=" + document.getElementById('cantidad').value + "&";
		parametros += "elaboracion=" + document.getElementById('elaboracion').value + "&";
		parametros += "caducidad=" + document.getElementById('caducidad').value;		

		if ( modify ){
			parametros +="&edit=1";
		}
		parametros = parametros.replace("#", "%23");
		sendPetitionQuery("AgregaLote1.php?" + encodeURI(parametros));
		console.log("AgregaLote1.php?" + encodeURI(parametros));
		//alert("AgregaLote1.php?" + encodeURI(parametros));
		/* returnedValue almacena el valor que devolvio el archivo PHP */
		if (returnedValue == "OK" ){
			if ( modify ){
				alert("Lote modificado correctamente");
			}else{
				alert("Lote registrado correctamente");
			}
			window.location = "./GestionarLotes.php";
		}
		else if ( returnedValue == "DATABASE_PROBLEM"){
			alert("Error en la base de datos");
		}
		else if ( returnedValue == "INPUT_PROBLEM"){
			alert("Datos con formato inválido");
		} else {
			alert ("Error desconocido D:");
		}
	}
	
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
/*	
		else if(validate == 'estado'){
			if(str == 0){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"Debes seleccionar un estado del lote!";									
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png'/>";
			}
		}//estado
*/		
	}
	
</script>
<!--
	SCRIPT PARA LAS FECHAS
-->       
<script type="text/javascript">
	$(function () {		
		$('#elaboracion').datepicker({
			changeMonth: true, changeYear: false,
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 
			'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 
			'Oct','Nov','Dic'],
      		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      		dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: "yy-mm-dd",
			minDate: "2013-01-01",
			maxDate: "+0"
		});
		//$('#elaboracion').datepicker("option", "dateFormat", "yy-mm-dd");
		//$('#elaboracion').datepicker("option", "minDate", "2013-01-01");
		//$('#elaboracion').datepicker("option", "maxDate", "+0");
		
		$('#caducidad').datepicker({
			changeMonth: true, changeYear: true,
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
		$('#caducidad').datepicker("option", "dateFormat", "yy-mm-dd");	
		$('#caducidad').datepicker("option", "minDate", "+3M");
		$('#caducidad').datepicker("option", "maxDate", "+1Y");		
	});
</script>  
<?php
	include("../php/DataConnection.class.php");		
	function getCatalogoProductos(){	
		$db = new DataConnection();
		$consulta = "SELECT * FROM producto;";
		$res = $db->executeQuery($consulta);
		
		if (mysql_num_rows($res) < 1){
			echo ("<script>alert('No se encontraron productos en el catalogo');</script>");
		}
		else{
			while($fila = @mysql_fetch_array($res)){
				echo "<option value='".$fila["idProducto"]."'>".utf8_encode($fila["Nombre"])."</option>";
			}
		}
	}
	
	function getCookieById($id){
		$db = new DataConnection();
		$consulta = "SELECT * FROM producto 
		WHERE idProducto = '".$nombre."';";
		$res = $db->executeQuery($consulta);
		if(mysql_num_rows($res) < 1){
			return "Producto Inexistente!";
		}		
		else{
			while($fila = @mysql_fetch_array($res)){
				$nombre = $fila["Nombre"];
			}
			return $nombre;
		}
		return 0;
	}

?>