<?php
// conexion a bases de datos
include_once 'db_conexion.php';
include_once 'class.asignaPermisos.php';

/**
* Permite controlar los permisos generales como
* Print Screen, Control + P, Menu para imprimir y guardar paginas
* Tambien controlar las opciones de ABM de un usuario
* y Por ultimo cargar la informacion permitida en un menu dinamico
*/
class Permisos
{
	private $userId;
	private $sPermisos;
	function __construct($usrId, $permisos){
		$this->userId = $usrId;
		$this->sPermisos = $permisos;
	}

	function leerPermisosUsuario(){
		global $objCon;
		$userId = $_SESSION['userId'];
		$aData = array("permisos");
		$objCon->where('id', $userId);
		$aPermisosUsuario = $objCon->get("members", null, $aData);
		if (is_array($aPermisosUsuario) && count($aPermisosUsuario)>0) {
			foreach ($aPermisosUsuario as $key => $permisoUsuario) {
				$sPermisosUsuario = $permisoUsuario['permisos'];
			}
			return $sPermisosUsuario;
		} else {
			return false;
		}
	}

	function leerPermisosPagina($paginaNombre){
		global $objCon;
		$aData = array("PROCESOS");
		$objCon->where("NOMBRE", $paginaNombre);
		$aPermisosPagina = $objCon->get("spaginas", null, $aData);
		if (is_array($aPermisosPagina) && count($aPermisosPagina)>0) {
			return $aPermisosPagina;
		} else {
			return false;
		}
	}

	function crearBotonPermiso($permisoCodigo){
		global $objCon;
		$aData = array("CODIGO", "ETIQUETA");
		$objCon->where("CODIGO", $permisoCodigo);
		$aEtiqueta = $objCon->get("spermisos", null, $aData);
		if (is_array($aEtiqueta) && count($aEtiqueta)>0) {
			foreach ($aEtiqueta as $key => $etiqueta) {
				switch ($etiqueta["CODIGO"]) {
					case 'P':
						$aDesabilitaPScreen = $this->deshabilitarPrintScreen();
						return $aDesabilitaPScreen;
						break;
					case 'C':
						$aDesabilitaMenuContextual = $this->deshabilitaMenuContextual();
						return $aDesabilitaMenuContextual;
						break;
					case 'T':
						$aDesabilitaControlP = $this->deshabilitaCtrlP();
						return $aDesabilitaControlP;
						break;
					case 'E':
						$aDesabilitaBarraMenu = $this->deshabilitaBarraMenu();
						return $aDesabilitaBarraMenu;
						break;
					default:
						if ($etiqueta['ETIQUETA'] != 'implicito') {
							$sBoton = "<button type='button' id='".$etiqueta['ETIQUETA']."'>".$etiqueta['ETIQUETA']."</button>";
							return $sBoton;
						}
						break;
				}
			}
		}
	}

	function permisosGeneral($paginaNombre=null){
		// si es diferente a menu solo se toman los permisos del usuario
		if ($paginaNombre != 'menu' && $paginaNombre != 'grilla') {
			$this->permisoUsuarioPagina();
		} else {
			return false;
		}
	}

	function permisoUsuarioPagina(){
		global $objCon;
		// Leer los permisos del usuario
		$sPermisoUsuario = $this->leerPermisosUsuario();
		// Leer los permisos de la pagina
		// Hacer un match de los permisos del usuario y de la pagina
		if ($sPermisoUsuario != false) {
			// Obtenemos los codigos de la tabla spermisos
			$aData = array("CODIGO, ETIQUETA");
			// Verificacion de permisos en los obtenidos por el usuario
			$aPermisos = $objCon->get("spermisos", null, $aData);
			foreach ($aPermisos as $key => $permiso) {
				if (strstr($sPermisoUsuario, $permiso["CODIGO"])) {
					echo $sResp = $this->crearBotonPermiso($permiso["CODIGO"]);
				}
			}
		}
	}

	function menuPrincipal(){
		global $objCon;
		// Seleccionamos los ids, menus tipo 'M' ordenados por 'MENUORDEN' ASC
		$aMenu = $this->obtieneMenu(null, 'M');
		if ($aMenu) {
			$sMenuPrincipal = "<div>
			<div id='menu'>
				<ul>";
			foreach ($aMenu as $key => $menu) {
				// Creamos el menu principal
				if ($menu['NOMBRE'] == "") {
					$sMenuPrincipal .= "<li class='nivel1 primera'><a href='#' class='nivel1'>".$menu['MENUNOMBRE']." ></a>";
					// Segun el ID seleccionar el ids, menu tipo 'SM' donde el menu padre sea el anterior tipo 'M'
					$aSubMenu = $this->obtieneMenu($menu['CODMENU'], 'SM');
					if ($aSubMenu != false) {
						// Creamos el submenu
						$sMenuPrincipal .= "<ul class='nivel2'>";
						foreach ($aSubMenu as $key => $subMenu) {
							if ($subMenu['NOMBRE'] == "") {
								$sMenuPrincipal .= "<li class='primera'><a href='#' class='nivel1'>".$subMenu['MENUNOMBRE']." ></a>";
								// Segun el ID seleccionar el ids, menu tipo 'P' donde el menu padre sea el anterior tipo 'SM'
								$aPagina = $this->obtieneMenu($subMenu['CODMENU'], 'P');
								// print_r($subMenu['CODMENU']); print_r($aPagina); die;
								if ($aPagina != false) {
									$sMenuPrincipal .= "<ul class='nivel3'>";
									foreach ($aPagina as $key => $pagina) {
										// Creamos el menu pagina con la referencia de la pagina ../pages/<pagina.php>
										$sCarpetaPagina = "../pages/".$pagina['NOMBRE']."?pag=".$pagina['PROCESOS']."&rel=".$pagina['PERMISOS'];
										$sMenuPrincipal .= "<li class='primera'><a href='".$sCarpetaPagina."'>".$pagina['MENUNOMBRE']."</a></li>";
									}
									$sMenuPrincipal .= "</ul>";
								} else {
									$sMenuPrincipal .= "</li>";
								}
							} else {
								// Creamos el menu pagina con la referencia de la pagina ../pages/<pagina.php>
								$sCarpetaPagina = "../pages/".$pagina['NOMBRE']."?pag=".$pagina['PROCESOS']."&rel=".$pagina['PERMISOS'];
								$sMenuPrincipal .= "<li><a href='".$sCarpetaPagina."'>".$subMenu['MENUNOMBRE']."</a></li>";
							}
						}
						$sMenuPrincipal .= "</ul>";
					} else {
						$sMenuPrincipal .= "</li>";
					}
				} else {
					// Creamos el menu pagina con la referencia de la pagina ../pages/<pagina.php>
					$sCarpetaPagina = "../pages/".$pagina['NOMBRE']."?pag=".$pagina['PROCESOS']."&rel=".$pagina['PERMISOS'];
					$sMenuPrincipal .= "<li><a href='".$sCarpetaPagina."'>".$menu['MENUNOMBRE']."</a></li>";
				}
			}
			$sMenuPrincipal .= "</ul></div></div>";
			echo $sMenuPrincipal;
		}
	}

	function obtieneMenu($codMenu=null, $sTipo){
		global $objCon;
		// Obtenemos todos los menus tipo $sTipo
		$aData = array('DISTINCT M.CODMENU', 'M.MENUNOMBRE', 'P.NOMBRE', 'P.PROCESOS', 'AP.PERMISOS');
		$objCon->join('spaginas P', 'P.CODPAG=M.CODPAG', 'LEFT');
		$objCon->join('saccesopaginas AP', 'AP.CODPAG=P.CODPAG', 'LEFT');
		$objCon->join('members Me', 'Me.CODPER=AP.CODPER', 'LEFT');
		$objCon->where('M.MENUTIPO', $sTipo);
		if($codMenu) $objCon->where('M.CODMENUPADRE', $codMenu);		// Verifica si tiene hijos
		// $objCon->where('Me.id', $this->userId);
		$objCon->orderBy('M.MENUORDEN', 'ASC');
		$aMenu = $objCon->get('sadminmenu M', null, $aData);
		if (is_array($aMenu) && count($aMenu)>0) {
			return $aMenu;
		} else {
			return false;
		}
	}

	function obtieneSubMenu($codMenu, $tipo){
		global $objCon;
		// Realizamos un conteo de los menus tipo '$tipo' que tengan CODPAG <> ""
		$aData = array('COUNT(CODPAG) AS CANTIDAD_PAGINAS');
		$objCon->where('MENUTIPO', $tipo);
		$objCon->where('CODPAG', '', '<>');
		$aCantidadPaginas = $objCon->get('sadminmenu', null, $aData);

		if ($aCantidadPaginas[0]['CANTIDAD_PAGINAS'] != 0) {
			global $objCon;			
			$aData = array('M.CODMENU', 'M.MENUNOMBRE', 'P.NOMBRE', 'P.PROCESOS', 'AP.PERMISOS');
			$objCon->join('spaginas P', 'P.CODPAG=M.CODPAG', 'LEFT');
			$objCon->join('saccesopaginas AP', 'AP.CODPAG=P.CODPAG', 'INNER');
			$objCon->join('spersonal Pe', 'Pe.CODPER=AP.CODPER', 'INNER');
			$objCon->join('members Me', 'Me.CODPER=Pe.CODPER', 'INNER');
			$objCon->where('M.MENUTIPO', $tipo);
			$objCon->where('M.CODMENUPADRE', $codMenu);
			$objCon->where('Me.id', $this->userId);
			$objCon->orderBy('M.MENUORDEN', 'ASC');
			$aSubMenu = $objCon->get('sadminmenu M', null, $aData);
		} else {
		// Si la cantidad es igual a 0 entonces se obtienen los menus sin hacer el join a las paginas
			global $objCon;
			$aData = array('M.CODMENU', 'M.MENUNOMBRE');
			$objCon->where('M.MENUTIPO', $tipo);
			$objCon->where('M.CODMENUPADRE', $codMenu);
			$aSubMenu = $objCon->get('sadminmenu M', null, $aData);
		}
		if (is_array($aSubMenu) && count($aSubMenu)>0) {
			return $aSubMenu;
		} else {
			return false;
		}
	}

	function obtienePermisosPagina($sPermisoPag, $sPermisoRel){
		$oAsignaPermiso = new AsignaPermisos;
		$aPermiso = $oAsignaPermiso->asignaPermiso($this->userId, basename($_SERVER['PHP_SELF']));
		if (is_array($aPermiso) && count($aPermiso)>0) {
			return $aPermiso;
		} else {
			$aPermisosPag = str_split($sPermisoPag);
			$aPermisosRel = str_split($sPermisoRel);
			$aPermisosUsuario = str_split($this->sPermisos);
			$aPermisosGeneral = array_intersect($aPermisosPag, $aPermisosRel, $aPermisosUsuario);
			$sPermisosGeneral = implode('', $aPermisosGeneral);
			return $sPermisosGeneral;
		}
	}

	function deshabilitarPrintScreen(){
		$sDeshabilita = "<script type='text/javascript'>
			function limpieza(){
				window.clipboardData.setData('text','')
			}
			function limpieza2(){
				if(clipboardData){
					clipboardData.clearData();
				}
			}
			setInterval('limpieza2();', 1000);
		</script>";
		// return $sDeshabilita;
	}

	function deshabilitaMenuContextual(){
		$sDeshabilita = "<script type='text/javascript'>
			function inhabilitar(){ 
				return false 
			} 

			document.oncontextmenu=inhabilitar;
		</script>";
		return $sDeshabilita;
	}

	function deshabilitaCtrlP(){
		$sDeshabilita = "<script type='text/javascript'>
			function disableCtrlKeyCombination(e){
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
							// alert('Key combination CTRL + ' +String.fromCharCode(key) +' has been disabled.');
							return false;
						}
					}
				}
				return true;
			}
			window.onkeypress = disableCtrlKeyCombination;
			window.onkeydown = disableCtrlKeyCombination;
			// document.body.addEventListener('onkeypress', disableCtrlKeyCombination(), false);
			// document.body.addEventListener('onkeydown', disableCtrlKeyCombination(), false);
		</script>";
		return $sDeshabilita;
	}

	function deshabilitaBarraMenu(){
		// No encontre codigo relacionado a la deshabilitacion del menu de barras
	}

	function ejecutaPermisoAsignado($tipoPermiso, $idAsignacion){
		$oAsignaPermiso = new AsignaPermisos;
		// Se manda este permiso antes de los permisos que ya tiene el usuario
		switch ($tipoPermiso) {
			case 1:	// unica vez
				$aAccesoOtorgado = $oAsignaPermiso->permisoUnicaVez($idAsignacion);
				break;
			case 2:
				$aAccesoOtorgado = $oAsignaPermiso->permisoTemporal($idAsignacion);
				break;
			default:
				# code...
				break;
		}
		return $aAccesoOtorgado;
	}
}