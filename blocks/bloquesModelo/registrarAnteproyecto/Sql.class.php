<?php

namespace bloquesModelo\registrarAnteproyecto;

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
			// VALUES (" . $variable ['modalidadGrado'] . ", ";
			
			case 'registrar' :
				$fechaNueva = date ( 'Y-m-d' );
				$descripcion = "descripcion";
				
				$cadenaSql = "INSERT INTO trabajosdegrado.ant_tantp";
				$cadenaSql .= "(";
				$cadenaSql .= "antp_moda,";
				$cadenaSql .= "antp_pcur,";
				$cadenaSql .= "antp_titu,";
				$cadenaSql .= "antp_fradi,";
				$cadenaSql .= "antp_descri,";
				$cadenaSql .= "antp_obser,";
				$cadenaSql .= "antp_eantp,";
				$cadenaSql .= "antp_dir_int";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "(";
				
				$cadenaSql .= $_REQUEST ['modalidadGrado'] . ", ";
				$cadenaSql .= $_REQUEST ['seleccionarProgramaCurricular'] . ", ";
				$cadenaSql .= "'" . $_REQUEST ['titulo'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['fecha'] . "', ";
				$cadenaSql .= "'" . $descripcion . "', ";
				$cadenaSql .= "'" . $_REQUEST ['observaciones'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['estado'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['seleccionarDirectorInterno'] . "' ";
				$cadenaSql .= ") ";
				$cadenaSql .= " RETURNING antp_antp;";
				// var_dump ( $cadenaSql );
				break;
			
			case 'registrarEstudiantes' :
				// obtener codigos por separado
				$cadenaSql = "";
				$codigos = $_REQUEST ['autoresArreglo'];
				$porciones = explode ( ";", $codigos );
				
				for($i = 0; $i < $_REQUEST ['numEstudiantes']; $i++) {
					$cadena = " INSERT INTO trabajosdegrado.ant_testantp ( ";
					$cadena .= "estantp_estd, estantp_antp) ";
					$cadena .= " VALUES (" . $porciones [$i] . ", ";
					// anteproyecto: buscar valor de la secuencia actual
					$cadena .= '(SELECT ';
					$cadena .= 'last_value ';
					$cadena .= 'FROM ';
					$cadena .= 'trabajosdegrado."ANT_SANTP") ); ';
					$cadenaSql = $cadenaSql . $cadena;
					var_dump ( $cadenaSql );
				}
				
				break;
			
			case "registroDocumento" :
				$hash = "funcion hash";
				$cadenaSql = " INSERT INTO trabajosdegrado.ant_tdantp ( ";
				$cadenaSql .= "dantp_vers, dantp_observ, dantp_falm, dantp_usua, dantp_antp,";
				$cadenaSql .= "dantp_url, dantp_hash, dantp_bytes, dantp_nombre, dantp_extension)";
				
				// asignar la version
				$cadenaSql .= " VALUES (1,";
				$cadenaSql .= " '" . $_REQUEST ['observaciones'] . "', ";
				$cadenaSql .= " '" . $_REQUEST ['fecha'] . "', ";
				// Usuario que ha iniciado sesión
				$cadenaSql .= " '" . $_REQUEST ['usuario'] . "', ";
				// anteproyecto: buscar valor de la secuencia actual
				$cadenaSql .= '(SELECT ';
				$cadenaSql .= 'last_value ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado."ANT_SANTP"), ';
				
				$cadenaSql .= " '" . $variable ['destino'] . "', ";
				$cadenaSql .= " '" . $hash . "', ";
				$cadenaSql .= " '" . $variable ['tamano'] . "', ";
				$cadenaSql .= " '" . $variable ['nombre'] . "', ";
				$cadenaSql .= " '" . $variable ['tipo'] . "' ";
				$cadenaSql .= ")";
				$cadenaSql .= " RETURNING dantp_dantp;";
				// var_dump ( $cadenaSql );
				break;
			
			case 'registrarTematicas' :
				$cadenaSql = "";
				
				for($i = 0; $i < $_REQUEST ['numTematicas']; $i ++) {
					
					$cadena = " INSERT INTO trabajosdegrado.ant_tacantp ( ";
					$cadena .= "acantp_acono, acantp_antp) ";
					$cadena .= " VALUES (" . $variable [$i] . ", ";
					// anteproyecto: buscar valor de la secuencia actual
					$cadena .= '(SELECT ';
					$cadena .= 'last_value ';
					$cadena .= 'FROM ';
					$cadena .= 'trabajosdegrado."ANT_SANTP") ); ';
					$cadenaSql = $cadenaSql . $cadena;
				}
				// var_dump ( $cadenaSql );
				break;
			
			case 'registrarHistorial' :
				
				$cadenaSql = " INSERT INTO trabajosdegrado.ant_thantp ( ";
				$cadenaSql .= "hantp_antp, hantp_eantp, hantp_fasig, ";
				$cadenaSql .= "hantp_obser, hantp_usua) ";
				$cadenaSql .= " VALUES (";
				// anteproyecto: buscar valor de la secuencia actual
				$cadenaSql .= '(SELECT ';
				$cadenaSql .= 'last_value ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado."ANT_SANTP"), ';
				
				$cadenaSql .= "'" . $_REQUEST ['estado'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['fecha'] . "', ";
				$cadenaSql .= "'" . $_REQUEST ['observaciones'] . "', ";
				// Usuario que ha iniciado sesión
				$cadenaSql .= " '" . $_REQUEST ['usuario'] . "' ";
				$cadenaSql .= ") ";
				//var_dump ( $cadenaSql );
				break;
			
			case 'buscarTematicas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acono_acono as CODIGO, ';
				$cadenaSql .= 'acono_nom as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tacono';
				break;
			
			case 'buscarDocentes' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "d.prof_prof, ";
				$cadenaSql .= "(u.nombre || ' ' ||u.apellido) AS  Nombre, ";
				$cadenaSql .= "d.prof_us ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "public.polux_usuario u, ";
				$cadenaSql .= "trabajosdegrado.ge_tprof d ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "d.prof_tpvinc='Planta' ";
				$cadenaSql .= "and (d.prof_us=u.id_usuario";
				$cadenaSql .= ")";
				// echo $cadenaSql;
				break;
			
			case 'buscarEstudiantes' :
				
				$cadenaSql = "SELECT ";
				$cadenaSql .= "estd_us, ";
				$cadenaSql .= "estd_estd ";
				$cadenaSql .= "FROM ";
				$cadenaSql .= "trabajosdegrado.ge_testd ";
				break;
			
			case 'buscarModalidades' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'moda_moda as ID, ';
				$cadenaSql .= 'moda_nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tmoda';
				break;
			
			case 'buscarEstados' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'eantp_eantp, ';
				$cadenaSql .= 'eantp_eantp, ';
				$cadenaSql .= 'eantp_descri ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_teantp';
				break;
			
			case 'buscarProgramasCurriculares' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'pcur_pcur as CODIGO, ';
				$cadenaSql .= 'pcur_nom as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tpcur';
				break;
			
			case 'buscarCodigosTematicas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'acono_acono ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ge_tacono ';
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "acono_nom='" . $variable . "' ";
				// var_dump ( $cadenaSql );
				break;
		}
		
		return $cadenaSql;
	}
}
?>
