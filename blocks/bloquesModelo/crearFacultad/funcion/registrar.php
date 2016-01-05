<?php

namespace bloquesModelo\crearFacultad\funcion;

include_once ('redireccionar.php');

class Registrar {
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
		
		// Aquí va la lógica de procesamiento
		
		// Al final se ejecuta la redirección la cual pasará el control a otra página
		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'registrar', $_REQUEST );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );
		
		if ($resultado) {
			redireccion::redireccionar ( 'inserto');
			exit ();
		} else {
			redireccion::redireccionar ( 'noInserto' );
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

$miProcesador = new Registrar ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

