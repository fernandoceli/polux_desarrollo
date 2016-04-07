$("#consultaProyecto").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$('#<?php echo $this->campoSeguro('observaciones')?>').width(350);
$('#<?php echo $this->campoSeguro('acta')?>').width(380);
$('#<?php echo $this->campoSeguro('fechaSustentacion')?>').width(280);
$('#<?php echo $this->campoSeguro('horaSustentacion')?>').width(280);
$('#<?php echo $this->campoSeguro('lugarSustentacion')?>').width(350);
$('#<?php echo $this->campoSeguro('seleccionarConceptoSustentacion')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarConceptoSustentacion')?>').select2();

$("#<?php echo $this->campoSeguro('botonAsignar')?>").attr('disabled','true');	

$('#<?php echo $this->campoSeguro('fechaSustentacion')?>').datepicker({

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
	
$(document).ready(function () {
	$('#<?php echo $this->campoSeguro('horaSustentacion')?>').scroller({ preset: 'time' });
	wheels = [];
	wheels[0] = { 'Hours': {} };
	wheels[1] = { 'Minutes': {} };
	for (var i = 0; i < 60; i++) {
		if (i < 16) wheels[0]['Hours'][i] = (i < 10) ? ('0' + i) : i;
			wheels[1]['Minutes'][i] = (i < 30) ? ('0' + i) : i;
		}
		
		$('#disable').click(function() {
			if ($('#<?php echo $this->campoSeguro('horaSustentacion')?>').scroller('isDisabled')) {
				$('#<?php echo $this->campoSeguro('horaSustentacion')?>').scroller('enable');
				$(this).text('Disable');
			}
			else {
				$('#<?php echo $this->campoSeguro('horaSustentacion')?>').scroller('disable');
				$(this).text('Enable');
			}
			return false;
		});

        $('#get').click(function() {
            alert($('#<?php echo $this->campoSeguro('horaSustentacion')?>').scroller('getDate'));
            return false;
		});

        $('#theme, #mode').change(function() {
			var t = $('#theme').val();
            var m = $('#mode').val();
            $('#<?php echo $this->campoSeguro('horaSustentacion')?>').scroller('destroy').scroller({ preset: 'time', theme: t, mode: m });
        });
});
