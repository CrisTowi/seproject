<!-- scripts -->
<script type="text/javascript" src="../js/color.js"></script>
<script type="text/javascript" src="../js/produccion.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/validaciones.js"></script>
<script type="text/javascript">
	window.onload = initialize;
	window.onresize = function () { resizeWindow(document) };
	function initialize() {		        
		resizeWindow(document);
	}
</script> 
<script type="text/javascript" src="../js/jquery-1.5.1.js"></script>
<script type="text/javascript" src="../js/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../js/navigation.js"></script>        
<script type="text/javascript">
	$(function () {
		var dates = $("#from, #to").datepicker
		(
			{
				defaultDate: "+1w",
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,

				onSelect: function (selectedDate) {
					var option = this.id == "from" ? "minDate" : "maxDate",
						instance = $(this).data("datepicker"),
						date = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings);
					dates.not(this).datepicker("option", option, date);
				}
			}
		);
	});
</script> 
<script type="text/javascript">
function validarReporte()
{

	if(document.SolicitarRepo.tipo_reporte.selectedIndex==0)
	{
		alert("El tipo de reporte es un campo obligatorio")
		document.SolicitarRepo.tipo_reporte.focus()
		return 0;
	}
	else
	{
		if(document.SolicitarRepo.tipo_reporte.selectedIndex==1)
		{
			window.location='ReporteVentas.php'
		}
	}
	
	
}

function isNew()
{
	if(document.cambioBox.ingrediente.selectedIndex==document.cambioBox.ingrediente.length-1)
	{
		window.location='AltasIngrediente.php'
	}
	else
	{
		encontrado=document.getElementById(document.cambioBox.ingrediente.selectedIndex); 
	
		if(encontrado==undefined && document.cambioBox.ingrediente.selectedIndex!=0)
		{
			field = document.getElementById('cuerpoT'); 
			tabla= document.getElementById('table-aux'); 
			actual=tabla.rows.length;
			
			celda1= document.createElement('td'); 
			texto=document.createElement('input');
			texto.id='ide'+actual;
			texto.name='ide'+actual;
			texto.type = 'text';
			texto.value=document.cambioBox.ingrediente.selectedIndex;
			celda1.appendChild(texto);
			
			input=document.createElement('input');
			input.id='cantidad'+actual;
			input.name='cantidad'+actual;
			input.type = 'text';
			input.placeholder='Cantidad de Ingrediente';
			celda2= document.createElement('td'); 
			celda2.appendChild(input);		
			
			celda3= document.createElement('td'); 
			divIMG= document.createElement('div'); 
			
			imagen=document.createElement('img'); 
			imagen.src="../img/less.png";
			imagen.alt="Eliminar";
			imagen.name="eliminar"+document.cambioBox.ingrediente.selectedIndex;
			divIMG.appendChild(imagen);
			divIMG.className ='evento';	
			divIMG.id ='divIMG'+document.cambioBox.ingrediente.selectedIndex;	
			divIMG.setAttribute( "onclick","quitarIngrediente("+document.cambioBox.ingrediente.selectedIndex+");");
			celda3.className='opc';
			celda3.appendChild(divIMG);	
			
			renglon = document.createElement('tr'); 
			renglon.className ='tr-cont'; 
			renglon.id=document.cambioBox.ingrediente.selectedIndex;
			renglon.name=document.cambioBox.ingrediente.selectedIndex;
		
			renglon.appendChild(celda1);
			renglon.appendChild(celda2);
			renglon.appendChild(celda3);
			
			field.appendChild(renglon);	
		}
	}
	
}

function quitarIngrediente(obj) {
  field = document.getElementById('cuerpoT'); 
  field.removeChild(document.getElementById(obj)); 
}
function validarReceta()
{		
		var RegExPattern = /^(?:\+|-)?\d+$/;
		count=document.getElementById('table-aux').rows.length-1;
		for(i=1;i<=count;i++)
		{
			cantidadT=document.getElementById('cantidad'+i);
			
				if(cantidadT.value=='')
				{
					alert('La cantidad necesaria es un campo obligatorio');
					cantidadT.focus();
					return;
				}
				if(!cantidadT.value.match(RegExPattern))
				{
					alert('La cantidad necesaria s\u00f3lo acepta tipo entero');
					cantidadT.focus();
					return;					
				}
			
			
			
		}
		
		document.altasReceta.submit();
		
			
}


function validaProducto()
{		
		var RegExPattern = /^[0-9]*(\.)?[0-9]*$/;
		if(document.altasProducto.nombreP.value=='')
		{
			alert('El nombre del producto es un campo obligatorio');
			document.altasProducto.nombreP.focus();
			return;
		}
		if(document.altasProducto.precioP.value=='')
		{
			alert('El precio del producto es un campo obligatorio');
			document.altasProducto.precioP.focus();
			return;
		}
		if(!document.altasProducto.precioP.value.match(RegExPattern))
		{
			alert('El precio del producto s\u00f3lo acepta tipo flotante o entero');
			document.altasProducto.precioP.focus();
			return;
		}
		
		document.altasProducto.submit();
}

function validaModificar()
{		
		var RegExPattern = /^[0-9]*(\.)?[0-9]*$/;
		if(document.altasProducto.nombreP.value=='')
		{
			alert('El nombre del producto es un campo obligatorio');
			document.altasProducto.nombreP.focus();
			return;
		}
		if(document.altasProducto.precioP.value=='')
		{
			alert('El precio del producto es un campo obligatorio');
			document.altasProducto.precioP.focus();
			return;
		}
		if(!document.altasProducto.precioP.value.match(RegExPattern))
		{
			alert('El precio del producto s\u00f3lo acepta tipo flotante o entero');
			document.altasProducto.precioP.focus();
			return;
		}
		
		document.altasProducto.submit();
}

function eli(renglon){
	resp=confirm("\u00bfDesea eliminar el producto?")
	if(resp==true)
	{
		
		form=document.createElement('form');
		form.id='eliminar';
		form.name='eliminar';
		form.method='post';
		form.action='EliminarProducto.php';
		
		texto=document.createElement('input');
		texto.id='ide';
		texto.name='ide';
		texto.type = 'text';
		texto.value=renglon;
		form.appendChild(texto);
		form.submit();
		
	}
}

function modificarProducto(renglon){
	
	
		
	form=document.createElement('form');
	form.id='modificar';
	form.name='modificar';
	form.method='post';
	form.action='ModificarProducto.php';
	
	texto=document.createElement('input');
	texto.id='ide';
	texto.name='ide';
	texto.type = 'text';
	texto.value=renglon;
	form.appendChild(texto);
	form.submit();
		
	
}
</script> 


<!-- end of scripts -->