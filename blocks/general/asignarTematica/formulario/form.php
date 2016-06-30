<?php

namespace general\asignarTematica\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSesion;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
		
		$this->miSesion = \Sesion::singleton ();
	}
	function formulario() {
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST ['tiempo'] = time ();
		$tiempo = $_REQUEST ['tiempo'];
		
		$conexion = 'estructura';
		$esteRecurso = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$seccion ['tiempo'] = $tiempo;
		
		$usuario = $this->miSesion->getSesionUsuarioId ();
		
		// -------------------------------------------------------------------------------------------------
		
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = '';
		
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		//$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = 'ancho';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		$roles = $this->miSesion->RolesSesion ();
		$rol = array();
		
		foreach ($roles AS $r) {
			array_push($rol, $r['rol']);
		}
		
		$acceso = false;
		$mostrar = true;
		
		if (in_array("Coordinador", $rol) || in_array("Docente", $rol)) {
			$acceso = true;
			$codigo = $roles [0] [0];
			$_REQUEST ["variable"] = $codigo;
		}
		
		if (in_array('Administrador General', $rol) || in_array('Desarrollo y Pruebas', $rol)) {
			$acceso = true;
		}
		$atributos ['mensaje'] = 'Asignar temáticas de Interés';
		$atributos ['tamanno'] = 'Enorme';
		$atributos ['linea'] = 'true';
		$atributos['estiloEnLinea']= "margin-top: 1%";
		echo $this->miFormulario->campoMensaje ( $atributos );
		
		$esteCampo = "marcoDatos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		$atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = $this->lenguaje->getCadena ( $esteCampo );
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		
		// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
		$esteCampo = 'docente';
		$atributos ['nombre'] = $esteCampo;
		$atributos ['id'] = $esteCampo;
		
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['tab'] = $tab;
		$atributos ['marco'] = true;
		$atributos ['evento'] = '';
		$atributos ['deshabilitado'] = false;
		$atributos ['limitar'] = true;
		$atributos ['tamanno'] = 1;
		$atributos ['columnas'] = 1;
		
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['validar'] = 'required';
		
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['anchoEtiqueta'] = 220;
		$atributos ['anchoCaja'] = 60;
		
		if (in_array("Coordinador", $rol)) {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarDocentes" );
		} else {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarDocentes", $codigo);
		}
		$matrizDocentes = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		if ($matrizDocentes) {
			$atributos ['matrizItems'] = $matrizDocentes;
		}
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['seleccion'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['seleccion'] = - 1;
		}
		
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		if ($matrizDocentes) {
			echo $this->miFormulario->campoCuadroLista ( $atributos );
		} else {
			echo "**REGISTRE PRIMERO UN DOCENTE";
		}
		unset ( $atributos );
		
		// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
		
		if ($matrizDocentes) {
			// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
			$esteCampo = 'seleccionarTematica';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['tab'] = $tab;
			$atributos ['marco'] = true;
			$atributos ['seleccion'] = - 1;
			$atributos ['evento'] = '';
			$atributos ['deshabilitado'] = true;
			$atributos ['limitar'] = false;
			$atributos ['tamanno'] = 1;
			$atributos ['columnas'] = 2;
			
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['validar'] = 'required';
			
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['anchoEtiqueta'] = 220;
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['seleccion'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['seleccion'] = - 1;
			}
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarTematicas" );
			$matrizTematicas = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			if ($matrizTematicas) {
				$atributos ['matrizItems'] = $matrizTematicas;
			}
			
			$tab ++;
			$atributos = array_merge ( $atributos, $atributosGlobales );
			if ($matrizTematicas) {
				echo $this->miFormulario->campoCuadroLista ( $atributos );
			} else {
				echo "**REGISTRE PRIMERO UNA TEMATICA";
			}
			unset ( $atributos );
			
			if ($matrizTematicas) {
				
				// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
				?>
				<div class="campoBoton">
					<button type="button" id="btn1" class="btn btn-primary btn-lg active">Agregar</button>
				</div>
			<p id="nota">...Agregue varias áreas de conocimiento seleccionando de la lista y oprimiendo el botón agregar.</p>
				
<div id="contenedor1" align="center">

<?php
				echo $this->miFormulario->division ( "fin" );
				
				// Hidden para guardar los nombres de las tem�ticas seleccionadas
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
				
				// Hidden para guardar el n�mero de estudiantes
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
				
				// Hidden para guardar el n�mero de estudiantes
				// ////////////////Hidden////////////
				$esteCampo = 'rol';
				$atributos ["id"] = $esteCampo;
				$atributos ["tipo"] = "hidden";
				$atributos ['estilo'] = '';
				$atributos ['validar'] = '';
				$atributos ["obligatorio"] = true;
				$atributos ['marco'] = true;
				$atributos ["etiqueta"] = "";
				$atributos ["valor"] = $rol[0];
				
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ////////////////////////////////////////
				
				if (isset ( $codigo )) {
					// Hidden para guardar el n�mero de estudiantes
					// ////////////////Hidden////////////
					$esteCampo = 'numDocente';
					$atributos ["id"] = $esteCampo;
					$atributos ["tipo"] = "hidden";
					$atributos ['estilo'] = '';
					$atributos ['validar'] = '';
					$atributos ["obligatorio"] = true;
					$atributos ['marco'] = true;
					$atributos ["etiqueta"] = "";
					$atributos ["valor"] = $codigo;
					
					$atributos = array_merge ( $atributos, $atributosGlobales );
					echo $this->miFormulario->campoCuadroTexto ( $atributos );
					unset ( $atributos );
					// ////////////////////////////////////////
				}
				// echo $this->miFormulario->marcoAgrupacion ( 'fin' );
				// ------------------Division para los botones-------------------------
				$atributos ["id"] = "botones";
				$atributos ["estilo"] = "marcoBotones";
				$atributos ["titulo"] = "Enviar Información";
				echo $this->miFormulario->division ( "inicio", $atributos );
				
				// -----------------CONTROL: Botón ----------------------------------------------------------------
				$esteCampo = 'botonCrear';
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab;
				$atributos ["tipo"] = 'boton';
				// submit: no se coloca si se desea un tipo button genérico
				$atributos ['submit'] = true;
				$atributos ["estiloMarco"] = '';
				$atributos ["estiloBoton"] = '';
				// verificar: true para verificar el formulario antes de pasarlo al servidor.
				$atributos ["verificar"] = '';
				$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
				$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoBoton ( $atributos );
				// -----------------FIN CONTROL: Botón -----------------------------------------------------------
				
				// -----------------CONTROL: Botón ----------------------------------------------------------------
				$esteCampo = 'botonCancelar2';
				$atributos ["id"] = $esteCampo;
				$atributos ["tabIndex"] = $tab;
				$atributos ["tipo"] = 'boton';
				// submit: no se coloca si se desea un tipo button genérico
				$atributos ['submit'] = true;
				$atributos ["estiloMarco"] = '';
				$atributos ["estiloBoton"] = '';
				// verificar: true para verificar el formulario antes de pasarlo al servidor.
				$atributos ["verificar"] = '';
				$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
				$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
				$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoBoton ( $atributos );
				// -----------------FIN CONTROL: Botón -----------------------------------------------------------
				
				// ------------------Fin Division para los botones-------------------------
				echo $this->miFormulario->division ( "fin" );
			}
		}
		//echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		
		// ------------------- SECCION: Paso de variables ------------------------------------------------
		
		/**
		 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
		 * SARA permite realizar esto a través de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor será una cadena codificada que contiene las variables.
		 * (c) a través de campos ocultos en los formularios. (deprecated)
		 */
		
		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
		
		// Paso 1: crear el listado de variables
		
		// $valorCodificado = "action=" . $esteBloque ["nombre"];
		$valorCodificado = "action=" . $esteBloque ["nombre"]; // Ir pagina Funcionalidad
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' ); // Frontera mostrar formulario
		$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=registrar";
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
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
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
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
			$atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
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