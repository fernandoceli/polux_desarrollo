<?php
use general\asignarTematica\Sql;

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

if (isset($_REQUEST ['funcion'])) {
	switch ($_REQUEST ['funcion']) {
		case 'consultarDocente':
			$cadenaSql = $this->sql->getCadenaSql ( 'buscarActuales', $_REQUEST['valor']);
			break;
	}
	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
	
	echo json_encode($resultadoItems);
// 	echo $resultadoItems;
}
// if ($_REQUEST ['funcion'] == 'consultarDocente') {
	
// 	$cadenaSql = $this->sql->getCadenaSql ( 'buscarActuales', $_REQUEST['valor']);
// 	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
// 	$resultadoItems=$resultadoItems[0];
	
// 	echo json_encode($resultadoItems);
// 	echo $resultado;
// } else if ($_REQUEST ['funcion'] == 'consultarTematica') {

// 	$cadenaSql = $this->sql->getCadenaSql ( 'buscarTematicas', $_REQUEST['valor']);
// 	$resultadoItems = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
// 	$resultadoItems=$resultadoItems[0];

// 	echo json_encode($resultadoItems);
// 	echo $resultado;
// }

?>