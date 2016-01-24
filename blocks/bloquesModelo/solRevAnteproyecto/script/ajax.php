<?php

// url base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url = $this->miConfigurador->getVariableConfiguracion ( "site" );
$url = "/index.php";

// Variables
$cadenaACodificar16 = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar16 .= "&procesarAjax=true";
$cadenaACodificar16 .= "&action=index.php";
$cadenaACodificar16 .= "&bloqueNombre=" . $estebloque ["nombre"];
$cadenaACodificar16 .= "&bloqueGrupo" . $esteBloque ["grupo"];
$cadenaACodificar16 .= $cadenaACodificar16 . "&funcion=consultarDocenteAjax";
$cadenaACodificar16 .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaCodificar16, $enlace );

// url definitiva
$urlFinal16 = $url . $cadena16;
// echo $urlFinal16; exit;

?>

<script>

function consultarDepartamentoMed(elem, request, response){
	$.ajax({
		url: "<?php echo $urlFinal16?>",
		dataType: "json",
		data: {valor:$("#<?php  echo $this->campoSeguro('personaJuridicaPais')?>").val()},
		success: function(data){
			if(data[0]!=" "){
				$("#<?php  echo $this->campoSeguro('personaJuridicoDepartamento')?>").html('');
				$("<option value=''>Seleccione ....</option>").appendTo("#<?php echo $this->campoSeguro('personaJuridicoDepartamento')?>");
				$.each(data, function(indice,valor){
					$("<option value='"+data[ indice ].id_departamento+"'>"+data[ indice ].nombre+"</option>").appendTo("#<?php  echo $this->campoSeguro('personaJuridicoDepartamento')?>");
				});
	    $("#<?php  echo $this->campoSeguro('personaJuridicoDepartamento')?>").removeAttr('disabled');
	    $("#<?php  echo $this->campoSeguro('personaJuridicoDepartamento')?>").select2();
	    $("#<?php  echo $this->campoSeguro('personaJuridicoDepartamento')?>").removeClass("validate[required]");
		
				 
	}
		
	} 
	});
</script>