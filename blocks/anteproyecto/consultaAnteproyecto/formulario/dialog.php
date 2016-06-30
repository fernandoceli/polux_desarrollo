<div class="modal fade popup" id="myModal" role="dialog">
    <div class="modal-dialog popup_margin margen-interna corner">
    
      <!-- Modal content-->
      <div class="modal-content ">
        <div class="modal-header" style="margin:0px; border-bottom: none; ">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h2 style="margin: 5px 5px 5px 5px;">Historial de Revisiones</h2>
        </div>
        <div style="margin: 5px 5px 5px 20px;">
        
        <?php 
       	
        // buscar revisiones
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarRevisionesPrueba", $_REQUEST['anteproyecto'] );
        $revisiones = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
        //var_dump($revisiones);
        
        if($revisiones){
        
        for($i = 0; $i < count ( $revisiones ); $i ++) {
        	if($i>0){
	        	if($revisiones[$i]['eval_iteracion']!=$revisiones[$i-1]['eval_iteracion']){
	        		echo 'Iteracion: '.$revisiones[$i]['eval_iteracion']. '/3'.'<br></br>';
	        	}
        	}else{
        		echo 'Iteracion: '.$revisiones[$i]['eval_iteracion']. '/3'.'<br></br>';
        	}
        ?>
        
		<table class="table">
			<tr>
				<td class="estilo_tr" colspan="5">Documento Revisado: Versión
				No. <?php echo $revisiones[$i]['dantp_vers']?></td>
			</tr>

			<tr>
				<td class="table-tittle estilo_tr" style="padding: 4px;" colspan="2">Revisor</td>
				<td class="table-tittle estilo_tr" style="padding: 4px;">Fecha de Solicitud</td>
				<td class="table-tittle estilo_tr" style="padding: 4px;">Concepto Respuesta</td>
				<td class="table-tittle estilo_tr" style="padding: 4px;">Fecha Respuesta</td>
			</tr>
			
			<tr>
				<td class="estilo_tr" style="padding: 4px;">
					<div class="corner bg-imagen-documento">
						<div id="documento" class="icon-mini-people"></div>
					</div>
				</td>
				<td class="estilo_tr" style="padding: 4px;">
					<?php echo $revisiones[$i]['nombre'];?>
				</td>
				<td class="estilo_tr" style="padding: 4px;">
					<?php echo $revisiones[$i]['slrev_fcrea'];?>
				</td>
				<td class="estilo_tr" style="padding: 4px;">
					<?php 
					
					
					$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
						
					$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
					$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
					$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
						
					$variable = "pagina=" . "consultaEvaluacionAnteproyecto";
					$variable .= "&usuario=" . $_REQUEST ['usuario'];
					$variable .= "&anteproyecto=" . $_REQUEST ['anteproyecto'];
					$variable .= "&revision=" . $revisiones [$i] ['eval_eval'];
					$variable .= "&concepto=" . $revisiones [$i] ['eval_cpto_rta'];
					$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $directorio );
						
					unset ( $atributos );
					// var_dump($matrizRevision);
						
					
					$esteCampo = 'verEvaluacion' . $i;
					$atributos ['id'] = $esteCampo;
					$atributos ['enlace'] = $variable;
					$atributos ['tabIndex'] = 1;
					$atributos ['estilo'] = 'textoSubtitulo';
					$atributos ['enlaceTexto'] = $revisiones [0] ['eval_cpto_rta'];
					$atributos ['ancho'] = '10%';
					$atributos ['alto'] = '10%';
					$atributos ['redirLugar'] = true;
					echo $this->miFormulario->enlace ( $atributos );
					unset ( $atributos );
					
					//echo $revisiones[$i]['eval_cpto_rta'];?>
				</td>
				<td class="estilo_tr" style="padding: 4px;">
					<?php echo $revisiones[$i]['eval_fcrea'];?>
				</td>
				
			</tr>
		</table>
		<?php }
        }else{
        	echo 'No se han realizado revisiones del anteproyecto';
        }
		?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
      
    </div>
  </div>

