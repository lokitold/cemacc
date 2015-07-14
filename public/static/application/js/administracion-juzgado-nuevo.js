$(document).ready(function() {


    $('body').on('change', '#distrito', function() {
        var id = $(this).val();
        $('#organo').html('');
        $('#especialidad').html('');
        $('#sede').html('');
        $('#organo').parent().parent().addClass('hide');
        $('#especialidad').parent().parent().addClass('hide');
        $('#sede').parent().parent().addClass('hide');
        $.ajax({
            async: false,
            url: "/default/utilitarios/ajax-get-organo",
            data: {
                id: id
            },
            success: function(data) {
                if(data.length > 0){
                var option = '<option value>--Seleccionar--</option>';
                $.each(data, function(key, val) {
                    option += '<option value=' + val['subcategoria_id'] + '>' + val['subcategoria_nombre'] + '</option>';
                });
                $("#organo").html(option);
                $("#organo").attr('required','required');
                $("#organo").parent().parent().removeClass('hide');
            }
            }
        });
    });

    $('body').on('change', '#organo', function() {
        var id = $(this).val();
        $('#especialidad').html('');
        $('#sede').html('');
        $('#especialidad').parent().parent().addClass('hide');
        $('#sede').parent().parent().addClass('hide');
        $.ajax({
            async: false,
            url: "/default/utilitarios/ajax-get-especialidad",
            data: {
                id: id
            },
            success: function(data) {
                if(data.length > 0){
                var option = '<option value>--Seleccionar--</option>';
                $.each(data, function(key, val) {
                    option += '<option value=' + val['especialidad_id'] + '>' + val['especialidad_nombre'] + '</option>';
                });
                $("#especialidad").html(option);
                $("#especialidad").attr('required','required');
                $("#especialidad").parent().parent().removeClass('hide');
            }
            }
        });
    });

    $('body').on('change', '#especialidad', function() {
        var id = $(this).val();
        $('#sede').html('');
        $('#sede').parent().parent().addClass('hide');
        $.ajax({
            async: false,
            url: "/default/utilitarios/ajax-get-sede",
            data: {
                id: id
            },
            success: function(data) {
                if(data.length > 0){
                var option = '<option value>--Seleccionar--</option>';
                $.each(data, function(key, val) {
                    option += '<option value=' + val['sede_id'] + '>' + val['sede_nombre'] + '</option>';
                });
                $("#sede").html(option);
                $("#sede").attr('required','required');
                $("#sede").parent().parent().removeClass('hide');
            }
            }
        });
    });
});

