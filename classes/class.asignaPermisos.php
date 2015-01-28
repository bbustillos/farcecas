<?php
	// conexion a bases de datos
	include_once 'db_conexion.php';

	/**
	* Permite administrar todos los recursos generados para la administracion de menus
	* altas bajas y modificaciones a nivel grilla
	*/
	class AsignaPermisos
	{
		private $permisos;
		function __construct($permisos=null){
			$this->permisos = $permisos;
		}

		function mostrarPermisos(/*$sEstado = null, $sMenuTipo = null*/){
			global $objCon;
			$aData = array("ASIGNACCID", "CODPER", "CODPAG", "ASIGNACCESO", "TIPOASIGNACCID", "FECHAINICIO", "FECHAFIN", "ESTADO");
			// if ($sEstado) { $objCon->where('ESTADO', $sEstado); }
			// if ($sMenuTipo) { $objCon->where('MENUTIPO', $sMenuTipo); }
		    $result = $objCon->get('sasignaacceso');
		    if (is_array($result) && count($result)>0) {
		    	return $result;
		    } else {
		    	return false;
		    }
		}

		function adicionarPermiso($aData){
			global $objCon;
			$aResp = array();
			$codAdmin = $objCon->almacenar('sasignaacceso', $aData, $validadores);
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

		function modificarPermiso($aData, $id){
			global $objCon;
			$objCon->where('ASIGNACCID', $id);
			if ($objCon->update('sasignaacceso', $aData)) {
				// Antes de retornar la actualizar del Menus, almacenar el proceso de actualizacion
				return true;
			}
		}

		function eliminarPermiso($id){
			global $objCon;
			$objCon->where('ASIGNACCID', $id);
			if($objCon->delete('sasignaacceso'))
				// Antes de retornar la eliminacion del Menus, almacenar el proceso de eliminacion
				return true;
			else
				return false;
		}

		function cargarPersonal(){
			global $objCon;
			$aResultado = array(0=>array('Value'=>'', 'DisplayText'=>''));
			$aData = array('CODPER AS Value', 'CONCAT(PATERNO, " ", MATERNO, " ", NOMBRES) AS DisplayText');
			$objCon->orderBy('DisplayText', 'ASC');
			$aPersonal = $objCon->get('spersonal', null, $aData);
			if (is_array($aPersonal) && count($aPersonal)>0) {
				foreach ($aPersonal as $key => $personal) {
					$aResultado[] = $personal;
				}
				return $aResultado;
			} else {
				return false;
			}
		}

		function cargarTipoAsignacion(){
			global $objCon;
			$aResultado = array(0=>array('Value'=>'', 'DisplayText'=>''));
			$aData = array('TIPOASIGNACCID AS Value', 'TIPOASIGNACCDES AS DisplayText');
			$objCon->orderBy('DisplayText', 'ASC');
			$aTipoAsignacion = $objCon->get('stipoasignaacceso', null, $aData);
			if (is_array($aTipoAsignacion) && count($aTipoAsignacion)>0) {
				foreach ($aTipoAsignacion as $key => $tipoAsingacion) {
					$aResultado[] = $tipoAsingacion;
				}
				return $aResultado;
			} else {
				return false;
			}
		}

		function cargarAsignacionPermisos(){
			$sMenus = '	<div id="contenedor">
						<h2>Asignaci&oacute;n de Permisos</h2>
						<div id="volver"><a href="../public/menuPrincipal.php">Volver</a></div><br>
							<div class="filtering">
								<div id="asignaPermisosContenedor"></div>
							</div>
						</div>';
			return $sMenus;
		}

		function asignaPermiso($userId, $nombrePag){
			// Se verifica que existan o no permisos en la tabla 'sasignaacceso'
			// Se determina el tipo de asignacion de permiso es
			global $objCon;
			// Obtenemos el codigo del nombre de la pagina enviada
			$aData = array('CODPAG');
			$objCon->where('NOMBRE', $nombrePag);
			$aCodPag = $objCon->get('spaginas');
			if (is_array($aCodPag) && count($aCodPag)>0) {
				$codPag = $aCodPag[0]['CODPAG'];
			} else {
				$codPag = null;
			}

			if ($codPag) {
				global $objCon;
				$aData = array('A.ASIGNACCID', 'A.ASIGNACCESO', 'A.TIPOASIGNACCID', 'A.FECHAINICIO', 'A.FECHAFIN');
				$objCon->join('members M', 'M.CODPER=A.CODPER', 'INNER');
				$objCon->where('M.id', $userId);
				$objCon->where('A.CODPAG', $codPag);
				$objCon->where('A.ESTADO', 1);
				$aPermiso = $objCon->get(' sasignaacceso A', 1, $aData);
				if (is_array($aPermiso) && count($aPermiso)>0) {
					if ($aPermiso[0]['TIPOASIGNACCID'] == 2) {
						$todayDate = date('Y-m-d');

						$fechaInicio = date('Y-m-d', strtotime($aPermiso[0]['FECHAINICIO']));
						$fechaFin = date('Y-m-d', strtotime($aPermiso[0]['FECHAFIN']));
						
						if (($todayDate >= $fechaInicio) && ($todayDate <= $fechaFin)){
							return $aPermiso;
						} else {
							$this->permisoUnicaVez($idAsignacion);
							return false;
						}
					} else {
						return $aPermiso;
					}
				} else {
					return false;
				}
			} else {
				return 1;
			}
		}

		function permisoUnicaVez($idAsignacion){
			// 1. Si es unica vez, en el momento que el usuario haga la ejecucion del permiso se deja el permiso en 0 y se refresca la pagina para re obtener los permisos generales
			global $objCon;
			$aData = array('ESTADO'=>0);
			$objCon->where('ASIGNACCID', $idAsignacion);
			if ($objCon ->update('sasignaacceso', $aData)) {
				return true;
			} else {
				return false;
			}
		}

		function permisoTemporal($idAsignacion){
			// 2. Si es temporal verificar las fechas y otorgar permiso mientras este dentro de la fecha, en cuanto salga del rango de fechas inactivar el permiso asignado y devolver los permisos generales
			global $objCon;
			$aData = array('ESTADO');
			$objCon->where('DATE(NOW()) BETWEEN FECHAINICIO AND FECHAFIN');
			$objCon->where('ASIGNACCID', $idAsignacion);
			$aEstadoTemporal = $objCon->get('sasignaacceso', 1, $aData);
			if (is_array($aEstadoTemporal) && count($aEstadoTemporal)>0) {
				return true;
			} else {
				$this->permisoUnicaVez($idAsignacion);
			}
		}
	}