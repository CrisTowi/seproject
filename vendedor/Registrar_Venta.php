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
                <table id="Tablap">
					<tr>
						<td></td>
						<td colspan="4"><!-- <?php include("GenrFolio.php"); ?>--></td>
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
					</tr>
					<tr>
						<td class="texto">Cliente:</td>
						<td> <?php include("SelectClie.php"); ?></td>
						<td colspan="5"></td>
					</tr>
					<!--<tr>
						<td colspan='4'><div id="BotonVenta" class="form-button"   onClick="agregarVenta()">Abrir Venta</div></td>
					</tr>-->
					<tr>
						<td class="texto" colspan='7'>Articulos</td>
					</tr>
					<tr>
						<td class="texto">Producto:</td>
						<td><?php include("SelectProd.php"); ?></td>
						<td class="texto" id="prec"></td>
						<td id="exi"></td>
						<td class="texto">Lotes:</td>
						<td><select id='cant' disabled></select></td>
						<td><img src="../img/busc.png" class="img-buscar"  alt="Buscar" onClick="ex();"/></td>						
					</tr>
					<tr>
						<td id="exss" class="texto"></td>
						<td id="exis"><div></div></td>
						<td></td>
						<td><div id="BotonVenta" class="form-button" onClick="AddArt();">Agregar</div></td>
						<td></td>
						<td></td>
						<td></td>
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
								<td></td>
								</tr>
							</tbody>
						</table>
					</div> 
				    <div id="buttonOK" class="form-button" onclick="">Aceptar</div>                   
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
    //sendPetitionSync("TablaArti.php?Folio="+document.getElementById('clie').value,"tablaArti",document);
</script>
<script type="text/javascript">
    function ex(){
    	var id=$("#cant").find(':selected').val();
    	document.getElementById('exss').innerHTML="Disponible:";
    	$("#exis").load('Getexist.php?id='+id);
    	
    }
</script>
<!--<script type="text/javascript">
	/* Agrega el empleado a la base de datos */
	/*function agregarVenta(){
		parametros= "Cliente=" + document.getElementById('clie').value;
		parametros = parametros.replace("#","%23");
		
		sendPetitionQuery("AgregaVenta.php?" + encodeURI(parametros));
		
		console.log("AgregaVenta.php?" + encodeURI(parametros));
		/* returnedValue almacena el valor que devolvio el archivo PHP 
		if (returnedValue == "OK" ){
				alert("Venta agregado correctamente");
			//window.location = "./GestionV.php";
		}
		else if ( returnedValue == "DATABASE_PROBLEM"){
			alert("Error en la base de datos");
		}
		else if ( returnedValue == "INPUT_PROBLEM"){
			alert("Datos con formato inválido");
		} else {
			alert ("Error desconocido D:");
		}
	}
	function AddArt(){
		parametros="Folio=" + document.getElementById('fol').value;
		parametros+= "&Lote=" + document.getElementById('cant').value;
		parametros+= "&Producto=" + document.getElementById('prod').value;
		sendPetitionQuery("AgregarArti.php?" + encodeURI(parametros))
		console.log("AgregarArti.php?" + encodeURI(parametros));
		if (returnedValue == "OK" ){
				alert("Articulo agregado correctamente");
		}
	}
	function loadTable(){
		//filtro = document.getElementById('buscar').value;
		sendPetitionSync("TablaARti.php","tablaArti",document);
		rePaint();
	}*/
		
</script>-->

