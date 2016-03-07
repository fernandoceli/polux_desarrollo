<?php

namespace reportes\trabajosxTematica;

if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("../index.php");
    exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

/**
 * IMPORTANTE: Se recomienda que no se borren registros. Utilizar mecanismos para - independiente del motor de bases de datos,
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
                
            case 'buscarTrabajos':
            	$cadenaSql = "SELECT ";
            	$cadenaSql .= "antp_antp AS numero, ";
            	$cadenaSql .= "antp_titu AS titulo, ";
            	$cadenaSql .= "string_agg(estantp_estd || ' - ' || nombre || ' ' || apellido, ', ') AS autor, ";
            	$cadenaSql .= "'ANTEPROYECTO' AS etapa, ";
            	$cadenaSql .= "antp_eantp AS estado ";
            	$cadenaSql .= "FROM trabajosdegrado.ant_tantp ";
            	$cadenaSql .= "JOIN trabajosdegrado.ant_testantp ";
            	$cadenaSql .= "ON estantp_antp=antp_antp ";
            	$cadenaSql .= "JOIN trabajosdegrado.ge_testd ";
            	$cadenaSql .= "ON estantp_estd=estd_estd ";
            	$cadenaSql .= "JOIN polux_usuario ";
            	$cadenaSql .= "ON estd_us=id_usuario ";
            	$cadenaSql .= "JOIN trabajosdegrado.ant_tacantp ";
            	$cadenaSql .= "ON acantp_antp=antp_antp ";
            	$cadenaSql .= "WHERE antp_eantp<>'PROYECTO' AND acantp_acono='" . $variable . "' ";
            	$cadenaSql .= "GROUP BY antp_antp, acantp_acono ";
            	
            	$cadenaSql .= "UNION ";
            	
            	$cadenaSql .= "SELECT ";
            	$cadenaSql .= "proy_proy AS numero, ";
            	$cadenaSql .= "proy_titu AS titulo, ";
            	$cadenaSql .= "string_agg(estproy_proy || ' - ' || nombre || ' ' || apellido, ', ') AS autor, ";
            	$cadenaSql .= "'PROYECTO' AS etapa, ";
            	$cadenaSql .= "proy_eproy AS estado ";
            	$cadenaSql .= "FROM trabajosdegrado.pry_tproy ";
            	$cadenaSql .= "JOIN trabajosdegrado.pry_testpry ";
            	$cadenaSql .= "ON estproy_proy=proy_proy ";
            	$cadenaSql .= "JOIN trabajosdegrado.ge_testd ";
            	$cadenaSql .= "ON estproy_estd=estd_estd ";
            	$cadenaSql .= "JOIN polux_usuario ";
            	$cadenaSql .= "ON estd_us=id_usuario ";
            	$cadenaSql .= "JOIN trabajosdegrado.pry_tacproy ";
            	$cadenaSql .= "ON acproy_proy=proy_proy ";
            	$cadenaSql .= "WHERE proy_eproy<>'INFORME FINAL' AND acproy_acono='" . $variable . "' ";
            	$cadenaSql .= "GROUP BY proy_proy, acproy_acono ";
            	
            	$cadenaSql .= "UNION ";
            	
            	$cadenaSql .= "SELECT ";
            	$cadenaSql .= "info_info AS numero, ";
            	$cadenaSql .= "info_titu AS titulo, ";
            	$cadenaSql .= "string_agg(estinfo_info || ' - ' || nombre || ' ' || apellido, ', ') AS autor, ";	
            	$cadenaSql .= "'INFORME FINAL' AS etapa, ";
            	$cadenaSql .= "info_einfo AS estado ";
            	$cadenaSql .= "FROM trabajosdegrado.inf_tinfo ";
            	$cadenaSql .= "JOIN trabajosdegrado.inf_testinfo ";
            	$cadenaSql .= "ON estinfo_info=info_info ";
            	$cadenaSql .= "JOIN trabajosdegrado.ge_testd ";
            	$cadenaSql .= "ON estinfo_est=estd_estd ";
            	$cadenaSql .= "JOIN polux_usuario ";
            	$cadenaSql .= "ON estd_us=id_usuario ";
            	$cadenaSql .= "JOIN trabajosdegrado.inf_tacinfo ";
            	$cadenaSql .= "ON acinfo_info=info_info ";
            	$cadenaSql .= "WHERE acinfo_acono='" . $variable . "' ";
            	$cadenaSql .= "GROUP BY info_info, acinfo_acono ";
            	$cadenaSql .= "ORDER BY etapa, estado, numero; ";
//             	echo $cadenaSql;
            	break;
        
        }
        
        return $cadenaSql;
    
    }
}
?>
