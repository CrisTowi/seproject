$(document).ready(function() {
      
   $('#formRegistrar').validate({
	  ignore: "",
      rules: {//Inicio de las reglas
         sufFinal0: {
            min: 0
         },
		 sufFinal1: {
            min: 0
         },
		 sufFinal2: {
            min: 0
         },
		 sufFinal3: {
            min: 0
         },
		 sufFinal4: {
            min: 0
         },
		 sufFinal5: {
            min: 0
         },
		 sufFinal6: {
            min: 0
         },
		 sufFinal7: {
            min: 0
         },
		 sufFinal8: {
            min: 0
         },
		 sufFinal9: {
            min: 0
         },
		 sufFinal10: {
            min: 0
         }
      }, // Fin de las reglas
      messages: { //Inicio de los mensajes de error
         sufFinal0: {
            min: '*Materia prima insuficiente'
         },
		 sufFinal1: {
            min: '*Materia prima insuficiente'
         },
		 sufFinal2: {
            min: '*Materia prima insuficiente'
         },
		 sufFinal3: {
            min: '*Materia prima insuficiente'
         },
		 sufFinal4: {
            min: '*Materia prima insuficiente'
         },
		 sufFinal5: {
            min: '*Materia prima insuficiente'
         },
		 sufFinal6: {
            min: '*Materia prima insuficiente'
         },
		 sufFinal7: {
            min: '*Materia prima insuficiente'
         },
		 sufFinal8: {
            min: '*Materia prima insuficiente'
         },
		 sufFinal9: {
            min: '*Materia prima insuficiente'
         },
		 sufFinal10: {
            min: '*Materia prima insuficiente'
         }		 
      }//Fin de mensajes
	 	 
	 }//Fin del argumento que enviamos a validate
    );  //Fin de la funcion validate  
    
}); // end ready