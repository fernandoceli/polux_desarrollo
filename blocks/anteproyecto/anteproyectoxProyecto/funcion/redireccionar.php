<?php

namespace anteproyecto\anteproyectoxProyecto\funcion;

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
			
			case "opcion1" :
				$variable = 'pagina=segundaPagina';
				$variable .= '&variable' . $valor;
				break;
			
			case "ver" :
				$variable = 'pagina=verAnteproyecto';
				$variable .= '&usuario=' . $valor['usuario'];
				$variable .= '&ante=' . $valor['ante'];
				break;
			
			case "irinicio":
				$variable = 'pagina=indexPolux';
				$variable .= '&usuario=' . $valor['usuario'];
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
		//var_dump ( $variable );
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		//var_dump($_REQUEST);
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
// 		echo "entro";
		return true;
	}
}
?>