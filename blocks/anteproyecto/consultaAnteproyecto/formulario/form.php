<?php

namespace anteproyecto\consultaAnteproyecto\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
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
		
		if (! isset ( $_REQUEST ['anteproyecto'] )) {
			if (isset ( $_REQUEST ['numanteproyecto'] )) {
				$_REQUEST ['anteproyecto'] = $_REQUEST ['numanteproyecto'];
			} elseif (isset ( $_REQUEST ['ante'] )) {
				$_REQUEST ['anteproyecto'] = $_REQUEST ['ante'];
			}
		}
		$matrizRevisiones = null;
		
		$conexion = 'estructura';
		$esteRecurso = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$usuario = $this->miSesion->getSesionUsuarioId ();
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarRol", $_REQUEST ['usuario'] );
		$matrizRol = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$roles = $this->miSesion->RolesSesion ();
		$rol = array ();
		
		foreach ( $roles as $r ) {
			array_push ( $rol, $r ['rol'] );
		}
		
		$acceso = false;
		$mostrar = false;
		
		if (in_array ( "Estudiante", $rol )) {
			$mostrar = true;
			$_REQUEST ["variable"] = $_REQUEST ['usuario'];
			$_REQUEST ['estudiante'] = $_REQUEST ['usuario'];
		}
		
		if (in_array ( "Coordinador", $rol ) || in_array ( "Desarrollo y Pruebas", $rol )) {
			$acceso = true;
			$mostrar = true;
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
		
		// Hidden para anteproyecto
		$esteCampo = 'id';
		$atributos ["id"] = $esteCampo;
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ['validar'] = '';
		$atributos ["obligatorio"] = true;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ['valor'] = $_REQUEST ['anteproyecto'];
		
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// /////////////////////////////////
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAnteproyecto", $_REQUEST ['anteproyecto'] );
		$matrizAnteproyecto = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$id = $_REQUEST ['anteproyecto'];
		$director = $matrizAnteproyecto [0] ['nombre'];
		
		// Buscar tematicas asociadas
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarTematicas", $_REQUEST ['anteproyecto'] );
		$matrizTematicas = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$nomTematicas = array ();
		for($i = 0; $i < count ( $matrizTematicas ); $i ++) {
			array_push ( $nomTematicas, $matrizTematicas [$i] ['nombre'] );
		}
		
		// Buscar estudiantes asociados
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAutores", $_REQUEST ['anteproyecto'] );
		$matrizAutores = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$nomAutores = array ();
		for($i = 0; $i < count ( $matrizAutores ); $i ++) {
			array_push ( $nomAutores, $matrizAutores [$i] [1] );
		}
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarVersiones" );
		$matrizVersiones = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarRevisores" );
		$matrizRevisores = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		// var_dump($matrizRevisores);
		
		// buscar solicitudes de revision
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarSolicitudes" );
		$matrizSolicitudes = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarRevisionesPrueba", $_REQUEST ['anteproyecto'] );
		$matrizRevisionesPrueba = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		// var_dump($matrizRevisionesPrueba);
		
		// ////////////////Hidden////////////
		$esteCampo = 'revisionAntp';
		$atributos ["id"] = $esteCampo;
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ['validar'] = '';
		$atributos ["obligatorio"] = true;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ['valor'] = '0';
		
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		$itera = 1;
		
		?>
<div class="canvas-contenido">
	<h1>Anteproyecto No. <?php echo $id?></h1>
	<div id="izq">
		<h3>Información General</h3>
		<table id="documento" class="table">
			<tr>
				<td id="col" rowspan="7">
					<div class="corner bg-imagen-documento">
						<div id="documento" class="icon-max-pdf">
						<?php
		echo $this->miFormulario->division ( "fin" );
		?>
						<div class="codigo-documento">Versión No.1
						<?php
		echo $this->miFormulario->division ( "fin" );
		echo $this->miFormulario->division ( "fin" );
		?>
				
				
				
				
				</td>
				<td class="table-tittle estilo_tr">Titulo</td>
				<td class="estilo_tr"><?php echo $matrizAnteproyecto[0][3]?></td>
			</tr>

			<tr>
				<td class="table-tittle estilo_tr">Modalidad de Grado</td>
				<td class="estilo_tr"><?php echo $matrizAnteproyecto[0][1]?></td>
			</tr>

			<tr>
				<td class="table-tittle estilo_tr">Temáticas de Interés</td>
				<td class="estilo_tr"><?php
		for($i = 0; $i < count ( $nomTematicas ); $i ++) {
			echo $nomTematicas [$i]?><br> <?php
			
			;
		}
		?></td>
			</tr>

			<tr>
				<td class="table-tittle estilo_tr">Estado</td>
				<td class="estilo_tr"><?php echo $matrizAnteproyecto[0][6]?></td>
			</tr>

		</table>

		<h3>Autores y Directores</h3>

		<table class="table">
			<tr>
				<td class="table-tittle estilo_tr">Autores</td>
				<td class="estilo_tr"><?php
		for($i = 0; $i < count ( $nomAutores ); $i ++) {
			echo $nomAutores [$i]?><br> <?php
			;
		}
		?></td>
			</tr>

			<tr>
				<td class="table-tittle estilo_tr">Directores Internos</td>
				<td class="estilo_tr"><?php echo $director?></td>
			</tr>

		</table>

		<h3>Documentos Anexos</h3>
		<table id="documento" class="table">
			<tr>
				<td id="col">
					<div class="corner bg-imagen-documento">
						<div id="documento" class="docs-anexos-icon">
						<?php
		echo $this->miFormulario->division ( "fin" );
		?>
						</div>
						<div class="codigo-documento">Anexos
						<?php
		echo $this->miFormulario->division ( "fin" );
		echo $this->miFormulario->division ( "fin" );
		?>
				
				</td>
				<td class="estilo_tr">Documentación anexa</td>
			</tr>
		</table>
		
		<?php
		
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
		$atributos ['estiloEnLinea'] = 'padding: 8px';
		// verificar: true para verificar el formulario antes de pasarlo al servidor.
		$atributos ["verificar"] = '';
		$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
		$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$atributos ['deshabilitado'] = false;
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoBoton ( $atributos );
		unset ( $atributos );
		// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		
		// si ha recibido viable por parte de los revisores se ACTIVA botón PROYECTO
		$esViable = false;
		for($i = 0; $i < count ( $matrizRevisionesPrueba ); $i ++) {
			//var_dump($matrizRevisionesPrueba [$i] [2]);
			if ($matrizRevisionesPrueba [$i] [2] == 'VIABLE') {
				$esViable = true;
			}
		}
		
		if ($esViable && (count ( $matrizRevisionesPrueba ) == count ( $matrizSolicitudes )) && ($matrizAnteproyecto [0] [7] != "PROYECTO") && in_array ( "Estudiante", $rol ) && !($matrizAnteproyecto[0][6] == "PROYECTO")) {
			
			// -----------------CONTROL: Botón ----------------------------------------------------------------
			$esteCampo = 'botonIniciar';
			$atributos ["id"] = $esteCampo;
			$atributos ["tabIndex"] = $tab;
			$atributos ["tipo"] = 'boton';
			// submit: no se coloca si se desea un tipo button genérico
			$atributos ['submit'] = true;
			$atributos ["estiloMarco"] = '';
			$atributos ["estiloBoton"] = 'jqueryui';
			$atributos ['estiloEnLinea'] = 'padding: 8px';
			// verificar: true para verificar el formulario antes de pasarlo al servidor.
			$atributos ["verificar"] = '';
			$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
			$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoBoton ( $atributos );
			unset ( $atributos );
			// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		}
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		if ($matrizRevisores == null && $acceso) {
			$esteCampo = 'botonA';
			$atributos ["id"] = $esteCampo;
			$atributos ["tabIndex"] = $tab;
			$atributos ["tipo"] = 'boton';
			// submit: no se coloca si se desea un tipo button genérico
			$atributos ['submit'] = true;
			$atributos ["estiloMarco"] = '';
			$atributos ["estiloBoton"] = 'jqueryui';
			$atributos ['estiloEnLinea'] = 'padding: 8px';
			// verificar: true para verificar el formulario antes de pasarlo al servidor.
			$atributos ["verificar"] = '';
			$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
			$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
			$atributos ['deshabilitado'] = false;
			// $atributos ['deshabilitado'] = true;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoBoton ( $atributos );
			unset ( $atributos );
		}
		// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		if ($matrizRevisionesPrueba && $matrizAnteproyecto [0] [6] != 'NO APROBADO' && $mostrar && in_array ( "Estudiante", $rol ) && !$esViable) {
			$esteCampo = 'btnCrearVersion';
			$atributos ["id"] = $esteCampo;
			$atributos ["tabIndex"] = $tab;
			$atributos ["tipo"] = 'boton';
			// submit: no se coloca si se desea un tipo button genérico
			$atributos ['submit'] = true;
			$atributos ["estiloMarco"] = '';
			$atributos ["estiloBoton"] = 'jqueryui';
			$atributos ['estiloEnLinea'] = 'padding: 8px';
			// verificar: true para verificar el formulario antes de pasarlo al servidor.
			$atributos ["verificar"] = '';
			$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
			$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
			$atributos ['deshabilitado'] = false;
			// $atributos ['deshabilitado'] = true;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoBoton ( $atributos );
			unset ( $atributos );
		}
		// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		if ($matrizRevisionesPrueba && $matrizAnteproyecto [0] [6] != 'NO APROBADO' && $mostrar && in_array ( "Estudiante", $rol ) && !$esViable) {
			$esteCampo = 'btnSolicitarRevision';
			$atributos ["id"] = $esteCampo;
			$atributos ["tabIndex"] = $tab;
			$atributos ["tipo"] = 'boton';
			// submit: no se coloca si se desea un tipo button genérico
			$atributos ['submit'] = true;
			$atributos ["estiloMarco"] = '';
			$atributos ["estiloBoton"] = 'jqueryui';
			$atributos ['estiloEnLinea'] = 'padding: 8px';
			// verificar: true para verificar el formulario antes de pasarlo al servidor.
			$atributos ["verificar"] = '';
			$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
			$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
			$atributos ['deshabilitado'] = false;
			// $atributos ['deshabilitado'] = true;
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoBoton ( $atributos );
			unset ( $atributos );
		}
		// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		
		// ------------------Fin Division para los botones-------------------------
		echo $this->miFormulario->division ( "fin" );
		
		echo $this->miFormulario->division ( "fin" );
		
		?>

	<div id="der">
			<div id="versiones">
				<h3>Versiones del Documento</h3>

				<Blockquote
					style="font-size: 15px; border-left: none; margin-bottom: 0px">A
					continuación encontrará las últimas versiones del documento que
					se hayan cargado al sistema. Para cargar el documento por favor
					seleccione la versión que desea descargar.</Blockquote>

				<table id="vers" class="table">
					<tr>
						<td class="estilo_tr" colspan="4">Versión actual: Versión No. 
						<?php
		// buscar la versi�n registrada no contarla
		echo count ( $matrizVersiones );
		?></td>
					</tr>
					<tr>
						<td class="table-tittle estilo_tr" style="padding: 4px;"
							colspan="2">Versión</td>
						<td class="table-tittle estilo_tr" style="padding: 4px;">Nombre
							del documento</td>
						<td class="table-tittle estilo_tr" style="padding: 4px;">Fecha de
							subida</td>
					</tr>
				<?php
		for($i = count ( $matrizVersiones ) - 1; $i >= 0; $i --) {
			?>
				<tr>
						<td class="estilo_tr" style="padding: 4px;">
							<div class="corner bg-imagen-documento">
								<div id="documento" class="icon-mini-archivo">
							<?php
			echo $this->miFormulario->division ( "fin" );
			?>
							<div class="codigo-documento">
							<?php
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			?>		
						
						</td>
						<td class="estilo_tr" style="padding: 4px;">
						<?php
			
			if (strlen ( $matrizVersiones [$i] [0] ) < 10) {
				echo $matrizVersiones [$i] [0];
			} else {
				echo substr ( $matrizVersiones [$i] [0], 10 ) . "...";
			}
			?>
					</td>
						<td class="estilo_tr" style="padding: 4px;">
						<?php
			// echo $matrizItems5 [$i] [1];
			$tam = strlen ( $matrizVersiones [$i] [1] );
			// echo $matrizItems5 [$i] [1];
			// echo $tam;
			if ($tam < 30) {
				echo "<a href='" . $matrizVersiones [$i] [2] . "' download='" . $matrizVersiones [$i] [1] . "'>" . $matrizVersiones [$i] [1] . "</a>";
			} else {
				$nombre = substr ( $matrizVersiones [$i] [1], 0, 12 ) . " .. " . substr ( $matrizVersiones [$i] [1], - 5 );
				echo "<a href='" . $matrizVersiones [$i] [2] . "' download='" . $matrizVersiones [$i] [1] . "'>" . $nombre . "</a>";
			}
			?>
				</td>
						<td class="estilo_tr" style="padding: 4px;">
						<?php
			echo $matrizVersiones [$i] [3];
			?>
				</td>
					</tr>
				<?php
		}
		?>
			</table>
				

		<?php
		echo $this->miFormulario->division ( "fin" );
		
		if ($matrizRevisores) {
			?>
			<div id="revisores">
					<h3>Solicitudes de Asignación de Revisor</h3>

					<Blockquote
						style="font-size: 15px; border-left: none; margin-bottom: 0px">A
						continuación encontrará un resumen de las solicitudes creadas.</Blockquote>

					<table id="vers" class="table">
						<tr>
							<td class="estilo_tr" colspan="4">Solicitudes de asignación de
								revisor</td>
						</tr>
						<tr>
							<td class="table-tittle estilo_tr" style="padding: 4px;"
								colspan="2">Fecha solicitud</td>
							<td class="table-tittle estilo_tr" style="padding: 4px;">Docente
								asignado</td>
							<td class="table-tittle estilo_tr" style="padding: 4px;">Estado</td>
						</tr>
				<?php
			for($i = 0; $i < count ( $matrizRevisores ); $i ++) {
				?>
				<tr>
							<td class="estilo_tr" style="padding: 4px;">
								<div class="corner bg-imagen-documento">
									<div id="documento" class="icon-mini-people">
							<?php
				echo $this->miFormulario->division ( "fin" );
				?>
							<div class="codigo-documento">
							<?php
				echo $this->miFormulario->division ( "fin" );
				
				echo $this->miFormulario->division ( "fin" );
				
				?>			
							
							</td>
							<td class="estilo_tr">
						<?php echo $matrizSolicitudes[$i][0];?>
					</td>
							<td class="estilo_tr">
						<?php echo $matrizSolicitudes [$i][8];?>
					</td>
							<td class="estilo_tr">
						<?php echo $matrizSolicitudes[$i][5]?>
					</td>
						</tr>
				<?php
			}
			?>
			</table>
		<?php
			echo $this->miFormulario->division ( "fin" );
		} else {
			?>
		<div id="revisores">
						<h3>Solicitudes de Asignación de Revisor</h3>

						<table class="table-formulario">
							<tbody>
								<tr>
									<td>
										<div class="icon-mini-info"></div>
									</td>
									<td>
										<div class="mensaje-ayuda">
											<div>Aun no existen solicitudes de asignación de revisión
									indicadas por el programa curricular.
									<?php
			echo $this->miFormulario->division ( "fin" );
			?>
							</div>
											<br> <b>NOTA: </b> Una vez el programa curricular inicie las
											solicitudes, los revisores tendran un plazo máximo de <span
												class="resaltado">10 dias calendario</span> para dar
											respuesta a la solicitud
									
									</td>

								</tr>
							</tbody>
						</table>
						<br>
		<?php
			echo $this->miFormulario->division ( "fin" );
		}
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "ultimaIteracion" );
		$iteracion = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		// var_dump($iteracion);
		
		// ////////////////////////////////////////////////////////
		// 1)buscar ultima solicitud
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarSolicitudes" );
		$solicitud = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		// 2)Buscar documento de solicitud
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarDocumentoSolicitud", $solicitud [0] [0] );
		$documentoSolicitud = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		// 3)evaluaciones: Estudiante
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarEvaluacionEstudiante", $documentoSolicitud [0] [0] );
		$evalDocumentoEstudiante = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		// var_dump($evalDocumentoEstudiante);
		
		// 4)evaluaciones: Revisor
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarEvaluacionRevisor", $documentoSolicitud [0] [0] );
		$evalDocumentoRevisor = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		//var_dump($evalDocumentoRevisor);
		// ///////////////////////////////////////////////////////
		
		if ($iteracion [0] [0] != null && $iteracion [0] [0]<3) {
			$itera = $iteracion [0] [0]+1;
		}
		
		?>
	
	<div id="proceso">
		<h3>Proceso de revisión (<?php echo $itera; ?>/3)</h3>
			
<?php
		
if ($matrizRevisores) {
			//
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarVersiones2" );
			$matrizVersiones2 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			// var_dump($matrizVersiones2);
			
			?>

			<p>
				<Blockquote
					style="font-size: 15px; border-left: none; margin-bottom: 0px; padding-top: 1px; padding-bottom: 1px;">Responsable:
					Revisores</Blockquote>
			</p>

							<table class="table" style="margin-bottom: 0px;">
								<tr>
									<td class="estilo_tr" colspan="5">Documento Revisado: Versión
										No. <?php echo $matrizVersiones2[0][0]?></td>
								</tr>
								<tr>
									<td class="table-tittle estilo_tr" style="padding: 4px;"
										colspan="2">Revisor</td>
									<td class="table-tittle estilo_tr" style="padding: 4px;">Fecha
										de Solicitud</td>
									<td class="table-tittle estilo_tr" style="padding: 4px;">Concepto
										Respuesta</td>
									<td class="table-tittle estilo_tr" style="padding: 4px;">Fecha
										Respuesta</td>
								</tr>
				<?php
			// con solicitudes
			for($i = 0; $i < count ( $matrizRevisores ); $i ++) {
				
				?>
				<tr>
									<td class="estilo_tr" style="padding: 4px;">
										<div class="corner bg-imagen-documento">
											<div id="documento" class="icon-mini-people">
							<?php
				echo $this->miFormulario->division ( "fin" );
				?>
							<div class="codigo-documento">
							<?php
				echo $this->miFormulario->division ( "fin" );
				
				echo $this->miFormulario->division ( "fin" );
				?>
					
									
									
									</td>
									<td class="estilo_tr" style="padding: 4px;">
						<?php echo $matrizRevisores[$i]['nombre'];?>
					</td>
									<td class="estilo_tr" style="padding: 4px;">
						<?php echo $matrizRevisores [$i][0];?>
					</td>
				<?php
				
				
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarSolicitudesRev2" );
				$matrizSolicitudes2 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
				//var_dump($matrizSolicitudes2);
				
				// documento de la solicitud
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarDocumentoSolicitud", $matrizSolicitudes2 [0] [0] );
				$matrizDoc = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
				//var_dump($matrizDoc);
			
				// buscar evaluaciones del anteproyecto
				$datos = array (
						'anteproyecto' => $_REQUEST ['anteproyecto'],
						'documento' => $matrizDoc [0] [0],
						'revisor' => $matrizRevisores [$i] [1] 
				);
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarRevisiones", $datos );
				$matrizRevisiones = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
				
				//var_dump($matrizRevisiones);
				
				$n = 0;
				
				
				if ($evalDocumentoRevisor) {
					// var_dump($matrizRevisiones);
					?>
					<td class="estilo_tr" style="cursor: pointer; padding: 4px;">
						<?php
					
					$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
					
					$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
					$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
					$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
					
					$variable = "pagina=" . "consultaEvaluacionAnteproyecto";
					$variable .= "&usuario=" . $_REQUEST ['usuario'];
					$variable .= "&anteproyecto=" . $_REQUEST ['anteproyecto'];
					$variable .= "&revision=" . $matrizRevisiones [$n] [0];
					$variable .= "&concepto=" . $matrizRevisiones [$n] [2];
					$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );
					
					unset ( $atributos );
					// var_dump($matrizRevision);
					
					$esteCampo = 'verEvaluacion' . $i;
					$atributos ['id'] = $esteCampo;
					$atributos ['enlace'] = $variable;
					$atributos ['tabIndex'] = 1;
					$atributos ['estilo'] = 'textoSubtitulo';
					$atributos ['enlaceTexto'] = $matrizRevisiones [0] [2];
					$atributos ['ancho'] = '10%';
					$atributos ['alto'] = '10%';
					$atributos ['redirLugar'] = true;
					echo $this->miFormulario->enlace ( $atributos );
					unset ( $atributos );
					$n ++;
					?>
					</td>
									<td class="estilo_tr" style="padding: 4px;">
						<?php echo $matrizRevisiones[0][1]?>
					</td>
				<?php
				} else {
					?>
						<td class="estilo_tr" style="padding: 4px;">
							<?php echo "--"?>
						</td>
									<td class="estilo_tr" style="padding: 4px;">
							<?php echo "--"?>
						</td>
					<?php
				}
				?>	
					
				</tr>
				<?php
			}
			?>
			</table>
							<div style="float: right">
<?php
			
			// -----------------CONTROL: Botón ----------------------------------------------------------------
			$esteCampo = 'botonSolicitudes';
			$atributos ["id"] = $esteCampo;
			$atributos ["tabIndex"] = $tab;
			$atributos ["tipo"] = '';
			// submit: no se coloca si se desea un tipo button genérico
			$atributos ["modal"] = 'myModal';
			$atributos ['submit'] = false;
			$atributos ["estiloMarco"] = '';
			$atributos ["estiloBoton"] = 'btn btn-link';
			$atributos ['estiloEnLinea'] = 'padding: 2px; margin-right:15px';
			// verificar: true para verificar el formulario antes de pasarlo al servidor.
			$atributos ["verificar"] = '';
			$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoBoton ( $atributos );
			unset ( $atributos );
			// -----------------FIN CONTROL: Botón -----------------------------------------------------------
			
			?>
		</div>
			
	<?php
		} else {
			?>
			
			<table class="table-formulario">
								<tbody>
									<tr>
										<td class="">
											<div class="icon-mini-info"></div>
										</td>
										<td>
											<div class="mensaje-ayuda">
												<div>
													Aun no existen procesos de evaluaci&oacute;n iniciados.
													Para iniciar un proceso de evaluaci&oacute;n es
													indispensable que solicite revisi&oacute;n de la
													&uacute;ltima versi&oacute;n del documento del
													anteproyecto. <br> <br> <b>NOTA:</b> Una vez solicite la
													revisi&oacute;n, los revisores tendr&aacute;n un plazo
													m&aacute;ximo de <span class="resaltado">20 d&iacute;as
														calendario</span> para dar repuesta a la solicitud la
													c&uacute;al ser&aacute; notificada a los estudiantes a
													traves del correo electr&oacute;nico.
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
			
			<?php
		}
		?>		
			
	<?php
		
		echo $this->miFormulario->division ( "fin" );

		//|| !$matrizRevisores ||$matrizSolicitudes[$i][5]='ASIGNADA'
		if($evalDocumentoRevisor[0]['eval_cpto_rta']=='VIABLE' || !$matrizRevisores ||$matrizSolicitudes[0][5]=='ASIGNADA'  ) {
			?>
<div class="bg-tablero corner">
								<h4>Solicitud de modificación</h4>
								<div class="plugins corner margen-interna">
									<div class="plugin">
										<div>
											<table class="table-formulario">
												<tbody>
													<tr>
														<td>
															<div class="icon-mini-info"></div>
														</td>
														<td>
															<div class="mensaje-ayuda">
																<div>
																	No existen procesos de modificaci&oacute;n pendientes.
																	Es indispensable que todos los procesos de
																	revisi&oacute;n finalicen para determinar si es
																	necesario realizar modificaciones al documento. <br> <br>
																	<b>NOTA:</b> Una vez exista una solicitud de
																	modificaci&oacute;n, los estudiantes tendr&aacute;n un
																	plazo m&aacute;ximo de <span class="resaltado">25
																		d&iacute;as calendario </span> para dar modificar el
																	documento y solicitar nuevamente la revisi&oacute;n por
																	parte de los revisores.
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>

<?php
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
			
			echo $this->miFormulario->division ( "fin" );
		} 
		
		else {
			?>

	<div id="modif">
	
		<?php
			if ($iteracion [0] [0] > 1) {
				$itera = $iteracion [0] [0] - 1;
				$rev = $matrizRevisiones [0] ['eval_iteracion'] + 1;
			} else {
				$itera = $iteracion [0] [0];
				$rev = 1;
			}
			
			?>
		<h4>Proceso de Modificación (<?php echo $itera?>/2)</h4>
												<Blockquote
													style="font-size: 15px; border-left: none; margin-bottom: 0px; padding-top: 1px;">Responsable:
													Estudiantes</Blockquote>


												<table id="proc" class="table">
													<tr>
														<td class="estilo_tr " style="padding: 4px;" colspan="5">Documento por modificar Versión No. <?php echo $matrizRevisiones [0] [4]?></td>
													</tr>
													<tr>
														<td class="table-tittle estilo_tr" style="padding: 4px;"
															colspan="2">Estudiante que confirma Modificación</td>
														<td class="table-tittle estilo_tr" style="padding: 4px;">Estado
															Modificación</td>
														<td class="table-tittle estilo_tr" style="padding: 4px;">Fecha
															Modificación</td>
													</tr>
				<?php
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarModificaciones", $rev );
			$matrizRev = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			//var_dump($matrizRev);
			
			// for($i = 0; $i < count ( $matrizRevisiones ); $i ++) {
			// if ($matrizRevisiones [$i] [2] == "MODIFICABLE") {
			//var_dump($evalDocumentoEstudiante);
			// &&  $evalDocumentoEstudiante[0]['dantp_vers']=
			
// 			var_dump($iteracion [0] [0]);
// 			var_dump($evalDocumentoEstudiante[0]['dantp_vers']);
			
			if ($evalDocumentoEstudiante && ($evalDocumentoEstudiante[0]['dantp_vers']>$iteracion [0] [0])) {
				?>
				<tr>
														<td class="estilo_tr" style="padding: 4px;">
															<div class="corner bg-imagen-documento">
																<div id="documento" class="icon-mini-estd"></div>
															</div>
														</td>
														<td class="estilo_tr" style="padding: 4px;">
						<?php
				echo $evalDocumentoEstudiante [0] ['estd_estd'];
				?>
					</td>

														<td class="estilo_tr" style="padding: 4px;">
						<?php echo $evalDocumentoEstudiante[0]['eval_cpto_rta'];?>
					</td>
														<td class="estilo_tr" style="padding: 4px;">
						<?php echo $evalDocumentoEstudiante [0] ['eval_fcrea'];?>
					</td>
													</tr>
				<?php
			} 			// }
			// }
			
			else 
			
			if($matrizAnteproyecto[0][6]!='NO APROBADO'){
				?>
				<tr>
														<td class="estilo_tr" style="padding: 4px;">
															<div class="corner bg-imagen-documento">
																<div id="documento" class="icon-mini-estd"></div>
															</div>
														</td>
														<td class="estilo_tr" style="padding: 4px;">
					<?php
				// solicitud asignada
				echo '-----';
				?>
					</td>
														<td class="estilo_tr" style="padding: 4px;">
						<?php echo 'PENDIENTE';?>
					</td>
														<td class="estilo_tr" style="padding: 4px;">
						<?php echo '-----';?>
					</td>
													</tr>
			<?php
			}
			?>
			
			</table>
												
<?php
			echo $this->miFormulario->division ( "fin" );
		}
		
		echo $this->miFormulario->division ( "fin" );
		echo $this->miFormulario->division ( "fin" );
		
		// ventana dialog
		include ("dialog.php");
		
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
		
		// $valorCodificado = "action=" . $esteBloque ["nombre"]; // Ir pagina Funcionalidad
		$valorCodificado = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' ); // Frontera mostrar formulario
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&usuario=" . $usuario;
		if (isset ( $_REQUEST ['variable'] )) {
			$valorCodificado .= "&estudiante=" . $_REQUEST ['variable'];
		}
		$valorCodificado .= "&rol=" . $rol [0] [0];
		$valorCodificado .= "&anteproyecto=" . $_REQUEST ['anteproyecto'];
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