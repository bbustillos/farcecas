<?php
    // conexion a bases de datos
    include_once '../classes/class.conexion.php';
    include_once '../classes/class.permisos.php';
    include_once '../classes/class.adminmenu.php';
    $oConex = new Conexion;
    $oConex->sec_session_start();
    $resCheck = $oConex->login_check();
    $oPermiso = new Permisos($oConex->userId, $oConex->permisos);
    $oAdminMenu = new AdminMenu;

    $aPermisosUsuario = $oPermiso->permisosGeneral('grilla');
    if (!$aPermisosUsuario) {
        $sPermisoPag = $_GET['pag'];
        $sPermisoRel = $_GET['rel'];
        $sPermisoGeneral = $oPermiso->obtienePermisosPagina($sPermisoPag, $sPermisoRel);
        if (is_array($sPermisoGeneral)) {
            $oConex->idAsignacion = $sPermisoGeneral[0]['ASIGNACCID'];
            $oConex->permisosGeneral = $sPermisoGeneral[0]['ASIGNACCESO'];
            $oConex->tipoPermisoAsignacion = $sPermisoGeneral[0]['TIPOASIGNACCID'];
        } else {
            $oConex->idAsignacion = null;
            $oConex->permisosGeneral = $sPermisoGeneral;
            $oConex->tipoPermisoAsignacion = null;
        }
        $oConex->almacenaSesion();
    }
    // print_r($oConex);die;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html> 
  <head> 
    <title>Administraci&oacute;n de Men&uacute;s</title> 
    <link rel="stylesheet" type="text/css" href="../styles/adminMenu.css">
    <!-- Include one of jTable styles. -->
    <link href="../javascript/jtable/themes/metro/blue/jtable.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="../javascript/jquery-ui-1.11.2.custom/jquery-ui.min.css" />
    <!-- Include jTable script file. -->
    <script src="../javascript/jqGrid/js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../javascript/jquery-ui-1.11.2/jquery-ui.js" type="text/javascript"></script>
    <script src="../javascript/jtable/jquery.jtable.min.js" type="text/javascript"></script>
    <script src="../javascript/adminMenu.js" type="text/javascript"></script>
  </head> 
  <body>
        <?php echo $oAdminMenu->cargarMenus(); ?>
   </body> 
</html> 