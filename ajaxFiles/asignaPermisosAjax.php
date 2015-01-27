<?php 
    // conexion a bases de datos
    include_once '../classes/db_conexion.php';
    include_once '../classes/class.conexion.php';
    include_once '../classes/class.asignaPermisos.php';
    include_once '../classes/class.permisos.php';
    $oConex = new Conexion;
    $oConex->sec_session_start();
    $resCheck = $oConex->login_check();
    $oAsignaPermisos = new AsignaPermisos;
    global $oRegistro;
    $oPermisos = new Permisos($oConex->userId, $oConex->permisos);

    // Parametros para almacenamiento de procesos
    $sPaginaActual = $oRegistro->obtienePaginaActual();
    $ip = $oRegistro->ObtenerIP();
    $login = $oConex->usuario;

    try {
        $sAction = $_GET["action"];
        switch ($sAction) {
            case 'list':
                // Obtener la informacion con filtros
                $result = $oAsignaPermisos->mostrarPermisos();
                // Devolvemos el valor a la grilla
                $jTableResult = array();
                $jTableResult['Result'] = "OK";
                $jTableResult['Records'] = $result;
                $jTableResult['TotalRecordCount'] = count($result);
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
                    $result = $oAsignaPermisos->adicionarPermiso($aData);
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
                $sId = $_POST['ASIGNACCID'];
                foreach ($_POST as $key => $value) {
                    $aData[$key] = $value;
                }
                unset($aData['ASIGNACCID']);
                
                // Verificamos si el usuario puede actualizar
                if(strstr($oConex->permisosGeneral,"M") != false){
                    // Almacenamos la informacion del nuevo menu
                    $result = $oAsignaPermisos->modificarPermiso($aData, $sId);
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
                $sId = $_POST['ASIGNACCID'];

                // Verificamos si el usuario puede eliminar
                if(strstr($oConex->permisosGeneral,"B") != false){
                    // Eliminamos la informacion del menu
                    $result = $oAsignaPermisos->eliminarPermiso($sId);
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