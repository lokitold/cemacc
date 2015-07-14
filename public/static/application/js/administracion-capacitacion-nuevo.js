$(document).ready(function() {

    $('#fecha').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });

    $('.summernote').summernote({
        height: 300
    });

    $(".btnRegistrar").click(function(e) {
        e.preventDefault();
        var presentacion = $("#presentacion").parent().find(".note-editable").html();
        var beneficios = $("#beneficios").parent().find(".note-editable").html();
        var contenido = $("#contenido").parent().find(".note-editable").html();
        var info = $("#info").parent().find(".note-editable").html();

        $("#txtPresentacion").val(presentacion);
        $("#txtBeneficios").val(beneficios);
        $("#txtContenido").val(contenido);
        $("#txtInfo").val(info);

        $("#frmCapacitacion").submit();
    })

});

//////////// ///////////////



