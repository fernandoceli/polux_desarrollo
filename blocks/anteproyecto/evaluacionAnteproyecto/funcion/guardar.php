<?php

namespace anteproyecto\evaluacionAnteproyecto\funcion;

use anteproyecto\evaluacionAnteproyecto\funcion\redireccionar;

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
		
		//var_dump ( $_REQUEST );
		// respuestas formulario 1
		$arreglo = json_decode ( $_REQUEST ['respForm1'] );
		
		// respuestas formulario 2
		$arreglo2 = json_decode ( $_REQUEST ['respForm2'] );
		
		// respuestas formulario 3
		$arreglo3 = json_decode ( $_REQUEST ['respForm3'] );
		
		$fecha = date ( 'Y-m-d' );
		
		//definir iteraci�n
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'ultimaIteracion', $_REQUEST ['ante'] );
		$iteracion = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'busqueda' );
		
		if($iteracion[0][0]==null){
			$var=1;
		}else{
			$var=$iteracion[0][0];
		}
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'buscarUltimoDocumento', $_REQUEST ['ante'] );
		$documento = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'busqueda' );
		
		$eval = array (
				'documento' => $documento[0][0],
				'concepto' => $_REQUEST ['seleccionarConcepto'],
				'usuario' => $_REQUEST['usuario'],
				'iteracion' => $var
		);
		//var_dump($eval);
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'registrarEvaluacion', $eval );
		$matrizPrueba = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
// 		echo $atributos ['cadena_sql'];
		$eval = $matrizPrueba [0] [0];
		//var_dump ( $eval );
		
		if ($matrizPrueba) {
			// guardar respuestas del cuestionario
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarPreguntas" );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
// 			echo $atributos ['cadena_sql'];
			// var_dump($matrizItems);
			
			$preguntas1=array(1,2,3,4,7);
			for ($i=0; $i<count($arreglo); $i++){
				$datos = array (
						'evaluacion' => $matrizPrueba[0][0],
						'pregunta' => $preguntas1[$i],
						'opcion' => $arreglo[$i]->respuesta,
						'justificacion' => $arreglo[$i]->justificacion
				);
					
				$cadenaSql = $this->miSql->getCadenaSql ( 'registrarRespuestas', $datos );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
			}
			
			$num=7;
			for ($i=0; $i<count($arreglo2); $i++){
				
				$datos2 = array (
						'evaluacion' => $matrizPrueba[0][0],
						'pregunta' => $matrizItems [$num][0],
						'opcion' => $arreglo2[$i]->respuesta,
						'justificacion' => $arreglo2[$i]->justificacion
				);
				
				$cadenaSql = $this->miSql->getCadenaSql ( 'registrarRespuestas', $datos2 );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
				$num=$num+1;
			}
			
			$preguntas3=array(5,12,14,15);
			for ($i=0; $i<count($arreglo3); $i++){
			
				$datos3 = array (
						'evaluacion' => $matrizPrueba[0][0],
						'pregunta' => $preguntas3[$i],
						'opcion' => $arreglo3[$i]->respuesta,
						'justificacion' => $arreglo3[$i]->justificacion
				);
			
				$cadenaSql = $this->miSql->getCadenaSql ( 'registrarRespuestas', $datos3 );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
			}
			
			$datos4 = array (
					'evaluacion' => $matrizPrueba[0][0],
					'pregunta' => 16,
					'opcion' => 3,
					'justificacion' => $_REQUEST['pregunta41']
			);
				
			$cadenaSql = $this->miSql->getCadenaSql ( 'registrarRespuestas', $datos4 );
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
// 			echo $atributos ['cadena_sql'];
			
			
			//buscar codigo del docente
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarCod", $_REQUEST['usuario'] );
			$docente = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			//var_dump($docente);
			
			//actualizar estado de la solicitud de revisi�n
			$cadenaSql = $this->miSql->getCadenaSql ( 'actualizarEstadoSolicitud', $docente[0][0] );
			$resul1 = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' );
			//var_dump($resul1);
			
			//si la iteracion=3, y concepto = modificable
			if($var==3 && $_REQUEST ['seleccionarConcepto']=='MODIFICABLE'){
				//antp->NO APROBADO
				$cadenaSql = $this->miSql->getCadenaSql ( 'actualizarEstadoAntp', $_REQUEST );
				$no_aprobado= $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'actualizar' );
			}
			
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
