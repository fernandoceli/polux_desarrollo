<?php

namespace proyecto\iniciarProyecto\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class redireccion {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		$miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		echo "Cargando...";
		
		switch ($opcion) {
			
			case "inserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=confirma";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&anteproyecto=" . $_REQUEST ['anteproyecto'];
				$variable .= "&proyecto=" . $_REQUEST ['proyecto'];
				break;
			
			case "noInserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=error";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&anteproyecto=" . $_REQUEST ['anteproyecto'];
				break;
			
			case 'bienvenida':
				$variable = "pagina=indexPolux";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			default :
				$variable = 'pagina=bienvenida';
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		
		$enlace = $miConfigurador->configuracion ['enlace'];
		// var_dump ( $variable );
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		return true;
	}
}
?>