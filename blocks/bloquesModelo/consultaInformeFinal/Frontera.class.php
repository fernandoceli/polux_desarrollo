<?

namespace bloquesModelo\consultaInformeFinal;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
class Frontera {
	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $miFormulario;
	var 

	$miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	public function setRuta($unaRuta) {
		$this->ruta = $unaRuta;
	}
	public function setLenguaje($lenguaje) {
		$this->lenguaje = $lenguaje;
	}
	public function setFormulario($formulario) {
		$this->miFormulario = $formulario;
	}
	function frontera() {
		$this->html ();
	}
	function setSql($a) {
		$this->sql = $a;
	}
	function setFuncion($funcion) {
		$this->funcion = $funcion;
	}
	function html() {
		
		// Como se tiene un solo formulario no es necesario un switch para cargarlo:
		$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
		
		if (isset ( $_REQUEST ['botonI'] ) && ($_REQUEST ['botonI'] == 'true')) {
			include_once ($this->ruta . "/formulario/iniciar.php");
		} else if (isset ( $_REQUEST ['opcion'] )) {
			switch ($_REQUEST ['opcion']) {
				case "asignar" :
					include_once ($this->ruta . "/formulario/asignar.php");
					break;
				case "mensaje" :
					include_once ($this->ruta . "/formulario/mensaje.php");
					break;
				case "continuar" :
					include_once ($this->ruta . "/formulario/form.php");
					break;
				case "solicitar":
					if (isset ( $_REQUEST ['btnCrearVersion'] ) && ($_REQUEST ['btnCrearVersion'] == 'true')) {
						include_once ($this->ruta . "/formulario/crearVersion.php");
					}
						
					if (isset ( $_REQUEST ['botonSolicitar'] ) && ($_REQUEST ['botonSolicitar'] == 'true')) {
						include_once ($this->ruta . "/formulario/solicitar.php");
					}
						
					if (isset ( $_REQUEST ['btnAsignarJurados'] ) && ($_REQUEST ['btnAsignarJurados'] == 'true')) {
						include_once ($this->ruta . "/formulario/asignar.php");
					}
					break;
			}
		} else {
	include_once ($this->ruta . "/formulario/form.php");
}
	}
}
?>