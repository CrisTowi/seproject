<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Seguimiento</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">        
    </head>    
    <body>
    	<?php include("../php/header.php"); ?>
        <center>
        <div id="mainDiv">
            <nav>
                <div class="button" onclick="redirect('visualizaProblemas.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Visualizar problemas</div>
                <div class="selected-button" onclick="redirect('seguimiento.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Seguimiento de producto</div>
                <div class="button" onclick="redirect('crearReporte.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reporte general</div>
            </nav>
            <div id="all-content">				
                <h2>Seguimiento del producto</h2>
                <div id="content">
                    <div class="box">
                        <h4>Número de lote</h4>
                        <div class="option"><input type="radio" id="filtro1" name="filtroLote" checked="checked" />Por número de lote de Materia prima</div>
                        <div class="option"><input type="radio" id="filtro2" name="filtroLote" />Por número de lote de Producto</div>
                    </div>
                    <div class="box">
                       Número de lote: <input type="text" placeholder="Ingrese aquí el lote" id="numLote" />
                    </div>        
                    <div class="box">
                        <div class="form-button" onclick="track();">Rastrear producto</div>
                    </div>
                </div>
            </div>
			
        </div>
        </center>
        <?php include("../php/footer.php"); ?>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script>
	function track(){
		var numLote = document.getElementById('numLote').value;
		if ( numLote.length == 0 ){
			alert("Introduce un número de lote");
			return;
		}
		if ( document.getElementById("filtro1").checked ){
			redirect('tracking.php?tipo=0&numero=' + numLote);
		}else{
			redirect('tracking.php?tipo=1&numero=' + numLote);
		}
	}
</script>	