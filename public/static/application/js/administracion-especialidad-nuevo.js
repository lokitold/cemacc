$(document).ready(function() {
    
    var distritoSelected = $('#distrito option:selected').val();
    var organoSelected = $('#organo option:selected').val();
    
    if (parseInt(organoSelected) > 0) {
        cargarProcesos(distritoSelected,organoSelected);
    } else {
       
        cleanOrgano();
    }
    $('#distrito').change(function() {
        cargarOrganos($(this).val(), '');
    });
});

/*Limpia el combobox proceso*/
function cleanOrgano() {
    $('#organo').find('option').remove().end().append('<option value="">------Seleccionar--------</option>');
}

/*Carga por ajax los procesos segun un tipo de proceso*/
function cargarOrganos(distrito, organo) {
    $('#organo').attr('disabled', true);
    $.ajax({
        async: false,
        url: "/default/utilitarios/ajax-get-organos-by-distrito",
        data: {
            distrito: distrito
        },
        success: function(data) {
            cleanOrgano();
            $.each(data, function(key, val) {
                if (organo == val['organo_jurisdiccional_id']) {
                    $('#organo').append(
                            '<option selected value="' +
                            val['organo_jurisdiccional_id'] + '">' +
                            val['organo_jurisdiccional_nombre'] + '</option>\n\
                    ');
                } else {
                    $('#organo').append(
                            '<option value="' +
                            val['organo_jurisdiccional_id'] + '">' +
                            val['organo_jurisdiccional_nombre'] + '</option>\n\
                    ');
                }
            });
            $('#organo').attr('disabled', false);
        }
    });
}