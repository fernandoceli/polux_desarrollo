// Asociar el widget de validación al formulario
$("#login").validationEngine({
	promptPosition : "centerRight",
	scroll : false
});

$('#usuario').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});

$('#clave').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});

$(function() {
	$(document).tooltip({
		position : {
			my : "left+15 center",
			at : "right center"
		}
	}, {
		hide : {
			duration : 800
		}
	});
});

$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});

$(document).ready(function(){
	//numero de solicitudes
	var dato = $('#<?php echo $this->campoSeguro('antpSolicitudes')?>').val();
	
	
});

$('#btn1').on('click', function() {
	$( "#tabs" ).tabs({ active: 1 });
	var pregunta1 = {id:1, respuesta:$('#<?php echo $this->campoSeguro('pregunta1')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion1')?>').val()};
	var pregunta2 = {id:2, respuesta:$('#<?php echo $this->campoSeguro('pregunta2')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion2')?>').val()};
	var pregunta3 = {id:3, respuesta:$('#<?php echo $this->campoSeguro('pregunta3')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion3')?>').val()};
	var pregunta4 = {id:4, respuesta:$('#<?php echo $this->campoSeguro('pregunta4')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion4')?>').val()};
	var pregunta5 = {id:5, respuesta:$('#<?php echo $this->campoSeguro('pregunta5')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion5')?>').val()};
	
	var arreglo1 = [pregunta1, pregunta2, pregunta3, pregunta4, pregunta5];
	
	var json = JSON.stringify( arreglo1 );
	console.log(json);
	$('#<?php echo $this->campoSeguro('respForm1')?>').val(json);
	
});

$('#btn2').on('click', function() {
	$( "#tabs" ).tabs({ active: 2 });
	var pregunta1 = {id:1, respuesta:$('#<?php echo $this->campoSeguro('pregunta21')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion21')?>').val()};
	var pregunta2 = {id:2, respuesta:$('#<?php echo $this->campoSeguro('pregunta22')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion22')?>').val()};
	var pregunta3 = {id:3, respuesta:$('#<?php echo $this->campoSeguro('pregunta23')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion23')?>').val()};
	var pregunta4 = {id:4, respuesta:$('#<?php echo $this->campoSeguro('pregunta24')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion24')?>').val()};

	var arreglo2 = [pregunta1, pregunta2, pregunta3, pregunta4];
	
	var json2 = JSON.stringify( arreglo2 );
	console.log(json2);
	$('#<?php echo $this->campoSeguro('respForm2')?>').val(json2);
	 console.log(arreglo2);
	
});

$('#btn3').on('click', function() {
	$( "#tabs" ).tabs({ active: 3 });
	var pregunta1 = {id:1, respuesta:$('#<?php echo $this->campoSeguro('pregunta31')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion31')?>').val()};
	var pregunta2 = {id:2, respuesta:$('#<?php echo $this->campoSeguro('pregunta32')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion32')?>').val()};
	var pregunta3 = {id:3, respuesta:"3", justificacion:$('#<?php echo $this->campoSeguro('pregunta33')?>').val()};
	var pregunta4 = {id:4, respuesta:$('#<?php echo $this->campoSeguro('pregunta34')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion34')?>').val()};
	var pregunta5 = {id:5, respuesta:$('#<?php echo $this->campoSeguro('pregunta35')?>').val(), justificacion:$('#<?php echo $this->campoSeguro('justificacion35')?>').val()};
	
	var arreglo3 = [pregunta1, pregunta2, pregunta3, pregunta4, pregunta5];
	var json3 = JSON.stringify( arreglo3 );
	console.log(json3);
	
	$('#<?php echo $this->campoSeguro('respForm3')?>').val(json3);
	 
	
});
