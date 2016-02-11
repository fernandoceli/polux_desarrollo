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
$cadenaACodificar16 = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
//$cadenaACodificar16 .= "&procesarAjax=true";
$cadenaACodificar16 .= "&action=index.php";
$cadenaACodificar16 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar16 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar16 .= $cadenaACodificar16 . "";
if(isset($_REQUEST['id_usuario']))
    {$cadenaACodificar16 .= "&id_usuario=".$_REQUEST['id_usuario'];}
$cadenaACodificar16 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar16, $enlace );

// URL definitiva
$urlFinal16 = $url . $cadena16;

?>

<script type='text/javascript'>

// Obtener elemento div 
var dato = '';

//Arreglo para guardar los códigos
var codigos = [];

var jurados = [];

var iCnt = 0;
var iCnt2 = 0;

var text="";
var text2="";

var ruta = "blocks/bloquesModelo/consultaInformeFinal";

$(document).ready(function() {
	$("#<?php echo $this->campoSeguro('botonAsignar')?>").attr('disabled','true');	
	actualizar();
});

function actualizar () {

	var director = $('#<?php echo $this->campoSeguro("director")?>').val();
	var coddirector = $('#<?php echo $this->campoSeguro("coddirector")?>').val();
	
	iCnt2 = iCnt2 + 1;
	
	var container1 = document.getElementById('contenedor1');
		 
	// Añadir caja de texto.
	$(container1).append('<input type=text class="tem" style="display: inline-block;" disabled id=td' + iCnt2 + ' />');
	
	$('#td'+ iCnt2).val(director);
	
	$(container1).append('<img id=img' + iCnt2 + ' width="22px" height="22px" src="' + ruta + '/css/images/icon-mini-delete.png" alt="delete" onclick="eliminar(' + iCnt2 + ')">');
	
	$(container1).append('<br id=br' + iCnt2 + '>');
	
	console.log(director);
	jurados.push(director);
	
	for (i = 0; i < jurados.length; i++) { 
	    text2 += jurados[i] + ";";
	}
	
	// Guardar datos en el hidden
	$('#<?php echo $this->campoSeguro("nombresJurados")?>').val(text2);
	$('#<?php echo $this->campoSeguro("numJurados")?>').val(jurados.length);
	text2="";
	$('#marcoDatos2').after(container1);
}

function consultarPerfil(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlFinal16?>",
	    dataType: "json",
	    data: { },
	    success: function(data){ 
		    
	    	$("#<?php echo $this->campoSeguro('botonAsignar')?>").attr('disabled','');	
	    }
		                    
	   });
	};

$(function () {
   consultarPerfil();
		
});

function eliminar(num){
// 	alert(num);
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


</script>