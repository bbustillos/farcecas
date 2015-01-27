<?php
// conexion a bases de datos
include_once 'db_conexion.php';

/**
* Manejo de actividades generales de conexion
*/
class Conexion
{
	public $usuario;
	public $codEmp;
	public $codSuc;
	public $password;
	public $userId;
	public $emailUsuario;
	public $loginString;
	public $permisos;
	public $permisosGeneral;
	public $tipoPermisoAsignacion;
	public $idAsignacion;
	protected static $_instance;

	public function __construct(){
		self::$_instance = $this;
	}

	public static function getInstance(){
        return self::$_instance;
    }

    public function pantallaLogin(){
    	$sLogin = "	<div id='contenedor'>
    				<div id='dialog-message' title='Informaci&oacute;n' style='display: none;'><p></p></div>
    				<ul>
						<li>
							<h2>Bienvenidos a SALEH (Identif&iacute;quese)</h2>
							<span class='campos_requeridos'>* Campos requeridos</span>
						</li>
						<li colspan='2' width='700px' align='middle'>
							<img src='../images/cabecera_r2_c3.gif' alt='lighthouse'>
						</li>
						<li>
							".$this->cargaEmpresa()." 
						</li>
						<li>
							".$this->cargarSucursal()."
						</li>
						<li>
							<label for='email'>Email:</label>
							<input type='email' name='email' id='usuario' placeholder='ejemplo@test.com' required>
							<span class='formulario_ayuda'>Ejemplo 'ejemplo@test.com'</span>
						</li>
						<li>
							<label for='password'>Contrase&ntilde;a:</label>
							<input type='password' name='password' id='password' placeholder='Contrase&ntilde;a' required>
						</li>
						<li>
							<button type='submit' id='ingresar'>Ingresar</button>
						</li>
					</ul>
				</div>";
		return $sLogin;
    }

    public function cargarSucursal(){
    	global $objCon;
		$columns = array("S.CODSUC", "S.NOMBRE", "E.CODEMP");
		$objCon->join("sempresas E", "S.CODEMP=E.CODEMP AND S.ESTADO='A'", "LEFT");
		$objCon->where("S.ESTADO", "A");
		$objCon->orderBy("S.NOMBRE");
		$aSucursal = $objCon->get("ssucursales S", null, $columns);
		// Carga dropdown de sucursal
		$sSucursal = "<label for='sucursal'>Sucursal:</label>
						<select name='sucursal' id='sucursal' required>
							<option value=''>-- Seleccionar Sucursal --</option>";
		foreach ($aSucursal as $key => $value) {
			$sSucursal .= "<option value=".$value['CODSUC'].">".$value['NOMBRE']."</option>";
		}
		$sSucursal .= "</select>";
		// Fin Carga dropdown de sucursal
		return $sSucursal;
    }

    public function cargaEmpresa(){
		global $objCon;
		$columns = array('CODEMP', 'NOMBRE');
		$objCon->where('ESTADO', 'A');
		$objCon->orderBy('NOMBRE','asc');
		$aEmpresas = $objCon->get('sempresas', null, $columns);
		// Carga dropdown de Empresas
		$sEmpresa = "<label for='empresa'>Empresa:</label>
						<select name='empresa' id='empresa' required>
							<option value=''>-- Seleccionar Empresa --</option>";
		foreach ($aEmpresas as $key => $value) {
			$sEmpresa .= "<option value=".$value['CODEMP'].">".$value['NOMBRE']."</option>";
		}
		$sEmpresa .= "</select>";
		// Fin Carga dropdown de Buses
		return $sEmpresa;
    }

    function procesaLogin(){
    	global $oRegistro;
    	// Obtenemos variables de formularios POST
	    $aVariables = $_POST;
		$this->usuario = (array_key_exists('usuario', $aVariables))?$aVariables['usuario']:'';
	    $this->codEmp = (array_key_exists('empresa', $aVariables))?$aVariables['empresa']:'';
		$this->codSuc = (array_key_exists('sucursal', $aVariables))?$aVariables['sucursal']:'';
		if (isset($aVariables['usuario'], $aVariables['p'])) {
			$sUsuario = $aVariables['usuario'];
			$sPassword = $aVariables['p'];
			$this->password = $sPassword;
			if ($this->login($sUsuario, $sPassword) == true) {
				$ip = $oRegistro->ObtenerIP();
				$login = $this->usuario;
				$oRegistro->almacenamientoProceso('salehLogAccesos', $ip, $login);
				$_SESSION['userId'] = $this->userId;
				// $this->verificaSucursal();
				// almacena sesion en base de datos
				$this->almacenaSesion();
				// Inicializa la pantalla de Sincronizacion
				return true;
				// header('Location:../pagina_inicio.php');
			} else {
				return false;
				// header('Location:../login.php?error=1');
			}
		} else {
			return -1;
			// echo 'Solicitud incorrecta';
		}
    }

    function login($email, $password){
		global $objCon;
		$columns = array('id', 'username', 'password', 'salt', 'permisos');
		$objCon->where('email',$email);
		$aUser = $objCon->get('members', null, $columns);
		$contador = count($aUser);
		if ($contador>0) {
			foreach ($aUser as $key => $user) {
				$db_password = $user['password'];
				$salt = $user['salt'];
				$user_id = $user['id'];
				$username = $user['username'];
				$password = hash('sha512', $password . $salt);
				if ($db_password == $password) {
					$user_browser = $_SERVER['HTTP_USER_AGENT'];
					$user_id = preg_replace("/[^0-9]+/", "", $user_id);
					$this->userId = $user_id;
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
					$this->emailUsuario = $email;
					$this->usuario = $username;
					$this->permisos = $user['permisos'];
					$this->loginString = hash('sha512', $password . $user_browser);
					$fechaActual = date("Y-m-d H:i:s");
					return true;
				} else {
					// La contraseña no es correcta, y se graba el intento
					$now = time();
					$data = Array ("user_id" => "$user_id", "time" => "$now");
					$id = $objCon->insert('login_attempts', $data);
					return false;
				}
			}
		} else {
			// El usuario no existe.
			return false;
		}
	}

	function login_check() {
		global $objCon;
		$objSession = $this->obtieneSesion();
		
		if (count($objSession)>0 && $objSession != false) {
			foreach ($objSession as $key => $value) {
				$this->$key = $value;
			}
		}
		if (isset($this->userId, $this->usuario, $this->loginString)) {
			$user_id = $this->userId;
			$username = $this->usuario;
			$login_string = $this->loginString;
			$user_browser = $_SERVER['HTTP_USER_AGENT'];
			$columns = array('password');
			$objCon->where('id', $user_id);
			$aUserPass = $objCon->get('members', null, $columns);
			$contador = count($aUserPass);
			if ($contador == 1) {
				foreach ($aUserPass as $key => $userPass) {
					$password = $userPass['password'];
					$login_check = hash('sha512', $password . $user_browser);
					if ($login_check == $login_string) {
						return true;
					} else {
						return false;
					}
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function sec_session_start(){
		$session_name = 'sec_session_id';
		$secure = SECURE;

		// Esto detiene a que el javascript sea capaz de acceder a la identificacion de la sesion
		$httponly = true;
		
		// Obliga a la sesion a solo manejar cookies.
		if (ini_set('session.use_only_cookies', 1) === FALSE) {
			header("Location:../error.php?err=No se puede iniciar una sesion segura");
			exit();
		}

		// Obtiene los params de las cookies actuales.
		$cookieParams = session_get_cookie_params();
		session_set_cookie_params($cookieParams["lifetime"],
			$cookieParams["path"],
			$cookieParams["domain"],
			$secure,
			$httponly);

		// Configura el nombre de sesion al configurado arriba.
		session_name($session_name);
		session_start();
		session_regenerate_id();
	}

    function almacenaSesion(){
		global $objCon;
		$user_id = $this->userId;
		$aData = array('session_obj'=>serialize($this));
		$objCon->where('id', $user_id);
		$resp = $objCon->update('members', $aData);

	}

	function obtieneSesion(){
		global $objCon;
		if (isset($_SESSION['userId'])) {
			$user_id = $_SESSION['userId'];
		} else {
			$user_id = "";
		}
		if ($user_id != "") {
			$columns = array('session_obj');
			$objCon->where('id', $user_id);
			$aSession = $objCon->get('members', 1, $columns);
			if (count($aSession)>0) {
				foreach ($aSession as $key => $sSession) {
					$objSession = unserialize($sSession['session_obj']);
				}
				return $objSession;
			}
		} else {
			return false;
		}
	}

	function reiniciar(){
		$link = "<script>window.open('../public/reconectar.php','Sesion perdida','width=600,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=300,top=200');</script>";
		echo $link;
	}

	function reiniciarWindow(){
		// Mostrara la informacion para el inicio de sesion
		$sTable = "<div id='contenedor'>
    				<div id='dialog-message' title='Informaci&oacute;n' style='display: none;'><p></p></div>
    				<ul>
						<li>
							<h2>Identif&iacute;quese nuevamente a SALEH</h2>
							<span class='campos_requeridos'>* Campos requeridos</span>
						</li>
						<li colspan='2' width='700px' align='middle'>
							<img src='../images/cabecera_r2_c3.gif' alt='lighthouse'>
						</li>
						<li>
							".$this->cargaEmpresa()." 
						</li>
						<li>
							".$this->cargarSucursal()."
						</li>
						<li>
							<label for='email'>Email:</label>
							<input type='email' name='email' id='usuario' placeholder='ejemplo@test.com' required>
							<span class='formulario_ayuda'>Ejemplo 'ejemplo@test.com'</span>
						</li>
						<li>
							<label for='password'>Contrase&ntilde;a:</label>
							<input type='password' name='password' id='password' placeholder='Contrase&ntilde;a' required>
						</li>
						<li>
							<button type='submit' id='reingresar'>Ingresar</button>
						</li>
					</ul>
				</div>";
		echo $sTable;
	}
}