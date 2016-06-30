<?php

namespace informeFinal\consultaInformeFinal\funcion;

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
		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// Obtener código del estudiante
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarCodigo", $_REQUEST ["usuario"] );
		$cod = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$_REQUEST ["variable"] = $cod [0][0];
		
		$arreglo = array (
				'pregunta' => $_REQUEST ['pregunta1'],
				'estudiante' => $_REQUEST ["variable"],
				'proyecto' => $_REQUEST ['proyecto']
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'guardarSolicitud', $arreglo );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );
		
		if ($resultado) {
			redireccion::redireccionar ( 'inserto' );
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

