$("#registrarAnteproyecto").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});

$("#tablaReporte").dataTable({
	"class": "dataTable display",
	"sPaginationType": "full_numbers"
	
});

$('#<?php echo $this->campoSeguro('autores')?>').width(280);
$('#<?php echo $this->campoSeguro('autores')?>').select2();

$('#<?php echo $this->campoSeguro('seleccionarDirectorInterno')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarDirectorInterno')?>').select2();

$('#<?php echo $this->campoSeguro('seleccionarProgramaCurricular')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarProgramaCurricular')?>').select2();

$('#<?php echo $this->campoSeguro('seleccionarTematica')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarTematica')?>').select2();

$('#<?php echo $this->campoSeguro('modalidadGrado')?>').width(280);
$('#<?php echo $this->campoSeguro('modalidadGrado')?>').select2();

$('#<?php echo $this->campoSeguro('estado')?>').width(280);
$('#<?php echo $this->campoSeguro('estado')?>').select2();

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

	
	
var iCnt = 0;
var iCnt2 = 0;
// Obtener elemento div 
var container1 = document.getElementById('contenedor1');
var container2 = document.getElementById('contenedor2');
var dato = '';

//Arreglo para guardar los códigos
var codigos = [];
//Arreglo para guardar las temáticas
var tematicas = [];
var text="";
var text2="";

var ruta = "blocks/bloquesModelo/registrarAnteproyecto";

function contains(a, obj) {
    for (var i = 0; i < a.length; i++) {
        if (a[i] === obj) {
            return true;
        }
    }
    return false;
}

function eliminar(num){
	var dato = $("#td" + num).val();
	var index = tematicas.indexOf(dato);
	tematicas.splice(index, 1);
	for (i = 0; i < tematicas.length; i++) { 
	    text2 += tematicas[i] + ";";
	}
	$('#<?php echo $this->campoSeguro("nombresTematicas")?>').val(text2);
	$('#<?php echo $this->campoSeguro("numTematicas")?>').val(tematicas.length);
	$("#td" + num).remove();
	$("#img" + num).remove();
	$("#br" + num).remove();
	console.log("Se elimino " + num);
}

function eliminar2(num){
	var dato = $("#tb" + num).val();
	var index = codigos.indexOf(dato);
	codigos.splice(index, 1);
	for (i = 0; i < codigos.length; i++) { 
	    text2 += codigos[i] + ";";
	}
	$('#<?php echo $this->campoSeguro("autoresArreglo")?>').val(text2);
	$('#<?php echo $this->campoSeguro("numEstudiantes")?>').val(codigos.length);
	$("#tb" + num).remove();
	$("#img2" + num).remove();
	$("#br2" + num).remove();
	console.log("Se elimino " + num);
	
}

$('#btn1').on('click', function() {

	if (codigos.length <= 2) {
		
		var dato = $('#<?php echo $this->campoSeguro('autores')?> option:selected').html();
		alert(dato);
		if (dato != 'Seleccione .....' && !contains(codigos, dato)) {
			iCnt = iCnt + 1;
			 
			// Añadir caja de texto.
			$(container1).append('<input type=text class="input ui-widget ui-widget-content ui-corner-all" style="display: inline-block; text-align: right; border-style: hidden; width:200px;" disabled id=tb' + iCnt + ' ' +
			'" />');
			 
			$('#tb'+ iCnt).val(dato);
			$(container1).append('<img id=img2' + iCnt + ' width="22px" height="22px" src="' + ruta + '/css/images/icon-mini-delete.png" alt="delete" onclick="eliminar2(' + iCnt + ')">');
			$(container1).append('<br id=br2' + iCnt + ' >');
			codigos.push(dato);
			
			for (i = 0; i < codigos.length; i++) { 
			    text += codigos[i] + ";";
			}
			//Guardar datos en el hidden
			$('#<?php echo $this->campoSeguro('autoresArreglo')?>').val(text);
			$('#<?php echo $this->campoSeguro('numEstudiantes')?>').val(codigos.length);
			text="";
			
			$('#marcoDatos').after(container1);
		}
	}
	
});

$('#btn2').on('click', function() {
	
	var dato = $('#<?php echo $this->campoSeguro("seleccionarTematica")?> option:selected').html();
	
	if (dato != 'Seleccione .....' && !contains(tematicas, dato)) {
		iCnt2 = iCnt2 + 1;
			 
		// Añadir caja de texto.
		$(container2).append('<input type=text class="input ui-widget ui-widget-content ui-corner-all" style="display: inline-block; text-align: right; border-style: hidden;" disabled id=td' + iCnt2 + ' ' +
		'" />');
			 
		$('#td'+ iCnt2).val(dato);
		
		$(container2).append('<img id=img' + iCnt2 + ' width="22px" height="22px" src="' + ruta + '/css/images/icon-mini-delete.png" alt="delete" onclick="eliminar(' + iCnt2 + ')">');
		
		$(container2).append('<br id=br' + iCnt2 + ' >');
		
		console.log(dato);
		tematicas.push(dato);
		
		for (i = 0; i < tematicas.length; i++) { 
		    text2 += tematicas[i] + ";";
		}
		
		//Guardar datos en el hidden
		$('#<?php echo $this->campoSeguro("nombresTematicas")?>').val(text2);
		$('#<?php echo $this->campoSeguro("numTematicas")?>').val(tematicas.length);
		text2="";
		$('#marcoDatos2').after(container1);
	}
});		