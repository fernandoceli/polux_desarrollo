<?php

namespace bloquesModelo\informesFinalesSinJurados\funcion;

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
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=confirma";
				// $variable .= "&facultad=" . $valor;
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "noInserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=error";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "devolver" :
				$variable = "pagina=" . 'bienvenida';
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "ver" :
				$variable = 'pagina=verInformeFinal';
				$variable .= '&usuario=' . $valor ['usuario'];
				$variable .= '&informe=' . $valor ['id'];
				
				break;
			
			case "irinicio" :
				$variable = 'pagina=indexPolux';
				$variable .= '&usuario=' . $valor ['usuario'];
				break;
			
			default :
				$variable = '';
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		
		$enlace = $miConfigurador->configuracion ['enlace'];
		// var_dump($variable);
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		
		return true;
	}
}
?>