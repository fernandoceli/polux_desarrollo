<?php

namespace informeFinal\evaluacionInforme;

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
				
				$cadenaSql = "INSERT INTO trabajosdegrado.inf_teval";
				$cadenaSql .= "(";
				$cadenaSql .= "eval_fcrea,";
				$cadenaSql .= "eval_instancia,";
				$cadenaSql .= "eval_dinfo,";
				$cadenaSql .= "eval_cpto_rta,";
				$cadenaSql .= "eval_iteracion,";
				$cadenaSql .= "eval_usua_crea,";
				$cadenaSql .= "eval_info";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "(";
				$cadenaSql .= "'" . $fecha . "', ";
				$cadenaSql .= "'JURADO', ";
				// Documento a evaluar
				$cadenaSql .= $variable ['documento'] . ", ";
				// Concepto
				$cadenaSql .= "'" . $variable ['concepto'] . "', ";
				// Iteraci�n
				$cadenaSql .= "'" . 1 . "', ";
				$cadenaSql .= "'" . $variable ['usuario'] . "', ";
				$cadenaSql .= $_REQUEST ['informe'] . " ";
				$cadenaSql .= ") ";
				$cadenaSql .= " RETURNING eval_eval;";
				echo ($cadenaSql);
				break;
			
			case 'registrarRespuestas' :
				$cadenaSql = "INSERT INTO trabajosdegrado.inf_trevision";
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
			
			case 'buscarConceptos' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "cpto_cpto, ";
				$cadenaSql .= "cpto_cpto, ";
				$cadenaSql .= "cpto_descri ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tcpto ';
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "cpto_instancia='JURADO'";
				// echo $cadenaSql;
				break;
			
			case 'buscarDocumento' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "dinfo_dinfo ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tdinfo ';
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "dinfo_info=" . $_REQUEST ['informe'];
				echo $cadenaSql;
				break;
			
			case 'buscarPreguntas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "preg_preg, ";
				$cadenaSql .= "preg_pregunta ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.inf_tpreg ';
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
			
			case 'buscarCod' :
				$cadenaSql = "SELECT identificacion ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "polux_usuario ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= 'id_usuario=\'' . $variable . '\' ';
				// echo $cadenaSql;
				break;
			
			case "actualizarEstadoSolicitud" :
				$cadenaSql = " UPDATE trabajosdegrado.inf_tsljur ";
				$cadenaSql .= " SET sljur_esljur = 'ACEPTADA'";
				$cadenaSql .= " WHERE sljur_info=" . $_REQUEST ['informe'] . " ";
				$cadenaSql .= " and sljur_prof_asignado ='" . $variable . "' ";
				
				// echo $cadenaSql;
				break;
			
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
				$cadenaSql .= "'" . "ACEPTADA" . "', ";
				$cadenaSql .= "'" . $fechaActual . "', ";
				$cadenaSql .= $_REQUEST ['acta'] . ", ";
				$cadenaSql .= "'" . $_REQUEST ['fecha'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['usuario'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['observaciones'] . "' ";
				$cadenaSql .= "); ";
				
				echo ($cadenaSql);
				break;
		}
		
		return $cadenaSql;
	}
}
?>
