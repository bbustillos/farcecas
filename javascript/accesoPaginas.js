var personal = null;
var paginas = null;
var empresa = null;
$(document).ready(function () {
    $('#accesoPaginasContenedor').jtable({
        title: 'Acceso de P&aacute;ginas',
        paging: true,
        pageSize: 20,
        multiselect: true,
        columnResizable: false,
        actions: {
            listAction: '../ajaxFiles/accesoPaginasAjax.php?action=list&jtStartIndex=0&jtPageSize=20',
            createAction: '../ajaxFiles/accesoPaginasAjax.php?action=create',
            updateAction: '../ajaxFiles/accesoPaginasAjax.php?action=update',
            deleteAction: '../ajaxFiles/accesoPaginasAjax.php?action=delete'
        },
        fields: {
            ID: {
                key: true,
                list: false
            },CODEMP: {
                title: 'Empresa',
                width: '14%'
            },CODPER: {
                title: 'Personal',
                width: '28%',
                options: cargaPersonal
            },CODPAG: {
                title: 'P&aacute;gina',
                width: '28%',
                options: cargaPaginaLista
            },PERMISOS: {
                title: 'Permisos',
                width: '14%'
            }, CAMBIA: {
                title: 'Cambia',
                width: '15%',
                type: 'checkbox',
                values: {'S':'Si','N':'No'}
            }
        }
    });

    //Load all records when page is first shown
    $('#accesoPaginasContenedor').jtable('load');

    function cargaPersonal() {
        if (personal) { //Check for cache
            return personal;
        }
        var options = [];
        $.ajax({
            url: '../ajaxFiles/selectAjax.php?o=personal',
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
        return personal = options; //Cache results and return options
    }

    function cargaPaginaLista() {
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

    function cargaEmpresa() {
        if (empresa) { //Check for cache
            return empresa;
        }
        var options = [];
        $.ajax({
            url: '../ajaxFiles/selectAjax.php?o=empresa',
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
        return empresa = options; //Cache results and return options
    }
});