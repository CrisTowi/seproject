<?php
	if(!defined("__PRODUCCION__")){
		define("__Produccion__", "");
		include("../php/DataConnection.class.php");	
		include("Lote.class.php");	
		
		class Produccion{
			
			private $numProduccion;
			private $noLinea;
			private $encargadoLinea;
			private $loteAsociado;
			private $estado;
			
			public function __construct($numProduccion, $noLinea, $encargadoLinea, $loteAsociado, $estado){
				$this->numProduccion = $numProduccion;
				$this->noLinea = $noLinea;
				$this->encargadoLinea = $encargadoLinea;
				$this->loteAsociado = $loteAsociado;
				$this->estado = $estado;
			}//Construct
			
			public function getLinea(){
				return $this->noLinea;
			}
			
			public function getEncargado(){
				return $this->encargadoLinea;
			}

			public function getLote(){
				return $this->loteAsociado;
			}
			
			public function getEstado(){
				return $this->estado;
			}
			
			public static function findById($numprod){	
				$db = new DataConnection();
				$result = $db->executeQuery("SELECT * FROM lineaproduccion 
				WHERE numproduccion = '".$numprod."'");
				if($dato = mysql_fetch_assoc($result)){
					$prod = new Produccion($dato["numproduccion"], $dato["nolinea"], $dato["encargadoLinea"]
					, $dato["nolote"], $dato["estado"]);
					return $prod;
				}
				return false;
			}

			public static function eliminar($numprod){
				$db = new DataConnection();

				$loteAux = $db->executeQuery("SELECT * FROM lineaproduccion 
				WHERE numproduccion = '$numprod';");
				if($dato = mysql_fetch_assoc($loteAux)){
					$lote = $dato["nolote"];
				}

				$qry = "DELETE FROM lineaproduccion WHERE numproduccion = '$numprod';";
				$qry1 = "DELETE FROM lote WHERE idLote='$lote';";
				
				$result = $db->executeQuery($qry);
				if($result){
					$result1 = $db->executeQuery($qry1);
				}

				return $result1;
			}

			public static function agregar($linea, $encargado, $producto, $cantidad, $elaboracion, 
			$caducidad){
				
				$db = new DataConnection();
				$nuevoLote = Lote::agregar($producto, $cantidad, $elaboracion, $caducidad);
/*				
				$aux = "INSERT INTO lote (noLote, productoAsociado, cantidadProducto, fechaElaboracion,
				fechaCaducidad) VALUES('0', '$producto', '$cantidad', '$elaboracion', '$caducidad');";
				echo $aux;
*/				
				//Si se pudo agregar el lote, asignamos la linea
				if($nuevoLote){
					//Obtener el id del ultimo lote agregado
	 				$pqry2 = "SELECT * FROM LOTE ORDER BY idLote DESC LIMIT 1";
	 				$id = obtenerId($pqry2);
	 				//echo $id."<br />";		
								
					$qry = "INSERT INTO lineaproduccion (numproduccion, nolinea, encargadoLinea, 
					estado, nolote)
					VALUES('0', '$linea', '$encargado', 'pendiente', '$id');";
					//echo $qry;							
					
					if($res = $db->executeQuery($qry)){
						return true;						
					}
				}
				return false;
			}//agregar

//		$accept = Produccion::modificar($numprod, $linea, $encargado, $producto, $cantidad, 
//		$elaboracion, $caducidad);			
			public static function modificar($numprod, $linea, $encargado, $estado, $producto, $cantidad,
			$elaboracion, $caducidad){
				
				$db = new DataConnection();
				
				$encontrarProduccion = "SELECT * FROM lineaproduccion WHERE numproduccion = '$numprod';";
				if($res = $db->executeQuery($encontrarProduccion)){
					while($fila = @mysql_fetch_array($res)){
						$nl = $fila["nolote"];
					}
					//echo $nl."<br />";
					$lotem = Lote::modificar($nl, $producto, $cantidad, $elaboracion, $caducidad);
					$qry = "UPDATE lineaproduccion SET nolinea = '$linea', encargadoLinea = '$encargado', 
					estado = '$estado', nolote = '$nl' WHERE numproduccion = '$numprod';";
					//echo $qry;
					if($resulado = $db->executeQuery($qry)){
						return true;
					}
				}

				return false;

				
				//$nl = $prod->getLote();
				//$lote = Lote::findById($nl);
/*				
				$modificarLote = Lote::modificar($nl, $producto, $cantidad, $elaboracion, $caducidad);
				if($modificarLote){
					
					$qry = "UPDATE lineaproduccion SET nolinea = '$linea', encargadoLinea = '', 
					estado = '', nolote = '' WHERE 'numproduccion = '$numprod';'";
					if($res = $db->executeQuery($qry)){
						return true;
					}
				}

				return false;
*/								
			}				
			
		}//clase
	}//ifdefined
?>

<?php

	function obtenerId($qry){
		$db = new DataConnection();
		$res = $db->executeQuery($qry);
		
		if(mysql_num_rows($res) < 1){
			return 0;		//Lote no encontrado
		}
		else{
			while($fila = @mysql_fetch_array($res)){
				$id = $fila["idLote"];
			}
			return $id;
		}
		return 0;
	}
?>