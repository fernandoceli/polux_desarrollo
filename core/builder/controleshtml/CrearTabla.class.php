<?php

require_once ("core/builder/HtmlBase.class.php");

class CrearTabla extends HtmlBase {

    function tablaReporte($datos, $nombre = "tablaReporte") {
        $this->cadenaHTML = "";

        $this->setAtributos($datos);

        $this->campoSeguro();

        $this->cadenaHTML = array('');
        $encabezado = array();

        foreach ($datos[0] as $key => $values) {
            if (!is_numeric($key)) {
                $encabezado[$key] = '<th>' . strtoupper(str_replace("_", " ", $key)) . '</th>';
            }
        }

        $encabezadof = implode($encabezado);

        foreach ($this->cadenaHTML as $key => $values) {

            if (is_array($datos)) {
				$this->cadenaHTML [$key] = '<table id="' . $nombre . '"><thead><tr>';
                $this->cadenaHTML[$key].=$encabezadof;
                $this->cadenaHTML[$key].='</tr></thead><tbody>';
                    foreach ($datos as $nodo => $fila) {
                        $this->cadenaHTML[$key].= '<tr>';
                        foreach ($fila as $columna => $valor) {
                            if (is_numeric($columna)) {
                                $this->cadenaHTML[$key].= "<td>" . $valor . "</td> ";
                            }
                        }
                        $this->cadenaHTML[$key].= '</tr>';
                    }
                
                $this->cadenaHTML[$key].= '</tbody>';
                $this->cadenaHTML[$key].= '</table>';
            } else {
                $this->cadenaHTML[$key].= '<tr>';
                $this->cadenaHTML[$key].= '</tr>';
            }
        }

        return $this->cadenaHTML[0];
    }

    
    function tablaInfo($datos, $atributos, $tipo) {
    	$this->cadenaHTML = "\n";
    
    	$this->setAtributos ( $atributos );
    
    	$this->campoSeguro ();
    
    	if (isset ( $datos )) {
    			
    		$this->cadenaHTML .= "<table id='" . $this->atributos ['id'] . "' ";
    			
    		if (isset ( $this->atributos ['estilo'] )) {
    
    			$this->cadenaHTML .= "class='" . $this->atributos ['estilo'] [0] . "'>\n";
    			$this->cadenaHTML .= "<tr>\n";
    
    			if (isset ( $tipo ) && $tipo == "general") {
    					
    				$this->cadenaHTML .= "<td id='col' rowspan='" . $this->atributos ['tam'] . "'>\n";
    				$this->cadenaHTML .= "<div class='" . $this->atributos ['estilo'] [1] . "'>\n";
    					
    				if (isset ( $this->atributos ['id'] )) {
    
    					$this->cadenaHTML .= "<div id='" . $this->atributos ['id'] . "' class='" . $this->atributos ['estilo'] [2] . "'></div>\n";
    
    					if (isset ( $this->atributos ['version'] )) {
    						$this->cadenaHTML .= "<div class='" . $this->atributos ['estilo'] [3] . "'>Versión No." . $this->atributos ['version'] . "</div>\n";
    						$this->cadenaHTML .= "</div>";
    					}
    
    					$this->cadenaHTML .= "</td>";
    
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [4] . "'>" . $this->atributos ['titulos'] [0] . "</td>\n";
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [5] . "'>\n";
    
    					$this->cadenaHTML .= "<p>" . $datos [0] [3] . "</p>\n";
    					$this->cadenaHTML .= "</td>\n";
    
    					$this->cadenaHTML .= "</tr>\n";
    				}
    					
    				$this->cadenaHTML .= "<tr>\n";
    					
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [4] . "'>" . $this->atributos ['titulos'] [1] . "</td>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [5] . "'><p>" . $this->atributos ['modalidad'] . "</p></td>\n";
    					
    				$this->cadenaHTML .= "</tr>\n";
    					
    				$this->cadenaHTML .= "<tr>\n";
    					
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [4] . "'>" . $this->atributos ['titulos'] [2] . "</td>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [5] . "'>\n<p>";
    					
    				if (isset ( $this->atributos ['tematicas'] )) {
    					for($i = 0; $i < count ( $this->atributos ['tematicas'] ); $i ++) {
    						$this->cadenaHTML .= $this->atributos ['tematicas'] [$i];
    						$this->cadenaHTML .= "<br></br>\n";
    					}
    				}
    				$this->cadenaHTML .= "</p>\n";
    					
    				$this->cadenaHTML .= "</td>\n";
    					
    				$this->cadenaHTML .= "</tr>\n";
    					
    				$this->cadenaHTML .= "<tr>\n";
    					
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [4] . "'>" . $this->atributos ['titulos'] [3] . "</td>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [5] . "'>\n";
    					
    				$this->cadenaHTML .= "<p class='" . $this->atributos ['estilo'] [6] . "'>" . $datos [0] [7] . "</p></td>\n";
    			} elseif ($tipo == "autores") {
    					
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [1] . "'>" . $this->atributos ['titulos'] [0] . "</td>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [2] . "'>\n<p>";
    					
    				if (isset ( $this->atributos ['autores'] )) {
    					for($i = 0; $i < count ( $this->atributos ['autores'] ); $i ++) {
    						$this->cadenaHTML .= $this->atributos ['autores'] [$i];
    						$this->cadenaHTML .= "<br></br>\n";
    					}
    				}
    					
    				$this->cadenaHTML .= "</p>\n";
    					
    				$this->cadenaHTML .= "</td>\n";
    					
    				$this->cadenaHTML .= "</tr>\n";
    					
    				$this->cadenaHTML .= "<tr>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [1] . "'>" . $this->atributos ['titulos'] [1] . "</td>\n";
    					
    				if (isset ( $this->atributos ['director'] )) {
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [2] . "'><p>" . $this->atributos ['director'] . "</p></td>\n";
    				}
    			} elseif ($tipo == "documentos") {
    					
    				$this->cadenaHTML .= "<td id='col'>\n";
    					
    				$this->cadenaHTML .= "<div class='" . $this->atributos ['estilo'] [1] . "'>\n";
    				$this->cadenaHTML .= "<div id='" . $this->atributos ['id'] . "' class='" . $this->atributos ['estilo'] [2] . "'>\n";
    				$this->cadenaHTML .= "<div class='" . $this->atributos ['estilo'] [3] . "'>Anexos\n";
    				$this->cadenaHTML .= "</div>\n";
    					
    				$this->cadenaHTML .= "</td>\n";
    					
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [4] . "'>Documentacion anexa</td>\n";
    			} elseif ($tipo == "versiones") {
    					
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [1] . "' colspan='4'>";
    				$this->cadenaHTML .= "Version actual: Version No. " . count ( $datos ) . "</td>\n";
    				$this->cadenaHTML .= "</tr>\n";
    					
    				$this->cadenaHTML .= "<tr>\n";
    					
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [2] . "' colspan='2'>Version</td>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [2] . "'>Nombre del documento</td>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [2] . "'>Fecha de subida</td>\n";
    					
    				$this->cadenaHTML .= "</tr>\n";
    					
    				for($i = 0; $i < count ( $datos ); $i ++) {
    
    					$this->cadenaHTML .= "<tr>\n";
    
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [3] . "'>\n";
    					$this->cadenaHTML .= "<div class='" . $this->atributos ['estilo'] [4] . "'>\n";
    					$this->cadenaHTML .= "<div id='" . $this->atributos ['estilo'] [5] . "' class='" . $this->atributos ['estilo'] [6] . "'></div>\n";
    					$this->cadenaHTML .= "<div class='" . $this->atributos ['estilo'] [7] . "'></div>\n";
    					$this->cadenaHTML .= "</div>\n";
    					$this->cadenaHTML .= "</td>\n";
    
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [3] . "'>\n";
    					if (strlen ( $datos [$i] [0] ) < 10) {
    						$this->cadenaHTML .= $datos [$i] [0];
    					} else {
    						$this->cadenaHTML .= substr ( $datos [$i] [0], 10 ) . "...";
    					}
    					$this->cadenaHTML .= "</td>\n";
    
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [3] . "'>\n";
    					$tam = strlen ( $datos [$i] [1] );
    					if ($tam < 30) {
    						$this->cadenaHTML .= "<a href='" . $datos [$i] [2] . "' download='" . $datos [$i] [1] . "'>" . $datos [$i] [1] . "</a>\n";
    					} else {
    						$nombre = substr ( $datos [$i] [1], 0, 12 ) . " .. " . substr ( $datos [$i] [1], - 5 );
    						$this->cadenaHTML .= "<a href='" . $datos [$i] [2] . "' download='" . $datos [$i] [1] . "'>" . $nombre . "</a>\n";
    					}
    					$this->cadenaHTML .= "</td>\n";
    
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [3] . "'>\n";
    					$this->cadenaHTML .= $datos [$i] [3];
    					$this->cadenaHTML .= "</td>\n";
    				}
    			} elseif ($tipo == "solicitudes") {
    					
    				$this->cadenaHTML .= "<td class=" . $this->atributos ['estilo'] [1] . " colspan='6'>\n";
    				$this->cadenaHTML .= "Solicitudes de asignacion de revision</td>\n";
    				$this->cadenaHTML .= "</tr>\n";
    					
    				$this->cadenaHTML .= "<tr>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [2] . "' colspan='2'>Fecha solicitud</td>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [2] . "'>Docente asignado</td>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [2] . "'>Estado</td>\n";
    				$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [2] . "' colspan='2'>Dias restantes</td>\n";
    				$this->cadenaHTML .= "</tr>\n";
    					
    				for($i = 0; $i < count ( $datos ); $i ++) {
    					$this->cadenaHTML .= "<tr>\n";
    
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [3] . "'>\n";
    					$this->cadenaHTML .= "<div class='" . $this->atributos ['estilo'] [4] . "'>\n";
    					$this->cadenaHTML .= "<div id='" . $this->atributos ['estilo'] [5] . "' ";
    					$this->cadenaHTML .= "class='" . $this->atributos ['estilo'] [6] . "'></div>\n";
    					$this->cadenaHTML .= "</div>\n";
    					$this->cadenaHTML .= "</td>\n";
    
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [3] . "'>\n";
    					$this->cadenaHTML .= $datos [$i] [0];
    					$this->cadenaHTML .= "\n</td>\n";
    
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [3] . "'>\n";
    					$this->cadenaHTML .= $datos [$i] [2];
    					$this->cadenaHTML .= "\n</td>\n";
    
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [3] . "'>\n";
    					$this->cadenaHTML .= "ACEPTADO\n";
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [3] . "'>\n";
    					$this->cadenaHTML .= "N/A\n";
    					$this->cadenaHTML .= "<td class='" . $this->atributos ['estilo'] [3] . "'>\n";
    					$this->cadenaHTML .= "<div class='" . $this->atributos ['estilo'] [7] . "'></div>\n";
    					$this->cadenaHTML .= "</td>\n";
    
    					if ($i < count ( $datos )) {
    						$this->cadenaHTML .= "</tr>\n";
    					}
    				}
    			}
    
    			$this->cadenaHTML .= "</tr>\n";
    		}
    		$this->cadenaHTML .= "</table>\n";
    	}
    
    	$this->cadenaHTML .= "<br>\n";
    
    	return $this->cadenaHTML;
    }
    function tablaMensaje($atributos, $tipo = "normal") {
    	$this->cadenaHTML = "\n";
    
    	$this->setAtributos ( $atributos );
    
    	$this->campoSeguro ();
    
    	if (isset ( $tipo ) && ($tipo = "normal")) {
    		$this->cadenaHTML .= "<table class='" . $this->atributos ['estilo'] [0] . "'>\n";
    		$this->cadenaHTML .= "<tbody>\n";
    		$this->cadenaHTML .= "<tr>\n";
    		$this->cadenaHTML .= "<td class=''>\n";
    		$this->cadenaHTML .= "<div class='" . $this->atributos ['estilo'] [1] . "'></div>\n";
    		$this->cadenaHTML .= "</td>\n";
    		$this->cadenaHTML .= "<td>\n";
    		$this->cadenaHTML .= "<div class='" . $this->atributos ['estilo'] [2] . "'>\n";
    		$this->cadenaHTML .= "<div>\n";
    		$this->cadenaHTML .= $this->atributos ['mensaje'] . "\n";
    		$this->cadenaHTML .= "</div>\n";
    		$this->cadenaHTML .= "</div>\n";
    		$this->cadenaHTML .= "</td>\n";
    		$this->cadenaHTML .= "</tr>\n";
    		$this->cadenaHTML .= "</tbody>\n";
    		$this->cadenaHTML .= "</table>\n";
    	} else {
    		$this->cadenaHTML .= "<table class='" . $this->atributos ['estilo'] [0] . "'>\n";
    		$this->cadenaHTML .= "<tr>\n";
    		$this->cadenaHTML .= "<td>Responsable: <strong>Revisores</strong></td>";
    			
    		if ($this->atributos ['estado'] == "EN REVISION" || $this->atributos ['estado'] == "ASINGADO REVISORES") {
    			$this->cadenaHTML .= '<td class="izq">Dias restantes ' . 20 - $this->atributos ['dias'] . '/20</td>';
    		} else {
    			$this->cadenaHTML .= '<td class="izq">Estado: <b>' . $this->atributos ['estado'] . '</b></td>';
    		}
    			
    		$this->cadenaHTML .= "</tr>\n";
    		$this->cadenaHTML .= "</table>\n";
    			
    	}
    
    	return $this->cadenaHTML;
    }
  
}
