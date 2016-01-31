<?php

require_once ("core/builder/HtmlBase.class.php");

class ListaCuadriculada extends HtmlBase {
	
	function listaTabla($datos, $enlace) {
		$this->cadenaHTML = "";

		$this->setAtributos($datos);
		
		$this->campoSeguro();
		
		$this->cadenaHTML = array('');
		
		for($i = 0; $i < count ( $datos ); $i ++) {
			$this->cadenaHTML[0] = '<div class="bg-caja corner" id="caja<?php ' . $i . ' ?>" style="float: left">';
			$this->cadenaHTML[0] .= '<div class="caja corner">';
			$this->cadenaHTML[0] .= '<div class="caja-header">';
			$this->cadenaHTML[0] .= '<div class="caja-fecha" style="float: left">' . $datos[$i]['fecha'] . '</div>';
			$this->cadenaHTML[0] .= '<div class="clearboth">';
			$this->cadenaHTML[0] .= '<br></br>';
			$this->cadenaHTML[0] .= '</div>';
			$this->cadenaHTML[0] .= '</div>';
			$this->cadenaHTML[0] .= '<div>';
			$this->cadenaHTML[0] .= '<div class="caja-codigo" style="float: left">';
			$this->cadenaHTML[0] .= '<div class="caja-icon-documento"></div>';
			$this->cadenaHTML[0] .= '<p class="caja-numero" id="cajanum<?php echo $i ?>">No. ' . $datos[$i]['anteproyecto'] . '</p>';
			$this->cadenaHTML[0] .= '</div>';
			$this->cadenaHTML[0] .= '<div class="caja-info" style="float: left">';
			$this->cadenaHTML[0] .= '<table style="border: 0; width: 100%">';
			$this->cadenaHTML[0] .= '<tbody>';
			$this->cadenaHTML[0] .= '<tr>';
			$this->cadenaHTML[0] .= '<td><b>Titulo:</b></td>';
			$this->cadenaHTML[0] .= '<td>' . $datos[$i]['titulo'] . '</td>';
			$this->cadenaHTML[0] .= '</tr>';
			$this->cadenaHTML[0] .= '<tr>';
			$this->cadenaHTML[0] .= '<td><b>Modalidad:</b></td>';
			$this->cadenaHTML[0] .= '<td>' . $datos[$i]['modalidad'] . '</td>';
			$this->cadenaHTML[0] .= '</tr>';
			$this->cadenaHTML[0] .= '<tr>';
			$this->cadenaHTML[0] .= '<td><b>Estado:</b></td>';
			$this->cadenaHTML[0] .= '<td>' . $datos[$i]['estado'] . '</td>';
			$this->cadenaHTML[0] .= '</tr>';
			$this->cadenaHTML[0] .= '</tbody>';
			$this->cadenaHTML[0] .= '</table>';
			$this->cadenaHTML[0] .= '</div>';
			
			$variableVer = "pagina=verAnteproyecto";
			$variableVer .= "&usuario=" . $_REQUEST ['usuario'];
			$variableVer .= "&anteproyecto=" . $datos [$i] ['anteproyecto'];
			if (isset ( $docente )) {
				$variableVer .= "&docente=" . $docente;
			}
			$variableVer .= "&rol=" . $rol;
				
			$variableVer = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variableVer, $directorio );
				
			
			$this->cadenaHTML[0] .= $enlace;
			$this->cadenaHTML[0] .= '</div>';
			$this->cadenaHTML[0] .= '</div>';
			$this->cadenaHTML[0] .= '</div>';
		}
		
		return $this->cadenaHTML[0];
	}
	
}