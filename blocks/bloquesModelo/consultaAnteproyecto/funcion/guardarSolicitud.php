<?php

namespace bloquesModelo\consultaAnteproyecto\funcion;

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
		
		var_dump($_REQUEST);
		
		date_default_timezone_set ( 'America/Bogota' );
		
		$fecha = date ( "Y-m-d" );
		
		if (!isset($_REQUEST['proyecto'])) {
			$_REQUEST['proyecto'] = $_REQUEST['id'];
		}
		
		$arreglo = array (
				'estado' => 'ESPERA',
				'pregunta1' => $_REQUEST ['pregunta1'],
				'estudiante' => $_REQUEST ["variable"],
				'proyecto' => $_REQUEST ['proyecto'],
				'fecha' => $fecha
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'guardarSolicitud', $arreglo );
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );
		
		var_dump($cadenaSql);
		
		if ($resultado) {
			redireccion::redireccionar ( 'inserto' );
			exit ();
		} else {
			exit();
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

