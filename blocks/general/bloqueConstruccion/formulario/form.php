<?php

namespace general\bloqueConstruccion\formulario;

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
			P&aacute;gina en construci&oacute;n.
		</div>
		<div class="info-home resaltado">Universidad Distrital FJC.</div>
	</div>
</div>
