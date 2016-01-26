<?php

namespace bloquesModelo\consultaProyecto\funcion;

use bloquesModelo\consultaProyecto\funcion\redireccionar;

include_once ('redireccionar.php');

class Iniciar {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		// $this->miFuncion = $funcion;
	}
	
	function procesarFormulario() {
		if (isset ( $_REQUEST ['botonCancelarIni'] ) && $_REQUEST ['botonCancelarIni'] == "true") {
			redireccion::redireccionar ( 'devolver' );
			exit ();
		} else if (isset ( $_REQUEST ['botonIni'] ) && $_REQUEST ['botonIni'] == "true") {
			redireccion::redireccionar ( 'iniciar' );
			exit ();
		}
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miProcesador = new Iniciar ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

