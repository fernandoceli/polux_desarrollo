<?php

namespace bloquesModelo\consultaInformeFinal\funcion;

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
		
		// Obtener c�digo del estudiante
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarCodigo", $_REQUEST ["usuario"] );
		$cod = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$_REQUEST ["variable"] = $cod [0][0];
		
		$codJurados = array ();
		$jurados = $_REQUEST ['codJurados'];
		
		$jurados = explode ( ";", $jurados );
		
		$aux = count($jurados);
		
		if ($jurados[$aux-1] == "") {
			array_pop($jurados);
		}
		
// 		var_dump($jurados);
		
		var_dump($_REQUEST);
// 		exit();
		
		date_default_timezone_set ( 'America/Bogota' );
		
		$fecha = date ( "Y-m-d" );
		
		$_REQUEST ['revisores'] = $jurados;
		
		$datos = array(
			"informe" => $_REQUEST['informe'],
			"fecha" => $fecha
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( 'registrar', $datos);
		var_dump($cadenaSql);
// 		exit;
		
		$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );
		
		var_dump($resultado);
		
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

