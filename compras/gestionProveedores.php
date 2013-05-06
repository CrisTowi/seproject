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
				<div id="content">
				<h2>Gesti&oacute;n de Proveedores</h2>
					<div class="box">
						<div onclick="redirect('registrarProveedor.php');" class="form-button">Registrar Proveedor</div>
						<input type="text" name="buscar" id="buscar" placeholder="Buscar" class="searchBar" style="width:250px;"/>
						<img src="../img/busc.png" class="img-buscar"  alt="Buscar" onClick="onClickBusqueda();"/>
					</div>					  
					<div id="tablaProveedores" class="box">
						<?php include("tablaProveedores.php"); ?>
					</div>               
                </div>
            </div>			
        </div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script type="text/javascript">
	/* Genera la tabla de empleados */
	function onClickBusqueda(){
		loadTable();
	}
	
	/*Redirige a la pagina de modificar empleado*/
	function modificarProveedor(id){
		redirect("registrarProveedor.php?id=" + id);
	}
	
	/*Confirma y elimina el empleado*/
	function eliminarProveedor(id){
		if ( confirm("¿Seguro que desea eliminar al Proveedor con RFC " + id +"?") ){
			sendPetitionQuery("eliminaProveedor.php?id=" + id );
			alert("Proveedor eliminado");
			loadTable();
		}
	}
	
	function desbloquearProveedor(id)
	{
		if ( confirm("¿Seguro que desea desbloquear al Proveedor con RFC " + id +"?") ){
			sendPetitionQuery("desbloqueaProveedor.php?id=" + id );
			alert("Proveedor desbloqueado");
			loadTable();
		}
	}

	/*Carga la tabla de empleado de acuerdo al filtro de busqueda*/
	function loadTable(){
		filtro = document.getElementById('buscar').value;
		sendPetitionSync("tablaProveedores.php?search=" + filtro ,"tablaProveedores",document);
		rePaint();
	}	
</script>