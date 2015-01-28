<?php
	include_once '../classes/db_conexion.php';
	/**
	* Funciones genericas
	*/
	class ClassName extends AnotherClass
	{
		
		function __construct() {
		}

		function obtenerCantidadRegistros($sTable){
			global $objCon;
			$aData = array("COUNT(*) AS TOTAL");
			$result = $objCon->get($sTable, null, $aData);
			return $result[0]['TOTAL'];
		}
	}
?>