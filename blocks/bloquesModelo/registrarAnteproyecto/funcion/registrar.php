<?php

namespace bloquesModelo\registrarAnteproyecto\funcion;

use bloquesModelo\registrarAnteproyecto\funcion\redireccionar;

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
			
			$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/bloquesModelo/" . $esteBloque ['nombre'];
			
			// Aquí va la lógica de procesamiento
			
			// Al final se ejecuta la redirección la cual pasará el control a otra página
			$conexion = "estructura";
			$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
			
			// registro de anteproyecto
			$cadenaSql = $this->miSql->getCadenaSql ( 'registrar', $_REQUEST );
			$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, 'insertar' );
			
			if ($resultado) {
				//var_dump ( $_FILES );
				//$fechaActual = date ( 'Y-m-d' );
				
				//registro de historial
				$cadenaSql33 = $this->miSql->getCadenaSql ( 'registrarHistorial', $_REQUEST );
				$resultado33 = $esteRecursoDB->ejecutarAcceso ( $cadenaSql33, 'insertar' );
				
				$i = 0;
				foreach ( $_FILES as $key => $values ) {
					
					$archivo [$i] = $_FILES [$key];
					$i ++;
				}
				
				$archivo = $archivo [0];
				
				if (isset ( $archivo )) {
					// obtenemos los datos del archivo
					$tamano = $archivo ['size'];
					$tipo = $archivo ['type'];
					$archivo1 = $archivo ['name'];
					$prefijo = substr ( md5 ( uniqid ( rand () ) ), 0, 6 );
					
					if ($archivo1 != "") {
						// guardamos el archivo a la carpeta files
						$destino1 = $rutaBloque . "/documento/" . $prefijo . "_" . $archivo1;
						//var_dump($destino1);
						if (copy ( $archivo ['tmp_name'], $destino1 )) {
							$status = "Archivo subido: <b>" . $archivo1 . "</b>";
							$destino1 = $host . "/documento/" . $prefijo . "_" . $archivo1;
							
							
							//var_dump($destino1);
							$arreglo = array (
									'fecha' => $_REQUEST ['fecha'],
									'destino' => $destino1,
									'nombre' => $archivo1,
									'tamano' => $tamano,
									'tipo' => $tipo,
									'estado' => 1 
							);
							
							
							$cadenaSql2 = $this->miSql->getCadenaSql ( "registroDocumento", $arreglo );
							$idAprobacion = $esteRecursoDB->ejecutarAcceso ( $cadenaSql2, 'registroDocumento', $arreglo, "registroDocumento" );	
							//var_dump ( $idAprobacion );
							
							if ($idAprobacion == false) {
								redireccion::redireccionar ( 'noInserto' );
								exit ();
							} else {
								//arreglo para los cods temáticas
								$codTematicas = array ();
								
								$cadenaSql3 = $this->miSql->getCadenaSql ( "registrarEstudiantes", $_REQUEST );
								$resul = $esteRecursoDB->ejecutarAcceso ( $cadenaSql3, 'registrarEstudiantes');
								
								
								$tematicas=$_REQUEST ['nombresTematicas'];
								$porciones = explode(";", $tematicas);
								//var_dump($porciones);
							
								for($i = 0; $i < $_REQUEST ['numTematicas']; $i++){
									$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarCodigosTematicas", $porciones[$i] );
									$matrizItems2 = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
									//var_dump($matrizItems2);
									
									array_push($codTematicas, $matrizItems2[0][0]);
								}
								
								//var_dump($codTematicas);
									
								$cadenaSql5 = $this->miSql->getCadenaSql ( "registrarTematicas", $codTematicas );
								$resul3 = $esteRecursoDB->ejecutarAcceso ( $cadenaSql5, 'registrarTematicas', $codTematicas, "registrarAutores" );
								
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
						redireccion::redireccionar ( 'noInserto');
						exit ();
					}
				}
				redireccion::redireccionar ( 'inserto' );
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

