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
                if (data.length > 0) {
                    var option = '<option value>--Seleccionar--</option>';
                    $.each(data, function(key, val) {
                        option += '<option value=' + val['subcategoria_id'] + '>' + val['subcategoria_nombre'] + '</option>';
                    });
                    $("#subcategoria").html(option);
                    $("#subcategoria").attr('required', 'required');
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
        if (pais === 'Perú') {
            $("#departamento").attr('required', 'required');
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
                if (data.length > 0) {
                    var option = '<option value>--Seleccionar--</option>';
                    $.each(data, function(key, val) {
                        option += '<option value=' + val['provincia'] + '>' + val['provincia'] + '</option>';
                    });
                    $("#provincia").html(option);
                    $("#provincia").attr('required', 'required');
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
                if (data.length > 0) {
                    var option = '<option value>--Seleccionar--</option>';
                    $.each(data, function(key, val) {
                        option += '<option value=' + val['distrito'] + '>' + val['distrito'] + '</option>';
                    });
                    $("#distrito").html(option);
                    $("#distrito").attr('required', 'required');
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
                if (id != '') {
                    $("#idUbigeo").val(id);
                }
            }
        });
    });
    var c = 0;
    $("#arrCompras").click(function() {
        if (c == 0) {
            c++;
            $("#resCompras").removeClass('hide');
            $("#arrCompras span").removeClass('glyphicon-chevron-right');
            $("#arrCompras span").addClass('glyphicon-chevron-down');
            $("#nombreLogistica").attr('required', 'required');
            $("#apellidoLogistica").attr('required', 'required');
            $("#correoLogistica").attr('required', 'required');
            $("#activoL").val(1);
        } else if (c == 1) {
            $("#resCompras").addClass('hide');
            $("#arrCompras span").removeClass('glyphicon-chevron-down');
            $("#arrCompras span").addClass('glyphicon-chevron-right');
            $("#nombreLogistica").removeAttr('required');
            $("#apellidoLogistica").removeAttr('required');
            $("#correoLogistica").removeAttr('required');
            $("#activoL").val(0);
            c = 0;
        }

    });
    var r = 0;
    $("#arrRecursos").click(function() {
        if (r == 0) {
            r++;
            $("#resRecursos").removeClass('hide');
            $("#arrRecursos span").removeClass('glyphicon-chevron-right');
            $("#arrRecursos span").addClass('glyphicon-chevron-down');
            $("#nombreRecursosHumanos").attr('required', 'required');
            $("#apellidoRecursosHumanos").attr('required', 'required');
            $("#correoRecursosHumanos").attr('required', 'required');
            $("#activoR").val(1);
        } else if (r == 1) {
            $("#resRecursos").addClass('hide');
            $("#arrRecursos span").removeClass('glyphicon-chevron-down');
            $("#arrRecursos span").addClass('glyphicon-chevron-right');
            $("#nombreRecursosHumanos").removeAttr('required');
            $("#apellidoRecursosHumanos").removeAttr('required');
            $("#correoRecursosHumanos").removeAttr('required');
            $("#activoR").val(0);
            r = 0;
        }

    });

    $('body').on('submit', '#frmRegistro', function(e) {
        if ($("#admin").val() == '') {
            e.preventDefault();
            var swt_l = $("#activoL").val();
            var swt_r = $("#activoR").val();

            var options = '<br/><p><input type="radio" checked="checked" name="sladmin" value="1"/> Ventas<br/>';

            if (swt_l == 1) {
                options += '<input type="radio" name="sladmin" value="2"/> Logística<br/>';
            }

            if (swt_r == 1) {
                options += '<input type="radio" name="sladmin" value="3"/> RR.HH</p>';
            }
            $("#optionAdmin").html(options);
            $("#modalAdmin").modal('show');
        }
    })

    $('body').on('click', '#btnAceptar', function() {
        $("#admin").val($("input[name=sladmin]:checked").val());
        $("#frmRegistro").submit();
    });


    $("#razonSocial").keyup(function() {
        $.ajax({
            url: "/default/utilitarios/autocomplete-all-empresas",
            data: {
                value: $(this).val()
            },
            success: function(data) {
                $("#razonSocial").autocomplete({
                    minLength: 3,
                    source: data,
                    focus: function(event, ui) {
                        $("#razonSocial").val(ui.item.label);
                        return false;
                    },
                    select: function(event, ui) {
                        $("#razonSocial").val(ui.item.label);
                        $("#pre").val(1);
                        fillData(ui.item);
                        return false;
                    }
                });
            }
        });

    });
});

function fillData(data) {
    $("#idEmpresa").val(data['empresa_id']);
    $("#idUbicacion").val(data['ubicacion_id']);
    $('#nombreComercial').val(data['empresa_nombre_comercial']);
    $('#numeroRuc').val(data['empresa_ruc']);
    if (data['categoria_id'] != "") {
        $('#categoria').val(data['categoria_id']);
        $('#subcategoria').html('');
        $('#subcategoria').parent().parent().addClass('hide');
        $.ajax({
            async: false,
            url: "/default/utilitarios/ajax-get-subcategoria-by-categoria",
            data: {
                categoria: data['categoria_id']
            },
            success: function(data) {
                if (data.length > 0) {
                    var option = '<option value>--Seleccionar--</option>';
                    $.each(data, function(key, val) {
                        option += '<option value=' + val['subcategoria_id'] + '>' + val['subcategoria_nombre'] + '</option>';
                    });
                    $("#subcategoria").html(option);
                    $("#subcategoria").attr('required', 'required');
                    $("#subcategoria").parent().parent().removeClass('hide');
                }
            }
        });
        if (data['subcategoria_id'] != "") {
            $('#subcategoria').val(data['subcategoria_id']);
        }

    }
    if (data['pais_id'] != "") {
        $('#pais').val(data['pais_id']);
        $('#provincia').html('');
        $('#distrito').html('');
        $('#departamento').parent().parent().addClass('hide');
        $('#provincia').parent().parent().addClass('hide');
        $('#distrito').parent().parent().addClass('hide');
        if (data['pais_id'] === 173) {
            $("#departamento").attr('required', 'required');
            $("#departamento").parent().parent().removeClass('hide');

            if (data['departamento'] != "") {
                $('#departamento').val(data['departamento']);
                $('#provincia').html('');
                $('#distrito').html('');
                $('#provincia').parent().parent().addClass('hide');
                $('#distrito').parent().parent().addClass('hide');
                $.ajax({
                    async: false,
                    url: "/default/utilitarios/ajax-get-provincia-by-departamento",
                    data: {
                        departamento: data['departamento']
                    },
                    success: function(data) {
                        if (data.length > 0) {
                            var option = '<option value>--Seleccionar--</option>';
                            $.each(data, function(key, val) {
                                option += '<option value=' + val['provincia'] + '>' + val['provincia'] + '</option>';
                            });
                            $("#provincia").html(option);
                            $("#provincia").attr('required', 'required');
                            $("#provincia").parent().parent().removeClass('hide');
                        }
                    }
                });

                if (data['provincia'] != "") {
                    $('#provincia').val(data['provincia']);
                    $('#distrito').html('');
                    $('#distrito').parent().parent().addClass('hide');
                    $.ajax({
                        async: false,
                        url: "/default/utilitarios/ajax-get-distrito-by-provincia",
                        data: {
                            provincia: data['provincia']
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                var option = '<option value>--Seleccionar--</option>';
                                $.each(data, function(key, val) {
                                    option += '<option value=' + val['distrito'] + '>' + val['distrito'] + '</option>';
                                });
                                $("#distrito").html(option);
                                $("#distrito").attr('required', 'required');
                                $("#distrito").parent().parent().removeClass('hide');
                            }
                        }
                    });
                    if (data['distrito'] != "") {
                        $("#distrito").val(data['distrito']);
                        $("#idUbigeo").val(data['ubigeo_id'])
                    }
                }
            }

        }
    }

    $("#direccion").val(data['ubicacion_direccion']);

}



//////////// ///////////////



