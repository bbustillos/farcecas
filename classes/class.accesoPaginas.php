<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', True);
// Include de clase general
require_once('class.general.php');

/**
* Clase para administracion de acceso a paginas
*/
class AccessoPaginas
{

	function __construct() {
	}

	function mostrarAccesoPagina(){
		$oGeneral = new General;
		$aAccesoPagina = $oGeneral->leerTabla('saccesopaginas');
		if ($aAccesoPagina) {
			return $aAccesoPagina;
		}
	}

	function adicionarAccesoPagina($aData){
		$oGeneral = new General;
		$sId = $oGeneral->almacenarTabla('saccesopaginas', $aData);
		if ($sId) {
			$aResp['success'] = true;
			$aResp['codAccesoPagina'] = $sId;
		} else {
			$aResp['success'] = false;
		}
		return $aResp;
	}

	function modificarAccesoPagina($aData, $id){
		$oGeneral = new General;
		$sId = 'ID';
		$reg = $oGeneral->modificaTabla('saccesopaginas', $aData, $sId, $id);
		if ($reg) {
			return true;
		} else {
			return false;
		}
	}

	function eliminaAccesoPagina($id){
		$oGeneral = new General;
		$sId = 'ID';
		$sResp = $oGeneral->eliminaRegistroTabla('saccesopaginas', $sId, $id);
		if($sResp)
			// Antes de retornar la eliminacion del Menus, almacenar el proceso de eliminacion
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
							<div id="volver"><a href="../public/menuPrincipal.php">Volver</a></div><br>
								<div class="filtering">
									<div id="accesoPaginasContenedor"></div>
								</div>
							</div>';
		return $sAsignaPermiso;
	}
}
?>