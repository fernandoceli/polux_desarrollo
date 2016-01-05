$("#crearEstudiante").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$("#tablaReporte").dataTable({
	"class": "dataTable display",
	"sPaginationType": "full_numbers"
	
});

$('#<?php echo $this->campoSeguro('seleccionarProgramaCurricular')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarProgramaCurricular')?>').select2();

$('#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>').select2();

$('#<?php echo $this->campoSeguro('numeroDocIdentidad')?>').width(280);
$('#<?php echo $this->campoSeguro('nombreEstudiante')?>').width(280);
$('#<?php echo $this->campoSeguro('primerApellido')?>').width(280);
$('#<?php echo $this->campoSeguro('segundoApellido')?>').width(280);
$('#<?php echo $this->campoSeguro('codigoEstudiante')?>').width(280);
$('#<?php echo $this->campoSeguro('semestre')?>').width(280);
$('#<?php echo $this->campoSeguro('emailEstudiante')?>').width(280);
$('#<?php echo $this->campoSeguro('password')?>').width(280);
$('#<?php echo $this->campoSeguro('passConfirmado')?>').width(280);