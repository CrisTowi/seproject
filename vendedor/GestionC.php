<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Gestión de Clientes</title>
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
            <!--<div id="mainDiv">
			<!-- Divisor del contenido de la pagina -->
           <div id="all-content">
				<div class="box">
				<div id="AC" class="form-button" onClick="window.location ='RC.php'">Registar Cliente</div>
			        <input type="text" id="buscar" name="buscar" placeholder = "Buscar Cliente(RFC,Nombre)" class="searchBar" onChange="onClickBusqueda();" style="width:250px;"/>
				</div>
				<div id="tablaCliente"><?php include("TablaClientes.php"); ?></div>
         </div>  
         </div>
     </center>   
       
    </body>   
</html>
<?php include('scripts.php');?> 
<script type="text/javascript">
	/* Genera la tabla de empleados */
	function onClickBusqueda(){
		loadTable();
	}
	/*Redirige a la pagina de modificar cliente*/
	function modificarCliente(id){
		window.location ="RC.php?id=" + id;	
	}
	
	/*Confirma y elimina el cliente*/
	function eliminarCliente(id){
		if ( confirm("¿Seguro que desea eliminar al cliente con RFC " + id +"?") ){
			sendPetitionQuery("EliminaCliente.php?id=" + id );
			alert("Cliente eliminado");
			loadTable();
		}
	}
	function recuperarCliente(id){
		if ( confirm("¿Seguro que desea recuperar al cliente con RFC " + id +"?") ){
			sendPetitionQuery("RecuperarCliente.php?id=" + id );
			alert("Cliente Recuperado");
			loadTable();
		}
	}
	/*Carga la tabla de cliente de acuerdo al filtro de busqueda*/
	function loadTable(){
		filtro = document.getElementById('buscar').value;
		sendPetitionSync("TablaClientes.php?search=" + filtro,"tablaCliente",document);
		rePaint();
	}	
</script>