$("#evaluacionProyecto").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});


$('#<?php echo $this->campoSeguro('seleccionarConcepto')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarConcepto')?>').select2();

