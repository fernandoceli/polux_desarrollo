<?php

namespace anteproyecto\consultaAnteproyecto\funcion;

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
				break;
			
			case "noInserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=error";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "iniciar" :
				$variable = "pagina=iniciarProyecto";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&anteproyecto=" . $_REQUEST ['id'];
				if (isset ( $_REQUEST ['estudiante'] )) {
					$variable .= "&estudiante=" . $_REQUEST ['estudiante'];
				}
				$variable .= "&rol=" . $_REQUEST ['rol'];
				break;
			
			case "insertoDocumento" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=confirmaVersion";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&anteproyecto=" . $_REQUEST ['anteproyecto'];
				break;
			
			case "noInsertoDocumento" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=errorVersion";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "insertoSolicitud" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=confirmaSolicitud";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				$variable .= "&anteproyecto=" . $_REQUEST ['anteproyecto'];
				break;
			
			case "noInsertoSolicitud" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=errorSolicitud";
				$variable .= "&usuario=" . $_REQUEST ['usuario'];
				break;
			
			case "regresar" :
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

		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		
		return true;
	}
}
?>