$("#consultaAnteproyecto").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

//$("#<?php echo $this->campoSeguro('botonA')?>").prop("disabled", true);

$('#<?php echo $this->campoSeguro('seleccionar')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionar')?>').select2();

$('#<?php echo $this->campoSeguro('revisor')?>').width(280);
$('#<?php echo $this->campoSeguro('revisor')?>').select2();

$('#<?php echo $this->campoSeguro('observaciones')?>').width(350);
$('#<?php echo $this->campoSeguro('acta')?>').width(280);
$('#<?php echo $this->campoSeguro('fecha')?>').width(280);
	

$('#<?php echo $this->campoSeguro('fecha')?>').datepicker({

		dateFormat: 'dd-mm-yy',
		minDate: 0,
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		    
			
	   });
        
        $(function() {
		$(document).tooltip();
	});
