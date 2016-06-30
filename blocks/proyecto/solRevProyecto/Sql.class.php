<?php

namespace proyecto\solRevProyecto;

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
			
			case 'buscarSolicitudes' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'proy_proy ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tsrdp ';
				$cadenaSql .= 'JOIN trabajosdegrado.pry_tproy ';
				$cadenaSql .= 'ON srdp_proy=proy_proy ';
				$cadenaSql .= 'WHERE ';
				// $cadenaSql .= "r.rev_antp = a.antp_antp ";
				$cadenaSql .= "proy_dir_int='" . $variable . "' ";
				$cadenaSql .= "AND srdp_esrdp='ESPERA' ";
// 				echo $cadenaSql;
				break;
			
			case 'buscarProyecto' :
				
				$cadenaSql = 'SELECT * ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tproy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "proy_proy = " . $variable . " ";
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
				$cadenaSql .= 'estproy_estd as ESTUDIANTE,';
				$cadenaSql .= 'estproy_proy as PROYECTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_testpry ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estproy_proy =' . $_REQUEST ['proyecto'];
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
			
			case 'buscarDocumento' :
				$cadenaSql = 'SELECT MAX(dproy_dproy) FROM trabajosdegrado.pry_tdproy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dproy_proy=\'' . $variable . '\' ';
				// var_dump ( $cadenaSql );
				break;
			
			case 'buscarVersionDoc' :
				$cadenaSql = 'SELECT dproy_vers FROM trabajosdegrado.pry_tdproy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dproy_dproy=\'' . $variable . '\' ';
				// var_dump ( $cadenaSql );
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
		}
		
		return $cadenaSql;
	}
}
?>
