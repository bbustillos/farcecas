var aPermisos;

/**
 * Permite validaro los campos de Login
 * @param  {object} form
 * @param  {string} password
 * @return {submit}
 */
function formhash(form, password) {
    if(form.usuario.value == ""){ 
        alert("Debe ingresar un nombre de usuario.");
        form.usuario.focus();
        return false;
    }

    if(form.password.value == ""){ 
        alert("Debe ingresar su clave de acceso.");
        form.password.focus();
        return false;
    }

    if(form.empresa.value == ""){ 
        alert("Debe seleccionar una empresa.");
        form.empresa.focus();
        return false;
    }

    if(form.sucursal.value == ""){ 
        alert("Debe seleccionar una sucursal.");
        form.sucursal.focus();
        return false;
    }

    // Crea una entrada de elemento nuevo, esta será nuestro campo de contraseña con hash.
    var p = document.createElement("input");

    // Agrega el elemento nuevo a nuestro formulario.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Se asegura de que la contraseña en texto simple no se envíe.
    password.value = "";

    // Finalmente envía el formulario.
    form.submit();
}

/**
 * Permite ocultar un campo de un formulario
 * @param  {string} campo
 * @param  {integer} valor
 * @return {nothing}
 */
function ocultarMostrar(campo, valor){
    if (valor == 1) {
        document.getElementById(campo).style.visibility = 'visible';
    } else {
        document.getElementById(campo).style.visibility = 'hidden';
    }
}

/**
 * (Especifica) Permite determinar segun la cadena sAccesos que botones estan visibles
 * @param  {string} sAccesos
 * @return {nothing}
 */
function evaluaAccesos(sAccesos){
    aAccesos = sAccesos.split('__');
    ocultarMostrar('almacenar', aAccesos[0]);
    ocultarMostrar('eliminar', aAccesos[1]);
    ocultarMostrar('modificar', aAccesos[2]);
    ocultarMostrar('ver', aAccesos[3]);
}

/**
 * (Especifica) Permite ejecutar una funcion mediante Ajax 
 * para obtener la informacion del bus solicitado como parametro
 * @param  {integer} cod
 * @return {array (informacion del bus)}
 */
function mostrarInfoBuses(cod) {
    if (cod != "") {
        // Carga informacion de la variable
        var data = "CODBUS=" + cod;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var obj = eval("(function(){return " + xmlhttp.responseText + ";})()");
                document.getElementById("placa").value = obj.sPLACA;
                document.getElementById("marca").value = obj.sMARCA;
                document.getElementById("modelo").value = obj.iMODELO;
                document.getElementById("color").value = obj.sCOLOR;
                document.getElementById("asientos").value = obj.iASIENTOS;
                document.getElementById("contv").checked = (obj.sCONTV == 'S') ? true : false;
                document.getElementById("filas").value = obj.sFILAS;
                document.getElementById("columnas").value = obj.iCOLUMNAS;
                document.getElementById("pisos").value = obj.PISOS;
                document.getElementById("tipoMovil").value = obj.sTIPOBUS;
                document.getElementById("comodin").checked = (obj.sCOMODIN == 'S') ? true : false;
                document.getElementById("obs").value = obj.sOBS;
                document.getElementById("carga").value = obj.iCARGA;
                document.getElementById("pseudo").value = obj.sPSEUDO;
                document.getElementById("estado").checked = (obj.sESTADO == 'A') ? true : false;
                document.getElementById("personal").value = obj.iCODPRO;
                document.getElementById("proyecto").value = obj.iCODPRY;
                document.getElementById("disenio").value = (obj.CODIGODISENIO == 0)?1:0;
                document.getElementById("mixtoCombinacion").value = (obj.CODIGOCOMBINA == 0)?1:0;
                document.getElementById("banio").checked = (obj.BANIO == 1) ? true : false;
                document.getElementById("airea").checked = (obj.AIRE == 1) ? true : false;
                document.getElementById("calef").checked = (obj.CALEFACCION == 1) ? true : false;
                document.getElementById("asafa").checked = (obj.ASAFATA == 1) ? true : false;
                document.getElementById("guiat").checked = (obj.GUIA == 1) ? true : false;
                document.getElementById("luzpe").checked = (obj.LUZ_PERSONAL == 1) ? true : false;
                document.getElementById("audif").checked = (obj.AUDIFONOS == 1) ? true : false;
                document.getElementById("wi_fi").checked = (obj.WI_FI == 1) ? true : false;
                document.getElementById("caUSB").checked = (obj.CARGADOR_USB == 1) ? true : false;
                document.getElementById("cSegu").checked = (obj.CINTURON_SEG == 1) ? true : false;
                document.getElementById("fraza").checked = (obj.FRAZADA == 1) ? true : false;
                document.getElementById("cafet").checked = (obj.CAFETERIA == 1) ? true : false;
                document.getElementById("comid").checked = (obj.COMIDA == 1) ? true : false;
            }
        }

        xmlhttp.open("POST", "../ajaxFiles/busesAjax.php?a=1", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
        xmlhttp.send(data);
    } else {
        limpiaInfoBus();
    }
}

/**
 * Permite la limpieza de la informacion del bus
 * @return {nothing}
 */
function limpiaInfoBus(){
    document.getElementById("placa").value = '';
    document.getElementById("marca").value = '';
    document.getElementById("modelo").value = '';
    document.getElementById("color").value = '';
    document.getElementById("asientos").value = '';
    document.getElementById("contv").checked = false;
    document.getElementById("filas").value = '';
    document.getElementById("columnas").value = '';
    document.getElementById("pisos").value = '';
    document.getElementById("tipoMovil").selectedIndex = '';
    document.getElementById("comodin").checked = false;
    document.getElementById("obs").value = '';
    document.getElementById("carga").value = '';
    document.getElementById("pseudo").value = '';
    document.getElementById("estado").checked = false;
    document.getElementById("personal").selectedIndex = '';
    document.getElementById("proyecto").selectedIndex = '';
    document.getElementById("disenio").selectedIndex = '';
    document.getElementById("mixtoCombinacion").selectedIndex = '';
    document.getElementById("banio").checked = false;
    document.getElementById("airea").checked = false;
    document.getElementById("calef").checked = false;
    document.getElementById("asafa").checked = false;
    document.getElementById("guiat").checked = false;
    document.getElementById("luzpe").checked = false;
    document.getElementById("audif").checked = false;
    document.getElementById("wi_fi").checked = false;
    document.getElementById("caUSB").checked = false;
    document.getElementById("cSegu").checked = false;
    document.getElementById("fraza").checked = false;
    document.getElementById("cafet").checked = false;
    document.getElementById("comid").checked = false;
}

/**
 * (Especifica) Permite almacenar la modificacion de la informacion de un bus
 * @return {nothing}
 */
function modificarInfoBuses(){
    // Obtener los valores de los campos
    var sBus = document.getElementById('documento').value;
    var sPlaca = document.getElementById('placa').value;
    var sMarca = document.getElementById('marca').value;
    var sModelo = document.getElementById('modelo').value;
    var sColor = document.getElementById('color').value;
    var sAsientos = document.getElementById('asientos').value;
    var sContv = document.getElementById('contv').value;
    var sFilas = document.getElementById('filas').value;
    var sColumnas = document.getElementById('columnas').value;
    var stipoMovil = document.getElementById('tipoMovil').value;
    var sComodin = document.getElementById('comodin').value;
    var sCarga = document.getElementById('carga').value;
    var sPseudo = document.getElementById('pseudo').value;
    var sObs = document.getElementById('obs').value;
    var sEstado = document.getElementById('estado').value;
    var sPersonal = document.getElementById('personal').value;
    var sProyecto = document.getElementById('proyecto').value;
    var disenio = document.getElementById("disenio").selectedIndex;
    var mixtoCombinacion = document.getElementById("mixtoCombinacion").selectedIndex;
    var banio = document.getElementById("banio").value;
    var airea = document.getElementById("airea").value;
    var calef = document.getElementById("calef").value;
    var asafa = document.getElementById("asafa").value;
    var guiat = document.getElementById("guiat").value;
    var luzpe = document.getElementById("luzpe").value;
    var audif = document.getElementById("audif").value;
    var wi_fi = document.getElementById("wi_fi").value;
    var caUSB = document.getElementById("caUSB").value;
    var cSegu = document.getElementById("cSegu").value;
    var fraza = document.getElementById("fraza").value;
    var cafet = document.getElementById("cafet").value;
    var comid = document.getElementById("comid").value;
    // Almcenamiendo de variaable formulario
    var miFormulario = "bus="+sBus+"&PLACA="+sPlaca+"&MARCA="+sMarca+"&MODELO="+sModelo+"&COLOR="+sColor+"&ASIENTOS="+sAsientos
        +"&CONTV="+sContv+"&FILAS="+sFilas+"&COLUMNAS="+sColumnas+"&TIPOBUS="+stipoMovil+"&COMODIN="+sComodin+"&CARGA="+sCarga
        +"&PSEUDO="+sPseudo+"&OBS="+sObs+"&ESTADO="+sEstado+"&CODPRY="+sProyecto+'&CODIGODISENIO='+disenio
        +'&CODIGOCOMBINA='+mixtoCombinacion+"&BANIO="+banio+"&AIRE="+airea+"&CALEFACCION="+calef
        +"&ASAFATA="+asafa+"&GUIA="+guiat+"&LUZ_PERSONAL="+luzpe+"&AUDIFONOS="+audif+"&WI_FI="+wi_fi+"&CARGADOR_USB="+caUSB
        +"&CINTURON_SEG="+cSegu+"&FRAZADA="+fraza+"&CAFETERIA="+cafet+"&COMIDA="+comid;
    var sBus = document.getElementById('documento').value;
    // Se almacena la informacion relacionada alfd bus seleccionado
    if (sBus != '') {
        // Carga informacion de la variable
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                alert('La información fue almacenada correctamente');
            }
        }

        xmlhttp.open("POST", "../ajaxFiles/busesAjax.php?a=2", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                    
        xmlhttp.send(miFormulario);
    } else {
        // Se almacena la informacion de un nuevo bus
        AlmacenaBus();
        // almacenaBus();
    }
}

function AlmacenaBus(){
    // Obtener los valores de los campos
    var sPlaca = document.getElementById('placa').value;
    var sMarca = document.getElementById('marca').value;
    var sModelo = document.getElementById('modelo').value;
    var sColor = document.getElementById('color').value;
    var sAsientos = document.getElementById('asientos').value;
    var sContv = document.getElementById('contv').value;
    var sFilas = document.getElementById('filas').value;
    var sColumnas = document.getElementById('columnas').value;
    var stipoMovil = document.getElementById('tipoMovil').value;
    var sComodin = document.getElementById('comodin').value;
    var sCarga = document.getElementById('carga').value;
    var sPseudo = document.getElementById('pseudo').value;
    var sObs = document.getElementById('obs').value;
    var sEstado = document.getElementById('estado').value;
    var sPersonal = document.getElementById('personal').value;
    var sProyecto = document.getElementById('proyecto').value;
    if (sPlaca==""||sMarca==""||sModelo==""||sColor==""||sAsientos==""||sFilas==""||sColumnas==""||stipoMovil==""||sCarga==""||sPseudo==""||sProyecto==""||sPersonal==""){
        alert('La informacion del bus no esta completa, favor verifique nuevamente');
        return false;
    } else {
        var miFormulario = "PLACA="+sPlaca+"&MARCA="+sMarca+"&MODELO="+sModelo+"&COLOR="+sColor+"&ASIENTOS="+sAsientos+"&CONTV="+sContv+"&FILAS="+sFilas+"&COLUMNAS="+sColumnas+"&TIPOBUS="+stipoMovil+"&COMODIN="+sComodin+"&CARGA="+sCarga+"&PSEUDO="+sPseudo+"&OBS="+sObs+"&ESTADO="+sEstado+"&CODPRY="+sProyecto+"&CODPRO="+sPersonal;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var obj = eval("(function(){return " + xmlhttp.responseText + ";})()");
            } else {
                return false;
            }
        }

        xmlhttp.open("POST", "../ajaxFiles/busesAjax.php?a=3", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(miFormulario);
    }
}

/**
 * (Especifica) Permite controlar que la informacion este llena para almacenar un bus
 * @return {true / false}
 */
function validaBuses(){
    
}

/**
 * Muestra un popup de las conexiones activas (modificar nombre de archivo sincronizacion.php a conexionesActivas.php)
 * @return {nothing}
 */
function sincronizarBuses(){
    // Carga informacion de la variable
    window.open('../paginas/sincronizacion.php','Sincronizaci&oacute;n','width=450,height=350,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=300,top=300');
}

/**
 * (Especifica) Permite ejecutar una consulta ajax para obtener 
 * la informacion de las conexiones activas a traves de la tabla de verificaciones
 * @return {obj / false}
 */
function conexionesActivasBoton(){
    document.getElementById('bloquea').style.display = 'block';
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById('bloquea').style.display = 'none';
            var obj = eval("(function(){return " + xmlhttp.responseText + ";})()");
            for (var i = 0; i < obj.totalConexiones; i++) {
                var campo = obj[i].HOSTIP;
                document.getElementById(campo).checked = (obj[i].ESTADO == 1)?true:false;
                document.getElementById(campo).disabled = (obj[i].ESTADO == 1)?false:true;
                document.getElementById(campo+'_BD').innerHTML = (obj[i].ESTADO == 1)?'Activo':'Inactivo';
                document.getElementById(campo+'_BD').style.color = (obj[i].ESTADO == 1)?'green':'red';
            }
        } else {
            return false;
        }
    }

    xmlhttp.open("POST", "../ajaxFiles/busesAjax.php?a=5", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(1);
}

/**
 * (Especifica) Permite ejecutar una consulta ajax 
 * para obtener la informacion de una conexion activa en especifico
 * @param  {string} campo
 * @return {obj / false}
 */
function conexionActivaBoton(campo){
    document.getElementById('bloquea').style.display = 'block';
    var data = "CAMPO=" + campo;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById('bloquea').style.display = 'none';
            var obj = eval("(function(){return " + xmlhttp.responseText + ";})()");
            for (var i = 0; i < obj.totalConexiones; i++) {
                var campo = obj[i].HOSTIP;
                document.getElementById(campo).checked = (obj[i].ESTADO == 1)?true:false;
                document.getElementById(campo).disabled = (obj[i].ESTADO == 1)?false:true;
                document.getElementById(campo+'_BD').innerHTML = (obj[i].ESTADO == 1)?'Activo':'Inactivo';
                document.getElementById(campo+'_BD').style.color = (obj[i].ESTADO == 1)?'green':'red';
            }
        } else {
            return false;
        }
    }

    xmlhttp.open("POST", "../ajaxFiles/busesAjax.php?a=6", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(data);
}

/**
 * Muestra un popup de almacenamiento de informacion de un nuevo campo
 * @return {nothing}
 */
function almacenarNuevoCampo(columnaNueva, tabla){
    // Carga informacion de la variable
    
    window.open('../paginas/actualizarCampo.php?col='+columnaNueva+'&tab='+tabla,'Actualizar nuevo campo','width=450,height=250,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=300,top=300');
}

/**
 * Permite el almacenamiento del campo o modificacion a la tabla relacionada
 * en tiempo real de ejecucion
 * @return {string}
 */
function almacenarCampoCC(){
    // Verificar que todos los campos esten llenos
    var nombreCampo = document.getElementById('nombreCampo').value;
    var nombreTabla = document.getElementById('nombreTabla').value;
    var tipoCampo = document.getElementById('tipoCampo').value;
    var longitudCampo = document.getElementById('longitudCampo').value;
    var permiteNulo = (document.getElementById('permiteNulo').checked == true)?1:0;
    // Si alguno de los campos esta vacio no permitir el almacenamiento
    if (nombreCampo == "" || nombreTabla == "" || tipoCampo == "" || longitudCampo == "") {
        alert("Todos los campos deben ser llenados, por favor verifique e intente nuevamente.");
    } else {
        // Llamar al ajax especifico del ALTER TABLE
        var data = "nc=" + nombreCampo + "&nt=" + nombreTabla + "&tc=" + tipoCampo + "&lc=" + longitudCampo + "&pn=" + permiteNulo;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                window.opener.document.location.reload();self.close();
            } else {
                return false;
            }
        }

        xmlhttp.open("POST", "../ajaxFiles/generalAjax.php?a=2", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(data);
    }
}

// funciones jquery
$(document).ready(function() {


    // ------------------ Cargar Bus Seleccionado ------------------ //
    $('#documento').change(function() {
        $docId = $('#documento').val();
        if ($docId != "") {
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
                    alert('La informacion del bus seleccionado no existe');
                }
            })
        } else {
            limpiaInfoBus();
        }
    })
    // End Cargar Bus Seleccionado

    // ------------------ Integridad de Datos -------------------- //
    $('#ejecutar').click(function(){
        var consulta = 'SELECT NOMBRE, APELLIDO, MATERNO, EDAD, DIRECCION, TELEFONO FROM spruebaeje WHERE 1';
        var dataConsulta = {
            'cons': consulta
        }
        $.post('../ajaxFiles/generalAjax.php?a=1', dataConsulta, function(data) {
            var aData = JSON.parse(data);
            if (aData.success == true) {
                // Modificar el campo y volver a la pagina padre
                alert(aData.data.toSource());
            } else {
                var errorNro = aData.errno;
                switch(errorNro){
                    case 1054:
                        alert(aData.error);
                        // Obtener el nombre de la columna faltante
                        var error = aData.error;
                        var inicioNuevoCampo = error.search(" '") + 2;
                        var finNuevoCampo = error.search("' ");
                        var columnaNueva = error.substring(inicioNuevoCampo, finNuevoCampo);
                        // Obtener el nombre de la tabla
                        var posicionIniFrom = consulta.search("FROM ") + 6;
                        var posicionFinFrom = posicionIniFrom + 1;
                        var posicion = consulta.substring(posicionFinFrom, posicionFinFrom+1);
                        while (posicion != " "){
                            var posicion = consulta.substring(posicionFinFrom, posicionFinFrom+1);
                            var tabla = consulta.substring(posicionIniFrom, posicionFinFrom);
                            posicionFinFrom++;
                        }
                        almacenarNuevoCampo(columnaNueva, tabla);
                        break;
                    default:
                    break;
                }
            }
        });
    })

    // ---------------------- Pagina de Buses ------------------ //

    if ($('#tipoMovil').val() == 5) {
        $("#combinaLabel").css("display", "");
        $("#mixtoCombinacion").css("display", "");
    } else{
        $("#combinaLabel").css("display", "none");
        $("#mixtoCombinacion").css("display", "none");
    }

    $('#tipoMovil').change(function(){
        if ($('#tipoMovil').val() == 5) {
            $("#combinaLabel").css("display", "");
            $("#mixtoCombinacion").css("display", "");
        } else{
            $("#combinaLabel").css("display", "none");
            $("#mixtoCombinacion").css("display", "none");
        }
    })

    $('#disenio').change(function(){
        // obtenemos el valor del campo mismo
        var disenio = $('#disenio').val();
        var aDisenio = {
            'disenio' : disenio
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
            } else {
                alert('Ha ocurrido un error inesperado por favor verifique la carga del diseño.')
            }
        });
    })

    // Llamar a ajax para determinar si el bus tiene asientos registrados o no
    $('#agregarAsientos').click(function(){
        var sBus = $("#documento").val();
        if (sBus != '') {
            window.open('asientoBus.php?codBus='+sBus,'Definici&oacute;n de Asientos de Bus','width=1000,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=250,top=200');
        };
    })

    // Almacenamiento de informacion
    $('#almacenar').click(function(){
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
                alert('La informacion del bus no esta completa, favor verifique nuevamente');
                return false;
            } else {
                // Almacenar nuevo bus
                $.post('../ajaxFiles/busesAjax.php?a=3', informacionBus, function(data) {
                    var aData = JSON.parse(data);
                    if (aData.success == true) {
                        alert('El bus se almaceno con exito. Cod Bus: ' + aData.codBus);
                        limpiaInfoBus();
                    } else {
                        var validador = aData.validador;
                        alert('La placa que intenta ingresar es repetida: '+validador.PLACA);
                        return false;
                    }
                });
            }
        } else {
            // Almacenar modificacion de bus si el bus ha sido seleccionado
            $.post('../ajaxFiles/busesAjax.php?a=2', informacionBus, function(data) {
                var aData = JSON.parse(data);
                if (aData.success == true) {
                    alert('El bus se modifico con exito.');
                } else {
                    alert('Ha ocurrido un error inesperado por favor verifique el almacenamiento del bus.')
                }
            });
        }
    })

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
            alert('Se debe seleccion el objeto antes de modificar un campo');
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
});