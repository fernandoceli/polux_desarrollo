<?php

namespace proyecto\consultaEvaluacionProyecto;

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
			case 'registrarEvaluacion' :
				$fecha = date ( 'Y-m-d' );
				
				$cadenaSql = "INSERT INTO trabajosdegrado.ant_teval";
				$cadenaSql .= "(";
				$cadenaSql .= "eval_fcrea,";
				$cadenaSql .= "eval_instancia,";
				$cadenaSql .= "eval_dantp,";
				$cadenaSql .= "eval_cpto_rta,";
				$cadenaSql .= "eval_iteracion,";
				$cadenaSql .= "eval_us_crea";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "(";
				$cadenaSql .= "'" . $fecha . "', ";
				$cadenaSql .= "'REVISOR', ";
				// Documento a evaluar
				$cadenaSql .= $variable ['documento'] . ", ";
				// Concepto
				$cadenaSql .= "'" . $variable ['concepto'] . "', ";
				// Iteraci�n
				$cadenaSql .= "'" . 1 . "', ";
				$cadenaSql .= "(Select prof_prof from trabajosdegrado.ge_tprof where prof_us='" . $variable ['usuario'] . "' )";
				$cadenaSql .= ") ";
				$cadenaSql .= " RETURNING eval_eval;";
				echo ($cadenaSql);
				break;
			
			case 'registrarRespuestas' :
				$cadenaSql = "INSERT INTO trabajosdegrado.ant_trevision";
				$cadenaSql .= "(";
				$cadenaSql .= "revision_eval,";
				$cadenaSql .= "revision_preg,";
				$cadenaSql .= "revision_orta,";
				$cadenaSql .= "revision_justif";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "(";
				
				$cadenaSql .= $variable ['evaluacion'] . ", ";
				$cadenaSql .= $variable ['pregunta'] . ", ";
				$cadenaSql .= $variable ['opcion'] . ", ";
				$cadenaSql .= "'" . $variable ['justificacion'] . "' ";
				
				$cadenaSql .= ") ";
				echo ($cadenaSql);
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
			
			case 'buscarTematicas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acproy_acono as ACONO, ';
				$cadenaSql .= 'acproy_proy as PROYECTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tacproy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'acproy_proy =' . $variable;
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
			
			case 'buscarProyecto' :
				
				$cadenaSql = 'SELECT ';
				
				$cadenaSql .= 'p.proy_proy, ';
				$cadenaSql .= 'p.proy_antp, ';
				$cadenaSql .= 'm.moda_nombre, ';
				$cadenaSql .= 'p.proy_pcur, ';
				$cadenaSql .= 'p.proy_titu, ';
				
				$cadenaSql .= 'p.proy_fcrea, ';
				$cadenaSql .= 'p.proy_descri, ';
				$cadenaSql .= 'p.proy_obser, ';
				$cadenaSql .= 'p.proy_eproy, ';
				$cadenaSql .= 'p.proy_duracion, ';
				$cadenaSql .= 'p.proy_dir_int ';
				
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tproy p,  ';
				$cadenaSql .= 'trabajosdegrado.ge_tmoda m ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'p.proy_proy =' . $_REQUEST ['proyecto'];
				$cadenaSql .= " and p.proy_moda=m.moda_moda";
				// echo $cadenaSql;
				break;
			
			case 'buscarConceptos' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "cpto_cpto, ";
				$cadenaSql .= "cpto_cpto, ";
				$cadenaSql .= "cpto_descri ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tcpto ';
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "cpto_instancia='REVISOR'";
				// echo $cadenaSql;
				break;
			
			case 'buscarDocumento' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "dantp_dantp ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tdantp ';
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "dantp_antp=" . $_REQUEST ['ante'];
				echo $cadenaSql;
				break;
			
			case 'buscarPreguntas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "preg_preg, ";
				$cadenaSql .= "preg_pregunta ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tpreg ';
				break;
			
			case 'opcionesRespuestas1' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "orta_orta, ";
				$cadenaSql .= "orta_opcion ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_torta ';
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "orta_orta=1 or orta_orta=2 or orta_orta=3";
				break;
			
			case 'opcionesRespuestas2' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "orta_orta, ";
				$cadenaSql .= "orta_opcion ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_torta ';
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "orta_orta=3 or orta_orta=4 or orta_orta=5 or orta_orta=6";
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
			
			case 'buscarRevision' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "r.revision_eval, ";
				$cadenaSql .= "p.preg_pregunta, ";
				$cadenaSql .= "r.revision_justif, ";
				$cadenaSql .= "eval_dproy, ";
				$cadenaSql .= "dproy_vers ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.pry_trevision r, ";
				$cadenaSql .= "trabajosdegrado.pry_tpreg p, ";
				$cadenaSql .= "trabajosdegrado.pry_teval, ";
				$cadenaSql .= "trabajosdegrado.pry_tdproy ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "revision_eval=" . $_REQUEST ['revision'];
				$cadenaSql .= " and p.preg_preg=r.revision_preg";
				$cadenaSql .= " and eval_eval=r.revision_eval";
				$cadenaSql .= " and dproy_dproy=eval_dproy";
			//	echo $cadenaSql;
				break;
			
			
			case 'buscarDescripcion' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "cpto_descri ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.pry_tcpto ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "cpto_cpto='" . $_REQUEST ['concepto'] . "'";
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
			
			case "consultarVersiones" :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "dproy_vers, dproy_nombre, dproy_url, dproy_falm ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.pry_tdproy ";
				$cadenaSql .= "WHERE dproy_proy=" . $variable . " ";
				
				break;
		}
		
		return $cadenaSql;
	}
}
?>
