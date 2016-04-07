<?php

namespace bloquesModelo\solRevAnteproyecto;

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
				
				$cadenaSql = "SELECT DISTINCT ";
				$cadenaSql .= "slrev_slrev, ";
				$cadenaSql .= "s.slrev_fcrea, ";
				$cadenaSql .= "s.slrev_fradi, ";
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS Nombre, ";
				$cadenaSql .= "s.slrev_antp, ";
				$cadenaSql .= "s.slrev_descri, ";
				$cadenaSql .= "s.slrev_eslrev, ";
				$cadenaSql .= "s.slrev_acta, ";
				$cadenaSql .= "s.slrev_acta_fecha, ";
				$cadenaSql .= "slrev_prof_asignado ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev s, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof p, ";
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "slrev_eslrev='ASIGNADA' ";
				$aux = substr ( $variable, 2 );
				if (! is_numeric ( $aux )) {
					$cadenaSql .= "and p.prof_us='" . $variable . "' ";
				} else {
					$cadenaSql .= "and p.prof_prof='" . $variable . "' ";
				}
				$cadenaSql .= "and s.slrev_prof_asignado=p.prof_prof ";
				$cadenaSql .= "and u.id_usuario=s.slrev_usua; ";
				// echo $cadenaSql;
				break;
			
			case 'buscarAnteproyectos' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'p.prof_prof, ';
				$cadenaSql .= 'p.prof_us, ';
				$cadenaSql .= 'a.antp_antp, ';
				$cadenaSql .= 'a.antp_fradi, ';
				$cadenaSql .= 'a.antp_eantp, ';
				$cadenaSql .= 'r.rev_antp, ';
				$cadenaSql .= 'r.rev_prof, ';
				$cadenaSql .= 'r.rev_fasig ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tantp a, ';
				$cadenaSql .= 'trabajosdegrado.ant_trev r, ';
				$cadenaSql .= 'trabajosdegrado.ge_tprof p ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "r.rev_antp = a.antp_antp ";
				$cadenaSql .= "and p.prof_prof=r.rev_prof ";
				$cadenaSql .= "and p.prof_us = '" . $variable . "' ";
				$cadenaSql .= "and a.antp_eantp = 'REVISORES ASIGNADOS' ";
				// echo $cadenaSql;
				break;
			
			case 'buscarAnteproyecto' :
				
				$cadenaSql = 'SELECT * ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "antp_antp = " . $variable . " ";
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
				$cadenaSql .= 'estantp_estd as ESTUDIANTE,';
				$cadenaSql .= 'estantp_antp as ANTEPROYECTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_testantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estantp_antp =' . $_REQUEST ['anteproyecto'];
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
			
			case 'consultarCodigo' :
				$cadenaSql = 'SELECT prof_prof ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tprof ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'polux_usuario ';
				$cadenaSql .= 'ON prof_us=id_usuario ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_usuario=\'' . $variable . '\' ';
				// echo $cadenaSql;
				break;
			
			case 'buscarDocumento' :
				$cadenaSql = 'SELECT MAX(dantp_dantp) FROM trabajosdegrado.ant_tdantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dantp_antp=\'' . $variable . '\' ';
				// var_dump ( $cadenaSql );
				break;
			
			case 'buscarVersionDoc' :
				$cadenaSql = 'SELECT dantp_vers FROM trabajosdegrado.ant_tdantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dantp_dantp=\'' . $variable . '\' ';
				// var_dump ( $cadenaSql );
				break;
		}
		
		return $cadenaSql;
	}
}
?>
