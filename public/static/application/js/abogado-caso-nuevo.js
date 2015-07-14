$(document).ready(function() {

    cleanProceso();
    cleanMateria();

    $('#tipoProceso').change(function() {
        cargarProcesos($(this).val(), '');
    });

    $('#proceso').change(function() {
        cargarMaterias($(this).val(), '');
    });

    $('#fechaInicio').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });

    $('#tipoDocumento').change(function() {
        $('#apellidoPaterno').val('');
        $('#apellidoMaterno').val('');
        switch ($(this).val()) {
            case '1':
            case '2':
                $('#apellidoPaterno').parent().parent().show();
                $('#apellidoMaterno').parent().parent().show().next().next().show();
                break;
            case '3':
                $('#apellidoPaterno').parent().parent().hide();
                $('#apellidoMaterno').parent().parent().hide().next().next().hide();
                break;
        }

    });

});

/*Limpia el combobox proceso*/
function cleanProceso() {
    $('#proceso').find('option').remove().end().append('<option value="">------Seleccionar--------</option>');
}

function cleanMateria() {
    $('#materia').find('option').remove().end().append('<option value="">------Seleccionar--------</option>');
}

/*Carga por ajax los procesos segun un tipo de proceso*/
function cargarProcesos(tipo, proceso) {
    $('#proceso').prop('disabled', true);
    $('#materia').prop('disabled', true);
    $.ajax({
        async: false,
        url: "/default/utilitarios/ajax-get-procesos-by-tipo",
        data: {
            tipo: tipo
        },
        success: function(data) {
            cleanProceso();
            cleanMateria();
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
            $('#materia').prop('disabled', false);
        }
    });
}

/*Carga por ajax los procesos segun un tipo de proceso*/
function cargarMaterias(proceso, materia) {
    $('#materia').prop('disabled', true);
    $.ajax({
        async: false,
        url: "/default/utilitarios/ajax-get-materias-by-proceso",
        data: {
            proceso: proceso
        },
        success: function(data) {
            cleanMateria();
            $.each(data, function(key, val) {
                if (proceso === val['materia_id']) {
                    $('#materia').append(
                            '<option selected value="' +
                            val['materia_id'] + '">' +
                            val['materia_nombre'] + '</option>\n\
                    ');
                } else {
                    $('#materia').append(
                            '<option value="' +
                            val['materia_id'] + '">' +
                            val['materia_nombre'] + '</option>\n\
                    ');
                }
            });
            $('#materia').prop('disabled', false);
        }
    });
}