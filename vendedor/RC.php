<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="author" content="Ventas"/>
        <title>Registrar Cliente</title>
         <link rel="stylesheet" type="text/css" href="../css/ventas.css" />
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
         <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">		
    </head>    
    <body>
	 <?php include('header.php');?>   
	 <center>
        <div id="mainDiv">
		<!-- Aquí se coloca el menú -->
            <nav>
			      <div id="GV" class="button" onClick="window.location ='GestionV.php'"><img src="../img/archive.png"  alt="Icono" class="img-icon"/>Gestión de Ventas</div>     
				  <div id="GC" class="selected-button" onClick="window.location ='GestionC.php'"><img src="../img/card.png"  alt="Icono" class="img-icon"/>Gestión de Clientes</div>
				  <div id="rep" class="button" onClick="window.location ='Reportes.php'"><img src="../img/notepad.png"  alt="Icono" class="img-icon"/>Crear Reportes</div>
			</nav>
			<!-- Divisor del contenido de la pagina -->
            <div id="all-content">
                <div id="cab" class="titulo">REGISTRAR CLIENTE</div>
                <div id="tip" class="texto1">Todos los campos son obligatorios.</div>
                <table>
				<tr>
				<td><div id="dvrfc" class="texto">RFC:</div></td>
				<td><input type="text" id="RFC" class="tb" name="RFC" maxlength="13" placeholder="AAAA880326XXX" onblur="valida(this.value,'mrfc','RFC');"/></td>
				<td><span id="mrfc"></span></td>
				</tr>
				<tr>
				<td><div id="dvnom" class="texto">Nombre:</div></td>
				<td><input type="text" id="nom" class="tb" name="nom" placeholder="Nombre Cliente" onblur="valida(this.value,'mnom','nombre');"/></td>
				<td><span id="mnom"></span></td>
				</tr>
				<tr>
				<td><div id="dvtel" class="texto">Teléfono Fijo:</div></td>
				<td><input type="text" id="tel" class="tb" name="tel" maxlength="11" placeholder="55-55-55-55" onblur="valida(this.value,'mtel','telefono');"/></td>
				<td><span id="mtel"></span></td>
				</tr>
				<td><div id="dvema" class="texto">E-mail:</div></td>
				<td><input type="text" id="ema" class="tb" name="ema" placeholder="nombre@ejemplo.com" onblur="valida(this.value,'mema','email');"/></td>
				<td><span id="mema"></span></td>
				</tr>
				<tr>
				<td><div id="dvdir" class="texto">Dirección:</div></td>
				<td><textarea id="dir" class="ta" name="dir" rows="10" cols="10" placeholder="Dirección" onblur="valida(this.value,'mdir','direccion');"></textarea></td>
				<td><span id="mdir"></span></td>
				</tr>
				</table>
                <div id="buttonOK" class="form-button" onClick="agregarCliente();"><center>Aceptar</center></div>
				<div class="form-button" onClick="window.location ='Gestionc.php'"><center>Cancelar</center></div>
            </div>  
   </center>
    </body>   
</html>
<?php include('scripts.php');?> 
<script type="text/javascript">
	var modify = false;
</script>
<?php
	/*
		Verifica si es la opcion de modificar un empleado, si lo es, agrega los scripts y carga los datos correspondientes
	*/
	include("../php/Cliente.class.php");

	if (isset($_GET["id"]) ){
		$clie = $_GET["id"];
		$encontrado = Cliente::findById($clie);
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
		document.getElementById('buttonOK').innerHTML = "EDITAR";
		document.getElementById('RFC').disabled="disabled";
		document.getElementById('nom').value = "<?php echo $encontrado->getNombre(); ?>";
		document.getElementById('RFC').value = "<?php echo $encontrado->getRFC(); ?>";
		document.getElementById('tel').value = "<?php echo $encontrado->getTelefono(); ?>";
		document.getElementById('ema').value = "<?php echo $encontrado->getEmail(); ?>";
		document.getElementById('dir').value = "<?php echo $encontrado->getDireccion(); ?>";
		document.getElementById('cab').innerHTML = "Modificar Cliente";
		modify=true;		
	</script>
<?php
	}
?>
<script type="text/javascript">
	/* Agrega el empleado a la base de datos */
	function agregarCliente(){
		parametros = "nombre=" + document.getElementById('nom').value + "&";
		parametros+= "RFC=" + document.getElementById('RFC').value + "&";
		parametros+= "direccion=" + document.getElementById('dir').value + "&";
		parametros+= "telefono=" + document.getElementById('tel').value + "&";
		parametros+= "email=" + document.getElementById('ema').value + "&";
		if ( modify ){
			parametros +="&edit=1";
		}
		parametros = parametros.replace("#","%23");
		
		sendPetitionQuery("AgregaClie.php?" + encodeURI(parametros));
		
		console.log("AgregaClie.php?" + encodeURI(parametros));
		/* returnedValue almacena el valor que devolvio el archivo PHP */
		if (returnedValue == "OK" ){
			if ( modify ){
				alert("Cliente editado correctamente");
			}else{
				alert("Cliente agregado correctamente");
			}
			window.location = "./GestionC.php";
		}
		else if ( returnedValue == "DATABASE_PROBLEM"){
			alert("El RFC de cliente ya existe");
		}
		else if ( returnedValue == "INPUT_PROBLEM"){
			alert("Datos con formato inválido");
		} else {
			alert ("Error desconocido D:");
		}
	}
	
	/*function showCURPHelp(){
		alert("Fomato del CURP:\nPosición 1-4: La letra inicial y la primera vocal interna del primer apellido, la letra inicial del segundo apellido y la primera letra del nombre.\nPosición 5-10: La fecha de nacimiento en el orden año, mes y día. Para el año se tomarán los últimos dos digitos, cuando el día sea menor a diez, se antepondrá un cero.\nPosición 11: Sexo M para mujer o H para hombre.\nPosición 12-13: La letra inicial y ultima consonante del nombre de estado de nacimiento.\nPosición 14-16: Integradas por las primeras consonantes internas del primer apellido, segundo apellido y nombre.\nPosición 17: Diferenciador de homonimia. 1-9 para fechas de nacimiento hasta 1999, A-Z para fechas de nacimiento a partir de 2000.\nPosición 18: Digito verificador asignado por la Secretaría de Gobernación.");
	}*/
	
	function valida( str, target, validate ){
		if ( validate == "nombre" ){
			str = str.trim();
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' title='Este campo es obligatorio.'/>";	
			}
			else{
				var re = /^[a-zA-Z áéíóúÁÉÍÓÚ]{3,}$/;
				ok = re.exec(str);
				if ( !ok ){
					document.getElementById(target).innerHTML = "<img src='../img/error.png' title='Este campo solo acepta letras y espacios.'/>";	
				}else{
					document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				}
			}
		}
		else if ( validate == "email"){			
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' title='Este campo es obligatorio.'/>";	
			}
			else{
			if ( !validarEma(str)){
				 document.getElementById(target).innerHTML = "<img src='../img/error.png' title='Email incorrecto'/> ";			
			}
			 else {
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";			
			}}
		}
		else if ( validate == "RFC") {
			str = str.trim();
			if ( !validarRFC(str) ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' title='RFC no tiene formato correcto.'/> ";	
				//document.getElementById(target).innerHTML += "<img src='../img/help.png' onclick='showCURPHelp();' class='clickable'/>";	
			}
			else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
			
		}else if ( validate == "direccion" ){
			str = str.trim();
			if ( str.length >= 200 || str.length < 3)
				document.getElementById(target).innerHTML = "<img src='../img/error.png' title='Este campo debe tener entre 3 y 200 caracteres.'/> ";	
			else
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
		}else if ( validate == "telefono"){			
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' title='Este campo es obligatorio.'/>";	
			}
			else{
				
			if ( !validarTel(str)){
				 document.getElementById(target).innerHTML = "<img src='../img/error.png' title='Numero Telefonico Incorrecto'/> ";			
			}
			 else {
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";}
			}
		}		
	}
	
</script>
