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

$(document).ready(function() {
	$("#<?php echo $this->campoSeguro('botonAsignar')?>").attr('disabled','true');	
});

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

</script>