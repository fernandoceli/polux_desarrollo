<?php

namespace bloquesModelo\consultaInformeFinal\funcion;

use bloquesModelo\consultaInformeFinal\funcion\redireccionar;

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
			
			if ($resultado) {
				
				// obtener codigos por separado
				$revisores = $_REQUEST ['revisores'];
				$porciones = explode ( ";", $revisores );
				for($i = 0; $i < $_REQUEST ['numRevisores']; $i ++) {
					// guardar solicitudes
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'registrarSolicitudes', $porciones [$i] );
					$matrizSol = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					var_dump ( $matrizSol );
				}
				
				//modificar el estado del Informe Final
				$cadenaSql = $this->miSql->getCadenaSql ( 'actualizarEstadoInforme', $_REQUEST );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
				
				// guardar historial de las solicitudes de revisión
				$cadenaSql = $this->miSql->getCadenaSql ( 'guardarHistorialSol', $matrizSol[0][0] );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
			}
			
			if ($resultado) {
				redireccion::redireccionar ( 'inserto');
				exit ();
			} else {
				redireccion::redireccionar ( 'noInserto' );
				exit ();
			}
			
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

