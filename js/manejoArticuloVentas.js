function valida( str, target, validate ){
		if ( validate == "cantidad") {
		str = str.trim();
		if ( str.length == 0 ){
			document.getElementById(target).innerHTML = "<img src='../img/error.png' />La cantidad es un campo obligatorio.";	
		}
		else{
			var re =/#^[^0-9]$#/;
			ok = re.exec(str);
			if ( !ok ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' />La cantidad s�lo acepta tipo num�rico.";	
			}else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
		}
		
	}
}
function AddArt()
{
	selector=document.getElementById("prod");
	
	if(selector.value=='nuevo')
	{
		window.location='GestionV.php'
	}
	else
	{
		
		nuevoIngreso=document.getElementById(selector.value);
		if(nuevoIngreso==undefined)
		{
			field = document.getElementById('cuerpoT'); 
			tabla= document.getElementById('table-aux'); 
			actual=tabla.rows.length;
			
			celda1= document.createElement('td'); 
			texto=document.createElement('span');
			texto.id='ide'+actual;
			texto.name='ide'+actual;
			texto.innerHTML=selector.options[selector.selectedIndex].text;
			celda1.appendChild(texto);
			
			celda4= document.createElement('td'); 
			unidad=document.createElement('span');
			unidad.id='precio'+actual;
			unidad.name='precio'+actual;
			unidad.innerHTML=document.getElementById('precio').value;
			celda4.appendChild(precio);
			
			celda5= document.createElement('td'); 
			mensaje=document.createElement('span');
			mensaje.id='MSG'+actual;
			mensaje.name='MSG'+actual;
			celda5.appendChild(mensaje);
			celda5.className="opc";
			
			/*input=document.createElement('input');
			input.id='cantidad'+actual;
			input.name='cantidad'+actual;
			input.className='cantidades';
			input.type = 'text';
			input.setAttribute("onblur","valida(this.value,'MSG"+actual+"','cantidad');");
			input.placeholder='Cantidad de Ingrediente';
			celda2= document.createElement('td'); 
			celda2.appendChild(input);	
			
			celda3= document.createElement('td'); 
			divIMG= document.createElement('div'); 
			
			imagen=document.createElement('img'); 
			imagen.src="../img/less.png";
			imagen.alt="Eliminar";
			imagen.name="eliminar"+selector.value;
			divIMG.appendChild(imagen);
			divIMG.className ='evento';	
			divIMG.id ='divIMG'+selector.value;	
			divIMG.setAttribute( "onclick","quitarIngrediente("+selector.value+");");
			celda3.className='opc';
			celda3.appendChild(divIMG);	
			
			renglon = document.createElement('tr'); 
			renglon.className ='tr-cont'; 
			renglon.id=selector.value;
			renglon.name=selector.value;*/
		
			renglon.appendChild(celda1);
			renglon.appendChild(celda4);
			//renglon.appendChild(celda2);
			//renglon.appendChild(celda3);
			renglon.appendChild(celda5);
			//field.appendChild(renglon);

			//se alamacenan los idMP
			/*idMP=document.createElement('input');
			idMP.id='idMP'+actual;
			idMP.name='idMP'+actual;
			idMP.type = 'hidden';
			idMP.className='ides';
			idMP.value=selector.value;
			field.appendChild(idMP);*/
		}
		else
		{
			alert("El ingrediente ya est� en la lista");
		}
	}	
}

function quitarIngrediente(obj)
{
  field = document.getElementById('cuerpoT'); 
  field.removeChild(document.getElementById(obj)); 
}