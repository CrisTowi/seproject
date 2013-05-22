<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Ingresar Materia Prima</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
	</head>    
    <body>
	<?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
		    <nav>
                <div class="button" onclick="redirect('gestionProveedores.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gesti&oacute;n de Proveedores</div>
                <div class="selected-button" onclick="redirect('IngresarMP.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Gesti&oacute;n de Materia Prima</div>
                <div class="button" onclick="redirect('Compras_Reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes</div>
            </nav>
            <div id="all-content">
				<div id="content">
                <h2>Ingresar Materia Prima</h2>                
					<div class="box">
						<div onclick="redirect('Compra.php');" class="form-button">Realizar Compra</div>
						<input type="text" name="buscar" id="buscar" onkeypress="ValidaSoloNumeros()" placeholder="No Compra" class="searchBar" style="width:250px;"/>
						<img src="../img/busc.png" class="img-buscar"  alt="Buscar" onClick="onClickBusqueda();"/>
					</div>
					<div id="tablaCompras">
						<?php include("TablaCompras.php"); ?>
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
	function ValidaSoloNumeros() {
 if ((event.keyCode < 48) || (event.keyCode > 57))
  event.returnValue = false;
}
	function onClickBusqueda(){
		
		loadTable();
	}	
	
	/*Finaliza la compra*/
	function TerminarCompra(id){
		if ( confirm("Desea finalizar la compra " + id +"?") ){
			sendPetitionQuery("TerminarCompra.php?id=" + id );
			alert("La Compra ha sido finalizada exitosamente");
			loadTable();
		}
	}
	
	/*Cancelar la compra*/
	function CancelarCompra(id){
		if ( confirm("Desea cancelar la compra " + id +"?") ){
			sendPetitionQuery("CancelarCompra.php?id=" + id );
			alert("La Compra ha sido cancelada exitosamente");
			loadTable();
		}
	}
	
	/*Carga la tabla de empleado de acuerdo al filtro de busqueda*/
	function loadTable(){
		filtro = document.getElementById('buscar').value;
		sendPetitionSync("TablaCompras.php?search=" + filtro ,"tablaCompras",document);
		rePaint();
	}
	
</script>
