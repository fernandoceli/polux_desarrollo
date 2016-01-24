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
$cadenaACodificar16 .= "&procesarAjax=true";
$cadenaACodificar16 .= "&action=index.php";
$cadenaACodificar16 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar16 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar16 .= $cadenaACodificar16 . "&funcion=consultarPerfil";
if (isset ( $_REQUEST ['id_usuario'] )) {
	$cadenaACodificar16 .= "&id_usuario=" . $_REQUEST ['id_usuario'];
}
$cadenaACodificar16 .= "&tiempo=" . time ();

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar16, $enlace );

// URL definitiva
$urlFinal16 = $url . $cadena16;

?>

<script type='text/javascript'>

function consultarPerfil(elem, request, response){
	  $.ajax({
	    url: "<?php echo $urlFinal16?>",
	    dataType: "json",
	    data: { valor:$("#<?php echo $this->campoSeguro('subsistema')?>").val()},
	    success: function(data){ 
	        if(data[0]!=" "){
	            $("#<?php echo $this->campoSeguro('perfil')?>").html('');
	            $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('perfil')?>");
	            $.each(data , function(indice,valor){
	            	$("<option value='"+data[ indice ].rol_id+"'>"+data[ indice ].rol_alias+"</option>").appendTo("#<?php echo $this->campoSeguro('perfil')?>");
	            });
	            $("#<?php echo $this->campoSeguro('perfil')?>").removeAttr('disabled');
	            $('#<?php echo $this->campoSeguro('perfil')?>').width(210);
	            $("#<?php echo $this->campoSeguro('perfil')?>").select2();
		        }
	    }
		                    
	   });
	};

$(function () {
    $("#<?php echo $this->campoSeguro('subsistema')?>").change(function(){
    	if($("#<?php echo $this->campoSeguro('subsistema')?>").val()!=''){
        	consultarPerfil();
		}else{
			$("#<?php echo $this->campoSeguro('perfil')?>").attr('disabled','');
			}
	      });
});

$('#<?php echo $this->campoSeguro('seleccionarProgramaCurricular')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarProgramaCurricular')?>').select2();
$('#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>').width(280);
$('#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>').select2();
$('#<?php echo $this->campoSeguro('subsistema')?>').width(210);
$("#<?php echo $this->campoSeguro('subsistema')?>").select2(); 
$('#<?php echo $this->campoSeguro('perfil')?>').width(210);
$("#<?php echo $this->campoSeguro('perfil')?>").select2(); 

$('#<?php echo $this->campoSeguro('numeroDocIdentidad')?>').width(280);
$('#<?php echo $this->campoSeguro('nombreDocente')?>').width(280);
$('#<?php echo $this->campoSeguro('apellidos')?>').width(280);
$('#<?php echo $this->campoSeguro('codigoDocente')?>').width(280);
$('#<?php echo $this->campoSeguro('semestre')?>').width(280);
$('#<?php echo $this->campoSeguro('emailDocente')?>').width(280);
$('#<?php echo $this->campoSeguro('telefono')?>').width(280);

$('#<?php echo $this->campoSeguro('tipoVinculacion')?>').width(280);
$('#<?php echo $this->campoSeguro('tipoVinculacion')?>').select2();

$('#<?php echo $this->campoSeguro('fechaFin')?>').datepicker({
		dateFormat: 'yy-mm-dd',
		minDate: 0,
		changeYear: true,
		changeMonth: true,
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		    dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		    dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
		    
			
	   });
        
        $(function() {
		$(document).tooltip();
	});

</script>