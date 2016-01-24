<?php

namespace bloquesModelo\crearDocente\funcion;

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
		
		// ///////////////////////////////////
		$conexion = "estructura";
		$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$num = '1234567890';
		$caracter = '=_#$-';
		$numerodeletras = 5;
		$pass = "";
		$keycar = $keyNum = "";
		for($i = 0; $i < $numerodeletras; $i ++) {
			$pass .= substr ( $caracteres, rand ( 0, strlen ( $caracteres ) ), 1 );
		}
		
		$maxCar = strlen ( $caracter ) - 1;
		$maxNum = strlen ( $num ) - 1;
		
		for($j = 0; $j < 1; $j ++) {
			$keycar .= $caracter {mt_rand ( 0, $maxCar )};
		}
		for($k = 0; $k < 2; $k ++) {
			$keyNum .= $num {mt_rand ( 0, $maxNum )};
		}
		$pass = $pass . $keycar . $keyNum;
		$password = $this->miConfigurador->fabricaConexiones->crypto->codificarClave ( $pass );
		$hoy = date ( "Y-m-d" );
		$arregloDatos = array (
				'id_usuario' => $_REQUEST ['seleccionarTipoDocumento'] . $_REQUEST ['numeroDocIdentidad'],
				'nombres' => $_REQUEST ['nombreDocente'],
				'apellidos' => $_REQUEST ['apellidos'],
				'correo' => $_REQUEST ['emailDocente'],
				'telefono' => $_REQUEST ['telefono'],
				'subsistema' => $_REQUEST ['subsistema'],
				'perfil' => $_REQUEST ['perfil'],
				'password' => $password,
				'pass' => $pass,
				'fechaIni' => $hoy,
				'fechaFin' => $_REQUEST ['fechaFin'],
				'identificacion' => $_REQUEST ['numeroDocIdentidad'],
				'tipo_identificacion' => $_REQUEST ['seleccionarTipoDocumento'],
				// datos docente
				'programaCurricular' => $_REQUEST ['seleccionarProgramaCurricular'],
				'codigo' => $_REQUEST ['codigoDocente'],
				'tipoVinculacion' => $_REQUEST ['tipoVinculacion'],
				'usuario' => $_REQUEST['usuario']
		);
		
// 		var_dump($_REQUEST);
// 		exit();
		
		$this->cadena_sql = $this->miSql->getCadenaSql ( "consultarUsuarios", $arregloDatos );
		$resultadoUsuario = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "busqueda" );
		if (! $resultadoUsuario) {
			$this->cadena_sql = $this->miSql->getCadenaSql ( "insertarUsuario", $arregloDatos );
			$resultadoEstado = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
			if ($resultadoEstado) {
				$this->cadena_sql = $this->miSql->getCadenaSql ( "insertarPerfilUsuario", $arregloDatos );
				$resultadoPerfil = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
				
				// insertar los datos del estudiante
				$this->cadena_sql = $this->miSql->getCadenaSql ( "registrarDocente", $arregloDatos );
				$resultadoPerfil = $esteRecursoDB->ejecutarAcceso ( $this->cadena_sql, "acceso" );
				
				$parametro ['id_usuario'] = $arregloDatos ['id_usuario'];
				$cadena_sql = $this->miSql->getCadenaSql ( "consultarPerfilUsuario", $parametro );
				$resultadoPerfil = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
				
				$log = array (
						'accion' => "REGISTRO",
						'id_registro' => $_REQUEST ['seleccionarTipoDocumento'] . $_REQUEST ['numeroDocIdentidad'],
						'tipo_registro' => "GESTION USUARIO",
						'nombre_registro' => "id_usuario=>" . $_REQUEST ['seleccionarTipoDocumento'] . $_REQUEST ['numeroDocIdentidad'] . "|identificacion=>" . $_REQUEST ['numeroDocIdentidad'] . "|tipo_identificacion=>" . $_REQUEST ['seleccionarTipoDocumento'] . "|nombres=>" . $_REQUEST ['nombreDocente'] . "|apellidos=>" . $_REQUEST ['apellidos'] . "|correo=>" . $_REQUEST ['emailDocente'] . "|telefono=>" . $_REQUEST ['telefono'] . "|subsistema=>" . $_REQUEST ['subsistema'] . "|perfil=>" . $_REQUEST ['perfil'] . "|fechaIni=>" . $hoy . "|fechaFin=>" . $_REQUEST ['fechaFin'],
						'descripcion' => "Registro de nuevo Usuario " . $_REQUEST ['seleccionarTipoDocumento'] . $_REQUEST ['numeroDocIdentidad'] . " con perfil " . $resultadoPerfil [0] ['rol_alias'] 
				);
				// no funiona
				// $this->miLogger->log_usuario ( $log );
				$arregloDatos ['perfilUs'] = $resultadoPerfil [0] ['rol_alias'];
				redireccion::redireccionar ( 'inserto', $arregloDatos );
				exit ();
			} else {
				redireccion::redireccionar ( 'noInserto', $arregloDatos );
				exit ();
			}
		} else {
			redireccion::redireccionar ( 'existe', $arregloDatos );
			exit ();
		}
		
		// ////////////////////////////////////
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

