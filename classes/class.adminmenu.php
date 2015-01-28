<?php
	// conexion a bases de datos
	include_once 'db_conexion.php';

	/**
	* Permite administrar todos los recursos generados para la administracion de menus
	* altas bajas y modificaciones a nivel grilla
	*/
	class AdminMenu
	{
		private $permisos;
		function __construct($permisos=null){
			$this->permisos = $permisos;
		}

		function adicionarMenu($aData){
			global $objCon;
			$aResp = array();
			$codAdmin = $objCon->almacenar('sadminmenu', $aData, $validadores);
			if ($codAdmin) {
				// Antes de retornar el almacenamiento de Menus, almacenar el proceso de almacenamiento
				$aResp['success'] = true;
				$aResp['codAdmin'] = $codAdmin;
				return $aResp;
			} else {
				$aResp['success'] = false;
				$aResp['validador'] = $validadores;
				return $aResp;
			}
		}

		function modificarMenu($aData, $id){
			global $objCon;
			$objCon->where('CODMENU', $id);
	        if ($objCon->update('sadminmenu', $aData)) {
				// Antes de retornar la actualizar del Menus, almacenar el proceso de actualizacion
	            return $db->count;
	        } else {
	        	return false;
	        }
		}

		function eliminarMenu($id){
			global $objCon;
			$objCon->where('CODMENU', $id);
			if($objCon->delete('sadminmenu'))
				// Antes de retornar la eliminacion del Menus, almacenar el proceso de eliminacion
				return true;
			else
				return false;
		}

		function cargarPaginas(){
			global $objCon;
			$aResultado = array(0=>array('Value'=>'', 'DisplayText'=>''));
			$aData = array('CODPAG AS Value', 'NOMBRE AS DisplayText');
			$objCon->orderBy('DisplayText', 'ASC');
			$aPaginas = $objCon->get('spaginas', null, $aData);
			if (is_array($aPaginas) && count($aPaginas)>0) {
				foreach ($aPaginas as $key => $pagina) {
					$aResultado[] = $pagina;
				}
				return $aResultado;
			} else {
				return false;
			}
		}

		function cargarPadre(){
			global $objCon;
			$aResultado = array(0=>array('Value'=>'', 'DisplayText'=>''));
			$aData = array('CODMENU AS Value', 'MENUNOMBRE AS DisplayText');
			$objCon->orderBy('Value', 'ASC');
			$aPadre = $objCon->get('sadminmenu', null, $aData);
			if (is_array($aPadre) && count($aPadre)>0) {
				foreach ($aPadre as $key => $padre) {
					$aResultado[] = $padre;
				}
				return $aResultado;
			} else {
				return false;
			}
		}

		function cargarMenus(){
			$sMenus = '<div id="contenedor">
						<h2>Administraci&oacute;n de Men&uacute;s</h2>
						<div class="filtering">
							Estado:
							<select id="ESTADO" name="ESTADO">
								<option selected="selected" value="0">-- Seleccione --</option>
								<option value="1">Activo</option>
								<option value="2">Inactivo</option>
							</select>
							Tipo:
							<select id="MENUTIPO" name="MENUTIPO">
								<option selected="selected" value="0">-- Seleccione --</option>
								<option value="M">Men&uacute;</option>
								<option value="SM">Sub-Men&uacute;</option>
								<option value="P">P&aacute;gina</option>
							</select>
							<button type="submit" id="LoadRecordsButton">Buscar</button>
							<button type="button" id="clearFilters">Limpiar</button>
							<div id="volver"><a href="../public/menuPrincipal.php">Volver</a></div>
							<div id="menuAdminContenedor"></div>
						</div>
					</div>';
	        return $sMenus;
		}
	}