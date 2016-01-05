<?php
?>

<script>

$(function () {
    
    $("#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>").change(function(){
    	$("#<?php echo $this->campoSeguro('numeroDocIdentidad')?>").removeAttr('readonly');
    	if($("#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>").val()==2 || $("#<?php echo $this->campoSeguro('seleccionarTipoDocumento')?>").val()==3  ){
    		$("#<?php echo $this->campoSeguro('numeroDocIdentidad')?>").removeAttr('validate[required]');
        	}
	      });
    

});

</script>