<?php

namespace proyecto\consultaProyecto\funcion;

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
				$variable .= "&programaCurricular=" . $valor;
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "insertoDocumento" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=confirma2";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
				
				case "insertoSolicitud" :
					$variable = "pagina=" . $miPaginaActual;
					$variable .= "&opcion=mensaje";
					$variable .= "&mensaje=confirmaSolicitud";
					$variable .= "&usuario=" . $_REQUEST ['usuario'];
					break;
			
			case "noInserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=error";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "noInsertoDocumento" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=error2";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
				
				case "noInsertoSolicitud" :
					$variable = "pagina=" . $miPaginaActual;
					$variable .= "&opcion=mensaje";
					$variable .= "&mensaje=errorSolicitud";
					$variable .= "&usuario=" . $_REQUEST ['usuario'];
					break;
			
			case "iniciar" :
				$variable = "pagina=iniciarInformeFinal";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&proyecto=" . $_REQUEST ['id'];
				if (isset ( $_REQUEST ['estudiante'] )) {
					$variable .= "&estudiante=" . $_REQUEST ['estudiante'];
				}
				$variable .= "&rol=" . $_REQUEST ['rol'];
				break;
			
			case "continuar" :
				$variable = "pagina=indexPolux";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "principal" :
				$variable = "pagina=indexPolux";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
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