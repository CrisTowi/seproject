<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
                	<div id="foli" class="texto">FOLIO:</div>
                    <?php include("GenrFolio.php"); ?>
                	<div id="periodo" class="texto">FECHA:</div>
                	<div id="fech" class="texto">
					<script type="text/javascript">
					var date = new Date();
					var d  = date.getDate();
					var day = (d < 10) ? '0' + d : d;
					var m = date.getMonth() + 1;
					var month = (m < 10) ? '0' + m : m;
					var yy = date.getYear();
					var year = (yy < 1000) ? yy + 1900 : yy;
					document.write(day + "/" + month+ "/" + year);
					</script></div>
                    <div id="cliente" class="texto">CLIENTE:</div>
                    <div id="cliente1"class="box">
                       <?php include("SelectClie.php"); ?>
                    </div> 
                    <div id="Boton1"><input type="button" name="abrir" value="Abrir Venta" onClick="agregarVenta()"></div>
                    <div id="articulos" class="texto">ARTICULOS</div>
                    <div id="linea"></div>
                    <div id="producto" class="texto">PRODUCTO:</div>
                    <div id="producto1"class="box">
                          <?php include("SelectProd.php"); ?>
                    </div> 
                    <div id="canti" class="texto">LOTES:</div>
                    <select id='cant'></select>
                    <div id="ex" class="texto">PRECIO DEL LOTE:</div>
                    <div id="exi" >
                    	<input type="text" id="precio" size="5" maxlength="7" value="Precio" disabled/>
                    </div>
                    
                    <div id="boton3"><input type="button" value="Agregar Articulo" onClick="AddArt()"></div>
                    <div id="TablaArti">
                    	<?php include("TablaARti.php"); ?>
                    </div>     
                    
                    <div id="boton"><input type="button" name="cerrar" value="Cerrar Venta" onClick=""></div>
                    <div id="boton2"><input type="button" value="Cancelar" onClick="cancelar()"></div>  
                  </form>
                </div>
            </div>   
            <center> 
    </body>   
</html>

<?php include('scripts.php'); ?> 	
<!--<script type="text/javascript" src="jquery-1.4.2.min.js"></script>-->
<script type="text/javascript">
	 $(document).ready(function(){
        $("#prod").change(function(event){
            var id = $("#prod").find(':selected').val();
            $("#cant").load('selectLote.php?id='+id);
            $("#exi").load('Getprec.php?id='+id);
        });
    });
    sendPetitionSync("TablaArti.php?Folio="+document.getElementById('clie').value,"tablaArti",document);
</script>


<script type="text/javascript">
	/* Agrega el empleado a la base de datos */
	function agregarVenta(){
		parametros= "Cliente=" + document.getElementById('clie').value;
		parametros = parametros.replace("#","%23");
		
		sendPetitionQuery("AgregaVenta.php?" + encodeURI(parametros));
		
		console.log("AgregaVenta.php?" + encodeURI(parametros));
		/* returnedValue almacena el valor que devolvio el archivo PHP */
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
	
	/*function showCURPHelp(){
		alert("Fomato del CURP:\nPosición 1-4: La letra inicial y la primera vocal interna del primer apellido, la letra inicial del segundo apellido y la primera letra del nombre.\nPosición 5-10: La fecha de nacimiento en el orden año, mes y día. Para el año se tomarán los últimos dos digitos, cuando el día sea menor a diez, se antepondrá un cero.\nPosición 11: Sexo M para mujer o H para hombre.\nPosición 12-13: La letra inicial y ultima consonante del nombre de estado de nacimiento.\nPosición 14-16: Integradas por las primeras consonantes internas del primer apellido, segundo apellido y nombre.\nPosición 17: Diferenciador de homonimia. 1-9 para fechas de nacimiento hasta 1999, A-Z para fechas de nacimiento a partir de 2000.\nPosición 18: Digito verificador asignado por la Secretaría de Gobernación.");
	}*/
	function AddArt(){
		parametros="Folio=" + document.getElementById('fol').value;
		parametros+= "&Lote=" + document.getElementById('cant').value;
		parametros+= "&Producto=" + document.getElementById('prod').value;
		sendPetitionQuery("AgregarArti.php?" + encodeURI(parametros))
		console.log("AgregarArti.php?" + encodeURI(parametros));
		if (returnedValue == "OK" ){
				alert("Articulo agregado correctamente");
			//window.location = "./GestionV.php";
		}
	}
	
	function loadTable(){
		//filtro = document.getElementById('buscar').value;
		sendPetitionSync("TablaARti.php","tablaArti",document);
		rePaint();
	}	
</script>

