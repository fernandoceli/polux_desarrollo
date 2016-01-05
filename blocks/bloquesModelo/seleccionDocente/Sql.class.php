<?php

namespace bloquesModelo\seleccionDocente;

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
		}
		
		return $cadenaSql;
	}
}
?>
