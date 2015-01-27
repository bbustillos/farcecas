<?php
	// conexion a bases de datos
    include_once '../classes/class.conexion.php';
    include_once '../classes/class.permisos.php';
    include_once '../classes/class.buses.php';
    $oConex = new Conexion;
    $oConex->sec_session_start();
    $resCheck = $oConex->login_check();
    $oPermiso = new Permisos($oConex->userId, $oConex->permisos);
    
    $oBuses = new Buses;
	$sBus = $_GET['codBus'];
	
?>
<html>
<head>
	<title>Definici&oacute;n de Asientos de Bus</title>
</head>
<body>
	<?php $oBuses->defineEstructuraBus($sBus); ?>
</body>
<link href="../styles/asientos.css" rel="stylesheet" />
<script type="text/JavaScript" src="../javascript/jquery-1.10.2.js"></script>
<script type="text/JavaScript" src="../javascript/buses.js"></script>
</html>