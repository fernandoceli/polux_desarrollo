<?php

namespace bloquesModelo\consultaInformeFinal;

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
				$revisores = $_REQUEST ['revisores'];
				var_dump ( $revisores );
				$porciones = explode ( ";", $revisores );
				var_dump ( $porciones );
				var_dump ( $_REQUEST ['numJurados'] );
				for($i = 0; $i < $_REQUEST ['numJurados']; $i ++) {
					
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
				
				$cadenaSql .= 'info_info, ';
				$cadenaSql .= 'info_proy, ';
				$cadenaSql .= 'moda_nombre, ';
				$cadenaSql .= 'info_pcur, ';
				$cadenaSql .= 'info_titu, ';
				
				$cadenaSql .= 'info_fcrea, ';
				$cadenaSql .= 'info_descri, ';
				$cadenaSql .= 'info_obser, ';
				$cadenaSql .= 'info_einfo, ';
				
				$cadenaSql .= 'info_dir_int ';
				
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tinfo ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.ge_tmoda ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'info_moda=moda_moda ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'info_info =' . $variable;
				
				// $cadenaSql .= 'estado=\'RADICADO\' OR estado=\'ASIGNADO REVISORES\'';
				// $cadenaSql .= 'nombre=\'' . $_REQUEST ['nombrePagina'] . '\' ';
				// echo $cadenaSql;
				break;
			
			case 'buscarTematicas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acono_acono, ';
				$cadenaSql .= 'acono_nom ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tacinfo ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.ge_tacono ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'acinfo_acono=acono_acono ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'acinfo_info =' . $variable;
				// echo $cadenaSql;
				break;
			
			case 'buscarTematicasInforme' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acinfo_acono ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tinfo ';
				$cadenaSql .= 'JOIN trabajosdegrado.inf_tacinfo ';
				$cadenaSql .= 'ON acinfo_info=info_info ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'info_info =' . $variable;
// 				echo $cadenaSql;
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
				$cadenaSql .= "dinfo_vers, dinfo_nombre, dinfo_url, dinfo_falm ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.inf_tdinfo ";
				$cadenaSql .= "WHERE dinfo_info='" . $variable . "' ";
				
				$cadenaSql .= "ORDER BY dinfo_vers DESC";
				// echo $cadenaSql;
				break;
			
			case 'documentoAnexo' :
				$cadenaSql = "SELECT ";
				
				$cadenaSql .= "tdain_descri, ";
				$cadenaSql .= "dain_url, ";
				$cadenaSql .= "dain_nombre ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.inf_tdain ";
				
				$cadenaSql .= "JOIN ";
				$cadenaSql .= "trabajosdegrado.inf_ttdain ";
				$cadenaSql .= "ON ";
				$cadenaSql .= "dain_tdain=tdain_tdain ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "dain_info='" . $variable . "';";
				// echo $cadenaSql;x
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
				$cadenaSql .= "dproy_vers ";
				$cadenaSql .= "FROM trabajosdegrado.pry_tdproy ";
				$cadenaSql .= "ORDER BY dproy_vers DESC; ";
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
				$cadenaSql .= "srdp_proy) ";
				$cadenaSql .= "VALUES (";
				$cadenaSql .= "'" . $variable ['estado'] . "', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['pregunta1'] . "', ";
				$cadenaSql .= "'" . $variable ['estudiante'] . "', ";
				$cadenaSql .= "'" . $variable ['proyecto'] . "')";
				break;
			
			case 'buscarCodigo' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "estd_estd ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_testd ";
				$cadenaSql .= "WHERE estd_us='" . $variable . "' ";
				break;
			
			case 'buscarDocenteParaJurado' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "prof_prof, ";
				$cadenaSql .= "nombre || ' ' || apellido AS docente ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_tprof ";
				$cadenaSql .= "JOIN polux_usuario ";
				$cadenaSql .= "ON prof_us=id_usuario ";
				$cadenaSql .= "JOIN trabajosdegrado.ge_tacpro ";
				$cadenaSql .= "ON acpro_prof=prof_prof ";
				$cadenaSql .= "WHERE prof_prof<>'" . $variable ['director'] . "' ";
				for($i = 0; $i < count ( $variable ['tematicas'] ); $i ++) {
					if ($i == 0) {
						$cadenaSql .= "AND ";
					} else {
						$cadenaSql .= "OR ";
					}
					$cadenaSql .= "acpro_acono=" . $variable ['tematicas'][0][$i] . " ";
				}
// 				echo $cadenaSql;
				break;
			
			case 'bucarDirector' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "info_dir_int ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.inf_tinfo ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "info_info=" . $variable;
				break;
		}
		
		return $cadenaSql;
	}
}
?>
