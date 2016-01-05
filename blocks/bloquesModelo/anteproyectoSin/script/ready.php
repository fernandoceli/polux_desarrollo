$("#anteproyectoSin").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});


$('#<?php echo $this->campoSeguro('fecha'); ?>').datepicker();
$('#<?php echo $this->campoSeguro('fecha'); ?>').datepicker( "option", "dateFormat", "dd/mm/yy" );

$('#<?php echo $this->campoSeguro('revisor')?>').width(280);
$('#<?php echo $this->campoSeguro('revisor')?>').select2();