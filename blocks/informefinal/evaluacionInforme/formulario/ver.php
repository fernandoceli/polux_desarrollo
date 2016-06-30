<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
/**
 * Este script estÃ¡ incluido en el mÃ©todo html de la clase Frontera.class.php.
 *
 * La ruta absoluta del bloque estÃ¡ definida en $this->ruta
 */

$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$nombreFormulario = $esteBloque ["nombre"];

include_once ("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton ();
$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];

$valorCodificado = $cripto->codificar ( $valorCodificado );
//$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" ) . "/icons/";

// ------------------Division para las pestaÃ±as-------------------------
$atributos ["id"] = "tabs";
$atributos ["estilo"] = "";
echo $this->miFormulario->division ( "inicio", $atributos );
unset ( $atributos );
{
	// -------------------- Listado de Pestañas (Como lista No Ordenada) -------------------------------
	
	$items = array (
			"tab1" => $this->lenguaje->getCadena ( "tab1" ),
			"tab2" => $this->lenguaje->getCadena ( "tab2" ),
			"tab3" => $this->lenguaje->getCadena ( "tab3" ),
			"tab4" => $this->lenguaje->getCadena ( "tab4" )
	);
	
	$atributos ["items"] = $items;
	$atributos ["estilo"] = "";
	$atributos ["pestaÃ±as"] = "true";
	echo $this->miFormulario->listaNoOrdenada ( $atributos );
	
	
	// ------------------Division para la pestaña 1-------------------------
	$esteCampo = "tab1";
	$atributos ["id"] = $esteCampo;
	$atributos ["estilo"] = "jqueryui";
	$atributos ['tipoEtiqueta'] = 'inicio';
	$atributos ['titulo'] = 'titulo prueba';
	echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
	
	{
		include ($this->ruta . "formulario/tabs/form1.php");
		// -----------------Fin Division para la pestaña 1-------------------------
	}
	echo $this->miFormulario->agrupacion ( 'fin' );
	unset ( $atributos );
	
	// ------------------Division para la pestaña 2-------------------------
	$esteCampo = "tab2";
	$atributos ['id'] = $esteCampo;
	$atributos ["estilo"] = "jqueryui";
	$atributos ['tipoEtiqueta'] = 'inicio';
	echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
	
	{
		include ($this->ruta . "formulario/tabs/form2.php");
	}
	echo $this->miFormulario->agrupacion ( 'fin' );
	unset ( $atributos );
	
	// ------------------Division para la pestaña 3-------------------------
	$esteCampo = "tab3";
	$atributos ['id'] = $esteCampo;
	$atributos ["estilo"] = "jqueryui";
	$atributos ['tipoEtiqueta'] = 'inicio';
	echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
	
	{
		include ($this->ruta . "formulario/tabs/form3.php");
	}
	echo $this->miFormulario->agrupacion ( 'fin' );
	unset ( $atributos );
	
	// ------------------Division para la pestaña 4-------------------------
	$esteCampo = "tab4";
	$atributos ['id'] = $esteCampo;
	$atributos ["estilo"] = "jqueryui";
	$atributos ['tipoEtiqueta'] = 'inicio';
	echo $this->miFormulario->agrupacion ( 'inicio', $atributos );
	
	{
		include ($this->ruta . "formulario/tabs/form4.php");
	}
	echo $this->miFormulario->agrupacion ( 'fin' );
	unset ( $atributos );
}

echo $this->miFormulario->division ( "fin" );

?>

