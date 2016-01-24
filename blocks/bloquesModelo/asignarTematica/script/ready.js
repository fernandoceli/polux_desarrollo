
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
	{ hide: { duration: 80 } }
	);
});

$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});

// //////////////////////////////////////////
$(document).ready(function() {
	// Obtener elemento div 
	var container1 = document.getElementById('contenedor1');
	var dato = '';
	
	//Arreglo para guardar los códigos
	//Arreglo para guardar las temáticas
	var text="";
	var text2="";
	
	$('#btn1').on('click', function() {
		
		var dato = $('#<?php echo $this->campoSeguro("seleccionarTematica")?> option:selected').html();
		
		if (dato != 'Seleccione .....' && !contains(tematicas, dato)) {
			iCnt2 = iCnt2 + 1;
				 
			// Añadir caja de texto.
			$(container1).append('<input type=text class="tem" style="display: inline-block;" disabled id=td' + iCnt2 + ' />');
			
			$('#td'+ iCnt2).val(dato);
			
			$(container1).append('<img id=img' + iCnt2 + ' width="22px" height="22px" src="' + ruta + '/css/images/icon-mini-delete.png" alt="delete" onclick="eliminar(' + iCnt2 + ')">');
			
			$(container1).append('<br>');
			
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
});

function contains(a, obj) {
    for (var i = 0; i < a.length; i++) {
        if (a[i] === obj) {
            return true;
        }
    }
    return false;
}
