<?php

namespace bloquesModelo\consultaInformeFinal\formulario;

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
		
		// Buscar tem�ticas asociadas
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarTematicas2", $_REQUEST ['id'] );
		$matriz = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$codTematicas = array ();
		for($i = 0; $i < count ( $matriz ); $i ++) {
			array_push ( $codTematicas, $matriz [$i] [0] );
		}
		// var_dump ( $codTematicas );
		
		// Buscar nombres de las tem�ticas
		$nomTematicas = array ();
		for($i = 0; $i < count ( $codTematicas ); $i ++) {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombresTematicas", $codTematicas [$i] );
			$matrizNomTematicas = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			array_push ( $nomTematicas, $matrizNomTematicas [0] [0] );
		}
		
		$arreglo = array (
				'informe' => $_REQUEST ['id'],
				'tematica' => $codTematicas 
		);
		
		//buscar revisores
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarRevisores", $_REQUEST ['id'] );
		$matrizRevisores = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		//var_dump($matrizRevisores);
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
	
		//Informe Final
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarInforme", $_REQUEST ['informe'] );
		$matrizItems = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		// var_dump($matrizItems);
		
		// Buscar estudiantes asociados
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAutores", $_REQUEST ['informe'] );
		$matrizItems2 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$cod = array ();
		for($i = 0; $i < count ( $matrizItems2 ); $i ++) {
			array_push ( $cod, $matrizItems2 [$i] [0] );
		}
		
		// Buscar nombres de los estudiantes
		$autores = array ();
		for($i = 0; $i < count ( $cod ); $i ++) {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombresAutores", $cod [$i] );
			$matrizItems4 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			array_push ( $autores, ''.$matrizItems4 [0] [1] );
		}
		
		
		$atributos ['mensaje'] = 'Finalizar Información de Sustentación de Informe Final';
		$atributos ['tamanno'] = 'Enorme';
		$atributos ['linea'] = 'true';
		echo $this->miFormulario->campoMensaje ( $atributos );
		unset ( $atributos );
		
		?> 
			<h3>Informe Final Asociado</h3>
			<br>
		<?php
		///---------------------Inicio Tabla---------------------------------
		$atributos ['id'] = 'vers';
		$atributos ['estilo'] = 'table';
		$atributos ['tipo_etiqueta'] = 'table';
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		///---------------------Inicio---------------------------------
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle";
		$atributos ['mensaje'] = 'Referencia:';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = 'Informe Final No. '.$_REQUEST['informe'];
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		///---------------------Fin---------------------------------
		
		///---------------------Inicio---------------------------------
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle";
		$atributos ['mensaje'] = 'Titulo del informe final:';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = $matrizItems [0][4];
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		///---------------------Fin---------------------------------
		
		///---------------------Inicio---------------------------------
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle";
		$atributos ['mensaje'] = 'Descripción:';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = $matrizItems [0] [6];
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		///---------------------Fin---------------------------------
		
		///---------------------Inicio---------------------------------
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle";
		$atributos ['mensaje'] = 'Autores:';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		
		for($i = 0; $i < count ( $autores ); $i ++) {
			if ($i == 0) {
				echo $autores [$i];
			} else {
				echo "<br>";
				echo $i + 1 . ". " . $autores [$i];
			}
		}
		
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		///---------------------Fin---------------------------------
		
		///---------------------Inicio---------------------------------
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle";
		$atributos ['mensaje'] = 'Modalidad:';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = $matrizItems [0] [6];
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		///---------------------Fin---------------------------------
		
		///---------------------Inicio---------------------------------
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle";
		$atributos ['mensaje'] = 'Areas:';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		
		for($i = 0; $i < count ( $matrizNomTematicas ); $i ++) {
			if ($i == 0) {
				echo $matrizNomTematicas [0][$i];
			} else {
				echo "<br>";
				echo $i + 1 . ". " . $matrizNomTematicas [0][$i];
			}
		}
		
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		///---------------------Fin---------------------------------
		
		$atributos ['tipo_etiqueta'] = "table";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		///---------------------Fin Tabla---------------------------------
		
		?>
			<br>
			<h3>Información requerida para finalización de la sustentación</h3>
			<br>
		<?php
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'calificacionFinal';
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
		$atributos ['tamanno'] = 25;
		$atributos ['maximoTamanno'] = '';
		$atributos ['anchoEtiqueta'] = 400;
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
		
		// ---------------- CONTROL: Cuadro Lista --------------------------------------------------------
		$esteCampo = 'seleccionarConceptoSustentacion';
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
		$atributos ['anchoEtiqueta'] = 400;
		$atributos ['anchoCaja'] = 60;
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarConceptosSustentacion" );
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
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'actaFinalizacion';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'file';
		
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ["etiquetaObligatorio"] = true;
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = false;
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
		$atributos ['anchoEtiqueta'] = 400;
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
		
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'observacionesFinalizacion';
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
		$atributos ['validar'] = 'required, maxSize[50]';
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 60;
		$atributos ['maximoTamanno'] = '';
		$atributos ['anchoEtiqueta'] = 400;
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		
		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
		
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botones";
		$atributos ["estilo"] = "marcoBotones";
		$atributos ["titulo"] = "Enviar Información";
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		// -----------------CONTROL: Bot�n ----------------------------------------------------------------
		$esteCampo = 'botonFinalizar';
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
		$atributos ["tipoSubmit"] = ''; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
		$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoBoton ( $atributos );
		// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		
		// ------------------Fin Division para los botones-------------------------
		echo $this->miFormulario->division ( "fin" );
		// echo $this->miFormulario->marcoAgrupacion ( 'fin' );
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
		$valorCodificado .= "&informe=" . $_REQUEST ['informe'];
		$valorCodificado .= "&opcion=finalizar";
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