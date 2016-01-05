<?php

namespace bloquesModelo\anteproyectoxEstudiante;

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
			
			case 'buscarEstudiante' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'pern_nomb || \' \' || pern_papell || \' \' || pern_sapell AS  Nombre ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_testd ';
				$cadenaSql .= 'JOIN trabajosdegrado.ge_tpern ';
				$cadenaSql .= 'ON estd_pern = pern_pern ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estd_estd=\'' . $variable . '\' ';
// 				echo $cadenaSql;
				break;
			
			case 'buscarAnteproyecto' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'antp_fradi, ';
				$cadenaSql .= 'antp_antp, ';
				$cadenaSql .= 'moda_nombre, ';
				$cadenaSql .= 'antp_titu, ';
				$cadenaSql .= 'antp_eantp ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_testantp ';
				$cadenaSql .= 'JOIN trabajosdegrado.ge_testd ';
				$cadenaSql .= 'ON estantp_estd = estd_estd ';
				$cadenaSql .= 'JOIN trabajosdegrado.ant_tantp ';
				$cadenaSql .= 'ON estantp_antp = antp_antp ';
				$cadenaSql .= 'JOIN trabajosdegrado.ge_tmoda ';
				$cadenaSql .= 'ON antp_moda = moda_moda ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estd_usua=\'' . $variable . '\' ';
				// $cadenaSql .= 'WHERE '; $cadenaSql .= ''
				// $cadenaSql .= 'estado=\'RADICADO\' OR estado=\'ASIGNADO REVISORES\'';
				// $cadenaSql .= 'nombre=\'' . $_REQUEST ['nombrePagina'] . '\' ';
				// echo $cadenaSql;
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
		}
		
		return $cadenaSql;
	}
}
?>
