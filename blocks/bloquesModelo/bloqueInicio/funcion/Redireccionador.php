<?php

namespace bloquesModelo\bloqueInicio\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		$miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		switch ($opcion) {
			
			case "index" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= '&variable' . $valor;
				break;
			
			case "bienvenida" :
				$variable = 'pagina=bienvenida';
				$variable .= '&variable=' . $valor;
				break;
			
			default :
				$variable = '';
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		$enlace = $miConfigurador->getVariableConfiguracion ( "enlace" );
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		
		$_REQUEST [$enlace] = $variable;
		$_REQUEST ["recargar"] = true;
		
// 		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
// 		$enlace = $miConfigurador->configuracion ['enlace'];
// 		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
// 		$_REQUEST [$enlace] = $enlace . '=' . $variable;
// 		$redireccion = $url . $_REQUEST [$enlace];
		
// 		echo "<script>location.replace('" . $redireccion . "')</script>";
		
		return true;
	}
}
?>