<?php

namespace general\crearProgramaCurricular;

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
			case 'insertar' :
				$cadenaSql = 'INSERT INTO trabajosdegrado.ge_tpcur';
				$cadenaSql .= '(';
				$cadenaSql .= 'pcur_pcur,';
				$cadenaSql .= 'pcur_nom,';
				$cadenaSql .= 'pcur_facu,';
				$cadenaSql .= 'pcur_dir,';
				$cadenaSql .= 'pcur_tel,';
				$cadenaSql .= 'pcur_mail,';
				$cadenaSql .= 'pcur_descri';
				$cadenaSql .= ')';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '(' . $_REQUEST ['codigoProgramaCurricular'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['nombreProgramaCurricular'] . '\', ';
				$cadenaSql .= '' . $_REQUEST ['seleccionar'].', ';
				$cadenaSql .= '\'' . $_REQUEST ['direccionProgramaCurricular'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['telefonoProgramaCurricular'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['emailProgramaCurricular'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionProgramaCurricular'] . '\'';
				$cadenaSql .= ') ';
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
			
			case 'buscarFacultades' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'facu_facu as CODIGO, ';
				$cadenaSql .= 'facu_nom as NOMBRE, ';
				$cadenaSql .= 'facu_descri as DESCRIPCION ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tfacu';
				break;
			
			case 'borrarRegistro' :
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
			
			case 'obtenerFacultad' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'facu_facu as CODIGO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tfacu ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'facu_nom=\'' . $_REQUEST ['seleccionar'] . '\' ';
				// echo $cadenaSql;
				break;
		}
		
		return $cadenaSql;
	}
}
?>
