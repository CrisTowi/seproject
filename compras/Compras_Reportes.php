<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>M&oacute;dulo Compras</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
		<script src="js/jquery.ui.datepicker-es.js"></script>
		
	</head>    
    <body>
    	<?php include("header.php"); ?>
        <center>
        <div id="mainDiv">
		<!-- Aquí se coloca el menú -->
            <nav>
				<div class="button" onclick="redirect('gestionProveedores.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gesti&oacute;n de Proveedores</div>
                <div class="button" onclick="redirect('IngresarMP.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Gesti&oacute;n de Materia Prima</div>
                <div class="selected-button" onclick="redirect('Compras_Reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes</div>
            </nav>
			<!-- Divisor del contenido de la pagina -->
            <div id="all-content">
				<form  name="reporte" action="procesarReporte.php" method="POST">
					<h2>Creaci&oacute;n de reporte</h2>
					<div id="content">
						<div class="box">
						   Fecha inicial: <input type="text" id="from" name="from"  placeholder="Fecha de Inicio" />*
							<span id="inicial"></span>
						</div>
						<div class="box">
						   Fecha final: <input type="text" id="to" name="to" placeholder="Fecha de fin"/> *
							<span id="final"></span>
						</div>
						<div class="box">
							<h4>&Aacute;reas que abarcar&aacute; el reporte</h4>
							<div class="option"><input type="radio" name="tipo" value="proveedor" checked > Mejores Proveedores</div>
							<div class="option"><input type="radio" name="tipo" value="MP"> Materia Prima mas Usada</div>
						</div>            
						<div class="box">
							<input type="button" class="form-button" onClick="vacios();" value="Crear Reporte"/>
								
						</div>
					</div>
				</form>
			</div>
			
        </div>
        </center>
        <footer>Elaborado por nosotros(C) 2013</footer>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script type="text/javascript">
 function vacios(){
	inicial =document.getElementById('from').value;
	ffinal = document.getElementById('to').value;
	if(inicial.length==0 || ffinal.length==0){
				alert("Campos vacios");
				document.reporte.from.focus() 
				return 0;
		} else {
			document.reporte.submit();	

		}
	//select idMateriaPrima, count(*) as producto from compra_mp group by idmateriaprima
}


</script>
