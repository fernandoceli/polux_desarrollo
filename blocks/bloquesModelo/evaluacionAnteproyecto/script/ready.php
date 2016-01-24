$("#evaluacionAnteproyecto").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$('#<?php echo $this->campoSeguro('pregunta1')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta1')?>').select2();
$('#<?php echo $this->campoSeguro('pregunta2')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta2')?>').select2();
$('#<?php echo $this->campoSeguro('pregunta3')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta3')?>').select2();
$('#<?php echo $this->campoSeguro('pregunta4')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta4')?>').select2();
$('#<?php echo $this->campoSeguro('pregunta5')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta5')?>').select2();

$('#<?php echo $this->campoSeguro('pregunta21')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta21')?>').select2();
$('#<?php echo $this->campoSeguro('pregunta22')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta22')?>').select2();
$('#<?php echo $this->campoSeguro('pregunta23')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta23')?>').select2();
$('#<?php echo $this->campoSeguro('pregunta24')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta24')?>').select2();

$('#<?php echo $this->campoSeguro('pregunta31')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta31')?>').select2();
$('#<?php echo $this->campoSeguro('pregunta32')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta32')?>').select2();
$('#<?php echo $this->campoSeguro('pregunta34')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta34')?>').select2();
$('#<?php echo $this->campoSeguro('pregunta35')?>').width(280);
$('#<?php echo $this->campoSeguro('pregunta35')?>').select2();

$('#<?php echo $this->campoSeguro('seleccionarConcepto')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarConcepto')?>').select2();

////////////Función que organiza los tabs en la interfaz gráfica//////////////
$(function() {
	$("#tabs").tabs();
}); 
//////////////////////////////////////////////////////////////////////////////
