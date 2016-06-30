 <?php
		
 		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNoticias", $usuario );
 		$matrizNoticias = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
 		//var_dump($matrizNoticias);
		
 		$esteCampo = 'noticias';
 		$atributos ['id'] = $esteCampo;
 		$atributos ['estiloEnLinea'] = 'width: 100%; height: 90%; overflow-y: scroll;';
 		echo $this->miFormulario->division ( "inicio", $atributos );
 		unset ( $atributos );
		
 		echo "<hr>";
		
 		 var_dump($matrizNoticias);
		
 		foreach ( $matrizNoticias as $noticia ) {
 			$atributos ['id'] = '';
 			$atributos ['estilo'] = 'noticia_index';
 			echo $this->miFormulario->division ( "inicio", $atributos );
 			unset ( $atributos );
			
 			echo "<FONT COLOR=RED>" . $noticia ['nombre'] . " <br> </FONT>";
			
 			$aux = $noticia ['descripcion'];
			
 			if ($noticia ['enlace']) {
 				$aux = str_replace ( "[", "<a href='" . $noticia ['enlace'] . "'>", $aux );
 			} else {
 				if ($noticia ['prev']) {
 					$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ("buscarPrev", $noticia['prev']);
 					$matrizPrev = $esteRecurso->ejecutarAcceso ($atributos['cadena_sql'], "busqueda");
					
 					$cadena = '<a ';
					
 					if (isset($matrizPrev[0]['sale'])) {
 						$cadena .= 'onmouseout="' . $matrizPrev[0]['sale'] . '" ';					
 					}
					
 					if (isset($matrizPrev[0]['entra'])) {
 						$entra = $matrizPrev[0]['entra'];
 						$entra = str_replace('img/', $rutaUrlBloque . 'images/', $entra);
 						$cadena .= 'onmouseover="' . $entra . '" ';	
 					}
					
 					if (isset($matrizPrev[0]['mueve'])) {
 						$cadena .= 'onmousemove="' . $matrizPrev[0]['mueve'] . '" ';	
 					}
					
 					$cadena .= 'href="" >';
					
 					$aux = str_replace ( "[", $cadena, $aux );
					
 				} else {
 					$aux = str_replace ( "[", "<a href=''>", $aux );
 				}
 			}
 			$aux = str_replace ( "]", "</a>", $aux );
			
 			echo $aux;
			
 			echo "<hr>";
			
 			echo $this->miFormulario->division ( "fin" );
 		}
		
 		echo $this->miFormulario->division ( "fin" );
			 
 		?>