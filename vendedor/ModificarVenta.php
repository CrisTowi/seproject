<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="author" content="Ventas"/>
        <title>Modificar Venta</title>
        <link rel="stylesheet" type="text/css" href="../css/ventas.css" />
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
    </head>    
    <body>
	<!-- El header es el mismo para todas las paginas-->
    	<?php include('header.php');?>
        <center>
        <div id="mainDiv">
		<!-- Aqu� se coloca el men� -->
            <nav>
			      <div id="GV" class="selected-button" onClick="window.location ='GestionV.php'"><img src="../img/archive.png"  alt="Icono" class="img-icon"/>Gestión de Ventas</div>     
				  <div id="GC" class="button" onClick="window.location ='GestionC.php'"><img src="../img/card.png"  alt="Icono" class="img-icon"/>Gestión de Clientes</div>
				  <div id="rep" class="button" onClick="window.location ='Reportes.php'"><img src="../img/notepad.png"  alt="Icono" class="img-icon"/>Crear Reportes</div>
			</nav>
			<!-- Divisor del contenido de la pagina -->
            <div id="all-content" >
				<br/>
                <div id="ti" class="titulo">MODIFICAR VENTA</div>
                 <div id="tip" class="texto1"></div>
        	    <div style="display: block">
                <table id="Tablap">
                	<tbody>
					<tr>
						<td colspan="7"></td>
						<td class="texto" align="right" colspan="2">Fecha de Realización:</td>
						<td id="FechaR"></td>
						<td class="texto" colspan="2">Fecha de Entrega:</td>
						<td id="fentr"><input type="text" id="to" name="to" placeholder="Fecha de fin"/></td>
					</tr>
					<tr>
						<td colspan="5"></td>
						<td ></td>
						<td class="texto" colspan="2">Folio de Venta:</td>
						<td id="Folios"></td>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan="6"></td>
						<td class="texto" colspan="3" align="right">Cliente:</td>
						<td class="texto" id="cliente"> La vaca Feliz</td>
						<td colspan="4"></td>
						
					</tr>
					<tr>
						<td colspan="6"></td>
						<td class="texto" align="center">Articulos</td>
						<td class="texto" colspan='7'><hr size="5"/></td>
		           </tr>
					<tr>
						<td colspan="14" align="center" id="Articulotab" ><?php include("TablaARti.php"); ?></td>
					</tr>
					</tbody>
				</table>	
				</div>
				<div  id="botones" style="display: block">
					<div id="buttonOK" class="form-button" onclick="modificarVenta();">Aceptar</div>                
                	<div id="buttonCancel" class="form-button" onClick="window.location='GestionV.php'">Cancelar</div>
				 </div>  
            </div>   
            </center> 
    </body>   
</html>
<?php include('scripts.php');?>
<?php
    include("../php/venta.class.php");
	if ( isset($_GET["id"]) ){
		$emp = $_GET["id"];
		$encontrado = Venta::findById($emp);
		$cliente=Venta::NombreClie($encontrado->getCliente());
?>


<script type="text/javascript">
        var eliminar = new Array();
        var i=0;
        function loadTable(view){
			filtro = document.getElementById('Folios').innerHTML;
			sendPetitionSync("TablaARti.php?Folio=" + filtro+"&view="+view,"Articulotab",document);
			rePaint();
		}
		function cancelarArticulo(idlote)
		{ 	if ( confirm("¿Seguro que desea cancelar de la venta articulo con lote " + idlote +"?") ){
			eliminar[i]=idlote;
			var el=document.getElementById(idlote);
			var padre = el.parentNode;
			padre.removeChild(el);
			i+=1;}
		}	
		document.getElementById('Folios').innerHTML = "<?php echo $encontrado->getFolio(); ?>";
		document.getElementById('cliente').innerHTML = "<?php echo $cliente; ?>";
		document.getElementById('FechaR').innerHTML = "<?php echo $encontrado->getFecha(); ?>";
		document.getElementById('to').value = "<?php echo $encontrado->getFentrega(); ?>";
		
		<?php
		if(isset($_GET['view'])){?>
		document.getElementById('ti').innerHTML="VISUALIZAR VENTA";
		document.getElementById('tip').innerHTML="Informacion detallada de la venta.";
		document.getElementById('fentr').innerHTML="";
		document.getElementById('fentr').innerHTML="<?php echo $encontrado->getFentrega(); ?>";
		var el=document.getElementById('buttonOK');
		var padre = el.parentNode;
		padre.removeChild(el);
		loadTable(1);
		<?php }
		else {?>
		loadTable(0);
		<?php }?>
		function modificarVenta(){
		parametros = "Folio=" + document.getElementById('Folios').innerHTML + "&";	
		parametros += "Fentrega=" + document.getElementById('to').value + "&";
		for (c=0; c <= eliminar.length-1;c++) 
		{
			parametros+= "Eliminar"+c+"=" + eliminar[c] + "&";
		}
		parametros +="noEl="+eliminar.length;
		sendPetitionQuery("ModiVenta.php?" + encodeURI(parametros));
		
		console.log("ModiVenta.php?" + encodeURI(parametros));
		if (returnedValue == "OK" ){
	    alert("Venta editada correctamente");
	    window.location= "./GestionV.php";
		}
		else if ( returnedValue == "DATABASE_PROBLEM"){
			alert("No se pudo modificar la venta correctamente");
		}
		else if ( returnedValue == "INPUT_PROBLEM"){
			alert("Datos con formato inválido");
		} else {
			alert ("Error desconocido D:");
		}
		}
		
		
</script>
<?php
	}
?>

    