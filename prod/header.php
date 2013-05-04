<!--	header     -->
<div id="header">
	<div id="leftHeader">
		<img src="../img/user.png" class="img-header" alt="Username" onclick="redirect('index.php')" />
		<div id="userName" class="text-header"><?php echo $sesion->getEmpleado()->getNombre(); ?></div>
		<img src="../img/noti.png" class="img-header" alt="Notificaciones" onclick="redirect('Notificaciones.php');" />
		<img src="../img/out.png" class="img-header" alt="Salir" onclick="redirect('../logout.php');"/>
	</div>
	<div id="rightHeader">
		<img src="../img/Banner1.png" class="img-banner" alt="Sistema" />
	</div>
</div>
<!-- end of header -->