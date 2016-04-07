<?php
namespace bloquesModelo\informesFinalesSinJurados\funcion;
include_once ('redireccionar.php');
class Ver {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	
	function __construct($lenguaje) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
	}
	function procesarFormulario() {
		redireccion::redireccionar ( 'ver', $_REQUEST);
		exit ();
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
				
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}
$miProcesador = new Ver ( $this->lenguaje);
$resultado = $miProcesador->procesarFormulario ();