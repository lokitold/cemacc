$(document).ready(function() {

    $('#fechaInicio').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });

    $('#fechaFin').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });

    $(".fecha").change(function() {
        var fechaIni = $("#fechaInicio").val();
        var fechaFin = $("#fechaFin").val();
        var paquete = $(".rdPosicion:checked").attr('paq');
        if (fechaIni != '' && fechaFin != '') {
            var dias = DiferenciaFechas(fechaIni,fechaFin);
            if((paquete == '1') && (dias > $("#saldo1").val())){
                alert("Usted solo tiene saldo disponible para " + $("#saldo1").val() + " días");
                $("#fechaFin").val('');
            }
            if(paquete == '2' && (dias > $("#saldo2").val())){
                alert("Usted solo tiene saldo disponible para " + $("#saldo2").val() + " días");
                $("#fechaFin").val('');
            }
            if(paquete == '3' && (dias > $("#saldo3").val())){
                alert("Usted solo tiene saldo disponible para " + $("#saldo3").val() + " días");
                $("#fechaFin").val('');
            }
            if(paquete == '4' && (dias > $("#saldo4").val())){
                alert("Usted solo tiene saldo disponible para " + $("#saldo4").val() + " días");
                $("#fechaFin").val('');
            }
        }
    })

    $('body').on('change', '#categoria', function() {
        var id = $(this).val();
        $('#subcategoria').html('');
        $('#subcategoria').parent().parent().addClass('hide');
        $.ajax({
            async: false,
            url: "/ventas/publicar/ajax-get-subcategoria-by-categoria",
            data: {
                id: id
            },
            success: function(data) {
                if (data.length > 0) {
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
    $("input[name=posicion]").change(function() {
        $("#file").removeAttr('disabled');
        $("#fechaInicio").removeAttr('disabled');
        $("#fechaFin").removeAttr('disabled');
    });
    function readURL(input) {
        var posicion = $("input[name=posicion]:checked").val();
        if (!/(\.bmp|\.gif|\.jpg|\.jpeg|\.png)$/i.test(input.value))
        {
            alert('INVALID FILE');
            $("#file").val('');
            return false;
        }
        if (posicion == undefined) {
            alert("Seleccione una posición!");
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
                    if (posicion == 1) {
                        if (imgW != 760 || imgH != 410) {
                            alert("Para la posición " + posicion + " las dimensiones de la imagen debe ser 760x410");
                            $("#file").val('');
                            return false;
                        }
                    }

                    if (posicion == 2) {
                        if (imgW != 370 || imgH != 410) {
                            alert("Para la posición " + posicion + " las dimensiones de la imagen debe ser 370x410");
                            $("#file").val('');
                            return false;
                        }
                    }

                    if (posicion == 3) {
                        if (imgW != 1150 || imgH != 250) {
                            alert("Para la posición " + posicion + " las dimensiones de la imagen debe ser 1150x250");
                            $("#file").val('');
                            return false;
                        }
                    }

                    if (posicion == 4 || posicion == 5 || posicion == 6 || posicion == 7 || posicion == 8 || posicion == 9) {
                        if (imgW != 370 || imgH != 250) {
                            alert("Para la posición " + posicion + " las dimensiones de la imagen debe ser 370x250");
                            $("#file").val('');
                            return false;
                        }
                    }
                    $('#preview').attr('src', e.target.result);
                    $('#preview').parent().removeClass('hide');
                };
                //$('#preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('body').on("change", "#file", function() {
        readURL(this);
    });
    $('body').on('change', '#chkPublicar1', function() {
        if ($(this).is(':checked')) {
            $("#imgPosicion").removeClass('hide');
        } else {
            $("#imgPosicion").addClass('hide');
        }
    });

    function DiferenciaFechas(fecha2, fecha1) {
        //Obtiene dia, mes y año  
        var fecha1 = new fecha(fecha1);
        var fecha2 = new fecha(fecha2);

        //Obtiene objetos Date  
        var miFecha1 = new Date(fecha1.anio, fecha1.mes, fecha1.dia);
        var miFecha2 = new Date(fecha2.anio, fecha2.mes, fecha2.dia);

        //Resta fechas y redondea  
        var diferencia = miFecha1.getTime() - miFecha2.getTime();
        var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24)) + 1;
        return dias
    }
    
    function fecha( cadena ) {  
  
   //Separador para la introduccion de las fechas  
   var separador = "/"  
  
   //Separa por dia, mes y año  
   if ( cadena.indexOf( separador ) != -1 ) {  
        var posi1 = 0  
        var posi2 = cadena.indexOf( separador, posi1 + 1 )  
        var posi3 = cadena.indexOf( separador, posi2 + 1 )  
        this.dia = cadena.substring( posi1, posi2 )  
        this.mes = cadena.substring( posi2 + 1, posi3 )  
        this.anio = cadena.substring( posi3 + 1, cadena.length )  
   } else {  
        this.dia = 0  
        this.mes = 0  
        this.anio = 0     
   }  
}  


});

//////////// ///////////////



