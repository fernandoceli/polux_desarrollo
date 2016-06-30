<?php

namespace informeFinal\consultaInformeFinal\funcion;

use informeFinal\consultaInformeFinal\funcion\redireccionar;

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
			
			$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/informefinal/";
			$rutaBloque .= $esteBloque ['nombre'];
			
			$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/informefinal/consultarInformeFinal/" . $esteBloque ['nombre'];
			
			$conexion = "estructura";
			$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
			
			
			//buscar documento de antp
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'buscarDocumento3');
			$documento = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			//var_dump($documento);
			
				// obtener codigos por separado
				$revisores = $_REQUEST ['revisores'];
				$porciones = explode ( ";", $revisores );
				for($i = 0; $i < $_REQUEST ['numRevisores']; $i ++) {
					// guardar solicitudes
					
					$datosSol = array (
							'docente' => $porciones [$i],
							'documento' => $documento[0][0]
					);
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'registrarSolicitudes', $datosSol );
					$matrizSol = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					var_dump ( $matrizSol );
					
					$datos = array (
							'docente' => $porciones [$i],
							'solicitud' => $matrizSol[0][0]
					);
					
					if ($matrizSol) {
						$cadenaSql = $this->miSql->getCadenaSql ( 'registrar', $datos );
						$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
					
						// guardar historial de las solicitudes de revisi�n
						$cadenaSql = $this->miSql->getCadenaSql ( 'guardarHistorialSol', $matrizSol[0][0] );
						$resul = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
					}
					
				}
				
				if($resul){
					//modificar el estado del Informe Final
					$cadenaSql = $this->miSql->getCadenaSql ( 'actualizarEstado', $_REQUEST );
					$resul2 = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
	
				}
			
			if ($resul2) {
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

