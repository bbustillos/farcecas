<?php 
	include "../classes/class.conexion.php";
	$oConex = new Conexion;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SALEH (Sistema Administrativo en Linea de Empresas y Holdings)</title>
	<link rel="stylesheet" href="../styles/principal.css">
	<link rel="stylesheet" type="text/css" media="screen" href="../javascript/jquery-ui-1.11.2.custom/jquery-ui.min.css" />
	<script type="text/JavaScript" src="../javascript/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="../javascript/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
	<script type="text/JavaScript" src="../javascript/sha512.js"></script>
	<script type="text/JavaScript" src="../javascript/conexion.js"></script>
</head>
<body>
	<?php echo $oConex->pantallaLogin();?>
</body>
</html>