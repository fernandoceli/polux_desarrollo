<?php

namespace bloquesModelo\iniciarInformeFinal;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

/**
 * IMPORTANTE: Se recomienda que no se borren registros.
 * Utilizar mecanismos para - independiente del motor de bases de datos,
 * poder realizar rollbacks gestionados por el aplicativo.
 */
class Sql extends \Sql {
	var $miConfigurador;
	function getCadenaSql($tipo, $variable = '') {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			/**
			 * Clausulas especÃ­ficas
			 */
			case 'insertarRegistro' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'modulo,';
				$cadenaSql .= 'nivel,';
				$cadenaSql .= 'parametro';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
				$cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
				$cadenaSql .= ') ';
				break;
			
			case 'actualizarRegistro' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'modulo,';
				$cadenaSql .= 'nivel,';
				$cadenaSql .= 'parametro';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
				$cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
				$cadenaSql .= ') ';
				break;
			
			case 'buscarRegistro' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_pagina as PAGINA, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCRIPCION,';
				$cadenaSql .= 'modulo as MODULO,';
				$cadenaSql .= 'nivel as NIVEL,';
				$cadenaSql .= 'parametro as PARAMETRO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'nombre=\'' . $_REQUEST ['nombrePagina'] . '\' ';
				break;
			
			case 'borrarRegistro' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'modulo,';
				$cadenaSql .= 'nivel,';
				$cadenaSql .= 'parametro';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
				$cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
				$cadenaSql .= ') ';
				break;
			
			case 'buscarProyecto' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'proy_proy, ';
				$cadenaSql .= 'proy_titu, ';
				$cadenaSql .= 'proy_descri, ';
				$cadenaSql .= 'estproy_proy, ';
				$cadenaSql .= 'nombre || \' \' || apellido AS nombre, ';
				$cadenaSql .= 'dproy_vers, ';
				$cadenaSql .= 'proy_moda, ';
				$cadenaSql .= 'proy_pcur, ';
				$cadenaSql .= 'proy_dir_int, ';
				$cadenaSql .= 'acproy_acono ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tproy ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.pry_testpry ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'proy_proy=estproy_proy ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.pry_tdproy ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'dproy_dproy=proy_proy ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.ge_testd ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'estproy_estd=estd_estd ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'polux_usuario ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'estd_us=id_usuario ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.pry_tacproy ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'proy_proy=acproy_proy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'proy_proy=\'' . $variable . '\' ';
				echo $cadenaSql;
				break;
			
			case 'actualizarProyecto' :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "trabajosdegrado.pry_tproy ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "proy_eproy='INFORME FINAL' ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "proy_proy='" . $variable . "'; ";
				echo $cadenaSql;
				break;
			
			case 'guardarInformeFinal' :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.inf_tinfo ";
				$cadenaSql .= "( ";
				$cadenaSql .= "info_proy, ";
				$cadenaSql .= "info_moda, ";
				$cadenaSql .= "info_pcur, ";
				$cadenaSql .= "info_titu, ";
				$cadenaSql .= "info_fcrea, ";
				$cadenaSql .= "info_descri, ";
				$cadenaSql .= "info_obser, ";
				$cadenaSql .= "info_einfo, ";
				$cadenaSql .= "info_dir_int ";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "( ";
				$cadenaSql .= "'" . $variable ['proy'] . "', ";
				$cadenaSql .= "'" . $variable ['modalidad'] . "', ";
				$cadenaSql .= "'" . $variable ['programa'] . "', ";
				$cadenaSql .= "'" . $variable ['titulo'] . "', ";
				$cadenaSql .= "'" . $variable ['proy_fcrea'] . "', ";
				$cadenaSql .= "'" . $variable ['descripcion'] . "', ";
				$cadenaSql .= "'" . $variable ['comentario'] . "', ";
				$cadenaSql .= "'" . $variable ['estado'] . "', ";
				$cadenaSql .= "'" . $variable ['director'] . "'";
				$cadenaSql .= ") ";
				$cadenaSql .= "RETURNING info_info;";
				echo $cadenaSql;
				break;
			
			case 'registrarHistorial' :
				
				$cadenaSql = " INSERT INTO trabajosdegrado.inf_thinfo ( ";
				$cadenaSql .= "hinfo_info, hinfo_einfo, hinfo_fasig, ";
				$cadenaSql .= "hinfo_obser, hinfo_usua) ";
				$cadenaSql .= " VALUES (";
				// anteproyecto: buscar valor de la secuencia actual
				$cadenaSql .= '(SELECT ';
				$cadenaSql .= 'last_value ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado."INF_SINFO"), ';
				
				$cadenaSql .= "'" . $variable ['estado'] . "', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['observaciones'] . "', ";
				// Usuario que ha iniciado sesión
				$cadenaSql .= " '" . $variable ['usuario'] . "' ";
				$cadenaSql .= ") ";
				echo $cadenaSql;
				// var_dump ( $cadenaSql );
				break;
			
			case "registrarAnexo" :
				$hash = "funcion hash";
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.inf_tdain ( ";
				$cadenaSql .= "dain_info, ";
				$cadenaSql .= "dain_tdain, ";
				$cadenaSql .= "dain_falm, ";
				$cadenaSql .= "dain_usua, ";
				$cadenaSql .= "dain_url, ";
				$cadenaSql .= "dain_hash, ";
				$cadenaSql .= "dain_bytes, ";
				$cadenaSql .= "dain_nombre, ";
				$cadenaSql .= "dain_extension) ";
				$cadenaSql .= "VALUES ( ";
				$cadenaSql .= '(SELECT ';
				$cadenaSql .= 'last_value ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado."INF_SINFO"), ';
				$cadenaSql .= "'ACTA', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['usuario'] . "', ";
				$cadenaSql .= "'" . $variable ['destino'] . "', ";
				$cadenaSql .= "'" . $hash . "', ";
				$cadenaSql .= "'" . $variable ['tamano'] . "', ";
				$cadenaSql .= "'" . $variable ['nombre'] . "', ";
				$cadenaSql .= "'" . $variable ['tipo'] . "' ";
				$cadenaSql .= ") ";
				$cadenaSql .= "RETURNING dain_dain;";
				echo $cadenaSql;
				// var_dump ( $cadenaSql );
				break;
			
			case "registrarDocumento" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.inf_tdinfo ( ";
				$cadenaSql .= "dinfo_vers, ";
				$cadenaSql .= "dinfo_observ, ";
				$cadenaSql .= "dinfo_falm, ";
				$cadenaSql .= "dinfo_usua, ";
				$cadenaSql .= "dinfo_info, ";
				$cadenaSql .= "dinfo_url, ";
				$cadenaSql .= "dinfo_hash, ";
				$cadenaSql .= "dinfo_bytes, ";
				$cadenaSql .= "dinfo_nombre, ";
				$cadenaSql .= "dinfo_extension) ";
				$cadenaSql .= "VALUES ( ";
				$cadenaSql .= "" . $variable ['version'] . ", ";
				$cadenaSql .= "'" . $variable ['observacion'] . "', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['usuario'] . "', ";
				$cadenaSql .= "" . $variable ['informe'] . ", ";
				$cadenaSql .= "'" . $variable ['url'] . "', ";
				$cadenaSql .= "'" . $variable ['hash'] . "', ";
				$cadenaSql .= "'" . $variable ['bytes'] . "', ";
				$cadenaSql .= "'" . $variable ['nombre'] . "', ";
				$cadenaSql .= "'" . $variable ['extension'] . "' ";
				$cadenaSql .= ") ";
				var_dump ( $cadenaSql );
				break;
			
			case 'registrarEstudiantes' :
				// obtener codigos por separado
				$cadenaSql = "";
				
				for($i = 0; $i < count ( $variable ); $i ++) {
					$cadena = " INSERT INTO trabajosdegrado.inf_testinfo ( ";
					$cadena .= "estinfo_est, estinfo_info) ";
					$cadena .= " VALUES (" . $variable [$i] . ", ";
					// anteproyecto: buscar valor de la secuencia actual
					$cadena .= '(SELECT ';
					$cadena .= 'last_value ';
					$cadena .= 'FROM ';
					$cadena .= 'trabajosdegrado."INF_SINFO") ); ';
					$cadenaSql = $cadenaSql . $cadena;
					var_dump ( $cadenaSql );
				}
				
				break;
			
			case 'registrarTematicas' :
				$cadenaSql = "";
				
				for($i = 0; $i < count ( $variable ); $i ++) {
					
					$cadena = " INSERT INTO trabajosdegrado.inf_tacinfo ( ";
					$cadena .= "acinfo_acono, acinfo_info) ";
					$cadena .= " VALUES (" . $variable [$i] . ", ";
					// anteproyecto: buscar valor de la secuencia actual
					$cadena .= '(SELECT ';
					$cadena .= 'last_value ';
					$cadena .= 'FROM ';
					$cadena .= 'trabajosdegrado."INF_SINFO") ); ';
					$cadenaSql = $cadenaSql . $cadena;
				}
				var_dump ( $cadenaSql );
				break;
			
			case 'obtenerID' :
				$cadenaSql = 'SELECT last_value FROM trabajosdegrado."INF_SINFO"';
				break;
			
			case 'buscarDocumento' :
				$cadenaSql = 'SELECT * ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tdproy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dproy_dproy=\'' . $variable . '\' ';
				var_dump ( $cadenaSql );
				break;
		}
		
		return $cadenaSql;
	}
}
?>
