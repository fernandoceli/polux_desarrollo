<?php

namespace bloquesModelo\iniciarProyecto\funcion;

use bloquesModelo\iniciarProyecto\funcion\redireccionar;

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
		if (isset ( $_REQUEST ['botonIniciar'] ) && $_REQUEST ['botonIniciar'] == "true") {
			$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
			
			$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/bloquesModelo/";
			$rutaBloque .= $esteBloque ['nombre'];
			
			$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/bloquesModelo/" . $esteBloque ['nombre'];
			
			// Aquí va la lógica de procesamiento
			
			// Al final se ejecuta la redirección la cual pasará el control a otra página
			$conexion = "estructura";
			$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
			
			var_dump ( $_REQUEST );
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarProyecto", $_REQUEST ['proyecto'] );
			$matrizAnteproyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			// echo $atributos['cadena_sql'];
			var_dump ( $matrizAnteproyecto );
			// exit();
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "actualizarAnteproyecto", $_REQUEST ['anteproyecto'] );
			$matrizActualizar = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "actualizar" );
			// echo $atributos['cadena_sql'];
			
			date_default_timezone_set ( 'America/Bogota' );
			
			$fecha = date ( "Y-m-d" );
			
			$proyecto = array (
					"ante" => $_REQUEST ['anteproyecto'],
					"modalidad" => $matrizAnteproyecto [0] ['antp_moda'],
					"programa" => $matrizAnteproyecto [0] ['antp_pcur'],
					"titulo" => $_REQUEST ['titulo'],
					"proy_fcrea" => $fecha,
					"descripcion" => $_REQUEST ['descripcion'],
					"comentario" => $_REQUEST ['comentario'],
					"estado" => "EN DESARROLLO",
					"duracion" => "6", 
					"director" => $matrizAnteproyecto[0]['antp_dir_int']
			);
			
			// registro de proyecto
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'guardarProyecto', $proyecto );
			$resultadoProyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'insertar' );
			var_dump($resultadoProyecto);
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'obtenerID', $proyecto );
			$IDproyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'busqueda' );
			
			var_dump($IDproyecto);
			
			$_REQUEST['proyecto'] = $IDproyecto[0][0];
			// echo $atributos['cadena_sql'];
			echo $resultadoProyecto;
			
			// registro de documento de proyecto: se guarda la última versión del anteproyecto
			//1. Buscar el ultimo documento del anteproyecto
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'buscarDocumento', $_REQUEST ['anteproyecto'] );
			$documentoAnteproyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'busqueda' );
			//datos del documento que pasa a ser proyecto
			$documento = array (
					"version" => $documentoAnteproyecto[0][1],
					"observacion" => $documentoAnteproyecto[0][2],
					"fecha" => $documentoAnteproyecto[0][3],
					"usuario" => $documentoAnteproyecto[0][4],
					"proyecto" =>$_REQUEST['proyecto'],
					"url" => $documentoAnteproyecto[0][6],
					"hash" => $documentoAnteproyecto[0][7],
					"bytes" => $documentoAnteproyecto[0][8],
					"nombre" => $documentoAnteproyecto[0][9],
					"extension" => $documentoAnteproyecto[0][10]
			);
			var_dump($documento );
			exit();
			//2. Registrar el documento como proyecto
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'registrarDocumento', $documento );
			$documentoProyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registrar' );
			
			if ($resultadoProyecto) {
				// var_dump ( $_FILES );
				// $fechaActual = date ( 'Y-m-d' );
				
				$historial = array (
						"estado" => "EN DESARROLLO",
						"fecha" => $fecha,
						"observaciones" => $_REQUEST ['comentario'],
						"usuario" => $_REQUEST ['usuario'] 
				);
				
				// registro de historial
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'registrarHistorial', $historial );
				$resultadoHistorial = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'insertar' );
				// echo $atributos ['cadena_sql'];
				// exit();
				echo $resultadoHistorial;
				
				if ($resultadoHistorial) {
					
					$i = 0;
					foreach ( $_FILES as $key => $values ) {
						
						$archivo [$i] = $_FILES [$key];
						$i ++;
					}
					
					$archivo = $archivo [0];
					
					echo isset ( $archivo );
					
					if (isset ( $archivo )) {
						// obtenemos los datos del archivo
						$tamano = $archivo ['size'];
						$tipo = $archivo ['type'];
						$archivo1 = $archivo ['name'];
						$prefijo = substr ( md5 ( uniqid ( rand () ) ), 0, 6 );
						
						echo $archivo1;
						
						if ($archivo1 != "") {
							// guardamos el archivo a la carpeta files
							$destino1 = $rutaBloque . "/documento/" . $prefijo . "_" . $archivo1;
							// var_dump($destino1);
							if (copy ( $archivo ['tmp_name'], $destino1 )) {
								$status = "Archivo subido: <b>" . $archivo1 . "</b>";
								$destino1 = $host . "/documento/" . $prefijo . "_" . $archivo1;
								
								// var_dump($destino1);
								$aDoc = array (
										'fecha' => $fecha,
										'destino' => $destino1,
										'nombre' => $archivo1,
										'tamano' => $tamano,
										'tipo' => $tipo,
										'estado' => 1,
										"usuario" => $_REQUEST ['usuario'] 
								);
								
								$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "registrarAnexo", $aDoc );
								$resultadoDocumento = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registroDocumento', $aDoc, "registroDocumento" );
								// var_dump ( $idAprobacion );
								// exit ();
								echo $resultadoDocumento;
								
								if ($resultadoDocumento == false) {
									//exit ();
									//redireccion::redireccionar ( 'noInserto' );
									exit ();
								} else {
									
									$autores = array ();
									
									for($i = 0; $i < count ( $matrizAnteproyecto ); $i ++) {
										if (! in_array ( $matrizAnteproyecto [$i] ['estantp_estd'] , $autores)) {
											array_push ( $autores, $matrizAnteproyecto [$i] ['estantp_estd'] );
										}
									}
									
									$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "registrarEstudiantes", $autores );
									$resultadoEstudiantes = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registrarEstudiantes' );
									
									var_dump ( $resultadoEstudiantes );
// 									exit();
									
									$tematicas = array ();
										
									for($i = 0; $i < count ( $matrizAnteproyecto ); $i ++) {
										if (! in_array ( $matrizAnteproyecto [$i] ['acantp_acono'] , $tematicas)) {
											array_push ( $tematicas, $matrizAnteproyecto [$i] ['acantp_acono'] );
										}
									}
									
									$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "registrarTematicas", $tematicas );
									$resultadoTematicas = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registrarTematicas', $tematicas, "registrarAutores" );
									
									redireccion::redireccionar ( 'inserto' );
									exit ();
								}
							} else {
								$status = "Error al subir el archivo";
								redireccion::redireccionar ( 'noInserto' );
								exit ();
							}
						} else {
							$status = "Error al subir archivo";
							redireccion::redireccionar ( 'noInserto' );
							exit ();
						}
					}
					redireccion::redireccionar ( 'inserto' );
					exit ();
				} else {
					redireccion::redireccionar ( 'noInserto' );
					exit ();
				}
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

