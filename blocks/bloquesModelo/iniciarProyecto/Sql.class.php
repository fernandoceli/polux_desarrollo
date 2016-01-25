<?php

namespace bloquesModelo\iniciarProyecto;

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
			 * Clausulas específicas
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
			
			case 'buscarAnteproyecto' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'antp_antp, ';
				$cadenaSql .= 'antp_titu, ';
				$cadenaSql .= 'antp_descri, ';
				$cadenaSql .= 'estantp_estd, ';
				$cadenaSql .= 'nombre || \' \' || apellido AS nombre, ';
				$cadenaSql .= 'dantp_vers, ';
				$cadenaSql .= 'antp_moda, ';
				$cadenaSql .= 'antp_pcur, ';
				$cadenaSql .= 'antp_dir_int ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tantp ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.ant_testantp ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'antp_antp=estantp_antp ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.ant_tdantp ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'dantp_antp=antp_antp ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.ge_testd ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'estantp_estd=estd_estd ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'polux_usuario ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'estd_us=id_usuario ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'antp_antp=\'' . $variable . '\' ';
				break;
				
			case 'actualizarAnteproyecto':
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "trabajosdegrado.ant_tantp ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "antp_eantp='PROYECTO' ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "antp_antp='" . $variable . "'";
				break;
				
			case 'guardarProyecto':
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.pry_tproy ";
				$cadenaSql .= "( ";
				$cadenaSql .= "proy_antp, ";
				$cadenaSql .= "proy_moda, ";
				$cadenaSql .= "proy_pcur, ";
				$cadenaSql .= "proy_titu, ";
				$cadenaSql .= "proy_fcrea, ";
				$cadenaSql .= "proy_descri, ";
				$cadenaSql .= "proy_obser, ";
				$cadenaSql .= "proy_eproy, ";
				$cadenaSql .= "proy_duracion";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "( ";
				$cadenaSql .= "'" . $variable['ante'] . "', ";
				$cadenaSql .= "'" . $variable['modalidad'] . "', ";
				$cadenaSql .= "'" . $variable['programa'] . "', ";
				$cadenaSql .= "'" . $variable['titulo'] . "', ";
				$cadenaSql .= "'" . $variable['proy_fcrea'] . "', ";
				$cadenaSql .= "'" . $variable['descripcion'] . "', ";
				$cadenaSql .= "'" . $variable['comentario'] . "', ";
				$cadenaSql .= "'" . $variable['estado'] . "', ";
				$cadenaSql .= "'" . $variable['duracion'] . "'";
				$cadenaSql .= ") ";
				$cadenaSql .= "RETURNING proy_proy;";
		}
		
		return $cadenaSql;
	}
}
?>
