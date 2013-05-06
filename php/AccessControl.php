<?php
	session_start();
	include("WebSession.class.php");	
	if ( isset($_SESSION["websession"] )){
		$sesion = unserialize($_SESSION["websession"]);
		$sesion->accessControl();
	} else {
		header("location:/seproject/index.php");
	}
?>