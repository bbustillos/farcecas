<?php
include_once 'db_conexion.php';
require_once('MysqliDb.php');
// require_once('class.gralFunctions.php');
/**
* Permite manejar el objeto buses con todos sus metodos
*/
class Buses
{
	public $iCODBUS;
	public $sCODEMP;
	public $sCODACTIVO;
	public $sPLACA;
	public $sMARCA;
	public $iMODELO;
	public $sCOLOR;
	public $iASIENTOS;
	public $sFILAS;
	public $iCOLUMNAS;
	public $PISOS;
	public $sCONTV;
	public $sCOMODIN;
	public $sTIPOBUS;
	public $iCARGA;
	public $sOBS;
	public $sESTADO;
	public $iCODPRY;
	public $iCODPRO;
	public $sUPLOAD;
	public $sPSEUDO;
	public $sIMAGEN;
	public $sCAMBIA;
	public $sCHASIS;
	public $sMOTOR;
	public $sRESEXE;
	public $dVALIDRES;
	public $sPOLIZA;
	public $dVALIDPOL;
	public $sTOPERACION;
	public $dVALIDOPER;
	public $CODIGODISENIO;
	public $CODIGOCOMBINA;
	public $BANIO;
	public $AIRE;
	public $CALEFACCION;
	public $ASAFATA;
	public $GUIA;
	public $LUZ_PERSONAL;
	public $AUDIFONOS;
	public $WI_FI;
	public $CARGADOR_USB;
	public $CINTURON_SEG;
	public $FRAZADA;
	public $CAFETERIA;
	public $COMIDA;

	function __construct() {
	}

	function obtieneBus($codBus){
		global $objCon;
		$objCon->where('CODBUS', $codBus);
		$aBuses = $objCon->get('sbuses');
		if (is_array($aBuses) && count($aBuses)>0) {
			foreach ($aBuses as $key => $bus) {
				$this->iCODBUS = $bus['CODBUS'];
				$this->sCODEMP = $bus['CODEMP'];
				$this->sCODACTIVO = $bus['CODACTIVO'];
				$this->sPLACA = $bus['PLACA'];
				$this->sMARCA = $bus['MARCA'];
				$this->iMODELO = $bus['MODELO'];
				$this->sCOLOR = $bus['COLOR'];
				$this->iASIENTOS = $bus['ASIENTOS'];
				$this->sFILAS = $bus['FILAS'];
				$this->iCOLUMNAS = $bus['COLUMNAS'];
				$this->PISOS = $bus['PISOS'];
				$this->sCONTV = $bus['CONTV'];
				$this->sCOMODIN = $bus['COMODIN'];
				$this->sTIPOBUS = $bus['TIPOBUS'];
				$this->iCARGA = $bus['CARGA'];
				$this->sOBS = $bus['OBS'];
				$this->sESTADO = $bus['ESTADO'];
				$this->iCODPRO = $bus['CODPRO'];
				$this->iCODPRY = $bus['CODPRY'];
				$this->sUPLOAD = $bus['UPLOAD'];
				$this->sPSEUDO = $bus['PSEUDO'];
				$this->sIMAGEN = $bus['IMAGEN'];
				$this->sCAMBIA = $bus['CAMBIA'];
				$this->sCHASIS = $bus['CHASIS'];
				$this->sMOTOR = $bus['MOTOR'];
				$this->sRESEXE = $bus['RESEXE'];
				$this->dVALIDRES = $bus['VALIDRES'];
				$this->sPOLIZA = $bus['POLIZA'];
				$this->dVALIDPOL = $bus['VALIDPOL'];
				$this->sTOPERACION = $bus['TOPERACION'];
				$this->dVALIDOPER = $bus['VALIDOPER'];
				$this->CODIGODISENIO = $bus['CODIGODISENIO'];
				$this->CODIGOCOMBINA = $bus['CODIGOCOMBINA'];
				$this->BANIO = $bus['BANIO'];
				$this->AIRE = $bus['AIRE'];
				$this->CALEFACCION = $bus['CALEFACCION'];
				$this->ASAFATA = $bus['ASAFATA'];
				$this->GUIA = $bus['GUIA'];
				$this->LUZ_PERSONAL = $bus['LUZ_PERSONAL'];
				$this->AUDIFONOS = $bus['AUDIFONOS'];
				$this->WI_FI = $bus['WI_FI'];
				$this->CARGADOR_USB = $bus['CARGADOR_USB'];
				$this->CINTURON_SEG = $bus['CINTURON_SEG'];
				$this->FRAZADA = $bus['FRAZADA'];
				$this->CAFETERIA = $bus['CAFETERIA'];
				$this->COMIDA = $bus['COMIDA'];
			}
			// Antes de retornar, almacenar el proceso de consulta
			return $aBuses;
		} else {
			return false;
		}
	}

	function obtieneBuses($data){
		global $objCon;
		$objCon->where('ESTADO <> "I"');
		$aBuses = $objCon->get('sbuses', null, $data);
		if (is_array($aBuses) && count($aBuses)>0) {
			// Antes de retornar los buses, almacenar el proceso de consulta
			return $aBuses;
		} else {
			return false;
		}
	}

	function almacenarBus($data, $validadores){
		global $objCon;
		$aResp = array();
		$codBus = $objCon->almacenar('sbuses', $data, $validadores);
		if ($codBus) {
			// Antes de retornar el almacenamiento de buses, almacenar el proceso de almacenamiento
			$aResp['success'] = true;
			$aResp['codBus'] = $codBus;
			return $aResp;
		} else {
			$aResp['success'] = false;
			$aResp['validador'] = $validadores;
			return $aResp;
		}
	}

	function eliminarBus($codBus){
		global $objCon;
		$aCodBus = array('ESTADO' => '');
		$objCon->where('CODBUS', $codBus);
		if($objCon->update('sbuses', $aCodBus)){
			// Antes de retornar la eliminacion del bus, almacenar el proceso de eliminacion
			$aResp['success'] = true;
		} else {
			$aResp['success'] = false;
		}
		return $aResp;
	}

	function actualizarBus($codBus, $data){
		global $objCon;
		$aResp = array();
		unset($data['validador']);
		$objCon->where('CODBUS', $codBus);
		// Antes de retornar la modificacion del buses, almacenar el proceso de almacenamiento
		if($objCon->update('sbuses', $data))
			$aResp['success'] = true;
		else 
			$aResp['success'] = false;
		return $aResp;
	}

	function cargaDDBus($codEmp){
		global $objCon;
		$dataBuses = array("B.CODBUS", "B.PSEUDO", "B.MARCA", "B.PLACA", "CONCAT(P.DES,' ',B.PLACA) AS DES");
        $objCon->join("sdiarioinvdet D", "B.CODACTIVO = D.NROSERIE", "LEFT");
        $objCon->join("spremios P", "P.CODPREMIO = D.CODPREMIO", "LEFT");
        $objCon->where("B.CODEMP", $codEmp);
        $objCon->where("B.CODACTIVO", '', "<>");
        $objCon->orderBy("B.PSEUDO", "asc");
        $objCon->orderBy("P.DES", "asc");
        $aBuses = $objCon->get('sbuses B', null, $dataBuses);
        if (is_array($aBuses) && count($aBuses)>0) {
            $sComboBuses = "<select name='documento' id='documento' required>
                            	<option value=''>-- NUEVO BUS --</option>";
            foreach ($aBuses as $key => $bus) {
               $sComboBuses .= "<option value=".$bus['CODBUS'].">".$bus['PSEUDO'].' ['.$bus['CODBUS'].'] '.$bus['MARCA'].'&nbsp;'.$bus['PLACA']."</option>";
            }
            $sComboBuses .= "</select>";
        }
        return $sComboBuses;
	}

	function cargaProyectos($codEmp, $codSuc){
		global $objCon;
		$dataProyectos = array("CODPRY", "DES");
		$objCon->where("CODEMP",$codEmp);
		$objCon->where("ESTADO",'A');
		$objCon->where("IF(TRIM(VISIBLE)!='',FIND_IN_SET(".$codSuc.",VISIBLE)>=1,1=1)");
		$objCon->orderBy("DES", "ASC");
		$aProyectos = $objCon->get('sproyectos', null, $dataProyectos);
		// Carga dropdown de Proyectos
		if (is_array($aProyectos) && count($aProyectos)>0) {
			$sComboProyectos = "<select name='proyecto' id='proyecto'>
									<option value=''>-- SELECCIONAR --</option>";
			foreach ($aProyectos as $key => $proyecto) {
				$sComboProyectos .= "<option value='".$proyecto['CODPRY']."'>".$proyecto['DES']."</option>";
			}
			$sComboProyectos .= "</select>";
		}
		// Fin Carga dropdown de Proyectos
		return $sComboProyectos;
	}

	function cargaPropietarios(){
		global $objCon;
		$dataPersonal = array('P.CODPER', 'P.NRODOCID', 'P.NOMBRES', 'P.PATERNO', 'P.MATERNO');
		// $objCon->join('sbuses S', 'S.CODPRO', 'LEFT');
		$objCon->orderBy('P.PATERNO');
		$aPersonal = $objCon->get('spersonal P', null, $dataPersonal);
		// Carga dropdown de Proyectos
		if (is_array($aPersonal) && count($aPersonal)>0) {
			$sComboPersonal = "<select name='personal' id='personal'>
									<option value=''>-- SELECCIONAR --</option>";
			foreach ($aPersonal as $key => $personal) {
				$nombreCompleto = $personal['PATERNO'] . " " . $personal['MATERNO'] . ", ". $personal['NOMBRES'];
				$sComboPersonal .= "<option value='".$personal['CODPER']."'>".$nombreCompleto."-".$personal['NRODOCID']. "</option>";
			}
			$sComboPersonal .= "</select>";
		}
		// Fin Carga dropdown de Proyectos
		return $sComboPersonal;
	}

	function cargaDisenio(){
		global $objCon;
		$dataDisenio = array('CODIGODISENIO', 'NOMBREDISENIO');
		$aDisenio = $objCon->get('sdiseniobus', null, $dataDisenio);
		// Carga dropdown de Disenio
		if (is_array($aDisenio) && count($aDisenio)>0) {
			$sComboDisenio = "<select name='disenio' id='disenio'>
									<option value=0>-- SELECCIONAR --</option>";
			foreach ($aDisenio as $key => $disenio) {
				$sComboDisenio .= "<option value='".$disenio['CODIGODISENIO']."'>".$disenio['NOMBREDISENIO']. "</option>";
			}
			$sComboDisenio .= "</select>";
		}
		// Fin Carga dropdown de Disenio
		return $sComboDisenio;
	}

	function tipoMovil(){
		global $objCon;
		$dataMovil = array('CODTIPOBUS', 'DESC_TIPOBUS');
		$aMovil = $objCon->get(' stipobus', null, $dataMovil);
		// Carga dropdown de Disenio
		if (is_array($aMovil) && count($aMovil)>0) {
			$sComboMovil = "<select name='tipoMovil' id='tipoMovil'>
									<option value=0>-- SELECCIONAR --</option>";
			foreach ($aMovil as $key => $movil) {
				$sComboMovil .= "<option value='".$movil['CODTIPOBUS']."'>".$movil['DESC_TIPOBUS']. "</option>";
			}
			$sComboMovil .= "</select>";
		}
		// Fin Carga dropdown de Disenio
		return $sComboMovil;
	}

	function obtieneTipoDisenio($codDisenio=null){
		global $objCon;
		$aResp = array();
		if ($codDisenio) {
			$objCon->where('CODIGODISENIO', $codDisenio);
		}
		$aTipoDisenio = $objCon->get('stipobus');
		if (is_array($aTipoDisenio) && count($aTipoDisenio)>0) {
			$aResp['success'] = true;
			$aResp['data'] = $aTipoDisenio;
		}
			return $aResp;
	}

	function mixtoCombinacion(){
		global $objCon;
		$dataCombina = array('CODIGOCOMBINA', 'NOMBRECOMBINA');
		$aCombina = $objCon->get('scombinacion_tipobus', null, $dataCombina);
		// Carga dropdown de Combina
		if (is_array($aCombina) && count($aCombina)>0) {
			$sComboCombina = "<select name='mixtoCombinacion' id='mixtoCombinacion'>
									<option value=0>-- SELECCIONAR --</option>";
			foreach ($aCombina as $key => $combina) {
				$sComboCombina .= "<option value='".$combina['CODIGOCOMBINA']."'>".$combina['NOMBRECOMBINA']. "</option>";
			}
			$sComboCombina .= "</select>";
		}
		// Fin Carga dropdown de Combina
		return $sComboCombina;
	}

	function cargaPantalla($codEmp, $codSuc){
		$sBusesPantalla = "	<div id='contenedor'>
	    						<div id='dialog-message' title='Informaci&oacute;n' style='display: none;'><p></p></div>
								<div id='dialog-confirm' title='Confirmar' style='display: none;'>Confirmar Solicitud</p></div>
								<ul>
									<li> <h2> Buses </h2> <div id='volver'><a href='../public/menuPrincipal.php'>Volver</a></div> </li>
									<li>
										<label for='bus'>Bus : </label>".$this->cargaDDBus($codEmp)."<br>
										<label for='marca'>Marca : </label><input type='text' id='marca'>
										<label for='placa'>Placa : </label><input type='text' id='placa'>
										<label for='comodin'>Comod&iacute;n : </label><input type='checkbox' id='comodin'><br>
										<label for='modelo'>Modelo : </label><input type='text' id='modelo'>
										<label for='color'>Color : </label><input type='text' id='color'>
										<label for='activo'>Activo : </label><input id='estado' align='left' type='checkbox'>
									</li>
									<li>
										<label for='disenio'>Dise&ntilde;o : </label>".$this->cargaDisenio()."
										<label for='tipoBus'>Tipo de Bus : </label>".$this->tipoMovil()."
										<label id='combinaLabel' for='combinacion'>Combinaci&oacute;n : </label>".$this->mixtoCombinacion()."
									</li>
									<li>
										<label class='checklabel' for='coTV'>Con TV</label><input type='checkbox' id='contv'>
										<label class='checklabel' for='bano'>Ba&ntilde;o</label><input type='checkbox' id='banio'>
										<label class='checklabel' for='aire'>Aire Acondicionado</label><input type='checkbox' id='airea'>
										<label class='checklabel' for='cale'>Calefacci&oacute;n</label><input type='checkbox' id='calef'><br>
										<label class='checklabel' for='azaf'>Azafata</label><input type='checkbox' id='asafa'>
										<label class='checklabel' for='guia'>Gu&iacute;a Turismo</label><input type='checkbox' id='guiat'>
										<label class='checklabel' for='luzp'>Luz Personal</label><input type='checkbox' id='luzpe'>
										<label class='checklabel' for='audi'>Aud&iacute;fonos</label><input type='checkbox' id='audif'>
										<label class='checklabel' for='wifi'>Wi-Fi</label><input type='checkbox' id='wi_fi'><br>
										<label class='checklabel' for='ausb'>Cargador USB</label><input type='checkbox' id='caUSB'>
										<label class='checklabel' for='cint'>Cintur&oacute;n Seguridad</label><input type='checkbox' id='cSegu'>
										<label class='checklabel' for='fraz'>Frazada</label><input type='checkbox' id='fraza'>
										<label class='checklabel' for='cafe'>Cafeter&iacute;a</label><input type='checkbox' id='cafet'>
										<label class='checklabel' for='comi'>Comida</label><input type='checkbox' id='comid'>
									</li>
									<li>
										<label for='filas'>Filas : </label><input type='text' id='filas' size='7'>
										<label for='columna'>Columnas : </label><input type='text' id='columnas' size='7'>
										<label for='asiento'>Asientos : </label><input type='text' id='asientos' align='left' size='7'><br>
										<label for='pisos'>Nroº Pisos : </label><input type='text' id='pisos' align='left' size='7'>
										<label for='carga'>Carga M&aacute;xima : </label><input type='text' defaultvalue='0' id='carga' size='7'>
										<label for='interno'>Interno : </label><input defaultvalue='0' id='pseudo' type='text' size='7'>
									</li>
									<li>
										<label for='antec'>Observaciones : </label><textarea id='obs' rows='3' cols='45' name='obs'></textarea><br>
										<label for='prop'>Propietario : </label>".$this->cargaPropietarios($codEmp, $codSuc)."<br>
										<label for='proy'>Proyecto : </label><input type='hidden' id='CODEMP' value='".$codEmp."'/>".$this->cargaProyectos($codEmp, $codSuc)."
									</li>
								</ul>
								<!-- <td><input type='button' id='agregarAsientos' value='asientos'></td> -->
							</div>";
        return $sBusesPantalla;  
	}

	function cargaObjetoAsiento(){
		$sObjetoAsiento = "<select style='width:100px;' name='objetoAsiento' id='objetoAsiento'>
								<option value=''>-- SELECCIONAR --</option>
								<option value='A'>Asiento</option>
								<option value='T'>Televisor</option>
								<option value='B'>Ba&ntilde;o</option>
								<option value='C'>Chofer</option>
								<option value='P'>Puerta</option>
							</select>";
		return $sObjetoAsiento;
	}

	function cargaTipoAsiento(){
		global $objCon;
		$aData = array('CODIGOTIPOASI', 'NOMBRETIPOASI');
		$aTipoAsiento = $objCon->get('stiposasientos', null, $aData);
		if (is_array($aTipoAsiento) && count($aTipoAsiento)>0) {
			$sTipoAsientoDD = "<select name='tipoAsiento' id='tipoAsiento'>
									<option value=''>-- SELECCIONAR --</option>";
			foreach ($aTipoAsiento as $key => $tipoAsiento) {
				$sTipoAsientoDD .= "<option value='".$tipoAsiento['CODIGOTIPOASI']."'>".$tipoAsiento['NOMBRETIPOASI']. "</option>";
			}
			$sTipoAsientoDD .= "</select>";
		}
		// Fin Carga dropdown de Combina
		return $sTipoAsientoDD;
	}

	function cargaAcceso(){
		global $objCon;
		$aData = array('CODIGOACCEASI', 'NOMBREACCEASI');
		$aAcceso = $objCon->get('saccesoasientos', null, $aData);
		if (is_array($aAcceso) && count($aAcceso)>0) {
			$sAccesoDD = "<select name='accesoDD' id='accesoDD'>
									<option value=''>-- SELECCIONAR --</option>";
			foreach ($aAcceso as $key => $acceso) {
				$sAccesoDD .= "<option value='".$acceso['CODIGOACCEASI']."'>".$acceso['NOMBREACCEASI']. "</option>";
			}
			$sAccesoDD .= "</select>";
		}
		// Fin Carga dropdown de Combina
		return $sAccesoDD;
	}

	function cargaEstado(){
		global $objCon;
		$aData = array('CODIGOESTAASI', 'NOMBREESTAASI');
		$aEstado = $objCon->get('sestadoasientos', null, $aData);
		if (is_array($aEstado) && count($aEstado)>0) {
			$sEstadoDD = "<select name='estadoDD' id='estadoDD'>
									<option value=''>-- SELECCIONAR --</option>";
			foreach ($aEstado as $key => $estado) {
				$sEstadoDD .= "<option value='".$estado['CODIGOESTAASI']."'>".$estado['NOMBREESTAASI']. "</option>";
			}
			$sEstadoDD .= "</select>";
		}
		// Fin Carga dropdown de Combina
		return $sEstadoDD;
	}

	function verificarBusAsiento($codBus){
		global $objCon;
		// Obtener la informacion del bus, verificando si existe informacion en la tabla sasientosbuses
		$aResp = array();
		$objCon->where('CODBUS', $codBus);
		$aBusAsientos = $objCon->get('sasientosbuses');
		if (is_array($aBusAsientos) && count($aBusAsientos)>0) {
			$aResp['success'] = true;
		} else {
			$aResp['success'] = false;
		}
		return $aResp;
	}

	/**
	 * Muestra la pantalla de defincion de asientos para el bus
	 * @param  int $codBus Codigo de Bus
	 * @return echo        Impresion del dibujo HTML
	 */
	function defineEstructuraBus($codBus){
		// Obtenemos la informacion de las filas, columnas y tipo
		global $objCon;
		$aData = array('ASIENTOS', 'FILAS', 'COLUMNAS', 'TIPOBUS', 'CONTV');
		$objCon->where('CODBUS', $codBus);
		$aAsientos = $objCon->get('sbuses', 1, $aData);
		if (is_array($aAsientos) && count($aAsientos)>0) {
			foreach ($aAsientos as $key => $asiento) {
				$sColumnas = $asiento['COLUMNAS'];
				$sFilas = $asiento['FILAS'];
			}
		}

		// Cargar la pantalla de asientos para bus
		$sBusAsiento = "<table border='1'>";
		for ($columna=1; $columna <= $sColumnas; $columna++) { 
			$sBusAsiento .= "<tr>";
			for ($fila=1; $fila <= $sFilas; $fila++) { 
				$aAsientoActual = $this->cargaAsientoBus($codBus, $fila, $columna);
				if ($aAsientoActual == false) {
					$desc = '';
					$sObjeto = 'por definir';
				} else {
					foreach ($aAsientoActual as $key => $asientoActual) {
						$desc = $asientoActual['DES'];
						$objeto = $asientoActual['OBJETO'];
						$sObjeto = $this->objetoAsiento($objeto);
						$sTipoAsiento = ($asientoActual['NOMBRETIPOASI']=='')?'tipo':$asientoActual['NOMBRETIPOASI'];
						$sAcceso = ($asientoActual['NOMBREACCEASI']=='')?'acceso':$asientoActual['NOMBREACCEASI'];
						$sSalEmer = ($asientoActual['SALIDA_EMERGENCIA']==1)?true:false;
						$sEstado = ($asientoActual['NOMBREESTAASI']=='')?'estado':$asientoActual['NOMBREESTAASI'];
					}
				}
				$sBusAsiento .= "<td align='center' valign='middle'>
									<div id='".$columna."_".$fila."_cont'>
										<ul>
											<li><label>N&deg;&nbsp;</label><input type='text' id='".$columna."_".$fila."_des' value='".$desc."'>
											<label>Sel</label><input class='checkField' type='checkbox' id='".$columna."_".$fila."_cb'></li>
										</ul>
										<ul>
											<li><label id='".$columna."_".$fila."_ob'>".$sObjeto."</label></li>
										</ul>
										<ul>
											<li><label id='".$columna."_".$fila."_tip'>".$sTipoAsiento."</label>&nbsp;&nbsp;
											<label id='".$columna."_".$fila."_acc'>".$sAcceso."</label></li>
										</ul>
										<ul>
											<li><label>E?</label><input class='checkField' type='checkbox' id='".$columna."_".$fila."_eme'>&nbsp;&nbsp;
											<label id='".$columna."_".$fila."_est'>".$sEstado."</label></li>
										</ul>
									</div>
								</td>";
			}
			$sBusAsiento .= "</tr>";
		}
		$sBusAsiento .= "</table>";
		// Acciones generales
		
		$sBusAsiento .= "<table>
							<tr>
								<td><input type='hidden' id='columnas' value='".$sColumnas."'></td>
								<td><input type='hidden' id='filas' value='".$sFilas."'></td>
								<td><input type='hidden' id='documento' value='".$codBus."'></td>
							</tr>
							<tr>
								<td><label class='desc'>Objeto</label>".$this->cargaObjetoAsiento()."&nbsp;</td>
								<td><label class='desc'>Tipo</label> ".$this->cargaTipoAsiento()."</td>
								<td><label class='desc'>Acceso</label> ".$this->cargaAcceso()."</td>
								<td><label class='desc'>Estado</label> ".$this->cargaEstado()."</td>
								<td><input type='button' id='almacenarAsientoBus' value='Aplicar' class='buttonS'/></td>
								<td><input type='button' onclick='window.close();' value='Cerrar' class='buttonS'/></td>
						 	</tr>
						 </table>";
		echo $sBusAsiento;
		// hacemos un for de las columnas y por cada columna agregamos una fila
	}

	/**
	 * Almacenamiento individual por cada asiento
	 * @param  int    $codBus Codigo unico de Bus
	 * @param  int    $fil    Identificador de la fila
	 * @param  int    $col    Identificador de la columna
	 * @return array / fase   Info Bus / vacio (Null)
	 */
	function cargaAsientoBus($codBus, $fil, $col){
		global $objCon;
		// Verificar si el asiento existe en base a la fila, columna y codigo de bus
		$aDataSolo = array('AB.CODASIENTO', 'AB.DES', 'AB.OBJETO', 'AB.SALA', 'AB.CAMBIA', 'TA.NOMBRETIPOASI', 'AA.NOMBREACCEASI', 'AB.SALIDA_EMERGENCIA', 'EA.NOMBREESTAASI');
        $objCon->join("sestadoasientos EA", "EA.CODIGOESTAASI = AB.TIPOASIENTO", "LEFT");
        $objCon->join(" saccesoasientos AA", "AA.CODIGOACCEASI = AB.ACCESO", "LEFT");
        $objCon->join("stiposasientos TA", "TA.CODIGOTIPOASI = AB.TIPOASIENTO", "LEFT");
		$objCon->where('CODBUS', $codBus);
		$objCon->where('FILA', $fil);
		$objCon->where('COLUMNA', $col);
		$aAsientoSolo = $objCon->get('sasientosbuses AB', null, $aDataSolo);
		if (is_array($aAsientoSolo) && count($aAsientoSolo)>0) {
			// Si el asiento se encuentra entonces devolver el valor del objeto, del tipo y del piso (sala)
			return $aAsientoSolo;
		} else {
			// Si no se encuentra el entonces devolver un valor vacio
			return false;
		}
	}

	function objetoAsiento($codObjeto){
		switch ($codObjeto) {
			case 'A':
				$sObjeto = 'Asiento';
				break;
			case 'T':
				$sObjeto = 'Televisor';
				break;
			case 'B':
				$sObjeto = 'Baño';
				break;
			case 'C':
				$sObjeto = 'Chofer';
				break;
			case 'P':
				$sObjeto = 'Puerta';
				break;
			
			default:
				break;
		}
		return $sObjeto;
	}

	function almModAsientoBus($codBus, $data){
		global $objCon;
		if (is_array($data) && count($data)>0) {
			$fil = $data[0];									// fila
			$col = $data[1];									// columna
			// Verificar que el asiento no exista   
			$data = array('CODASIENTO');
			$objCon->where('CODBUS',$codBus);
			$objCon->where('FILA',$fil);
			$objCon->where('COLUMNA',$col);
			$aAsientoBus = $objCon->get('sasientosbuses', null, $data);
			if (is_array($aAsientoBus) && count($aAsientoBus)>0) {
				$des = $data[2];									// descripcion
				$obj = $data[3];									// objeto
				$tip = $data[4];									// tipo
				$acc = $data[5];									// acceso
				$est = $data[6];									// estado
				$est = $data[7];									// estado
				$eme = (isset($data[8]) && $data[8]==1)?true:false;	// emergencia
				$sObj = htmlentities($this->objetoAsiento($obj));
				// Si existe informacion actualizar la informacion de asiento
				global $objCon;
				$codAsiento = $aAsientoBus[0]['CODASIENTO'];
				$aData = array('CODBUS'=>$codBus, 'OBJETO'=>$sObj, 'DES'=>$des, 'FILA'=>$fil, 'COLUMNA'=>$col, 'TIPOASIENTO'=>$tip, 'ACCESO'=>$acc, 'SALIDA_EMERGENCIA'=>$est, 'ESTADO'=>$eme);
				// print_r('data: ');print_r($aData); die;
				$objCon->where('CODBUS',$codBus);
				$objCon->where('FILA',$fil);
				$objCon->where('COLUMNA',$col);
				$sUpdateAsientoBus = $objCon->update('sasientosbuses', $aData);
				if ($sUpdateAsientoBus == true) {
					$aInfoAsientoBus = array('CODASIENTO'=>$codAsiento, 'FILA'=>$fil, 'COLUMNA'=>$col, 'OBJETO'=>$sObj);
					return $aInfoAsientoBus;
				}
			} else {
				// Si no existe informcion almacenar la informacion de asiento
				global $objCon;
				$aData = array('CODBUS'=>$codBus, 'OBJETO'=>$sObj, 'DES'=>$des, 'FILA'=>$fil, 'COLUMNA'=>$col, 'SALA'=>'1', 'CAMBIA'=>'S', 'TIPOASIENTO'=>$tip, 'ACCESO'=>$acc, 'SALIDA_EMERGENCIA'=>$est, 'ESTADO'=>$eme);
				$asientoId = $objCon->insert('sasientosbuses', $aData);
				if ($asientoId != '') {
					$aInfoAsientoBus = array('CODASIENTO'=>$asientoId, 'FILA'=>$fil, 'COLUMNA'=>$col, 'OBJETO'=>$sObj);
					return $aInfoAsientoBus;
				}
			}
		}
	}

	function almacenaAsientosBus($codBus, $infoAsientoBus){
		$aAsientos = array();
		$contador = 0;
		// obtener la informacion de todos los asientos modificados
		$aAsientosBus = explode('|', $infoAsientoBus);
		// Recorrer el array y almacenar o modificar cada item
		for ($i=0; $i < count($aAsientosBus); $i++) { 
			// obtener la informacion del asiento
			$aAsiento = explode('_', $aAsientosBus[$i]);
			$asientoId = $this->almModAsientoBus($codBus, $aAsiento);
			$aAsientos[$contador] = $asientoId;
			$contador++;
		}
		return $aAsientos;
	}
}