<?php
    // conexion a bases de datos
    include_once '../classes/class.conexion.php';
    include_once '../classes/class.permisos.php';
    $oConex = new Conexion;
    $oConex->sec_session_start();
    $resCheck = $oConex->login_check();

    $oPermiso = new Permisos;
    // $aPermisosUsuario = $oPermiso->permisosGeneral();
    // print_r($aPermisosUsuario);
    // print_r($oConex);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html> 
  <head> 
    <title>jqGrid PHP Demo</title> 


    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 75%;
        }

        #content { 
            top: 150px;
            width:80%; 
            margin-left:10%; 
            height:200px; 

        }
    </style>

    <link rel="stylesheet" type="text/css" media="screen" href="../javascript/jqGrid/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../javascript/jqGrid/css/ui.jqgrid.css" />
    <script src="../javascript/jqGrid/js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="../javascript/jqGrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script src="../javascript/jqGrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function () {
            $("#list").jqGrid({
                url: "../ajaxFiles/adminMenuAjax.php",
                datatype: "json",
                mtype: "POST",
                colNames: ["Menu", "Pagina", "Padre", "Estado", "Tipo", "Orden"],
                colModel: [
                    { name: "MENUNOMBRE", width: 150, editable:true },
                    { name: "CODPAG", width:150, resizable:false, align:'left', editable:true, edittype:'select', editoptions:{dataUrl:'../ajaxFiles/selectAjax.php?o=paginas'}},
                    { name: "CODMENUPADRE", width:150, resizable:false, align:'left',editable:true, edittype:'select',editoptions:{dataUrl:'../ajaxFiles/selectAjax.php?o=padre'}},
                    { name: 'ESTADO', width: 50, editable:false, edittype:'select', formatter:'select', editoptions:{value:"1:Activo;2:Inactivo"}},
                    { name: 'MENUTIPO', width: 50, editable:true, edittype:'select', formatter:'select', editoptions:{value:"M:Menu;SM:Submenu;P:Pagina"}},
                    { name: "MENUORDEN", width: 50, editable:true, sortable: false }
                ],
                pager: "#pager",
                // rowNum: 10,
                rowList: [10, 20, 30],
                sortname: "invid",
                sortorder: "desc",
                viewrecords: true,
                gridview: true,
                autoencode: true,
                editurl:"../ajaxFiles/adminMenuAjax.php",
                caption: "Administraci&oacute;n de Men&uacute;s"
            });
            jQuery('#list').jqGrid('navGrid','#pager',
                {edit:true,add:true,del:true,search:false,cloneToTop:true},
                {closeAfterEdit:true, reloadAfterSubmit: true},
                {closeAfterAdd:true, reloadAfterSubmit: true});            
        }); 
    </script>

  </head> 
  <body>
        <h2>Administraci&oacute;n de Men&uacute;s</h2>
        <div id="content">
            <table id="list"><tr><td></td></tr></table> 
            <div id="pager"></div>
        </div>
   </body> 
</html> 