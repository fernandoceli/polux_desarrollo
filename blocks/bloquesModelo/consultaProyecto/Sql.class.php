<?php

namespace bloquesModelo\consultaProyecto;

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
				
				$cadenaSql = "INSERT INTO trabajosdegrado.ant_trev";
				$cadenaSql .= "(";
				$cadenaSql .= "rev_antp,";
				$cadenaSql .= "rev_prof,";
				$cadenaSql .= "rev_fasig";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "(";
				
				$cadenaSql .= $_REQUEST ['anteproyecto'] . ", ";
				$cadenaSql .= "'" . $_REQUEST ['revisor'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['fecha'] . "' ";
				$cadenaSql .= ") ";
				// var_dump ( $cadenaSql );
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
			
			case 'buscarProyecto' :
				
				$cadenaSql = 'SELECT * ';
				// $cadenaSql .= 'antp_titu as TITULO,';
				// $cadenaSql .= 'antp_moda as MODALIDAD,';
				// $cadenaSql .= 'antp_eantp as ESTADO ';
				/*
				 * $cadenaSql .= 'antp_fradi as FECHA, ';
				 * $cadenaSql .= 'antp_antp as ANTEPROYECTO, ';
				 */
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tproy  ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'proy_proy =' . $variable;
				// $cadenaSql .= 'estado=\'RADICADO\' OR estado=\'ASIGNADO REVISORES\'';
				// $cadenaSql .= 'nombre=\'' . $_REQUEST ['nombrePagina'] . '\' ';
				// echo $cadenaSql;
				break;
			
			case 'buscarTematicas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acantp_acono as ACONO,';
				$cadenaSql .= 'acantp_antp as ANTEPROYECTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tacproy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'acproy_proy =' . $variable;
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
			
			case 'buscarAutores' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'estproy_estd as ESTUDIANTE,';
				$cadenaSql .= 'estproy_proy as PROYECTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_testpry ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estproy_proy =' . $variable;
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
				$cadenaSql = "SELECT ";
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
				$cadenaSql .= "dproy_vers, dproy_nombre, dproy_url, dproy_falm ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.pry_tdproy ";
				$cadenaSql .= "WHERE dproy_dproy='" . $variable . "' ";
				// echo $cadenaSql;
				break;
			
				
			case 'consultaRespuesta':
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
				$cadenaSql .= "rev_fasig, nombre || ' ' || apellido as Nombre ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_trev ";
				$cadenaSql .= "JOIN ";
				$cadenaSql .= "trabajosdegrado.ge_tprof ";
				$cadenaSql .= "ON rev_prof = prof_prof ";
				$cadenaSql .= "JOIN ";
				$cadenaSql .= "polux_usuario ";
				$cadenaSql .= "ON id_usuario = (tipo_identificacion || prof_prof) ";
				$cadenaSql .= "WHERE rev_antp='" . $variable . "' ";
// 				echo $cadenaSql;
				break;
		}
		
		return $cadenaSql;
	}
}
?>
