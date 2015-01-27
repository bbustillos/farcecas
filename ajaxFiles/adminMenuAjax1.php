<?php 
// conexion a bases de datos
include_once '../classes/db_conexion.php';
include '../classes/class.adminmenu.php';
$oAdminMenu = new AdminMenu;

$page = (array_key_exists('page', $_GET))?$_GET['page']:""; 
$limit = (array_key_exists('rows', $_GET))?$_GET['rows']:""; 
$sidx = (array_key_exists('sidx', $_GET))?$_GET['sidx']:""; 
$sord = (array_key_exists('sord', $_GET))?$_GET['sord']:"";
$oper = (array_key_exists('oper', $_POST))?$_POST['oper']:"";
// print_r($_POST); die;
if(!$sidx) $sidx =1; 
 
$count = count($objCon->get('sadminmenu'));
// calculate the total pages for the query 
if( $count > 0 && $limit > 0) { 
    $total_pages = ceil($count/$limit); 
} else { 
    $total_pages = 0; 
} 
 
// if for some reasons the requested page is greater than the total 
// set the requested page to total page 
if ($page > $total_pages) $page=$total_pages;
 
// calculate the starting position of the rows 
$start = $limit*$page - $limit;
 
// if for some reasons start position is negative set it to 0 
// typical case is that the user type 0 for the requested page 
if($start <0) $start = 0; 
// print_r($oper); die;
switch ($oper) {
    case 'edit':
        foreach ($_POST as $key => $value) {
            $aData[$key] = $value;
        }
        unset($aData['oper'], $aData['id']);
        $oAdminMenu->modificarMenu($aData, $_POST['id']);
        break;
    
    default:
        $result = $oAdminMenu->mostrarMenus();
        break;
}

if (is_array($result) && count($result)>0) {
    $sCount = count($result[0]);
    foreach ($result[0] as $key => $value) {
        $ind[] = $key;
    }
}
array_shift($ind);

$aRespuesta->page = $page;
$aRespuesta->total = $total_pages;
$aRespuesta->records = $count;
$i=0;
if(is_array($result) && count($result)>0){
    foreach($result as $row) {
        $var   = array();
        foreach($ind as $row2){
            $var[] = $row[$row2];
        }
        
        $aRespuesta->rows[$i]['id'] = $row["CODMENU"];
        $aRespuesta->rows[$i]['cell'] = $var;
        $i++;  
    }
}

echo json_encode($aRespuesta);
?>