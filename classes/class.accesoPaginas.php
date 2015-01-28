<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', True);
    // conexion a bases de datos
	include_once 'db_conexion.php';

	/**
	* Clase para administracion de acceso a paginas
	*/
	class AccessoPaginas
	{

		function __construct() {
		}

		function adicionarAccesoPagina($aData){
			global $objCon;
			$codAccesoPagina = $objCon->almacenar('saccesopaginas', $aData/*, $validadores*/);
			if ($codAccesoPagina) {
				$aResp['success'] = true;
				$aResp['codAccesoPagina'] = $codAccesoPagina;
			} else {
				$aResp['success'] = false;
			}
			return $aResp;
		}

		function modificarAccesoPagina($aData, $id){
			global $objCon;
			$objCon->where('ID', $id);
			if ($objCon->update('saccesopaginas', $aData)) {
				// Antes de retornar la actualizacion del acceso a Paginas, almacenar el proceso de actualizacion
				return $objCon->count;
			}
		}

		function eliminaAccesoPagina($id){
			global $objCon;
			$objCon->where('ID', $id);
			if($objCon->delete('saccesopaginas'))
				// Antes de retornar la eliminacion del acceso a Paginas, almacenar el proceso de eliminacion
				return true;
			else
				return false;
		}

		function cargarEmpresa(){
			global $objCon;
			$aResultado = array(0=>array('Value'=>'', 'DisplayText'=>''));
			$aData = array('CODEMP AS Value', 'NOMBRE AS DisplayText');
			$aEmpresa = $objCon->get('sempresas', null, $aData);
			if (is_array($aEmpresa) && count($aEmpresa)>0) {
				foreach ($aEmpresa as $key => $empresa) {
					$aResultado[] = $empresa;
				}
				return $aResultado;
			} else {
				return false;
			}
		}

		function cargarAccesoPaginas(){
			$sAsignaPermiso = '	<div id="contenedor">
									<h2>Accesa a P&aacute;ginas</h2>
									Duplicar Permiso de:
									<select id="PERSONAL" name="PERSONAL">
										<option selected="selected" value="0">-- Seleccione --</option>
										<option value="1">Persona1</option>
										<option value="2">Persona2</option>
									</select>
									<div id="volver"><a href="../public/menuPrincipal.php">Volver</a></div><br>
									<div class="filtering">
										<div id="accesoPaginasContenedor"></div>
									</div>
								</div>';
			return $sAsignaPermiso;
		}
	}
?>