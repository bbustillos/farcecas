<?php
    // conexion a bases de datos
	include_once '../classes/class.conexion.php';
	include_once '../classes/class.permisos.php';
	$oConex = new Conexion;
	$oConex->sec_session_start();
	$resCheck = $oConex->login_check();
	$oPermiso = new Permisos($oConex->userId, $oConex->permisos);
?>

<html>
<head>
    <title>Saleh - Sistema Administrativo</title>
</head>
<link href="../styles/menuPrincipal.css" rel="stylesheet" />
<script type="text/JavaScript" src="../javascript/jquery-1.10.2.js"></script>
<script type="text/JavaScript" src="../javascript/sha512.js"></script>
<script type="text/JavaScript" src="../javascript/conexion.js"></script>
<body>

	<div id="contenedor">
		<table>
			<tr>
				<td colspan="2" width="700px" align="middle">
					<img src="../images/cabecera_r2_c3.gif" alt="lighthouse">
				</td>
			</tr>
			<tr>
				<td align="middle"><h2>Por favor seleccione una opci&oacute;n</h2></td>
			</tr>
			<tr>
				<td width="200px"><?php $oPermiso->menuPrincipal(); ?></td>
				<td></td>
			</tr>
		</table>
	</div>
	<div class="saleh_reg">
		Sistema desarrollado por Fernando Arce Castellon Cel. 76210417 Email:ferarce@yahoo.com<br>
		Derechos Reservados© - Representantes LEGALES "GRUPO SALEH"
	</div>
</body>
<script type="text/javascript">

</script>
</html>