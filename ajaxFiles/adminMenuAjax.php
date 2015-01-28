<?php 
    // conexion a bases de datos
    include_once '../classes/db_conexion.php';
    include '../classes/class.conexion.php';
    include '../classes/class.adminmenu.php';
    include '../classes/class.permisos.php';
    $oConex = new Conexion;
    $oConex->sec_session_start();
    $resCheck = $oConex->login_check();
    $oAdminMenu = new AdminMenu;
    global $oRegistro;
    $oPermisos = new Permisos($oConex->userId, $oConex->permisos);
    global $objCon;

    // Parametros para almacenamiento de procesos
    $sPaginaActual = $oRegistro->obtienePaginaActual();
    $ip = $oRegistro->ObtenerIP();
    $login = $oConex->usuario;

    try {
        $sAction = $_GET["action"];
        switch ($sAction) {
            case 'list':
                // Obtenemos la cantidad total de registros
                $aData = array("COUNT(*) AS TOTAL");
                $result1 = $objCon->get("sadminmenu", null, $aData);

                global $objCon;
                // con los valores POST formar las variables con la informacion correspondiente
                if ($_POST['ESTADO'] != 0) { $objCon->where('ESTADO', $_POST['ESTADO']); }
                if ($_POST['MENUTIPO'] != 0) { $objCon->where('MENUTIPO', $_POST['MENUTIPO']); }
                $start = $_REQUEST["jtStartIndex"];
                $page = $_REQUEST["jtPageSize"];
                $objCon->where("1 LIMIT $start, $page");
                $result = $objCon->get('sadminmenu');
                // Devolvemos el valor a la grilla
                $jTableResult = array();
                $jTableResult['Result'] = "OK";
                $jTableResult['Records'] = $result;
                $jTableResult['TotalRecordCount'] = $result1[0]['TOTAL'];
                $oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, $sPaginaActual, $_GET["action"]);
                print json_encode($jTableResult);
                break;
            case 'create':
                // Crear un array para almacenar la informacion de la grilla
                $aData = array();
                foreach ($_POST as $key => $value) {
                    $aData[$key] = $value;
                }
                // Verificamos si el usuario puede almacenar
                if(strstr($oConex->permisosGeneral,"A") != false){
                    // Almacenamos la informacion del nuevo menu
                    $result = $oAdminMenu->adicionarMenu($aData);
                    if ($oConex->tipoPermisoAsignacion != null) {
                        $tipoPermisoAsignacion = $oConex->tipoPermisoAsignacion;
                        $idAsignacion = $oConex->idAsignacion;
                        $permisoAsignado = $oPermisos->ejecutaPermisoAsignado($tipoPermisoAsignacion, $idAsignacion);
                        $sPermisoPag = $_GET['pag'];
                        $sPermisoRel = $_GET['rel'];
                        $sPermisoGeneral = $oPermisos->obtienePermisosPagina($sPermisoPag, $sPermisoRel);

                        // Hacer un explode de | en la cadena obtenida
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

                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $jTableResult['Record'] = $result;
                    $oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, $sPaginaActual, $_GET["action"]);
                    print json_encode($jTableResult);
                } else {
                    $jTableResult['Result'] = "ERROR";
                    $jTableResult['Message'] = 'Usted no tiene permiso para almacenar';
                    print json_encode($jTableResult);
                }
                break;
            case 'update':
                // Crear un array para almacenar la informacion de la grilla
                $aData = array();
                $sId = $_POST['CODMENU'];
                foreach ($_POST as $key => $value) {
                    $aData[$key] = $value;
                }
                unset($aData['CODMENU']);
                
                // Verificamos si el usuario puede actualizar
                if(strstr($oConex->permisosGeneral,"M") != false){
                    // Almacenamos la informacion del nuevo menu
                    $result = $oAdminMenu->modificarMenu($aData, $sId);
                    if ($oConex->tipoPermisoAsignacion != null) {
                        $tipoPermisoAsignacion = $oConex->tipoPermisoAsignacion;
                        $idAsignacion = $oConex->idAsignacion;
                        $permisoAsignado = $oPermisos->ejecutaPermisoAsignado($tipoPermisoAsignacion, $idAsignacion);
                        $sPermisoPag = $_GET['pag'];
                        $sPermisoRel = $_GET['rel'];
                        $sPermisoGeneral = $oPermisos->obtienePermisosPagina($sPermisoPag, $sPermisoRel);

                        // Hacer un explode de | en la cadena obtenida
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
                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, $sPaginaActual, $_GET["action"]);
                    print json_encode($jTableResult);
                } else {
                    $jTableResult['Result'] = "ERROR";
                    $jTableResult['Message'] = 'Usted no tiene permiso para actualizar';
                    print json_encode($jTableResult);
                }
                break;
            case 'delete':
                $sId = $_POST['CODMENU'];

                // Verificamos si el usuario puede eliminar
                if(strstr($oConex->permisosGeneral,"B") != false){
                    // Eliminamos la informacion del menu
                    $result = $oAdminMenu->eliminarMenu($sId);
                    if ($oConex->tipoPermisoAsignacion != null) {
                        $tipoPermisoAsignacion = $oConex->tipoPermisoAsignacion;
                        $idAsignacion = $oConex->idAsignacion;
                        $permisoAsignado = $oPermisos->ejecutaPermisoAsignado($tipoPermisoAsignacion, $idAsignacion);
                        $sPermisoPag = $_GET['pag'];
                        $sPermisoRel = $_GET['rel'];
                        $sPermisoGeneral = $oPermisos->obtienePermisosPagina($sPermisoPag, $sPermisoRel);

                        // Hacer un explode de | en la cadena obtenida
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
                    //Return result to jTable
                    $jTableResult = array();
                    $jTableResult['Result'] = "OK";
                    $oRegistro->almacenamientoProceso('salehLogProcesos', $ip, $login, $sPaginaActual, $_GET["action"]);
                    print json_encode($jTableResult);
                } else {
                    $jTableResult['Result'] = "ERROR";
                    $jTableResult['Message'] = 'Usted no tiene permiso para eliminar';
                    print json_encode($jTableResult);
                }
                break;
            default:
                // nothing
                break;
        }
    }
    catch(Exception $ex)
    {
        //Return error message
        $jTableResult = array();
        $jTableResult['Result'] = "ERROR";
        $jTableResult['Message'] = $ex->getMessage();
        print json_encode($jTableResult);
    }
    
?>