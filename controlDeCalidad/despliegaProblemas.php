<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Visualizar problemas</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">  
        <style>
            #fechas {display: none;}
            #estatus{display: none;}        
        </style>      
    </head>    
    <body>
    	<?php include("../php/header.php"); ?>
        <center>
        <div id="mainDiv">
            <nav>
                <div class="selected-button" onclick="redirect('visualizaProblemas.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Visualizar problemas</div>
                <div class="button" onclick="redirect('seguimiento.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Seguimiento de producto</div>
                <div class="button" onclick="redirect('crearReporte.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reporte general</div>
            </nav>
            <div id="all-content">
				
                <h2>Visualizar problemas</h2>
                <div id="content">
				<table style="margin-left: 10px">
				<tr style='background-color:#333333; color: white;'>
					<td style="width: 90px;"><h2>Fecha</h2></td>
					<td style="width: 200px;"><h2>Remitente</h2></td>
					<td style="width: 300px;"><h2>Asunto</h2></td>
				</tr>
                <?php				
				include("../php/DataConnection.class.php");	
				$db = new DataConnection();
				$qry = "SELECT * FROM Mensajes,Empleado,Area WHERE Mensajes.remitente = Empleado.CURP and Empleado.Area = Area.id and Mensajes.problema = 1 ";
				if ( isset($_GET["area"])){
					$qry .= " and Empleado.area=".$_GET["area"];
				}
				if ( isset($_GET["estatus"])){
					$qry .= " and Mensajes.archivadoCC=".$_GET["estatus"];
				}
				if ( isset($_GET["from"]) ){
					$qry .= " and fecha >= '".$_GET["from"]."' and fecha <= '".$_GET["to"]."'";
				}				
				$qry .= " ORDER BY Mensajes.id DESC";
				$result = $db->executeQuery($qry);
				$cont = 0;
				while($fila = mysql_fetch_array($result))
				{		
					$cont++;
					//var_dump($fila);
					echo "<tr style='background-color:#DDDDDD;'>";
					echo "<td>".$fila["fecha"]."</td>";
					echo "<td>".$fila["nombre"]."</td>";
					echo "<td>".$fila["asunto"]."</td>";
					echo "<td style='width: 90px;'><span class='clickable' style='color:blue;'onclick='despliegaDetalles(".$fila[0].");'>Ver detalles</span></td>";
					echo "</tr>";
				}
				if ( $cont == 0 ){
					echo "<tr style='background-color:#DDDDDD;'>";
					echo "<td colspan='4'>No hay mensajes</td>";
					echo "</tr>";
				}
				?>
				</table>
                </div>
            </div>			
        </div>
        </center>
        <?php include("../php/footer.php"); ?>
		
		<div id="detalleCC" class="detalleCC">
			<div class="close" onclick="closeDetailCC();"><img src="../img/close.png" ></div>
			<center>
				<h1>Detalle</h1>
			</center>
			<div id="content">
				<div class="box">
					<!--<div class="form-button" onclick="sendMsg();">Responder</div>-->
					<div class="form-button" onclick="archivarMsgCC();" id="botonArchivarCC">Archivar</div>
				 </div>
				<div class="box">
					<div id="msgDetailCC">Aqui van el detalle</div>
				</div>			            
		   </div>
		</div>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script type="text/javascript">
    function toggleState(element, bvar) {
        var e = new String(element);
        if (!bvar) {
            document.getElementById(e).style.display = "none";
        } else {
            document.getElementById(e).style.display = "block";
        }
    }
	
	function despliegaDetalles(id){
		document.getElementById("detalleCC").style.display = "block";
		sendPetitionSync("detalleCC.php?id=" + id,"msgDetailCC",document);
		if ( document.getElementById("archivadoCC").value == 1 ){
			document.getElementById("botonArchivarCC").innerHTML = "Marcar como pendiente";
		}else{
			document.getElementById("botonArchivarCC").innerHTML = "Marcar como solucionado";
		}
	}
	
	function closeDetailCC(){
		document.getElementById("detalleCC").style.display = "none";
	}
	
	function archivarMsgCC(){
		id = document.getElementById("id").value;	
		if ( document.getElementById("archivadoCC").value == 1 ){
			sendPetitionQuery("archivaMensajeCC.php?id=" + id + "&reverse=true"); // Desarchivar
		}else{
			sendPetitionQuery("archivaMensajeCC.php?id=" + id); // Archivar
		}	
		if ( returnedValue == "OK" ){
			alert("Operacion realizada correctamente");
			closeDetails();
			redirect(document.URL);
		}else{
			alert("Error desconocido :(");
		}
	}
	
</script>    