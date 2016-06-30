<?php

namespace general\asignarTematica\funcion;

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
		
		// Aqu� va la l�gica de procesamiento
		if (isset ( $_REQUEST ['botonCancelar2'] ) && $_REQUEST ['botonCancelar2'] == "true") {
			redireccion::redireccionar ( 'principal' );
			exit ();
		}
		if (isset ( $_REQUEST ['botonCrear'] ) && $_REQUEST ['botonCrear'] == "true") {
			
			echo "Cargando...";
			
			// Al final se ejecuta la redirecci�n la cual pasar� el control a otra p�gina
			$conexion = "estructura";
			$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
			
			$codTematicas = array ();
			$tematicas = $_REQUEST ['nombresTematicas'];
			
			$porciones = explode ( ";", $tematicas );
			
			for($i = 0; $i < $_REQUEST ['numTematicas']; $i ++) {
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarCodigosTematicas", $porciones [$i] );
				$matrizItems2 = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
				
				array_push ( $codTematicas, $matrizItems2 [0] [0] );
			}
			
			// var_dump ( $codTematicas );
			// var_dump ( $_REQUEST );
			
			$elim = array ();
			
			$cadenaSql0 = $this->miSql->getCadenaSql ( 'buscarActuales', $_REQUEST ['docente'] );
			$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql0, "busqueda" );
			
			if ($resultadoItems) {
				foreach ( $resultadoItems as $clave => $valor ) {
					// echo "clave $clave y valor $valor[0]";
					if (in_array ( $valor [0], $codTematicas )) {
						$pos = array_search ( $valor [0], $codTematicas );
						unset ( $codTematicas [$pos] );
					} else {
						array_push ( $elim, $valor [0] );
					}
				}
			}
			// var_dump ( $elim );
			
			if ($elim) {
				$_REQUEST ['numTematicasElim'] = count ( $elim );
				$cadenaSql = $this->miSql->getCadenaSql ( "quitarTematica", $elim );
				// echo $cadenaSql;
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "eliminar" );
			}
			
			$cods = array ();
			$num = 0;
			for($i = 0; $i < $_REQUEST ['numTematicas']; $i ++) {
				if (isset ( $codTematicas [$i] )) {
					array_push ( $cods, $codTematicas [$i] );
					$num ++;
				}
			}
			$_REQUEST ['numTematicas'] = $num;
			
			// var_dump ( $codTematicas );
			// var_dump ( $cods );
			// if (isset ( $resultado )){
			// var_dump ( $resultado );
			// }
			// var_dump ( $_REQUEST );
			// exit ();
			
			if ($cods) {
				$cadenaSql = $this->miSql->getCadenaSql ( "asignarTematica", $cods );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "asignar" );
			} else {
				$resultado = true;
			}
			
			if ($resultado) {
				redireccion::redireccionar ( 'inserto', $_REQUEST ['docente'] . $_REQUEST ['nombresTematicas'] );
				exit ();
			} else {
				echo "error 3";
				redireccion::redireccionar ( 'noInserto' );
				exit ();
			}
		} else {
			echo "error 4";
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

