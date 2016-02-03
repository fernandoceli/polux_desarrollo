<?php
require_once ("core/builder/HtmlBase.class.php");
class Ver extends HtmlBase {
	function visualizar($atributos) {
		$this->cadenaHTML = "";
		
		$this->setAtributos ( $atributos );
		
		$this->campoSeguro ();
		
		$this->cadenaHTML = array (
				'' 
		);
		
		if (isset ( $this->atributos ['matrizAnteproyectos'] )) {
			$this->cadenaHTML [0] = "\n<div ";
			
			if (isset($this->atributos ['clases'])) {
				$this->cadenaHTML [0] .= "class=' . $this->atributos ['clases'][0] . '>\n";
				if (isset($this->atributos ['titulo'])) {
					$this->cadenaHTML [0] .= "<h1>Anteproyecto No. ' . $id . '</h1>\n";
				}
			}
			
			$this->cadenaHTML [0] .= "<table id='documento' class=' . $this->atributos ['clases'][1] . '>\n";
			$this->cadenaHTML [0] .= "<tr>\n";
			$this->cadenaHTML [0] .= "<td id='col' rowspan='7'>\n";
			$this->cadenaHTML [0] .= "<div class=' . $this->atributos ['clases'][2] . '>";
			$this->cadenaHTML [0] .= "</td>\n";
			$this->cadenaHTML [0] .= "</tr>\n";
			
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
			$this->cadenaHTML [0] .= "";
		}
		
		$this->cadenaHTML [0] .= "";
		$this->cadenaHTML [0] .= "";
		$this->cadenaHTML [0] .= "";
		$this->cadenaHTML [0] .= "";
		$this->cadenaHTML [0] .= "";
		$this->cadenaHTML [0] .= "";
		$this->cadenaHTML [0] .= "";
		$this->cadenaHTML [0] .= "";
	}
}