<?php
if ( !defined("__VALIDATIONS__") ){
	define("__VALIDATIONS__","");

	class Validations{
		
		public static function cleanString($string){
			return filter_var($string, FILTER_SANITIZE_STRING);
		}
		
		public static function validaRFC($string){
			$valor = str_replace("-", "", $string); 
			$cuartoValor = substr($valor, 3, 1); 
			if (ctype_digit($cuartoValor) && strlen($valor) == 12) { // Caso de personas morales
				$letras = substr($valor, 0, 3); 
				$numeros = substr($valor, 3, 6); 
				$homoclave = substr($valor, 9, 3); 
				if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) { 
					return true; 
				} 
			} else if (ctype_alpha($cuartoValor) && strlen($valor) == 13) { // Caso de personas fisicas
				$letras = substr($valor, 0, 4); 
				$numeros = substr($valor, 4, 6); 
				$homoclave = substr($valor, 10, 3); 
				if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) { 
					return true; 
				} 
			}else { 
				return false; 
			} 
		} 
		public static function validaCURP($string){
			if ( strlen($string) != 18 ) return false;
			$valor = str_replace("-", "", $string); 
			$letras = substr($valor,0,4);
			$fecha  = substr($valor,4,6);
			$estado = substr($valor,10,6);
			$clave1  = substr($valor,16,1);
			$clave2  = substr($valor,17,1);
			if (ctype_alpha($letras) && ctype_alpha($estado) && ctype_digit($fecha) && ctype_alnum($clave1) && ctype_digit($clave2) ){
				return true;
			}
			return false;
		}
		public static function validaTel($string){
			$reg = "/[0-9]{2}[-. ][0-9]{2}[-. ][0-9]{2}[-. ][0-9]{2}/";
			return preg_match($reg, $string) ? true: false;		
		}
		public static function validaEmail($string){
			return filter_var($string, FILTER_VALIDATE_EMAIL);  
		}
		
		public static function validaNombre($string){
			return preg_match("/^[^\d]+$/" , $string ) ? true: false;
		}
		
		public static function validaFloat($string){
			if (strlen($string)==0)return false;
			return preg_match("/^[0-9]*(\.)?[0-9]*$/" , $string ) ? true: false;
		}
		public static function validaInt($string){
			if (strlen($string)==0)return false;
			return preg_match("/^\d*$/" , $string ) ? true: false;
		}
	}
}
?>