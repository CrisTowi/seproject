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
                <div class="button" onclick="redirect('gestionProveedores.php');"><img src="../img/archive.png"  alt="Icono" class="img-icon" />Gesti&oacute;n Proveedores</div>
                <div class="button" onclick="redirect('IngresarMP.php');"><img src="../img/configuration2.png" alt="Icono" class="img-icon" />Gesti&oacute;n Materia Prima</div>
                <div class="button" onclick="redirect('Compras_Reportes.php');"><img src="../img/notepad.png"  alt="Icono" class="img-icon" />Reportes</div>
            </nav>
            <div id="all-content">				
                <h2>Realizar Compra</h2>
				Todos los campos son obligatorios.
                <form id="altaCompra" action="AgregaCom.php" name="altaCompra" method ="POST">
				<div id="content">
					<div class="box">
						<table>
							<tr>
								<td>Proveedor: <?php include("SelectProveedores.php"); ?></td>
							</tr>
							<tr>
								<td>Producto:
									<select id='selectProductos'>
										<?php include("SelectProductos.php"); ?>
									</select>
									<img src="../img/add.png" onClick="agregarProducto(document.altaCompra.selectProductos.value)" class='clickable'/>
								</td>
							</tr>
						</table>
						
						<table id="productos">
							<tr id="msgTable" class="tr-cont">
								<td colspan="2">Aun no se han agregado productos</td>
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
		if( document.getElementById("total").value!= 0 && document.altaCompra.proveedor[document.altaCompra.proveedor.selectedIndex].value!=-1 && document.altaCompra.selectProductos[document.altaCompra.selectProductos.selectedIndex].value!=-1 ){
		var filas = document.getElementById("productos").rows.length - 1;	//Menos 1 por el encabezado
		//alert(filas);
		parametros = "numprod="+ filas + "&"  ;
		parametros += "proveedor=" + document.getElementById('proveedor').value+"&";
		
		producto = document.getElementsByClassName("idProducto");	//Recuperamos los input con las cantidades
		cantidades = document.getElementsByClassName("cantidad");		//Recuperamos los input con los precios
		
		for (var i =1 ;i<=filas ;i++ ){
			parametros+= "producto"+ i+"=" + producto[i-1].value + "&";
		}
		for (var j =1 ;j<=filas ;j++ ){
			parametros+= "cantidad"+ j+"=" + cantidades[j-1].value + "&";
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

function loadTable()
{
	//Se llena el select de productos
	filtro = document.getElementById('proveedor').value;
	sendPetitionSync("SelectProductos.php?name=" + filtro , "selectProductos",document);
	
	//Se borra la tabla
	table = document.getElementById('productos');
	while(table.rows.length > 0)
		table.deleteRow(0);
	
	//Se pone el msg
	nuevaFila = document.getElementById('productos').insertRow(-1);
	nuevaFila.className = "tr-cont";
	nuevaFila.id = "msgTable";
	nuevaCelda = nuevaFila.insertCell(-1);
	nuevaCelda.innerHTML = "Aun no se han agregado productos";
	
	//Total = 0
	$("#total").val(0);
}

	function ValidaSoloNumeros() {
 if ((event.keyCode < 48) || (event.keyCode > 57))
  event.returnValue = false;
}
	
	function calcular_total() 
	{
		importe_total = 0
		cantidades = document.getElementsByClassName("cantidad");	//Recuperamos los input con las cantidades
		precios = document.getElementsByClassName("precio");		//Recuperamos los input con los precios
		for(i = 0; i < cantidades.length; i++)
			importe_total = importe_total + (cantidades[i].value * precios[i].value); 
	
		$("#total").val(importe_total);
	}
	
	var idProducto = 1;

	function agregarProducto(id)
	{		
		filas = document.getElementById('productos').rows.length - 1;	//menos 1 por la fila del mensaje inicial
			
		//Si no hay nada creamos los header
		if(filas == 0)
		{
			//Quitamos el msj inicial
			table = document.getElementById('productos');
			table.deleteRow(0);
			
			//Agregamos los header
			nuevaFila = document.getElementById('productos').insertRow(-1);
			nuevaFila.id = "header";
			nuevaFila.className = "tr-header";
			nuevaFila.style.backgroundColor = "#FFA154";
			nuevaCelda = nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML = "Producto";
			nuevaCelda = nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML = "Cantidad";
			nuevaCelda = nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML = "Precio";
		}
			
		if (!estaAgregado(id))	//Si no se ha agregado el producto
		{
			indice = document.altaCompra.selectProductos.selectedIndex;
			idMateriaPrima = document.altaCompra.selectProductos.value;	//Es el valor del option
			texto = document.altaCompra.selectProductos.options[indice].text;	//Es lo que ve el usuario
				
			nuevaFila = document.getElementById('productos').insertRow(-1);
			nuevaCelda = nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML = "<input type='hidden' name='idProducto"+idProducto+"' class='idProducto' value='"+idMateriaPrima+"' />" + texto;
			nuevaCelda = nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<input type='text' id='cantidad"+idProducto+"' class='cantidad' onChange='calcular_total();' onblur=\"valida(this.value,'cantidades"+idProducto+"','numero');\" value='0'><span id='cantidades"+idProducto+"'></span>";
			nuevaCelda=nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<input type='text' id='precio"+idProducto+"' class='precio' onChange='calcular_total();' onBlur=\"valida(this.value,'unitario"+idProducto+"','numero');\" value='0'><span id='unitario"+idProducto+"'></span>";		
			nuevaCelda=nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML="<img src= '../img/less.png' class='clickable' onclick='eliminarProducto(this);'>";
			idProducto++;
		}
		else
			alert("El producto ya se ha agregado");
	}

	//Funcion para saber si ya se agrego a la tabla el producto
	function estaAgregado(id)
	{
		arrayId = document.getElementsByClassName("idProducto");
		for(i = 0; i < arrayId.length; i++)
		{
			if(arrayId[i].value == id)
				return true;
		}
		return false;
	}
	
	function eliminarProducto(obj)
	{
		var oTr = obj;
		while(oTr.nodeName.toLowerCase()!='tr'){
			oTr=oTr.parentNode;
		}
		var root = oTr.parentNode;
		root.removeChild(oTr);
		
		filas = document.getElementById('productos').rows.length - 1;
		
		//Si se borraron todos los produtos hay que poner de nuevo el msg inicial
		if(filas == 0)
		{
			table = document.getElementById('productos');
			table.deleteRow(0);
			
			nuevaFila = document.getElementById('productos').insertRow(-1);
			nuevaFila.className = "tr-cont";
			nuevaFila.id = "msgTable";
			nuevaCelda = nuevaFila.insertCell(-1);
			nuevaCelda.innerHTML = "Aun no se han agregado productos";
		}
	}
	
	
</script>
