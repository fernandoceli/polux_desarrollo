<?php

namespace bloquesModelo\seleccionDocente\funcion;

use bloquesModelo\seleccionDocente\funcion\redireccionar;

include_once ('redireccionar.php');
class Seleccionar {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		// $this->miFuncion = $funcion;
	}
	function procesarFormulario() {
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/bloquesModelo/";
		$rutaBloque .= $esteBloque ['nombre'];
		
		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/bloquesModelo/registrarAnteproyecto/" . $esteBloque ['nombre'];
		
		// Aqu� va la l�gica de procesamiento
		
		switch ($_REQUEST ['pagina']) {
			case 'anteDirigidos' :
				redireccion::redireccionar ( 'dirigidos' );
				exit ();
				break;
			case 'anteproyectoAsignadoRevision' :
				redireccion::redireccionar ( 'revision' );
				exit ();
			case 'solRevAnteproyecto' :
				redireccion::redireccionar ( 'sols' );
				exit ();
				break;
		}
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miProcesador = new Seleccionar ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

