
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
		selector: "[data-toggle='tooltip']",
		position : {
			my : "left+15 center",
			at : "right center"
		},
		hide: { effect: "explode", duration: 10 },
		placement: "right"
	});
});

$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});
