<?php

namespace bloquesModelo\bloquePie\formulario;

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
<div class="footer animated fadeInDown">
	<div class="footer_messages">
		<p>
			Todos los derechos reservados<br> 2015. Universidad Distrital
			Francisco Jos&eacute; de Caldas.<br>
		</p>
	</div>
</div>
