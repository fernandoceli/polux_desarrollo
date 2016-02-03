<?php

namespace bloquesModelo\evaluacionProyecto\funcion;

use bloquesModelo\evaluacionProyecto\funcion\redireccionar;

include_once ('redireccionar.php');
class Registrar {
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
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/bloquesModelo/";
		$rutaBloque .= $esteBloque ['nombre'];
		
		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/bloquesModelo/" . $esteBloque ['nombre'];
		
		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'buscarDocumento', $_REQUEST );
		$matrizDocuento = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$documento = $matrizDocuento[0][0];
		var_dump($documento);
		// capturando el return
		$fecha = date ( 'Y-m-d' );
		$eval = array (
				'documento' => $documento,
				'concepto' => $_REQUEST ['seleccionarConcepto'],
				'usuario' => $_REQUEST ['usuario'],
				'proyecto' => $_REQUEST ['proyecto']
		);
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'registrarEvaluacion', $eval );
		$matrizPrueba = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$eval = $matrizPrueba [0] [0];
		var_dump ( $eval );
		
		$datos = array (
				'evaluacion' => $eval,
				'pregunta' => 2,
				'justificacion' => $_REQUEST ['pregunta1']
		);
		var_dump($datos);
		if ($matrizPrueba [0] [0] != null) {
			// guardar respuestas del cuestionario
			$cadenaSql = $this->miSql->getCadenaSql ( 'registrarRespuestas', $datos );
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
			
			//cambiar estado de la solicitud
			$cadenaSql = $this->miSql->getCadenaSql ( 'cambiarEstadoSolicitud');
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
			
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

