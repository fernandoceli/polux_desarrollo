$("#contenido").validationEngine({ promptPosition : "centerRight",
scroll: false, autoHidePrompt: true, autoHideDelay: 2000 });

$("#tablaReporte").dataTable({ "class": "dataTable display",
"sPaginationType": "full_numbers" });


$('#<?php echo $this->campoSeguro('tematica')?>').width(180);
$('#<?php echo $this->campoSeguro('tematica')?>').select2();
