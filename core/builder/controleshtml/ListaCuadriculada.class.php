<?php

require_once ("core/builder/HtmlBase.class.php");

class ListaCuadriculada extends HtmlBase {
	
	function listaTabla($atributos) {
		
		$this->cadenaHTML = "";
		
		$this->setAtributos ( $atributos );
		
		$this->campoSeguro ();
		
		$this->cadenaHTML = array ('');
		
		if (isset ( $this->atributos ['matrizItems'] )) {
			for($i = 0; $i < count ( $this->atributos ['matrizItems'] ); $i ++) {
				$this->cadenaHTML [$i] = "\n<div ";
				
				if (isset ( $this->atributos ['clase'] )) {
					$this->cadenaHTML [$i] .= "class='" . $this->atributos ['clase'] [0] . "' ";
					$this->cadenaHTML [$i] .= "id='caja" . $i . "' ";
					
					if (isset ( $this->atributos ['estilo'] )) {
						$this->cadenaHTML [$i] .= "style='" . $this->atributos ['estilo'] . "'>\n";
					}
				}
				
				if (isset ( $this->atributos ['clase'] )) {
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [1] . "'>\n";
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [2] . "'>\n";
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [3] . "' ";
					if (isset ( $this->atributos ['estilo'] )) {
						$this->cadenaHTML [$i] .= "style='" . $this->atributos ['estilo'] . "'>\n";
					}
				}
				
				$this->cadenaHTML [$i] .= $this->atributos ['matrizItems'] [$i] ['fecha'] . "</div>\n";
				
				if (isset ( $this->atributos ['clase'] )) {
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [4] . "'>\n";
					$this->cadenaHTML [$i] .= "<br></br>\n";
				}
				
				for($c = 0; $c < 2; $c ++) {
					$this->cadenaHTML [$i] .= "</div>\n";
				}
				
				$this->cadenaHTML [$i] .= "<div>\n";
				
				if (isset ( $this->atributos ['clase'] )) {
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [5] . "' ";
					if (isset ( $this->atributos ['estilo'] )) {
						$this->cadenaHTML [$i] .= "style='" . $this->atributos ['estilo'] . "'>\n";
					}
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [6] . "'></div>\n";
					$this->cadenaHTML [$i] .= "<p class='" . $this->atributos ['clase'] [7];
					$this->cadenaHTML [$i] .= "id='cajanum" . $i . "'>";
					if (isset ( $this->atributos ['matrizItems'] [$i] ['anteproyecto'] )) {
						$this->cadenaHTML [$i] .= "No. " . $this->atributos ['matrizItems'] [$i] ['anteproyecto'] . "</p>\n";
					}
					if (isset ( $this->atributos ['matrizItems'] [$i] ['proyecto'] )) {
						$this->cadenaHTML [$i] .= "No. " . $this->atributos ['matrizItems'] [$i] ['proyecto'] . "</p>\n";
					}
				}
				
				$this->cadenaHTML [$i] .= "</div>\n";
				
				if (isset ( $this->atributos ['clase'] )) {
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [8] . "' ";
					if (isset ( $this->atributos ['estilo'] )) {
						$this->cadenaHTML [$i] .= "style='" . $this->atributos ['estilo'] . "'>\n";
					}
				}
				
				if (isset ( $this->atributos ['estilo-tabla'] )) {
					$this->cadenaHTML [$i] .= "<table style='" . $this->atributos ['estilo-tabla'] . "'>\n";
					$this->cadenaHTML [$i] .= "<tbody>\n";
					for($j = 0; $j < count ( $this->atributos ['datos'] ); $j ++) {
						$this->cadenaHTML [$i] .= "<tr>\n";
						$this->cadenaHTML [$i] .= "<td><b>" . $this->atributos ['datos'] [$j] . "</b></td>\n";
						$this->cadenaHTML [$i] .= "<td>" . $this->atributos ['matrizItems'] [$i] [$j] . "</td>\n";
						$this->cadenaHTML [$i] .= "</tr>\n";
					}
					$this->cadenaHTML [$i] .= "</tbody>\n";
					$this->cadenaHTML [$i] .= "</table>\n";
				}
				
				$this->cadenaHTML [$i] .= "<p></p>\n";
				$this->cadenaHTML [$i] .= "</div>\n";
				
				if (isset ( $this->atributos ['enlaces'] )) {
					$this->cadenaHTML [$i] .= $this->atributos ['enlaces'] [$i] . "\n";
				}
				
				for($c = 0; $c < 3; $c ++) {
					$this->cadenaHTML [$i] .= "</div>\n";
				}
			}
		}
		
		return $this->cadenaHTML;
	}
}