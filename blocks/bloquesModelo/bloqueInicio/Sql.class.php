<?php

namespace bloquesModelo\bloqueInicio;

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
			case 'insertarRegistro' :
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
				$cadenaSql .= 'nombre as NOMBRE ';
				// $cadenaSql .= 'descripcion as DESCRIPCION,';
				// $cadenaSql .= 'modulo as MODULO,';
				// $cadenaSql .= 'nivel as NIVEL,';
				// $cadenaSql .= 'parametro as PARAMETRO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= $prefijo . 'pagina ';
				// $cadenaSql .= 'WHERE ';
				// $cadenaSql .= 'nombre=\'' . $_REQUEST ['nombrePagina'] . '\' ';
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
				$cadenaSql .= 'id_usuario as ID, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'telefono as TELEFONO, ';
				$cadenaSql .= 'email as CORREO, ';
				$cadenaSql .= 'genero as GENERO, ';
				$cadenaSql .= 'fecha_registro as FECHA, ';
				$cadenaSql .= 'clave as CLAVE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.usuario ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_usuario=\'' . $_REQUEST ['usuario'] . '\' ';
				$cadenaSql .= 'AND clave=\'' . $_REQUEST ['clave'] . '\' ';
				echo $cadenaSql;
				break;
			
			case 'crearUsuario' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= 'nomina.usuario ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['cedulaPersona'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePersona'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['telefonoPersona'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['emailPersona'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['seleccionar'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['fecha'] . '\'';
				$cadenaSql .= ') ';
				break;
		}
		
		return $cadenaSql;
	}
}
?>
