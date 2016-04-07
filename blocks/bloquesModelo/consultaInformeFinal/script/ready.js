
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
	},
	{ hide: { duration: 800 } }
	);
});

$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});


var iCnt = 0;
var iCnt2 = 0;
// Obtener elemento div 
var container1 = document.getElementById('contenedor1');
var dato = '';

//Arreglo para guardar los códigos
var revisores = [];
var text="";
var text2="";

var ruta = "blocks/bloquesModelo/consultaInformeFinal";

function contains(a, obj) {
    for (var i = 0; i < a.length; i++) {
        if (a[i] === obj) {
            return true;
        }
    }
    return false;
}

function contains2(a, num) {
    for (var i = 0; i < a.length; i++) {
    	
    	if (typeof a[i] !== 'undefined'){
	        if (num == a[i]) {
	            return true;
	        }
        }
    }
    return false;
}

function eliminar(num){
	var dato = $("#tb" + num).val();
	var index = revisores.indexOf(dato);
	revisores.splice(index, 1);
	for (i = 0; i < revisores.length; i++) { 
	    text2 += revisores[i] + ";";
	}
	$('#<?php echo $this->campoSeguro("revisores")?>').val(text2);
	$('#<?php echo $this->campoSeguro("numRevisores")?>').val(revisores.length);
	$("#tb" + num).remove();
	$("#img2" + num).remove();
	$("#br2" + num).remove();
	console.log("Se elimino " + num);
	
}

$('#btn1').on('click', function() {
	
	if (revisores.length < 2) {
		var dato = $('#<?php echo $this->campoSeguro('revisor')?> option:selected').html();
		var id=$('#<?php echo $this->campoSeguro('revisor')?>').val();
		
		if (dato != 'Seleccione .....' && !contains2(revisores, id)) {
			iCnt = iCnt + 1;
			
			// Añadir caja de texto.
			$(container1).append('<input type=text class="input ui-widget ui-widget-content ui-corner-all" style="display: inline-block; text-align: right; border-style: hidden; width:200px;" disabled id=tb' + iCnt + ' ' +
			'" />');
			 
			$('#tb'+ iCnt).val(dato);
			$(container1).append('<img id=img2' + iCnt + ' width="22px" height="22px" src="' + ruta + '/css/images/icon-mini-delete.png" alt="delete" onclick="eliminar(' + iCnt + ')">');
			$(container1).append('<br id=br2' + iCnt + ' >');
			revisores.push(id);
			
			for (i = 0; i < revisores.length; i++) { 
			    text += revisores[i] + ";";
			}
			//Guardar datos en el hidden
			$('#<?php echo $this->campoSeguro('revisores')?>').val(text);
			console.log(text);
			$('#<?php echo $this->campoSeguro('numRevisores')?>').val(revisores.length);
			text="";
			
			$('#marcoDatos').after(container1);
		}
	}
	
});


