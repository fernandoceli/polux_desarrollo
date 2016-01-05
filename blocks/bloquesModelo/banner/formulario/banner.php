<?php

namespace bloquesModelo\banner\formulario;

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );

$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];

$esteCampo = $esteBloque ['nombre'];
$atributos ['id'] = $esteCampo;
$atributos ['nombre'] = $esteCampo;

// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
$atributos ['tipoFormulario'] = 'multipart/form-data';

// Si no se coloca, entonces toma el valor predeterminado 'POST'
$atributos ['metodo'] = 'POST';

// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
$atributos ['action'] = 'index.php';
$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );

// Si no se coloca, entonces toma el valor predeterminado.
$atributos ["estilo"] = "animated fadeInDown";
$atributos ['marco'] = true;
$tab = 1;

$atributos ["id"] = "banner";
echo $this->miFormulario->division ( "inicio", $atributos );
unset ( $atributos );

$atributos ["id"] = "bannerImagen";
echo $this->miFormulario->division ( "inicio", $atributos );
unset ( $atributos );

// ---------------- CONTROL: Imagen --------------------------------------------------------
$esteCampo = 'bannerSuperior';
$atributos ['id'] = $esteCampo;
$atributos ['nombre'] = $esteCampo;
$atributos ['estiloMarco'] = '';
$atributos ["imagen"] = $rutaBloque . "/imagen/polux-titulo.png";
$atributos ['alto'] = 120;
$atributos ['ancho'] = 350;
$atributos ["borde"] = 0;
$atributos ['tabIndex'] = $tab ++;
echo $this->miFormulario->campoImagen ( $atributos );
unset ( $atributos );

// Aplica atributos globales al control

// --------------------FIN CONTROL: Imagen--------------------------------------------------------

echo $this->miFormulario->division ( "fin" );

// --------------------FIN CONTROL: Imagen--------------------------------------------------------
$atributos ["id"] = "Datos";
echo $this->miFormulario->division ( "inicio", $atributos );
unset ( $atributos );

// ---------------- CONTROL: Campo de Texto Funcionario--------------------------------------------------------

$esteCampo = 'campoUsuario';
$atributos ["id"] = $esteCampo;
$atributos ["estilo"] = $esteCampo;
$atributos ['columnas'] = 1;
$atributos ["estilo"] = $esteCampo;
$atributos ['texto'] = "Proyectos de Grado y Rendimiento Academico"; // Aqui se deberealizar la consulta para mostrar el usuario del sistema.
$atributos ['tabIndex'] = $tab ++;
echo $this->miFormulario->campoTexto ( $atributos );
unset ( $atributos );

// --------------------FIN CONTROL: Campo de Texto Funcionario--------------------------------------------------------

echo $this->miFormulario->division ( "fin" );
echo $this->miFormulario->division ( "fin" );
?>