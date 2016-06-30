<?php

// url base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url = $this->miConfigurador->getVariableConfiguracion ( "site" );
$url = "/index.php";

// Variables
$cadenaACodificar16 = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar16 .= "&procesarAjax=true";
$cadenaACodificar16 .= "&action=index.php";
$cadenaACodificar16 .= "&bloqueNombre=" . $estebloque ["nombre"];
$cadenaACodificar16 .= "&bloqueGrupo" . $esteBloque ["grupo"];
$cadenaACodificar16 .= $cadenaACodificar16 . "&funcion=consultarDocenteAjax";
$cadenaACodificar16 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaCodificar16, $enlace );

// url definitiva
$urlFinal16 = $url . $cadena16;
// echo $urlFinal16; exit;

?>
