<?php
$indice = 0;

$estilo [$indice ++] = "validationEngine.jquery.css";
$estilo [$indice ++] = "select2.css";
$estilo[$indice++]="jquery-ui_smoot.css";
$estilo[$indice++]="jquery-ui.css";
$estilo [$indice ++] = "estiloBloque.css";

$estilo[$indice++]="ui.multiselect.css";
$estilo[$indice++]="jquery-te.css";
$estilo[$indice++]="chosen.css";
$estilo[$indice++]="jquery_switch.css";

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
