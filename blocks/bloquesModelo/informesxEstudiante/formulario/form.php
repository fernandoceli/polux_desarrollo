<?php

namespace bloquesModelo\informesxEstudiante\formulario;

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
		$matrizInformes = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$rol = $matrizInformes [0] [0];
		$acceso = false;
		$mostrar = true;
		
		if ($rol == "Estudiante") {
			$acceso = true;
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarCodigo", $_REQUEST ["usuario"] );
			$cod = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			$_REQUEST ["variable"] = $cod [0] [0];
		}
		
		if (($rol == 'Administrador General') || ($rol == 'Desarrollo y Pruebas')) {
			$acceso = true;
		}
		
		if (isset ( $_REQUEST ["variable"] )) {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarInformes", $_REQUEST ["variable"] );
		} else {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarInformes", "0" );
		}
		$matrizInformes = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
// 		var_dump ( $matrizInformes );
		
		if (isset ( $_REQUEST ['variable'] )) {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarEstudiante", $_REQUEST ["variable"] );
			$matrizNombre = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			$mensaje = 'Informes finales por estudiante - ' . $matrizNombre [0] [0] . " - " . $_REQUEST ["variable"];
		} else {
			$mensaje = 'Informes finales por estudiante ';
		}
		
		?>
		<h2><?php echo $mensaje;?></h2>
		<?php 
		
		if ($matrizInformes) {
			
			for($i = 0; $i < count ( $matrizInformes ); $i ++) {
				$informe = $matrizInformes [$i] ['informe'];
				
				$titulo = $matrizInformes [$i] ['titulo'];
				if ($titulo == strtoupper ( $titulo )) {
					$titulo = substr ( $titulo, 0, 45 ) . "...";
				}
				if (strlen ( $titulo ) > 60) {
					$titulo = substr ( $titulo, 0, 55 ) . "...";
				}
				
				?>

<div class="bg-caja corner" id="caja<?php echo $i ?>"
	style="float: left">
	<div class="caja corner">
		<div class="caja-header">
			<div class="caja-fecha" style="float: left"><?php echo $matrizInformes[$i]['fecha']?>
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
							<div class="caja-icon-documento"></div>
							<p class="caja-numero" id="cajanum<?php echo $i ?>"><?php echo 'No. '. $matrizInformes[$i]['informe']?></p>
				<?php
				echo $this->miFormulario->division ( "fin" );
				?>
			<div class="caja-info" style="float: left">
								<table style="border: 0; width: 100%">
									<tbody>
										<tr>
											<td><b>Titulo:</b></td>
											<td><?php echo $titulo ?></td>
										</tr>
										<tr>
											<td><b>Modalidad:</b></td>
											<td><?php echo $matrizInformes[$i]['modalidad'] ?></td>
										</tr>
										<tr>
											<td><b>Estado:</b></td>
											<td><?php echo $matrizInformes[$i]['estado'] ?></td>
										</tr>
									</tbody>
								</table>
								<p></p>

										<?php
				
				echo $this->miFormulario->division ( "fin" );
				
				$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
				$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
				$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				
				// $variableVer = "action=" . $esteBloque ["nombre"];
				$variableVer = "pagina=verInformeFinal";
				$variableVer .= "&usuario=" . $_REQUEST ['usuario'];
				$variableVer .= "&informe=" . $matrizInformes [$i] ['informe'];
				if (isset ( $docente )) {
					$variableVer .= "&docente=" . $docente;
				}
				$variableVer .= "&rol=" . $rol;
				
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
				
				?>
									</div>
						</div>
					</div>

<?
			}
		} else {
			?>
<div class="ui-widget">
	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p>
			<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
			<strong>Informaci&oacute;n!</strong>
			No existen anteproyectos sin revisores asignados.
		</p>
	</div>
</div>
<?php
			// ------------------Division para los botones-------------------------
			$atributos ["id"] = "botones";
			$atributos ["estilo"] = "marcoBotones";
			$atributos ["titulo"] = "Enviar InformaciÃ³n";
			echo $this->miFormulario->division ( "inicio", $atributos );
			
			// -----------------CONTROL: BotÃ³n ----------------------------------------------------------------
			$esteCampo = 'botonInicio';
			$atributos ["id"] = $esteCampo;
			$atributos ["tabIndex"] = $tab;
			$atributos ["tipo"] = 'boton';
			// submit: no se coloca si se desea un tipo button genÃ©rico
			$atributos ['submit'] = true;
			$atributos ["estiloMarco"] = '';
			$atributos ["estiloBoton"] = '';
			// verificar: true para verificar el formulario antes de pasarlo al servidor.
			$atributos ["verificar"] = '';
			$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la funciÃ³n submit declarada en ready.js
			$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoBoton ( $atributos );
			// -----------------FIN CONTROL: Botï¿½n -----------------------------------------------------------
		}
		
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
		
		$valorCodificado = "action=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&usuario=" . $usuario;
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=ver";
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