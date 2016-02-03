<?php

namespace bloquesModelo\evaluacionProyecto;

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
			 * Clausulas especÃ­ficas
			 */
			
			case 'registrarEvaluacion' :
				$fecha = date ( 'Y-m-d' );
				
				$cadenaSql = "INSERT INTO trabajosdegrado.pry_teval";
				$cadenaSql .= "(";
				$cadenaSql .= "eval_fcrea,";
				$cadenaSql .= "eval_instancia,";
				$cadenaSql .= "eval_dproy,";
				$cadenaSql .= "eval_cpto_rta,";
				$cadenaSql .= "eval_iteracion,";
				$cadenaSql .= "eval_usua_crea,";
				$cadenaSql .= "eval_proy";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "(";
				$cadenaSql .= "'" . $fecha . "', ";
				$cadenaSql .= "'REVISOR', ";
				// Documento a evaluar
				$cadenaSql .= $variable ['documento'] . ", ";
				// Concepto
				$cadenaSql .= "'" . $variable ['concepto'] . "', ";
				// Iteración
				$cadenaSql .= "'" . 1 . "', ";
				$cadenaSql .= "(Select prof_prof from trabajosdegrado.ge_tprof where prof_us='" . $variable ['usuario'] . "' ),";
				$cadenaSql .= $variable ['proyecto'];
				$cadenaSql .= ") ";
				$cadenaSql .= " RETURNING eval_eval;";
				echo ($cadenaSql);
				break;
			
			case 'registrarRespuestas' :
				$cadenaSql = "INSERT INTO trabajosdegrado.pry_trevision";
				$cadenaSql .= "(";
				$cadenaSql .= "revision_eval,";
				$cadenaSql .= "revision_preg,";
				$cadenaSql .= "revision_justif";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "(";
				$cadenaSql .= $variable ['evaluacion'] . ", ";
				$cadenaSql .= $variable ['pregunta'] . ", ";
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
			
			case 'buscarProyecto' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'p.proy_proy, ';
				$cadenaSql .= 'p.proy_titu, ';
				$cadenaSql .= 'p.proy_descri ';
				
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tproy p ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "p.proy_proy = " . $variable . " ";
				// echo $cadenaSql;
				break;
			
			case 'buscarAutores' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'p.estproy_estd as ESTUDIANTE, ';
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS Nombre, ";
				$cadenaSql .= 'p.estproy_proy as PROYECTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_testpry p, ';
				$cadenaSql .= 'public.polux_usuario u, ';
				$cadenaSql .= 'trabajosdegrado.ge_testd e ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'p.estproy_proy =' . $variable;
				$cadenaSql .= ' and e.estd_us =u.id_usuario';
				$cadenaSql .= ' and p.estproy_estd=e.estd_estd';
				// echo $cadenaSql;
				break;
			
			case 'buscarConceptos' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "cpto_cpto, ";
				$cadenaSql .= "cpto_cpto, ";
				$cadenaSql .= "cpto_descri ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tcpto ';
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "cpto_instancia='DIRECTOR'";
				// echo $cadenaSql;
				break;
			
			case 'buscarDocumento' :
				var_dump ( $_REQUEST );
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "dproy_dproy ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tdproy ';
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "dproy_proy=" . $_REQUEST ['proyecto'];
				// echo $cadenaSql;
				break;
			
			case 'buscarPreguntas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= "preg_preg, ";
				$cadenaSql .= "preg_pregunta ";
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tpreg ';
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
			
			case "cambiarEstadoSolicitud" :
				$cadenaSql = " UPDATE trabajosdegrado.pry_tsrdp ";
				$cadenaSql .= " SET srdp_esrdp= 'ACEPTADA'";
				$cadenaSql .= " WHERE srdp_proy='" . $_REQUEST ['proyecto'] . "' ";
				// echo $cadenaSql;
				break;
			
			case 'buscarDocumento2' :
				$cadenaSql = 'SELECT MAX(dproy_dproy) FROM trabajosdegrado.pry_tdproy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dproy_proy=\'' . $variable . '\' ';
				//echo $cadenaSql;
				break;
			
			case 'buscarVersionDoc' :
				$cadenaSql = 'SELECT dproy_vers FROM trabajosdegrado.pry_tdproy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dproy_dproy=\'' . $variable . '\' ';
				//echo $cadenaSql;
				break;
		}
		
		return $cadenaSql;
	}
}
?>
