<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Asignar Línea de Producción</title>
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
                <div class="button" onclick="redirect('CrearReporte.php');">
                	<img src="../img/notepad.png"  alt="Icono" class="img-icon" />
                    	Crear Reporte
				</div>
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
            </nav>		
            <div id="all-content">
                <h2 id="titulo">Asignar Línea</h2>
                <form id="altaLinea" action="RegistarLinea.php" name="altaLinea" method="post">
                	<div id="content">
                    	<div class="box">
                        	<table>
                            	<tr>
                                	<td>Línea de Producción: </td>
                                    <td>
                                    	<select id="linea" name="linea"
                                        onBlur="valida(this.value, 'msgLinea', 'linea');" >
                                        	<option value="0">Seleccionar línea</option>
                                        	<option value="1">Línea 1</option>
                                        	<option value="2">Línea 2</option>
                                        	<option value="3">Línea 3</option>
										</select>
                                    </td>
                                    <td>
                                    	<span id="msgLinea"></span>
                                    </td>
                                </tr>
                            	<tr>
                                	<td>Encargado de Línea: </td>
                                    <td>
                                    	<select id="encargado" name="encargado"
                                        onBlur="valida(this.value, 'msgEncargado', 'encargado');" >
                                        	<option value="0">Seleccionar encargado</option>
                                            <option value="RULM910705HDFDPG08">Miguel Rueda</option>
										</select>
                                    </td>
                                    <td>
                                    	<span id="msgEncargado"></span>
                                    </td>
                                </tr>  
								<tr>
						   			<td>Producto Asociado: </td>
						   			<td>
                                        <select id="producto" name="producto"
                                        onblur="valida(this.value, 'msgProducto', 'producto');">
                                        	<option value="0">Selecciona un producto</option>
                                            <?php echo getCatalogoProductos(); ?>
                                        </select>
									</td>
						   			<td><span id="msgProducto"></span></td>
								</tr>         
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
                                <?php
									if(isset($_GET["numprod"]) || isset($_GET["folio"])){
										$codigo = "<tr>
											<td>Estado del Lote:</td>
											<td>
												<select id='estado' name='estado'
												onblur=\"valida(this.value,'msgEstado','estado');\">
													<option value='0'>Seleccionar estado: </option>
													<option value='pendiente'>Pendiente</option>
													<option value='produccion'>En producción</option>																										
													<option value='terminado'>Terminado</option>																																							
												</select>
											</td>
											<td>
												<span id='msgEstado'></span>
											</td>
										</tr>";
										echo $codigo;
									}
                                ?>                                                              
                            </table><!--table-->
                            <?php
                           		if ( isset($_GET["numprod"])){
									$np = $_GET["numprod"];
                            		echo "<input type='hidden' name='numprod' id='numprod'
									 value='$np' />";
								}
								else if(isset($_GET["folio"])){
									$folio = $_GET["folio"];
                            		echo "<input type='hidden' name='folio' id='folio'
									 value='$folio' />";									
								}
							?>
                            <div class="box">
                            	<div id="buttonOK" class="form-button" onClick="asignarLinea();" >
                                	Asignar
                                </div>
                                <div class="form-button" onClick="redirect('GestionarLineas.php')" >
                                	Cancelar
                                </div>
                            </div><!--box-->
                        </div><!--box-->
                    </div><!--content-->
                    <!-- PRUEBAS PARA COMPROBLAR EL LOTE
                    <input type="text" id="nolote" name="nolote" />
                    <input type="text" id="galleta" name="galleta" />
                   -->
                </form><!--form-->               
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
	include("clases/Produccion.class.php");
	//include("clases/Lote.class.php");
	
	if ( isset($_GET["numprod"]) ){
		$numprod = $_GET["numprod"];
		
		$encontrado = Produccion::findById($numprod);
		$loteencontrado = Lote::findById($encontrado->getLote());		
/*
	Comprobación de valores devueltos		
		//Numero de Lote
		$nl = $encontrado->getLote();
		echo "Lote: ".$nl;

		echo "Linea: ".$encontrado->getLinea();
		echo "Producto: ".findCookieById($loteencontrado->getProducto());
		echo "Cantidad: ".$loteencontrado->getCantidad();
		echo "Elaboracion: ".$loteencontrado->getElaboracion();
		echo "Caducidad: ".$loteencontrado->getCaducidad();		
*/		
?>
<script type="text/javascript">
	function selectItem(val, sel){
		for(var i, j = 0; i = sel.options[j]; j++) {
			if(i.value == val) {
				sel.selectedIndex = j;
				break;
			}//if
		}//for
	}//selectItem
	
	document.getElementById('linea').value = "<?php echo $encontrado->getLinea() ?>";
	document.getElementById('linea').disabled = "disabled";
	document.getElementById('encargado').value = "<?php echo $encontrado->getEncargado()?>";
	document.getElementById('producto').value = "<?php echo $loteencontrado->getProducto()?>";
	document.getElementById('cantidad').value = "<?php echo $loteencontrado->getCantidad()?>";	
	document.getElementById('elaboracion').value = "<?php echo $loteencontrado->getElaboracion(); ?>";
	document.getElementById('caducidad').value = "<?php echo $loteencontrado->getCaducidad(); ?>";

	<?php 
		if(isset($_GET["numprod"])){
			echo "document.getElementById('estado').value = '".$encontrado->getEstado()."';";
		}
	?>	

	
/*
	document.getElementById('nolote').value = "<?php //echo $encontrado->getLote() ?>";
	document.getElementById('galleta').value = "<?php //echo $loteencontrado->getProducto() ?>";	
*/
	document.getElementById('titulo').innerHTML = "Modificar Producción";
	document.getElementById('buttonOK').innerHTML = "Modificar";
	modify = true;

</script>
<?php
	}
?>
<!--
	ASIGNACION PARA PEDIDOS
-->
<?php
	include("clases/ArticuloV.class.php");	
	if ( isset($_GET["folio"]) ){
		$folio = $_GET["folio"];
		$artEncontrado = ArticuloV::findById($folio);
		$loteasociado = Lote::findById($artEncontrado->getLote());
/*		
		echo $artEncontrado->getLote();
		echo $artEncontrado->getEstado();
		echo $loteasociado->getProducto();
*/		
?>
<script type="text/javascript">
	function selectItem(val, sel){
		for(var i, j = 0; i = sel.options[j]; j++) {
			if(i.value == val) {
				sel.selectedIndex = j;
				break;
			}//if
		}//for
	}//selectItem
	
	document.getElementById('producto').value = "<?php echo $loteasociado->getProducto();?>";
	document.getElementById('producto').disabled = "disabled";
	document.getElementById('cantidad').value = "<?php echo $loteasociado->getCantidad()?>";	

	<?php 

		if(isset($_GET["folio"])){
			echo "document.getElementById('estado').value = '".$artEncontrado->getEstado()."';";
		}

	?>	

	document.getElementById('titulo').innerHTML = "Asignar Pedido";
	document.getElementById('buttonOK').innerHTML = "Asignar";
	modify = true;
	</script>

<?		
	}
?>


<?php
	include("../php/DataConnection.class.php");		
/*
	Funcion que llena el campo producto con los elementos de la tabla catalogo de productos
*/

	function getCatalogoProductos(){	
		$db = new DataConnection();
		$consulta = "SELECT * FROM catalogoProductos;";
		$res = $db->executeQuery($consulta);
		
		if (mysql_num_rows($res) < 1){
			echo ("<script>alert('No se encontraron productos en el catalogo');</script>");
		}
		else{
			while($fila = @mysql_fetch_array($res)){
				echo "<option value='".$fila["idProducto"]."'>".$fila["nombreProducto"]."</option>";
			}
		}
	}
/*
	Funcion para obtener el nombre de una galleta por su ID
	¿NECESARIA?
*/
	function findCookieById($id){
		$db = new DataConnection();
		$consulta = "SELECT * FROM catalogoproductos 
		WHERE idProducto ='$id';";
		$res = $db->executeQuery($consulta);
		if(mysql_num_rows($res) < 1){
			return "no hay";
		}
		else{
			while($fila = @mysql_fetch_array($res)){
				$galleta = $fila["nombreProducto"];
			}
			return $galleta;
		}
		return 0;		
	}
?>
<!-- 
	SCRIPTS para la funcion de asignar/modificar Linea
-->
<script type="text/javascript">

	/*
		Funcion para asignar la producción de galletas
		NOTA: 
			Esta funcion tiene un error, al momento de regresar el estado de RegistrarLinea.php
			me devuelve OK, con eso la asignacion fue correcta, pero esta funcion no toma el valor
			OK, pero si se devuelve ese valor.
	*/
	function asignarLinea(){

		parametros = "linea=" + document.getElementById('linea').value + "&";
		parametros += "encargado=" + document.getElementById('encargado').value + "&";
		parametros += "producto=" + document.getElementById('producto').value + "&";
		parametros += "cantidad=" + document.getElementById('cantidad').value + "&";
		parametros += "elaboracion=" + document.getElementById('elaboracion').value + "&";
		parametros += "caducidad=" + document.getElementById('caducidad').value;
		
		<?php 
			if(isset($_GET["numprod"]) || isset($_GET["folio"])){
				?>
				parametros += "&estado=" + document.getElementById('estado').value;
				<?php
			}
		?>					
			
		if ( modify ){
			<?php
				if(isset($_GET["numprod"])){
				?>
					parametros +="&edit=1&numprod=<?php echo $_GET["numprod"] ?>";	
				<?php
				}
				else if(isset($_GET["folio"])){
					?>
					parametros +="&edit=1&folio=<?php echo $_GET["folio"] ?>";	
					<?php
				}
			?>
			//alert("RegistrarLinea.php?" + parametros);								
		}
		//alert("RegistrarLinea.php?" + parametros);		

		sendPetitionQuery("RegistrarLinea.php?" + encodeURI(parametros));
		console.log("RegistrarLinea.php?" + encodeURI(parametros));
			
		//alert(returnedValue);

		if (returnedValue == "OK" ){
			if ( modify ){
				alert("La producción fue modificada correctamente.");
			}else{
				alert("La producción ha sido asignada correctamente.");
			}
			window.location = "./GestionarLineas.php";
		}
		else if ( returnedValue == "DATABASE_PROBLEM"){
			alert("Error en la base de datos");
		}
		else if(returnedValue == "DATE_PROBLEM"){
			alert("La fecha seleccionada ya se encuentra asignada.");
		}
		else if ( returnedValue == "INPUT_PROBLEM"){
			alert("Datos con formato inválido");
		} else {
			if ( modify ){
				alert("La producción fue modificada correctamente.");
			}
			else{
				alert("La producción ha sido asignada correctamente.");
			}
			window.location = "./GestionarLineas.php";	
		}

	}//funcion

	/*Funcion para validar los campos*/
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
		else if(validate == "linea"){
			str = str.trim();
			if(str == 0 || str > 3){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"La línea de producción no es valida!";				
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}					
		}//linea
		else if(validate == "encargado"){
			str = str.trim();
			if(str == 0){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"El encargado de línea no es valido!";
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}					
		}//linea		
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
		<?php
			if(isset($_GET['numprod']) || isset($_GET['folio'])){
				?>
		else if(validate == 'estado'){
			if(str == 0){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />" + 
				"Debes realizar un cambio en el estado!";					
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
		}//elaboracion							
				<?php
			}
		?>
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
			minDate: "+0",
			maxDate: "+20"
		});	
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
	});
</script>