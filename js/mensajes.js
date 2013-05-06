function openInbox() {
    document.getElementById("msgInbox").style.display = "block";
    document.getElementById("msgInbox").style.height  = window.innerHeight + "px";
    document.getElementById("msgInbox").style.width = window.innerWidth + "px";
    loadMessages();
}

function closeInbox() {
    document.getElementById("msgInbox").style.display = "none";
}

function loadMessagesArchived() {
    sendPetitionSync("../php/notifications/inbox.php?archivado=1","messages",document);
	document.getElementById("banner").innerHTML = "Mensajes archivados";
}

function loadMessages() {
    sendPetitionSync("../php/notifications/inbox.php?archivado=0","messages",document);
	document.getElementById("banner").innerHTML = "Bandeja de entrada";
}

function loadSentMessages() {
    sendPetitionSync("../php/notifications/inbox.php?sent","messages",document);
	document.getElementById("banner").innerHTML = "Bandeja de salida";
}

function viewDetails(id,read){
	document.getElementById("details").style.display = "block";
    document.getElementById("details").style.height  = window.innerHeight + "px";
    document.getElementById("details").style.width = window.innerWidth + "px";
    loadDetails(id); 
	if ( read ){
		if ( document.getElementById("archivado").value == 1 ){
			document.getElementById("botonArchivar").innerHTML = "Regresar a bandeja de entrada";
		}else{
			document.getElementById("botonArchivar").innerHTML = "Archivar";
		}
		document.getElementById("botonArchivar").style.display = "";
	} else {
		document.getElementById("botonArchivar").style.display = "none";
	}
}

function loadDetails(id){
	sendPetitionSync("../php/notifications/details.php?id=" + id,"msgDetail",document);
}

function closeDetails() {
    document.getElementById("details").style.display = "none";
}

function sendMsg(){
	document.getElementById("sendMessage").style.display = "block";
    document.getElementById("sendMessage").style.height  = window.innerHeight + "px";
    document.getElementById("sendMessage").style.width = window.innerWidth + "px";
    loadSender();
}
function loadSender(){
	sendPetitionSync("../php/notifications/sendMsg.php","msgSend",document);
}

function closeSend() {
    document.getElementById("sendMessage").style.display = "none";
}

function archivarMsg(){	
	id = document.getElementById("id").value;	
	if ( document.getElementById("archivado").value == 1 ){
		sendPetitionQuery("../php/notifications/archivaMensaje.php?id=" + id + "&reverse=true"); // Desarchivar
	}else{
		sendPetitionQuery("../php/notifications/archivaMensaje.php?id=" + id); // Archivar
	}	
	if ( returnedValue == "OK" ){
		alert("Operacion realizada correctamente");
		closeDetails();
		loadMessages();
	}else{
		alert("Error desconocido :(");
	}	
}

function sendMessage(){
	if ( document.getElementById("asunto").value.length == 0 ||
		 document.getElementById("mensaje").value.length == 0 ){
		alert("No puede dejar campos vacios"); 
		return;
	}
	qry = "enviarMensaje.php?";
	qry += "asunto=" + document.getElementById("asunto").value + "&";
	qry += "area=" + document.getElementById("area").value + "&";
	qry += "mensaje=" + document.getElementById("mensaje").value + "&";
	qry += "problema=" + document.getElementById("problema").checked;
	sendPetitionQuery("../php/notifications/" + qry);
	if ( returnedValue == "OK" ){
		alert("Mensaje enviado");
		closeSend();
		loadMessages();
	}else{
		alert("Error desconocido :(");
	}	
}