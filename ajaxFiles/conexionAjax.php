<?php
	include '../classes/class.conexion.php';
	$oConex = new Conexion;
	$oConex->sec_session_start();

	$accion = $_REQUEST['accion'];
	$aResp = array();
	switch ($accion) {
		// Verifica control de acceso
		case 1:
			$ingreso = $oConex->procesaLogin();
			print $ingreso;
			break;
		
		default:
			# code...
			break;
	}