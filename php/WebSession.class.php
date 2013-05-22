<?php
if ( !defined("__WEBSESSION__") ){
	define("__WEBSESSION__","");
	include("Empleado.class.php");

	class WebSession {

		private $empleado;
		private $sesion_activa;
		private $error;
		
		public function __construct()
		{
			session_start();
			if ( !$this->isSesionActiva() ){				
				if (isset($_POST["login"])){
					$usuario = $_POST["usuario"];
					$contrasena = $_POST["contrasena"];
					$login = Empleado::iniciarSesion($usuario,$contrasena);
					if ( $login != false ){
						$this->empleado = $login;
						$this->sesion_activa = true;
						$this->error = NULL;
					}else{
						$this->error = "USER_NOT_FOUND";
						$this->empleado = NULL;
						$this->sesion_activa = false;
					}	
				}
			}
			$_SESSION["websession"] = serialize($this);
		}
		
		public function isSesionActiva(){
			return $this->sesion_activa;
		}
		
		public function getEmpleado()
		{
			return $this->empleado;
		}
		
		public function getError(){
			return $this->error;
		}
		
		public function redirect(){
			if ( $this->isSesionActiva() ){
				$path = $this->getEmpleado()->getPath();
				header("location:/Github/seproject/".$path."/index.php");
			} else {
				header("location:/Github/seproject/index.php?error=1");
			}
		}
		
		public function accessControl(){			
			if ( !$this->isSesionActiva() ){
				header("location:/seproject/index.php?error=1");
			} else {
				$path = $this->getEmpleado()->getPath();
				if ( !preg_match("#/seproject/".$path."#" , $_SERVER['REQUEST_URI'] ) ){
					if ( !preg_match("#/seproject/php#" , $_SERVER['REQUEST_URI'] ) ){
						header("location:/seproject/".$path);
					}
				}
			}
		}
	}
}
?>