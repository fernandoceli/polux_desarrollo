<?php

namespace bloquesModelo\solRevAnteproyecto\formulario;

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
		
		$conexion = 'estructura';
		$esteRecurso = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$usuario = $this->miSesion->getSesionUsuarioId ();
		if (! isset ( $_REQUEST ['usuario'] )) {
			$_REQUEST ['usuario'] = $usuario;
		}
		
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
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarRol", $usuario );
		$matrizAnteproyectos = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$rol = $matrizAnteproyectos [0] [0];
		
		if (($rol == 'Administrador General') || ($rol == 'Desarrollo y Pruebas')) {
			$docente = $_REQUEST ["variable"];
			$acceso = true;
		}
		
		if (($rol == "Coordinador") || ($rol == "Docente")) {
			$acceso = true;
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarCodigo", $_REQUEST ["usuario"] );
			$matrizCodigo = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			$docente = $matrizCodigo [0] [0];
		}
		
		// Buscar Anteproyectos asignados al docente
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarSolicitudes", $docente );
		$matrizItems = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		// var_dump($matrizItems);
		
		?>
<br></br>
<?php
		
		if ($matrizItems [0] [0] != "") {
			
			$atributos ['mensaje'] = 'Solicitudes Pendientes de Revisión de Anteproyectos';
			$atributos ['tamanno'] = 'Enorme';
			$atributos ['linea'] = 'true';
			echo $this->miFormulario->campoMensaje ( $atributos );
			
			for($i = 0; $i < count ( $matrizItems ); $i ++) {
				$anteproyecto = $matrizItems [$i] [4];
				
				// buscar anteproyecto
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAnteproyecto", $anteproyecto );
				$matriz = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
				
				// ////////////////Hidden////////////
				$esteCampo = 'antpSolicitudes';
				$atributos ["id"] = $esteCampo;
				$atributos ["tipo"] = "hidden";
				$atributos ['estilo'] = '';
				$atributos ['validar'] = '';
				$atributos ["obligatorio"] = true;
				$atributos ['marco'] = true;
				$atributos ["etiqueta"] = "";
				$atributos ['valor'] = count ( $matrizItems );
				
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ////////////////////////////////////////
				
				?>

<div class="bg-caja corner" id="caja<?php echo $i ?>"
	style="float: left">
	<div class="caja corner">
		<div class="caja-header">
			<div class="caja-fecha" style="float: left"><?php echo $matrizItems[$i][8]?>
				<?php
				echo $this->miFormulario->division ( "fin" );
				?>
				<div class="caja-semaforo-gris" style="float: right">
				<?php
				echo $this->miFormulario->division ( "fin" );
				?>
				<div class="caja-semaforo-gris" style="float: right">
				<?php
				echo $this->miFormulario->division ( "fin" );
				?>
				<div class="caja-semaforo-verde" style="float: right">
				<?php
				echo $this->miFormulario->division ( "fin" );
				?>
				<div class="clearboth">
								<br></br>
				<?php
				echo $this->miFormulario->division ( "fin" );
				echo $this->miFormulario->division ( "fin" );
				?>
			<div>
									<div class="caja-codigo" style="float: left">
										<div class="caja-icon-documento">
					<?php
				echo $this->miFormulario->division ( "fin" );
				?>
					<p class="caja-numero" id="cajanum<?php echo $i ?>"><?php echo 'No. '. $matrizItems[$i][4]?></p>
				<?php
				echo $this->miFormulario->division ( "fin" );
				?>
				<div class="caja-info" style="float: left">
												<table style="border: 0; width: 100%">
													<tbody>
														<tr>
															<td><b>Solicitante:</b></td>
															<td><?php echo $matrizItems[$i][3]; ?></td>
														</tr>
														<tr>
															<td><b>Anteproyecto:</b></td>
															<td><?php echo 'No. '.$matrizItems[$i][4]; ?></td>
														</tr>
														<tr>
															<td><b>Estado:</b></td>
															<td><?php echo $matrizItems[$i][6]; ?></td>
														</tr>
														<tr>
															<td><b>Dias Restantes:</b></td>
															<td><?php
				$hoy = date ( "Y-m-d" );
				$dias = (strtotime ( $hoy ) - strtotime ( $matrizItems [$i] [8] )) / 86400;
				$dias = abs ( $dias );
				$dias = floor ( $dias );
				echo 20 - $dias . "/20";
				?></td>
														</tr>
													</tbody>
												</table>
												<p></p>
	
				<?php
				echo $this->miFormulario->division ( "fin" );
				
				$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
				$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
				$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				
				$variableVer = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
				$variableVer .= "&opcion=ver";
				$variableVer .= "&usuario=" . $_REQUEST ['usuario'];
				$variableVer .= "&anteproyecto=" . $matrizItems [$i] [4];
				$variableVer .= "&solicitud=" . $matrizItems [$i] [0];
				$variableVer .= "&campoSeguro=" . $_REQUEST ['tiempo'];
				$variableVer .= "&tiempo=" . time ();
				
				$variableVer = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variableVer, $directorio );
				
				// -------------Enlace-----------------------
				$esteCampo = "enlaceVer";
				$atributos ["id"] = $esteCampo;
				$atributos ['enlace'] = $variableVer;
				$atributos ['tabIndex'] = $esteCampo;
				$atributos ['redirLugar'] = true;
				$atributos ['estilo'] = 'color';
				$atributos ['enlaceTexto'] = $this->lenguaje->getCadena ( $esteCampo );
				;
				$atributos ['ancho'] = '25';
				$atributos ['alto'] = '25';
				echo $this->miFormulario->enlace ( $atributos );
				unset ( $atributos );
				
				echo $this->miFormulario->division ( "fin" );
				echo $this->miFormulario->division ( "fin" );
				echo $this->miFormulario->division ( "fin" );

			}
		} else {
			$mostrar = false;
			$pag = $this->miConfigurador->fabricaConexiones->crypto->codificar ( "pagina=indexPolux" );
			
			$atributos ['id'] = "d";
			$atributos ['estilo'] = "canvas-contenido";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "d";
			$atributos ['estilo'] = "area-msg corner margen-interna";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "d";
			$atributos ['estilo'] = "icono-msg info";
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			$atributos ['id'] = "d";
			$atributos ['estilo'] = "content-msg info corner";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "d";
			$atributos ['estilo'] = "title-msg info";
			$atributos ['mensaje'] = 'Informacion';
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			$atributos ['id'] = "d";
			$atributos ['estilo'] = "";
			$atributos ['estiloEnLinea'] = "padding: 5px 0px;";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "d";
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$atributos ['id'] = "c";
			$atributos ['estilo'] = "";
			$atributos ['mensaje'] = 'No existen anteproyectos actualmente registrados para
					dirigir.';
			$atributos ['tipo_etiqueta'] = "contenido";
			echo $this->miFormulario->div_especifico("inicio", $atributos);
			unset($atributos);
			
			$atributos ['id'] = "d";
			$atributos ['onclick'] = "window.location = 'index.php?data=" . $pag;
			$atributos ['estilo'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			// -----------------CONTROL: Botón ----------------------------------------------------------------
			$esteCampo = 'botonInicio';
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
			
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['tipo_etiqueta'] = "contenido";
			echo $this->miFormulario->div_especifico("fin", $atributos);
			unset($atributos);
			
			echo $this->miFormulario->division ( "fin" );
			echo $this->miFormulario->division ( "fin" );
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['id'] = "d";
			$atributos ['estilo'] = "clearboth";
			echo $this->miFormulario->division ( "inicio", $atributos );
			echo $this->miFormulario->division ( "fin" );
			unset ( $atributos );
			
			echo $this->miFormulario->division ( "fin" );
			echo $this->miFormulario->division ( "fin" );
		}
		
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