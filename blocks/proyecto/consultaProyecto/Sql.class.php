<?php

namespace proyecto\consultaProyecto;

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
			
			case "registrarVersionDoc" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.pry_tdproy ( ";
				$cadenaSql .= "dproy_vers, ";
				$cadenaSql .= "dproy_observ, ";
				$cadenaSql .= "dproy_falm, ";
				$cadenaSql .= "dproy_usua, ";
				$cadenaSql .= "dproy_proy, ";
				$cadenaSql .= "dproy_url, ";
				$cadenaSql .= "dproy_hash, ";
				$cadenaSql .= "dproy_bytes, ";
				$cadenaSql .= "dproy_nombre, ";
				$cadenaSql .= "dproy_extension) ";
				$cadenaSql .= "VALUES ( ";
				$cadenaSql .= "" . $variable ['version'] . ", ";
				$cadenaSql .= "'" . $variable ['observacion'] . "', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['usuario'] . "', ";
				$cadenaSql .= "" . $variable ['proyecto'] . ", ";
				$cadenaSql .= "'" . $variable ['url'] . "', ";
				$cadenaSql .= "'" . $variable ['hash'] . "', ";
				$cadenaSql .= "'" . $variable ['tamano'] . "', ";
				$cadenaSql .= "'" . $variable ['nombre'] . "', ";
				$cadenaSql .= "'" . $variable ['tipo'] . "' ";
				$cadenaSql .= ") ";
				//var_dump ( $cadenaSql );
				break;
			
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
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'proy_proy, ';
				$cadenaSql .= 'proy_antp, ';
				$cadenaSql .= 'moda_nombre, ';
				$cadenaSql .= 'proy_pcur, ';
				$cadenaSql .= 'proy_titu, ';
				$cadenaSql .= 'proy_fcrea, ';
				$cadenaSql .= 'proy_descri, ';
				$cadenaSql .= 'proy_obser, ';
				$cadenaSql .= 'proy_eproy, ';
				$cadenaSql .= 'duracion_descri, ';
				$cadenaSql .= 'proy_dir_int ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tproy ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.ge_tmoda ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'proy_moda=moda_moda ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.pry_tduracion ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'proy_duracion=duracion_duracion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'proy_proy =' . $variable;
				// echo $cadenaSql;
				break;
			
			case 'buscarTematicas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acono_acono, ';
				$cadenaSql .= 'acono_nom ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tacproy ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.ge_tacono ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'acproy_acono=acono_acono ';
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
			
			case 'buscarNombreDirector' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'nombre || \' \' || apellido AS NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tprof ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'polux_usuario ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'prof_us=id_usuario ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "prof_prof='" . $variable . "' ";
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
				$cadenaSql .= "WHERE dproy_proy='" . $variable . "' ";
				$cadenaSql .= "ORDER BY dproy_vers DESC";
				// echo $cadenaSql;
				break;
			
			case "buscarDocumentoActual" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "MAX(dproy_dproy) ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.pry_tdproy ";
				$cadenaSql .= "WHERE dproy_proy='" . $_REQUEST ['proyecto'] . "' ";
				//echo $cadenaSql;
				break;
			
			case 'documentoAnexo' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "tdapy_descri, ";
				$cadenaSql .= "dapy_url, ";
				$cadenaSql .= "dapy_nombre ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.pry_tdapy ";
				$cadenaSql .= "JOIN ";
				$cadenaSql .= "trabajosdegrado.pry_ttdapy ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "dapy_tdapy=tdapy_tdapy ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "dapy_proy='" . $variable . "';";
				break;
			
			/*
			 * case 'consultaRespuesta' :
			 * $cadenaSql = "SELECT ";
			 * $cadenaSql .= "eval_fcrea, ";
			 * $cadenaSql .= "eval_dantp, ";
			 * $cadenaSql .= "eval_cpto_rta, ";
			 * $cadenaSql .= "nombre || ' ' || apellido AS Nombre, ";
			 * $cadenaSql .= "rev_fasig ";
			 * $cadenaSql .= "FROM ";
			 * $cadenaSql .= "trabajosdegrado.ant_teval ";
			 * $cadenaSql .= "JOIN ";
			 * $cadenaSql .= "trabajosdegrado.ant_tdantp ";
			 * $cadenaSql .= "ON ";
			 * $cadenaSql .= "eval_dantp=dantp_dantp ";
			 * $cadenaSql .= "JOIN ";
			 * $cadenaSql .= "trabajosdegrado.ant_tantp ";
			 * $cadenaSql .= "ON ";
			 * $cadenaSql .= "dantp_antp=antp_antp ";
			 * $cadenaSql .= "JOIN ";
			 * $cadenaSql .= "polux_usuario ";
			 * $cadenaSql .= "ON ";
			 * $cadenaSql .= "eval_us_crea=identificacion::varchar ";
			 * $cadenaSql .= "JOIN ";
			 * $cadenaSql .= "trabajosdegrado.ant_trev ";
			 * $cadenaSql .= "ON ";
			 * $cadenaSql .= "antp_antp=rev_antp ";
			 * $cadenaSql .= "WHERE ";
			 * $cadenaSql .= "dantp_antp='" . $variable . "' ";
			 * echo $cadenaSql;
			 * break;
			 */
			
			case 'consultaRespuesta' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "e.eval_fcrea, ";
				$cadenaSql .= "e.eval_dproy, ";
				$cadenaSql .= "e.eval_cpto_rta, ";
				$cadenaSql .= "u.nombre || ' ' || u.apellido as nombre, ";
				$cadenaSql .= "srdp_fcrea, ";
				$cadenaSql .= "e.eval_eval ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.pry_teval e, ";
				$cadenaSql .= "trabajosdegrado.pry_tproy, ";
				$cadenaSql .= "trabajosdegrado.pry_tsrdp, ";
				$cadenaSql .= "polux_usuario u ";
				
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "srdp_dproy=e.eval_dproy ";
				$cadenaSql .= "and eval_proy=proy_proy ";
				$cadenaSql .= "and e.eval_proy=" . $variable ['proyecto'] . " ";
				$cadenaSql .= "and e.eval_dproy=" . $variable ['documento'] . " ";
				$cadenaSql .= "and e.eval_usua_crea=u.identificacion::varchar ";
				//echo $cadenaSql;
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
				// echo $cadenaSql;
				break;
			
			case 'actividadesPendientes' :
				$cadenaSql = "";
				break;
			
			case 'buscarDocumento' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "dproy_dproy, ";
				$cadenaSql .= "dproy_vers ";
				$cadenaSql .= "FROM trabajosdegrado.pry_tdproy ";
				$cadenaSql .= "ORDER BY dproy_vers DESC; ";
				break;
			
			case 'buscarDocumento2' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "dproy_dproy, ";
				$cadenaSql .= "dproy_vers ";
				$cadenaSql .= "FROM trabajosdegrado.pry_tdproy ";
				$cadenaSql .= "WHERE srdp_proy= " . $_REQUEST ['proyecto'];
				$cadenaSql .= " ORDER BY dproy_vers DESC; ";
				break;
			
			case 'buscarPreguntas' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "preg_preg, ";
				$cadenaSql .= "preg_pregunta ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.pry_tpreg; ";
				break;
			
			case 'guardarSolicitud' :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.pry_tsrdp ";
				$cadenaSql .= "(srdp_esrdp, ";
				$cadenaSql .= "srdp_fcrea, ";
				$cadenaSql .= "srdp_observ, ";
				$cadenaSql .= "srdp_estd, ";
				$cadenaSql .= "srdp_proy, ";
				$cadenaSql .= "srdp_dproy) ";
				
				$cadenaSql .= "VALUES (";
				$cadenaSql .= "'" . $variable ['estado'] . "', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['pregunta1'] . "', ";
				$cadenaSql .= "'" . $variable ['estudiante'] . "', ";
				$cadenaSql .= "'" . $variable ['proyecto'] . "',";
				$cadenaSql .= "'" . $variable ['documento'] . "')";
				//echo $cadenaSql;
				break;
			
			case 'buscarCodigo' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "estd_estd ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_testd ";
				$cadenaSql .= "WHERE estd_us='" . $variable . "' ";
				break;
			
			case 'buscarHistorial' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'h.hproy_fasig as FECHA,';
				$cadenaSql .= 'h.hproy_eproy as ESTADO, ';
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS  USUARIO, ";
				$cadenaSql .= 'h.hproy_obser as OBSERVACIONES ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_thproy h, ';
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'h.hproy_proy =' . $variable;
				$cadenaSql .= " and (h.hproy_usua=u.id_usuario)";
				// echo $cadenaSql;
				break;
			
			case 'buscarVersionDoc' :
				$cadenaSql = 'SELECT dproy_vers FROM trabajosdegrado.pry_tdproy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dproy_dproy=\'' . $variable . '\' ';
				// var_dump ( $cadenaSql );
				break;
			
			case 'buscarRevisionesPrueba' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "e.eval_eval, ";
				$cadenaSql .= "e.eval_fcrea, ";
				$cadenaSql .= "e.eval_cpto_rta, ";
				$cadenaSql .= "d.dproy_proy, ";
				$cadenaSql .= "d.dproy_vers, ";
				$cadenaSql .= "d.dproy_dproy, ";
				$cadenaSql .= "s.srdp_fcrea, ";
				$cadenaSql .= "p.prof_us, u.nombre || ' ' || u.apellido as Nombre, ";
				$cadenaSql .= "srdp_proy, ";
				$cadenaSql .= "e.eval_iteracion ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.pry_teval e, ";
				$cadenaSql .= "trabajosdegrado.pry_tdproy d, ";
				$cadenaSql .= "trabajosdegrado.pry_tsrdp s, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof p, ";
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "e.eval_dproy = d.dproy_dproy ";
				$cadenaSql .= "and d.dproy_proy=" . $variable . " ";
				$cadenaSql .= "and e.eval_instancia = 'DIRECTOR' ";
				$cadenaSql .= "and s.srdp_proy =" . $variable . " ";
				$cadenaSql .= "and srdp_dproy = d.dproy_dproy ";
				$cadenaSql .= "and p.prof_us = u.id_usuario ";
				$cadenaSql .= "and eval_usua_crea=p.prof_prof  ";
				
				//echo $cadenaSql;
				break;
				
				case 'buscarSolicitudes' :
					$cadenaSql = "SELECT ";
					$cadenaSql .= "srdp_srdp, srdp_dproy  ";
					$cadenaSql .= "FROM ";
					$cadenaSql .= "trabajosdegrado.pry_tsrdp ";
					$cadenaSql .= "WHERE ";
					$cadenaSql .= "srdp_proy=" . $_REQUEST ['proyecto'] . " ";
					$cadenaSql .= "ORDER BY srdp_dproy DESC ";
				
					//echo $cadenaSql;
					break;
		}
		
		return $cadenaSql;
	}
}
?>
