<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="author" content="Ventas"/>
        <title>Registrar Venta</title>
        <link rel="stylesheet" type="text/css" href="../css/ventas.css" />
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
    </head>    
    <body>
	<!-- El header es el mismo para todas las paginas-->
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
				<br/>
                <div id="ti" class="titulo">REGISTRAR VENTA</div>
                 <div id="tip" class="texto1">Todos los campos son obligatorios.</div>
                <form name="Rvalida">
                <input id="idVenta" name="idVenta" type="hidden"/>
                <table id="Tablap">
					<tr>
						
						<td colspan="5"></td>
						<td class="texto">Fecha</td>
						<td><script type="text/javascript">
						var date = new Date();
						var d  = date.getDate();
						var day = (d < 10) ? '0' + d : d;
						var m = date.getMonth() + 1;
						var month = (m < 10) ? '0' + m : m;
						var yy = date.getYear();
						var year = (yy < 1000) ? yy + 1900 : yy;
						document.write(day + "/" + month+ "/" + year);
						</script></td>
						<td cospan="3"></td>
					</tr>
					<tr>
						<td class="texto">Cliente:</td>
						<td> <?php include("SelectClie.php"); ?></td>
						<td colspan="8"></td>
					</tr>
					<tr>
						<td class="texto">Articulos</td>
						<td colspan="9"><hr size="5"/></td>
					</tr>
					<tr>
						<td class="texto">Producto:</td>
						<td><?php include("SelectProd.php"); ?></td>
						<td class="texto" id="prec"></td>
						<td id="exi"></td>
						<td class="texto">Lotes:</td>
						<td><select id='cant' disabled></select></td>
						<td><img src="../img/busc.png" class="img-buscar"  alt="Buscar" onClick="ex();"/></td>
						<td colspan="3"></td>						
					</tr>
					<tr>
						<td id="exss" class="texto"></td>
						<td id="exis"><div></div></td>
						<td></td>
						<td><div id="BotonVenta" class="form-button" onClick="AddArt();">Agregar</div></td>
						<td></td>
						<td></td>
						<td></td>
						<td colspan="3"></td>
					</tr>
				</table> 
				<div id="Articulotab" class="box">
						<table id="table-aux" style="padding-left:30px;">
							<tbody id="cuerpoT" name="cuerpoT">
								<tr id="titulosTr" class="tr-header">
								<td>Lote</td>
								<td>Producto</td>
								<td>Cantidad</td>
								<td>Precio/Paquete</td>
								<td>Precio/Total</td>
								<td></td>
								<td></td>
								</tr>
							</tbody>
						</table>
					</div> 
				    <div id="buttonOK" class="form-button" onclick="agregarVenta();">Aceptar</div>                   
                    <div id="buttonCancel" class="form-button" onClick="window.location='GestionV.php'">Cancelar</div>
                  </form>
                </div>
            </div>   
            <center> 
    </body>   
</html>

<?php include('scripts.php'); ?> 	
<script type="text/javascript" src="../js/manejoArticuloVentas.js"></script>
<!--<script type="text/javascript" src="jquery-1.4.2.min.js"></script>-->
<script type="text/javascript">
//parte para llenar los cosos :)
	 $(document).ready(function(){
        $("#prod").change(function(event){
        	document.getElementById('prec').innerHTML="";
            document.getElementById('exi').innerHTML="";
        	document.getElementById('cant').disabled="";
            var id = $("#prod").find(':selected').val();
            $("#cant").load('selectLote.php?id='+id);
            document.getElementById('prec').innerHTML="Precio:";
	    	$("#exi").load('Getprec.php?id='+id);
            document.getElementById('exss').innerHTML="";
            document.getElementById('exis').innerHTML="";
            //$("#exi").load('Getprec.php?id='+id);
        });
        $("#cant").change(function(event){
        	document.getElementById('exss').innerHTML="";
            document.getElementById('exis').innerHTML="";
         });
    });
    function ex(){
    	var id=$("#cant").find(':selected').val();
    	document.getElementById('exss').innerHTML="Disponible:";
    	$("#exis").load('Getexist.php?id='+id);
    	
    };
    //sendPetitionSync("TablaArti.php?Folio="+document.getElementById('clie').value,"tablaArti",document);
</script>
<script type="text/javascript">
	/* Agrega el empleado a la base de datos */
	function agregarVenta(){
		parametros = "idVenta=" + document.getElementById('idVenta').value + "&";
		parametros+= "Cliente=" + document.getElementById('clie').value;
		var arrayElements = new Array();
			var arrayElementsIDES = new Array();
		    arrayElements = document.getElementsByClassName("cantidades");					
			arrayElementsIDES = document.getElementsByClassName("ides");
			arrayElementsp = document.getElementsByClassName("produ");
			
			for(i=1;i<=arrayElements.length;i++)
			{
				parametros+="&Articulo"+i+"="+arrayElementsIDES[i-1].value;				
				parametros+="&cantidad"+i+"="+arrayElements[i-1].value;	
				parametros+="&Producto"+i+"="+arrayElementsp[i-1].value;
			}
			parametros+="&numeroFilas="+arrayElements.length;
		
		sendPetitionQuery("AgregaVenta.php?" + encodeURI(parametros));
		
		console.log("AgregaVenta.php?" + encodeURI(parametros));
		//returnedValue almacena el valor que devolvio el archivo PHP 
		if (returnedValue == "OK" ){
				alert("La Venta ha sido agregada correctamente");
			    window.location = "./GestionV.php";
		}
		else if ( returnedValue == "DATABASE_PROBLEM"){
			alert("No se pudo establecer conexión con la base de datos");
		}
		else if ( returnedValue == "INPUT_PROBLEM"){
			alert("Datos con formato inválido");
		} 
		else if ( returnedValue == "INPUT_DESB"){
			alert("Lo siento las unidades no son suficientes");
		}
		else {
			alert (returnedValue);
		}
	}
		
</script>

