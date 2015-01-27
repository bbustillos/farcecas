<?php

include '../classes/class.adminmenu.php';
include '../classes/class.asignaPermisos.php';
include '../classes/class.accesoPaginas.php';
$oAdminMenu = new AdminMenu;
$oAsignaPermisos = new AsignaPermisos;
$oAccessoPaginas = new AccessoPaginas;

$var = (array_key_exists('o', $_GET))?$_GET['o']:""; 
switch ($var) {
	case 'paginas':
		$aResultado = $oAdminMenu->cargarPaginas();
		break;
	case 'padre':
		$aResultado = $oAdminMenu->cargarPadre();
		break;
	case 'personal':
		$aResultado = $oAsignaPermisos->cargarPersonal();
		break;
	case 'tipoAsignacionPermiso':
		$aResultado = $oAsignaPermisos->cargarTipoAsignacion();
		break;
	case 'empresa':
		$aResultado = $oAccessoPaginas->cargarEmpresa();
		break;
	
	default:
		# code...
		break;
}

// Return result to jTable
$jTableResult = array();
$jTableResult['Result'] = "OK";
$jTableResult['Options'] = $aResultado;
print json_encode($jTableResult);