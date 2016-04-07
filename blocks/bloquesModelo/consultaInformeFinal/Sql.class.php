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
			
			case "registrarSustentacion" :
				var_dump ( $_REQUEST );
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.inf_tsust (";
				$cadenaSql .= "sust_fradi, ";
				$cadenaSql .= "sust_fsust, ";
				$cadenaSql .= "sust_lugar, ";
				$cadenaSql .= "sust_hora, ";
				$cadenaSql .= "sust_usua_crea, ";
				$cadenaSql .= "sust_observ_crea, ";
				$cadenaSql .= "sust_info) ";
				$cadenaSql .= "VALUES ( ";
				$cadenaSql .= "'" . $_REQUEST ['fechaSustentacion'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['fechaSustentacion'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['lugarSustentacion'] . "', ";
				// Guardar la hora
				$cadenaSql .= "'" . $_REQUEST ['horaSustentacion'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['usuario'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['observaciones'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['informe'] . "' ";
				$cadenaSql .= ") ";
				echo ($cadenaSql);
				break;
			
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
				var_dump ( $cadenaSql );
				break;
			
			case 'registrar' :
				
				// obtener codigos por separado
				$cadenaSql = "";
				$revisores = $_REQUEST ['revisores'];
				var_dump ( $revisores );
				$porciones = explode ( ";", $revisores );
				var_dump ( $porciones );
				var_dump ( $_REQUEST ['numRevisores'] );
				for($i = 0; $i < $_REQUEST ['numRevisores']; $i ++) {
					
					$cadena = "INSERT INTO trabajosdegrado.inf_tjur";
					$cadena .= "(";
					$cadena .= "jur_info, ";
					$cadena .= "jur_prof, ";
					$cadena .= "jur_fasig ";
					$cadena .= ") ";
					$cadena .= "VALUES ";
					$cadena .= "(";
					
					$cadena .= $_REQUEST ['informe'] . ", ";
					$cadena .= "'" . $_REQUEST ['revisor'] . "', ";
					$cadena .= "'" . $_REQUEST ['fecha'] . "' ";
					$cadena .= "); ";
					$cadenaSql = $cadenaSql . $cadena;
				}
				echo ($cadenaSql);
				break;
			
			case "registrarFinalizacion" :
				$fecha = date ( 'Y-m-d' );
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "trabajosdegrado.inf_tsust ";
				$cadenaSql .= " SET ";
				$cadenaSql .= "sust_nota= ".$_REQUEST ['calificacionFinal'] . ", ";
				$cadenaSql .= "sust_caracter= '". $_REQUEST ['seleccionarConceptoSustentacion'] . "', ";
				$cadenaSql .= "sust_usua_fin= '". $_REQUEST ['usuario'] . "', ";
				$cadenaSql .= "sust_observ_fin= '" . $_REQUEST ['observacionesFinalizacion'] . "', ";
				$cadenaSql .= "sust_ffin= '". $fecha . "' ";
				$cadenaSql .= " WHERE sust_info='" . $_REQUEST ['informe'] . "' ";
				echo ($cadenaSql);
				break;
			
			case 'registrarSolicitudes' :
				
				$fechaActual = date ( 'Y-m-d' );
				
				$cadenaSql = "INSERT INTO trabajosdegrado.inf_tsljur";
				$cadenaSql .= "(";
				$cadenaSql .= "sljur_fcrea,";
				$cadenaSql .= "sljur_fradi,";
				$cadenaSql .= "sljur_usua,";
				$cadenaSql .= "sljur_info,";
				$cadenaSql .= "sljur_descri,";
				$cadenaSql .= "sljur_esljur,";
				$cadenaSql .= "sljur_acta,";
				$cadenaSql .= "sljur_acta_fecha,";
				$cadenaSql .= "sljur_prof_asignado";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "(";
				$cadenaSql .= "'" . $fechaActual . "', ";
				$cadenaSql .= "'" . $fechaActual . "', ";
				$cadenaSql .= "'" . $_REQUEST ['usuario'] . "', ";
				$cadenaSql .= $_REQUEST ['informe'] . ", ";
				$cadenaSql .= "'" . $_REQUEST ['observaciones'] . "', ";
				$cadenaSql .= "'" . "ASIGNADA" . "', ";
				$cadenaSql .= $_REQUEST ['acta'] . ", ";
				$cadenaSql .= "'" . $_REQUEST ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable . "' ";
				$cadenaSql .= ") ";
				$cadenaSql .= " RETURNING sljur_sljur;";
				echo ($cadenaSql);
				break;
			
			case 'buscarCodigo' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'estd_estd as CODIGO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_testd ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estd_us=\'' . $variable . '\' ';
				// echo $cadenaSql;
				break;
			
			case 'buscarSustentaciones' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'sust_sust ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tsust ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'sust_info=\'' . $variable . '\' ';
				// echo $cadenaSql;
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
			
			case 'buscarInforme' :
				
				$cadenaSql = 'SELECT ';
				
				$cadenaSql .= 'i.info_info, ';
				$cadenaSql .= 'i.info_proy, ';
				$cadenaSql .= 'm.moda_nombre, ';
				$cadenaSql .= 'i.info_pcur, ';
				$cadenaSql .= 'i.info_titu, ';
				
				$cadenaSql .= 'i.info_fcrea, ';
				$cadenaSql .= 'i.info_descri, ';
				$cadenaSql .= 'i.info_obser, ';
				$cadenaSql .= 'i.info_einfo, ';
				// $cadenaSql .= 'i.info_duracion, ';
				$cadenaSql .= 'i.info_dir_int ';
				
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tinfo i,  ';
				$cadenaSql .= 'trabajosdegrado.ge_tmoda m ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'i.info_info =' . $variable;
				$cadenaSql .= " and i.info_moda=m.moda_moda";
				// echo $cadenaSql;
				break;
			
			case 'buscarTematicas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acinfo_acono as ACONO, ';
				$cadenaSql .= 'acinfo_info as INFORME ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tacinfo ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'acinfo_info =' . $variable;
				// echo $cadenaSql;
				break;
			
			case 'buscarTematicas2' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acinfo_acono as ACONO, ';
				$cadenaSql .= 'acinfo_info as INFORME ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tacinfo ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'acinfo_info =' . $variable;
				// echo $cadenaSql;
				break;
			
			case 'buscarAutores' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'estinfo_est as ESTUDIANTE,';
				$cadenaSql .= 'estinfo_info as INFORME ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_testinfo ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estinfo_info =' . $variable;
				// echo $cadenaSql;
				break;
			
			case 'buscarRevisores' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'r.rev_prof as REVISOR ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_trev r, ';
				$cadenaSql .= 'trabajosdegrado.ant_tantp a, ';
				$cadenaSql .= 'trabajosdegrado.pry_tproy p, ';
				$cadenaSql .= 'trabajosdegrado.inf_tinfo i ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'i.info_info =' . $variable;
				$cadenaSql .= ' and i.info_proy=p.proy_proy ';
				$cadenaSql .= ' and p.proy_antp=a.antp_antp ';
				$cadenaSql .= ' and r.rev_antp=a.antp_antp ';
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
				$cadenaSql .= "and (d.prof_prof <> (SELECT info_dir_int FROM trabajosdegrado.inf_tinfo WHERE info_info='" . $_REQUEST ['id'] . "')) ";
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
			
			case "actualizarEstadoInforme" :
				$cadenaSql = " UPDATE trabajosdegrado.inf_tinfo ";
				$cadenaSql .= " SET info_einfo= 'SUSTENTACION'";
				$cadenaSql .= " WHERE info_info='" . $_REQUEST ['informe'] . "' ";
				echo $cadenaSql;
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
				$cadenaSql .= "dinfo_vers, dinfo_nombre, dinfo_url, dinfo_falm ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.inf_tdinfo ";
				$cadenaSql .= "WHERE dinfo_info=" . $variable . " ";
				
				break;
			
			case 'consultaRespuesta' :
				$cadenaSql = "SELECT * ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.pry_teval ";
				
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "eval_proy='" . $variable . "' ";
				break;
			
			case "consultarRevisores" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "jur_fasig,  jur_prof, nombre || ' ' || apellido as Nombre ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.inf_tjur, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof, ";
				$cadenaSql .= "public.polux_usuario ";
				$cadenaSql .= "WHERE jur_info='" . $variable . "' ";
				$cadenaSql .= "and jur_prof = prof_prof ";
				$cadenaSql .= "and prof_us=id_usuario ";
				// echo $cadenaSql;
				break;
			
			case 'buscarRevisiones' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "e.eval_eval, ";
				$cadenaSql .= "e.eval_fcrea, ";
				$cadenaSql .= "e.eval_cpto_rta, ";
				$cadenaSql .= "d.dinfo_info ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.inf_teval e, ";
				$cadenaSql .= "trabajosdegrado.inf_tdinfo d ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "e.eval_dinfo = d.dinfo_dinfo ";
				$cadenaSql .= "and d.dinfo_info=" . $variable ['informe'] . " ";
				$cadenaSql .= "and e.eval_usua_crea=(Select prof_us from trabajosdegrado.ge_tprof where prof_prof='" . $variable ['jurado'] . "') ";
				// echo $cadenaSql;
				break;
			
			case 'buscarRevisiones2' :
				
				$cadenaSql = "SELECT * ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.inf_teval e, ";
				$cadenaSql .= "trabajosdegrado.inf_tdinfo d ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "e.eval_info = " . $_REQUEST ['informe'] . " ";
				// echo $cadenaSql;
				break;
			
			case 'buscarPreguntas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "preg_preg, ";
				$cadenaSql .= "preg_pregunta ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tpreg ';
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
			
			case "actualizarEstadoInforme" :
				$cadenaSql = " UPDATE trabajosdegrado.inf_tinfo ";
				$cadenaSql .= " SET info_einfo= 'EN REVISION'";
				$cadenaSql .= " WHERE info_info='" . $_REQUEST ['informe'] . "' ";
				echo $cadenaSql;
				break;
			
			case 'guardarHistorialSol' :
				
				$fechaActual = date ( 'Y-m-d' );
				$cadenaSql = "INSERT INTO trabajosdegrado.inf_thsljur";
				$cadenaSql .= "(";
				$cadenaSql .= "hsljur_sljur,";
				$cadenaSql .= "hsljur_esljur,";
				$cadenaSql .= "hsljur_fasig,";
				$cadenaSql .= "hsljur_acta,";
				$cadenaSql .= "hsljur_acta_fecha,";
				$cadenaSql .= "hsljur_usua,";
				$cadenaSql .= "hsljur_obser";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "(";
				$cadenaSql .= "'" . $variable . "', ";
				$cadenaSql .= "'" . "ASIGNADA" . "', ";
				$cadenaSql .= "'" . $fechaActual . "', ";
				$cadenaSql .= $_REQUEST ['acta'] . ", ";
				$cadenaSql .= "'" . $_REQUEST ['fecha'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['usuario'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['observaciones'] . "' ";
				$cadenaSql .= "); ";
				
				echo ($cadenaSql);
				break;
			
			case "consultarSolicitudes" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "s.sljur_fcrea, ";
				$cadenaSql .= "s.sljur_fradi, ";
				$cadenaSql .= "s.sljur_usua, ";
				$cadenaSql .= "s.sljur_info, ";
				$cadenaSql .= "s.sljur_descri, ";
				$cadenaSql .= "s.sljur_esljur, ";
				$cadenaSql .= "s.sljur_acta, ";
				$cadenaSql .= "s.sljur_acta_fecha, ";
				$cadenaSql .= "u.nombre || ' ' || u.apellido as Nombre ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.inf_tsljur s, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof p, ";
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "s.sljur_prof_asignado = p.prof_prof ";
				$cadenaSql .= "and p.prof_us = u.id_usuario ";
				$cadenaSql .= "and s.sljur_info='" . $_REQUEST ['informe'] . "' ";
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
			
			case 'buscarAutores' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'estinfo_est as ESTUDIANTE,';
				$cadenaSql .= 'estinfo_info as INFORME ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_testinfo ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estinfo_info =' . $_REQUEST ['informe'];
				// echo $cadenaSql;
				break;
			
			case 'buscarConceptosSustentacion' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "crmd_caracter, ";
				$cadenaSql .= "crmd_caracter ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tcrmd ';
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "crmd_moda=1";
				// echo $cadenaSql;
				break;
		}
		
		return $cadenaSql;
	}
}
?>
