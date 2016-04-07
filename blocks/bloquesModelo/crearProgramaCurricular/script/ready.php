$("#crearProgramaCurricular").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$('#<?php echo $this->campoSeguro('seleccionar')?>').width(520);
$('#<?php echo $this->campoSeguro('seleccionar')?>').select2();