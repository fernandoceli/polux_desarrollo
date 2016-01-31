<?php

require_once ("core/builder/HtmlBase.class.php");

class Informacion extends HtmlBase {
	
	function infoReporte($mensaje, $pag) {
		$this->cadenaHTML = "";

		$this->setAtributos($mensaje);
		
		$this->campoSeguro();
		
		$this->cadenaHTML = array('');
		
		$this->cadenaHTML[0] = '<div class="canvas-contenido">';
		$this->cadenaHTML[0] .= '<div class="area-msg corner margen-interna">';
		$this->cadenaHTML[0] .= '<div class="icono-msg info"></div>';
		$this->cadenaHTML[0] .= '<div class="content-msg info corner">';
		$this->cadenaHTML[0] .= '<div class="title-msg info">Informacion</div>';
		$this->cadenaHTML[0] .= '<div style="padding: 5px 0px;">';
		$this->cadenaHTML[0] .= '<div>';
		$this->cadenaHTML[0] .= '<contenido>' . $mensaje;
		$this->cadenaHTML[0] .= '<div style="text-align: right"	onclick="window.location =  \'index.php?data=' . $pag . '\';">';
		$this->cadenaHTML[0] .= '<input class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="submit" tabindex="1" value="Ir al inicio" role="button" aria-disabled="false">';
		$this->cadenaHTML[0] .= '</div>';
		$this->cadenaHTML[0] .= '</contenido>';
		$this->cadenaHTML[0] .= '</div>';
		$this->cadenaHTML[0] .= '</div>';
		$this->cadenaHTML[0] .= '</div>';
		$this->cadenaHTML[0] .= '</div>';
		$this->cadenaHTML[0] .= '</div>';
		
		return $this->cadenaHTML[0];
	}
	
}