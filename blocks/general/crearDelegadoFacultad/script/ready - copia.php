$("#crearDelegadoFacultad").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$("#tablaReporte").dataTable({
	"class": "dataTable display",
	"sPaginationType": "full_numbers"
	
});

$('#<?php echo $this->campoSeguro('facultad')?>').width(280);
$('#<?php echo $this->campoSeguro('facultad')?>').select2();

$('#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>').select2();

