<?php

namespace bloquesModelo\registrarAnteproyecto\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
	}
	function formulario() {
		
		/**
		 * IMPORTANTE: Este formulario est谩 utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		// ---------------- SECCION: Par谩metros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta t茅cnica es necesario realizar un mezcla entre este arreglo y el espec铆fico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST ['tiempo'] = time ();
		
		$conexion = 'estructura';
		$esteRecurso = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// -------------------------------------------------------------------------------------------------
		
		// ---------------- SECCION: Par谩metros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		// para que lea $_FILES
		$atributos ['tipoFormulario'] = 'multipart/form-data';
		
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Par谩metros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		$atributos ['mensaje'] = 'Creaci贸n de Anteproyecto';
		$atributos ['tamanno'] = 'Enorme';
		$atributos ['linea'] = 'true';
		echo $this->miFormulario->campoMensaje ( $atributos );
		
		// Hidden para guardar los c骴igos seleccionados
		// ////////////////Hidden////////////
		$esteCampo = 'usuario';
		$atributos ["id"] = $esteCampo;
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ['validar'] = '';
		$atributos ["obligatorio"] = true;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ['valor'] = $_REQUEST ['usuario'];
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// ////////////////////////////////////////
		
		/*
		 * $esteCampo = "marcoDatos";
		 * $atributos ['id'] = $esteCampo;
		 * $atributos ["estilo"] = "jqueryui";
		 * $atributos ['tipoEtiqueta'] = 'inicio';
		 * $atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
		 * echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		 */
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'titulo';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = false;
		$atributos ['obligatorio'] = true;
		$atributos ['etiquetaObligatorio'] = true;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['validar'] = 'required';
		$atributos ['anchoEtiqueta'] = 170;
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 50;
		$atributos ['maximoTamanno'] = '';
		$atributos ['columnas'] = 50;
		$atributos ['filas'] = 2;
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoTextArea ( $atributos );
		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
		
		// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
		$esteCampo = 'autores';
		$atributos ['nombre'] = $esteCampo;
		$atributos ['id'] = $esteCampo;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['tab'] = $tab;
		$atributos ['marco'] = true;
		$atributos ['seleccion'] = - 1;
		$atributos ['evento'] = '';
		$atributos ['deshabilitado'] = false;
		$atributos ['limitar'] = true;
		$atributos ['tamanno'] = 1;
		
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['validar'] = 'required';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['anchoEtiqueta'] = 170;
		$atributo ['dobleLinea'] = true;
		$atributos ['anchoCaja'] = 600;
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarEstudiantes" );
		$matrizAutores = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		if ($matrizAutores) {
			$atributos ['matrizItems'] = $matrizAutores;
		}
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['seleccion'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['seleccion'] = - 1;
		}
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		if ($matrizAutores) {
			echo $this->miFormulario->campoCuadroLista ( $atributos );
		} else {
			echo "**REGISTRE PRIMERO UN ESTUDIANTE";
		}
		unset ( $atributos );
		
		if ($matrizAutores) {
			// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
			
			?>

<div id="contenedor1"></div>

<button type="button" id="btn1" class="btn btn-primary btn-lg active">Agregar</button>

<?php
			
			// Hidden para guardar los c骴igos seleccionados
			// ////////////////Hidden////////////
			$esteCampo = 'autoresArreglo';
			$atributos ["id"] = $esteCampo;
			$atributos ["tipo"] = "hidden";
			$atributos ['estilo'] = '';
			$atributos ['validar'] = '';
			$atributos ["obligatorio"] = true;
			$atributos ['marco'] = true;
			$atributos ["etiqueta"] = "";
			
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ////////////////////////////////////////
			
			// Hidden para guardar el n鷐ero de estudiantes
			// ////////////////Hidden////////////
			$esteCampo = 'numEstudiantes';
			$atributos ["id"] = $esteCampo;
			$atributos ["tipo"] = "hidden";
			$atributos ['estilo'] = '';
			$atributos ['validar'] = '';
			$atributos ["obligatorio"] = true;
			$atributos ['marco'] = true;
			$atributos ["etiqueta"] = "";
			
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ////////////////////////////////////////
			
			// echo $this->miFormulario->marcoAgrupacion ( 'fin' );
			
			// ------------------Division -------------------------
			$atributos ["id"] = "division1";
			$atributos ["estilo"] = "";
			$atributos ["titulo"] = "Agregar";
			echo $this->miFormulario->division ( "inicio", $atributos );
			
			/*
			 * $esteCampo = "marcoDatos2";
			 * $atributos ['id'] = $esteCampo;
			 * $atributos ["estilo"] = "jqueryui";
			 * $atributos ['tipoEtiqueta'] = 'inicio';
			 * //$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
			 * echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
			 */
			
			// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
			$esteCampo = 'seleccionarDirectorInterno';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['tab'] = $tab;
			$atributos ['marco'] = true;
			$atributos ['seleccion'] = - 1;
			$atributos ['evento'] = '';
			$atributos ['deshabilitado'] = false;
			$atributos ['limitar'] = true;
			$atributos ['tamanno'] = 1;
			$atributos ['columnas'] = 1;
			
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['validar'] = 'required';
			
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['anchoEtiqueta'] = 170;
			$atributos ['anchoCaja'] = 60;
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarDocentes" );
			$matrizDocentes = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			if ($matrizDocentes) {
				$atributos ['matrizItems'] = $matrizDocentes;
			}
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['seleccion'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['seleccion'] = - 1;
			}
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			if ($matrizDocentes) {
				echo $this->miFormulario->campoCuadroLista ( $atributos );
			} else {
				echo "**REGISTRE PRIMERO UN DOCENTE";
			}
			
			// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
			
			if ($matrizDocentes) {
				// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
				$esteCampo = 'seleccionarProgramaCurricular';
				$atributos ['nombre'] = $esteCampo;
				$atributos ['id'] = $esteCampo;
				
				$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['tab'] = $tab;
				$atributos ['marco'] = true;
				$atributos ['seleccion'] = - 1;
				$atributos ['evento'] = '';
				$atributos ['deshabilitado'] = false;
				$atributos ['limitar'] = true;
				$atributos ['tamanno'] = 1;
				$atributos ['columnas'] = 1;
				
				$atributos ['estilo'] = 'jqueryui';
				$atributos ['validar'] = 'required';
				
				$atributos ["etiquetaObligatorio"] = true;
				$atributos ['anchoEtiqueta'] = 170;
				$atributos ['anchoCaja'] = 60;
				
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarProgramasCurriculares" );
				$matrizProgramas = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
				
				if ($matrizProgramas) {
					$atributos ['matrizItems'] = $matrizProgramas;
				}
				
				if (isset ( $_REQUEST [$esteCampo] )) {
					$atributos ['valor'] = $_REQUEST [$esteCampo];
				} else {
					$atributos ['valor'] = '';
				}
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				if ($matrizProgramas) {
					echo $this->miFormulario->campoCuadroLista ( $atributos );
				} else {
					echo "**REGISTRE PRIMERO UN PROGRAMA CURRICULAR";
				}
				
				// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
				
				if ($matrizProgramas) {
					// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
					$esteCampo = 'seleccionarTematica';
					$atributos ['nombre'] = $esteCampo;
					$atributos ['id'] = $esteCampo;
					
					$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
					$atributos ['tab'] = $tab;
					$atributos ['marco'] = true;
					$atributos ['seleccion'] = - 1;
					$atributos ['evento'] = '';
					$atributos ['deshabilitado'] = false;
					$atributos ['limitar'] = true;
					$atributos ['tamanno'] = 1;
					// $atributos ['columnas'] = 2;
					
					$atributos ['estilo'] = 'jqueryui';
					$atributos ['validar'] = 'required';
					
					$atributos ["etiquetaObligatorio"] = true;
					$atributos ['anchoEtiqueta'] = 170;
					$atributos ['anchoCaja'] = 60;
					
					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarTematicas" );
					$matrizTematicas = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
					
					if ($matrizTematicas) {
						$atributos ['matrizItems'] = $matrizTematicas;
					}
					
					if (isset ( $_REQUEST [$esteCampo] )) {
						$atributos ['seleccion'] = $_REQUEST [$esteCampo];
					} else {
						$atributos ['seleccion'] = - 1;
					}
					
					// Aplica atributos globales al control
					$atributos = array_merge ( $atributos, $atributosGlobales );
					if ($matrizTematicas) {
						echo $this->miFormulario->campoCuadroLista ( $atributos );
					} else {
						echo "**REGISTRE PRIMERO UNA TEMATICA";
					}
					
					// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
					if ($matrizTematicas) {
						?>

<div id="contenedor2"></div>

<button type="button" id="btn2" class="btn btn-primary btn-lg active">Agregar</button>
<?php
						
						// Hidden para guardar los nombres de las tem醫icas seleccionadas
						// ////////////////Hidden////////////
						$esteCampo = 'nombresTematicas';
						$atributos ["id"] = $esteCampo;
						$atributos ["tipo"] = "hidden";
						$atributos ['estilo'] = '';
						$atributos ['validar'] = '';
						$atributos ["obligatorio"] = true;
						$atributos ['marco'] = true;
						$atributos ["etiqueta"] = "";
						
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						// ////////////////////////////////////////
						
						// Hidden para guardar el n鷐ero de estudiantes
						// ////////////////Hidden////////////
						$esteCampo = 'numTematicas';
						$atributos ["id"] = $esteCampo;
						$atributos ["tipo"] = "hidden";
						$atributos ['estilo'] = '';
						$atributos ['validar'] = '';
						$atributos ["obligatorio"] = true;
						$atributos ['marco'] = true;
						$atributos ["etiqueta"] = "";
						
						$atributos = array_merge ( $atributos, $atributosGlobales );
						echo $this->miFormulario->campoCuadroTexto ( $atributos );
						unset ( $atributos );
						// ////////////////////////////////////////
						
						// echo $this->miFormulario->marcoAgrupacion ( 'fin' );
						
						$atributos ['mensaje'] = 'Creaci贸n de Anteproyecto';
						$atributos ['tamanno'] = 'Enorme';
						$atributos ['linea'] = 'true';
						echo $this->miFormulario->division ( $atributos );
						
						/*
						 * $esteCampo = "marcoDatos3";
						 * $atributos ['id'] = $esteCampo;
						 * $atributos ["estilo"] = "jqueryui";
						 * $atributos ['tipoEtiqueta'] = 'inicio';
						 * //$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
						 * echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
						 */
						
						// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
						$esteCampo = 'modalidadGrado';
						$atributos ['nombre'] = $esteCampo;
						$atributos ['id'] = $esteCampo;
						$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
						$atributos ['tab'] = $tab;
						$atributos ['marco'] = true;
						$atributos ['seleccion'] = - 1;
						$atributos ['evento'] = '';
						$atributos ['deshabilitado'] = false;
						$atributos ['limitar'] = true;
						$atributos ['tamanno'] = 1;
						$atributos ['columnas'] = 1;
						
						$atributos ['estilo'] = 'jqueryui';
						$atributos ['validar'] = 'required';
						
						$atributos ["etiquetaObligatorio"] = true;
						$atributos ['anchoEtiqueta'] = 170;
						$atributos ['anchoCaja'] = 60;
						
						$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarModalidades" );
						$matrizModalidades = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
						
						if ($matrizModalidades) {
							$atributos ['matrizItems'] = $matrizModalidades;
						}
						
						if (isset ( $_REQUEST [$esteCampo] )) {
							$atributos ['seleccion'] = $_REQUEST [$esteCampo];
						} else {
							$atributos ['seleccion'] = - 1;
						}
						
						// Aplica atributos globales al control
						$atributos = array_merge ( $atributos, $atributosGlobales );
						if ($matrizModalidades) {
							echo $this->miFormulario->campoCuadroLista ( $atributos );
						} else {
							echo "**NO HAY REGISTRADA NINGUNA MODALIDAD DE GRADO, CONTACTE AL ADMINISTRADOR DEL SISTEMA";
						}
						
						// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
						
						if ($matrizModalidades) {
							
							// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
							$esteCampo = 'fecha';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['columnas'] = 1;
							$atributos ['dobleLinea'] = false;
							$atributos ['obligatorio'] = true;
							$atributos ['etiquetaObligatorio'] = true;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required, custom[date]';
							$atributos ['anchoEtiqueta'] = 170;
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 25;
							$atributos ['maximoTamanno'] = '';
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
							
							// ---------------- CONTROL: Archivos --------------------------------------------------------
							// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
							$esteCampo = 'archivo';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'file';
							
							$atributos ['estilo'] = 'jqueryui';
							$atributos ['marco'] = true;
							$atributos ['estiloMarco'] = '';
							$atributos ["etiquetaObligatorio"] = true;
							$atributos ['columnas'] = 1;
							$atributos ['dobleLinea'] = 0;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required, accept="application/pdf" ';
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = true;
							$atributos ['tamanno'] = 200;
							$atributos ['maximoTamanno'] = '';
							$atributos ['anchoEtiqueta'] = 170;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoCuadroTexto ( $atributos );
							unset ( $atributos );
							// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
							// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
							
							// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
							$esteCampo = 'observaciones';
							$atributos ['id'] = $esteCampo;
							$atributos ['nombre'] = $esteCampo;
							$atributos ['tipo'] = 'text';
							$atributos ['estilo'] = '';
							$atributos ['marco'] = true;
							$atributos ['columnas'] = 1;
							$atributos ['dobleLinea'] = false;
							$atributos ['obligatorio'] = true;
							$atributos ['etiquetaObligatorio'] = true;
							$atributos ['tabIndex'] = $tab;
							$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['validar'] = 'required';
							$atributos ['anchoEtiqueta'] = 170;
							
							if (isset ( $_REQUEST [$esteCampo] )) {
								$atributos ['valor'] = $_REQUEST [$esteCampo];
							} else {
								$atributos ['valor'] = '';
							}
							$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
							$atributos ['deshabilitado'] = false;
							$atributos ['tamanno'] = 25;
							$atributos ['maximoTamanno'] = '';
							$atributos ['columnas'] = 50;
							$atributos ['filas'] = 2;
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoTextArea ( $atributos );
							// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
							
							// ------------------Division para los botones-------------------------
							$atributos ["id"] = "botones";
							$atributos ["estilo"] = "marcoBotones";
							$atributos ["titulo"] = "Enviar Informaci贸n";
							echo $this->miFormulario->division ( "inicio", $atributos );
							
							// -----------------CONTROL: Bot贸n ----------------------------------------------------------------
							$esteCampo = 'botonCrear';
							$atributos ["id"] = $esteCampo;
							$atributos ["tabIndex"] = $tab;
							$atributos ["tipo"] = 'boton';
							// submit: no se coloca si se desea un tipo button gen茅rico
							$atributos ['submit'] = true;
							$atributos ["estiloMarco"] = '';
							$atributos ["estiloBoton"] = 'jquery';
							// verificar: true para verificar el formulario antes de pasarlo al servidor.
							$atributos ["verificar"] = '';
							$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la funci贸n submit declarada en ready.js
							$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoBoton ( $atributos );
							// -----------------FIN CONTROL: Bot贸n -----------------------------------------------------------
							
							// -----------------CONTROL: Bot贸n ----------------------------------------------------------------
							$esteCampo = 'botonCancelar';
							$atributos ["id"] = $esteCampo;
							$atributos ["tabIndex"] = $tab;
							$atributos ["tipo"] = 'boton';
							// submit: no se coloca si se desea un tipo button gen茅rico
							$atributos ['submit'] = true;
							$atributos ["estiloMarco"] = '';
							$atributos ["estiloBoton"] = '';
							// verificar: true para verificar el formulario antes de pasarlo al servidor.
							$atributos ["verificar"] = '';
							$atributos ["tipoSubmit"] = ''; // Dejar vacio para un submit normal, en este caso se ejecuta la funci贸n submit declarada en ready.js
							$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
							$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
							$tab ++;
							
							// Aplica atributos globales al control
							$atributos = array_merge ( $atributos, $atributosGlobales );
							echo $this->miFormulario->campoBoton ( $atributos );
							// -----------------FIN CONTROL: Bot贸n -----------------------------------------------------------
							
							// ------------------Fin Division para los botones-------------------------
							echo $this->miFormulario->division ( "fin" );
						}
					}
				}
			}
		}
		
		// echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		
		// ------------------- SECCION: Paso de variables ------------------------------------------------
		
		/**
		 * En algunas ocasiones es 煤til pasar variables entre las diferentes p谩ginas.
		 * SARA permite realizar esto a trav茅s de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesi贸n. Estar谩n disponibles durante toda la sesi贸n de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor ser谩 una cadena codificada que contiene las variables.
		 * (c) a trav閟 de campos ocultos en los formularios. (deprecated)
		 */
		
		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
		
		// Paso 1: crear el listado de variables
		
		$valorCodificado = "action=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
		$valorCodificado .= "&opcion=registrar";
		/**
		 * SARA permite que los nombres de los campos sean din谩micos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo.
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
		// Paso 2: codificar la cadena resultante
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
		
		$atributos ["id"] = "formSaraData"; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ["obligatorio"] = false;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN SECCION: Paso de variables -------------------------------------------------
		
		// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
		
		// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
		// Se debe declarar el mismo atributo de marco con que se inici贸 el formulario.
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
		
		return true;
	}
	function mensaje() {
		
		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this->miConfigurador->getVariableConfiguracion ( 'mostrarMensaje' );
		$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );
		
		if ($mensaje) {
			
			$tipoMensaje = $this->miConfigurador->getVariableConfiguracion ( 'tipoMensaje' );
			
			if ($tipoMensaje == 'json') {
				
				$atributos ['mensaje'] = $mensaje;
				$atributos ['json'] = true;
			} else {
				$atributos ['mensaje'] = $this->lenguaje->getCadena ( $mensaje );
			}
			// -------------Control texto-----------------------
			$esteCampo = 'divMensaje';
			$atributos ['id'] = $esteCampo;
			$atributos ["tamanno"] = '';
			$atributos ["estilo"] = 'information';
			$atributos ["etiqueta"] = '';
			$atributos ["columnas"] = ''; // El control ocupa 47% del tama帽o del formulario
			echo $this->miFormulario->campoMensaje ( $atributos );
			unset ( $atributos );
		}
		
		return true;
	}
}

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario, $this->sql );

$miFormulario->formulario ();
$miFormulario->mensaje ();

?>