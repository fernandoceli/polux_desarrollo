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
$cadenaACodificar .= "&funcion=SeleccionAnteproyecto";
$cadenaACodificar .= "&tiempo=" . $_REQUEST ['tiempo'];

// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar, $enlace );

// URL definitiva
$urlFinal = $url . $cadena;

?>


<script type='text/javascript'>

function seleccionar(table, numero){
	$.ajax({
		url: "<?php echo $urlFinal; ?>",
		dataType: "json",
		data: {valor: numero},
		context: table,
		success: function(data){
			$('#ante').val(data[1]);
// 			this.style.background = (this.style.background=='') ? 'red' : '';
			if ($(this).hasClass('selected')) {
				// $(this).removeClass('selected');
			} else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
		}
	});	
};

$(function () {
	$("#tAnteAsignadosRevision tr").click( function () {
		var num = this.cells.item(1).textContent;
		seleccionar(this, num);
	});
});


</script>