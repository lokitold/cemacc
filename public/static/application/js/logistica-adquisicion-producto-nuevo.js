$(document).ready(function() {

    $('#fechaLimite').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });

    $('body').on('submit', '#frmAgregarProducto', function(e) {
        e.preventDefault();
        var cont = $('#tblProductos >tbody >tr').length + 1;
        //alert(cont);
        var row = '<tr><td>' + cont + '</td>';
        row += '<td class="nombre">' + $("#nombre").val() + '</td>';
        row += '<td class="descripcion">' + $("#descripcion").val() + '</td>';
        row += '<td class="cantidad">' + $("#cantidad").val() + '</td>';
        row += '<td class="precio">' + $("#precio").val() + '</td></tr>';

        $("#tblProductos").append(row);
        $("#nombre").val('');
        $("#descripcion").val('');
        $("#cantidad").val('');
        $("#precio").val('');
        $("#modalAgregarProducto").modal('hide');
    });

    $('body').on('click', '#btnAgregarCategoria', function() {
        var num = $("#dvCategoria .lblCategoria").length;
        var val = $("#categoria option:selected").val();
        var txt = $("#categoria option:selected").text();
        var count = 0;
        $('.lblCategoria').each(function() {
            if ($(this).attr('id') == val) {
                count++;
            }
        });
        if (val != '' && count == 0) {
            var lbl = '<div><span id="' + val + '"class="label label-success lblCategoria">' + txt + '<span title="Quitar" style="cursor:pointer;" class="suprimir"> x</span><br/></span></div>';
//            if (num % 2 == 0 && num != 0) {
//                lbl += '<br/>';
//            }
            $("#dvCategoria").append(lbl);
        }
    });

    $('body').on('click', '.suprimir', function() {
        $(this).parent().parent().remove();
    });

    $('body').on('click', '#btnEnviar', function() {
        var filas = $('#tblProductos tbody').find('tr');
        var cat = '';
        var c = 0;
        var html = $("#tblProductos").html();
        if (filas.length == 0) {
            alert('Debe agregar al menos un producto');
            return false;
        }
        var dataProducto = new Array();

        $(filas).each(function(index) {
            var nombre = $(this).find('.nombre').html();
            var descripcion = $(this).find('.descripcion').html();
            var cantidad = $(this).find('.cantidad').html();
            var precio = $(this).find('.precio').html();
            dataProducto[index] = nombre + '|' + descripcion + '|' + cantidad + '|' + precio;
        });
        //alert(html); return false;

        $("#tblHtml").val(html);

        $(".lblCategoria").each(function() {
            c++;
            if (c <= 1) {
                cat += $(this).attr('id');
            } else {
                cat += ',' + $(this).attr('id');
            }
        });
        $("#empresaEnvio").val(cat);
        $("#dataProducto").val(dataProducto);
    })


});

//////////// ///////////////



