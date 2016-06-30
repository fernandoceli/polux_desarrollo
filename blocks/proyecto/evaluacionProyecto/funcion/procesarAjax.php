<?php

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

if ($_REQUEST ['funcion'] == 'consultarDocenteAjax') {
	$cadenaSql = $this->sql->getCadenaSql ( 'buscarDocenteAjax', $_REQUEST['docente'] );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	$resultado = json_encode ( $resultado);
	echo $resultado;
}

?>