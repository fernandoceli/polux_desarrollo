<?php

namespace proyecto\evaluacionProyecto\formulario;

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
		
		$conexion = 'estructura';
		$esteRecurso = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
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
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		
		// buscar proyecto
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarProyecto", $_REQUEST ['proyecto'] );
		$matrizItems = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		// Buscar el ultimo documento del proyecto
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'buscarDocumento2', $_REQUEST ['proyecto'] );
		$documentoProyecto = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], 'busqueda' );
		// var_dump($documentoProyecto);
		
		// Buscar la version del ultimo documento
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( 'buscarVersionDoc', $documentoProyecto [0] [0] );
		$versionDoc = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], 'busqueda' );
		
		// buscar proponentes
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAutores", $_REQUEST ['proyecto'] );
		$matrizAutores = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		// var_dump($matrizAutores);
		
		$nomAutores = array ();
		for($i = 0; $i < count ( $matrizAutores ); $i ++) {
			array_push ( $nomAutores, $matrizAutores [$i] [1] );
		}
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		$atributos ['mensaje'] = 'Evaluación de Proyecto';
		$atributos ['tamanno'] = 'Enorme';
		$atributos ['linea'] = 'true';
		echo $this->miFormulario->campoMensaje ( $atributos );
		
		?>
<div class="canvas-contenido">
	<h1>Proyecto No. <?php echo $matrizItems[0][0]?></h1>
	<h3>Información General Proyecto</h3>

	<table id="documento" class="table">
		<tr>
			<td id="col" rowspan="7">
				<div class="corner bg-imagen-documento">
					<div id="documento" class="icon-max-pdf"></div>
					<div class="codigo-documento">Versión No. <?php echo $versionDoc[0][0]?></div>
				</div>
			</td>
			<td class="table-tittle estilo_tr">Referencia</td>
			<td class="estilo_tr"><?php echo 'Proyecto No. '.$matrizItems[0][0]?></td>
		</tr>

		<tr>
			<td class="table-tittle estilo_tr">Titulo</td>
			<td class="estilo_tr"><?php echo $matrizItems[0][1]?></td>
		</tr>

		<tr>
			<td class="table-tittle estilo_tr">Descripción</td>
			<td class="estilo_tr"><?php echo $matrizItems[0][2]?></td>
		</tr>

		<tr>
			<td class="table-tittle estilo_tr">Autores</td>
			<td class="estilo_tr">
				<?php
		for($i = 0; $i < count ( $nomAutores ); $i ++) {
			echo $nomAutores [$i]?><br> <?php
			
;
		}
		?>
				</td>
		</tr>

		<tr>
			<td class="table-tittle estilo_tr">Versión del documento a evaluar</td>
			<td class="estilo_tr"> <?php echo $versionDoc[0][0]?></td>
		</tr>

	</table>
	<br></br>
	<h3>Concepto General de la evaluación</h3>
	<Blockquote>Por favor seleccione el concepto que emitirá para la
		versión de documento de proyecto que se encuentra evaluando.</Blockquote>
</div>
<?php
		
		// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
		$esteCampo = 'seleccionarConcepto';
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
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarConceptos" );
		$matrizItems = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['matrizItems'] = $matrizItems;
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroLista ( $atributos );
		unset ( $atributos );
		// --------------- FIN CONTROL : Cuadro Lista --------------------------------------------------
		
		?>

<h3>Criterios de evaluación</h3>

<Blockquote>Por favor diligencie todas las preguntas establecidas en la
	sección. Recuerde que las justificaciones son de caracter obligatorio.
</Blockquote>

<?php
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		// buscar las preguntas
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarPreguntas" );
		$matrizPreguntas = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$pregunta1 = $matrizPreguntas [1] [1];
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'pregunta1';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['columnas'] = 100;
		$atributos ['filas'] = 3;
		$atributos ['dobleLinea'] = false;
		$atributos ['obligatorio'] = true;
		$atributos ['etiquetaObligatorio'] = true;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = '1.1. ' . $pregunta1;
		$atributos ['validar'] = 'required, maxSize[500]';
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 25;
		$atributos ['maximoTamanno'] = '';
		$atributos ['anchoEtiqueta'] = 280;
		$atributos ['anchoCaja'] = 60;
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
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		$esteCampo = 'botonEvaluar';
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab;
		$atributos ["tipo"] = 'boton';
		// submit: no se coloca si se desea un tipo button genérico
		$atributos ['submit'] = true;
		$atributos ["estiloMarco"] = '';
		$atributos ["estiloBoton"] = 'jqueryui';
	
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
		
		$valorCodificado = "action=" . $esteBloque ["nombre"]; // Ir pagina Funcionalidad
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' ); // Frontera mostrar formulario
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
		$valorCodificado .= "&proyecto=" . $_REQUEST ['proyecto'];
		$valorCodificado .= "&opcion=evaluar";
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