var personal = null;
var paginas = null;
var tipoAsignacion = null;
$(document).ready(function () {
    $('#asignaPermisosContenedor').jtable({
        title: 'Asignaci&oacute;n de Permisos',
        paging: true,
        pageSize: 10,
        multiselect: true,
        columnResizable: false,
        actions: {
            listAction: '../ajaxFiles/asignaPermisosAjax.php?action=list',
            createAction: '../ajaxFiles/asignaPermisosAjax.php?action=create',
            updateAction: '../ajaxFiles/asignaPermisosAjax.php?action=update',
            deleteAction: '../ajaxFiles/asignaPermisosAjax.php?action=delete'
        },
        fields: {
            ASIGNACCID: {
                key: true,
                list: false
            },CODPER: {
                title: 'Personal',
                width: '28%',
                options: cargaPersonal
            },CODPAG: {
                title: 'P&aacute;gina',
                width: '28%',
                options: cargaPaginaLista
            },ASIGNACCESO: {
                title: 'Permisos',
                width: '14%'
            },TIPOASIGNACCID: {
                title: 'Asignaci&oacute;n',
                width: '14%',
                options: cargaTipoAsignacionPermiso
            }, FECHAINICIO: {
                title: 'Inicio',
                width: '15%',
                type: 'date',
                displayFormat: 'yy-mm-dd',
                sorting: false
            }, FECHAFIN: {
                title: 'Fin',
                width: '15%',
                type: 'date',
                displayFormat: 'yy-mm-dd',
                sorting: false
            }, ESTADO: {
                title: 'Estado',
                width: '15%',
                type: 'checkbox',
                values: {'0':'Inactivo','1':'Activo'}
            }
        }
    });

    //Load all records when page is first shown
    $('#asignaPermisosContenedor').jtable('load');

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

    function cargaTipoAsignacionPermiso() {
        if (tipoAsignacion) { //Check for cache
            return tipoAsignacion;
        }
        var options = [];
        $.ajax({
            url: '../ajaxFiles/selectAjax.php?o=tipoAsignacionPermiso',
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
        return tipoAsignacion = options; //Cache results and return options
    }
});