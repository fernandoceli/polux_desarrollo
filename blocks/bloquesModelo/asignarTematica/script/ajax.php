<?php
/**
 *
 * Los datos del bloque se encuentran en el arreglo $esteBloque.
 */
// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";

// Variables
$cadenaACodificar = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar .= "&procesarAjax=true";
$cadenaACodificar .= "&action=index.php";
$cadenaACodificar .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlFinal = $url . $cadena;

$cadenaACodificar2 = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar2 .= "&procesarAjax=true";
$cadenaACodificar2 .= "&action=index.php";
$cadenaACodificar2 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar2 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar2 .= "&funcion=consultarDocente";
$cadenaACodificar2 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace2 = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena2 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar2, $enlace2 );

// URL definitiva
$urlFinal2 = $url . $cadena2;

?>

<script type='text/javascript'>

var iCnt = 0;
var iCnt2 = 0;
// Obtener elemento div 
var container1 = document.getElementById('contenedor1');
var dato = '';

//Arreglo para guardar los códigos
var codigos = [];
//Arreglo para guardar las temáticas
var tematicas = [];
var text="";
var text2="";

var ruta = "blocks/bloquesModelo/asignarTematica";

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

function seleccionar(elem, request, response){
	$.ajax({
		url: "<?php echo $urlFinal; ?>",
		dataType: "json",
		data: {valor: $("#<?php echo $this->campoSeguro('docente')?>").val()},
		success: function(data){
            $("#<?php echo $this->campoSeguro('seleccionarTematica')?>").removeAttr('disabled');
            $('#<?php echo $this->campoSeguro('seleccionarTematica')?>').width(280);
            $("#<?php echo $this->campoSeguro('seleccionarTematica')?>").select2();
		}
	});	
};

function actualizar(elem, request, response){
	$.ajax({
		url: "<?php echo $urlFinal2; ?>",
		dataType: "json",
		data: {valor: $("#<?php echo $this->campoSeguro('docente')?>").val()},
		success: function(data){
			$(container1).empty();
			iCnt = 0;
			iCnt2 = 0;
			var dato =  $("#<?php echo $this->campoSeguro('docente')?>").val();
			if (data) {
				console.log(data);
				if (!contains(tematicas, dato)) {
					for (var i in data) {
					
						iCnt2++;
						$(container1).append('<input type=text class="tem" style="display: inline-block;" disabled id=td' + iCnt2 + ' />');

						var actual = data[i][1];
						
						$('#td'+ iCnt2).val(actual);
						
						$(container1).append('<img id=img' + iCnt2 + ' width="22px" height="22px" src="' + ruta + '/css/images/icon-mini-delete.png" alt="delete" onclick="eliminar(' + iCnt2 + ')">');
						
						$(container1).append('<br id=br' + iCnt2 + '>');
						
						tematicas.push(actual);
							
						for (i = 0; i < tematicas.length; i++) { 
						    text2 += tematicas[i] + ";";
						}
							
						//Guardar datos en el hidden
						$('#<?php echo $this->campoSeguro("nombresTematicas")?>').val(text2);
						$('#<?php echo $this->campoSeguro("numTematicas")?>').val(tematicas.length);
						text2="";
						$('#marcoDatos2').after(container1);
					}
				}
			} else {
				console.log('No tiene areas asignadas');
			}
		}
	});	
};

$(function () {
	$("#<?php echo $this->campoSeguro('docente')?>").change(function(){
		if($("#<?php echo $this->campoSeguro('docente')?>").val()!='') {
			seleccionar();
			actualizar();
		} else {
			$("#<?php echo $this->campoSeguro('seleccionarTematica')?>").attr('disabled','');
		}
	 });
});


</script>