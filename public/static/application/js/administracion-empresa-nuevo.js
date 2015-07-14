$(document).ready(function() {
 
    $('body').on('change', '#categoria', function() {
        var categoria = $("#categoria option:selected").val();
        $('#subcategoria').html('');
        $('#subcategoria').parent().parent().addClass('hide');
        $.ajax({
            async: false,
            url: "/default/utilitarios/ajax-get-subcategoria-by-categoria",
            data: {
                categoria: categoria
            },
            success: function(data) {
                if(data.length > 0){
                var option = '<option value>--Seleccionar--</option>';
                $.each(data, function(key, val) {
                    option += '<option value=' + val['subcategoria_id'] + '>' + val['subcategoria_nombre'] + '</option>';
                });
                $("#subcategoria").html(option);
                $("#subcategoria").parent().parent().removeClass('hide');
            }
            }
        });
    });
    
    $('body').on('change', '#pais', function() {
        var pais = $("#pais option:selected").text();
        $('#provincia').html('');
        $('#distrito').html('');
        $('#departamento').parent().parent().addClass('hide');
        $('#provincia').parent().parent().addClass('hide');
        $('#distrito').parent().parent().addClass('hide');
        if(pais === 'Perú'){
                $("#departamento").parent().parent().removeClass('hide');
            }
        });

    $('body').on('change', '#departamento', function() {
        var departamento = $("#departamento option:selected").text();
        $('#provincia').html('');
        $('#distrito').html('');
        $('#provincia').parent().parent().addClass('hide');
        $('#distrito').parent().parent().addClass('hide');
        $.ajax({
            async: false,
            url: "/default/utilitarios/ajax-get-provincia-by-departamento",
            data: {
                departamento: departamento
            },
            success: function(data) {
                if(data.length > 0){
                var option = '<option value>--Seleccionar--</option>';
                $.each(data, function(key, val) {
                    option += '<option value=' + val['provincia'] + '>' + val['provincia'] + '</option>';
                });
                $("#provincia").html(option);
                $("#provincia").parent().parent().removeClass('hide');
            }
            }
        });
    });

    $('body').on('change', '#provincia', function() {
        var provincia = $("#provincia option:selected").text();
        $('#distrito').html('');
        $('#distrito').parent().parent().addClass('hide');
        $.ajax({
            async: false,
            url: "/default/utilitarios/ajax-get-distrito-by-provincia",
            data: {
                provincia: provincia
            },
            success: function(data) {
                if(data.length > 0){
                var option = '<option value>--Seleccionar--</option>';
                $.each(data, function(key, val) {
                    option += '<option value=' + val['distrito'] + '>' + val['distrito'] + '</option>';
                });
                $("#distrito").html(option);
                $("#distrito").parent().parent().removeClass('hide');
            }
            }
        });
    });
    
    $('body').on('change', '#distrito', function() {
        var provincia = $("#provincia option:selected").text();
        var departamento = $("#departamento option:selected").text();
        var distrito = $("#distrito option:selected").text();
        $.ajax({
            async: false,
            url: "/default/utilitarios/ajax-get-ubigeo-by-campos",
            data: {
                departamento: departamento,
                provincia: provincia,
                distrito: distrito
            },
            success: function(data) {
                var id = data['ubigeo_id'];
                if(id != ''){
                $("#idUbigeo").val(id);
            }
            }
        });
    });
    
});

//////////// ///////////////



