/*SideBar navigation toggle*/
$(document).ready(function() {

    

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();

    $('.hasSub').click(function() {
        var elem = $(this).find('.sub');
        elem.toggle();
        console.log('entro!');
        if (elem.css('display') === 'none') {
            console.log('up!');
            $(this).find('.glyphicon-chevron-up').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        }
        else {
            console.log('down!');
            $(this).find('.glyphicon-chevron-down').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        }
    });

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active").toggleClass("active-ls");
        $("#sidebar-wrapper").toggleClass("inactive-ls");
        if ($(this).hasClass('fa-toggle-left')) {
            $(this).removeClass('fa-toggle-left').addClass('fa-toggle-right');
        } else {
            $(this).removeClass('fa-toggle-right').addClass('fa-toggle-left');
        }
    });

    $('#btnMenuToggle').click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active").toggleClass("active-ls");
        $("#sidebar-wrapper").toggleClass("inactive-ls");
    });

    $('.input-group .elementActive').each(function() {
        $(this).parent().val('active');
    })

    $('.input-group .elementActive').each(function() {
        if ($(this).is(':checked')) {
            $(this).parent().parent().children(':text').attr('value', 'Activo');
        } else {
            $(this).parent().parent().children(':text').attr('value', 'Desactivo');
        }
    });

    $('.input-group .elementActive').click(function() {
        if ($(this).is(':checked')) {
            $(this).parent().parent().children(':text').attr('value', 'Activo');
        } else {
            $(this).parent().parent().children(':text').attr('value', 'Desactivo');
        }
    });
    $('.input-group .errors').each(function() {
        $(this).parent().parent().append($(this));
    });
    $('.dataTable').dataTable({
        "oLanguage": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "<li class='fa fa-angle-double-left'> </li>",
                "sLast": "<li class='fa fa-angle-double-right'> </li>",
                "sNext": "<li class='fa fa-angle-right'> </li>",
                "sPrevious": "<li class='fa fa-angle-left'> </li>"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "bJQueryUI": false,
        "sPaginationType": "full_numbers"
    });
});