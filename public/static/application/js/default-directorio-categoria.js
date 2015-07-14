$(document).ready(function() {
    
$("#tableEmpresaCategoria").dataTable({
    "bLengthChange": false,
    "bInfo": false,
    "oLanguage": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando empresas del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "<li class='fa fa-angle-double-left'></li>",
                "sLast": "<li class='fa fa-angle-double-right'> </li>",
                "sNext": "Siguiente <li class='fa fa-angle-right'></li>",
                "sPrevious": "<li class='fa fa-angle-left'></li> Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "bJQueryUI": false,
        "bPaginate": false,
    
});

});

//////////// ///////////////



