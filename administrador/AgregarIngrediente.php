<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Agregar Ingrediente</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
    </head>    
    <body>
    	<?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
        <nav>
			<div class="selected-button" onclick="redirect('GestionEmpleado.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gestión Empleados</div>
			<div class="button" onclick="redirect('GestionProducto.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Gestión Productos</div>
   			<div class="button" onclick="redirect('GestionReceta.php');"><img src="../img/note.png"  alt="Icono" class="img-icon" />Gestión Recetas</div>
			<div class="button" onclick="redirect('Reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Solicitar Reporte</div>
        </nav>
		<div id="all-content">
                <h2 id="titulo">Agregar Ingrediente</h2>
				<form id="altaEmpleado" action="AgregaEmp.php"name="altaEmpleado" method ="POST">
				<div id="content">
                    <div class="box">
					<table>						
						
						<tr>
						   <td>Nombre: </td>
						   <td><input id="nombre" name="nombre" type="text" placeholder="Nombre del Ingrediente" onblur="valida(this.value,'msgNombre','nombre');"/></td>
						   <td><span id="msgNombre"></span></td>
						</tr>
						<tr>
								<td>Unidad:</td>
                                <td>
                                    <select name="unidad" id="unidad">
                                        <option value="Kilogramos">Kilogramos</option>
                                        <option value="Litros">Litros</option>
                                        <option value="Onzas">Onza</option>
                                        <option value="Paquetes">Paquetes</option>
                                    </select>
                                </td>
                        </tr>					
					</table>
					</div>
                    
                    <div class="box">
						<div id="buttonOK" class="form-button" onclick="agregarIngrediente();">Agregar</div>
                        <div class="form-button" onclick="cancelar();">Cancelar</div>	
                    </div>
                </div>
				</form>
            </div>
			
        </div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<script type="text/javascript">
	var modify = false;
</script>

<?php
	/*
		Verifica si es la opcion de modificar un ingrediente, si lo es, agrega los scripts y carga los datos correspondientes
	*/
	include("../php/Ingrediente.class.php");
	if ( isset($_GET["id"]) ){
		$id = $_GET["id"];
		$encontrado = Ingrediente::findById($id);
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
	
		document.getElementById('nombre').value = "<?php echo $encontrado->getNombre(); ?>";		
		document.getElementById('titulo').innerHTML = "Editar Ingrediente";
		document.getElementById('buttonOK').innerHTML = "Editar";
		selectItem( <?php echo $encontrado->getUnidad(); ?> , document.getElementById("unidad"));
		modify = true;
	</script>
<?php
	}
?>
<!-- Agrega los scripts de la pantalla y el modulo -->
<?php include("scripts.php"); ?>
<script type="text/javascript">
	/* Agrega el empleado a la base de datos */
	function agregarIngrediente(){
		parametros = "nombre=" + document.getElementById('nombre').value + "&";
		parametros+= "unidad=" + document.getElementById('unidad').value;
		
		if ( modify ){
			parametros +="&edit=1";
		}
		parametros = parametros.replace("#","%23");
		sendPetitionQuery("AgregaIng.php?" + encodeURI(parametros));
		console.log("AgregaIng.php?" + encodeURI(parametros));
		/* returnedValue almacena el valor que devolvio el archivo PHP */
		if (returnedValue == "OK" ){
			if ( modify ){
				alert("Ingrediente editado correctamente");
			}else{
				alert("Ingrediente agregado correctamente");
			}
			history.back()
		}
		else if ( returnedValue == "DATABASE_PROBLEM"){
			alert("Error en la base de datos");
		}
		else if ( returnedValue == "INPUT_PROBLEM"){
			alert("Datos con formato inválido");
		} else {
			alert (returnedValue);
		}
	}
	
	
	function cancelar(){
				history.back()
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

	}
	
</script>