<?php

namespace bloquesModelo\bloqueBienvenida\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

$rutaPrincipal = $this->miConfigurador->getVariableConfiguracion ( 'host' ) . $this->miConfigurador->getVariableConfiguracion ( 'site' );

$indice = $rutaPrincipal . "/index.php?";

$directorio = $rutaPrincipal . '/' . $this->miConfigurador->getVariableConfiguracion ( 'bloques' ) . "/menu_principal/imagen/";

$urlBloque = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' );

$enlace = $this->miConfigurador->getVariableConfiguracion ( 'enlace' );

?>
<div style="">
	<div class="bg-home corner">
		<div class="info-home">
			El proceso de gesti&oacute;n de los recursos de informaci&oacute;n
			dentro de la <b>UD</b> debe entenderse como el manejo de la
			inteligencia corporativa a objeto de incrementar sus niveles de
			eficacia, eficiencia y efectividad en el cumplimiento de su
			misi&oacute;n social.
		</div>
		<div class="info-home resaltado">Universidad Distrital FJC.</div>
	</div>
</div>
