<!--
	AgregarEmpleado.php
	Última modificación: 17/04/2013
	
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
									<td><input type="text" name="email" id="email" placeholder="alguien@example.com"/></td>
									<td><span id="msgEmail"></span></td>
								</tr>
							</table>
							<!-- 
							<div class="box">
								Producto: <select><option>Producto1</option><option>Producto2</option></select>
								<div class="evento"><img src="img/less.png" alt="Eliminar" name="eliminar"/></div> 
								<div class="form-button">Agregar Producto</div>
							</div>
							<div class="box">
								Producto: <select><option>Producto1</option><option>Producto2</option></select>
								<div class="evento"><img src="img/less.png" alt="Eliminar" name="eliminar"/></div>
							</div> 
							-->
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
		parametros+= "email=" + document.getElementById('email').value;
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
		alert("Fomato del RFC:\nPosición 1-4: La letra inicial y la primera vocal interna del primer apellido, la letra inicial del segundo apellido y la primera letra del nombre.\nPosición 5-10: La fecha de nacimiento en el orden año, mes y día. Para el año se tomarán los últimos dos digitos, cuando el día sea menor a diez, se antepondrá un cero.");
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
			
		}else if ( validate == "direccion" ){
			str = str.trim();
			if ( str.length >= 200 || str.length < 3)
				document.getElementById(target).innerHTML = "<img src='../img/error.png' /> Este campo debe tener entre 3 y 200 caracteres.";	
			else
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				
		}else if ( validate == "telefono" ){
			str = str.trim();
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />Este campo es obligatorio.";	
			}
			else{
				var re = /^[0-9]{8,}$/;
				ok = re.exec(str);
				if ( !ok ){
					document.getElementById(target).innerHTML = "<img src='../img/error.png' />Este campo solo acepta numeros.";	
				}else{
					document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				}
			}
		}
	}
	
</script>