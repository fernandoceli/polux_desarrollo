<?php

namespace bloquesModelo\anteproyectoSin\funcion;

use bloquesModelo\anteproyectoSin\funcion\redireccionar;

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
		if (isset ( $_REQUEST ['botonCancelar2'] ) && $_REQUEST ['botonCancelar2'] == "true") {
			redireccion::redireccionar ( 'devolver' );
			exit ();
		}
		
		if (isset ( $_REQUEST ['botonCrear'] ) && $_REQUEST ['botonCrear'] == "true") {
			
			$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
			
			$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/bloquesModelo/";
			$rutaBloque .= $esteBloque ['nombre'];
			
			$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/bloquesModelo/registrarAnteproyecto/" . $esteBloque ['nombre'];
			
			$conexion = "estructura";
			$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
			
			$cadenaSql = $this->miSql->getCadenaSql ( 'registrar', $_REQUEST );
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );

			var_dump($cadenaSql);
			var_dump($resultado);
			if ($resultado) {
				//modificar el estado del Anteproyecto
				$cadenaSql = $this->miSql->getCadenaSql ( 'actualizarEstado', $_REQUEST );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
				redireccion::redireccionar ( 'inserto');
				exit ();
			} else {
				redireccion::redireccionar ( 'noInserto' );
				exit ();
			}
			var_dump($_REQUEST);
			var_dump($cadenaSql);
			var_dump($resultado);
			exit();
			
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

