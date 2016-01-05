<?php

namespace bloquesModelo\asignarTematica;

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
			
			case 'registrarPersona' :
				$cadenaSql = 'INSERT INTO trabajosdegrado.ge_tpern';
				$cadenaSql .= '(';
				$cadenaSql .= 'pern_nomb, ';
				$cadenaSql .= 'pern_papell, ';
				$cadenaSql .= 'pern_sapell, ';
				$cadenaSql .= 'pern_tdoc, ';
				$cadenaSql .= 'pern_doc ';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '(';
				$cadenaSql .= '\'' . $_REQUEST ['nombreDelegado'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['primerApellido'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['segundoApellido'] . '\', ';
				$cadenaSql .= $_REQUEST ['seleccionarTipoDocumento'] . ', ';
				$cadenaSql .= $_REQUEST ['numeroDocIdentidad'] . ' ';
				$cadenaSql .= ') ';
				break;
			
			case 'registrarUsuario' :
				$cadenaSql = 'INSERT INTO trabajosdegrado.aut_tusua';
				$cadenaSql .= '(';
				$cadenaSql .= 'usua_usua,';
				$cadenaSql .= 'usua_clave,';
				$cadenaSql .= 'usua_mail';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '(';
				$cadenaSql .= '\'' . $_REQUEST ['codigoDelegado'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['password'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['email'] . '\' ';
				$cadenaSql .= ') ';
				break;
				
			case 'registrarDelegado' :
				$cadenaSql = 'INSERT INTO trabajosdegrado.ge_tpdfa';
				$cadenaSql .= '(';
				$cadenaSql .= 'pdfa_pdfa,';
				$cadenaSql .= 'pdfa_pern,';
				$cadenaSql .= 'pdfa_facu,';
				$cadenaSql .= 'pdfa_usua';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '(';
				$cadenaSql .= $_REQUEST ['codigoDelegado'] . ', ';
				
				$cadenaSql .= '(SELECT ';
				$cadenaSql .= 'pern_pern ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tpern ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'pern_doc=\'' . $_REQUEST ['numeroDocIdentidad'] . '\'), ';
				$cadenaSql .= '' . $_REQUEST ['facultad'] . ', ';
				
				$cadenaSql .= '(SELECT ';
				$cadenaSql .= 'usua_usua ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.aut_tusua ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'usua_usua=\'' . $_REQUEST ['codigoDelegado'] . '\') ';
				
				$cadenaSql .= ')';
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
			
			case 'buscarDocentes' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "d.prof_prof, ";
				$cadenaSql .= "(p.pern_nomb || ' ' ||p.pern_papell || ' ' ||p.pern_sapell) AS  Nombre, ";
				$cadenaSql .= "d.prof_pern ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_tprof d, ";
				$cadenaSql .= "trabajosdegrado.ge_tpern p ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "d.prof_tpvinc='Planta' ";
				$cadenaSql .= "and (d.prof_pern=p.pern_pern";
				$cadenaSql .= ")";
// 				echo $cadenaSql;
				break;
			
			case 'buscarTematicas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acono_acono, ';
				$cadenaSql .= 'acono_nom ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tacono';
// 				echo $cadenaSql;
				break;
				
			case 'asignarTematica':
				$cadenaSql = 'INSERT INTO trabajosdegrado.ge_tacpro (';
				$cadenaSql .= 'acpro_acono, ';
				$cadenaSql .= 'acpro_prof) ';
				$cadenaSql .= 'VALUES (';
				$cadenaSql .= '\'' . $_REQUEST ['areas'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['docente'] . '\'';
				$cadenaSql .= ')';
// 				echo $cadenaSql;
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
		}
		
		return $cadenaSql;
	}
}
?>
