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
                <form id="formReporte" action="VerReportes.php" method="POST" name="Rvalida">
                	<table>
                		<tr>
                		<td width="50px"></td>
                		<td><div class="texto">PERIODO</div></td>
                		<td><input type="text" id="from" name="from" placeholder="Fecha de inicio"/></td>
                		<td class="texto"> a </td>
                		<td><input type="text" id="to" name="to" placeholder="Fecha de fin"/> </td>
                		</tr>
                		
                		<tr>
                		<td height="50px"></td>
                		</tr>
                		
                		<tr>
                			<td id="cliente" class="texto">CLIENTE</td>
                			<td><?php include("SelectClieR.php"); ?></td>
                			<td></td>
                			<td id="producto" class="texto">PRODUCTO</td>
                			<td colspan="2"><?php include("SelectProdR.php"); ?></td>
                		</tr>
                		
                		<tr>
                		<td height="50px"></td>
                		</tr>
                		
                		<tr>
                			<td colspan="2" ></td>
                			<td  id="edo" class="texto">ESTADO</td>
                			<td><select name="estados"><option value='0'>Todo</option><option value="Entregado">Entregado</option><option value="Cancelada">Cancelada</option><option value="En Espera">En Espera</option></select></td>
                		</tr>
                		
                		<tr>
                		<td height="50px"></td>
                		</tr>
                		
                		<tr>
                			<td colspan="2"></td>
                			<td ><input class="form-button" id="acept" type="button" value="Aceptar" onClick="valida();"></td>
                			<td><div id="buttonCancel" class="form-button" onClick="window.location ='Index.php'">Cancelar</div></td>
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
  function valida()
{
	
	//Validar Fechas
	if(document.Rvalida.from.value.length==0)
	{
		alert("El inicio de perido es un campo obligatorio")
		document.Rvalida.from.focus()
		return 0;
	}
	
	else if(document.Rvalida.to.value.length==0)
	{
		alert("El fin de periodo es un campo obligatorio")
		document.Rvalida.to.focus()
		return 0;
	}
	else if(document.Rvalida.from.value.length!=0 && document.Rvalida.to.value.length!=0){
	document.Rvalida.submit()}
	
 }
  
</script>


