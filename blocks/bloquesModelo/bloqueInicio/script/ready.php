
$("#bloqueInicio").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$("#tablaReporte").dataTable({
	"class": "dataTable display",
	"sPaginationType": "full_numbers"
	
});

$('#<?php echo $this->campoSeguro('fecha'); ?>').datepicker({
      dateFormat: 'yy-mm-dd'
});

$(function() {
	$(document).click(function() {
         animate(".seccionAmplia", 'bounce');
         return false;
    });
 });
 
 function animate(element_ID, animation) {
     $(element_ID).addClass(animation);
     var wait = window.setTimeout( function(){
     	$(element_ID).removeClass(animation)}, 1300
     );
 }
