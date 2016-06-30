<?php

namespace anteproyecto\consultaAnteproyecto;

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
			// //////////////////////////////
			case 'registrar' :
				
				// obtener codigos por separado
				$cadenaSql = "";
				$revisores = $_REQUEST ['revisores'];
				// var_dump ( $revisores );
				$porciones = explode ( ";", $revisores );
				// var_dump ( $porciones );
				// var_dump ( $_REQUEST ['numRevisores'] );
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
			
			// ///////////////////
			case "registrarVersionDoc" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp ( ";
				$cadenaSql .= "dantp_vers, ";
				$cadenaSql .= "dantp_observ, ";
				$cadenaSql .= "dantp_falm, ";
				$cadenaSql .= "dantp_usua, ";
				$cadenaSql .= "dantp_antp, ";
				$cadenaSql .= "dantp_url, ";
				$cadenaSql .= "dantp_hash, ";
				$cadenaSql .= "dantp_bytes, ";
				$cadenaSql .= "dantp_nombre, ";
				$cadenaSql .= "dantp_extension) ";
				$cadenaSql .= "VALUES ( ";
				$cadenaSql .= "" . $variable ['version'] . ", ";
				$cadenaSql .= "'" . $variable ['observacion'] . "', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['usuario'] . "', ";
				$cadenaSql .= "" . $_REQUEST ['anteproyecto'] . ", ";
				$cadenaSql .= "'" . $variable ['url'] . "', ";
				$cadenaSql .= "'" . $variable ['hash'] . "', ";
				$cadenaSql .= "'" . $variable ['tamano'] . "', ";
				$cadenaSql .= "'" . $variable ['nombre'] . "', ";
				$cadenaSql .= "'" . $variable ['tipo'] . "' ";
				$cadenaSql .= ") ";
				$cadenaSql .= " RETURNING dantp_dantp;";
				// var_dump ( $cadenaSql );
				break;
			
			// ////////////////////////////
			case "guardarRegistro" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.ant_teval ( ";
				$cadenaSql .= "eval_fcrea, ";
				$cadenaSql .= "eval_instancia, ";
				$cadenaSql .= "eval_dantp, ";
				$cadenaSql .= "eval_cpto_rta, ";
				$cadenaSql .= "eval_iteracion, ";
				$cadenaSql .= "eval_us_crea) ";
				$cadenaSql .= "VALUES ( ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['instancia'] . "', ";
				$cadenaSql .= "'" . $variable ['documento'] . "', ";
				$cadenaSql .= "'" . $variable ['concepto'] . "', ";
				$cadenaSql .= "'" . $variable ['iteracion'] . "', ";
				$cadenaSql .= "'" . $variable ['usuario'] . "' ";
				$cadenaSql .= ") ";
				//echo $cadenaSql;
				break;
			
			// ///////////////////////////////////////
			case 'registrarSolicitudes' :
				
				$fechaActual = date ( 'Y-m-d' );
				
				$cadenaSql = "INSERT INTO trabajosdegrado.ant_tslrev";
				$cadenaSql .= "(";
				$cadenaSql .= "slrev_fcrea,";
				$cadenaSql .= "slrev_fradi,";
				$cadenaSql .= "slrev_usua,";
				$cadenaSql .= "slrev_antp,";
				$cadenaSql .= "slrev_descri,";
				$cadenaSql .= "slrev_eslrev,";
				$cadenaSql .= "slrev_acta,";
				$cadenaSql .= "slrev_acta_fecha,";
				$cadenaSql .= "slrev_prof_asignado,";
				$cadenaSql .= "slrev_dantp";
				
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "(";
				$cadenaSql .= "'" . $fechaActual . "', ";
				$cadenaSql .= "'" . $fechaActual . "', ";
				$cadenaSql .= "'" . $_REQUEST ['usuario'] . "', ";
				$cadenaSql .= $_REQUEST ['anteproyecto'] . ", ";
				$cadenaSql .= "'" . $_REQUEST ['observaciones'] . "', ";
				$cadenaSql .= "'" . "ASIGNADA" . "', ";
				$cadenaSql .= $_REQUEST ['acta'] . ", ";
				$cadenaSql .= "'" . $_REQUEST ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['docente'] . "', ";
				$cadenaSql .= "'" . $variable ['documento'] . "' ";
				$cadenaSql .= ") ";
				$cadenaSql .= " RETURNING slrev_slrev;";
				// echo ($cadenaSql);
				break;
			
			// ////////////////////////////////
			case 'registrarHistorialAsignacion' :
				
				$cadenaSql = " INSERT INTO trabajosdegrado.ant_thantp ( ";
				$cadenaSql .= "hantp_antp, hantp_eantp, hantp_fasig, ";
				$cadenaSql .= "hantp_obser, hantp_usua) ";
				$cadenaSql .= " VALUES (";
				// anteproyecto: buscar valor de la secuencia actual
				$cadenaSql .= $_REQUEST ['anteproyecto'] . ", ";
				
				$cadenaSql .= "'REVISORES ASIGNADOS', ";
				$cadenaSql .= "'" . $_REQUEST ['fecha'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['observaciones'] . "', ";
				$cadenaSql .= " '" . $_REQUEST ['usuario'] . "' ";
				$cadenaSql .= ") ";
				// echo $cadenaSql;
				break;
			
			// //////////////////////
			case 'guardarHistorialSol' :
				
				$fechaActual = date ( 'Y-m-d' );
				$cadenaSql = "INSERT INTO trabajosdegrado.ant_thslrev";
				$cadenaSql .= "(";
				$cadenaSql .= "hslrev_slrev,";
				$cadenaSql .= "hslrev_eslrev,";
				$cadenaSql .= "hslrev_fasig,";
				$cadenaSql .= "hslrev_acta,";
				$cadenaSql .= "hslrev_acta_fecha,";
				$cadenaSql .= "hslrev_usua,";
				$cadenaSql .= "hslrev_obser";
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
				
				// echo ($cadenaSql);
				break;
			
			// /////////////
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
			
			/*
			 * case 'guardarVersion' :
			 * $cadenaSql = 'SELECT ';
			 * $cadenaSql .= 'h.hantp_fasig as FECHA,';
			 * $cadenaSql .= 'h.hantp_eantp as ESTADO, ';
			 * $cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS USUARIO, ";
			 * $cadenaSql .= 'h.hantp_obser as OBSERVACIONES ';
			 * $cadenaSql .= 'FROM ';
			 * $cadenaSql .= 'trabajosdegrado.ant_thantp h, ';
			 * $cadenaSql .= "public.polux_usuario u ";
			 * $cadenaSql .= 'WHERE ';
			 * $cadenaSql .= 'h.hantp_antp =' . $variable;
			 * $cadenaSql .= " and (h.hantp_usua=u.id_usuario)";
			 * //echo $cadenaSql;
			 * break;
			 */
			
			/*
			 * case 'buscarAnteproyectos' :
			 * $cadenaSql = 'SELECT ';
			 * $cadenaSql .= 'a.antp_fradi as FECHA, ';
			 * $cadenaSql .= 'a.antp_antp as ANTEPROYECTO, ';
			 * $cadenaSql .= 'm.moda_nombre as MODALIDAD, ';
			 * $cadenaSql .= 'a.antp_titu as TITULO, ';
			 * $cadenaSql .= 'a.antp_eantp as ESTADO ';
			 * $cadenaSql .= 'FROM ';
			 * $cadenaSql .= 'trabajosdegrado.ant_tantp a, ';
			 * $cadenaSql .= 'trabajosdegrado.ge_tmoda m ';
			 * $cadenaSql .= 'WHERE ';
			 * $cadenaSql .= "antp_eantp='RADICADO'";
			 * $cadenaSql .= "and a.antp_moda=m.moda_moda";
			 * // echo $cadenaSql;
			 * break;
			 */
			
			// /////////////////////////////////////////////////////
			case 'buscarAnteproyecto' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'a.antp_antp, ';
				$cadenaSql .= 'm.moda_nombre,';
				$cadenaSql .= 'a.antp_pcur,';
				$cadenaSql .= 'a.antp_titu,';
				$cadenaSql .= 'a.antp_fradi, ';
				$cadenaSql .= 'a.antp_obser, ';
				$cadenaSql .= 'a.antp_eantp, ';
				$cadenaSql .= 'a.antp_dir_int, ';
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS  Nombre ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'public.polux_usuario u, ';
				$cadenaSql .= 'trabajosdegrado.ant_tantp a, ';
				$cadenaSql .= 'trabajosdegrado.ge_tmoda m ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'antp_antp =' . $_REQUEST ['anteproyecto'];
				$cadenaSql .= ' and a.antp_moda=m.moda_moda ';
				$cadenaSql .= 'and a.antp_dir_int::int=u.identificacion';
				// echo $cadenaSql;
				break;
			
			// /////////////////////////////////
			case 'buscarEvaluaciones' :
				
				$cadenaSql = 'SELECT distinct ';
				$cadenaSql .= 'eval_iteracion ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_teval, ';
				$cadenaSql .= 'trabajosdegrado.ant_tdantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'eval_dantp=dantp_dantp ';
				$cadenaSql .= 'and dantp_antp =' . $variable;
				
				// echo $cadenaSql;
				break;
			
			// ///////////////////////////////////////////////////
			case 'buscarTematicas' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acantp.acantp_acono as ACONO,';
				$cadenaSql .= 'acantp.acantp_antp as ANTEPROYECTO, ';
				$cadenaSql .= 'ac.acono_nom as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tacantp acantp, ';
				$cadenaSql .= 'trabajosdegrado.ge_tacono ac ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'acantp_antp =' . $_REQUEST ['anteproyecto'];
				$cadenaSql .= ' and ac.acono_acono=acantp.acantp_acono';
				// echo $cadenaSql;
				break;
			
			// ////////////////////////////////////
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
			
			// ///////////////////////////////////////////
			case 'buscarAutores' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'a.estantp_estd as ESTUDIANTE, ';
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS Nombre, ";
				$cadenaSql .= 'a.estantp_antp as ANTEPROYECTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_testantp a, ';
				$cadenaSql .= 'public.polux_usuario u, ';
				$cadenaSql .= 'trabajosdegrado.ge_testd e ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estantp_antp =' . $_REQUEST ['anteproyecto'];
				$cadenaSql .= ' and e.estd_us =u.id_usuario';
				$cadenaSql .= ' and a.estantp_estd=e.estd_estd';
				// echo $cadenaSql;
				break;
			
			// //////////////////////////////////
			case 'buscarRevisores' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "rev_prof ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_trev ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "rev_antp=" . $_REQUEST ['anteproyecto'];
				// echo $cadenaSql;
				break;
			
			// /////////////////////////////////////////////
			case 'buscarDocentes' :
				$cadenaSql = "SELECT DISTINCT ";
				$cadenaSql .= "d.prof_prof, ";
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS  Nombre, ";
				$cadenaSql .= "d.prof_us ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "public.polux_usuario u, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof d, ";
				$cadenaSql .= "trabajosdegrado.ge_tacpro acp ";
				
				$cadenaSql .= "WHERE ";
				
				$cadenaSql .= " (d.prof_us=u.id_usuario)";
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
				$cadenaSql .= "and (d.prof_tpvinc='Planta' ";
				$cadenaSql .= "or d.prof_tpvinc='TCO') ";
				// echo $cadenaSql;
				break;
			
			// /////////////////
			case "actualizarEstado" :
				$cadenaSql = " UPDATE trabajosdegrado.ant_tantp ";
				$cadenaSql .= " SET antp_eantp= 'REVISORES ASIGNADOS'";
				$cadenaSql .= " WHERE antp_antp='" . $_REQUEST ['anteproyecto'] . "' ";
				// echo $cadenaSql;
				break;
			
			// ////////////////////
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
			
			// ////////////////////////////////////////
			case "consultarVersiones" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "dantp_vers, dantp_nombre, dantp_url, dantp_falm ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp ";
				$cadenaSql .= "WHERE dantp_antp='" . $_REQUEST ['anteproyecto'] . "' ";
				// echo $cadenaSql;
				break;
			
			// ////////////////////////////////////
			case "consultarVersiones2" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "MAX(dantp_vers) ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp ";
				$cadenaSql .= "WHERE dantp_antp='" . $_REQUEST ['anteproyecto'] . "' ";
				// echo $cadenaSql;
				break;
			
			// ///////////////////////////////////////
			case "consultarRevisores" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "r.rev_fasig,p.prof_us, r.rev_prof, u.nombre || ' ' || u.apellido as Nombre ";
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
			
			/*
			 * case "solicitudesRevision" :
			 * $cadenaSql = "SELECT ";
			 * $cadenaSql .= "s.slrev_fcrea, ";
			 * $cadenaSql .= "p.prof_us, ";
			 * $cadenaSql .= "u.nombre || ' ' || u.apellido as Nombre, ";
			 * $cadenaSql .= "slrev_dantp ";
			 * $cadenaSql .= "FROM ";
			 * $cadenaSql .= "trabajosdegrado.ant_tslrev s, ";
			 * $cadenaSql .= "trabajosdegrado.ge_tprof p, ";
			 * $cadenaSql .= "public.polux_usuario u ";
			 * $cadenaSql .= "WHERE ";
			 * $cadenaSql .= "s.slrev_prof_asignado = p.prof_prof ";
			 * $cadenaSql .= "and p.prof_us = u.id_usuario ";
			 * $cadenaSql .= "and s.slrev_antp='" . $_REQUEST ['anteproyecto'] . "' ";
			 * //echo $cadenaSql;
			 * break;
			 */
			
			// /////////////////////////////////
			case "consultarSolicitudes" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "s.slrev_fcrea, ";
				$cadenaSql .= "s.slrev_fradi, ";
				$cadenaSql .= "s.slrev_usua, ";
				$cadenaSql .= "s.slrev_antp, ";
				$cadenaSql .= "s.slrev_descri, ";
				$cadenaSql .= "s.slrev_eslrev, ";
				$cadenaSql .= "s.slrev_acta, ";
				$cadenaSql .= "s.slrev_acta_fecha, ";
				$cadenaSql .= "u.nombre || ' ' || u.apellido as Nombre ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev s, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof p, ";
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "s.slrev_prof_asignado = p.prof_prof ";
				$cadenaSql .= "and p.prof_us = u.id_usuario ";
				$cadenaSql .= "and s.slrev_antp='" . $_REQUEST ['anteproyecto'] . "' ";
				// echo $cadenaSql;
				break;
			
			// /////////////////////////////////////
			case 'buscarRevisiones' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "e.eval_eval, ";
				$cadenaSql .= "e.eval_fcrea, ";
				$cadenaSql .= "e.eval_cpto_rta, ";
				$cadenaSql .= "d.dantp_antp, ";
				$cadenaSql .= "d.dantp_vers, ";
				$cadenaSql .= "e.eval_dantp, ";
				$cadenaSql .= "e.eval_iteracion ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_teval e, ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp d ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "e.eval_dantp = d.dantp_dantp ";
				$cadenaSql .= "and d.dantp_antp=" . $variable ['anteproyecto'] . " ";
				$cadenaSql .= "and e.eval_us_crea='" . $variable ['revisor'] . "' ";
				// documento
				$cadenaSql .= "and eval_dantp='" . $variable ['documento'] . "'";
				// echo $cadenaSql;
				break;
			
			// //////////////////////////////////////////////////
			case 'buscarRevisionesPrueba' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "e.eval_eval, ";
				$cadenaSql .= "e.eval_fcrea, ";
				$cadenaSql .= "e.eval_cpto_rta, ";
				$cadenaSql .= "d.dantp_antp, ";
				$cadenaSql .= "d.dantp_vers, ";
				$cadenaSql .= "d.dantp_dantp, ";
				$cadenaSql .= "s.slrev_fcrea, ";
				$cadenaSql .= "p.prof_us, u.nombre || ' ' || u.apellido as Nombre, ";
				$cadenaSql .= "slrev_dantp, ";
				$cadenaSql .= "e.eval_iteracion ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_teval e, ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp d, ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev s, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof p, ";
				$cadenaSql .= "public.polux_usuario u ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "e.eval_dantp = d.dantp_dantp ";
				$cadenaSql .= "and d.dantp_antp=" . $variable . " ";
				$cadenaSql .= "and e.eval_instancia = 'REVISOR' ";
				$cadenaSql .= "and s.slrev_antp=" . $variable . " ";
				$cadenaSql .= "and slrev_dantp = d.dantp_dantp ";
				$cadenaSql .= "and s.slrev_prof_asignado = p.prof_prof ";
				$cadenaSql .= "and p.prof_us = u.id_usuario ";
				$cadenaSql .= "and eval_us_crea=p.prof_us ";
				
				// echo $cadenaSql;
				
				break;
			
			// /////////////////////////////////////////////
			case 'buscarEvaluacionEstudiante' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "e.eval_eval, ";
				$cadenaSql .= "e.eval_fcrea, ";
				$cadenaSql .= "e.eval_cpto_rta, ";
				$cadenaSql .= "d.dantp_antp, ";
				$cadenaSql .= "d.dantp_vers, ";
				$cadenaSql .= "d.dantp_dantp, ";
				$cadenaSql .= "s.slrev_fcrea, ";
				$cadenaSql .= "e.eval_iteracion, ";
				$cadenaSql .= "est.estd_estd ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_teval e, ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp d, ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev s, ";
				$cadenaSql .= "public.polux_usuario u, ";
				$cadenaSql .= "trabajosdegrado.ge_testd est ";
				
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "e.eval_dantp =" . $variable . " ";
				$cadenaSql .= "and e.eval_dantp = d.dantp_dantp ";
				$cadenaSql .= "and e.eval_instancia = 'ESTUDIANTE' ";
				$cadenaSql .= "and s.slrev_antp=" . $_REQUEST ['anteproyecto'] . " ";
				$cadenaSql .= "and slrev_dantp = d.dantp_dantp ";
				$cadenaSql .= "and e.eval_us_crea = u.id_usuario ";
				$cadenaSql .= "and u.id_usuario=est.estd_us ";
				
				// echo $cadenaSql;
				
				break;
			
			// ////////////////////////////////////////////
			case 'buscarEvaluacionRevisor' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "e.eval_eval, ";
				$cadenaSql .= "e.eval_fcrea, ";
				$cadenaSql .= "e.eval_cpto_rta, ";
				$cadenaSql .= "d.dantp_antp, ";
				$cadenaSql .= "d.dantp_vers, ";
				$cadenaSql .= "d.dantp_dantp, ";
				$cadenaSql .= "s.slrev_fcrea, ";
				$cadenaSql .= "e.eval_iteracion, ";
				$cadenaSql .= "p.prof_us, u.nombre || ' ' || u.apellido as Nombre ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_teval e, ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp d, ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev s, ";
				$cadenaSql .= "public.polux_usuario u, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof p ";
				
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "e.eval_dantp =" . $variable . " ";
				$cadenaSql .= "and e.eval_dantp = d.dantp_dantp ";
				$cadenaSql .= "and e.eval_instancia = 'REVISOR' ";
				$cadenaSql .= "and s.slrev_antp=" . $_REQUEST ['anteproyecto'] . " ";
				$cadenaSql .= "and slrev_dantp = d.dantp_dantp ";
				$cadenaSql .= "and e.eval_us_crea = u.id_usuario ";
				$cadenaSql .= "and u.id_usuario=p.prof_us ";
				
				// echo $cadenaSql;
				
				break;
			
			// /////////////////////////////
			case 'buscarDocumento' :
				$cadenaSql = 'SELECT MAX(dantp_dantp) as documento, dantp_vers  FROM trabajosdegrado.ant_tdantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dantp_antp=\'' . $variable . '\' ';
				$cadenaSql .= 'group by dantp_vers ';
				$cadenaSql .= 'order by documento DESC ';
				// var_dump ( $cadenaSql );
				break;
			
			/*
			 * case 'buscarDocumentoConVersion' :
			 * $cadenaSql = 'SELECT dantp_dantp FROM trabajosdegrado.ant_tdantp ';
			 * $cadenaSql .= 'WHERE ';
			 * $cadenaSql .= 'dantp_antp=\'' . $_REQUEST ['anteproyecto'] . '\' ';
			 * $cadenaSql .= ' and dantp_vers=\'' . $variable . '\' ';
			 * // var_dump ( $cadenaSql );
			 * break;
			 *
			 *
			 * case 'buscarVersionDoc' :
			 * $cadenaSql = 'SELECT dantp_vers FROM trabajosdegrado.ant_tdantp ';
			 * $cadenaSql .= 'WHERE ';
			 * $cadenaSql .= 'dantp_dantp=\'' . $variable . '\' ';
			 * // var_dump ( $cadenaSql );
			 * break;
			 *
			 *
			 * case "actualizarEstadoProyecto" :
			 * $cadenaSql = " UPDATE trabajosdegrado.ant_tantp ";
			 * $cadenaSql .= " SET antp_eantp= 'PROYECTO'";
			 * $cadenaSql .= " WHERE antp_antp='" . $_REQUEST ['anteproyecto'] . "' ";
			 * // echo $cadenaSql;
			 * break;
			 */
			
			// ///////////////////////////////
			case 'buscarPreguntas' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "preg_preg, ";
				$cadenaSql .= "preg_pregunta ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tpreg; ";
				break;
			
			// /////////////////////////////
			case 'guardarSolicitud' :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev ";
				$cadenaSql .= "(slrev_fcrea, ";
				$cadenaSql .= "slrev_fradi, ";
				$cadenaSql .= "slrev_usua, ";
				$cadenaSql .= "slrev_antp, ";
				$cadenaSql .= "slrev_descri, ";
				$cadenaSql .= "slrev_eslrev, ";
				$cadenaSql .= "slrev_prof_asignado, ";
				$cadenaSql .= "slrev_dantp) ";
				
				$cadenaSql .= "VALUES (";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['usuario'] . "', ";
				$cadenaSql .= "'" . $variable ['anteproyecto'] . "',";
				$cadenaSql .= "'" . $variable ['pregunta1'] . "', ";
				$cadenaSql .= "'" . $variable ['estado'] . "', ";
				$cadenaSql .= "'" . $variable ['revisor'] . "', ";
				$cadenaSql .= "'" . $variable ['documento'] . "')";
				// echo ($cadenaSql);
				break;
			
			// ////////////////////
			case 'buscarCodigo' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "estd_estd ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_testd ";
				$cadenaSql .= "WHERE estd_us='" . $variable . "' ";
				break;
			
			// //////////////////////////////////////////
			// solicitudes que esten asignadas
			case 'buscarSolicitudesRev' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "slrev_slrev, ";
				$cadenaSql .= "slrev_fcrea, ";
				$cadenaSql .= "slrev_usua, ";
				$cadenaSql .= "slrev_eslrev ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev ";
				$cadenaSql .= "WHERE slrev_usua='" . $variable . "' ";
				$cadenaSql .= "AND slrev_eslrev='" . "ASIGNADA" . "' ";
				// echo $cadenaSql;
				break;
			
			// ////////////////////////////
			case 'buscarDocumento2' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "dantp_dantp ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp ";
				$cadenaSql .= "WHERE dantp_antp='" . $variable ['anteproyecto'] . "' ";
				$cadenaSql .= "and dantp_vers='" . $variable ['version'] . "' ";
				//echo $cadenaSql;
				break;
			
			case 'buscarVersion' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "dantp_vers ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp ";
				$cadenaSql .= "WHERE dantp_dantp='" . $variable . "' ";
				
				// echo $cadenaSql;
				break;
	
				
			// /////////////////////////
			case 'buscarSolicitudesRev2' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "MAX(slrev_slrev) ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "slrev_eslrev=" . "'ACEPTADA' ";
				$cadenaSql .= "and slrev_antp='" . $_REQUEST ['anteproyecto'] . "' ";
				
				// echo $cadenaSql;
				break;
			
			case 'buscarSolicitudesRev3' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "slrev_slrev ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "slrev_eslrev=" . "'ASIGNADA' ";
				$cadenaSql .= "and slrev_antp=" . $_REQUEST ['anteproyecto'] . " ";
				
				// echo $cadenaSql;
				break;
			
			// ///////////////////////////////
			case 'buscarSolicitudes' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "MAX(slrev_slrev) ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "slrev_antp=" . $_REQUEST ['anteproyecto'] . " ";
				
				// echo $cadenaSql;
				break;
			
			// //////////////////////////////////////////
			case 'buscarDocumentoSolicitud' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "slrev_dantp ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "slrev_slrev='" . $variable . "' ";
				//echo $cadenaSql;
				break;
			
			// //////////////////////////////////
			case 'buscarModificaciones' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "eval_us_crea, ";
				$cadenaSql .= "eval_cpto_rta, ";
				$cadenaSql .= "eval_fcrea ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_teval, ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "eval_instancia='ESTUDIANTE' ";
				$cadenaSql .= "and eval_iteracion=" . $variable . " ";
				$cadenaSql .= "and dantp_antp=" . $_REQUEST ['anteproyecto'] . " ";
				$cadenaSql .= "and eval_dantp=dantp_dantp ";
				// echo $cadenaSql;
				break;
			
			/*
			 * case 'buscarConceptosSolicitudes' :
			 * $cadenaSql = "SELECT ";
			 * $cadenaSql .= "slrev_slrev ";
			 * $cadenaSql .= "FROM ";
			 * $cadenaSql .= "trabajosdegrado.ant_tslrev ";
			 * $cadenaSql .= "WHERE ";
			 * $cadenaSql .= "slrev_antp='" . $_REQUEST ['anteproyecto'] . "' ";
			 *
			 * // echo $cadenaSql;
			 * break;
			 */
			// ///////////////////////////
			case 'buscarUltimaVersion' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "max(dantp_vers) ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "dantp_antp='" . $_REQUEST ['anteproyecto'] . "' ";
				
				// echo $cadenaSql;
				break;
			
			// //////////////////////////////
			case 'buscarDocumento3' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "dantp_dantp ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_tdantp ";
				$cadenaSql .= "WHERE dantp_antp='" . $_REQUEST ['anteproyecto'] . "' ";
				
				// echo $cadenaSql;
				break;
			
			// ////////////////////////////////////////
			case 'ultimaIteracion' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "MAX(eval_iteracion) ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ant_teval, ";
				$cadenaSql .= "trabajosdegrado.ant_tslrev ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "slrev_antp=" . $_REQUEST ['anteproyecto'] . " ";
				$cadenaSql .= "and eval_dantp=slrev_dantp ";
				// echo $cadenaSql;
				break;
		}
		
		return $cadenaSql;
	}
}
?>
