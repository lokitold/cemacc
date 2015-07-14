$(document).ready(function() {

$(".btnConfirmar").click(function(){
    
    var detalle = '<h5><strong>Detalle de Compra</strong></h5>';
    detalle+='Nombre del Paquete: '+$(this).attr('nombre')+'<br/>';
    detalle+='Días: '+$(this).attr('dias')+'<br/>';
    detalle+='Dimesiones de Publicidad: '+$(this).attr('dimension')+'<br/>';
    detalle+='Precio: S/. '+$(this).attr('precio')+'<br/>';
    $("#detalleCompra").html(detalle);
    $("#idPaquete").val($(this).attr('paquete'));
    $("#cantidad").val($(this).attr('dias'));
    $("#modalConfirmarCompra").modal('show');
    
});

});

//////////// ///////////////



