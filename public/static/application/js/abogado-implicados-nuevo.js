$(document).ready(function() {

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
    $('#rol').change(function() {
        $('#nroColegiatura').val('');
        switch ($(this).val()) {
            case '3':
                $('#nroColegiatura').parent().parent().show();
                break;
            default:
                $('#nroColegiatura').parent().parent().hide();
                break;
        }

    });

    $('#btnBuscarDni').click(function() {
        buscarPorDNI($('#searchDni').val());
    });

    $('#searchDni').keyup(function(e) {
        if (e.keyCode === 13)
            buscarPorDNI($(this).val());
    });

    $.ajax({
        url: "/abogado/utilitarios/autocomplete-all-implicados",
        success: function(data) {
            $("#autoCompleteImplicado").autocomplete({
                minLength: 3,
                source: data,
                focus: function(event, ui) {
                    $("#autoCompleteImplicado").val(ui.item.label);
                    return false;
                },
                select: function(event, ui) {
                    $("#autoCompleteImplicado").val(ui.item.label);
                    fillData(ui.item);
                    return false;
                }
            });
        }
    });



});


function buscarPorDNI(dni) {
    $.ajax({
        url: "/abogado/utilitarios/ajax-busqueda-por-dni",
        data: {
            dni: dni
        },
        success: function(data) {
            if (!$.isEmptyObject(data)) {
                fillData(data);
            } else {
                cleanForm();
                alert('No hay resultados para su búsqueda');
            }
            console.log(data);
        }
    });
}

function cleanForm() {
    $('form .bloqueable').prop('disabled', false);
    $('form .bloqueable').val('');
    $('#id').val('');
}

function fillData(data) {
    $('form .bloqueable').prop('disabled', true);
    $('#tipoDocumento').val(data['implicado_tipo_documento']);
    $('#nroDocumento').val(data['implicado_numero_documento']);
    $('#nombres').val(data['implicado_nombre']);
    $('#apellidoPaterno').val(data['implicado_apellido_paterno']);
    $('#apellidoMaterno').val(data['implicado_apellido_materno']);
    $('#telefono').val(data['implicado_telefono']);
    $('#celular').val(data['implicado_celular']);
    $('#direccion').val(data['implicado_direccion']);
    $('#email').val(data['implicado_email']);
    $('#nroColegiatura').val(data['implicado_numero_colegiatura']);
    $('#id').val(data['implicado_id']);
}