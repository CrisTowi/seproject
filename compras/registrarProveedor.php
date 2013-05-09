<!--
	registrarProveedor.php
	Última modificación: 05/05/2013
	
	Agrega proveedor o los modifica
	
	Recibe: 
		$_GET["id"] : RFC del proveedor a modificar ó
					  sin definir cuando se va a agregar uno nuevo
	
	- Documentación del código: OK
-->
<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>M&oacute;dulo Compras</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
	</head>
    <body>
	<?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
		<!-- Aquí se coloca el menú -->
            <nav>
				<div class="selected-button" onclick="redirect('gestionProveedores.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gesti&oacute;n de Proveedores</div>
                <div class="button" onclick="redirect('IngresarMP.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Gesti&oacute;n de Materia Prima</div>
                <div class="button" onclick="redirect('Compras_Reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes</div>
            </nav>
			<!-- Divisor del contenido de la pagina -->
            <div id="all-content">
                <h2 id="titulo">Registrar Proveedor</h2>
				Todos los campos son obligatorios.
				<form id="altaProveedor" action="agregaProveedorBD.php"name="altaProveedor" method ="POST">
					<div id="content">
						<div class="box">
							<table>
								<tr>
									<td>RFC:</td>
									<td><input type="text" name="rfc" id="rfc" placeholder="RFC" onblur="valida(this.value,'msgRFC','rfc');"/></td>
									<td><span id="msgRFC"></span></td>
								</tr>
								<tr>
									<td>Nombre:</td>
									<td><input type="text" name="nombre" id="nombre" placeholder="Nombre" onblur="valida(this.value,'msgNombre','nombre');"/></td>
									<td><span id="msgNombre"></span></td>
								</tr>
								<tr>
									<td>Direccion:</td>
									<td><input type="text" name="direccion" id="direccion" placeholder="Direccion" onblur="valida(this.value,'msgDireccion','direccion');"/></td>
									<td><span id="msgDireccion"></span></td>
								</tr>
								<tr>
									<td>Tel&eacute;fono:</td>
									<td><input type="text" name="telefono" id="telefono" placeholder="Telefono" onblur="valida(this.value,'msgTelefono','telefono');"/></td>
									<td><span id="msgTelefono"></span></td>
								</tr>
								<tr>
									<td>Email:</td>
									<td><input type="text" name="email" id="email" placeholder="alguien@example.com" onblur="valida(this.value,'msgEmail','email');"/></td>
									<td><span id="msgEmail"></span></td>
								</tr>
							</table>
							<div class="box">
								<table id="productos">
									<tr class="tr-header">
										<td>Producto</td>
										<td>Precio</td>
									</tr>
									<tr>
										<td>
											<select id='sproductos1'>
												<div >
													<?php include("SelectMateriaPrima.php"); ?>
												</div>
											</select>
										</td>
										<td><input type="text" name="precio1" id="precio1" onblur="valida(this.value,'msgPrecio1','precio');" value="0" /></td>
										<td><span id="msgPrecio1"></span></td>
										<td><img src="../img/add.png" onClick="agregarProducto()" class='clickable'/></td>
									</tr>
								</table>
							</div>
							<div class="box">
								<div id="buttonOK" class="form-button" onclick="agregarProveedor();">Registrar</div>
								<div class="form-button" onclick="redirect('gestionProveedores.php')">Cancelar</div>	
							</div>
						</div>
					</div>	
				</form>
			</div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>

<script type="text/javascript">
	var modify = false;
	var posicionCampo = 2;
	var noMateriasPrimas = document.altaProveedor.sproductos1.length;	//total de materias en la bd
	
</script>

<?php
	/*
		Verifica si es la opcion de modificar un proveedor, si lo es, agrega los scripts y carga los datos correspondientes
	*/
	if ( isset($_GET["id"]) ){
		$pvr = $_GET["id"];
		include ("../php/Proveedor.class.php");
		$encontrado = Proveedor::findById($pvr);
?>
	<script type="text/javascript">

	function selectItem(val,sel){
			for(var i, j = 0; i = sel.options[j]; j++) {
				if(i.value == val) {
					sel.selectedIndex = j;
					break;
				}
			}
	}
	
	document.getElementById('rfc').disabled="disabled";
	document.getElementById('rfc').value = "<?php echo $encontrado->getRFC(); ?>";
	document.getElementById('nombre').value = "<?php echo $encontrado->getNombre(); ?>";
	document.getElementById('direccion').value = "<?php echo $encontrado->getDireccion(); ?>";
	document.getElementById('telefono').value = "<?php echo $encontrado->getTelefono(); ?>";
	document.getElementById('email').value = "<?php echo $encontrado->getEmail(); ?>";
	
	/* Recuperamos los productos y precios y los guardamos en unos arreglos */
	<?php echo "var productos = ".json_encode($encontrado->getProductos()).";\n" ?>;
	<?php echo "var precios = ".json_encode($encontrado->getPrecios()).";\n" ?>;
	
	selectItem(productos[0], document.getElementById("sproductos1"));
	document.getElementById('precio1').value = precios[0];
	
	for(i = 1; i < productos.length; i++, posicionCampo++)
	{
		nuevaFila = document.getElementById('productos').insertRow(-1);
		nuevaFila.id = posicionCampo;
		nuevaCelda = nuevaFila.insertCell(-1);
		nuevaCelda.innerHTML="<select id='sproductos"+posicionCampo+"'><?php include("SelectMateriaPrima.php"); ?></select>";
		
		/* Le ponemos su indice seleccionado */
		selectItem(productos[i], document.getElementById("sproductos"+posicionCampo));
		
		nuevaCelda = nuevaFila.insertCell(-1);
		nuevaCelda.innerHTML="<input type='text' name='precio"+posicionCampo+"' id='precio"+posicionCampo+"' value ='"+precios[i]+"' onblur=\"valida(this.value,'msgPrecio"+posicionCampo+"','precio');\" value='0' />";
		nuevaCelda=nuevaFila.insertCell(-1);
		nuevaCelda.innerHTML="<span id='msgPrecio"+posicionCampo+"'></span>";
		nuevaCelda=nuevaFila.insertCell(-1);
		nuevaCelda.innerHTML="<img src= '../img/less.png' class='clickable' onclick='eliminarProducto(this);'>";
	}
		
	document.getElementById('titulo').innerHTML = "Modificar Proveedor";
	document.getElementById('buttonOK').innerHTML = "Actualizar";
	
	modify = true;
	</script>
<?php
	}
?>

<script type="text/javascript">
	/* Agrega el proveedor a la base de datos */
	function agregarProveedor(){
		parametros = "rfc=" + document.getElementById('rfc').value + "&";
		parametros+= "nombre=" + document.getElementById('nombre').value + "&";
		parametros+= "direccion=" + document.getElementById('direccion').value + "&";
		parametros+= "telefono=" + document.getElementById('telefono').value + "&";
		parametros+= "email=" + document.getElementById('email').value + "&";
		
		var filas = document.getElementById("productos").rows.length - 1;
		parametros += "numprod="+ filas + "&"  ;
		
		for (var i = 1 ;i<=filas ;i++ ){
			parametros+= "producto"+ i+"=" + document.getElementById('sproductos'+i).value + "&";
			parametros+= "precio"+ i+"=" + document.getElementById('precio'+i).value + "&";
		}
		
		parametros = parametros.substring(0,parametros.length-1);	//Se le quita el & que sobra por el for
		
		if ( modify ){
			parametros +="&edit=1";
		}
		parametros = parametros.replace("#","%23");
		
		sendPetitionQuery("agregaProveedorBD.php?" + encodeURI(parametros));
		console.log("agregaProveedorBD.php?" + encodeURI(parametros));
		/* returnedValue almacena el valor que devolvio el archivo PHP */
		if (returnedValue == "OK" ){
			if ( modify ){
				alert("Proveedor editado correctamente");
			}else{
				alert("Proveedor agregado correctamente");
			}
			window.location = "./gestionProveedores.php";
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
	
	function showRFCHelp(){
		alert("Fomato del RFC:\n"
				+ "Posición 1-4: La letra inicial y la primera vocal interna del primer apellido, la letra inicial del segundo apellido y la primera letra del nombre.\n"
				+ "Posición 5-10: La fecha de nacimiento en el orden año, mes y día. Para el año se tomarán los últimos dos digitos, cuando el día sea menor a diez, se antepondrá un cero.\n"
				+ "Posición 11-13: Homoclave");
	}
	
	function valida( str, target, validate ){
		if ( validate == "nombre" ){
			str = str.trim();
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />Este campo es obligatorio.";	
			}
			else{
				var re = /^[a-zA-Z áéíóúÁÉÍÓÚ]{3,}$/;
				ok = re.exec(str);
				if ( !ok ){
					document.getElementById(target).innerHTML = "<img src='../img/error.png' />Este campo solo acepta letras y espacios.";	
				}else{
					document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				}
			}
		}
		
		else if ( validate == "rfc") {
			str = str.trim();
			if ( !validarRFC(str) ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' /> RFC no tiene formato correcto. ";	
				document.getElementById(target).innerHTML += "<img src='../img/help.png' onclick='showRFCHelp();' class='clickable'/>";	
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
			
		}
		
		else if ( validate == "direccion" ){
			str = str.trim();
			if ( str.length >= 200 || str.length < 3)
				document.getElementById(target).innerHTML = "<img src='../img/error.png' /> Este campo debe tener entre 3 y 200 caracteres.";	
			else
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				
		}
		
		else if ( validate == "telefono" ){
			str = str.trim();
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />Este campo es obligatorio.";	
			}
			else{
				if ( !validarTel(str) ){
					document.getElementById(target).innerHTML = "<img src='../img/error.png' />";
				}else{
					document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				}
			}
		}
		
		else if ( validate == "email" ){
			str = str.trim();
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />Este campo es obligatorio.";	
			}
			else{
				if ( !validarEma(str) ){
					document.getElementById(target).innerHTML = "<img src='../img/error.png' />";
				}else{
					document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				}
			}
		}
		
		else if ( validate == "precio" ){
			str = str.trim();
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />";	
			}
			else{
				var re = /^\d+\.?\d*$/;
				ok = re.exec(str);
				if ( !ok ){
					document.getElementById(target).innerHTML = "<img src='../img/error.png' />";						
				}else{
					document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				}
			}
		}
	}
	
	function agregarProducto(){
		var filas = document.getElementById('productos').rows.length - 1;	//menos 1 por la fila de los titulos
		
		if (noMateriasPrimas > filas){
			nuevaFila = document.getElementById('productos').insertRow(-1);
			nuevaFila.id = posicionCampo;
			nuevaCelda = nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<select id='sproductos"+posicionCampo+"'><?php include("SelectMateriaPrima.php"); ?></select>";
			nuevaCelda = nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<input type='text' name='precio"+posicionCampo+"' id='precio"+posicionCampo+"' onblur=\"valida(this.value,'msgPrecio"+posicionCampo+"','precio');\" value='0' />";
			nuevaCelda=nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<span id='msgPrecio"+posicionCampo+"'></span>";
			nuevaCelda=nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<img src= '../img/less.png' class='clickable' onclick='eliminarProducto(this);'>";
			posicionCampo++;
		}
	}	
	
	function eliminarProducto(obj){
		var oTr = obj;
		while(oTr.nodeName.toLowerCase()!='tr'){
			oTr=oTr.parentNode;
		}
		var root = oTr.parentNode;
		root.removeChild(oTr);
	}
	
</script>