
/**
 * ==================================
 * = COMBOBOX =======================
 * ==================================
 */


function toogleCombo(id_combo){
	
	var combo = osm_getObjeto(id_combo);
	
	if($(combo).is(':hidden')){
		
		$(combo).fadeIn('slow');
	
	}else{
		$(combo).fadeOut('slow');
	}	
}


function setValorCombo(id_combo_valor, valor, id_combo_titulo, titulo){
	
	osm_setValor(id_combo_titulo, titulo);
	osm_setValor(id_combo_valor, valor);
	
	
}

function limpiarCombo(id_combo){
	setValorCombo(id_combo, "", id_combo+"_titulo", "--Seleccione--");
	
}

function ocultarCombosDiferentesAlActual(id_combo){
	$(".bg-combo-options").each(function(i){
		if(this.id != id_combo){		
			$(this).fadeOut('slow');
		}
	});
}

function ocultarCombo(id_combo){
	var combo = osm_getObjeto(id_combo);
	$(combo).fadeOut('slow');
}


 

/**
 * ==================================
 * = COMBO A LISTADO ================
 * ==================================
 */
/**
 LISTADO 
 El listado contiene objetos con class item 
 La plantilla debe tener la clase  plantilla_listado
 Cada item debe tener dos elementos con el atributo propiedad=(id y texto) 
 Ejemplo:
 	<div class="listado" id="listado_profesores">
		<div class="plantilla_listado" style="display:none">
			<span propiedad="texto"></span>
			<input type="hidden" propiedad="id"/>
		</div>
	</div>
*/
/**
 * Pasar el item de un combo seleccionado a un listado
 * @param id_combo - id del combo
 * @param id_listado - id del listado
 * @author oskar
 */
function agregarItemComboAListado(id_combo, id_listado, id_plantilla_item, id_totalizador_items){
	
	var combo = osm_getObjeto(id_combo);
	var listado = osm_getObjeto(id_listado);
	var plantilla_item = osm_getObjeto(id_plantilla_item);
	
	var val_item = osm_getValor(id_combo);
	var descri_item = osm_getValor(id_combo + "_titulo");
	var num_items = osm_getValor(id_totalizador_items);
	
	var num_item = parseInt(num_items)+ 1;

	if(!osm_esVacio(val_item)){
		osm_construirHTML(id_listado, id_plantilla_item, [val_item, descri_item, num_item]);
		osm_setValor(id_totalizador_items, num_item);
	}
	
	//Finalmente se inicializa el combo
	limpiarCombo(id_combo);
	
		
}

function eliminarItemDeListado(id_item){
	var item = osm_getObjeto(id_item);
	$(item).remove();
	
}


/**
 * ==================================
 * = POPUP ==========================
 * ==================================
 */

function tooglePopup(id_popup){
	var popup= osm_getObjeto(id_popup);
	
	if($(popup).is(':hidden')){
		
		$(popup).fadeIn('fast');
	
	}else{
		$(popup).fadeOut('fast');
	}	
	
}


/**
 * ==================================
 * = FILECHOOSER ====================
 * ==================================
 */

function mostrarArchivoFilechooser(id_filechooser, id_filechoser_archivo){
	var archivo = osm_getValor(id_filechooser);
	
	$("#"+id_filechoser_archivo).text("Archivo: "+archivo);
	
	if(osm_esVacio(archivo)){
		$("#div_filechooser_"+id_filechooser).hide();
	}else{
		$("#div_filechooser_"+id_filechooser).show();
	}
		
}

/** 
 * ==================================
 * = UTILS ==========================
 * ==================================
 */

/**
 * Elimina el primer objeto padre encontrado
 * con el selector jquery
 */
function eliminarPadre(objeto, selector){
	$(objeto).parents(selector).filter(":first").remove();
}


function animar_enviar(id, formulario){
	
		
	var object = osm_getObjeto(id);
	
	$(object).animate({
		height: "toggle", 
		opacity: "toggle",
		width: "toogle"
			
	  }, 300, function() {
		  osm_enviarFormulario(formulario);
	  });
	
	return;
}