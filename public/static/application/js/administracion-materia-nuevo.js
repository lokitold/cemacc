$(document).ready(function() {
    
    var tipoProcesoSelected = $('#tipoProceso option:selected').val();
    var procesoSelected = $('#proceso option:selected').val();

    if (parseInt(procesoSelected) > 0) {
        cargarProcesos(tipoProcesoSelected,procesoSelected);
    } else {
        cleanProceso();
    }
    $('#tipoProceso').change(function() {
        cargarProcesos($(this).val(), '');
    });
});

/*Limpia el combobox proceso*/
function cleanProceso() {
    $('#proceso').find('option').remove().end().append('<option value="">------Seleccionar--------</option>');
}

/*Carga por ajax los procesos segun un tipo de proceso*/
function cargarProcesos(tipo, proceso) {
    $('#proceso').prop('disabled', true);
    $.ajax({
        async: false,
        url: "/default/utilitarios/ajax-get-procesos-by-tipo",
        data: {
            tipo: tipo
        },
        success: function(data) {
            cleanProceso();
            $.each(data, function(key, val) {
                if (proceso == val['proceso_id']) {
                    $('#proceso').append(
                            '<option selected value="' +
                            val['proceso_id'] + '">' +
                            val['proceso_nombre'] + '</option>\n\
                    ');
                } else {
                    $('#proceso').append(
                            '<option value="' +
                            val['proceso_id'] + '">' +
                            val['proceso_nombre'] + '</option>\n\
                    ');
                }
            });
            $('#proceso').prop('disabled', false);
        }
    });
}