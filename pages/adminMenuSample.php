<?php 
// conexion a bases de datos
include_once '../classes/db_conexion.php';

$page = (array_key_exists('page', $_GET))?$_GET['page']:""; 
 
$limit = (array_key_exists('rows', $_GET))?$_GET['rows']:""; 
$sidx = (array_key_exists('sidx', $_GET))?$_GET['sidx']:""; 
$sord = (array_key_exists('sord', $_GET))?$_GET['sord']:""; 
if(!$sidx) $sidx =1; 
 
$count = count($objCon->get('invheader'));
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
 
// the actual query for the grid data
$aData = array("invid", "invdate", "amount", "tax", "total", "note");
$result = $objCon->get('invheader', null, $aData);
// we should set the appropriate header information. Do not forget this.
header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
// be sure to put text data in CDATA
foreach ($result as $key => $row) {
    $s .= "<row id='". $row['invid']."'>";            
    $s .= "<cell>". $row['invid']."</cell>";
    $s .= "<cell>". $row['invdate']."</cell>";
    $s .= "<cell>". $row['amount']."</cell>";
    $s .= "<cell>". $row['tax']."</cell>";
    $s .= "<cell>". $row['total']."</cell>";
    $s .= "<cell><![CDATA[". $row['note']."]]></cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>