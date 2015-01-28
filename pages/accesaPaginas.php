<?php
    // conexion a bases de datos
    include_once '../classes/class.conexion.php';
    include_once '../classes/class.permisos.php';
    include_once '../classes/class.accesoPaginas.php';
    // Manejo de Sesion y Conexion a Base de Datos
    $oConex = new Conexion;
    $oConex->sec_session_start();
    $resCheck = $oConex->login_check();
    // Manejo de asignacion de permisos
    $oPermiso = new Permisos($oConex->userId, $oConex->permisos);
    $oAccessoPaginas = new AccessoPaginas;

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
        // si existe el valor 2 significaria el tipo de asignacion que se le otorgo al usuario
        // el mismo se deberia almacenar en el objeto conexion para tenerlo en todo lado
        $oConex->almacenaSesion();
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html> 
  <head> 
    <title>Acceso a P&aacute;ginas</title> 
    <link rel="stylesheet" type="text/css" href="../styles/adminMenu.css">
    <!-- Include one of jTable styles. -->
    <link href="../javascript/jtable/themes/metro/blue/jtable.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="../javascript/jquery-ui-1.11.2.custom/jquery-ui.min.css" />
    <!-- Include jTable script file. -->
    <script src="../javascript/jqGrid/js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../javascript/jquery-ui-1.11.2/jquery-ui.js" type="text/javascript"></script>
    <script src="../javascript/jtable/jquery.jtable.min.js" type="text/javascript"></script>
    <script src="../javascript/accesoPaginas.js" type="text/javascript"></script>
  </head> 
  <body>
        <?php echo $oAccessoPaginas->cargarAccesoPaginas(); ?>
   </body> 
</html> 