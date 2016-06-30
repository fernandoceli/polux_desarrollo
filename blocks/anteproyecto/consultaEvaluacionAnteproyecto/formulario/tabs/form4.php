<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

// use bloquesModelo\evaluacionAnteproyecto\funcion\redireccion;
class registrarForm4 {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
	}
	function miForm() {
		
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
		
		// lineas para conectar base de datos-------------------------------------------------------------------------------------------------
		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = 'multipart/form-data';
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		// $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = false;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		{
			
			// ---------------- SECCION: Controles del Formulario -----------------------------------------------
			
			$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
			
			$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
			$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
			$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];
			
			$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
			$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
			$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarPreguntas" );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			//var_dump($matrizItems);
			$pregunta1 = $matrizItems [15][1];
			
			?>
				<h1>Anteproyecto No. <?php echo $_REQUEST['anteproyecto']?></h1>
			<?php
			
			//buscar evaluación
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarRevision" );
			$matrizRevision = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			//var_dump($matrizRevision);
			
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'pregunta41';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['obligatorio'] = false;
			$atributos ['etiquetaObligatorio'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = '4.1. ' . $pregunta1;
			$atributos ['validar'] = '';
			$atributos ['valor'] = $matrizRevision[12][2];
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = true;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '';
			$atributos ['anchoEtiqueta'] = 500;
			$tab ++;
				
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
				
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'concepto';
			$atributos ['id'] = $esteCampo;
			$atributos ['nombre'] = $esteCampo;
			$atributos ['tipo'] = 'text';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['marco'] = true;
			$atributos ['columnas'] = 1;
			$atributos ['dobleLinea'] = false;
			$atributos ['obligatorio'] = false;
			$atributos ['etiquetaObligatorio'] = false;
			$atributos ['tabIndex'] = $tab;
			$atributos ['etiqueta'] = 'Concepto: ';
			$atributos ['validar'] = '';
			$atributos ['valor'] = $_REQUEST['concepto'];
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = true;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '';
			$atributos ['anchoEtiqueta'] = 500;
			$tab ++;
				
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			
			// ------------------Division para los botones-------------------------
			$atributos ["id"] = "botones";
			$atributos ["estilo"] = "marcoBotones";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			{
				
				?>
					<button type="button" id="btnAnt3" class="btn btn-primary btn-lg active">Anterior</button>
				<?php
				
// 				// -----------------CONTROL: Botón ----------------------------------------------------------------
// 				$esteCampo = 'botonAceptar';
// 				$atributos ["id"] = $esteCampo;
// 				$atributos ["tabIndex"] = $tab;
// 				$atributos ["tipo"] = 'boton';
// 				// submit: no se coloca si se desea un tipo button genérico
// 				$atributos ['submit'] = true;
// 				$atributos ["estiloMarco"] = '';
// 				$atributos ["estiloBoton"] = 'jqueryui';
// 				// verificar: true para verificar el formulario antes de pasarlo al servidor.
// 				$atributos ["verificar"] = '';
// 				$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
// 				$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
// 				$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
// 				$tab ++;
				
// 				// Aplica atributos globales al control
// 				$atributos = array_merge ( $atributos, $atributosGlobales );
// 				echo $this->miFormulario->campoBoton ( $atributos );
				// -----------------FIN CONTROL: Botón -----------------------------------------------------------
			}
			echo $this->miFormulario->division ( 'fin' );
			
			echo $this->miFormulario->marcoAgrupacion ( 'fin' );
			
			// ------------------Fin Division para los botones-------------------------
		echo $this->miFormulario->division ( "fin" );
		
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
		
		$valorCodificado = "action=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&ante=" . $_REQUEST ['anteproyecto'];
		$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
		$valorCodificado .= "&opcion=guardar";
		
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo. Si se utiliza esta técnica es necesario pasar dicho tiempo como una variable:
		 * (a) invocando a la variable $_REQUEST ['tiempo'] que se ha declarado en ready.php o
		 * (b) asociando el tiempo en que se está creando el formulario
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
		$valorCodificado .= "&tiempo=" . time ();
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
		}
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
		
		return true;
	}
}

$miSeleccionador = new registrarForm4 ( $this->lenguaje, $this->miFormulario, $this->sql );

$miSeleccionador->miForm ();
?>
