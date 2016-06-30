
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
	var table = $('#tAnteproyectosDirigidos').DataTable();
	var cod=0;
	
	$('#tAnteproyectosDirigidos tbody').on('click', 'tr', function() {
		$fila = table.row(this).data()
		cod = $fila[1];
		
		$('#<?php echo $this->campoSeguro("ante")?>').val(cod);
		
		if ($(this).hasClass('selected')) {
			// $(this).removeClass('selected');
		} else {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
		}
		
	});

});



$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});


