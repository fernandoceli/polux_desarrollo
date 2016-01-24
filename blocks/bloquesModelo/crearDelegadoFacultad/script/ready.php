$("#crearDelegadoFacultad").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$("#tablaReporte").dataTable({
	"class": "dataTable display",
	"sPaginationType": "full_numbers"
	
});


$('#<?php echo $this->campoSeguro('facultad')?>').width(280);
$('#<?php echo $this->campoSeguro('facultad')?>').select2();

$('#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>').select2();
$('#<?php echo $this->campoSeguro('subsistema')?>').width(210);
$("#<?php echo $this->campoSeguro('subsistema')?>").select2(); 
$('#<?php echo $this->campoSeguro('perfil')?>').width(210);
$("#<?php echo $this->campoSeguro('perfil')?>").select2();

$('#<?php echo $this->campoSeguro('numeroDocIdentidad')?>').width(280);
$('#<?php echo $this->campoSeguro('nombreDelegado')?>').width(280);
$('#<?php echo $this->campoSeguro('apellidos')?>').width(280);
$('#<?php echo $this->campoSeguro('codigoDelegado')?>').width(280);
$('#<?php echo $this->campoSeguro('email')?>').width(280);
$('#<?php echo $this->campoSeguro('telefono')?>').width(280);

$('#<?php echo $this->campoSeguro('fechaFin')?>').datepicker({
		dateFormat: 'yy-mm-dd',
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