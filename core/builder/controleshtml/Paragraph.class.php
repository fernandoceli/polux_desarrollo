<?php

require_once ("core/builder/HtmlBase.class.php");

class Paragraph extends HtmlBase {
	
	function crearParrafo($atributos) {
		$this->cadenaHTML = "\n";
		
		$this->setAtributos ( $atributos );
		
		$this->campoSeguro ();
		
		$this->cadenaHTML .= "<p ";
		
		if (isset($this->atributos['id'])) {
			$this->cadenaHTML .= "id = '" . $this->atributos['id'] . "' ";
		}
		
		if (isset($this->atributos['estilo'])) {
			$this->cadenaHTML .= "class = '" . $this->atributos['estilo'] . "'";
		}
		
		if (isset($this->atributos['mensaje'])) {
			$this->cadenaHTML .= "> " . $this->atributos['mensaje'] . "</p>";
		}
		
		
		return $this->cadenaHTML;
	}
	
}