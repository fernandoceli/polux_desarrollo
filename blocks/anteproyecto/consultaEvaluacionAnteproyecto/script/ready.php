$("#consultaEvaluacionAnteproyecto").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$('#<?php echo $this->campoSeguro('pregunta1')?>').width(211);
$('#<?php echo $this->campoSeguro('pregunta2')?>').width(211);
$('#<?php echo $this->campoSeguro('pregunta3')?>').width(211);
$('#<?php echo $this->campoSeguro('pregunta4')?>').width(211);
$('#<?php echo $this->campoSeguro('pregunta5')?>').width(211);

$('#<?php echo $this->campoSeguro('pregunta21')?>').width(211);
$('#<?php echo $this->campoSeguro('pregunta22')?>').width(211);
$('#<?php echo $this->campoSeguro('pregunta23')?>').width(211);
$('#<?php echo $this->campoSeguro('pregunta24')?>').width(211);

$('#<?php echo $this->campoSeguro('pregunta31')?>').width(211);
$('#<?php echo $this->campoSeguro('pregunta32')?>').width(211);
$('#<?php echo $this->campoSeguro('pregunta34')?>').width(211);
$('#<?php echo $this->campoSeguro('pregunta35')?>').width(211);

$('#<?php echo $this->campoSeguro('seleccionarConcepto')?>').width(211);

////////////Función que organiza los tabs en la interfaz gráfica//////////////
$(function() {
	$("#tabs").tabs();
}); 
//////////////////////////////////////////////////////////////////////////////
