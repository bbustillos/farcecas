// funciones jquery
$(document).ready(function() {

    // ------------------ Cargar Bus Seleccionado ------------------ //
    $('#documento').change(function() {
        $docId = $('#documento').val();
        if ($docId != "") {
            $('#tipoMovil').prop('disabled', false);
            $("#mixtoCombinacion").prop('disabled', false);
            var dataConsulta = {
                'CODBUS': $docId
            }
            $.post('../ajaxFiles/busesAjax.php?a=1', dataConsulta, function(data) {
                var aData = JSON.parse(data);
                if (aData.success == true) {
                    $('#placa').val(aData[0].PLACA);
                    $('#marca').val(aData[0].MARCA);
                    $('#modelo').val(aData[0].MODELO);
                    $('#color').val(aData[0].COLOR);
                    $('#asientos').val(aData[0].ASIENTOS);
                    $chkValue = (aData[0].CONTV=='S')?true:false; $('#contv').prop('checked', $chkValue); 
                    $('#filas').val(aData[0].FILAS);
                    $('#columnas').val(aData[0].COLUMNAS);
                    $('#pisos').val(aData[0].PISOS);
                    $('#tipoMovil').val(aData[0].TIPOBUS);
                    $chkValue = (aData[0].COMODIN=='S')?true:false; $('#comodin').prop('checked', $chkValue);
                    $('#carga').val(aData[0].CARGA);
                    $('#pseudo').val(aData[0].PSEUDO);
                    $('#obs').val(aData[0].OBS);
                    $chkValue = (aData[0].ESTADO=='A')?true:false; $('#estado').prop('checked', $chkValue);
                    $('#proyecto').val(aData[0].CODPRY);
                    $('#personal').val(aData[0].CODPRO);
                    $("#sCodEmp").val(aData[0].CODEMP);
                    $("#disenio").val(aData[0].CODIGODISENIO);
                    $("#mixtoCombinacion").val(aData[0].CODIGOCOMBINA);
                    $chkValue = (aData[0].BANIO==1)?true:false; $("#banio").prop('checked', $chkValue);
                    $chkValue = (aData[0].AIRE==1)?true:false; $("#airea").prop('checked', $chkValue);
                    $chkValue = (aData[0].CALEFACCION==1)?true:false; $("#calef").prop('checked', $chkValue);
                    $chkValue = (aData[0].ASAFATA==1)?true:false; $("#asafa").prop('checked', $chkValue);
                    $chkValue = (aData[0].GUIA==1)?true:false; $("#guiat").prop('checked', $chkValue);
                    $chkValue = (aData[0].LUZ_PERSONAL==1)?true:false; $("#luzpe").prop('checked', $chkValue);
                    $chkValue = (aData[0].AUDIFONOS==1)?true:false; $("#audif").prop('checked', $chkValue);
                    $chkValue = (aData[0].WI_FI==1)?true:false; $("#wi_fi").prop('checked', $chkValue);
                    $chkValue = (aData[0].CARGADOR_USB==1)?true:false; $("#caUSB").prop('checked', $chkValue);
                    $chkValue = (aData[0].CINTURON_SEG==1)?true:false; $("#cSegu").prop('checked', $chkValue);
                    $chkValue = (aData[0].FRAZADA==1)?true:false; $("#fraza").prop('checked', $chkValue);
                    $chkValue = (aData[0].CAFETERIA==1)?true:false; $("#cafet").prop('checked', $chkValue);
                    $chkValue = (aData[0].COMIDA==1)?true:false; $("#comid").prop('checked', $chkValue);
                } else {
                    mensajeAlerta('La informacion del bus seleccionado no existe.');
                }
            })
        } else {
            limpiaInfoBus();
        }
    })
    // End Cargar Bus Seleccionado

    // ---------------------- Pagina de Buses ------------------ //

    function habilitaDesDepDisenio(){
        if ($('#disenio').val() == 0) {
            $('#tipoMovil').prop('disabled', true);
            $("#mixtoCombinacion").prop('disabled', true);
        } else {
            if ($('#tipoMovil').val() == 5) {
                $("#combinaLabel").prop('disabled', false);
                $("#mixtoCombinacion").prop('disabled', false);
            } else {
                $("#combinaLabel").prop('disabled', true);
                $("#mixtoCombinacion").prop('disabled', true);
            }
        }
    }; habilitaDesDepDisenio();

    $('#tipoMovil').change(habilitaDesDepDisenio);

    $('#disenio').change(function(){
        // obtenemos el valor del campo mismo
        var $disenio = $('#disenio').val();
        if ($disenio != 0) {
            $('#tipoMovil').prop('disabled', false);
            var aDisenio = {
                'disenio' : $disenio
            }
            $.post('../ajaxFiles/busesAjax.php?a=8', aDisenio, function(data) {
                var aData = JSON.parse(data);
                if (aData.success == true) {
                    // obtenemos el combo
                    var $tipoMovil = $("#tipoMovil");
                    $tipoMovil.empty();
                    $tipoMovil.append("<option value=''>-- SELECCIONAR --</option>");
                    $.each(aData.data, function(index, tipoMovil) {
                        $tipoMovil.append("<option value='"+ tipoMovil.CODTIPOBUS +"'>" + tipoMovil.DESC_TIPOBUS + "</option>");
                    });
                }
            });
        } else {
            $('#tipoMovil').prop('disabled', true);
        }
    })

    // Llamar a ajax para determinar si el bus tiene asientos registrados o no
    $('#agregarAsientos').click(function(){
        var sBus = $("#documento").val();
        if (sBus != '') {
            window.open('asientoBus.php?codBus='+sBus,'Definici&oacute;n de Asientos de Bus','width=1000,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=250,top=200');
        } else {
            mensajeAlerta('Debe seleccionar un bus para ver la información de los asientos.');
        }
    })

    // Almacenamiento de informacion
    $('#Almacenar').click(function(){
        var sBus = $('documento').val();
        var sPlaca = $('#placa').val();
        var sMarca = $('#marca').val();
        var sModelo = $('#modelo').val();
        var sColor = $('#color').val();
        var sAsientos = $('#asientos').val();
        var sContv = ($('#contv').prop('checked') == true)?'S':'o';
        var sFilas = $('#filas').val();
        var sColumnas = $('#columnas').val();
        var sPisos = $('#pisos').val();
        var stipoMovil = $('#tipoMovil').val();
        var sComodin = ($('#comodin').prop('checked') == true)?'S':'o';
        var sCarga = $('#carga').val();
        var sPseudo = $('#pseudo').val();
        var sObs = $('#obs').val();
        var sEstado = ($('#estado').prop('checked') == true)?'A':'o';
        var sProyecto = $('#proyecto').val();
        var sPersonal = $('#personal').val();
        var sBus = $("#documento").val();
        var sCodEmp = $("#sCodEmp").val();
        var disenio = $("#disenio").val();
        var mixtoCombinacion = $("#mixtoCombinacion").val();
        var banio = ($("#banio").prop('checked') == false)?0:1;
        var airea = ($("#airea").prop('checked') == false)?0:1;
        var calef = ($("#calef").prop('checked') == false)?0:1;
        var asafa = ($("#asafa").prop('checked') == false)?0:1;
        var guiat = ($("#guiat").prop('checked') == false)?0:1;
        var luzpe = ($("#luzpe").prop('checked') == false)?0:1;
        var audif = ($("#audif").prop('checked') == false)?0:1;
        var wi_fi = ($("#wi_fi").prop('checked') == false)?0:1;
        var caUSB = ($("#caUSB").prop('checked') == false)?0:1;
        var cSegu = ($("#cSegu").prop('checked') == false)?0:1;
        var fraza = ($("#fraza").prop('checked') == false)?0:1;
        var cafet = ($("#cafet").prop('checked') == false)?0:1;
        var comid = ($("#comid").prop('checked') == false)?0:1;
        // Almacenar objeto con informacion de Bus
        var informacionBus = {
            'bus':sBus,
            'PLACA':sPlaca,
            'CODEMP':sCodEmp,
            'CODACTIVO':0,
            'MARCA':sMarca,
            'MODELO':sModelo,
            'COLOR':sColor,
            'ASIENTOS':sAsientos,
            'CONTV':sContv,
            'FILAS':sFilas,
            'COLUMNAS':sColumnas,
            'PISOS':sPisos,
            'TIPOBUS':stipoMovil,
            'COMODIN':sComodin,
            'CARGA':sCarga,
            'PSEUDO':sPseudo,
            'OBS':sObs,
            'ESTADO':sEstado,
            'CODPRY':sProyecto,
            'CODPRO':sPersonal,
            'CODIGODISENIO':disenio,
            'CODIGOCOMBINA':mixtoCombinacion,
            'BANIO':banio,
            'AIRE':airea,
            'CALEFACCION':calef,
            'ASAFATA':asafa,
            'GUIA':guiat,
            'LUZ_PERSONAL':luzpe,
            'AUDIFONOS':audif,
            'WI_FI':wi_fi,
            'CARGADOR_USB':caUSB,
            'CINTURON_SEG':cSegu,
            'FRAZADA':fraza,
            'CAFETERIA':cafet,
            'COMIDA':comid,
            'validador':{
                'PLACA':sPlaca
            }
        };
        if (sBus == '') {
            if (sPlaca==""||sMarca==""||sModelo==""||sColor==""||sAsientos==""||sFilas==""||sColumnas==""||stipoMovil==""||sCarga==""||sPseudo==""||sProyecto==""||sPersonal==""||disenio==""){
                mensajeAlerta('La informacion del bus no esta completa, favor verifique nuevamente.');
                return false;
            } else {
                // Almacenar nuevo bus
                $.post('../ajaxFiles/busesAjax.php?a=3', informacionBus, function(data) {
                    var aData = JSON.parse(data);
                    if (aData.success == true) {
                        mensajeAlerta('El bus se almaceno con exito. Cod Bus: ' + aData.codBus);
                        limpiaInfoBus();
                    } else {
                        var validador = aData.validador;
                        mensajeAlerta('La placa que intenta ingresar es repetida: '+validador.PLACA);
                        return false;
                    }
                });
            }
        } else {
            // Almacenar modificacion de bus si el bus ha sido seleccionado
            $.post('../ajaxFiles/busesAjax.php?a=2', informacionBus, function(data) {
                var aData = JSON.parse(data);
                if (aData.success == true) {
                    mensajeAlerta('El bus se modifico con exito.');
                    limpiaInfoBus();
                } else {
                    mensajeAlerta('Ha ocurrido un error inesperado por favor verifique el almacenamiento del bus.');
                }
            });
        }
    })

    $('#Eliminar').click(function() {
        $docId = $('#documento').val();
        if ($docId == "") {
            mensajeAlerta('Se debe seleccionar un bus para tomar esta acción.');
        } else {
            $("#dialog-confirm").css({ display: '' });
            $("#dialog-confirm").dialog({
                resizable: false,
                height:140,
                modal: true,
                buttons: {
                    "Eliminar bus": function() {
                        $(this).dialog("close");
                        var informacionBus = {
                            'bus' : $docId
                        }
                        // Eliminar la informacion del bus seleccionado
                        $.post('../ajaxFiles/busesAjax.php?a=4', informacionBus, function(data) {
                            var aData = JSON.parse(data);
                            if (aData.success == true) {
                                mensajeAlerta('El bus se eliminó con exito.');
                                limpiaInfoBus();
                            } else {
                                mensajeAlerta('Ha ocurrido un error inesperado por favor verifique el almacenamiento del bus.');
                            }
                        });
                    },
                    Cancel: function() {
                        $(this).dialog("close");
                    }
                }
            });
        }
    });

    function mensajeAlerta($sMensaje){
        $("#dialog-message").css({ display: '' });
        $sMensaje = "<p>"+$sMensaje+"</p>";
        $('#dialog-message').html($sMensaje);
        $( "#dialog-message" ).dialog({
            modal: true,
            buttons: {
                Aceptar: function() {
                    $(this).dialog("close");
                }
            }
        });
    }

    $('#almacenarAsientoBus').click(function() {
        // Obtenemos la informacion de columnas, filas, objeto y tipo
        var sBus = $("#documento").val();
        var columnas = $('#columnas').val();
        var filas = $('#filas').val();
        var objeto = $('#objetoAsiento').val();
        var tipo = $('#tipoAsiento').val();
        var acceso = $('#accesoDD').val();
        var estado = $('#estadoDD').val();
        var asientoBus = '';
        // Verificamos que el objeto no sea vacio
        if (objeto == '' && tipo == '' && acceso == '' && estado == '') {
            mensajeAlerta('Se debe seleccion el objeto antes de modificar un campo.');
        } else {
            // Recorremos mediante un for los componentes de la tabla de asientos
            for (var columna = 1; columna <= columnas; columna++) {
                for (var fila = 1; fila <= filas; fila++) {
                    var cbAsiento = '#'+columna+'_'+fila+'_cb';
                    if ($(cbAsiento).prop('checked') == true) {
                        var txDesc = '#'+columna+'_'+fila+'_des';
                        var txDes = $(txDesc).val();
                        var cbEmergencia = '#'+columna+'_'+fila+'_eme';
                        $(cbEmergencia).on('click', function(){
                            adicionaAlerta();
                        })
                        var sEmergencia = ($(cbEmergencia).prop('checked') == true)?1:0;
                        // alert(sEmergencia); return false;
                        // creac cadena de valores a almacenar
                        asientoBus += fila + '_' + columna + '_' + txDes + '_' + objeto + '_' + tipo + '_' + acceso + '_' + estado + '_' + sEmergencia + '|';
                    };
                };
            };
            // eliminamos el ultimo pipe de la cadena
            asientoBus = asientoBus.substring(0, asientoBus.length - 1);
            // Cargamos la informacion del POST
            var informacionAsientos = {
                'bus': sBus,
                'asientoBus':asientoBus
            }
            // Almacena la informacion de las celdas seleccionadas en la tabla
            $.post('../ajaxFiles/busesAjax.php?a=7', informacionAsientos, function(data) {
                var aData = JSON.parse(data);
                aData.forEach(function(data){
                    if (data) {
                        // creamos el id del objeto a modificar
                        var che = '#'+data.COLUMNA +'_'+ data.FILA +'_cb';
                        var des = '#'+data.COLUMNA +'_'+ data.FILA +'_des';
                        var obj = '#'+data.COLUMNA +'_'+ data.FILA +'_ob';
                        var tip = '#'+data.COLUMNA +'_'+ data.FILA +'_tip';
                        var acc = '#'+data.COLUMNA +'_'+ data.FILA +'_acc';
                        var eme = '#'+data.COLUMNA +'_'+ data.FILA +'_eme';
                        var est = '#'+data.COLUMNA +'_'+ data.FILA +'_est';
                        $(che).prop('checked', false);
                        $(des).text(data.DES);
                        $(obj).text(data.OBJETO);
                        $(tip).text(data.TIPOASIENTO);
                        $(acc).text(data.ACCESO);
                        $(eme).text(data.SALIDA_EMERGENCIA);
                        $(est).text(data.ESTADO);
                    };
                })
            });
        }
    })

    function adicionaAlerta(){
        alert('hola');
    }

    function limpiaInfoBus(){
        $("#documento").val('');
        $("#placa").val('');
        $("#marca").val('');
        $("#modelo").val('');
        $("#color").val('');
        $("#asientos").val('');
        $("#contv").prop('checked', false);
        $("#filas").val('');
        $("#columnas").val('');
        $("#pisos").val('');
        $("#tipoMovil").val(0);
        $("#comodin").prop('checked', false);
        $("#obs").val('');
        $("#carga").val('');
        $("#pseudo").val('');
        $("#estado").prop('checked', false);
        $("#personal").val('');
        $("#proyecto").val('');
        $("#disenio").val(0);
        $("#mixtoCombinacion").val(0);
        $("#banio").prop('checked', false);
        $("#airea").prop('checked', false);
        $("#calef").prop('checked', false);
        $("#asafa").prop('checked', false);
        $("#guiat").prop('checked', false);
        $("#luzpe").prop('checked', false);
        $("#audif").prop('checked', false);
        $("#wi_fi").prop('checked', false);
        $("#caUSB").prop('checked', false);
        $("#cSegu").prop('checked', false);
        $("#fraza").prop('checked', false);
        $("#cafet").prop('checked', false);
        $("#comid").prop('checked', false);
        $('#tipoMovil').prop('disabled', true);
        $('#mixtoCombinacion').prop('disabled', true);
        // habilitaDesDepDisenio();
    }
    
    /*$('#1_1_cont').click(function(e) {  
      alert(1);
    });*/
});