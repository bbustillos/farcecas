var paginas = null;
var padre = null;
$(document).ready(function () {
    $('#menuAdminContenedor').jtable({
        title: 'Administraci&oacute;n de Men&uacute;s',
        paging: true,
        pageSize: 10,
        multiselect: true,
        columnResizable: false,
        actions: {
            listAction: '../ajaxFiles/adminMenuAjax.php?action=list',
            createAction: '../ajaxFiles/adminMenuAjax.php?action=create',
            updateAction: '../ajaxFiles/adminMenuAjax.php?action=update',
            deleteAction: '../ajaxFiles/adminMenuAjax.php?action=delete'
        },
        fields: {
            CODMENU: {
                key: true,
                list: false
            },MENUNOMBRE: {
                title: 'Men&uacute;',
                width: '28%'
            },CODPAG: {
                title: 'P&aacute;gina',
                width: '28%',
                options: paginaLista
            },CODMENUPADRE: {
                title: 'Padre',
                width: '14%',
                options: padreLista
            },ESTADO: {
                title: 'Estado',
                width: '10%',
                options: {'1':'Activo','2':'Inactivo'}
            },MENUTIPO: {
                title: 'Tipo',
                width: '10%',
                options: {'M':'Men&uacute;','SM':'Sub-Men&uacute;','P':'P&aacute;gina'}
            },MENUORDEN: {
                title: 'Orden',
                width: '10%'
            }
        },
        recordAdded: function(){
            padreListaReload();
            paginaListaReload();
        },
        recordUpdated: function(){
            padreListaReload();
            paginaListaReload();
        }
    });

    // Re-load records when user click 'load records' button.
    $('#LoadRecordsButton').click(function (e) {
        e.preventDefault();
        $('#menuAdminContenedor').jtable('load', {
            ESTADO: $('#ESTADO').val(),
            MENUTIPO: $('#MENUTIPO').val()
        });
    });
    //Load all records when page is first shown
    $('#LoadRecordsButton').click();

    function padreLista() {
        if (padre) { //Check for cache
            return padre;
        }
        var options = [];
        $.ajax({
            url: '../ajaxFiles/selectAjax.php?o=padre',
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function (data) {
                if (data.Result != 'OK') {
                    alert(data.Message);
                    return;
                }
                options = data.Options;
            }
        });
        return padre = options; //Cache results and return options
    }

    function padreListaReload() {
        var options = [];
        $.ajax({
            url: '../ajaxFiles/selectAjax.php?o=padre',
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function (data) {
                if (data.Result != 'OK') {
                    alert(data.Message);
                    return;
                }
                options = data.Options;
            }
        });
        return padre = options; //Cache results and return options
    }

    function paginaLista() {
        if (paginas) { //Check for cache
            return paginas;
        }
        var options = [];
        $.ajax({
            url: '../ajaxFiles/selectAjax.php?o=paginas',
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function (data) {
                if (data.Result != 'OK') {
                    alert(data.Message);
                    return;
                }
                options = data.Options;
            }
        });
        return paginas = options; //Cache results and return options
    }

    function paginaListaReload() {
        var options = [];
        $.ajax({
            url: '../ajaxFiles/selectAjax.php?o=paginas',
            type: 'POST',
            dataType: 'json',
            async: false,
            success: function (data) {
                if (data.Result != 'OK') {
                    alert(data.Message);
                    return;
                }
                options = data.Options;
            }
        });
        return paginas = options; //Cache results and return options
    }

    $('#clearFilters').click( function(){
        $('#ESTADO').val(0);
        $('#MENUTIPO').val(0);
        $('#LoadRecordsButton').click();
        
    })
});