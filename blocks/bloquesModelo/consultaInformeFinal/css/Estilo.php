<?php
$indice = 0;
$estilo [$indice ++] = "estiloBloque.css";
$estilo [$indice ++] = "jquery.dataTables.css";
//$estilo [$indice ++] = "jquery.dataTables_themeroller.css";
//$estilo [$indice ++] = "jquery.datetimepicker.css";
$estilo [$indice ++] = "validationEngine.jquery.css";
$estilo [$indice ++] = "animate.css";
$estilo [$indice ++] = "select2.css";
$estilo [$indice ++] = "mobiscroll-1.5.css";
$estilo [$indice ++] = "mobiscroll-1.5.min.css";
$estilo [$indice ++] = "jquery.mobile-1.0b2.min.css";

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" );

if ($unBloque ["grupo"] == "") {
	$rutaBloque .= "/blocks/" . $unBloque ["nombre"];
} else {
	$rutaBloque .= "/blocks/" . $unBloque ["grupo"] . "/" . $unBloque ["nombre"];
}

foreach ( $estilo as $nombre ) {
	echo "<link rel='stylesheet' type='text/css' href='" . $rutaBloque . "/css/" . $nombre . "'>\n";
}
?>
