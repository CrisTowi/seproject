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
                    <div class="box">
                       Etapa del proceso: 
					<?php   
						include ("../php/DataConnection.class.php");
						$db = new DataConnection();
						$result = $db->executeQuery("SELECT * FROM Area");
						echo "<select id='area' name='area'>";
						echo "<option value='0'>Todos los departamentos</option>";
						while( $dato = mysql_fetch_assoc($result) ){
							echo "<option value='".$dato["id"]."'>".$dato["nombre"]."</option>";
						}
						echo "</select>";
					?> 
                    </div>
                    <div class="box">
                        <h4>Periodo de tiempo</h4>
                        <div class="option"><input type="radio" name="filtroTiempo" checked="checked" onclick="toggleState('fechas',false);" /> Todos los reportes</div>
                        <div class="option"><input type="radio" name="filtroTiempo" onclick="toggleState('fechas',true);" /> Por periodo de tiempo</div>
                        <div class="box" id="fechas">
                            Fecha inicial: <input type="text" id="from" name="from" placeholder="Fecha de inicio"/>
                            Fecha final: <input type="text" id="to" name="to" placeholder="Fecha de fin"/> 
                        </div>
                    </div>            
                    <div class="box">
                        <h4>Estado</h4>
                        <div class="option" id="estatus">
						<select id="filtroEstatus">
							<option value="-1">Todos</option>
							<option value="0">Pendiente</option>
							<option value="1">Solucionado</option>
						</select>
						</div>
                    </div>
                    <div class="box">
                        <div class="form-button" onclick="visualizarProblemas();">Visualizar problemas</div>
                    </div>
                </div>
            </div>			
        </div>
        </center>
        <?php include("../php/footer.php"); ?>
    </body>   
</html>
<?php include("scripts.php"); ?>
<script type="text/javascript">
	var filterByDate = false;
    function toggleState(element, bvar) {
        var e = new String(element);
        if (!bvar) {
            document.getElementById(e).style.display = "none";
			filterByDate = false;
        } else {
            document.getElementById(e).style.display = "block";
			filterByDate = true;
        }
    }
	
	function valida(){
		if ( filterByDate ){
			if ( document.getElementById("from").value.length != 10 ) return false;
			if ( document.getElementById("to").value.length != 10 ) return false;
		}
		return true;
	}
	
	function visualizarProblemas(){
		if ( !valida() ){
			alert("Datos incorrectos");
			return;
		}
		var extra = "?";
		var indice = document.getElementById("area").selectedIndex;		
		if ( indice != 0 ){
			extra = "area=" + indice;
		}
		indice = document.getElementById("filtroEstatus").selectedIndex;		
		if ( indice != 0 ){
			if  ( extra.length > 1 ) extra += "&";
			extra += "estatus=" + (indice-1);
		}		
		if ( filterByDate ){
			if  ( extra.length > 1 ) extra += "&";
			extra += "from=" + document.getElementById("from").value;
			extra += "&to=" + document.getElementById("to").value;
		}
		redirect('despliegaProblemas.php' + extra);
	}	
</script>    