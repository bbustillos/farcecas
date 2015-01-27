$(document).ready(function() {

	var $sucursal;
	var $empresa;
	var $usuario;
	var $password;

	// Verificar campos vacios
	function verificarCampos(){
		// Variables globales
		$empresa = $('#empresa').val();
		$sucursal = $('#sucursal').val();
		$usuario = $('#usuario').val();
		$password = $('#password').val();
		if ($empresa == '') {
			var message = 'Debe seleccionar una empresa';
			mensajeAlerta(message);
			return false;
		};
		if ($sucursal == '') {
			var message = 'Debe seleccionar una sucursal';
			mensajeAlerta(message);
			return false;
		};
		if ($usuario == '') {
			var message = 'Debe ingresar un usuario';
			mensajeAlerta(message);
			return false;
		};
		if ($password == '') {
			var message = 'Debe ingresar una contrase\u00F1a';
			mensajeAlerta(message);
			return false;
		};
		return true;
	}

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

	function mensaje(message){
		$('#messageBox').text(message).fadeIn().delay(2000).fadeOut('slow');
	}

	// accion ingresar
	$('#ingresar').click(function(event) {
		$controlVacios = verificarCampos();
		if ($controlVacios == true) {
			// codificamos contrasena con sha512
			$pass512 = hex_sha512($password);
			conexion = {
				sucursal: $sucursal,
				empresa: $empresa,
				usuario: $usuario,
				p: $pass512
			}

			$.ajax({
				url: '../ajaxFiles/conexionAjax.php?accion=1',
				type: 'POST',
				dataType: 'json',
				data: conexion,
				success:function(response){
					if (response == true) {
						window.location.assign('../public/menuPrincipal.php');
					};
				}
			});
		};
	});

	// accion re ingresar
	$('#reingresar').click(function(event) {
		$controlVacios = verificarCampos();
		if ($controlVacios == true) {
			// codificamos contrasena con sha512
			$pass512 = hex_sha512($password);
			conexion = {
				sucursal: $sucursal,
				empresa: $empresa,
				usuario: $usuario,
				p: $pass512
			}
			
			$.ajax({
				url: '../ajaxFiles/conexionAjax.php?accion=1',
				type: 'POST',
				dataType: 'json',
				data: conexion,
				success:function(response){
					if (response == true) {
						window.opener.document.location.reload();self.close();
					};
				}
			});
		};
	});

});

/*function disableCtrlKeyCombination(e){
	//list all CTRL + key combinations you want to disable
	var forbiddenKeys = new Array('a', 'n', 'c', 'x', 'v', 'j', 'p');
	var key;
	var isCtrl;
	
	if(window.event){
		key = window.event.keyCode;     //IE
		if(window.event.ctrlKey)
			isCtrl = true;
		else
			isCtrl = false;
	} else {
		key = e.which;     //firefox
		if(e.ctrlKey)
			isCtrl = true;
		else
			isCtrl = false;
	}
	
	//if ctrl is pressed check if other key is in forbidenKeys array
	if(isCtrl) {
		for(i=0; i<forbiddenKeys.length; i++) {
			//case-insensitive comparation
			if(forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase()){
				alert('Key combination CTRL + ' +String.fromCharCode(key) +' has been disabled.');
				return false;
			}
		}
	}
	return true;
}*/