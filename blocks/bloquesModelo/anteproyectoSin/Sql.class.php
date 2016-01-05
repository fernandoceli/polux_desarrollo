<?php

namespace bloquesModelo\anteproyectoSin;

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
				// $fechaNueva = date ( 'Y-m-d' );
				// $descripcion = "descripcion";
				
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
				$cadenaSql .= 'antp_fradi as FECHA, ';
				$cadenaSql .= 'antp_antp as ANTEPROYECTO, ';
				$cadenaSql .= 'moda_nombre as MODALIDAD, ';
				$cadenaSql .= 'antp_titu as TITULO, ';
				$cadenaSql .= 'antp_eantp as ESTADO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_testantp ';
				$cadenaSql .= 'JOIN trabajosdegrado.ge_testd ';
				$cadenaSql .= 'ON estantp_estd = estd_estd ';
				$cadenaSql .= 'JOIN trabajosdegrado.ant_tantp ';
				$cadenaSql .= 'ON estantp_antp = antp_antp ';
				$cadenaSql .= 'JOIN trabajosdegrado.ge_tmoda ';
				$cadenaSql .= 'ON antp_moda = moda_moda ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "antp_eantp='RADICADO'";
				//echo $cadenaSql;
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
				$cadenaSql .= 'antp_antp =' . $_REQUEST ['id'];
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
				$cadenaSql .= 'acantp_antp =' . $_REQUEST ['id'];
				// echo $cadenaSql;
				break;
			
			case 'buscarAutores' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'estantp_estd as ESTUDIANTE,';
				$cadenaSql .= 'estantp_antp as ANTEPROYECTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_testantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estantp_antp =' . $_REQUEST ['id'];
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
				$cadenaSql .= "acono_acono, ";
				$cadenaSql .= "acono_nom AS  Nombre ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_tacono ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "acono_acono='" . $variable . "' ";
				// echo $cadenaSql;
				break;
			
			case 'buscarNombresAutores' :
				$cadenaSql = "SELECT ";
				$cadenaSql .= "e.estd_estd, ";
				$cadenaSql .= "(p.pern_nomb || ' ' ||p.pern_papell || ' ' ||p.pern_sapell) AS  Nombre, ";
				$cadenaSql .= "e.estd_pern ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_testd e, ";
				$cadenaSql .= "trabajosdegrado.ge_tpern p ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "e.estd_estd='" . $variable . "'";
				$cadenaSql .= "and e.estd_pern=p.pern_pern";
				// echo $cadenaSql;
				break;
			
			case 'buscarNombresDirector' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "d.prof_prof, ";
				$cadenaSql .= "(p.pern_nomb || ' ' ||p.pern_papell || ' ' ||p.pern_sapell) AS  Nombre, ";
				$cadenaSql .= "d.prof_pern ";
				
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_tprof d, ";
				$cadenaSql .= "trabajosdegrado.ge_tpern p ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "d.prof_prof='" . $variable . "'";
				$cadenaSql .= "and (d.prof_pern=p.pern_pern)";
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
			
			
			case "actualizarEstado" :
				$cadenaSql = " UPDATE trabajosdegrado.ant_tantp ";
				$cadenaSql .= " SET antp_eantp= 'REVISORES ASIGNADOS'";
				$cadenaSql .= " WHERE antp_antp='" . $_REQUEST ['anteproyecto'] . "' ";
				//echo $cadenaSql;
				break;
		}
		
		return $cadenaSql;
	}
}
?>
