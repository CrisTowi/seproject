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
                <div class="button" onclick="redirect('gestionProveedores.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gesti&oacute;n Proveedores</div>
                <div class="selected-button" onclick="redirect('IngresarMP.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Gesti&oacute;n Materia Prima</div>
                <div class="button" onclick="redirect('Compras_Reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes</div>
            </nav>
            <div id="all-content">
				<div id="content">
                <h2>Ingresar Materia Prima</h2>                
					<div class="box">
						<div>
							<div onclick="redirect('Compra.php');" style="float:left" class="form-button">Realizar Compra</div>
							<div style="float:right">
									<input type="text" name="buscar" id="buscar" placeholder="Buscar" class="searchBar" style="width:250px;"/>
									<img src="../img/busc.png" class="img-buscar"  alt="Buscar" onClick="onClickBusqueda();"/>&nbsp; &nbsp;
							</div>
						</div>
						<div id="tablaCompras">
							<?php include("TablaCompras.php"); ?>
						</div>
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
	
	function onClickBusqueda(){
		loadTable();
	}	
	
	/*Finaliza la compra*/
	function TerminarCompra(id){
		if ( confirm("Desea dar por finalizada la compra " + id +"?") ){
			sendPetitionQuery("TerminarCompra.php?id=" + id );
			alert("Compra Finalizada!!!");
			loadTable();
		}
	}
	
	/*Cancelar la compra*/
	function CancelarCompra(id){
		if ( confirm("Deseas Cancelar la compra " + id +"?") ){
			sendPetitionQuery("CancelarCompra.php?id=" + id );
			alert("Compra Cancelada!!!");
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
