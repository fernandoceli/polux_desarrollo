$("#crearSecretaria").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$("#tablaReporte").dataTable({
	"class": "dataTable display",
	"sPaginationType": "full_numbers"
	
});

$('#<?php echo $this->campoSeguro('seleccionar')?>').width(525);
$('#<?php echo $this->campoSeguro('seleccionar')?>').select2();
