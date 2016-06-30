<?php

namespace informefinal\solicitudRevInformeFinal;

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
			
			case "consultarSolicitudes" :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "s.sljur_sljur as solicitud, ";
				$cadenaSql .= "s.sljur_fcrea as fecha_creacion, ";
				$cadenaSql .= "s.sljur_fradi as fecha_radicacion, ";
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) as nombre, ";
				$cadenaSql .= "s.sljur_info as informe, ";
				$cadenaSql .= "s.sljur_descri as descripcion, ";
				$cadenaSql .= "s.sljur_esljur as Estado, ";
				$cadenaSql .= "s.sljur_acta as acto, ";
				$cadenaSql .= "s.sljur_acta_fecha as fecha_acta, ";
				$cadenaSql .= "s.sljur_prof_asignado as docente ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.inf_tsljur s, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof p, ";
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "s.sljur_esljur='ASIGNADA' ";
				$cadenaSql .= "and p.prof_us='" . $variable . "' ";
				$cadenaSql .= "and p.prof_prof=s.sljur_prof_asignado ";
				$cadenaSql .= "and u.id_usuario=s.sljur_usua ";
				// echo $cadenaSql;
				break;
			
			case 'buscarInformes' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'p.prof_prof, ';
				$cadenaSql .= 'p.prof_us, ';
				$cadenaSql .= 'i.info_info, ';
				$cadenaSql .= 'i.info_fcrea, ';
				$cadenaSql .= 'i.info_einfo, ';
				$cadenaSql .= 'j.jur_info, ';
				$cadenaSql .= 'j.jur_prof, ';
				$cadenaSql .= 'j.jur_fasig ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tinfo i, ';
				$cadenaSql .= 'trabajosdegrado.inf_tjur j, ';
				$cadenaSql .= 'trabajosdegrado.ge_tprof p ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "j.jur_info = i.inf_tinfo ";
				$cadenaSql .= "and p.prof_prof=j.jur_prof ";
				$cadenaSql .= "and p.prof_us = '" . $variable . "' ";
				// $cadenaSql .= "and a.antp_eantp = 'REVISORES ASIGNADOS' ";
				// echo $cadenaSql;
				break;
			
			case 'buscarInforme' :
				
				$cadenaSql = 'SELECT * ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tinfo ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "info_info = " . $variable . " ";
				// echo $cadenaSql;
				break;
			
			case 'buscarDocentes' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "d.prof_prof, ";
				$cadenaSql .= "(p.pern_nomb || ' ' ||p.pern_papell || ' ' ||p.pern_sapell) AS  Nombre, ";
				$cadenaSql .= "d.prof_pern ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_tprof d, ";
				$cadenaSql .= "trabajosdegrado.ge_tpern p ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "d.prof_tpvinc='Planta'";
				$cadenaSql .= "and (d.prof_pern=p.pern_pern)";
				break;
			
			case 'buscarAutores' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'estinfo_est as ESTUDIANTE,';
				$cadenaSql .= 'estinfo_info as INFORME, ';
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS  Nombre ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_testinfo, ';
				$cadenaSql .= "trabajosdegrado.ge_testd e, ";
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estinfo_info =' . $_REQUEST ['informe'];
				$cadenaSql .= " and e.estd_us =u.id_usuario";
				$cadenaSql .= " and estinfo_est =e.estd_estd";
				
				// echo $cadenaSql;
				break;
			
			case 'buscarNombresAutores' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "e.estd_estd, ";
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS  Nombre, ";
				$cadenaSql .= "e.estd_us ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_testd e, ";
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "e.estd_estd='" . $variable . "'";
				$cadenaSql .= " and e.estd_us =u.id_usuario";
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
			
			case 'buscarNombre' :
				$cadenaSql = " SELECT ";
				$cadenaSql .= " nombre || ' ' || apellido AS nombre ";
				$cadenaSql .= " FROM ";
				$cadenaSql .= " polux_usuario ";
				$cadenaSql .= " WHERE ";
				$cadenaSql .= " id_usuario='" . $variable . "';";
				break;
			
			case 'ultimaIteracion' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "MAX(eval_iteracion) ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.inf_teval, ";
				$cadenaSql .= "trabajosdegrado.inf_tsljur ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "sljur_info=" . $_REQUEST ['informe'] . " ";
				$cadenaSql .= "and eval_dinfo=sljur_dinfo ";
				// echo $cadenaSql;
				break;
			
			case 'buscarDocumento' :
				$cadenaSql = 'SELECT MAX(dinfo_dinfo) FROM trabajosdegrado.inf_tdinfo ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dinfo_info=\'' . $variable . '\' ';
				// var_dump ( $cadenaSql );
				break;
			
			case 'buscarVersionDoc' :
				$cadenaSql = 'SELECT dinfo_vers FROM trabajosdegrado.inf_tdinfo ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dinfo_dinfo=\'' . $variable . '\' ';
				// var_dump ( $cadenaSql );
				break;
		}
		
		return $cadenaSql;
	}
}
?>
