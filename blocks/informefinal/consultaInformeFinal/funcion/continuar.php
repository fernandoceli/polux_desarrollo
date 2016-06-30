<?php
namespace informeFinal\consultaInformeFinal\funcion;
include_once ('redireccionar.php');
class Ver {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
	}
	function procesarFormulario() {
		redireccion::redireccionar ( 'continuar', $_REQUEST);
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
$miProcesador = new Ver ( $this->lenguaje, $this->sql );
$resultado = $miProcesador->procesarFormulario ();