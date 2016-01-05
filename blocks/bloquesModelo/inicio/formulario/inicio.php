<?php

namespace bloquesModelo\inicio\formulario;

$rutaPrincipal = $this->miConfigurador->getVariableConfiguracion ( 'host' ) . $this->miConfigurador->getVariableConfiguracion ( 'site' );
$indice = $rutaPrincipal . "/index.php?";
$directorio = $rutaPrincipal . '/' . $this->miConfigurador->getVariableConfiguracion ( 'bloques' ) . "/menu_principal/imagen/";

$urlBloque = $this->miConfigurador->getVariableConfiguracion ( 'rutaUrlBloque' );

?>
<!--Division flotante para el panel-->
<div id="divPanelCentral ">
	<div class="iconoPanelCentral animated fadeInDown"></div>
	<div class="tituloPanelCentral animated fadeInDown">
		UDLearn
		<div class="cuerpoPanelCentral animated fadeInDown">Proyectos de Grado
			y Rendimiento Acad&eacutemico</div>
	</div>


</div>
<!--Fin Division flotante para el Panel-->
