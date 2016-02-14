
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

$(document).ready(function() {
	
	// Obtener elemento div
	var dato = '';
	
	// Arreglo para guardar los códigos
	// Arreglo para guardar las temáticas
	var text="";
	var text2="";

	
	var ruta = "blocks/bloquesModelo/consultaInformeFinal";
	
	$('#btn1').on('click', function() {
//		alert('entro');
		
		var dato = $('#<?php echo $this->campoSeguro("seleccionarJurado")?> option:selected').html();
//		alert(dato);
		
		var dato2 = document.getElementById('<?php echo $this->campoSeguro("seleccionarJurado")?>').value;
//		alert(dato2);
		
		if (dato != 'Seleccione .....' && !contains(codjurados, dato2)) {
//			alert("entro");
			iCnt2 = iCnt2 + 1;
			
			var container1 = document.getElementById('contenedor1');
				 
			// Añadir caja de texto.
			$(container1).append('<input type=text class="tem" style="display: inline-block;" disabled id=td' + iCnt2 + ' />');
			
			$('#td'+ iCnt2).val(dato);
			
			$(container1).append('<img id=img' + iCnt2 + ' width="22px" height="22px" src="' + ruta + '/css/images/icon-mini-delete.png" alt="delete" onclick="eliminar(' + iCnt2 + ')">');
			
			$(container1).append('<br id=br' + iCnt2 + '>');
			
			console.log(dato);
			jurados.push(dato);
			codjurados.push(dato2);
			
			for (i = 0; i < codjurados.length; i++) { 
			    text += codjurados[i] + ";";
			}
			
			for (i = 0; i < jurados.length; i++) { 
			    text2 += jurados[i] + ";";
			}
			
			// Guardar datos en el hidden
			$('#<?php echo $this->campoSeguro("codJurados")?>').val(text);
			$('#<?php echo $this->campoSeguro("nombresJurados")?>').val(text2);
			$('#<?php echo $this->campoSeguro("numJurados")?>').val(jurados.length);
			text="";
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

function eliminar(num){
//	alert(num);
	var dato = $("#td" + num).val();
	var index = jurados.indexOf(dato);
	jurados.splice(index, 1);
	for (i = 0; i < jurados.length; i++) { 
	    text2 += jurados[i] + ";";
	}
	$('#<?php echo $this->campoSeguro("nombresJurados")?>').val(text2);
	$('#<?php echo $this->campoSeguro("numJurados")?>').val(jurados.length);
	$("#td" + num).remove();
	$("#img" + num).remove();
	$("#br" + num).remove();
	console.log("Se elimino " + num);
}

$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});
