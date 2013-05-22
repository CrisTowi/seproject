<?php
	if ( !defined("__DATACONNECTION__") ){
		define("__DATACONNECTION__","");
		class DataConnection
		{	
			private $link;
			private $server = "localhost";
			private $user = "root";
			private $password = "root";
			private $database = "cookies";
			
			public function __construct()  
			{  
				$link = mysql_connect($this->server,$this->user,$this->password);
				if ($link){
					$db_selected = mysql_select_db($this->database, $link);
					if ($db_selected) {
						$this->link = $link;
						return;
					}
				}
				$this->link = NULL;
			} 
		
			public static function testConnection(){
				$link = mysql_connect($this->server,$this->user,$this->password);
				if ($link){
					$db_selected = mysql_select_db($this->database, $link);
					if ($db_selected) {
						return true;
					}
				}
				return false;
			}
			
			public function isConnectionEstablished(){
				if ( $this->link != NULL ) return true; return false;
			}
			
			public function executeQuery($qry){
				if ( $this->link != NULL )
					return mysql_query($qry,$this->link);
				return false;
			}		
		}
	}
?>