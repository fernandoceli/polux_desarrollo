<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

class Formulario {
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
	function formulario() {
		
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
		// $tiempo = $_REQUEST ['tiempo'];
		
		// lineas para conectar base de datos-------------------------------------------------------------------------------------------------
		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// $seccion ['tiempo'] = $tiempo;
		
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
		$atributos ['marco'] = true;
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
			// var_dump($matrizItems);
			$pregunta1 = $matrizItems [0] [1];
			$pregunta2 = $matrizItems [1] [1];
			$pregunta3 = $matrizItems [2] [1];
			$pregunta4 = $matrizItems [3] [1];
			$pregunta5 = $matrizItems [6] [1];
			
?>
<h1>Informe Final No. <?php echo $_REQUEST['informe']?></h1>
<?php
			
			// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
			$esteCampo = 'pregunta1';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			// $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['etiqueta'] = '1.1. ' . $pregunta1;
			$atributos ['tab'] = $tab;
			$atributos ['marco'] = true;
			$atributos ['seleccion'] = - 1;
			$atributos ['evento'] = '';
			$atributos ['deshabilitado'] = false;
			$atributos ['limitar'] = true;
			$atributos ['tamanno'] = 1;
			$atributos ['columnas'] = 1;
			
			$atributos ['estilo'] = 'jqueryui';
			$atributos['estiloEnLinea']='text-align: left';
			$atributos ['validar'] = 'required';
			
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['anchoEtiqueta'] = 570;
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "opcionesRespuestas2" );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			$atributos ['matrizItems'] = $matrizItems;
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['seleccion'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['seleccion'] = - 1;
			}
			$tab ++;
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
			
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'justificacion1';
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
			$atributos ['validar'] = 'required';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '';
			$atributos ['anchoEtiqueta'] = 120;
			$atributos ['filas'] = 2;
			$atributos ['columnas'] = 80;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoTextArea ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			
			// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
			$esteCampo = 'pregunta2';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			// $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['etiqueta'] = '1.2. ' . $pregunta2.' *';
			$atributos ['tab'] = $tab;
			$atributos ['marco'] = true;
			$atributos ['seleccion'] = - 1;
			$atributos ['evento'] = '';
			$atributos ['deshabilitado'] = false;
			$atributos ['limitar'] = true;
			$atributos ['tamanno'] = 1;
			$atributos ['columnas'] = 1;
			$atributos ['estilo'] = 'jqueryui';
			$atributos['estiloEnLinea']='text-align: left';
			$atributos ['validar'] = 'required';
			
			$atributos ["etiquetaObligatorio"] = false;
			$atributos ['anchoEtiqueta'] = 570;
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "opcionesRespuestas2" );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			$atributos ['matrizItems'] = $matrizItems;
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['seleccion'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['seleccion'] = - 1;
			}
			$tab ++;
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
			
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'justificacion2';
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
			$atributos ['validar'] = 'required';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '';
			$atributos ['anchoEtiqueta'] = 120;
			$atributos ['filas'] = 2;
			$atributos ['columnas'] = 80;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoTextArea ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			
			// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
			$esteCampo = 'pregunta3';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			// $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['etiqueta'] = '1.3. ' . $pregunta3;
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
			$atributos ['anchoEtiqueta'] = 570;
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "opcionesRespuestas2" );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			$atributos ['matrizItems'] = $matrizItems;
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['seleccion'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['seleccion'] = - 1;
			}
			$tab ++;
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
			
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'justificacion3';
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
			$atributos ['validar'] = 'required';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '';
			$atributos ['anchoEtiqueta'] = 120;
			$atributos ['filas'] = 2;
			$atributos ['columnas'] = 80;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoTextArea ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			
			// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
			$esteCampo = 'pregunta4';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			// $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['etiqueta'] = '1.4. ' . $pregunta4;
			$atributos ['tab'] = $tab;
			$atributos ['marco'] = true;
			$atributos ['seleccion'] = - 1;
			$atributos ['evento'] = '';
			$atributos ['deshabilitado'] = false;
			$atributos ['limitar'] = true;
			$atributos ['tamanno'] = 1;
			$atributos ['columnas'] = 1;
			
			$atributos ['estiloEnLinea'] = 'text-align: left;';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['validar'] = 'required';
			
			$atributos ["etiquetaObligatorio"] = true;
			$atributos ['anchoEtiqueta'] = 570;
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "opcionesRespuestas1" );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			$atributos ['matrizItems'] = $matrizItems;
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['seleccion'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['seleccion'] = - 1;
			}
			$tab ++;
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
			
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'justificacion4';
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
			$atributos ['validar'] = 'required';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '';
			$atributos ['anchoEtiqueta'] = 120;
			$atributos ['filas'] = 2;
			$atributos ['columnas'] = 80;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoTextArea ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			
			// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
			$esteCampo = 'pregunta5';
			$atributos ['nombre'] = $esteCampo;
			$atributos ['id'] = $esteCampo;
			// $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['etiqueta'] = '1.5. ' . $pregunta5.' *';
			$atributos ['tab'] = $tab;
			$atributos ['marco'] = true;
			$atributos ['seleccion'] = - 1;
			$atributos ['evento'] = '';
			$atributos ['deshabilitado'] = false;
			$atributos ['limitar'] = true;
			$atributos ['tamanno'] = 1;
			$atributos ['columnas'] = 1;
			
			$atributos ['estiloEnLinea'] = 'text-align: left;';
			$atributos ['estilo'] = 'jqueryui';
			$atributos ['validar'] = 'required';
			
			$atributos ["etiquetaObligatorio"] = false;
			$atributos ['anchoEtiqueta'] = 570;
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "opcionesRespuestas1" );
			$matrizItems = $esteRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			$atributos ['matrizItems'] = $matrizItems;
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['seleccion'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['seleccion'] = - 1;
			}
			$tab ++;
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroLista ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
			
			// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
			$esteCampo = 'justificacion5';
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
			$atributos ['validar'] = 'required';
			
			if (isset ( $_REQUEST [$esteCampo] )) {
				$atributos ['valor'] = $_REQUEST [$esteCampo];
			} else {
				$atributos ['valor'] = '';
			}
			$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
			$atributos ['deshabilitado'] = false;
			$atributos ['tamanno'] = 57;
			$atributos ['maximoTamanno'] = '';
			$atributos ['anchoEtiqueta'] = 120;
			$atributos ['filas'] = 2;
			$atributos ['columnas'] = 80;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoTextArea ( $atributos );
			unset ( $atributos );
			// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
			
			// ------------------Division para los botones-------------------------
			$atributos ["id"] = "botones";
			$atributos ["estilo"] = "marcoBotones";
			echo $this->miFormulario->division ( "inicio", $atributos );
			
			?>
				<button type="button" id="btn1" class="btn btn-primary btn-lg active">Siguiente</button>
			<?php
			
			
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
		unset ( $atributos );
		
		return true;
	}
}

$miSeleccionador = new Formulario ( $this->lenguaje, $this->miFormulario, $this->sql );

$miSeleccionador->formulario ();
?>
