<?php

namespace bloquesModelo\crearProgramaCurricular\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class redireccion {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		$miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		switch ($opcion) {
			
			case "inserto" :
// 				var_dump($opcion);
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=confirma";
				$variable .= "&delegado=" . $valor;
				break;
			
			case "noInserto" :
// 				var_dump($opcion);
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=error";
				break;
			
			default :
				$variable = '';
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		
		$enlace = $miConfigurador->configuracion ['enlace'];
		//var_dump($variable);
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		
		
		return true;
	}
}
?>