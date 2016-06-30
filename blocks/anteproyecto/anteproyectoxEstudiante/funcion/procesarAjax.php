<?php

// namespace anteproyecto\anteproyectoxEstudiante\funcion;
use anteproyecto\anteproyectoxEstudiante\Sql;

include_once ('redireccionar.php');

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

if ($_REQUEST ['funcion'] == 'SeleccionAnteproyecto') {
	
	$cadenaSql = $this->sql->getCadenaSql ( 'buscarAnteproyecto', $_REQUEST['valor']);
	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	$resultadoItems=$resultadoItems[0];
	
	echo json_encode($resultadoItems);
// 	redireccion::redireccionar ( 'ver', $resultadoItems );
	
}

?>