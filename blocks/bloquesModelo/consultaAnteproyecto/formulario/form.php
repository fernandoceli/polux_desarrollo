<?php

namespace bloquesModelo\consultaAnteproyecto\formulario;

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
		
		if (! isset ( $_REQUEST ['anteproyecto'] )) {
			if (isset ( $_REQUEST ['numanteproyecto'] )) {
				$_REQUEST ['anteproyecto'] = $_REQUEST ['numanteproyecto'];
			} elseif (isset ( $_REQUEST ['ante'] )) {
				$_REQUEST ['anteproyecto'] = $_REQUEST ['ante'];
			}
		}
		
		$conexion = 'estructura';
		$esteRecurso = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// saber si es coordinador
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarRol", $_REQUEST ['usuario'] );
		$matrizAnteproyectos = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		// var_dump($matrizItems);
		$coordinador = false;
		for($i = 0; $i < count ( $matrizAnteproyectos ); $i ++) {
			// or $matrizItems[$i][0]='Desarrollo y Pruebas'
			// var_dump($matrizItems[$i][0]);
			if ($matrizAnteproyectos [$i] [0] == 'Coordinador') {
				$coordinador = true;
			}
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
		$matrizAnteproyectos = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$id = $_REQUEST ['anteproyecto'];
		$director = $matrizAnteproyectos [0] [8];
		$modalidad = $matrizAnteproyectos [0] [1];
		
		// Buscar nombre de la modalidad
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombreModalidad", $modalidad );
		$matrizNomModa = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$modalidadNom = $matrizNomModa [0] [1];
		
		// Buscar tem�ticas asociadas
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarTematicas", $_REQUEST ['anteproyecto'] );
		$matrizTematicas = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$codTematicas = array ();
		for($i = 0; $i < count ( $matrizTematicas ); $i ++) {
			array_push ( $codTematicas, $matrizTematicas [$i] [0] );
		}
		
		// Buscar nombres de las tem�ticas
		$nomTematicas = array ();
		for($i = 0; $i < count ( $codTematicas ); $i ++) {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombresTematicas", $codTematicas [$i] );
			$matrizNomTematicas = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			array_push ( $nomTematicas, $matrizNomTematicas [0] [0] );
		}
		
		// Buscar estudiantes asociados
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAutores", $_REQUEST ['anteproyecto'] );
		$matrizAutores = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$cod = array ();
		for($i = 0; $i < count ( $matrizAutores ); $i ++) {
			array_push ( $cod, $matrizAutores [$i] [0] );
		}
		
		// Buscar nombre de director
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombresDirector", $director );
		$matrizDirector = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		$director = $matrizDirector [0] [1];
		
		// Buscar nombres de los estudiantes
		$autores = array ();
		for($i = 0; $i < count ( $cod ); $i ++) {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNombresAutores", $cod [$i] );
			$matrizItems4 = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			array_push ( $autores, $matrizItems4 [0] [1] );
		}
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarVersiones" );
		$matrizVersiones = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarRevisor" );
		$matrizRevisor = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultaRespuesta", $id );
		$matrizRespuesta = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		?>
<div class="canvas-contenido">

	<h1>Anteproyecto No. <?php echo $id?></h1>

	<div id="izq">

		<h3>Información General</h3>

		<table id="documento" class="table">
			<tr>
				<td id="col" rowspan="7">
					<div class="corner bg-imagen-documento">
						<div id="documento" class="icon-max-pdf"></div>
						<div class="codigo-documento">Versión No.1</div>
					</div>
				</td>
				<td class="table-tittle estilo_tr">Titulo</td>
				<td class="estilo_tr"><p><?php echo $matrizAnteproyectos[0][3]?></p></td>
			</tr>

			<tr>
				<td class="table-tittle estilo_tr">Modalidad de Grado</td>
				<td class="estilo_tr"><p><?php echo $modalidadNom?></p></td>
			</tr>

			<tr>
				<td class="table-tittle estilo_tr">Temáticas de Interés</td>
				<td class="estilo_tr"><p><?php
		for($i = 0; $i < count ( $nomTematicas ); $i ++) {
			echo $nomTematicas [$i]?><br></br> <?php
			
			;
		}
		?></p></td>
			</tr>

			<tr>
				<td class="table-tittle estilo_tr">Estado</td>
				<td class="estilo_tr"><p><?php echo $matrizAnteproyectos[0][7]?></p></td>
			</tr>

		</table>
		<br>

		<h3>Autores y Directores</h3>

		<table class="table">
			<tr>
				<td class="table-tittle estilo_tr">Autores</td>
				<td class="estilo_tr"><p><?php
		for($i = 0; $i < count ( $autores ); $i ++) {
			echo $autores [$i]?><br></br> <?php
			
			;
		}
		?></p></td>
			</tr>

			<tr>
				<td class="table-tittle estilo_tr">Directores Internos</td>
				<td class="estilo_tr"><p><?php echo $director?></p></td>
			</tr>

		</table>

		<br>
		<h3>Documentos Anexos</h3>
		<table id="documento" class="table">
			<tr>
				<td id="col">
					<div class="corner bg-imagen-documento">
						<div id="documento" class="docs-anexos-icon"></div>
						<div class="codigo-documento">Anexos</div>
					</div>
				</td>
				<td class="estilo_tr">Documentacion anexa</td>
			</tr>

		</table>
		<br>
		
		<?php
		
		if ($matrizAnteproyectos [0] [7] == 'PROYECTO') {
			
			// ------------------Division para los botones-------------------------
			$atributos ["id"] = "botones";
			$atributos ["estilo"] = "marcoBotones";
			echo $this->miFormulario->division ( "inicio", $atributos );
			
			// -----------------CONTROL: Botón ----------------------------------------------------------------
			$esteCampo = 'botonIniciar';
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
			
			// -----------------CONTROL: Botón ----------------------------------------------------------------
			$esteCampo = 'botonHistorico';
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
		}
		?>
<!-- 		<button type="button" id="btn3">Iniciar proyecto</button> -->
		<!-- 		<button type="button" id="btn4">Historico anteproyecto</button> -->
	</div>

	<div id="der">
		<div id="versiones">
			<h3>Versiones del Documento</h3>
			<p class="idnt">A continucion encontraras las ultimas versiones del
				documento que se hayan cargado al sistema. Para cargar el documento
				por favor seleccione la version que desea descargar.</p>
			<table id="vers" class="table">
				<tr>
					<td class="estilo_tr tit" colspan="4">Version actual: Version No. <?php echo count($matrizVersiones);?></td>
				</tr>
				<tr>
					<td class="table-tittle estilo_tr" colspan="2">Version</td>
					<td class="table-tittle estilo_tr">Nombre del documento</td>
					<td class="table-tittle estilo_tr">Fecha de subida</td>
				</tr>
				<?php
		for($i = 0; $i < count ( $matrizVersiones ); $i ++) {
			?>
				<tr>
					<td class="estilo_tr">
						<div class="corner bg-imagen-documento">
							<div id="documento" class="icon-mini-archivo"></div>
							<div class="codigo-documento"></div>
						</div>
					</td>
					<td class="estilo_tr">
						<?php
			
			if (strlen ( $matrizVersiones [$i] [0] ) < 10) {
				echo $matrizVersiones [$i] [0];
			} else {
				echo substr ( $matrizVersiones [$i] [0], 10 ) . "...";
			}
			?>
					</td>
					<td class="estilo_tr">
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
					<td class="estilo_tr">
						<?php
			echo $matrizVersiones [$i] [3];
			?>
				</td>
				</tr>
				<?php
		}
		?>
			</table>
			<br>
		</div>

		<!-- 		<div id="separador"> -->
		<!-- 			<br>____<br> -->
		<!-- 		</div> -->

		
		
		<?php
		if ($matrizRevisor) {
			?>
			<div id="revisores">
			<h3>Solicitudes de Asignacion de Revisor</h3>
			<p class="idnt">A continucion encontrara un resumen de las
				solicitudes creadas.</p>
			<table id="vers" class="table">
				<tr>
					<td class="estilo_tr tit" colspan="4">Solicitudes de asignacion de
						revision</td>
				</tr>
				<tr>
					<td class="table-tittle estilo_tr" colspan="2">Fecha solicitud</td>
					<td class="table-tittle estilo_tr">Docente asignado</td>
					<td class="table-tittle estilo_tr">Estado</td>
				</tr>
				<?php
			for($i = 0; $i < count ( $matrizRevisor ); $i ++) {
				?>
				<tr>
					<td class="estilo_tr">
						<div class="corner bg-imagen-documento">
							<div id="documento" class="icon-mini-people"></div>
						</div>
					</td>
					<td class="estilo_tr">
						<?php echo $matrizRevisor[$i][0];?>
					</td>
					<td class="estilo_tr">
						<?php echo $matrizRevisor [$i] [1];?>
					</td>
					<td class="estilo_tr">
						<?php echo "ACEPTADO"?>
					</td>
				</tr>
				<?php
			}
			?>
			
			
			</table>
			<br>
		</div>
		<?php
		} else {
			?>
		<div id="revisores">
			<h3>Solicitudes de Asignacion de Revisor</h3>
			<p class="idnt2">
				Aun no exiten solicitudes de asignacion de revision indicadas por el
				programa curricular. <br> <strong>NOTA: </strong> Una vez el
				programa curricular inicie las solicitudes, los revisroes tendran un
				plazo maximo de 10 dias calendario para dar respuesta a la solicitud
			</p>

		</div>
			
		<?php
		}
		?>
	
<!-- 	<div id="separador"> -->
		<!-- 			<br>______<br> -->
		<!-- 		</div> -->

	<?php
		$fecini = substr ( $matrizRevisor [0] [0], 8 );
		$fecact = getdate ();
		
		if ($matrizRespuesta) {
			?>
			<div id="proceso">
			<h3>Proceso de revision (<?php echo count ( $matrizRespuesta );?>/3)</h3>
			<p class="idnt">
				Responsable: <strong>Revisores</strong>
					Dias restantes <?php echo  ($fecini - $fecact['mday']) + 20;?>/20
				
			</p>
			<table id="proc" class="table">
				<tr>
					<td class="estilo_tr tit" colspan="5">Solicitudes de asignacion de
						revision</td>
				</tr>
				<tr>
					<td class="table-tittle estilo_tr" colspan="2">Revisor</td>
					<td class="table-tittle estilo_tr">Fecha solicitud</td>
					<td class="table-tittle estilo_tr">Concepto respuesta</td>
					<td class="table-tittle estilo_tr">Fecha respuesta</td>
				</tr>
				<?php
			// var_dump($matrizRespuesta);
			for($i = 0; $i < count ( $matrizRespuesta ); $i ++) {
				?>
				<tr>
					<td class="estilo_tr">
						<div class="corner bg-imagen-documento">
							<div id="documento" class="icon-mini-people"></div>
						</div>
					</td>
					<td class="estilo_tr">
						<?php echo $matrizRespuesta[$i][3];?>
					</td>
					<td class="estilo_tr">
						<?php echo $matrizRespuesta [$i] [4];?>
					</td>
					<td class="estilo_tr">
						<?php echo $matrizRespuesta [$i] [2];?>
					</td>
					<td class="estilo_tr">
						<?php echo $matrizRespuesta [$i] [0];?>
					</td>
				</tr>
				<?php
			}
			?>
			
			
			</table>
			<br>

		</div>
		<?php
		} else {
			?>
		<div id="proceso">
			<h3>Proceso de revision</h3>
			<p class="idnt2">
				Aun no exiten procesos de evaluacion iniciados. Para iniciar un
				proceso de evalucacion es indispensable que solicite revision de la
				ultima version del documento del anteproyecto. <br> <strong>NOTA: </strong>
				Una vez el programa curricular inicie las solicitudes, los revisroes
				tendran un plazo maximo de 10 dias calendario para dar respuesta a
				la solicitud
			</p>
		
		</div>
			
		<?php
		}
		
		$modi = false;
		foreach ( $matrizRespuesta as $clave => $valor ) {
			if ($valor [2] == "MODIFICABLE") {
				$modi = true;
			}
		}
		
		?>
		
<!-- 		<div id="separador"> -->
		<!-- 			<br>______<br> -->
		<!-- 		</div> -->
		
		<?php
		if (! $modi) {
			?>
		
		<div id="modif">
			<h3>Solicitud de modificacion</h3>
			<p class="idnt2">
				No existen procesos de moficiacion pendientes. Es indispensable que
				todos procesos de revision finalizen para determinar si es necesario
				realizar modificaciones al documento. <br> <strong>NOTA: </strong>
				Una vez exista una solicitud de modificacion, los estudiantes
				tendran un plazo maximo de 25 dias calendario para dar modificar el
				documento y solicitar nuevamente la revision por parte de los
				revisores.
			</p>

		</div>
		<?php
		} else {
			?>
		<div id="modif">
			<h3>Solicitud de modificacion</h3>
			<p class="idnt">A continuacion se observa la modificacion requerida
				por el revisor:</p>
			<table id="proc" class="table">
				<tr>
					<td class="estilo_tr tit" colspan="5">Solicitudes de modificacion de
						revision</td>
				</tr>
				<tr>
					<td class="table-tittle estilo_tr" colspan="2">Revisor</td>
					<td class="table-tittle estilo_tr">Fecha solicitud</td>
					<td class="table-tittle estilo_tr">Concepto respuesta</td>
					<td class="table-tittle estilo_tr">Fecha respuesta</td>
				</tr>
				<?php
			// var_dump($matrizRespuesta);
			for($i = 0; $i < count ( $matrizRespuesta ); $i ++) {
				if ($matrizRespuesta[$i][2] == "MODIFICABLE") {
				?>
				<tr>
					<td class="estilo_tr">
						<div class="corner bg-imagen-documento">
							<div id="documento" class="icon-mini-people"></div>
						</div>
					</td>
					<td class="estilo_tr">
						<?php echo $matrizRespuesta [$i] [3];?>
					</td>
					<td class="estilo_tr">
						<?php echo $matrizRespuesta [$i] [4];?>
					</td>
					<td class="estilo_tr">
						<?php echo $matrizRespuesta [$i] [2];?>
					</td>
					<td class="estilo_tr">
						<?php echo $matrizRespuesta [$i] [0];?>
					</td>
				</tr>
				<?php
				}
			}
			?>
			
			
			</table>
			<br>
		</div>
		<?php
		}
		?>
			</div>
</div>

<?php
		// /////////////////////
		// echo $this->miFormulario->tablaReporte ( $matrizItems );
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botones";
		$atributos ["estilo"] = "marcoBotones";
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		if (! $matrizRevisor) {
			// -----------------CONTROL: Bot�n ----------------------------------------------------------------
			$esteCampo = 'botonA';
			$atributos ["id"] = $esteCampo;
			$atributos ["tabIndex"] = $tab;
			$atributos ["tipo"] = 'boton';
			// submit: no se coloca si se desea un tipo button gen�rico
			$atributos ['submit'] = true;
			$atributos ["estiloMarco"] = '';
			$atributos ["estiloBoton"] = 'jqueryui';
			// verificar: true para verificar el formulario antes de pasarlo al servidor.
			$atributos ["verificar"] = '';
			$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la funci�n submit declarada en ready.js
			$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
			$tab ++;
			
			// Aplica atributos globales al control
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoBoton ( $atributos );
			// -----------------FIN CONTROL: Bot�n -----------------------------------------------------------
		}
		// -----------------CONTROL: Bot�n ----------------------------------------------------------------
		$esteCampo = 'botonH';
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab;
		$atributos ["tipo"] = 'boton';
		// submit: no se coloca si se desea un tipo button gen�rico
		$atributos ['submit'] = true;
		$atributos ["estiloMarco"] = '';
		$atributos ["estiloBoton"] = 'jqueryui';
		// verificar: true para verificar el formulario antes de pasarlo al servidor.
		$atributos ["verificar"] = '';
		$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la funci�n submit declarada en ready.js
		$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoBoton ( $atributos );
		// -----------------FIN CONTROL: Bot�n -----------------------------------------------------------
		
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
		
		// $valorCodificado = "action=" . $esteBloque ["nombre"]; // Ir pagina Funcionalidad
		$valorCodificado = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' ); // Frontera mostrar formulario
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
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