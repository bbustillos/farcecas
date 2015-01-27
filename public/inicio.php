<?php 
    // Llamar a la clase y crear objeto de sesion
    include "../classes/class.conexion.php";
    $oConex = new Conexion;
    $oConex->sec_session_start();
?>

<html>
<head>
    <title>Saleh - Sistema Administrativo</title>
</head>
<link href="../styles/conexion.css" rel="stylesheet" />
<script type="text/JavaScript" src="../javascript/jquery-1.10.2.js"></script>
<script type="text/JavaScript" src="../javascript/sha512.js"></script>
<script type="text/JavaScript" src="../javascript/conexion.js"></script>
<body>
    <?php echo $oConex->pantallaLogin();?>
</body>
</html>