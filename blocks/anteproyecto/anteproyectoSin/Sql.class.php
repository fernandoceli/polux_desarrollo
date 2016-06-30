<?php

namespace anteproyecto\anteproyectoSin;

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
		
			case 'buscarAnteproyectos' :
				$cadenaSql = 'SELECT DISTINCT ';
				$cadenaSql .= 'a.antp_fradi as FECHA, ';
				$cadenaSql .= 'a.antp_antp as ANTEPROYECTO, ';
				$cadenaSql .= 'm.moda_nombre as MODALIDAD, ';
				$cadenaSql .= 'a.antp_titu as TITULO, ';
				$cadenaSql .= 'a.antp_eantp as ESTADO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tantp a, ';
				$cadenaSql .= 'trabajosdegrado.ge_tmoda m ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= "a.antp_eantp='RADICADO' ";
				$cadenaSql .= "AND a.antp_moda=m.moda_moda ";
				$cadenaSql .= "ORDER BY a.antp_antp";
 				//echo $cadenaSql;
				break;
				
		}
		return $cadenaSql;
	}
}
?>
