<?php

namespace proyecto\iniciarProyecto\funcion;

use proyecto\iniciarProyecto\funcion\redireccionar;

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
			
			$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/proyecto/";
			$rutaBloque .= $esteBloque ['nombre'];
			
			$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/proyecto/" . $esteBloque ['nombre'];
			
			// Aquí va la lógica de procesamiento
			
			// Al final se ejecuta la redirección la cual pasará el control a otra página
			$conexion = "estructura";
			$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAnteproyecto", $_REQUEST ['anteproyecto'] );
			$matrizAnteproyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			//var_dump($matrizAnteproyecto);
			
			if ($matrizAnteproyecto) {
				
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "actualizarAnteproyecto", $_REQUEST ['anteproyecto'] );
				$matrizActualizar = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "actualizar" );
				//var_dump($matrizActualizar);
				
				if ($matrizActualizar) {
					
					date_default_timezone_set ( 'America/Bogota' );
					
					$fecha = date ( "Y-m-d" );
					
					$actualizar = array (
							"anteproyecto" => $_REQUEST ['anteproyecto'],
							"comentario" => $_REQUEST ['comentario'],
							"usuario" => $_REQUEST ['usuario'],
							"fecha" => $fecha 
					);
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "guardarHistorialAnteproyecto", $actualizar );
					$matrizHistorial = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "actualizar" );
					//var_dump($matrizHistorial);
					if ($matrizHistorial) {
						
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
								"director" => $matrizAnteproyecto [0] ['antp_dir_int'] 
						);
						
						// registro de proyecto
						$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'guardarProyecto', $proyecto );
						$resultadoProyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'insertar' );
						//var_dump($resultadoProyecto);
						if ($resultadoProyecto) {
							
							$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'obtenerID', $proyecto );
							$IDproyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'busqueda' );
							//var_dump($IDproyecto);
							if ($IDproyecto) {
								
								$_REQUEST ['proyecto'] = $IDproyecto [0] [0];
								
								// registro de documento de proyecto: se guarda la �ltima versi�n del anteproyecto
								// 1. Buscar el ultimo documento del anteproyecto
								$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'buscarDocumento', $_REQUEST ['anteproyecto'] );
								$documentoAnteproyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'busqueda' );
								//var_dump($documentoAnteproyecto);
								if ($documentoAnteproyecto) {
									
									// datos del documento que pasa a ser proyecto
									$documento = array (
											"version" => $documentoAnteproyecto [0] [1],
											"observacion" => $documentoAnteproyecto [0] [2],
											"fecha" => $documentoAnteproyecto [0] [3],
											"usuario" => $documentoAnteproyecto [0] [4],
											"proyecto" => $_REQUEST ['proyecto'],
											"url" => $documentoAnteproyecto [0] [6],
											"hash" => $documentoAnteproyecto [0] [7],
											"bytes" => $documentoAnteproyecto [0] [8],
											"nombre" => $documentoAnteproyecto [0] [9],
											"extension" => $documentoAnteproyecto [0] [10] 
									);
									
									// 2. Registrar el documento como proyecto
									$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'registrarDocumento', $documento );
									$documentoProyecto = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registrar' );
									//var_dump($documentoProyecto);
									if ($documentoProyecto) {
										
										$historial = array (
												"estado" => "EN DESARROLLO",
												"fecha" => $fecha,
												"observaciones" => $_REQUEST ['comentario'],
												"usuario" => $_REQUEST ['usuario'] 
										);
										
										// registro de historial
										$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'registrarHistorial', $historial );
										$resultadoHistorial = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'insertar' );
										//var_dump($resultadoHistorial);
										if ($resultadoHistorial) {
											
											$i = 0;
											foreach ( $_FILES as $key => $values ) {
												
												$archivo [$i] = $_FILES [$key];
												$i ++;
											}
											
											$archivo = $archivo [0];
											//var_dump($archivo);
											if (isset ( $archivo )) {
												
												// obtenemos los datos del archivo
												$tamano = $archivo ['size'];
												$tipo = $archivo ['type'];
												$archivo1 = $archivo ['name'];
												$prefijo = substr ( md5 ( uniqid ( rand () ) ), 0, 6 );
												//var_dump($archivo1);
												if ($archivo1 != "") {
													// guardamos el archivo a la carpeta files
													$destino1 = $rutaBloque . "/documento/" . $prefijo . "_" . $archivo1;

													if (copy ( $archivo ['tmp_name'], $destino1 )) {
														$status = "Archivo subido: <b>" . $archivo1 . "</b>";
														$destino1 = $host . "/documento/" . $prefijo . "_" . $archivo1;
														
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
														//var_dump($resultadoDocumento);
														if ($resultadoDocumento) {
															$autores = array ();
															
															for($i = 0; $i < count ( $matrizAnteproyecto ); $i ++) {
																if (! in_array ( $matrizAnteproyecto [$i] ['estantp_estd'], $autores )) {
																	array_push ( $autores, $matrizAnteproyecto [$i] ['estantp_estd'] );
																}
															}
															//var_dump($autores);
															$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "registrarEstudiantes", $autores );
															$resultadoEstudiantes = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registrarEstudiantes' );
															//var_dump($resultadoEstudiantes);
															if ($resultadoEstudiantes) {
																
															
																// Buscar tem�ticas asociadas
																$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarTematicas", $_REQUEST ['anteproyecto'] );
																$matrizTematicas = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
																//var_dump($matrizTematicas);
																
																//falta pasar el proyecto
																$datos = array (
																		'proyecto' => $IDproyecto[0][0],
																		'tematicas' => $matrizTematicas
																);
																
																$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "registrarTematicas", $datos );
 																$resultadoTematicas = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], 'registrarTematicas');
 																//var_dump($resultadoTematicas);
																
																redireccion::redireccionar ( 'inserto' );
																exit ();
															}
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
								} else {
									redireccion::redireccionar ( 'noInserto' );
									exit ();
								}
							} else {
								redireccion::redireccionar ( 'noInserto' );
								exit ();
							}
						} else {
							redireccion::redireccionar ( 'noInserto' );
							exit ();
						}
					} else {
						redireccion::redireccionar ( 'noInserto' );
						exit ();
					}
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

