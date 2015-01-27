<?php
    // conexion a bases de datos
    include_once '../classes/class.conexion.php';
    include_once '../classes/class.permisos.php';
    include_once '../classes/class.buses.php';
    $oConex = new Conexion;
    $oConex->sec_session_start();
    $resCheck = $oConex->login_check();
    if ($resCheck == true) {
        $oPermiso = new Permisos($oConex->userId, $oConex->permisos);
        $oBuses = new Buses;
    } else {
        $oConex->reiniciar();
    }
?>
<!DOCTYPE html>  
  
<html xmlns="http://www.w3.org/1999/xhtml">  
<head runat="server">  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <head>
        <meta charset="UTF-8">
        <title>Inicio de sesi&oacute;n segura: P&aacute;gina protegida</title>
        <style type="text/css">
            .error { color: red; }
        </style>
    </head>
    <body>
        <?php if ($resCheck == true) : ?>
            <div id='contenedor'>
                <input type='hidden' id='control' value='1'/>
                <?php echo $oBuses->cargaPantalla($oConex->codEmp, $oConex->codSuc); ?>
                <?php $aPermisosUsuario = $oPermiso->permisosGeneral(); ?>
                <button type='button' id='agregarAsientos'>Asientos</button>
            </div>
        <?php else: ?>
            <input type='hidden' id='control' value='0'/>
        <?php endif; ?>
        
    </body>
    <link href="../styles/pagina.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="../javascript/jquery-ui-1.11.2.custom/jquery-ui.min.css" />
    <script type="text/JavaScript" src="../javascript/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="../javascript/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
    <script type="text/JavaScript" src="../javascript/buses.js"></script>
    <script type="text/javascript">
        // evaluaAccesos('<?php // echo $aAccesos ?>');
    </script>
</html>