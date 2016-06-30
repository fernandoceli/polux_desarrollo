<?php

namespace general\bloqueBienvenida\formulario;

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
			El proceso de gestión de los recursos de información
			dentro de la <b>UD</b> debe entenderse como el manejo de la
			inteligencia corporativa a objeto de incrementar sus niveles de
			eficacia, eficiencia y efectividad en el cumplimiento de su
			misión social.
			
			<?php
			echo $this->miFormulario->division ( "fin" );
			?>
		<div class="info-home resaltado">Universidad Distrital FJC.
		<?php
		echo $this->miFormulario->division ( "fin" );
		echo $this->miFormulario->division ( "fin" );
		echo $this->miFormulario->division ( "fin" );
		?>
