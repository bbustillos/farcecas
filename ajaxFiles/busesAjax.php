<?php
    // conexion a bases de datos
    include_once '../classes/db_conexion.php';
    include '../classes/class.conexion.php';
    include '../classes/class.buses.php';
    include '../classes/class.permisos.php';
    $oConex = new Conexion;
    $oConex->sec_session_start();
    $resCheck = $oConex->login_check();
    $oBuses = new Buses;
    global $oRegistro;
    $oPermisos = new Permisos($oConex->userId, $oConex->permisos);

    // Parametros para almacenamiento de procesos
    $sPaginaActual = 'captaBuses.php';
    $ip = $oRegistro->ObtenerIP();
    $login = $oConex->usuario;

	$a = $_GET['a'];
	switch ($a) {
		// Obtiene info bus
		case 1:
			$codBus = $_POST['CODBUS'];
			$aBus = $oBuses->obtieneBus($codBus);
			if ($aBus) {
				$aBus['success'] = true;
				$oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, $sPaginaActual, 'ver');
				echo json_encode($aBus);
			} else 
				$aBus['success'] = false;
		break;
		// Modifica info bus
		case 2:
			$aDatos = $_POST;
			$codBus = $_POST['bus'];
			unset($aDatos['bus']);
			$aInfoBus = $oBuses->actualizarBus($codBus, $aDatos);
			$oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, $sPaginaActual, 'actualizar');
			echo json_encode($aInfoBus);
		break;
		// Almacena bus
		case 3:
			$aDatos = $_POST;
			$aValidador = $_POST['validador'];
			unset($aDatos['bus']);
			unset($aDatos['validador']);
			$aInfoBus = $oBuses->almacenarBus($aDatos, $aValidador);
			$oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, $sPaginaActual, 'crear');
			echo json_encode($aInfoBus);
		break;
		// Elimina bus
		case 4:
			$codBus = $_POST['bus'];
			if ($oBuses->eliminarBus($codBus)) {
				$aBus['success'] = true;
				$oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, $sPaginaActual, 'eliminar');
			} else {
				$aBus['success'] = false;
			}
			echo json_encode($aBus);
		break;
		// Verifica todas las Conexiones Activas
		case 5:
			$aConexionesActivas = $oBuses->conexionesActivasBoton();
			$oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, $sPaginaActual, 'ver conexiones activas');
			echo json_encode($aConexionesActivas);
		break;
		// Verifica Conexion Activa
		case 6:
			$campo = $_POST['CAMPO'];
			$aConexionActiva = $oBuses->conexionActivaBoton($campo);
			$oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, $sPaginaActual, 'verificar conexion activa');
			echo json_encode($aConexionActiva);
		break;
		// Verifica que el bus no tenga asientos registrados
		case 7:
			$codBus = $_POST['bus'];
			$asientoBus = $_POST['asientoBus'];
			$sResp = $oBuses->almacenaAsientosBus($codBus, $asientoBus);
			$oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, 'captaAsientos.php', 'crear asiento');
			echo json_encode($sResp);
		break;
		// Obtiene la informacion del tipo segun el disenio
		case 8:
			$codDisenio = (isset($_POST['disenio']))?$_POST['disenio']:null;
			$sResp = $oBuses->obtieneTipoDisenio($codDisenio);
			$oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, 'captaAsientos.php', 'disenar asientos');
			echo json_encode($sResp);
		break;
		default:
			break;
	}
?>