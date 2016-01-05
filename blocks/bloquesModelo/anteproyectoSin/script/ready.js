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

$(document).ready(function() {
	var table = $('#tablaReporte').DataTable();
	var cod=0;
	
	$('#tablaReporte tbody').on('click', 'tr', function() {
		$fila = table.row(this).data()
		cod = $fila[1];
		
		$('#<?php echo $this->campoSeguro('id')?>').val(cod);
		
		if ($(this).hasClass('selected')) {
			// $(this).removeClass('selected');
		} else {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
		}
		
	});
	
	$('#documento').on('click', 'tr', function() {
		alert("Descargando el archivo...");
		
	});

});



$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});


