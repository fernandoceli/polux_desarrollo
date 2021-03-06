<?php

namespace bloquesModelo\crearFacultad;

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
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
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
				$cadenaSql = 'INSERT INTO trabajosdegrado.ge_tfacu';
				$cadenaSql .= '(';
				$cadenaSql .= 'facu_nom,';
				$cadenaSql .= 'facu_dir,';
				$cadenaSql .= 'facu_tel,';
				$cadenaSql .= 'facu_mail,';
				$cadenaSql .= 'facu_descri';
				$cadenaSql .= ')';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '(';
				$cadenaSql .= '\'' . $_REQUEST ['nombreFacultad'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['direccionFacultad'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['telefonoFacultad'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['emailFacultad'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionFacultad'] . '\'';
				$cadenaSql .= ') ';
				//echo $cadenaSql;
				
				break;
			
			case 'buscarUsuario' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_usuario as CC, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'telefono as TELEFONO, ';
				$cadenaSql .= 'email as EMAIL, ';
				$cadenaSql .= 'genero as GENERO, ';
				$cadenaSql .= 'fecha_registro as FECHA ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'udlearn.usuario ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_usuario=\'' . $_REQUEST ['user'] . '\' ';
				$cadenaSql .= 'and clave=\'' . $_REQUEST ['pass'] . '\' ';
				// echo $cadenaSql;
				break;
		}
		
		return $cadenaSql;
	}
}
?>
