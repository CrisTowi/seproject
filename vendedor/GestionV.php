<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Gestión de Ventas</title>
        <link rel="stylesheet" type="text/css" href="../css/ventas.css" />
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
 
    </head>    
    <body>
	 <?php include('header.php');?>   
	   <center>
        <div id="mainDiv">
		<!-- Aquí se coloca el menú -->
            <nav>
			      <div id="GV" class="selected-button" onClick="window.location ='GestionV.php'"><img src="../img/archive.png"  alt="Icono" class="img-icon"/>Gestión de Ventas</div>     
					<div id="GC" class="button" onClick="window.location ='GestionC.php'"><img src="../img/card.png"  alt="Icono" class="img-icon"/>Gestión de Clientes</div>
					<div id="rep" class="button" onClick="window.location ='Reportes.php'"><img src="../img/notepad.png"  alt="Icono" class="img-icon"/>Crear Reportes</div>
			</nav>
			<!-- Divisor del contenido de la pagina -->
            <div id="all-content">
                <div class="box">
                    <div id="AV" class="form-button" onClick="window.location ='Registrar_Venta.php'">Registar Venta</div>
		            <input type="text" id="buscar" name="buscar" placeholder = "Buscar Venta (RFC,FolioVenta)" class="searchBar" onChange="onClickBusqueda();" style="width:250px;"/>
			   </div>
    			   <div id="tablaVenta"><?php include("TablaVentas.php"); ?></div>
				</div>
            </div>  
        </center>
 <?php include("../php/footer.php"); ?>      
    </body>   
</html>
<?php include('scripts.php');?> 
<script type="text/javascript">
	/* Genera la tabla de empleados */
	function onClickBusqueda(){
		loadTable();
	}
	/*Redirige a la pagina de modificar cliente*/
	function modificarVenta(id){
		window.location ="ModificarVenta.php?id="+ id;
		console.log("ModificarVenta.php?id=" + id);
	}
	function ViewVenta(id){
		window.location ="ModificarVenta.php?id="+ id+"&view=1";
		console.log("ModificarVenta.php?id=" + id+"&view=1");
	}
	/*Confirma y elimina el cliente*/
	function cancelarVenta(id){
		if ( confirm("¿Seguro que desea cancelar la venta con Folio " + id +"?") ){
			sendPetitionQuery("CancelaVenta.php?id=" + id );
			alert("Venta Cancelada");
			loadTable();
		}
	}

	/*Carga la tabla de cliente de acuerdo al filtro de busqueda*/
	function loadTable(){
		filtro = document.getElementById('buscar').value;
		sendPetitionSync("TablaVentas.php?search=" + filtro,"tablaVenta",document);
		rePaint();
	}	
</script>
