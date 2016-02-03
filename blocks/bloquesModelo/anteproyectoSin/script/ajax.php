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

//Arreglo para guardar las temáticas
var revisores = [];
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


$('#btn1').on('click', function() {
	
	var dato = $('#<?php echo $this->campoSeguro("revisor")?> option:selected').html();
	
	if (dato != 'Seleccione .....' && !contains(revisores, dato)) {
		iCnt2 = iCnt2 + 1;
			 
		// Añadir caja de texto.
		$(container1).append('<input type=text class="tem" style="display: inline-block;" disabled id=td' + iCnt2 + ' ' +
		'" />');
			 
		$('#td'+ iCnt2).val(dato);
		
		$(container1).append('<img id=img' + iCnt2 + ' width="22px" height="22px" src="' + ruta + '/css/images/icon-mini-delete.png" alt="delete" onclick="eliminar(' + iCnt2 + ')">');
		
		$(container1).append('<br id=br' + iCnt2 + ' >');
		
		console.log(dato);
		revisores.push(dato);
		
		for (i = 0; i < revisores.length; i++) { 
		    text2 += revisores[i] + ";";
		}
		
		//Guardar datos en el hidden
		$('#<?php echo $this->campoSeguro("nombresRevisores")?>').val(text2);
		$('#<?php echo $this->campoSeguro("numRevisores")?>').val(revisores.length);
		text2="";
		$('#marcoDatos2').after(container1);
	}
});		

</script>