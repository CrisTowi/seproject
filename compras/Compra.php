<?php include("../php/AccessControl.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Modulo de Administración</title>
        <link rel="stylesheet" type="text/css" href="../css/mainStyle.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
		<script type="text/javascript" href="jquery-1.9.1.js"></script>

    </head>    
    <body>
    	 <?php include("header.php"); ?>

        <center>
        <div id="mainDiv">
            <nav>
                <div class="button" onclick="redirect('gestionProveedores.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gesti&oacute;n de Proveedores</div>
                <div class="selected-button" onclick="redirect('IngresarMP.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Gesti&oacute;n de Materia Prima</div>
                <div class="button" onclick="redirect('Compras_Reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes</div>
            </nav>
            <div id="all-content">				
                <h2>Realizar Compra</h2>
				Todos los campos son obligatorios.
                <form id="altaCompra" action="AgregaCom.php" name="altaCompra" method ="POST">
				<div id="content">
					<div class="box">
						Proveedor: <?php include("SelectProveedores.php"); ?>
						<table id="productos">
						<tr>
								<td>
									Producto:<br>
									<select id='sproductos1'>
										<div >
											<?php include("SelectProductos.php"); ?>
										</div>
									</select>

								</td>
								<td>
									Cantidad:<br> <input type="number" onblur="valida(this.value,'cantidad','numero');" class="cantidad" value="0" min="0" max="10000" >
									<span id="cantidad"></span>
								
								</td>
									
								<td>
									Precio Unitario:$<br> <input type="number" class="cantidad" onblur="valida(this.value,'unitario','numero');" onChange="calcular_total();"  value="0" min="0" max="1000000"> 
									<span id="unitario"></span>
								</td>
							   <td>
									<img src="../img/add.png" onClick="agregarProducto()" class='clickable'/>
							   </td>
						</tr>
						</table>
							Total: 
							<input readonly type="text" id="total" name="total"> 
						</div>		
					
						<div class="box">
							
							<div id="buttonOK" class="form-button" onclick="agregarCompra();">Finalizar Compra</div>
							<div class="form-button" onclick="redirect('IngresarMP.php')">Cancelar</div>	
						</div>
						
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

function agregarCompra(){
		if( document.getElementById("total").value!= 0 && document.altaCompra.proveedor[document.altaCompra.proveedor.selectedIndex].value!=-1 && document.altaCompra.sproductos1[document.altaCompra.sproductos1.selectedIndex].value!=-1 ){
		var filas = document.getElementById("productos").rows.length;
		//alert(filas);
		parametros = "numprod="+ filas + "&"  ;
		parametros += "proveedor=" + document.getElementById('proveedor').value+"&";
		
		for (var i =1 ;i<=filas ;i++ ){
			parametros+= "producto"+ i+"=" + document.getElementById('sproductos'+i).value + "&";
		}
		
		parametros += "total=" + document.getElementById('total').value;
		
		parametros = parametros.replace("#","%23");
		sendPetitionQuery("AgregaCom.php?" + encodeURI(parametros));
		console.log("AgregaCom.php?" + encodeURI(parametros));
		/* returnedValue almacena el valor que devolvio el archivo PHP */
		if (returnedValue == "OK" ){
				alert("La Compra ha sido agregada exitosamente");
			
			window.location = "./IngresarMP.php";
		}
		else if ( returnedValue == "DATABASE_PROBLEM"){
			alert("Error en la base de datos");
		}
		 else {
			alert ("Error desconocido D:"+returnedValue);
		}
	}else alert ("Todos los campos son obligatorios");
		 
}

function valida( str, target, validate ){
		
		 if ( validate == "numero" ){
			str = str.trim();
			if ( str.length == 0 ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />";	
			}
			else{
				//document.write(/^\d+\.?\d*$/.test('15.22'));
				var re = /^\d+\.?\d*$/;
				ok = re.exec(str);
				if ( !ok ){
					document.getElementById(target).innerHTML = "<img src='../img/error.png' />";	
				}else{
					document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				}
			}
		}
	}

function Contar(){
	var numero = document.altaCompra.sproductos1;
	return numero.length;

}


function loadTable(){
		var  tabla=Contar()-1;
		filtro = document.getElementById('proveedor').value;
		
		while(tabla>=0){
				var aux = tabla+1;
				var aux2 = "sproductos"+aux;
				sendPetitionSync("SelectProductos.php?name=" + filtro ,aux2,document);
				tabla--;	
		}
	}

	function ValidaSoloNumeros() {
 if ((event.keyCode < 48) || (event.keyCode > 57))
  event.returnValue = false;
}
	
	function calcular_total() {
	importe_total = 0
	subtotal=0
	aux = 0
	$(".cantidad").each(
		function(index, valor) {
			if(index==0 || (index%2)==0){
			aux =valor.value;
			}else if((index%2)!=0){
				subtotal = aux * eval($(this).val());
				importe_total+=subtotal;
			}
		}
	);
	$("#total").val(importe_total);
}
	
var posicionCampo=2;


function agregarProducto(){
		var opciones= posicionCampo;
		var productos= Contar();
		if (productos-1>opciones-1){
			nuevaFila = document.getElementById('productos').insertRow(-1);
			nuevaFila.id=posicionCampo;
			nuevaCelda=nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<select id='sproductos"+posicionCampo+"'><?php include("SelectProductos.php"); ?></select>";
			nuevaCelda=nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<td><input type='text' id='producto"+posicionCampo+"' onblur=\"valida(this.value,'cantidad"+posicionCampo+"','numero\');\" class='cantidad' value='0'><span id='cantidad"+posicionCampo+"'></span></td>";
			nuevaCelda=nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<td><input type='text' id='precio"+posicionCampo+"' class='cantidad' onChange='calcular_total();' onBlur=\"valida(this.value,'unitario"+posicionCampo+"','numero');\" value='0'><span id='unitario"+posicionCampo+"'></span></td>";
			nuevaCelda=nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<td><img src= '../img/less.png'  class='clickable' onclick='eliminarUsuario(this);calcular_total();'></td>";
			posicionCampo++;
			loadTable();
		}
}

/* Definimos la función eliminarUsuario, la cual se encargará de quitar la fila completa del formulario. No es necesario hacer modificaciones sobre este código */

function eliminarUsuario(obj){

var oTr = obj;

while(oTr.nodeName.toLowerCase()!='tr'){

oTr=oTr.parentNode;

}

var root = oTr.parentNode;

root.removeChild(oTr);

}

/* Cerramos el código Javascript */
	
	
	
</script>
