<?php

namespace bloquesModelo\informesAsignadoRevision;

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
			
			case 'buscarInformes' :
				
				$cadenaSql = 'SELECT DISTINCT ';
				$cadenaSql .= 'info_titu AS titulo, ';
				$cadenaSql .= 'moda_nombre AS modalidad, ';
				$cadenaSql .= 'info_einfo AS estado, ';
				$cadenaSql .= 'info_fcrea AS fecha, ';
				$cadenaSql .= 'info_info AS informe ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tjur ';
				$cadenaSql .= 'JOIN trabajosdegrado.inf_tinfo ';
				$cadenaSql .= 'ON jur_info=info_info ';
				$cadenaSql .= 'JOIN trabajosdegrado.ge_tmoda ';
				$cadenaSql .= 'ON info_moda=moda_moda ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'jur_prof=\'' . $variable . '\' ';
				$cadenaSql .= 'ORDER BY info_info ASC';
// 				echo $cadenaSql;
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
			
			case 'buscarNombrePrograma' :
				$cadenaSql = 'SELECT pcur_nom ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tpcur ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'pcur_pcur=\'' . $variable . '\' ';
				break;
			
			case 'buscarProgramaDocente' :
				$cadenaSql = 'SELECT pcur_pcur ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tprof ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.ge_tpcur ';
				$cadenaSql .= 'ON prof_pcur = pcur_pcur ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'prof_us=\'' . $variable . '\' ';
				// echo $cadenaSql;
				break;
			
			case 'consultarRol' :
				$cadenaSql = 'SELECT rol_nombre ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'polux_usuario u ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'polux_usuario_subsistema us ';
				$cadenaSql .= 'ON u.id_usuario::varchar = us.id_usuario ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'polux_rol r ';
				$cadenaSql .= 'ON us.rol_id = r.rol_id ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'u.id_usuario=\'' . $variable . '\' ';
				break;
			
			case 'buscarNombrePrograma' :
				$cadenaSql = 'SELECT pcur_nom ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tpcur ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'pcur_pcur=\'' . $variable . '\' ';
				break;
			
			case 'buscarEstudiante' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'nombre || \' \' || apellido AS  Nombre ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'polux_usuario ';
				$cadenaSql .= 'JOIN trabajosdegrado.ge_testd ';
				$cadenaSql .= 'ON id_usuario = estd_us ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estd_estd=\'' . $variable . '\' ';
				// echo $cadenaSql;
				break;
			
			case 'buscarDocente' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "nombre || ' ' || apellido AS Nombre ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'polux_usuario ';
				$cadenaSql .= 'JOIN trabajosdegrado.ge_tprof ';
				$cadenaSql .= 'ON id_usuario = prof_us ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'prof_us=\'' . $variable . '\' ';
				$cadenaSql .= 'OR ';
				$cadenaSql .= 'prof_prof=\'' . $variable . '\' ';
				// echo $cadenaSql;
				break;
		}
		
		if (! isset ( $cadenaSql )) {
			echo "No se encontro la cosulta: '" . $tipo . "'";
		}
		
		return $cadenaSql;
	}
}
?>
