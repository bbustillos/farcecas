<?php
// conexion a bases de datos
include_once 'db_conexion.php';

/**
* Mantiene funciones generales para ser extendida en cualquier otra clase
*/
class General
{
	function __construct() {
	}

	/**
	 * Permite la lectura de una tabla general
	 * @param  string $sTabla Nombre de la tabla
	 * @param  array  $aData  Columnas requeridas ej. $array = array('id', 'nombre');
	 * @param  array  $mWhere Sentencia Where ej $array = array(array('id1', 'valor1'), array('id2', 'valor2'));
	 * @return array $aResult Devuelve la informacion obtenida de la consulta
	 */
	public function leerTabla($sTabla, $aData=null, $mWhere=null){
		global $objCon;
		if ($mWhere) {
			foreach ($mWhere as $key => $aWhere) {
				$sId = $aWhere[0];
				$sValor = $aWhere[1];
				$objCon->where($sId, $sValor);
			}
		}
		if ($aData) {
			$aResult = $objCon->get($sTabla, null, $aData);
		} else {
			$aResult = $objCon->get($sTabla);
		}

		return $aResult;
	}

	/**
	 * Permite el almacenamiento de informacion en una tabla general
	 * @param  string $sTabla Nombre de la tabla
	 * @param  array  $aData  Informacion para almacenar ej. $array = array('id'=>1, 'nombre'=>'Felipe', 'apellido'=>'Salazar')
	 * @return string $sId    
	 */
	public function almacenarTabla($sTabla, $aData/*, $aValidador=null*/){
		global $objCon;
		$sId = $objCon->almacenar($sTabla, $aData/*, $aValidador*/);
		return $sId;
	}

	/**
	 * Permite la modificacion de informacion en una tabla general
	 * @param  string $sTabla Nombre de la tabla
	 * @param  array  $aData  Informacion que se desea actualizar
	 * @param  string $sId    Nombre de columna para el WHERE
	 * @param  string $sValor Valor de la columna para el WHERE
	 * @return int    $reg    Cantidad de registros afectados
	 */
	public function modificaTabla($sTabla, $aData, $sId, $sValor){
		global $objCon;
		$objCon->where($sId, $sValor);
		if($objCon->update($sTabla, $aData)){
			$registros = $objCon->count;
			return $reg;
		}else {
			return false;
		}
	}

	/**
	 * Permite la eliminacion de un registro
	 * @param  string $sTabla Nombre de la tabla
	 * @param  string $sId    Nombre de la columna para el WHERE
	 * @param  string $sValor Valor de la columna para el WHERE
	 * @return return true
	 */
	public function eliminaRegistroTabla($sTabla, $sId, $sValor){
		global $objCon;
		$objCon->where($sId, $sValor);
		if ($objCon->delete($sTabla)) {
			return true;
		} else {
			return false;
		}
	}
}