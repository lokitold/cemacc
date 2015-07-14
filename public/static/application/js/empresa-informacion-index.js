$(document).ready(function() {
 
 
 /////////////   files  ////////////
 
 var content = $("#imagen-1").parent().html();
 //alert(file2);
 
 $("#imagen-1").parent().remove();
 
 var file2 = '<a class="file-input-wrapper btn btn-default ">' + content + '</a>';
 $("#fileLogo").append(file2);
 
 /////////////////////////////////
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
                $("#subcategoria").attr('required','required');
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
                $("#departamento").attr('required','required');
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
                $("#provincia").attr('required','required');
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
                $("#distrito").attr('required','required');
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
                $("#ubigeo").val(id);
            }
            }
        });
    });
    
});

//////////// IMAGENES ///////////////

function readURLImagen(input) {
        if (!/(\.bmp|\.gif|\.jpg|\.jpeg|\.png)$/i.test(input.value))
        {
            alert('INVALID FILE');
            $("#imagen-0").val('');
            return false;
        }
        
        if (input.files && input.files[0]) {

            var reader = new FileReader();
            reader.onload = function(e) {
                var image = new Image();
                image.src = e.target.result;

                image.onload = function() {
                    // now we have the image.
                    var imgW = image.width;
                    var imgH = image.height;
                        if (imgW != 370 || imgH > 370) {
                            alert("La imagen debe tener un ANCHO de 370px y un ALTO no mayor a 370px");
                            $("#imagen-0").val('');
                            return false;
                    }
                    $('#preImagen').attr('src', e.target.result);
                };
                //$('#preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function readURLLogo(input) {
        if (!/(\.bmp|\.gif|\.jpg|\.jpeg|\.png)$/i.test(input.value))
        {
            alert('INVALID FILE');
            $("#imagen-1").val('');
            return false;
        }
        
        if (input.files && input.files[0]) {

            var reader = new FileReader();
            reader.onload = function(e) {
                var image = new Image();
                image.src = e.target.result;

                image.onload = function() {
                    // now we have the image.
                    var imgW = image.width;
                    var imgH = image.height;
                        if (imgW != 200 || imgH != 200) {
                            alert("La imagen debe tener un ANCHO y ALTO de 200px");
                            $("#imagen-1").val('');
                            return false;
                    }
                    $('#preLogo').attr('src', e.target.result);
                };
                //$('#preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('body').on("change", "#imagen-0", function() {
        readURLImagen(this);
    });
    
    $('body').on("change", "#imagen-1", function() {
        readURLLogo(this);
    });

