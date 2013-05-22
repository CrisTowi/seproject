function valida( str, target,target2, target3,validate ){
		if ( validate == "cantidad") {
		str = str.trim();
		if ( str.length == 0 || str == 0 ){
			document.getElementById(target).innerHTML = "<img src='../img/error.png' title='La cantidad es un campo obligatorio.' />";	
		}
		else{
			var re =/^\d*$/;
			ok = re.exec(str);
			var a=parseInt(str)%100;
			if ( !ok ){
				document.getElementById(target).innerHTML = "<img src='../img/error.png' title='La cantidad sólo acepta numeros.' />";	
			}else{
				if(a!=0)
				{
					document.getElementById(target).innerHTML = "<img src='../img/error.png' title='La cantidad sólo acepta multiplos de 100.' />";
				}else{
				document.getElementById(target).innerHTML = "<img src='../img/ok.png' />";
				var b=document.getElementById(target3).innerHTML;
				b=b.replace('$','');
				document.getElementById(target2).innerHTML="$"+parseInt(b)*parseInt(str);}
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
		if(nuevoIngreso==undefined || selector.value==0)
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
			if(selector.value==0)
			{
			texto.innerHTML="Pedido"+actual;	
			}
			else
			{texto.innerHTML=selector.options[selector.selectedIndex].text;}
			
			celda1.appendChild(texto);
			///ceLda 4
			celda4= document.createElement('td'); 
			precio=document.createElement('span');
			precio.id='precio'+actual;
			precio.name='precio'+actual;
			//precio.innerHTML=document.getElementById('precio').value;
			celda4.appendChild(precio);
			///
			celda6= document.createElement('td'); 
			preciou=document.createElement('span');
			preciou.id='preciou'+actual;
			preciou.name='preciou'+actual;
			preciou.innerHTML=document.getElementById('precio').value;
			celda6.appendChild(preciou);
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
			input.setAttribute("onblur","valida(this.value,'MSG"+actual+"','precio"+actual+"','preciou"+actual+"','cantidad');");
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
			if(selector.value==0)
			{
			divIMG.setAttribute( "onclick","quitarIngrediente('Pedido"+actual+"');");	
			}
			else
			{divIMG.setAttribute( "onclick","quitarIngrediente('"+selector.value+"');");}
			
			celda3.className='opc';
			celda3.appendChild(divIMG);	
			
			renglon = document.createElement('tr'); 
			renglon.className ='tr-cont'; 
			if(selector.value==0)
			{
			renglon.id="Pedido"+actual;
			renglon.name="Pedido"+actual;
			}else{renglon.id=selector.value;
			renglon.name=selector.value;}
		   
			renglon.appendChild(celda1);
			renglon.appendChild(celda0);
			renglon.appendChild(celda2);
			renglon.appendChild(celda6);
			renglon.appendChild(celda4);
			
			renglon.appendChild(celda3);
			renglon.appendChild(celda5);
			field.appendChild(renglon);

			//se alamacenan los idMP
			idMP=document.createElement('input');
			idMP.id='idMP'+actual;
			idMP.name='idMP'+actual;
			idMP.type = 'hidden';
			idMP.className='ides';
			if(selector.value==0)
			{
			idMP.value="Pedido"+actual;
			}else{
			idMP.value=selector.value;}
			
			field.appendChild(idMP);
			
			idprod=document.createElement('input');
			idprod.id='idprod'+actual;
			idprod.name='idprod'+actual;
			idprod.type = 'hidden';
			idprod.className='produ';
			idprod.value=document.getElementById('prod').value;
			
			field.appendChild(idprod);
		}
		else
		{
			alert("El lote ya está en la lista");
		}
	}	
}

function quitarIngrediente(obj)
{
  field = document.getElementById('cuerpoT'); 
  field.removeChild(document.getElementById(obj)); 
}