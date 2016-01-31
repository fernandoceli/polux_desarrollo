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
				$this->cadenaHTML [$i] = "<div ";
				
				if (isset ( $this->atributos ['clase'] )) {
					$this->cadenaHTML [$i] .= "class='" . $this->atributos ['clase'] [0] . "' ";
					$this->cadenaHTML [$i] .= "id='caja" . $i . "' ";
					
					if (isset ( $this->atributos ['estilo'] )) {
						$this->cadenaHTML [$i] .= "style='" . $this->atributos ['estilo'] . "'>";
					}
				}
				
				if (isset ( $this->atributos ['clase'] )) {
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [1] . "'>";
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [2] . "'>";
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [3] . "' ";
					if (isset ( $this->atributos ['estilo'] )) {
						$this->cadenaHTML [$i] .= "style='" . $this->atributos ['estilo'] . "'>";
					}
				}
				
				$this->cadenaHTML [$i] .= $this->atributos ['matrizItems'] [$i] ['fecha'] . "</div>";
				
				if (isset ( $this->atributos ['clase'] )) {
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [4] . "'>";
					$this->cadenaHTML [$i] .= "<br></br>";
				}
				
				for($c = 0; $c < 2; $c ++) {
					$this->cadenaHTML [$i] .= "</div>";
				}
				
				$this->cadenaHTML [$i] .= "<div>";
				
				if (isset ( $this->atributos ['clase'] )) {
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [5] . "' ";
					if (isset ( $this->atributos ['estilo'] )) {
						$this->cadenaHTML [$i] .= "style='" . $this->atributos ['estilo'] . "'>";
					}
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [6] . "'></div>";
					$this->cadenaHTML [$i] .= "<p class='" . $this->atributos ['clase'] [7];
					$this->cadenaHTML [$i] .= "id='cajanum" . $i . "'>";
					if (isset ( $this->atributos ['matrizItems'] [$i] ['anteproyecto'] )) {
						$this->cadenaHTML [$i] .= "No. " . $this->atributos ['matrizItems'] [$i] ['anteproyecto'] . "</p>";
					}
					if (isset ( $this->atributos ['matrizItems'] [$i] ['proyecto'] )) {
						$this->cadenaHTML [$i] .= "No. " . $this->atributos ['matrizItems'] [$i] ['proyecto'] . "</p>";
					}
				}
				
				$this->cadenaHTML [$i] .= "</div>";
				
				if (isset ( $this->atributos ['clase'] )) {
					$this->cadenaHTML [$i] .= "<div class='" . $this->atributos ['clase'] [8] . "' ";
					if (isset ( $this->atributos ['estilo'] )) {
						$this->cadenaHTML [$i] .= "style='" . $this->atributos ['estilo'] . "'>";
					}
				}
				
				if (isset ( $this->atributos ['estilo-tabla'] )) {
					$this->cadenaHTML [$i] .= "<table style='" . $this->atributos ['estilo-tabla'] . "'>";
					$this->cadenaHTML [$i] .= "<tbody>";
					for($j = 0; $j < count ( $this->atributos ['datos'] ); $j ++) {
						$this->cadenaHTML [$i] .= "<tr>";
						$this->cadenaHTML [$i] .= "<td><b>" . $this->atributos ['datos'] [$j] . "</b></td>";
						$this->cadenaHTML [$i] .= "<td>" . $this->atributos ['matrizItems'] [$i] [$j] . "</td>";
						$this->cadenaHTML [$i] .= "</tr>";
					}
					$this->cadenaHTML [$i] .= "</tbody>";
					$this->cadenaHTML [$i] .= "</table>";
				}
				
				$this->cadenaHTML [$i] .= "<p></p>";
				$this->cadenaHTML [$i] .= "</div>";
				
				if (isset ( $this->atributos ['enlaces'] )) {
					$this->cadenaHTML [$i] .= $this->atributos ['enlaces'] [$i];
				}
				
				for($c = 0; $c < 3; $c ++) {
					$this->cadenaHTML [$i] .= "</div>";
				}
			}
		}
		
		return $this->cadenaHTML;
	}
}