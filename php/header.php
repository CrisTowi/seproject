<!--	header     -->
<div id="header">
	<div id="leftHeader">
		<img src="../img/user.png" class="img-header-nc" alt="Username" />
		<div id="userName" class="text-header"><?php echo $sesion->getEmpleado()->getNombre(); ?></div>
		<img src="../img/noti.png" class="img-header" alt="Notificaciones" onclick="openInbox();" />
		<img src="../img/out.png" class="img-header" alt="Salir" onclick="redirect('../logout.php');"/>
	</div>
	<div id="rightHeader">
		<img src="../img/Banner1.png" class="img-banner" alt="Sistema" />
	</div>
</div>
<div id="msgInbox">
    <div id="inbox">
		<div class="close" onclick="closeInbox();"><img src="../img/close.png" ></div>
        <center>
            <h1 id="banner">Notificaciones</h1>			
        </center>
        <div id="content">
            <div class="box">
				<center>
					<div class="form-button" onclick="sendMsg();"><img src="../img/write.png" height="40px"></div>
					<div class="form-button" onclick="loadMessages();"><img src="../img/inbox.png" height="40px"></div>
					<div class="form-button" onclick="loadSentMessages();"><img src="../img/sent.png" height="40px"></div>
					<div class="form-button" onclick="loadMessagesArchived();"><img src="../img/achieved.png" height="40px"></div>
				</center>
             </div>
    		<div class="box">
                <div id="messages">Aqui van los mensajes</div>
            </div>			            
       </div>
    </div>
</div>
<!-- Ver mensaje -->
<div id="details">
    <div id="inbox">
		<div class="close" onclick="closeDetails();"><img src="../img/close.png" ></div>
        <center>
            <h1>Detalle</h1>
        </center>
        <div id="content">
            <div class="box">
                <!--<div class="form-button" onclick="sendMsg();">Responder</div>-->
				<div class="form-button" onclick="archivarMsg();" id="botonArchivar">Archivar</div>
             </div>
    		<div class="box">
                <div id="msgDetail">Aqui van el detalle</div>
            </div>			            
       </div>
    </div>
</div>
<!-- Enviar mensaje -->
<div id="sendMessage">
    <div id="inbox">
	<div class="close" onclick="closeSend();"><img src="../img/close.png" ></div>
        <center>
            <h1>Enviar Mensaje</h1>
        </center>
        <div id="content">
    		<div class="box">
                <div id="msgSend">Mensaje D:</div>
            </div>	
			<div class="box">
                <div class="form-button" onclick="sendMessage();">Enviar</div>               
             </div>
       </div>
    </div>
</div>
<!-- end of header -->