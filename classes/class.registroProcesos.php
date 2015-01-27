<?php
// conexion a bases de datos
include_once 'db_conexion.php';

/**
* almacenamiento de procesos (log de acciones)
*/
class registroProcesos{
	function __construct(){
	}

	function almacenamientoProceso($nombre, $ip, $login, $pagina=null, $accion=null){
		$archivo = $this->verificaArchivoLog($nombre);
		$fecha = date('d-m-Y H:i:s');
		if ($nombre == 'salehLogAccesos') {
			$registroLog = '"Fecha: '.$fecha.'", "IP: '.$ip.'", "Login: '.$login.'"';
		} else {
			$registroLog = '"Fecha: '.$fecha.'", "IP: '.$ip.'", "Login: '.$login.'", "Pagina: '.$pagina.'", "Accion: '.$accion.'"';
		}
		fwrite($archivo, $registroLog.PHP_EOL);
		fclose($archivo);
	}

	function creaArchivoLog($nombre){
		$pathArchivo = "../logs/".$nombre.".log";
		$archivo = fopen($pathArchivo,"a");
		return $archivo;
	}

	function verificaArchivoLog($nombre){
		$pathArchivo = "../logs/".$nombre.".log";
		$existeArchivo = file_exists($pathArchivo);
		if ($existeArchivo) {
			$archivo = fopen($pathArchivo,"a");
			return $archivo;
		} else {
			// Crear archivo de Log
			$archivoCreado = $this->creaArchivoLog($nombre);
			return $archivoCreado;
		}
	}

	function obtienePaginaActual(){
		return basename($_SERVER['PHP_SELF']);
	}

	function ObtenerIP()
    {
		$ip = "";
		if(isset($_SERVER)){
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip=$_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
				$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip=$_SERVER['REMOTE_ADDR'];
			}
		} else {
			if ( getenv( 'HTTP_CLIENT_IP' ) ){
				$ip = getenv( 'HTTP_CLIENT_IP' );
			} elseif( getenv( 'HTTP_X_FORWARDED_FOR' ) ){
				$ip = getenv( 'HTTP_X_FORWARDED_FOR' );
			} else {
				$ip = getenv( 'REMOTE_ADDR' );
			}
		}  
		// En algunos casos muy raros la ip es devuelta repetida dos veces separada por coma 
		if(strstr($ip,',')) {
			$ip = array_shift(explode(',',$ip));
		}

		return $ip;
    }
}