<?php

namespace bloquesModelo\crearEstudiante\funcion;

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
				$variable .= "&identificacion=" . $valor ['identificacion'];
				$variable .= "&nombres=" . $valor ['nombres'];
				$variable .= "&apellidos=" . $valor ['apellidos'];
				$variable .= "&correo=" . $valor ['correo'];
				$variable .= "&telefono=" . $valor ['telefono'];
				$variable .= "&perfilUs=" . $valor ['perfilUs'];
				$variable .= "&password=" . $valor ['pass'];
				$variable .= "&id_usuario=" . $valor ['id_usuario'];
				break;
			
			case "noInserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=error";
				if ($valor != "") {
					$variable .= "&identificacion=" . $valor ['identificacion'];
					$variable .= "&nombres=" . $valor ['nombres'];
					$variable .= "&apellidos=" . $valor ['apellidos'];
					$variable .= "&correo=" . $valor ['correo'];
					$variable .= "&telefono=" . $valor ['telefono'];
					$variable .= "&password=" . $valor ['password'];
				}
				break;
			
			case "existe" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=existe";
				if ($valor != "") {
					$variable .= "&identificacion=" . $valor ['identificacion'];
					$variable .= "&nombres=" . $valor ['nombres'];
					$variable .= "&apellidos=" . $valor ['apellidos'];
					$variable .= "&correo=" . $valor ['correo'];
					$variable .= "&telefono=" . $valor ['telefono'];
					$variable .= "&password=" . $valor ['password'];
				}
				break;
			
			case "existeLog" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=existeLog";
				if ($valor != "") {
					$variable .= "&id_usuario=" . $valor ['id_usuario'];
					$variable .= "&identificacion=" . $valor ['identificacion'];
					$variable .= "&nombres=" . $valor ['nombre'];
					$variable .= "&apellidos=" . $valor ['apellido'];
				}
				break;
			
			default :
				$variable = '';
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
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		
		return true;
	}
}
?>