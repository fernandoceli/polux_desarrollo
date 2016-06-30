<?php

namespace informeFinal\iniciarInformeFinal\funcion;

use informeFinal\iniciarInformeFinal\funcion\redireccionar;

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
			
			echo "Cargando, espere un momento...";
			
			$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
			
			$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/informefinal/";
			$rutaBloque .= $esteBloque ['nombre'];
			
			$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/informefinal/" . $esteBloque ['nombre'];
			
			// Aquí va la lógica de procesamiento
			
			// Al final se ejecuta la redirección la cual pasará el control a otra página
			$conexion = "estructura";
			$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
			
// 			var_dump ( $_REQUEST );
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarProyecto", $_REQUEST ['proyecto'] );
			$matrizProyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "actualizarProyecto", $_REQUEST ['proyecto'] );
			$matrizActualizar = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "actualizar" );
			// echo $atributos['cadena_sql'];
			
			if ($matrizActualizar) {
				
				date_default_timezone_set ( 'America/Bogota' );
				
				$fecha = date ( "Y-m-d" );
				
				$informefinal = array (
						"proy" => $_REQUEST ['proyecto'],
						"modalidad" => $matrizProyecto [0] ['proy_moda'],
						"programa" => $matrizProyecto [0] ['proy_pcur'],
						"titulo" => $_REQUEST ['titulo'],
						"proy_fcrea" => $fecha,
						"descripcion" => $_REQUEST ['descripcion'],
						"comentario" => $_REQUEST ['comentario'],
						"estado" => "RADICADO",
						"duracion" => "6",
						"director" => $matrizProyecto [0] ['proy_dir_int'] 
				);
				
				// registro de informe
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'guardarInformeFinal', $informefinal );
				$resultadoInformeFinal = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'insertar' );
// 				var_dump ( $resultadoInformeFinal );
				
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'obtenerID', $informefinal );
				$IDproyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'busqueda' );
				
// 				var_dump ( $IDproyecto );
				
				$_REQUEST ['informe'] = $IDproyecto [0] [0];
				
				// registro de documento de proyecto: se guarda la última versión del proyecto
				// 1. Buscar el último documento del proyecto
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'buscarDocumento', $_REQUEST ['proyecto'] );
				$documentoProyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'busqueda' );
 			//	var_dump($documentoProyecto);
				// datos del documento de proyecto que pasa a ser inf final
				$documento = array (
						"version" => 1,
						"observacion" => $documentoProyecto [0] [2],
						"fecha" => $documentoProyecto [0] [3],
						"usuario" => $documentoProyecto [0] [4],
						"informe" => $_REQUEST ['informe'],
						"url" => $documentoProyecto [0] [6],
						"hash" => $documentoProyecto [0] [7],
						"bytes" => $documentoProyecto [0] [8],
						"nombre" => $documentoProyecto [0] [9],
						"extension" => $documentoProyecto [0] [10] 
				);
// 				var_dump ( $documento );
				// 2. Registrar el documento como informe final
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'registrarDocumento', $documento );
				$documentoInformeFinal = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registrar' );
 			//	var_dump($documentoInformeFinal);
				
				if ($documentoInformeFinal) {
					// var_dump ( $_FILES );
					// $fechaActual = date ( 'Y-m-d' );
					
					$historial = array (
							"estado" => "RADICADO",
							"fecha" => $fecha,
							"observaciones" => $_REQUEST ['comentario'],
							"usuario" => $_REQUEST ['usuario'] 
					);
					
					// registro de historial
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'registrarHistorial', $historial );
					$resultadoHistorial = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'insertar' );
					// echo $atributos ['cadena_sql'];
					// exit();
					//echo $resultadoHistorial;
					
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
									
									echo $resultadoDocumento;
									
									if ($resultadoDocumento == false) {
										
										redireccion::redireccionar ( 'noInserto' );
										exit ();
									} else {
										
										$autores = array ();
										// Buscar estudiantes asociados
										$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAutores", $_REQUEST ['proyecto'] );
										$matrizAutores = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
										
										
										for($i = 0; $i < count ( $matrizAutores ); $i ++) {
											if (! in_array ( $matrizAutores[$i] ['estudiante'], $autores )) {
												array_push ( $autores, $matrizAutores[$i] ['estudiante'] );
											}
										}
										
// 										var_dump($autores);
										
										$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "registrarEstudiantes", $autores );
										$resultadoEstudiantes = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registrarEstudiantes' );
										
										$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarTematicas", $_REQUEST ['proyecto'] );
										$matrizTematicas = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
										$tematicas = array ();
										
										for($i = 0; $i < count ( $matrizTematicas ); $i ++) {
											if (! in_array ( $matrizTematicas [$i] ['acono_acono'], $tematicas )) {
												array_push ( $tematicas, $matrizTematicas [$i] ['acono_acono'] );
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
						//var_dump ( "Error al crear el historial" );
						redireccion::redireccionar ( 'noInserto' );
						exit ();
					}
				} else {
// 					var_dump ( "Error al crear el informe" );
					redireccion::redireccionar ( 'noInserto' );
					exit ();
				}
			} else {
// 				var_dump ( "Error al crear el informe" );
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

