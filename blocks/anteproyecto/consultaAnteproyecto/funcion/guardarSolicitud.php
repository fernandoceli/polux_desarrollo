<?php

namespace anteproyecto\consultaAnteproyecto\funcion;

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
		
		//var_dump($_REQUEST);
		
		date_default_timezone_set ( 'America/Bogota' );
		
		$fecha = date ( "Y-m-d" );
		
		if (!isset($_REQUEST['anteproyecto'])) {
			$_REQUEST['anteproyecto'] = $_REQUEST['id'];
		}
		
		//buscar revisores asignados para asignar solicitudes
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarRevisores", $_REQUEST ["usuario"] );
		$revisores = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		//var_dump($revisores);
		
	//////////////////////////////////////////////////////////
	//buscar ultima version antp 
	$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarUltimaVersion" );
	$version = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
	//var_dump($version);
	
	//buscar el documento perteneciente a la última versión
	$doc = array (
			'anteproyecto' => $_REQUEST ['anteproyecto'],
			'version' => $_REQUEST ['version']
	);
	
	$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarDocumento2", $doc);
	$docu = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
	//var_dump($docu);
	
		//por cada revisor guardar 1 solicitud
		for($i=0; $i<count($revisores); $i++){
			$arreglo = array (
					'estado' => 'ASIGNADA',
					'pregunta1' => $_REQUEST ['pregunta1'],
					'estudiante' => $_REQUEST ["variable"],
					'anteproyecto' => $_REQUEST ['anteproyecto'],
					'fecha' => $fecha,
					'revisor' => $revisores[$i][0],
					'documento' => $docu[0][0]
			);
			
			$cadenaSql = $this->miSql->getCadenaSql ( 'guardarSolicitud', $arreglo );
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertar" );
			//var_dump($resultado);
		}
		
		//buscar iteracion de ultima evaluacion
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarEvaluaciones", $_REQUEST ['anteproyecto'] );
		$resultadoEvaluaciones = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		//var_dump($resultadoEvaluaciones);
		
		$d = array (
				'fecha' => $fecha,
				'instancia' => 'ESTUDIANTE',
				'documento' => $docu[0][0],
				'concepto' => 'MODIFICADO',
				'iteracion' => $resultadoEvaluaciones[0][0]+1,
				'usuario' => $_REQUEST ['usuario']
		
		);
		
		//guardar en ant_teval
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "guardarRegistro", $d );
		$resultadoDocumento = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registroDocumento' );
			
		
		if ($resultado) {
			redireccion::redireccionar ( 'insertoSolicitud' );
			exit ();
		} else {
			redireccion::redireccionar ( 'noInsertoSolicitud' );
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

