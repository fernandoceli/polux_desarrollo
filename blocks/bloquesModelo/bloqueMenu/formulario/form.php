<?php

namespace bloquesModelo\bloqueMenu\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

$rutaPrincipal = $this->miConfigurador->getVariableConfiguracion ( 'host' ) . $this->miConfigurador->getVariableConfiguracion ( 'site' );

$indice = $rutaPrincipal . "/index.php?";

$directorio = $rutaPrincipal . '/' . $this->miConfigurador->getVariableConfiguracion ( 'bloques' ) . "/menu_principal/imagen/";

$urlBloque = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' );

$enlace = $this->miConfigurador->getVariableConfiguracion ( 'enlace' );

?><hr></hr>

<style type="text/css">
* {
	margin: 0px;
	padding: 0px;
}

#header {
	margin: auto;
	width: 100%;
	font-family: Arial, Helvetica, sans-serif;
}

ul, ol {
	list-style: none;
}

.nav>li {
	float: left;
}

.nav li a {
	background-color: #000;
	color: #fff;
	text-decoration: none;
	padding: 10px 12px;
	display: block;
	z-index: 100;
}

.nav li a:hover {
	background-color: #434343;
	z-index: 100;
}

.nav li ul {
	display: none;
	position: absolute;
	min-width: 140px;
	z-index: 100;
}

.nav li:hover>ul {
	display: block;
	z-index: 100;
}

.nav li ul li {
	position: relative;
	z-index: 100;
}

.nav li ul li ul {
	right: -140px;
	top: 0px;
	z-index: 100;
}
</style>

<div id="header">
	<ul class="nav">
		<li><a href="">Facultades</a>

<?php
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$esteCampo = 'crearFacultad';
$item = $esteCampo;
$items [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=inicio';
$enlace .= '';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$esteCampo = 'crearDelegado';
$item = $esteCampo;
$items [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=crearDelegado ';
$enlace .= '';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

// Atributos generales para la lista
$atributos ['id'] = 'menu';
$atributos ['estilo'] = 'jqueryui';
$atributos ["enlaces"] = true;
$atributos ['items'] = $items;
$atributos ['menu'] = true;

echo $this->miFormulario->listaNoOrdenada ( $atributos );
?>
			
		</li>
		<li><a href="">Programas Curriculares</a>
<?php
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$esteCampo = 'crearProgramaCurricular';
$item = $esteCampo;
$items2 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items2 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items2 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=crearProgramaCurricular';
$enlace .= '';
$items2 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

// Atributos generales para la lista
$atributos ['id'] = 'menu';
$atributos ['estilo'] = 'jqueryui';
$atributos ["enlaces"] = true;
$atributos ['items'] = $items2;
$atributos ['menu'] = true;

echo $this->miFormulario->listaNoOrdenada ( $atributos );
?>
		</li>
		<li><a href="">Estudiantes</a>
<?php
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$esteCampo = 'crearEstudiante';
$item = $esteCampo;
$items3 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items3 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items3 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=crearEstudiante';
$enlace .= '';
$items3 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

// Atributos generales para la lista
$atributos ['id'] = 'menu';
$atributos ['estilo'] = 'jqueryui';
$atributos ["enlaces"] = true;
$atributos ['items'] = $items3;
$atributos ['menu'] = true;

echo $this->miFormulario->listaNoOrdenada ( $atributos );
?>
		</li>
		<li><a href="">Profesores</a>
<?php
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$esteCampo = 'crearDocente';
$item = $esteCampo;
$items4 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items4 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items4 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=crearDocente';
$enlace .= '';
$items4 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$esteCampo = 'asignarTematica';
$item = $esteCampo;
$items4 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items4 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items4 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=asignarTematica';
$enlace .= '';
$items4 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

// Atributos generales para la lista
$atributos ['id'] = 'menu';
$atributos ['estilo'] = 'jqueryui';
$atributos ["enlaces"] = true;
$atributos ['items'] = $items4;
$atributos ['menu'] = true;

echo $this->miFormulario->listaNoOrdenada ( $atributos );
?>
		</li>
		<li><a href="">Tem&aacuteticas de inter&eacutes</a>
<?php
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$esteCampo = 'crearTematicasInteres';
$item = $esteCampo;
$items5 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items5 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items5 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=crearTematicaInteres';
$enlace .= '';
$items5 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

// Atributos generales para la lista
$atributos ['id'] = 'menu';
$atributos ['estilo'] = 'jqueryui';
$atributos ["enlaces"] = true;
$atributos ['items'] = $items5;
$atributos ['menu'] = true;

echo $this->miFormulario->listaNoOrdenada ( $atributos );
?>
		</li>
		<li><a href="">Secretaria academicas</a>
<?php
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$esteCampo = 'crearSecretaria';
$item = $esteCampo;
$items6 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items6 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items6 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=crearSecretaria';
$enlace .= '';
$items6 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$esteCampo = 'crearDelegadoSecretaria';
$item = $esteCampo;
$items6 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items6 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items6 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=crearDelegadoSecretaria';
$enlace .= '';
$items6 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

// Atributos generales para la lista
$atributos ['id'] = 'menu';
$atributos ['estilo'] = 'jqueryui';
$atributos ["enlaces"] = true;
$atributos ['items'] = $items6;
$atributos ['menu'] = true;

echo $this->miFormulario->listaNoOrdenada ( $atributos );
?>
		</li>
		<li><a href="">Anteproyectos</a>
<?php
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$esteCampo = 'registrarAnteproyecto';
$item = $esteCampo;
$items7 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items7 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items7 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=registrarAnteproyecto';
$enlace .= '';
$items7 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$esteCampo = 'anteproyectoSin';
$item = $esteCampo;
$items7 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items7 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items7 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=anteproyectoSin';
$enlace .= '';
$items7 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$esteCampo = 'anteproyectoxProyecto';
$item = $esteCampo;
$items7 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items7 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items7 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=anteproyectoxProyecto';
$enlace .= '';
$items7 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$esteCampo = 'anteproyectoAsignadoRevision';
$item = $esteCampo;
$items7 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items7 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items7 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=anteproyectoAsignadoRevision';
$enlace .= '';
$items7 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$esteCampo = 'solRevAnteproyecto';
$item = $esteCampo;
$items7 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items7 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items7 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=solRevAnteproyecto';
$enlace .= '';
$items7 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

$esteCampo = 'anteDirigidos';
$item = $esteCampo;
$items7 [$item] ['nombre'] = $this->lenguaje->getCadena ( $esteCampo );
$items7 [$item] ['enlace'] = true; // El li es un enlace directo, dejar false si existe submenus
$items7 [$item] ['icono'] = ''; // El li es un enlace directo
$enlace = 'pagina=anteDirigidos';
$enlace .= '';
$items7 [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );

// Atributos generales para la lista
$atributos ['id'] = 'menu';
$atributos ['estilo'] = 'jqueryui';
$atributos ["enlaces"] = true;
$atributos ['items'] = $items7;
$atributos ['menu'] = true;

echo $this->miFormulario->listaNoOrdenada ( $atributos );
?>
		</li>
	</ul>
</div>