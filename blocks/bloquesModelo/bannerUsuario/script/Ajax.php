<script type='text/javascript'>

function hora() {  
    var hora = fecha.getHours();
    var minutos = fecha.getMinutes();
    var segundos = fecha.getSeconds();

    var dia = fecha.getDate();
    var mes = (fecha.getMonth() + 1);
    var anio = fecha.getFullYear();
    
    if(hora < 10){ 
        hora = '0' + hora;
    }
    if(minutos < 10){
        minutos = '0' + minutos; 
    }
    if(segundos < 10){ 
        segundos = '0'+segundos; 
    }
    
    fecha.setSeconds(fecha.getSeconds()+1);

    if (dia < 10) {
        dia = '0' + dia;
    }

    if (mes < 10) {
        mes = '0' + mes;
    }
    
    var fech = "Fecha: " + dia + "/" + mes + "/" + anio + " " + hora +":"+minutos+":"+segundos + "";       
    
    $('#<?php echo ('bannerFecha') ?>').text( fech );
    setTimeout("hora()",1000);
}

fecha = new Date(); 
hora();

</script>

