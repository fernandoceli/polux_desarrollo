<?php

namespace bloquesModelo\consultaAnteproyecto;

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
			case 'registrar' :
				
				// obtener codigos por separado
				$cadenaSql = "";
				$revisores = $_REQUEST ['nombresRevisores'];
				var_dump ( $revisores );
				$porciones = explode ( ";", $revisores );
				var_dump ( $porciones );
				var_dump ( $_REQUEST ['numRevisores'] );
				for($i = 0; $i < $_REQUEST ['numRevisores']; $i ++) {
					
					$cadena = "INSERT INTO trabajosdegrado.ant_trev";
					$cadena .= "(";
					$cadena .= "rev_antp,";
					$cadena .= "rev_prof,";
					$cadena .= "rev_fasig";
					$cadena .= ") ";
					$cadena .= "VALUES ";
					$cadena .= "(";
					
					$cadena .= $_REQUEST ['anteproyecto'] . ", ";
					$cadena .= "'" . $porciones [$i] . "', ";
					$cadena .= "'" . $_REQUEST ['fecha'] . "' ";
					$cadena .= "); ";
					
					$cadenaSql = $cadenaSql . $cadena;
				}
				// echo ( $cadenaSql );
				break;
			
			case 'buscarAnteproyectos' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'a.antp_fradi as FECHA, ';
				$cadenaSql .= 'a.antp_antp as ANTEPROYECTO, ';
				$cadenaSql .= 'm.moda_nombre as MODALIDAD, ';
				$cadenaSql .= 'a.antp_titu as TITULO, ';
				$cadenaSql .= 'a.antp_eantp as ESTADO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tantp a, ';
				$cadenaSql .= 'trabajosdegrado.ge_tmoda m ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "antp_eantp='RADICADO'";
				$cadenaSql .= "and a.antp_moda=m.moda_moda";
				// echo $cadenaSql;
				break;
			
			case 'buscarAnteproyecto' :
				
				$cadenaSql = 'SELECT * ';
				// $cadenaSql .= 'antp_titu as TITULO,';
				// $cadenaSql .= 'antp_moda as MODALIDAD,';
				// $cadenaSql .= 'antp_eantp as ESTADO ';
				/*
				 * $cadenaSql .= 'antp_fradi as FECHA, ';
				 * $cadenaSql .= 'antp_antp as ANTEPROYECTO, ';
				 */
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'antp_antp =' . $_REQUEST ['anteproyecto'];
				// $cadenaSql .= 'estado=\'RADICADO\' OR estado=\'ASIGNADO REVISORES\'';
				// $cadenaSql .= 'nombre=\'' . $_REQUEST ['nombrePagina'] . '\' ';
				// echo $cadenaSql;
				break;
			
			case 'buscarTematicas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acantp_acono as ACONO,';
				$cadenaSql .= 'acantp_antp as ANTEPROYECTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tacantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'acantp_antp =' . $_REQUEST ['anteproyecto'];
				// echo $cadenaSql;
				break;
			
			case 'buscarTematicas2' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acantp_acono as ACONO,';
				$cadenaSql .= 'acantp_antp as ANTEPROYECTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tacantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'acantp_antp =' . $variable;
				// echo $cadenaSql;
				break;
			
			case 'buscarHistorial' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'h.hantp_fasig as FECHA,';
				$cadenaSql .= 'h.hantp_eantp as ESTADO, ';
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS  USUARIO, ";
				$cadenaSql .= 'h.hantp_obser as OBSERVACIONES ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_thantp h, ';
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'h.hantp_antp =' . $variable;
				$cadenaSql .= " and (h.hantp_usua=u.id_usuario)";
				// echo $cadenaSql;
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
			
			case 'buscarNombreModalidad' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "moda_moda, ";
				$cadenaSql .= "moda_nombre AS  Nombre ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_tmoda ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "moda_moda='" . $variable . "' ";
				// echo $cadenaSql;
				break;
			
			case 'buscarNombresTematicas' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "acono_nom AS Nombre ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_tacono ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "acono_acono='" . $variable . "' ";
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
			
			case 'buscarNombresDirector' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "d.prof_prof, ";
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS  Nombre, ";
				$cadenaSql .= "d.prof_us ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "public.polux_usuario u, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof d ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "d.prof_prof='" . $variable . "'";
				$cadenaSql .= "and (d.prof_us=u.id_usuario";
				$cadenaSql .= ")";
				// echo $cadenaSql;
				break;
			
			case 'buscarDocentes' :
				// var_dump ( count ( $variable ['tematica'] ) );
				$cadenaSql = "SELECT DISTINCT ";
				$cadenaSql .= "d.prof_prof, ";
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS  Nombre, ";
				$cadenaSql .= "d.prof_us ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "public.polux_usuario u, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof d, ";
				$cadenaSql .= "trabajosdegrado.ge_tacpro acp ";
				
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "d.prof_tpvinc='Planta' ";
				$cadenaSql .= "and (d.prof_us=u.id_usuario)";
				// para que no salga el docente director
				$cadenaSql .= "and (d.prof_prof <> (SELECT a.antp_dir_int FROM trabajosdegrado.ant_tantp a WHERE antp_antp='" . $_REQUEST ['id'] . "')) ";
				$cadenaSql .= " and acp.acpro_prof=d.prof_prof";
				
				$cadenaSql .= " and (";
				for($i = 0; $i < count ( $variable ['tematica'] ); $i ++) {
					if (($i + 1) == count ( $variable ['tematica'] )) {
						$cadenaSql .= " acp.acpro_acono=" . $variable ['tematica'] [$i];
					} else {
						$cadenaSql .= " acp.acpro_acono=" . $variable ['tematica'] [$i] . " or";
					}
				}
				
				$cadenaSql .= " )";
				// echo $cadenaSql;
				break;
			
			case "actualizarEstado" :
				$cadenaSql = " UPDATE trabajosdegrado.ant_tantp ";
				$cadenaSql .= " SET antp_eantp= 'REVISORES ASIGNADOS'";
				$cadenaSql .= " WHERE antp_antp='" . $_REQUEST ['anteproyecto'] . "' ";
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
			
			case "consultarVersiones" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "dantp_vers, dantp_nombre, dantp_url, dantp_falm ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp ";
				$cadenaSql .= "WHERE dantp_antp='" . $_REQUEST ['anteproyecto'] . "' ";
				// echo $cadenaSql;
				break;
			
			case 'consultaRespuesta' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "eval_fcrea, ";
				$cadenaSql .= "eval_dantp, ";
				$cadenaSql .= "eval_cpto_rta, ";
				$cadenaSql .= "nombre || ' ' || apellido AS Nombre, ";
				$cadenaSql .= "rev_fasig ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_teval ";
				$cadenaSql .= "JOIN ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "eval_dantp=dantp_dantp ";
				$cadenaSql .= "JOIN ";
				$cadenaSql .= "trabajosdegrado.ant_tantp ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "dantp_antp=antp_antp ";
				$cadenaSql .= "JOIN ";
				$cadenaSql .= "polux_usuario ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "eval_us_crea=identificacion::varchar ";
				$cadenaSql .= "JOIN ";
				$cadenaSql .= "trabajosdegrado.ant_trev ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "antp_antp=rev_antp ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "dantp_antp='" . $variable . "' ";
				break;
			
			case "consultarRevisor" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "r.rev_fasig, r.rev_prof, u.nombre || ' ' || u.apellido as Nombre ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_trev r, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof p, ";
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "r.rev_prof = p.prof_prof ";
				$cadenaSql .= "and p.prof_us = u.id_usuario ";
				$cadenaSql .= "and r.rev_antp='" . $_REQUEST ['anteproyecto'] . "' ";
				// echo $cadenaSql;
				break;
			
			case 'buscarRevisiones' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "e.eval_eval, ";
				$cadenaSql .= "e.eval_fcrea, ";
				$cadenaSql .= "e.eval_cpto_rta, ";
				$cadenaSql .= "d.dantp_antp ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_teval e, ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp d ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "e.eval_dantp = d.dantp_dantp ";
				$cadenaSql .= "and d.dantp_antp=" . $variable ['anteproyecto'] . " ";
				$cadenaSql .= "and e.eval_us_crea='" . $variable ['revisor'] . "'";
				
				echo $cadenaSql;
				break;
		}
		
		return $cadenaSql;
	}
}
?>
