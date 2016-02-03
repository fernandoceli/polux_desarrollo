<?php

namespace bloquesModelo\solRevAnteproyecto\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class redireccion {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		$miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		switch ($opcion) {
			
			case "opcion1" :
				
				$variable = 'pagina=segundaPagina';
				$variable .= '&variable' . $valor;
				break;
			
			case "evaluar" :
				
				$variable = 'pagina=evaluacionAnteproyecto';
				$variable .= '&usuario=' . $valor['usuario'];
				$variable .= '&ante=' . $valor['ante'];
				$variable .= "&solicitud=" . $_REQUEST ['solicitud'];
				break;
			
			default :
				$variable = '';
				break;
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		
		$enlace = $miConfigurador->configuracion ['enlace'];
		var_dump ( $variable );
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		var_dump($_REQUEST);
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
// 		echo "entro";
		return true;
	}
}
?>