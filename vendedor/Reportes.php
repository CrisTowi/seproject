<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="author" content="Ventas"/>
        <title>Reportes</title>
        <link rel="stylesheet" type="text/css" href="../css/ventas.css" />
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />	
    </head>    
    <body>
    	 
	<!-- El header es el mismo para todas las paginas-->
    	
       <?php include('header.php');?> <center>
        <div id="mainDiv">
		<!-- Aquí se coloca el menú -->
            <nav>
			      <div id="GV" class="button" onClick="window.location ='GestionV.php'"><img src="../img/archive.png"  alt="Icono" class="img-icon"/>Gestión de Ventas</div>     
				  <div id="GC" class="button" onClick="window.location ='GestionC.php'"><img src="../img/card.png"  alt="Icono" class="img-icon"/>Gestión de Clientes</div>
				  <div id="rep" class="selected-button" onClick="window.location ='Reportes.php'"><img src="../img/notepad.png"  alt="Icono" class="img-icon"/>Crear Reportes</div>
			</nav>
			<!-- Divisor del contenido de la pagina -->
			<div id="all-content">
				<br/>
				
            <div id="content1">		
              <div id="tir" class="titulo">CONSULTAR REPORTES</div>
                <div id="tip" class="texto1">Todos los campos son obligatorios.</div>
                <br/>
                <form id="formReporte" action="VerReportes.php" method="POST" >
                	<table>
                		<tr>
                		<td><div class="texto">PERIODO</div></td>
                		<td><input type="text" id="from" name="from" placeholder="Fecha de inicio" onblur="valida(this.value,'mfrom','from');"/></td>	
                		<td><span id="mfrom"></span></td>
                		<td class="texto"> a </td>
                		<td><input type="text" id="to" name="to" placeholder="Fecha de fin" onblur="valida(this.value,'mto','to');"/> </td>
                		<td><span id="mto"></span></td>
                		</tr>
                		<tr>
                			<td id="cliente" class="texto">CLIENTE</td>
                			<td><?php include("SelectClieR.php"); ?></td>
                			<td></td>
                			<td id="producto" class="texto">PRODUCTO</td>
                			<td colspan="2"><?php include("SelectProdR.php"); ?></td>
                		</tr>
                		<tr>
                			<td colspan="2" ></td>
                			<td  id="edo" class="texto">ESTADO</td>
                			<td><select name="estados"><option value='0'>Todo</option><option value="Entregado">Entregado</option><option value="Cancelada">Cancelada</option><option value="En Espera">En Espera</option></select></td>
                		</tr>
                		<tr>
                			<td ></td>
                			<td ><input class="form-button" id="acept" type="submit" value="Aceptar" ></td>
                			<td colspan="3"><div id="buttonCancel" class="form-button" onClick="window.location ='Index.php'">Cancelar</div></td>
                		</tr>
     
                	</table>
                               
   
                  </form>
                </div>
                </center>
            </div>
    </body>   
</html>
  <?php include('scripts.php'); ?> 

<script type="text/javascript">
function valida( str, target, validate ){
		if ( validate == "from" ){
			str = str.trim();
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' title='La fecha de inicio es obligatoria.'/>";	
			}
			else{
					document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				}
			}
		
		else if ( validate == "to"){			
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' title='La fecha de fin es obligatoria.'/>";	
			}
			
			 else {
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";			
			}}
		}
		
	
</script>
