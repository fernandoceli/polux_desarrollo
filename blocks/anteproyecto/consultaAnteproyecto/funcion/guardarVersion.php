<?php

namespace anteproyecto\consultaAnteproyecto\funcion;

use anteproyecto\consultaAnteproyecto\funcion\redireccionar;

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
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/anteproyecto/";
		$rutaBloque .= $esteBloque ['nombre'];
		
		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/anteproyecto/" . $esteBloque ['nombre'];
		
		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		//var_dump ( $_REQUEST );
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAnteproyecto", $_REQUEST ['anteproyecto'] );
		$matrizProyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$fecha = date ( "Y-m-d" );
		
		$i = 0;
		//var_dump($_FILES);
		foreach ( $_FILES as $key => $values ) {
				
			$archivo [$i] = $_FILES [$key];
			$i ++;
		}
		
		$archivo = $archivo [0];
		
// 		echo isset ( $archivo );
		
		if (isset ( $archivo )) {
			// obtenemos los datos del archivo
			$tamano = $archivo ['size'];
			$tipo = $archivo ['type'];
			$archivo1 = $archivo ['name'];
			$prefijo = substr ( md5 ( uniqid ( rand () ) ), 0, 6 );
			
// 			echo $archivo1;
			
			if ($archivo1 != "") {
				// guardamos el archivo a la carpeta files
				$destino1 = $rutaBloque . "/documento/" . $prefijo . "_" . $archivo1;
				// var_dump($destino1);
				if (copy ( $archivo ['tmp_name'], $destino1 )) {
					$status = "Archivo subido: <b>" . $archivo1 . "</b>";
					$destino1 = $host . "/documento/" . $prefijo . "_" . $archivo1;
					
					$aDoc = array (
							'version' => $_REQUEST['version'],
							'observacion' => $_REQUEST ['observacionesVersion'],
							'fecha' => $fecha,
							'destino' => $destino1,
							'nombre' => $archivo1,
							'tamano' => $tamano,
							'tipo' => $tipo,
							'url' => $destino1,
							'hash' => 'hash',
							'estado' => 1,
							'usuario' => $_REQUEST ['usuario']
							
					);
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "registrarVersionDoc", $aDoc );
					$resultadoDocumento = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registroDocumento' );
					redireccion::redireccionar ( 'insertoDocumento' );
					exit ();
				} else {
					$status = "Error al subir el archivo";
					redireccion::redireccionar ( 'noInsertoDocumento' );
					exit ();
				}
			} else {
				$status = "Error al subir el archivo";
				redireccion::redireccionar ( 'noInsertoDocumento' );
				exit ();
			}
		} else {
			$status = "Error al subir el archivo";
			redireccion::redireccionar ( 'noInsertoDocumento' );
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
