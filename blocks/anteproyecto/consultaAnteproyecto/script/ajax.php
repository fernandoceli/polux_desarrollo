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

?>

<script type='text/javascript'>

var iCnt = 0;
var iCnt2 = 0;
// Obtener elemento div 
var container1 = document.getElementById('contenedor1');
var dato = '';

//Arreglo para guardar los c�digos
var revisores = [];
var text="";
var text2="";

var ruta = "blocks/anteproyecto/consultaAnteproyecto";

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
			$(container1).append('<input type=text class="input ui-widget ui-widget-content ui-corner-all" style="display: inline-block; text-align: right; border-style: hidden; width:350px;" disabled id=tb' + iCnt + ' ' +
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
			
			$('#marcoDatos2').after(container1);
		}
	}
	
});

</script>