<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Creación de reporte general</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">        
    </head>    
    <body>
    	<?php include("../php/header.php"); ?>
        <center>
        <div id="mainDiv">
            <nav>
                <div class="button" onclick="redirect('visualizaProblemas.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Visualizar problemas</div>
                <div class="button" onclick="redirect('seguimiento.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Seguimiento de producto</div>
                <div class="selected-button" onclick="redirect('crearReporte.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reporte general</div>
            </nav>
            <div id="all-content">				
                <h2>Creación de reporte general</h2>
                <div id="content">
					<form action="procesarReporte.php" method="POST" name="formulario">
                    <div class="box">
                       Fecha inicial: <input type="text" id="from" name="from" placeholder="Fecha de inicio"/>
                    </div>
                    <div class="box">
                       Fecha final: <input type="text" id="to" name="to" placeholder="Fecha de fin"/> 
                    </div>
                    <div class="box">
                        <h4>Áreas que abarcará el reporte</h4>
                        <div class="option"><input type="checkbox" id="all" /> Todas</div>
						<div class="option"><input type="checkbox" id="admin" /> Administración</div>
                        <div class="option"><input type="checkbox" id="produccion" /> Producción</div>
                        <div class="option"><input type="checkbox" id="inventarios" /> Inventario</div>
                        <div class="option"><input type="checkbox" id="compras" /> Compras</div>
                        <div class="option"><input type="checkbox" id="ventas" /> Ventas</div>                        
                    </div>            
                    <div class="box">
                       Ordenar por: <select name="order"><option value="1">Área</option><option value="2">Fecha</option></select>
                    </div>        
					<input type="hidden" id="mask" name="mask" />
                    <div class="box">
                        <div class="form-button" onclick="createReport();">Crear reporte</div>
                    </div>
					</form>
                </div>
            </div>
			
        </div>
        </center>
        <?php include("../php/footer.php"); ?>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script type="text/javascript">
	function createReport(){
		var mask = 0;
		if ( document.getElementById("from").value.length == 0){
			alert("No se ha seleccionado la fecha de inicio");
			return;
		}
		if ( document.getElementById("to").value.length == 0){
			alert("No se ha seleccionado la fecha de fin");
			return;
		}
		if(document.getElementById("all").checked == true ){
			mask |= 31;
		}
		if(document.getElementById("admin").checked == true ){
			mask |= 16;
		}
		if(document.getElementById("produccion").checked == true ){
			mask |= 8;
		}
		if(document.getElementById("inventarios").checked == true ){
			mask |= 4;
		}
		if(document.getElementById("compras").checked == true ){
			mask |= 2;
		}
		if(document.getElementById("ventas").checked == true ){
			mask |= 1;
		}
		document.getElementById("mask").value = mask;
		if ( mask == 0 )
		{
			alert("No se ha seleccionado un área");
			return;
		}
		document.formulario.submit();
	}
</script>

