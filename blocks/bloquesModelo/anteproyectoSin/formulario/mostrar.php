<?php

namespace bloquesModelo\anteproyectoSin\formulario;

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
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		// ////////////////Hidden////////////
		$esteCampo = 'id';
		$atributos ["id"] = $esteCampo; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ['validar'] = ''; // decia required
		$atributos ["obligatorio"] = true;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ['valor'] = $_REQUEST ['id'];
		
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAnteproyecto", $_REQUEST['id'] );
		$matrizItems = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$id=$_REQUEST['id'];
		//var_dump($matrizItems);
		$director = $matrizItems[0][8];
		$modalidad = $matrizItems[0][1];
		
		//Buscar nombre de la modalidad
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombreModalidad", $modalidad );
		$matriz3 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$modalidadNom=$matriz3[0][1];
		
		//Buscar tem�ticas asociadas
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarTematicas", $_REQUEST['id'] );
		$matriz = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$tematica=$matriz[0][0];
		
		//Buscar nombre de las tem�ticas
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombresTematicas", $tematica );
		$matriz2 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$nomtematica=$matriz2[0][1];
		
		//Buscar estudiantes asociados
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAutores", $_REQUEST['id'] );
		$matrizItems2 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$cod=$matrizItems2[0][0];
		
		//Buscar nombre de director
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombresDirector", $director );
		$matrizItems3 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$director=$matrizItems3[0][1];
		
		//Buscar nombres de los estudiantes
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombresAutores", $cod );
		$matrizItems4 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$autores=$matrizItems4[0][1];
		//var_dump($nombre);
		
		?>
	<div class="canvas-contenido">
	
		<h1>Anteproyecto No. <?php echo $id?></h1>
		
		<h3>Información General</h3>
		
		<table id="documento" class="table">
		  <tr>
		  	<td id="col" rowspan="7">
		  		<div class="corner bg-imagen-documento">
		  			<div id="documento" class="icon-max-pdf"></div>
		  			<div class="codigo-documento">Versión No.1</div>
		  		</div>
		  	</td>
		  	<td class="table-tittle">Titulo</td>
		    <td><p><?php echo $matrizItems[0][3]?></p></td>
		  </tr>
		  
		  <tr >
		      <td class="table-tittle">Modalidad de Grado</td>
		      <td><p><?php echo $modalidadNom?></p></td>
		  </tr>
		  
		  <tr>
		      <td class="table-tittle">Temáticas de Interés</td>
		      <td><p><?php echo $nomtematica?></p></td>
		  </tr>
		  
		  <tr>
		      <td class="table-tittle">Estado</td>
		      <td><p><?php echo $matrizItems[0][7]?></p></td>
		  </tr>
		  
		</table>
		<br></br>
	</div>

		<h3>Autores y Directores</h3>
		
		<table class="table">
		  <tr>
		    <td class="table-tittle">Autores</td>
		    <td><p><?php echo $autores;?></p></td>
		  </tr>
		  
		  <tr>
			<td class="table-tittle">Directores Internos</td>
		    <td><p><?php echo $director?></p></td>
		  </tr>
		  
		</table>
		
		<br></br>
		<h3>Documentos Anexos</h3>
		
		<?php
		///////////////////////
		//echo $this->miFormulario->tablaReporte ( $matrizItems );

		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botones";
		$atributos ["estilo"] = "marcoBotones";
		$atributos ["titulo"] = "Enviar Información";
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		// -----------------CONTROL: Bot�n ----------------------------------------------------------------
		$esteCampo = 'botonAsignar';
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
		
		//$valorCodificado = "action=" . $esteBloque ["nombre"]; // Ir pagina Funcionalidad
		$valorCodificado = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' ); // Frontera mostrar formulario
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=asignar";
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