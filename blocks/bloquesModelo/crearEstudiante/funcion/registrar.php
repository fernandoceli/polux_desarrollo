<?php

namespace bloquesModelo\crearEstudiante\funcion;

include_once ('redireccionar.php');
class Registrar {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
	}
	function procesarFormulario() {
		if(isset ( $_REQUEST ['botonCancelar2'] ) && $_REQUEST ['botonCancelar2'] == "true"){
			redireccion::redireccionar ('devolver');
			exit();
		}else if(isset ( $_REQUEST ['botonCrear'] ) && $_REQUEST ['botonCrear'] == "true"){
			// Aqu� va la l�gica de procesamiento
			
			// Al final se ejecuta la redirecci�n la cual pasar� el control a otra p�gina
			$conexion = "estructura";
			$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
			
			$resultado=null;
			if($_REQUEST ['password']==$_REQUEST ['passConfirmado']){
				$cadenaSql = $this->miSql->getCadenaSql ( 'registrarUsuario', $_REQUEST );
				var_dump ( $cadenaSql );
				$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "insertarUs" );
				var_dump ( $resultado );
			}
			
			
			$cadenaSql2 = $this->miSql->getCadenaSql ( 'registrarPersona', $_REQUEST );
			var_dump ( $cadenaSql2 );
			$resultado2 = $esteRecursoDB->ejecutarAcceso ( $cadenaSql2, "insertarPers" );
			
			$cadenaSql3 = $this->miSql->getCadenaSql ( 'registrarEstudiante', $_REQUEST );
			var_dump ( $cadenaSql3 );
			$resultado3 = $esteRecursoDB->ejecutarAcceso ( $cadenaSql3, "insertarEst" );
			
			if ($resultado) {
				if ($resultado2) {
					redireccion::redireccionar ( 'inserto',  $_REQUEST['codigoEstudiante'] );
					exit ();
				} else {
					redireccion::redireccionar ( 'noInserto' );
					exit ();
				}
			} else {
				redireccion::redireccionar ( 'noInserto' );
				exit ();
			}
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

$miProcesador = new Registrar ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

