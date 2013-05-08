function valida( str, target, validate ){
		if ( validate == "cantidad") {
		str = str.trim();
		if ( str.length == 0 ){
			document.getElementById(target).innerHTML = "<img src='../img/error.png' title='La cantidad es un campo obligatorio.' />";	
		}
		else{
			var re =/#^[^0-9]$#/;
			ok = re.exec(str);
			if ( !ok ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' title='La cantidad sólo acepta tipo numérico.' />";	
			}else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
			}
		}
		
	}
}
function AddArt()
{
	selector=document.getElementById('cant');
	
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
			//celda 0
			celda0= document.createElement('td'); 
			producto=document.createElement('span');
			producto.id='prod'+actual;
			producto.name='prod'+actual;
			producto.innerHTML=document.getElementById('prod').options[document.getElementById('prod').selectedIndex].text;
			celda0.appendChild(producto);
			//celda 1
			celda1= document.createElement('td'); 
			texto=document.createElement('span');
			texto.id='ide'+actual;
			texto.name='ide'+actual;
			texto.innerHTML=selector.options[selector.selectedIndex].text;
			celda1.appendChild(texto);
			///ceLda 4
			celda4= document.createElement('td'); 
			precio=document.createElement('span');
			precio.id='precio'+actual;
			precio.name='precio'+actual;
			precio.innerHTML=document.getElementById('precio').value;
			celda4.appendChild(precio);
			//celda 5
			celda5= document.createElement('td'); 
			mensaje=document.createElement('span');
			mensaje.id='MSG'+actual;
			mensaje.name='MSG'+actual;
			celda5.appendChild(mensaje);
			//celda5.className="opc";
			//textbox
			input=document.createElement('input');
			input.id='cantidad'+actual;
			input.name='cantidad'+actual;
			input.className='cantidades';
			input.type = 'text';
			input.setAttribute("onblur","valida(this.value,'MSG"+actual+"','cantidad');");
			input.placeholder='Cantidad a comprar';
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
			renglon.name=selector.value;
		    
		    renglon.appendChild(celda0);
			renglon.appendChild(celda1);
			renglon.appendChild(celda4);
			renglon.appendChild(celda2);
			renglon.appendChild(celda3);
			renglon.appendChild(celda5);
			field.appendChild(renglon);

			//se alamacenan los idMP
			idMP=document.createElement('input');
			idMP.id='idMP'+actual;
			idMP.name='idMP'+actual;
			idMP.type = 'hidden';
			idMP.className='ides';
			idMP.value=selector.value;
			field.appendChild(idMP);
		}
		else
		{
			alert("El lote ya est� en la lista");
		}
	}	
}

function quitarIngrediente(obj)
{
  field = document.getElementById('cuerpoT'); 
  field.removeChild(document.getElementById(obj)); 
}