$(document).ready(function() {

    $('#fechaLimite').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });

    $('body').on('submit', '#frmAgregarServicio', function(e) {
        e.preventDefault();
        var cont = $('#tblServicios >tbody >tr').length + 1;
        //alert(cont);
        var row = '<tr><td>' + cont + '</td>';
        row += '<td class="nombre">' + $("#nombre").val() + '</td>';
        row += '<td class="descripcion">' + $("#descripcion").val() + '</td>';
        row += '<td class="precio">' + $("#precio").val() + '</td></tr>';

        $("#tblServicios").append(row);
        $("#nombre").val('');
        $("#descripcion").val('');
        $("#precio").val('');
        $("#modalAgregarServicio").modal('hide');
    });

    $('body').on('click', '#btnAgregarCategoria', function() {
        var num = $("#dvCategoria .lblCategoria").length;
        var val = $("#categoria option:selected").val();
        var txt = $("#categoria option:selected").text();
        var count = 0;
        $('.lblCategoria').each(function(){
            if($(this).attr('id') == val){
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
    
    $('body').on('click','.suprimir',function(){
       $(this).parent().parent().remove(); 
    });
    
    $('body').on('click','#btnEnviar',function(){
        var filas = $('#tblServicios tbody').find('tr');
        var cat = '';
        var c = 0;
        if(filas.length == 0){
            alert('Debe agregar al menos un servicio');
            return false;
        }
         var dataServicio = new Array();

         $(filas).each(function(index) {
            var nombre = $(this).find('.nombre').html();
            var descripcion = $(this).find('.descripcion').html();
            var precio = $(this).find('.precio').html();
            dataServicio[index] = nombre+'|'+descripcion+'|'+precio;
        });
        
        $(".lblCategoria").each(function() {
            c++;
           if(c <= 1){
             cat +=  $(this).attr('id');
           }else{
               cat += ','+$(this).attr('id');
           }
        });
        $("#empresaEnvio").val(cat);
        $("#dataServicio").val(dataServicio);
    })


});

//////////// ///////////////



