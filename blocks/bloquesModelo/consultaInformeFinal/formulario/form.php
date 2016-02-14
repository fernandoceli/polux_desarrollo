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
		 * IMPORTANTE: Este formulario estÃ¡ utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		// ---------------- SECCION: ParÃ¡metros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta tÃ©cnica es necesario realizar un mezcla entre este arreglo y el especÃ­fico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST ['tiempo'] = time ();
		
		if (! isset ( $_REQUEST ['informe'] )) {
			if (isset ( $_REQUEST ['numinforme'] )) {
				$_REQUEST ['informe'] = $_REQUEST ['numinforme'];
			} elseif (isset ( $_REQUEST ['info'] )) {
				$_REQUEST ['informe'] = $_REQUEST ['info'];
			}
		}
		
		$conexion = 'estructura';
		$esteRecurso = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$usuario = $this->miSesion->getSesionUsuarioId ();
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarRol", $_REQUEST ['usuario'] );
		$matrizRol = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$rol = $matrizRol [0] [0];
		$acceso = false;
		$mostrar = false;
		
		if ($rol == "Estudiante") {
			$acceso = true;
			$mostrar = true;
			$_REQUEST ["variable"] = $_REQUEST ['usuario'];
		}
		
		if (($rol == 'Administrador General') || ($rol == 'Desarrollo y Pruebas')) {
			$acceso = true;
			$mostrar = true;
		}
		
		// -------------------------------------------------------------------------------------------------
		
		// ---------------- SECCION: ParÃ¡metros Generales del Formulario ----------------------------------
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
		// ---------------- FIN SECCION: de ParÃ¡metros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		// Hidden para informe
		$esteCampo = 'id';
		$atributos ["id"] = $esteCampo;
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ['validar'] = '';
		$atributos ["obligatorio"] = true;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ['valor'] = $_REQUEST ['informe'];
		
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// /////////////////////////////////
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarInforme", $_REQUEST ['informe'] );
		$matrizInformes = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombreDirector", $_REQUEST ['informe'] );
		$matrizDirector = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$id = $_REQUEST ['informe'];
		
		$modalidad = $matrizInformes [0] [1];
		$director = $matrizDirector [0] [0];
		
		// Buscar temáticas asociadas
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarTematicas", $_REQUEST ['informe'] );
		$matrizTematicas = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		// Buscar estudiantes asociados
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAutores", $_REQUEST ['informe'] );
		$matrizAutores = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$cod = array ();
		for($i = 0; $i < count ( $matrizAutores ); $i ++) {
			array_push ( $cod, trim ( $matrizAutores [$i] [0] ) );
		}
		
		// Buscar nombres de los estudiantes
		$autores = array ();
		for($i = 0; $i < count ( $cod ); $i ++) {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombresAutores", $cod [$i] );
			$matrizItems4 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			array_push ( $autores, $matrizItems4 [0] [1] );
		}
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarVersiones", $_REQUEST ['informe'] );
		$matrizVersiones = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarRevisor" );
		$matrizRevisor = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultaRespuesta", $id );
		$matrizRespuesta = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "documentoAnexo", $id );
		$matrizAnexo = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "actividadesPendientes", $id );
		$matrizActividades = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "canvas-contenido";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "h";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = 'Informe Final No. ' . $id;
		$atributos ['tipo_etiqueta'] = "h1";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "izq";
		$atributos ['estilo'] = "";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "h";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = 'InformaciÃ³n General';
		$atributos ['tipo_etiqueta'] = "h3";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "documento";
		$atributos ['estilo'] = "table";
		$atributos ['tipo_etiqueta'] = "table";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "col";
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "td";
		$atributos ['rowspan'] = 7;
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "corner bg-imagen-documento";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "documento";
		$atributos ['estilo'] = "icon-max-pdf";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "codigo-documento";
		$atributos ['mensaje'] = 'VersiÃ³n No.1';
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		
		echo $this->miFormulario->division ( "fin" );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle estilo_tr";
		$atributos ['mensaje'] = 'Titulo';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "estilo_tr";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = $matrizInformes [0] ['info_titu'];
		$atributos ['tipo_etiqueta'] = "p";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle estilo_tr";
		$atributos ['mensaje'] = 'Modalidad de Grado';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "estilo_tr";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = $matrizInformes [0] ['moda_nombre'];
		$atributos ['tipo_etiqueta'] = "p";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle estilo_tr";
		$atributos ['mensaje'] = 'TemÃ¡ticas de InterÃ©s';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "estilo_tr";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "p";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		
		for($i = 0; $i < count ( $matrizTematicas ); $i ++) {
			if ($i == 0) {
				echo $matrizTematicas [$i] [1];
			} else {
				echo "<br>";
				echo $i + 1 . ". " . $matrizTematicas [$i] [1];
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
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle estilo_tr";
		$atributos ['mensaje'] = 'Estado';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "estilo_tr";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = $matrizInformes [0] ['info_einfo'];
		$atributos ['tipo_etiqueta'] = "p";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "table";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		echo "<br>";
		
		$atributos ['id'] = "h";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = 'Autores - Directores - Revisores';
		$atributos ['tipo_etiqueta'] = "h3";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table";
		$atributos ['tipo_etiqueta'] = "table";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "col";
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "td";
		$atributos ['rowspan'] = 3;
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "corner bg-imagen-documento";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "documento";
		$atributos ['estilo'] = "icon-all-people";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "codigo-documento";
		$atributos ['mensaje'] = 'Participantes';
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		
		echo $this->miFormulario->division ( "fin" );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle estilo_tr";
		$atributos ['mensaje'] = 'Autores';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "estilo_tr";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "p";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		
		for($i = 0; $i < count ( $autores ); $i ++) {
			if ($i == 0) {
				echo $i + 1 . ". " . $autores [$i];
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
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle estilo_tr";
		$atributos ['mensaje'] = 'Directores Internos';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "estilo_tr";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "p";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = $director;
		$atributos ['tipo_etiqueta'] = "p";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle estilo_tr";
		$atributos ['mensaje'] = 'Revisores anteproyecto';
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "table";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		echo "<br>";
		
		$atributos ['id'] = "h";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = 'Informaci&oacute;n Sustentaci&oacute;n';
		$atributos ['tipo_etiqueta'] = "h3";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "documento";
		$atributos ['estilo'] = "table";
		$atributos ['tipo_etiqueta'] = "table";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "col";
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "corner bg-imagen-documento";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "documento";
		$atributos ['estilo'] = "icon-check-list";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "codigo-documento";
		$atributos ['mensaje'] = 'Sustentaci&oacute;n';
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		
		echo $this->miFormulario->division ( "fin" );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		if (! isset ( $matrizInfoSustentacion )) {
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['estilo'] = "table-formulario";
			echo $this->miFormulario->crearTabla3 ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "icon-mini-info";
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "mensaje-ayuda";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "b";
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "b";
			$atributos ['mensaje'] = 'IMPORTANTE: ';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			echo "A&uacute;n no se programado la
				sustentaci&oacute;n del informe final. Para ello es
				indispensable que todos los jurados hayan aprobado el
				documento para sustentaci&oacute;n.";
			
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			echo $this->miFormulario->crearTabla3 ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
		}
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "table";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		echo "<br>";
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = 'Documentos Anexos';
		$atributos ['tipo_etiqueta'] = "h3";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "documento";
		$atributos ['estilo'] = "table";
		$atributos ['tipo_etiqueta'] = "table";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "col";
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "corner bg-imagen-documento";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "documento";
		$atributos ['estilo'] = "docs-anexos-icon";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "codigo-documento";
		$atributos ['mensaje'] = 'Anexos';
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		
		echo $this->miFormulario->division ( "fin" );
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "estilo_tr";
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = 'Documentacion anexa';
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		
		echo "<br>";
		
		if ($matrizAnexo) {
			for($i = 0; $i < count ( $matrizAnexo ); $i ++) {
				
				echo "<br>";
				
				$atributos ['id'] = '';
				$atributos ['estilo'] = "";
				$atributos ['mensaje'] = $i + 1 . ". " . $matrizAnexo [$i] [0];
				echo $this->miFormulario->division ( "inicio", $atributos );
				unset ( $atributos );
				
				echo $this->miFormulario->division ( "fin" );
				
				$atributos ['id'] = '';
				$atributos ['estilo'] = "";
				echo $this->miFormulario->division ( "inicio", $atributos );
				unset ( $atributos );
				
				$atributos ['enlace'] = $matrizAnexo [$i] [1];
				$atributos ['enlaceTexto'] = $matrizAnexo [$i] [2];
				$atributos ['download'] = $matrizAnexo [$i] [1];
				echo $this->miFormulario->enlace ( $atributos );
				unset ( $atributos );
				
				echo $this->miFormulario->division ( "fin" );
			}
		}
		
		$atributos ['tipo_etiqueta'] = "td";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "table";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		echo "<br>";
		
		$aprob = true;
		for($i = 0; $i < count ( $matrizRespuesta ); $i ++) {
			if ($matrizRespuesta [$i] [2] != "APROBADO") {
				$aprob = false;
			}
		}
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botones";
		$atributos ["estilo"] = "marcoBotones";
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		$esteCampo = 'botonH';
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
		
		if (! $matrizRevisor && ($rol == "Coordinador" || ($rol == 'Administrador General') || ($rol == 'Desarrollo y Pruebas'))) {
			// -----------------CONTROL: Botón ----------------------------------------------------------------
			$esteCampo = 'btnAsignarJurados';
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
		}
		
		if (! $matrizRespuesta) {
			// -----------------CONTROL: Botón ----------------------------------------------------------------
			$esteCampo = 'botonSolicitar';
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
		}
		
		// ------------------Fin Division para los botones-------------------------
		echo $this->miFormulario->division ( "fin" );
		
		echo $this->miFormulario->division ( "fin" );
		
		$atributos ['id'] = "der";
		$atributos ['estilo'] = "";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "versiones";
		$atributos ['estilo'] = "";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = "h";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = 'Versiones del Documento';
		$atributos ['tipo_etiqueta'] = "h4";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = 'p';
		$atributos ['tipo_etiqueta'] = 'p';
		$atributos ['estilo'] = 'idnt';
		$atributos ['mensaje'] = 'A continuaci&oacute;n encontrara las &uacute;ltimas
					versiones del documento que se hayan cargado al sistema. Para
					descargar el documento por favor seleccione la versi&oacute;n que
					desea consultar.';
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = 'vers';
		$atributos ['estilo'] = 'table';
		$atributos ['tipo_etiqueta'] = 'table';
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "estilo_tr tit";
		$atributos ['tipo_etiqueta'] = "td";
		$atributos ['colspan'] = 4;
		$atributos ['mensaje'] = 'Version actual: Version No. ' . count ( $matrizVersiones );
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle estilo_tr";
		$atributos ['tipo_etiqueta'] = "td";
		$atributos ['colspan'] = 2;
		$atributos ['mensaje'] = 'Version';
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle estilo_tr";
		$atributos ['tipo_etiqueta'] = "td";
		$atributos ['mensaje'] = 'Nombre del documento';
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "table-tittle estilo_tr";
		$atributos ['tipo_etiqueta'] = "td";
		$atributos ['mensaje'] = 'Fecha de subida';
		echo $this->miFormulario->div_especifico ( "inicio", $atributos );
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['tipo_etiqueta'] = "tr";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		for($i = 0; $i < count ( $matrizVersiones ); $i ++) {
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "corner bg-imagen-documento";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "documento";
			$atributos ['estilo'] = "icon-mini-archivo";
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "codigo-documento";
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			if (strlen ( $matrizVersiones [$i] [0] ) < 10) {
				echo $matrizVersiones [$i] [0];
			} else {
				echo substr ( $matrizVersiones [$i] [0], 10 ) . "...";
			}
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['enlace'] = $matrizVersiones [$i] [2];
			$atributos ['download'] = $matrizVersiones [$i] [1];
			
			$tam = strlen ( $matrizVersiones [$i] [1] );
			if ($tam < 30) {
				$atributos ['enlaceTexto'] = $matrizVersiones [$i] [1];
			} else {
				$nombre = substr ( $matrizVersiones [$i] [1], 0, 12 ) . " .. " . substr ( $matrizVersiones [$i] [1], - 5 );
				$atributos ['enlaceTexto'] = $nombre;
			}
			
			echo $this->miFormulario->enlace ( $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			echo $matrizVersiones [$i] [3];
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
		}
		
		$atributos ['tipo_etiqueta'] = "table";
		echo $this->miFormulario->div_especifico ( "fin", $atributos );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "separador";
		$atributos ['mensaje'] = '&nbsp;';
		echo $this->miFormulario->division ( "inicio", $atributos );
		echo $this->miFormulario->division ( "fin" );
		unset ( $atributos );
		
		$atributos ['id'] = '';
		$atributos ['estilo'] = "";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		echo $this->miFormulario->division ( "fin" );
		
		echo "<br>";
		
		echo $this->miFormulario->division ( "fin" );
		
		if (isset ( $matrizSolsJurados ) && $matrizSolsJurados) {
		} else {
			$atributos ['id'] = 'jurados';
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "plugins corner margen-interna";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "plugin";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = 'titulo-tablero-revision';
			$atributos ['mensaje'] = 'Solicitudes de Asignaci&oacute;n de Jurado';
			$atributos ['tipo_etiqueta'] = 'span';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = 'table-formulario';
			echo $this->miFormulario->crearTabla3 ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = 'icon-mini-info';
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "mensaje-ayuda";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['mensaje'] = 'Aun no existen solicitudes de asignaci&oacute;n jurado iniciadas
							por el programa curricular. <br> <br> <b>NOTA:</b> Una vez el
							programa curricular inicie las solicitudes, los jurados
							tendr&aacute;n un plazo m&aacute;ximo de <span class="resaltado">10
								d&iacute;as calendario</span> para dar repuesta a la solicitud.';
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			echo $this->miFormulario->crearTabla3 ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
		}
		
		$fecini = substr ( $matrizRevisor [0] [0], 8 );
		$fecact = getdate ();
		
		if ($matrizRespuesta) {
			
			$atributos ['id'] = "proceso";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['mensaje'] = 'Proceso de revision (' . count ( $matrizRespuesta ) . '/3)';
			$atributos ['tipo_etiqueta'] = "h4";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "table2";
			$atributos ['tipo_etiqueta'] = "table";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['mensaje'] = 'Responsable: <strong>Revisores</strong>';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "izq";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['mensaje'] = 'Dias restantes ' . ($fecini - $fecact ['mday']) + 20 . '/20';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "table";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "proc";
			$atributos ['estilo'] = "table";
			$atributos ['tipo_etiqueta'] = "table";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "estilo_tr tit";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['colspan'] = 5;
			$atributos ['mensaje'] = 'Solicitudes de asignacion de revision';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "table-tittle estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['colspan'] = 2;
			$atributos ['mensaje'] = 'Revisor';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "table-tittle estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['mensaje'] = 'Fecha solicitud';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "table-tittle estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['mensaje'] = 'Concepto respuesta';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "table-tittle estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['mensaje'] = 'Fecha respuesta';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			for($i = 0; $i < count ( $matrizRespuesta ); $i ++) {
				
				$atributos ['id'] = '';
				$atributos ['estilo'] = "";
				$atributos ['tipo_etiqueta'] = "tr";
				echo $this->miFormulario->div_especifico ( "inicio", $atributos );
				unset ( $atributos );
				
				$atributos ['id'] = '';
				$atributos ['estilo'] = "estilo_tr";
				$atributos ['tipo_etiqueta'] = "td";
				echo $this->miFormulario->div_especifico ( "inicio", $atributos );
				unset ( $atributos );
				
				$atributos ['id'] = '';
				$atributos ['estilo'] = "corner bg-imagen-documento";
				$atributos ['tipo_etiqueta'] = "td";
				echo $this->miFormulario->div_especifico ( "inicio", $atributos );
				unset ( $atributos );
				
				$atributos ['id'] = 'documento';
				$atributos ['estilo'] = "icon-mini-people";
				$atributos ['tipo_etiqueta'] = "td";
				echo $this->miFormulario->div_especifico ( "inicio", $atributos );
				unset ( $atributos );
				
				echo $this->miFormulario->division ( "fin" );
				
				echo $this->miFormulario->division ( "fin" );
				
				$atributos ['tipo_etiqueta'] = "td";
				echo $this->miFormulario->div_especifico ( "fin", $atributos );
				unset ( $atributos );
				
				$atributos ['id'] = '';
				$atributos ['estilo'] = "estilo_tr";
				$atributos ['tipo_etiqueta'] = "td";
				$atributos ['mensaje'] = $matrizRespuesta [$i] [3];
				echo $this->miFormulario->div_especifico ( "inicio", $atributos );
				echo $this->miFormulario->div_especifico ( "fin", $atributos );
				unset ( $atributos );
				
				$atributos ['id'] = '';
				$atributos ['estilo'] = "estilo_tr";
				$atributos ['tipo_etiqueta'] = "td";
				$atributos ['mensaje'] = $matrizRespuesta [$i] [4];
				echo $this->miFormulario->div_especifico ( "inicio", $atributos );
				echo $this->miFormulario->div_especifico ( "fin", $atributos );
				unset ( $atributos );
				
				$atributos ['id'] = '';
				$atributos ['estilo'] = "estilo_tr";
				$atributos ['estiloEnLinea'] = 'cursor: pointer;';
				$atributos ['tipo_etiqueta'] = "td";
				$atributos ['mensaje'] = $matrizRespuesta [$i] [4];
				echo $this->miFormulario->div_especifico ( "inicio", $atributos );
				echo $this->miFormulario->div_especifico ( "fin", $atributos );
				unset ( $atributos );
				
				$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
				
				$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
				$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
				$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				
				$variable = "pagina=" . "consultaEvaluacionAnteproyecto";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&anteproyecto=" . $_REQUEST ['anteproyecto'];
				$variable .= "&revision=" . $matrizRespuesta [$i] [1];
				$variable .= "&concepto=" . $matrizRespuesta [$i] [2];
				$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );
				
				unset ( $atributos );
				
				$esteCampo = 'verEvaluacion' . $i;
				$atributos ['id'] = $esteCampo;
				$atributos ['enlace'] = $variable;
				$atributos ['tabIndex'] = 1;
				$atributos ['estilo'] = 'textoSubtitulo';
				$atributos ['enlaceTexto'] = $matrizRespuesta [0] [2];
				$atributos ['ancho'] = '10%';
				$atributos ['alto'] = '10%';
				$atributos ['redirLugar'] = true;
				echo $this->miFormulario->enlace ( $atributos );
				
				$atributos ['tipo_etiqueta'] = "td";
				echo $this->miFormulario->div_especifico ( "fin", $atributos );
				unset ( $atributos );
				
				$atributos ['id'] = '';
				$atributos ['estilo'] = "estilo_tr";
				$atributos ['tipo_etiqueta'] = "td";
				$atributos ['mensaje'] = $matrizRespuesta [0] [1];
				echo $this->miFormulario->div_especifico ( "inicio", $atributos );
				echo $this->miFormulario->div_especifico ( "fin", $atributos );
				unset ( $atributos );
				
				$atributos ['tipo_etiqueta'] = "tr";
				echo $this->miFormulario->div_especifico ( "fin", $atributos );
				unset ( $atributos );
			}
			
			$atributos ['tipo_etiqueta'] = "table";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			echo "<br>";
			
			echo $this->miFormulario->division ( "fin" );
		} else {
			
			$atributos ['id'] = "proceso";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "plugins corner margen-interna";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "plugin";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "titulo-tablero-revision";
			$atributos ['mensaje'] = 'Proceso de Revisi&oacute;n';
			$atributos ['tipo_etiqueta'] = "span";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = 'table-formulario';
			echo $this->miFormulario->crearTabla3 ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "icon-mini-info";
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "mensaje-ayuda";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['mensaje'] = 'Aun no existen procesos de evaluaci&oacute;n iniciados. Para
												iniciar un proceso de evaluaci&oacute;n es indispensable que
												solicite revisi&oacute;n de la &uacute;ltima versi&oacute;n
												del documento del proyecto. <br> <br> <b>NOTA:</b> Una vez
												solicite la revisi&oacute;n, los revisores tendr&aacute;n un
												plazo m&aacute;ximo de <span class="resaltado">20
													d&iacute;as calendario</span> para dar repuesta a la
												solicitud la c&uacute;al ser&aacute; notificada a los
												estudiantes a traves del correo electr&oacute;nico.';
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			echo $this->miFormulario->crearTabla3 ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			echo $this->miFormulario->division ( "fin" );
			echo $this->miFormulario->division ( "fin" );
			echo $this->miFormulario->division ( "fin" );
		}
		
		$modi = false;
		if ($matrizRespuesta) {
			foreach ( $matrizRespuesta as $clave => $valor ) {
				if ($valor [2] == "MODIFICABLE") {
					$modi = true;
				}
			}
		}
		
		if (! $modi) {
			
			$atributos ['id'] = "modif";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "plugins corner margen-interna";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "plugin";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "titulo-tablero-revision";
			$atributos ['mensaje'] = 'Solicitud de Modificaci&oacute;n';
			$atributos ['tipo_etiqueta'] = "span";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['estilo'] = 'table-formulario';
			echo $this->miFormulario->crearTabla3 ( "inicio", $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "icon-mini-info";
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "mensaje-ayuda";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['mensaje'] = 'No existen procesos de modificaci&oacute;n pendientes. Es
						indispensable que todos los procesos de revisi&oacute;n finalicen
						para determinar si es necesario realizar modificaciones al
						documento. <br> <br> <b>NOTA:</b> Una vez exista una solicitud de
						modificaci&oacute;n, los estudiantes tendr&aacute;n un plazo
						m&aacute;ximo de <span class="resaltado">25 d&iacute;as calendario
						</span> para dar modificar el documento y solicitar nuevamente la
						revisi&oacute;n por parte de los revisores.';
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			echo $this->miFormulario->crearTabla3 ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
		} else {
			
			$atributos ['id'] = "modif";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['mensaje'] = 'Solicitud de modificacion';
			$atributos ['tipo_etiqueta'] = "h4";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "idnt";
			$atributos ['mensaje'] = 'A continuacion se observa la modificacion requerida por el revisor:';
			$atributos ['tipo_etiqueta'] = "p";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "proc";
			$atributos ['estilo'] = "table";
			$atributos ['tipo_etiqueta'] = "table";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['estilo'] = 'estilo_tr tit';
			$atributos ['colspan'] = 5;
			$atributos ['mensaje'] = 'Solicitudes de modificacion de revision';
			$atributos ['tipo_etiqueta'] = "td";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "";
			$atributos ['estilo'] = "";
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "table-tittle estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['colspan'] = 2;
			$atributos ['mensaje'] = 'Revisor';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "table-tittle estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['mensaje'] = 'Fecha solicitud';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "table-tittle estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['mensaje'] = 'Concepto respuesta';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = '';
			$atributos ['estilo'] = "table-tittle estilo_tr";
			$atributos ['tipo_etiqueta'] = "td";
			$atributos ['mensaje'] = 'Fecha respuesta';
			echo $this->miFormulario->div_especifico ( "inicio", $atributos );
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			$atributos ['tipo_etiqueta'] = "tr";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			for($i = 0; $i < count ( $matrizRespuesta ); $i ++) {
				
				if ($matrizRespuesta [$i] [2] == "MODIFICABLE") {
					
					$atributos ['id'] = "";
					$atributos ['estilo'] = "";
					$atributos ['tipo_etiqueta'] = "tr";
					echo $this->miFormulario->div_especifico ( "inicio", $atributos );
					unset ( $atributos );
					
					$atributos ['id'] = "";
					$atributos ['estilo'] = "estilo_tr";
					$atributos ['tipo_etiqueta'] = "td";
					echo $this->miFormulario->div_especifico ( "inicio", $atributos );
					unset ( $atributos );
					
					$atributos ['id'] = "";
					$atributos ['estilo'] = "corner bg-imagen-documento";
					echo $this->miFormulario->division ( "inicio", $atributos );
					unset ( $atributos );
					
					$atributos ['id'] = "documento";
					$atributos ['estilo'] = "icon-mini-people";
					echo $this->miFormulario->division ( "inicio", $atributos );
					unset ( $atributos );
					
					echo $this->miFormulario->division ( "fin" );
					
					$atributos ['tipo_etiqueta'] = "td";
					echo $this->miFormulario->div_especifico ( "fin", $atributos );
					unset ( $atributos );
					
					$atributos ['id'] = '';
					$atributos ['estilo'] = "estilo_tr";
					$atributos ['tipo_etiqueta'] = "td";
					$atributos ['mensaje'] = $matrizRespuesta [$i] [3];
					echo $this->miFormulario->div_especifico ( "inicio", $atributos );
					echo $this->miFormulario->div_especifico ( "fin", $atributos );
					unset ( $atributos );
					
					$atributos ['id'] = '';
					$atributos ['estilo'] = "estilo_tr";
					$atributos ['tipo_etiqueta'] = "td";
					$atributos ['mensaje'] = $matrizRespuesta [$i] [4];
					echo $this->miFormulario->div_especifico ( "inicio", $atributos );
					echo $this->miFormulario->div_especifico ( "fin", $atributos );
					unset ( $atributos );
					
					$atributos ['id'] = '';
					$atributos ['estilo'] = "estilo_tr";
					$atributos ['tipo_etiqueta'] = "td";
					$atributos ['mensaje'] = $matrizRespuesta [$i] [2];
					echo $this->miFormulario->div_especifico ( "inicio", $atributos );
					echo $this->miFormulario->div_especifico ( "fin", $atributos );
					unset ( $atributos );
					
					$atributos ['id'] = '';
					$atributos ['estilo'] = "estilo_tr";
					$atributos ['tipo_etiqueta'] = "td";
					$atributos ['mensaje'] = $matrizRespuesta [$i] [0];
					echo $this->miFormulario->div_especifico ( "inicio", $atributos );
					echo $this->miFormulario->div_especifico ( "fin", $atributos );
					unset ( $atributos );
					
					$atributos ['tipo_etiqueta'] = "tr";
					echo $this->miFormulario->div_especifico ( "fin", $atributos );
					unset ( $atributos );
					
				}
			}
			
			$atributos ['tipo_etiqueta'] = "table";
			echo $this->miFormulario->div_especifico ( "fin", $atributos );
			unset ( $atributos );
			
			echo "<br>";
			
			echo $this->miFormulario->division ( "fin" );
		}
		
		echo $this->miFormulario->division ( "fin" );
		echo $this->miFormulario->division ( "fin" );
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botones";
		$atributos ["estilo"] = "marcoBotones";
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		// ------------------Fin Division para los botones-------------------------
		echo $this->miFormulario->division ( "fin" );
		
		// ------------------- SECCION: Paso de variables ------------------------------------------------
		
		/**
		 * En algunas ocasiones es Ãºtil pasar variables entre las diferentes pÃ¡ginas.
		 * SARA permite realizar esto a travÃ©s de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesiÃ³n. EstarÃ¡n disponibles durante toda la sesiÃ³n de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor serÃ¡ una cadena codificada que contiene las variables.
		 * (c) a travÃ©s de campos ocultos en los formularios. (deprecated)
		 */
		
		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
		
		// Paso 1: crear el listado de variables
		
		$valorCodificado = "action=" . $esteBloque ["nombre"]; // Ir pagina Funcionalidad
		$valorCodificado = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' ); // Frontera mostrar formulario
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
		$valorCodificado .= "&informe=" . $_REQUEST ['informe'];
		if (isset ( $_REQUEST ['estudiante'] )) {
			$valorCodificado .= "&estudiante=" . $_REQUEST ['estudiante'];
		}
		$valorCodificado .= "&rol=" . $rol;
		$valorCodificado .= "&opcion=asignar";
		
		// echo $valorCodificado;
		/**
		 * SARA permite que los nombres de los campos sean dinÃ¡micos.
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
		// Se debe declarar el mismo atributo de marco con que se iniciÃ³ el formulario.
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
			$atributos ["columnas"] = ''; // El control ocupa 47% del tamaÃ±o del formulario
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